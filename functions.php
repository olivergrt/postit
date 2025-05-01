<?php 

function ConnexionDB(){  
    $bdd = new PDO('mysql:host=127.0.0.1;dbname=app_post_it;charset=utf8', 'root', ''); 
    return $bdd; 
}

function verifSession() {
    if (!isset($_SESSION['idUser'])) {
        header("Location: ../connexion/connexion.php");
        exit();
    }
}


function verifAlreadyConnected() {
    if (isset($_SESSION['idUser'])) {
        header("Location: ../index.php");
        exit();
    }
}

function SelectPostitPersonnel($idUtilisateur){
    $bdd = ConnexionDB();
    $infoPostitPerso = $bdd->prepare("SELECT id_post_it,titre,date_creation,date_modification,couleur FROM post_it where id_proprietaire = ? ORDER BY date_creation desc");
    $infoPostitPerso->execute(array($idUtilisateur));
    
    return $infoPostitPerso->fetchAll(PDO::FETCH_ASSOC); // permet de mettre les données dans un tableau associatif pour chaque post it 
}


function SelectPostitPartage($idUtilisateur){
    $bdd = ConnexionDB();
    $infoPostitPartage = $bdd->prepare("SELECT post_it.id_post_it,titre,date_creation,date_modification,nom, prenom, couleur FROM post_it join post_it_partage on post_it.id_post_it = post_it_partage.id_post_it join utilisateur on post_it.id_proprietaire = utilisateur.id_utilisateur where id_user_partage = ? ORDER BY date_creation desc");
    $infoPostitPartage->execute(array($idUtilisateur));
    
    return $infoPostitPartage->fetchAll(PDO::FETCH_ASSOC); // permet de mettre les données dans un tableau associatif pour chaque post it 
}

function SelectInfoUtilisateur($idUtilisateur) {
    $bdd = ConnexionDB();
    $infoUtilisateur = $bdd->prepare("SELECT email, password, nom, prenom, pseudo, date_naiss  FROM utilisateur WHERE id_utilisateur = ?");
    $infoUtilisateur->execute(array($idUtilisateur));
    return $infoUtilisateur->fetch(PDO::FETCH_ASSOC); // Renvoie directement un tableau associatif
}


//Verification Requete SQL importante permettant de savoir si l'utilisateur à le droit de voir le postit  
// Affiche le postit si : 
// 1. L'utilisateur connecté sur la page est le pripriotaire du postit passé dans l'URL 
// 2. Si l'utilisateur connecté sur la page fait parti des utilisateur partagés 
function SelectInfoPostit($idPostit, $idUtilisateur) {
    $bdd = ConnexionDB();
    $infoPostit = $bdd->prepare("SELECT DISTINCT post_it.id_post_it, post_it.id_proprietaire,post_it.titre,post_it.contenu,post_it.date_creation,post_it.date_modification, utilisateur.nom, utilisateur.prenom, post_it.couleur FROM post_it JOIN utilisateur ON utilisateur.id_utilisateur = post_it.id_proprietaire LEFT JOIN post_it_partage ON post_it.id_post_it = post_it_partage.id_post_it WHERE post_it.id_post_it = ? AND (post_it.id_proprietaire = ? OR post_it_partage.id_user_partage = ?);
                                ");
    $infoPostit->execute(array($idPostit, $idUtilisateur, $idUtilisateur));
    return $infoPostit->fetch(PDO::FETCH_ASSOC); // Renvoie directement un tableau associatif
}

function SelectUserPostitPartage($idPostit) {
    $bdd = ConnexionDB();
    $UserPartagePostit = $bdd->prepare("SELECT id_utilisateur, prenom, nom, pseudo from post_it_partage join utilisateur on utilisateur.id_utilisateur = post_it_partage.id_user_partage where id_post_it = ?"); 
    $UserPartagePostit->execute(array($idPostit));

    // Le fetchall ici est important !! Il va permettre de recupéré toutes les lignes trouvées (fetch recupere que la premiere)
    return $UserPartagePostit->fetchAll(PDO::FETCH_ASSOC); 
}

function updatePostit($titre, $contenu, $date_modification, $idPostit, $id_proprio, $couleur){
     $bdd = ConnexionDB();
    $updatePostit = $bdd->prepare('UPDATE post_it SET titre = ?, contenu = ?, date_modification = ?, couleur = ? WHERE id_post_it = ? AND id_proprietaire = ?');
    $updatePostit->execute([$titre, $contenu, $date_modification, $couleur, $idPostit, $id_proprio]);
}

function deletePartagePostit($idPostit,$idUserPartageDelete){
    $bdd = ConnexionDB();
    $deletePartage = $bdd->prepare('DELETE FROM `post_it_partage` WHERE id_post_it = ? AND id_user_partage = ?'); 
    $deletePartage->execute([$idPostit, $idUserPartageDelete]);
}

function deletePostit($idPostit,$id_proprio){
    $bdd = ConnexionDB();
    $deletePostit = $bdd->prepare('DELETE FROM `post_it` WHERE id_post_it = ? AND id_proprietaire = ?'); 
    $deletePostit->execute([$idPostit,$id_proprio]);
}

function insertPostit($id_proprio,$titre,$contenu, $date_creation,$date_modification, $couleur) {
    $bdd = ConnexionDB();
    $insertPostit = $bdd->prepare('INSERT INTO post_it (id_proprietaire, titre, contenu, date_creation, date_modification, couleur) VALUES (?, ?, ?, ?, ?, ?)');
    $insertPostit->execute([$id_proprio, $titre, $contenu, $date_creation, $date_modification, $couleur]);
    return $bdd->lastInsertId();
}

?>
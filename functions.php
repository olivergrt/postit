<?php 

function ConnexionDB(){  
    $bdd = new PDO('mysql:host=127.0.0.1;dbname=app_post_it;charset=utf8', 'root', ''); 
    return $bdd; 
}

function SelectPostitPersonnel($idUtilisateur){
    $bdd = ConnexionDB();
    $infoPostitPerso = $bdd->prepare("SELECT id_post_it,titre,date_creation,date_modification FROM post_it where id_proprietaire = ? ORDER BY date_creation desc");
    $infoPostitPerso->execute(array($idUtilisateur));
    
    return $infoPostitPerso->fetchAll(PDO::FETCH_ASSOC); // permet de mettre les données dans un tableau associatif pour chaque post it 
}

function SelectPostitPartage($idUtilisateur){
    $bdd = ConnexionDB();
    $infoPostitPartage = $bdd->prepare("SELECT id_post_it,titre,date_creation,date_modification FROM post_it where id_proprietaire = ? ORDER BY date_creation desc");
    $infoPostitPartage->execute(array($idUtilisateur));
    
    return $infoPostitPartage->fetchAll(PDO::FETCH_ASSOC); // permet de mettre les données dans un tableau associatif pour chaque post it 
}

function SelectInfoPostit($idPostit, $idUtilisateur) {
    $bdd = ConnexionDB();
    $infoPostit = $bdd->prepare("SELECT id_post_it, titre, contenu, date_creation, date_modification, utilisateur.nom, utilisateur.prenom FROM post_it JOIN utilisateur ON utilisateur.id_utilisateur = post_it.id_proprietaire WHERE id_post_it = ? AND id_proprietaire = ?");
    $infoPostit->execute(array($idPostit, $idUtilisateur));
    
    return $infoPostit->fetch(PDO::FETCH_ASSOC); // Renvoie directement un tableau associatif
}

function SelectUserPostitPartage($idPostit) {
    $bdd = ConnexionDB();
    $UserPartagePostit = $bdd->prepare("SELECT id_utilisateur, prenom, nom, pseudo from post_it_partage join utilisateur on utilisateur.id_utilisateur = post_it_partage.id_user_partage where id_post_it = ?"); 
    $UserPartagePostit->execute(array($idPostit));
    return $UserPartagePostit->fetchAll(PDO::FETCH_ASSOC); // attention le fetchall ici est important il va nous permettre de recupéré toutes les lignes trouvées (fetch recupere que la premiere)


}

function updatePostit($titre, $contenu, $date_modification, $idPostit, $id_proprio){
     $bdd = ConnexionDB();
    $updatePostit = $bdd->prepare('UPDATE post_it SET titre = ?, contenu = ?, date_modification = ? WHERE id_post_it = ? AND id_proprietaire = ?');
    $updatePostit->execute([$titre, $contenu, $date_modification, $idPostit, $id_proprio]);
}

// function SelectInfoPostit($idPostit) {
//   $ReqVerifInfoPostit = $bdd->prepare("SELECT * FROM post_it WHERE id_post_it = ? AND id_proprietaire = ?");
//     $ReqVerifInfoPostit->execute([$idPostit, $_SESSION['idUser']]);
//     $SelectInfoPostit = $ReqVerifInfoPostit->fetch(PDO::FETCH_ASSOC);


?>
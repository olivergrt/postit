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
    $infoPostit = $bdd->prepare("
        SELECT id_post_it, titre, contenu, date_creation, date_modification FROM post_it WHERE id_post_it = ? AND id_proprietaire = ?
    ");
    $infoPostit->execute(array($idPostit, $idUtilisateur));
    
    return $infoPostit->fetch(PDO::FETCH_ASSOC); // Renvoie directement un tableau associatif
}



?>
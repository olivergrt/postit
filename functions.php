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


?>
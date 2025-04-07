<?php
session_start();
require_once("../functions.php");
include("../connectDB.php");

if (!isset($_SESSION['idUser'])) {
    header("Location: ../connexion/connexion.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: ../index.php");
    exit();
}

$idPostit = intval($_GET['id']);

$infoPostit = SelectInfoPostit($idPostit, $_SESSION['idUser']); 
$userPostitPartage = SelectUserPostitPartage($idPostit); 

if(isset($_GET['delete_postit'])){
    
    deletePostit($idPostit,$_SESSION['idUser']);
    header("Location: ../index.php");
}


if (!$infoPostit) {
        // header("Location: ../index.php");
        // exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Détails du Post-it</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
</head>
<body>
    <div class="postit-container">
        <div class="postit-info">
            <p class="title"> 
                <i class="fas fa-share-alt" title="Post-it partagé"></i> 
                <strong><?= $infoPostit['titre'] ?></strong>
            </p>
          

            <p><?= $infoPostit['contenu'] ?></p><br>
            
            <!-- Afficher uniquement si user = proprietaire -->
            <?php if($_SESSION['idUser'] == $infoPostit['id_proprietaire']){ ?>


                <a href="../creation_edition/create_postit.php?id=<?= $infoPostit['id_post_it'] ?>" class="join-button"> <i class="fas fa-edit"></i></a>
                <a href="visualisation_postit.php?id=<?= $infoPostit['id_post_it'] ?>&delete_postit=<?= $infoPostit['id_post_it'] ?>" class="join-button delete-button"><i class="fas fa-trash-alt"></i></a>
    
            <?php   
            }
              if($userPostitPartage){ ?> <!-- Permet d'afficher le champ unbiquement si un partage existe -->

              <p class="dates"><b>Partagé avec :</b></p>
            <?php 
                foreach ($userPostitPartage as $user) : ?> <!-- Permet de prendre en compte chaque ligne recupéré dans la requete et ajoutées dans le tableau -->
                      
                    <p class="dates"><?= $user['prenom'] ?> <?= $user['nom'] ?></p>
                
            <?php endforeach; }?>
        </div>
    </div>
        <br>
        <p class="dates">Dernière modification le : <?= date('d/m/Y', strtotime($infoPostit['date_modification'])) ?></p>
        <p class="dates">Créé le : <?= date('d/m/Y', strtotime($infoPostit['date_creation'])) ?> par <?= $infoPostit['prenom'] ?> <?= $infoPostit['nom'] ?></p>
        <a href="../index.php" class="join-button">Retour</a>
       
</body>
</html>


<style>
    body {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 100vh;
        background-color: #f8f9fa;
        font-family: Arial, sans-serif;
    }
    .postit-container {
        width: 500px; /* Augmenter la largeur pour un plus grand carré */
        background-color: #fffa90;
        padding: 25px; /* Ajouter plus de padding pour le confort */
        border-radius: 15px;
        box-shadow: 2px 2px 15px rgba(0, 0, 0, 0.3); /* Ombre plus marquée */
        text-align: center;
    }
    .postit-info p {
        margin: 15px 0;
        color: #333;
    }
    .title {
        font-size: 24px; /* Augmenter la taille du titre */
        font-weight: bold;
        margin-bottom: 10px;
    }
    .dates {
        font-size: 14px; /* Réduire la taille des dates */
        color: #555; /* Rendre le texte des dates plus discret */
        font-weight: normal;
    }
    .join-button {
        display: inline-block;
        padding: 12px 20px;
        margin: 10px 5px;
        text-decoration: none;
        color: white;
        background-color: #007bff;
        border-radius: 5px;
        font-size: 16px;
    }
    .join-button:hover {
        background-color: #0056b3;
    }
    .delete-button {
        background-color: #dc3545;
    }
    .delete-button:hover {
        background-color: #a71d2a;
    }
</style>

<?php
session_start();
require_once("../functions.php");
include("../config.php");

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
        header("Location: ../index.php");
        exit();
}

$couleur = $infoPostit['couleur']; 

$backgroundColor = '#FFF176';

$couleursHex = [
    'jaune' => '#FFF176',
    'orange' => '#FFB74D',
    'rouge'  => '#EF5350',
    'vert'   => '#81C784',
    'bleu'   => '#64B5F6',
    'rose'   => '#F48FB1',
];

if (isset($couleursHex[$couleur])) {
    
    $backgroundColor = $couleursHex[$couleur];
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Détails du Post-it</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <div class="navbar">
        <a href="../index.php" title="Accueil"><i class="fas fa-home"></i></a>
        <a href="../index.php?account=true" title="Mon compte"><i class="fas fa-user"></i></a>
        <a href="../connexion/deconnexion.php" title="Déconnexion"><i class="fas fa-sign-out-alt"></i></a>
    </div>

    <main>
        <div class="postit-container" style="background-color: <?= $backgroundColor ?>;">
            
            <div class="postit-info">
                
                <p class="title"> 
                    <strong><?= $infoPostit['titre'] ?></strong>
                </p>
              

                <p><?= $infoPostit['contenu'] ?></p><br>
                
                <!-- Afficher les boutons supprimer et modif uniquement si user connecté = proprietaire du postit -->
                <?php if($_SESSION['idUser'] == $infoPostit['id_proprietaire']){ ?>


                        <a href="../creation_edition/create_postit.php?id=<?= $infoPostit['id_post_it'] ?>" class="btn-page-visualisation"> <i class="fas fa-edit"></i></a>
                        <a href="visualisation_postit.php?id=<?= $infoPostit['id_post_it'] ?>&delete_postit=<?= $infoPostit['id_post_it'] ?>" class="btn-page-visualisation delete-button"><i class="fas fa-trash-alt"></i></a>
        
                <?php   
                }
                  if($userPostitPartage){ ?> <!-- Permet d'afficher le champ unbiquement si un partage existe -->

                    <p class="dates">
                        <b>Partagé avec :</b>
                    </p>
                    
                    <?php 
                    foreach ($userPostitPartage as $user) : ?> <!-- Permet de prendre en compte chaque ligne recupéré dans la requete et ajoutées dans le tableau -->
                          
                        <p class="dates"><?= $user['prenom'] ?> <?= $user['nom'] ?></p>
                    
                    <?php 
                    endforeach; 
                    }?>
            </div>

        </div>

        <br>
        <p class="dates">Dernière modification le : <?= date('d/m/Y à H:i', strtotime($infoPostit['date_modification'])) ?></p>

        <p class="dates">Créé le : <?= date('d/m/Y à H:i', strtotime($infoPostit['date_creation'])) ?> par <?= $infoPostit['prenom'] ?> <?= $infoPostit['nom'] ?></p>
        <a href="../index.php" class="btn-page-visualisation">Retour</a>
    </main>
       
</body>
</html>
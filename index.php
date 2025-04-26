<?php 
session_start(); 
require_once("functions.php");

if (!isset($_SESSION['idUser'])) { // Vérification d'accessibilité à la page => accès autorisé uniquement si l'utilisateur est connecté.
    header("Location: connexion/connexion.php");
    exit();
} 
else {
    $idUtilisateur = $_SESSION['idUser']; 
    $infoPostitPerso = SelectPostitPersonnel($idUtilisateur); // Récupération des informations relatives à l'utilisateur
    $infoPostitPartage = SelectPostitPartage($idUtilisateur); 
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <title>Accueil</title>

</head>
<body>
    <div class="navbar">
        <a href="index.php" class="tab-link">Accueil</a>
        <a href="connexion/deconnexion.php" class="tab-link">Déconnexion</a>
    </div>

    <div class="content">

        <!-- Affichage de Mes post-its -->

        <div class="postit-container">
            
            <h2>Mes post-it</h2>
            
            <a href="creation_edition/create_postit.php" class="btn-create">Créer un post-it</a>

            <?php foreach ($infoPostitPerso as $postit) { ?>
                
                <div class="postit-list">
                    <p><a href="visualisation_postit/visualisation_postit.php?id=<?= $postit['id_post_it'] ?>">
                        <?= htmlspecialchars($postit['titre']) ?></a>
                    </p>
                    <p>Créé le : <?= date('d/m/Y', strtotime($postit['date_creation'])) ?></p>
                </div>
            
            <?php } ?>
       
        </div>

        <!-- Fin d'affichage de mes Post-its -->
        <!-- Affichage des Post-its partagés -->

        <div class="postit-container">
            
            <h2 style="margin-bottom: 65px;">Post-it partagés</h2>

            <?php foreach ($infoPostitPartage as $postit) { ?>
                
                <div class="postit-list">
                    <p> 
                        <i class="fas fa-share-alt" title="Post-it partagé"></i>
                        <a href="visualisation_postit/visualisation_postit.php?id=<?= $postit['id_post_it'] ?>">
                        <?= htmlspecialchars($postit['titre']) ?></a>
                    </p>
                    <p>Créé le : <?= date('d/m/Y', strtotime($postit['date_creation'])) ?></p>
                    <p>Par : <?= $postit['prenom'] ?> <?= $postit['nom'] ?></p>
                </div>
            
            <?php } ?>
        
        </div>

        <!-- Fin d'affichage des Post-its partagés -->

    </div>

</body>
</html>
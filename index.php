<?php 
session_start(); 
require_once("functions.php");

if (!isset($_SESSION['idUser'])) {
    header("Location: connexion/connexion.php");
    exit();
} else {
    $idUtilisateur = $_SESSION['idUser']; 
    $infoPostitPerso = SelectPostitPersonnel($idUtilisateur);
    $infoPostitPartage = SelectPostitPartage($idUtilisateur); 
}

// Tableau de couleur et code hexadécimal pour le background des postits 
$couleursHex = [
    'jaune' => '#FFF176',
    'orange' => '#FFB74D',
    'rouge'  => '#EF5350',
    'vert'   => '#81C784',
    'bleu'   => '#64B5F6',
    'rose'   => '#F48FB1',
];
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

            <?php foreach ($infoPostitPerso as $postit) { 
                $couleur = $postit['couleur'];
                // Vérification de la couleur et attribution du code hexadécimal
                if (isset($couleursHex[$couleur])) {
                    $backgroundColor = $couleursHex[$couleur];
                } else {
                    $backgroundColor = '#FFF176'; // Jaune par défaut
                }
            ?>
                <div class="postit-list" style="background-color: <?= $backgroundColor ?>;">
                    <p><a href="visualisation_postit/visualisation_postit.php?id=<?= $postit['id_post_it'] ?>">
                        <?= htmlspecialchars($postit['titre']) ?></a>
                    </p>
                    <p>Créé le : <?= date('d/m/Y à H:i' , strtotime($postit['date_creation'])) ?></p>
                </div>
            <?php } ?>
        </div>

        <!-- Affichage des Post-its partagés -->
        <div class="postit-container">
            <h2 style="margin-bottom: 65px;">Post-it partagés</h2>

            <?php foreach ($infoPostitPartage as $postit) { 
                $couleur = $postit['couleur'];
                if (isset($couleursHex[$couleur])) {
                    $backgroundColor = $couleursHex[$couleur];
                } else {
                    $backgroundColor = '#FFF176'; // Jaune par défaut
                }
            ?>
                <div class="postit-list" style="background-color: <?= $backgroundColor ?>;">
                    <p> 
                        <i class="fas fa-share-alt" title="Post-it partagé"></i>
                        <a href="visualisation_postit/visualisation_postit.php?id=<?= $postit['id_post_it'] ?>">
                        <?= htmlspecialchars($postit['titre']) ?></a>
                    </p>
                    <p>Créé le : <?= date('d/m/Y à H:i', strtotime($postit['date_creation'])) ?></p>
                    <p>Par : <?= $postit['prenom'] ?> <?= $postit['nom'] ?></p>
                </div>
            <?php } ?>
        </div>
    </div>
</body>
</html>

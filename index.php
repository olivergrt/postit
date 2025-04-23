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

<!-- CSS à séprer dans un nouveau fichier -->
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            height: 100vh;
            background-color: #f8f9fa;
        }

        .navbar {
            display: flex;
            justify-content: center;
            width: 100%;
            background: white;
            padding: 10px 0;
            margin-bottom: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .navbar a {
            text-decoration: none;
            color: black;
            padding: 10px 20px;
            margin: 0 10px;
            font-size: 18px;
            font-weight: bold;
            border-bottom: 3px solid transparent;
        }

        .content {
            display: flex;
            justify-content: space-between;
            width: 80%;
            padding: 20px;
            background: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .postit-container {
            width: 45%;
            display: flex;
            flex-direction: column;
        }

        .postit-list {
            background-color: #fffa90;
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 10px;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.2);
        }

        .postit-list a {
            text-decoration: none;
            font-weight: bold;
            color: #333;
        }

        .postit-list p {
            margin: 5px 0;
            font-size: 14px;
        }

        .btn-create {
            display: block;
            width: fit-content;
            margin-bottom: 15px;
            padding: 10px 15px;
            color: white;
            background-color: #007bff;
            text-decoration: none;
            border-radius: 5px;
        }

        .btn-create:hover {
            background-color: #0056b3;
        }

        h2 {
            text-align: center;
            margin-bottom: 15px;
        }
    </style>
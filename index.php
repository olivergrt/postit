<?php 
session_start(); 
require_once("functions.php");

if (!isset($_SESSION['idUser'])) {
    header("Location: connexion/connexion.html");
    exit();
}else{
	$idUtilisateur = $_SESSION['idUser']; 
	$infoPostitPerso = SelectPostitPersonnel($idUtilisateur);
}


?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Accueil</title>
</head>
<body>

    <div class="navbar">
        <a href="index.php" class="tab-link" id="AfficheMesPostit">Mes post-it</a>
        <a href="index.php?partage=<?= $_SESSION['idUser'] ?>" class="tab-link" id="AfficheMesPartages">Partagé</a>
        <a href="deconnexion.php" class="tab-link" id="tab-partage">Deconnexion</a>
    </div>

    <div id="content">

        <!-- Affichage des données pour "Mes Post-its" -->
        <h2>Mes post-it</h2>
        <a style="margin-bottom: 50px;" href="creation_edition/create_postit.html" class="btn-create">Créer un post-it</a><br>

        <?php foreach ($infoPostitPerso as $postit) { ?>

        <div class="postit-container">
            <div class="postit-info">
                <p><strong><?= htmlspecialchars($postit['titre']) ?></strong></p>
                <p>Créé le : <?= date('d/m/Y', strtotime($postit['date_creation'])) ?></p>
                <a href="edit_postit.php?id=<?= $postit['id_post_it'] ?>" class="join-button">Éditer</a>
                <a href="delete_postit.php?id=<?= $postit['id_post_it'] ?>" class="join-button delete-button">Supprimer</a>
            </div>
        </div>
        <br>
    <?php } ?>
</div>



    <script>

        /*Permet le switch entre les onglets "Mes postits" et "Partages" */
        // Récupère l'URL de le page actuelle
        const urlParams = new URLSearchParams(window.location.search);
        const partage = urlParams.get("partage");

        // Recupere les éléments contenu dans les balises div pour : content, tabPostit, tab 
        const content = document.getElementById("content");
        const tabPostIt = document.getElementById("AfficheMesPostit");
        const tabPartage = document.getElementById("AfficheMesPartages");

        // Met à jour le contenu en fonction de l'URL donc soit "Mes Post-it" soit "Partagé"
        if (partage) {
            content.innerHTML = "<h2>Post-it partagés</h2>";
            tabPartage.classList.add("active");
            tabPostIt.classList.remove("active");
        } else {
            tabPostIt.classList.add("active");
            tabPartage.classList.remove("active");
        }
    </script>

</body>
</html>


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
            justify-content: start;
            height: 100vh;
            background-color: #f8f9fa;
        }

        .navbar {
            display: flex;
            justify-content: center;
            width: 100%;
            background: white;
            padding: 10px 0;
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

        .navbar a.active {
            border-bottom: 3px solid #007bff;
            color: #007bff;
        }

        .content {
            width: 80%;
            margin-top: 20px;
            padding: 20px;
            background: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            text-align: center;
        }

        .btn-create {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 20px;
            font-size: 18px;
            font-weight: bold;
            color: white;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
            text-decoration: none;
        }

        .btn-create:hover {
            background-color: #0056b3;
        }


        .postit-container {
            width: 250px;
            background-color: #fffa90;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.2);
            font-family: Arial, sans-serif;
        }

        .postit-info p {
            margin: 5px 0;
            color: #333;
            font-weight: bold;
        }

        .join-button {
            display: inline-block;
            padding: 8px 12px;
            margin: 5px 5px 0 0;
            text-decoration: none;
            color: white;
            background-color: #007bff;
            border-radius: 5px;
            font-size: 14px;
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
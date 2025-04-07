<?php
session_start();
require_once('../connectDB.php');
require_once("../functions.php");

// Vérification de l'authentification
if (!isset($_SESSION['idUser'])) {
    header("Location: ../connexion/connexion.php");
    exit();
}

$idPostit = null;
if (isset($_GET['id'])) { // si un id de postit est present dans l'url, donc il sagit potentiellement d'une modif 
    
    $idPostit = intval($_GET['id']);
    $SelectInfoPostit = SelectInfoPostit($idPostit,$_SESSION['idUser']); 

    if (!$SelectInfoPostit) { // Si le postit existe pas ou si le postit n'appartient pas à l'utilisateur connecté
        header("Location: ../index.php");
        exit();
    }

    $userPostitPartage = SelectUserPostitPartage($idPostit); // recuperation des user avec qui le postit est partagé
}

if (isset($_POST['save'])) {
    if (!empty($_POST['title']) && !empty($_POST['content'])) {
        $titre = htmlspecialchars($_POST['title']);
        $contenu = htmlspecialchars($_POST['content']);
        $id_proprio = $_SESSION['idUser'];

        if (strlen($titre) <= 30) {
            if (strlen($contenu) <= 250) {
                $date_modification = date('Y-m-d H:i:s');

                if ($idPostit) {

                    updatePostit($titre, $contenu, $date_modification, $idPostit, $id_proprio);      
                    // var_dump($date_modification);     // exit(); 
                } else {
                    $date_creation = date('Y-m-d H:i:s');
                    $insertPostit = $bdd->prepare('INSERT INTO post_it (id_proprietaire, titre, contenu, date_creation, date_modification) VALUES (?, ?, ?, ?, ?)');
                    $insertPostit->execute([$id_proprio, $titre, $contenu, $date_creation, $date_modification]);
                    $idPostit = $bdd->lastInsertId();
                }

                /*A RELIRE LA PARTIE CI DESSOUS */

                // Gestion des utilisateurs partagés
                if (!empty($_POST['selected_users'])) {
                    $selectedUsers = array_filter(explode(',', $_POST['selected_users']), 'ctype_digit');

                    foreach ($selectedUsers as $userId) {
                        
                        $checkShare = $bdd->prepare('SELECT COUNT(*) FROM post_it_partage WHERE id_post_it = ? AND id_user_partage = ?');
                        $checkShare->execute([$idPostit, $userId]);
                        if ($checkShare->fetchColumn() == 0) {
                            $insertShare = $bdd->prepare('INSERT INTO post_it_partage (id_post_it, id_user_partage) VALUES (?, ?)');
                            $insertShare->execute([$idPostit, $userId]);

                        }
                    }
                }
                header("Location: ../visualisation_postit/visualisation_postit.php?id=$idPostit");
                exit();

            } else {
                $erreur = "Le contenu doit comporter au maximum 250 caractères.";
            }
        } else {
            $erreur = "Le titre doit comporter au maximum 30 caractères.";
        }
    } else {
        $erreur = "Tous les champs doivent être complétés.";
    }
}



if(isset($_GET['deleteSharedUser'])){
    deletePartagePostit($idPostit,$_GET['deleteSharedUser']);
    header("Location: create_postit.php?id=$idPostit");
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <title>Créer ou Éditer un post-it</title>
    <style>
        .autocomplete-suggestion {
            padding: 5px;
            border-bottom: 1px solid #ddd;
        }
        .autocomplete-email {
            font-size: 12px;
            color: gray;
        }
  
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-sm-6">
            <div class="shadow-lg p-3 mb-5 bg-body rounded">
                <h1 class="text-center"><?= $idPostit ? "Édition d'un post-it" : "Création d'un post-it" ?></h1>

                <!-- Formulaire d'édition ou de création -->
                <form method="POST" action="create_postit.php<?= $idPostit ? '?id=' . $idPostit : '' ?>">
                    <div class="form-group">
                        <label>Titre :</label>
                        <input class="form-control" type="text" placeholder="Max 30 caractères" name="title"
                               value="<?= $idPostit ? htmlspecialchars($SelectInfoPostit['titre']) : '' ?>"
                               autocomplete="off" required>
                    </div>
                    <br>
                    <div class="form-group">
                        <label>Contenu :</label>
                        <textarea class="form-control" name="content" rows="4" maxlength="200"
                                  placeholder="Max 200 caractères" required><?= $idPostit ? htmlspecialchars($SelectInfoPostit['contenu']) : '' ?></textarea>
                    </div>
                    <br>

                    <h3>Partager</h3>
                    <input type="text" id="search" class="form-control" placeholder="Rechercher un utilisateur...">
                    <div class="selected-users mt-3">
                        
                    <h5>Partagé avec :</h5>
                        <ul id="selected-list" class="list-group"></ul> <!-- afiche les users selectionnés lors de la recherche  -->
                        
                    <?php     
                    if (isset($_GET['id'])){ // Permet d'afficher le champ unbiquement si un partage existe 

                        foreach ($userPostitPartage as $user) : ?> <!-- Permet de prendre en compte chaque ligne recupéré dans la requete et ajoutées dans le tableau -->
                            <p class="dates"><?= $user['prenom'] ?> <?= $user['nom'] ?> <a href="create_postit.php?id=<?= $idPostit ?>&deleteSharedUser=<?= $user['id_utilisateur']?>">Supprimer</a></p>
                                
                        <?php 
                        endforeach; 
                        }?>

                    </div>
                    <input type="hidden" name="selected_users" id="selected-users-input">
                    <button class="btn btn-primary" name="save">Enregistrer</button>
                </form>

                <?php if (isset($erreur)) {
                    echo "<div class='alert alert-danger mt-3'>$erreur</div>";
                } ?>
            </div>
        </div>
    </div>
</div>

<script src="search_user.js"></script>
</body>
</html>


 <style>
        .autocomplete-suggestion {
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }

        .autocomplete-email {
            font-size: 12px;
            color: gray;
        }


        .autocomplete-pseudo {
            font-weight: bold;
            font-size: 14px;
        }

        .autocomplete-name {
            font-size: 13px;
            color: #555;
        }
        .selected-users {
            margin-bottom: 10px;
        }
        .selected-user {
            display: inline-block;
            background: #f0f0f0;
            padding: 5px 10px;
            margin: 5px;
            border-radius: 5px;
            font-size: 14px;
        }
        .remove-user {
            margin-left: 10px;
            color: red;
            cursor: pointer;
        }
    </style>



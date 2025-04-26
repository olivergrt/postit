<?php
session_start();
require_once('../config.php');
require_once("../functions.php");

verifSession();

$idPostit = null; 

if (isset($_GET['id'])) { // si un id de postit est present dans l'url, donc il sagit potentiellement d'une modif 
    
    $idPostit = intval($_GET['id']);
    $SelectInfoPostit = SelectInfoPostit($idPostit,$_SESSION['idUser']); 

    if (!$SelectInfoPostit) { // Vérification si le postit exist et s'il appartient bien à l'utilisateur connecté
        header("Location: ../index.php");
        exit();
    }

    $userPostitPartage = SelectUserPostitPartage($idPostit); // Récuperation des informations des utilisateurs avec qui le postit est partagé
}

if (isset($_POST['save'])) { // si le btn "save" a été cliqué 
     
    if (!empty($_POST['title']) && !empty($_POST['content'])) { // Vérification si les champs obligatoires sont rempli 
        
        $titre = htmlspecialchars($_POST['title']);
        $contenu = htmlspecialchars($_POST['content']);
        $id_proprio = $_SESSION['idUser'];

        if (strlen($titre) <= 30) { // Vérification de la longeur du titre < 30 carractères 
            
            if (strlen($contenu) <= 250) { // Vérification de la longeur du contenu < 250 carractères 

                $date_modification = date('Y-m-d H:i:s');

                if ($idPostit) { // Si $idPostit == true alors il s'agit d'une modification car l'id Postit est récupéré en GET

                    
                    updatePostit($titre, $contenu, $date_modification, $idPostit, $id_proprio);  // Donc on met a jour le postit    
                } 
                else { // Sinon on insere le nouveau postit 
                    
                    $date_creation = date('Y-m-d H:i:s');    
                    $idPostit = insertPostit($id_proprio, $titre, $contenu, $date_creation, $date_modification); // On stock l'id du postit qui vient d'être créé pour l'insertion des utilisateur partagés

                }

                /*A RELIRE LA PARTIE CI DESSOUS */

                // Gestion des utilisateurs partagés
                if (!empty($_POST['selected_users'])) { //Verifie si un utilisateur à été selectionné 
                    
                    $selectedUsers = array_filter(explode(',', $_POST['selected_users']), 'ctype_digit'); //Stockage dans un tableau des id des users selectionné

                    foreach ($selectedUsers as $userId) {
                        
                        /* Pour chaque user selected, Verification si le postit est deja partagé avec l'utilisateur*/
                        $VerifDejaPartage = $bdd->prepare('SELECT COUNT(*) FROM post_it_partage WHERE id_post_it = ? AND id_user_partage = ?');
                        $VerifDejaPartage->execute([$idPostit, $userId]);
                        
                        if ($VerifDejaPartage->fetchColumn() == 0) {
                            /*Si aucun partage existe alors on insere le couple unique idpostit,iduser */
                            $insertShare = $bdd->prepare('INSERT INTO post_it_partage (id_post_it, id_user_partage) VALUES (?, ?)');
                            $insertShare->execute([$idPostit, $userId]);

                        }
                    }
                }
                header("Location: ../visualisation_postit/visualisation_postit.php?id=$idPostit"); // Redirection vers l'affichage du Postit 
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


/*Lors de la suppression du partage d'un postit avec un utilisateur*/
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
    <link rel="stylesheet" href="styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <title>Créer ou Éditer un post-it</title>
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
                        <input class="form-control" type="text" placeholder="Max 30 caractères" name="title" value="<?= $idPostit ? htmlspecialchars($SelectInfoPostit['titre']) : '' ?>">
                    </div>
                    
                    <br>
                    
                    <div class="form-group">
                        <label>Contenu :</label>
                        <textarea class="form-control" name="content" rows="4" placeholder="Max 200 caractères"><?= $idPostit ? htmlspecialchars($SelectInfoPostit['contenu']) : '' ?></textarea>
                    </div>
                    
                    <br>

                    <!-- Partager le postit avec des utilisateurs -->

                    <h3>Partager</h3>
                    
                    <!-- Barre de recherche avec autocomplétion -->
                    <input type="text" id="search" class="form-control" placeholder="Rechercher un utilisateur..."> 
                    
                    <div class="selected-users mt-3">
                        
                        <h5>Partagé avec :</h5>
                                <ul id="selected-list" class="list-group"></ul> <!-- affiche les uers en autocompletion lors de la recherche  -->
                                
                            <?php     
                            if (isset($_GET['id'])){ // Permet d'afficher le champ unbiquement si un partage existe 

                                // Permet de prendre en compte chaque ligne recupéré dans la requete et ajoutées dans le tableau
                                foreach ($userPostitPartage as $user) : ?> 
                                    
                                    <p class="dates">
                                        <?= $user['prenom'] ?> <?= $user['nom'] ?> 
                                        <a href="create_postit.php?id=<?= $idPostit ?>&deleteSharedUser=<?= $user['id_utilisateur']?>">Supprimer</a>
                                    </p>
              
                            <?php 
                                endforeach; 
                        }?>

                    </div>

                    <input type="hidden" name="selected_users" id="selected-users-input">
                    <button class="btn btn-primary" name="save">Enregistrer</button>

                </form>

                <?php if (isset($erreur)) { echo "<div class='alert alert-danger mt-3'>$erreur</div>"; } ?>
            </div>
        </div>
    </div>
</div>

<script src="search_user.js"></script>
</body>
</html>


<!-- Mettre le CSS dans un fichier à part -->
 <style>


</style>



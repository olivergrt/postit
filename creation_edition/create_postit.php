<?php
session_start(); 
require_once('../config.php');
require_once("../functions.php");

verifSession();

$idPostit = null; //Si on est sur une creation

if (isset($_GET['id'])) { // si un id de postit est present dans l'url, donc il sagit potentiellement d'une modification
    
    $idPostit = intval($_GET['id']);
    $SelectInfoPostit = SelectInfoPostit($idPostit,$_SESSION['idUser']); 

    if (!$SelectInfoPostit) { 
        // Vérification si le postit exist et s'il appartient bien à l'utilisateur connecté
        header("Location: ../index.php");
        exit();
    }

    $userPostitPartage = SelectUserPostitPartage($idPostit); // Récuperation des informations des utilisateurs avec qui le postit est partagé
}


if (isset($_POST['save'])) {
    
    $erreurs = []; /*stockage des erreurs à afficher*/

    if (isset($_POST['title'])) {
        $titre = $_POST['title']; 
    } 
    else {
        $titre = ''; 
    }

    if (isset($_POST['content'])) {
        $contenu = $_POST['content']; 
    } 
    else {
        $contenu = '';
    }

    if (isset($_POST['couleur'])) {
        $couleur = $_POST['couleur']; 
    } 
    else {
        $couleur = '';
    }


    $id_proprio = $_SESSION['idUser'];

    // Vérification des champs obligatoires
    if (empty($titre) || empty($contenu) || empty($couleur)) {
        $erreurs[] = "Tous les champs doivent être complétés.";
    }

    // Vérification des longueurs
    if (strlen($titre) > 150) { 
        $erreurs[] = "Le titre doit comporter au maximum 30 caractères.";
    }

    if (strlen($contenu) > 600) { 
        $erreurs[] = "Le contenu doit comporter au maximum 600 caractères.";
    }

    if (empty($erreurs)) {
        $titre = htmlspecialchars($titre);
        $contenu = htmlspecialchars($contenu);
        date_default_timezone_set('Europe/Paris');
        $date_modification = date('Y-m-d H:i:s');
       

        if ($idPostit) { // Si modification 
            updatePostit($titre, $contenu, $date_modification, $idPostit, $id_proprio, $couleur);
        } 
        else {    // Si Creation 
            $date_creation = date('Y-m-d H:i:s');
            $idPostit = insertPostit($id_proprio, $titre, $contenu, $date_creation, $date_modification, $couleur);
        }

        

        // Gestion des utilisateurs partagés
        // Vérifie si des utilisateurs ont été sélectionné pour le partage
        if (!empty($_POST['selected_users'])) {

            $ids = explode(',', $_POST['selected_users']);
            // array_filter avec 'ctype_digit' garde uniquement les chiffres donc les ids
            $selectedUsers = array_filter($ids, function($id) {
                return ctype_digit($id);
            });

            foreach ($selectedUsers as $userId) {

                // vérifie si le post-it a déjà été partagé avec cet utilisateur
                $VerifDejaPartage = $bdd->prepare('SELECT COUNT(*) FROM post_it_partage WHERE id_post_it = ? AND id_user_partage = ?');
                $VerifDejaPartage->execute([$idPostit, $userId]);

                // Si ce n'est pas encore le cas (le partage n'existe pas)
                if ($VerifDejaPartage->fetchColumn() == 0) { /*fetchColumn retourne la valeur unique */

                    // Alors on insère une ligne dans la table de partage
                    $insertShare = $bdd->prepare('INSERT INTO post_it_partage (id_post_it, id_user_partage) VALUES (?, ?)');
                    $insertShare->execute([$idPostit, $userId]);
                }
            }
        }


        header("Location: ../visualisation_postit/visualisation_postit.php?id=$idPostit");
        exit();
    } else {
        $erreur = implode("<br>", $erreurs);
    }
}



/*Suppression du partage d'un postit avec un utilisateur*/
if(isset($_GET['deleteSharedUser'])){ 
    deletePartagePostit($idPostit,$_GET['deleteSharedUser']);
    header("Location: create_postit.php?id=$idPostit");
}

// Détermination de la couleur du post-it à afficher dans le formulaire

if ($idPostit && isset($SelectInfoPostit['couleur'])) {
    // Si le user est en edition et qu'une couleur est enregistrée pour ce post-it
    /*recuperation de la couleur */
    $color = $SelectInfoPostit['couleur'];
} 
else {
    // couleur par defaut jaune
    $color = 'jaune';
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
<body">
    <div class="container mt-5">
      <div class="row justify-content-center">
        <div class="col-sm-8">
          <div class="form-container">
          <h2 class="text-center mb-4">
            <?php
            if ($idPostit) {
                echo "Édition d'un post-it";
            } 
            else {
                echo "Création d'un post-it";
            }
            ?>
            </h2>
            
            <form method="POST">
              <div class="form-group mb-3">
                <label>Titre :</label>
                <input class="form-control" type="text" id="title" placeholder="Max 150 caractères" name="title" value="<?= $idPostit ? htmlspecialchars($SelectInfoPostit['titre']) : '' ?>" maxlength="150">
              </div>

              <div class="form-group mb-3">
                <label>Contenu :</label>
                <textarea class="form-control" id="content" name="content" maxlength="600" rows="4" placeholder="Max 600 caractères"><?= $idPostit ? htmlspecialchars($SelectInfoPostit['contenu']) : '' ?></textarea>
              </div>
              
              <label for="couleur">Couleur du post-it :</label>
                <select class="form-control" name="couleur" id="couleur">
                    
                    <?php if ($color == 'jaune') { ?>
                        <option value="jaune" selected>Jaune</option>
                    <?php } 
                    else { ?>
                        <option value="jaune">Jaune</option>
                    <?php } ?>

                    <?php if ($color == 'orange') { ?>
                        <option value="orange" selected>Orange</option>
                    <?php } 
                    else { ?>
                        <option value="orange">Orange</option>
                    <?php } ?>

                    <?php if ($color == 'rouge') { ?>
                        <option value="rouge" selected>Rouge</option>
                    <?php } 
                    else { ?>
                        <option value="rouge">Rouge</option>
                    <?php } ?>

                    <?php if ($color == 'vert') { ?>
                        <option value="vert" selected>Vert</option>
                    <?php } 
                    else { ?>
                        <option value="vert">Vert</option>
                    <?php } ?>

                    <?php if ($color == 'bleu') { ?>
                        <option value="bleu" selected>Bleu</option>
                    <?php } 
                    else { ?>
                        <option value="bleu">Bleu</option>
                    <?php } ?>

                    <?php if ($color == 'rose') { ?>
                        <option value="rose" selected>Rose</option>
                    <?php } 
                    else { ?>
                        <option value="rose">Rose</option>
                    <?php } ?>
                </select>

              <h3 class="mt-4">Partager</h3>
              <input type="text" id="search" class="form-control" placeholder="Rechercher un utilisateur...">

              <div class="selected-users mt-3">       
                <h5>Partagé avec :</h5>
                <ul id="selected-list" class="list-group"></ul>

                <?php if (isset($_GET['id'])){ ?>
                  
                  <?php foreach ($userPostitPartage as $user){ ?>
                    
                    <p class="dates">
                      <?= $user['prenom'] ?> <?= $user['nom'] ?> 
                      <a href="create_postit.php?id=<?= $idPostit ?>&deleteSharedUser=<?= $user['id_utilisateur']?>">Supprimer</a>
                    </p>
                  
                  <?php } 
                   } ?>

              </div>

              <input type="hidden" name="selected_users" id="selected-users-input">
              <button class="btn-connexion w-100 mt-4" name="save">Enregistrer</button>
            </form>
              <a href="../index.php">
                <button class="btn-cancel w-100 mt-4">Annuler</button>
              </a>

            <?php if (isset($erreur)){ ?>
              <div class="alert alert-danger mt-3 text-center"><?= $erreur ?></div>
            <?php } ?>            

          </div>
        </div>
      </div>
    </div>
    <br>
    <script src="search_user.js"></script>
    <script src="create_postit.js"></script>
</body>
</html>




<?php
session_start();
require_once('../connectDB.php');

// Vérification si un id de postit est passé dans l'URL pour une édition/modification
if (isset($_GET['id'])) {
    // Si un ID de postit est passé, on va récupérer les informations du post-it à éditer
    $idPostit = intval($_GET['id']);
    
    // Requête pour verifier et récupérer les informations du post-it
    $ReqVerifInfoPostit = $bdd->prepare("SELECT * FROM post_it WHERE id_post_it = ? AND id_proprietaire = ?");
    $ReqVerifInfoPostit->execute([$idPostit, $_SESSION['idUser']]);
    $VerifInfoPostit = $ReqVerifInfoPostit->fetch(PDO::FETCH_ASSOC);
    
    // Si le post-it n'existe pas ou n'appartient pas à l'utilisateur, redirection
    if (!$VerifInfoPostit) {
        header("Location: ../index.php");
        exit();
    }
} else {
    // Si pas d'ID passé, on est en mode création
    $idPostit = null;
}

if (isset($_POST['save'])) {
    // Vérification que le titre et le contenu ne sont pas vides
    if (!empty($_POST['title']) && !empty($_POST['content'])) {
        $titre = htmlspecialchars($_POST['title']);
        $contenu = htmlspecialchars($_POST['content']);

        // Vérification de la longueur du titre
        $longueur_titre = strlen($titre);
        if ($longueur_titre < 30) {
            // Vérification de la longueur du contenu (limite à 250 caractères)
            $longueur_contenu = strlen($contenu);
            if ($longueur_contenu <= 250) {
                $date_modification = date('Y-m-d H:i:s'); // Date de modification
                $id_proprio = $_SESSION['idUser'];

                if ($idPostit) { //variable $idPostit true or false 
                    // Si un ID est passé (donc true) on fait une mise à jour du post-it
                    $updatePostit = $bdd->prepare('UPDATE post_it SET titre = ?, contenu = ?, date_modification = ? WHERE id_post_it = ? AND id_proprietaire = ?');
                    $updatePostit->execute([$titre, $contenu, $date_modification, $idPostit, $id_proprio]);
                } else {
                    // Sinon on crée un nouveau post-it
                    $date_creation = date('Y-m-d H:i:s');
                    $insertPostit = $bdd->prepare('INSERT INTO post_it (id_proprietaire, titre, contenu, date_creation, date_modification) VALUES (?, ?, ?, ?, ?)');
                    $insertPostit->execute([$id_proprio, $titre, $contenu, $date_creation, $date_modification]);
                }

                header("Location: ../index.php");
                exit();
            } else {
                $erreur = "Le contenu doit comporter au maximum 200 caractères.";
            }
        } else {
            $erreur = "Le titre doit comporter moins de 30 caractères.";
        }
    } else {
        $erreur = "Tous les champs doivent être complétés.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Créer ou Éditer un post-it</title>
</head>	
<body>

<div class="container">
    <br><br><br>
    <div class="row justify-content-center">
        <div class="col-sm-6">
            <div class="shadow-lg p-3 mb-5 bg-body rounded">
                <h1 class="text-center"><?= $idPostit ? "Édition d'un post-it" : "Création d'un post-it" ?></h1>

                <!-- Formulaire d'édition ou de création -->
                <form method="POST" action="create_postit.php<?= $idPostit ? '?id=' . $idPostit : '' ?>">

                    <div class="form-group">
                        <label>Titre :</label>
                        <input class="form-control" type="text" placeholder="Max 30 caractères" name="title" value="<?= $idPostit ? htmlspecialchars($VerifInfoPostit['titre']) : '' ?>" autocomplete="off" required>
                    </div>
                    <br>
                    <div class="form-group">
                        <label>Contenu :</label>
                        <textarea class="form-control" name="content" rows="4" maxlength="200" placeholder="Max 200 caractères" required><?= $idPostit ? htmlspecialchars($VerifInfoPostit['contenu']) : '' ?></textarea>
                    </div>
                    <br>
                    <button class="btn btn-primary" name="save">Enregistrer</button>
                </form>
                
                <?php if (isset($erreur)) { echo "<div class='alert alert-danger mt-3'>$erreur</div>"; } ?>
            </div>
        </div>
    </div>
</div>

</body>
</html>

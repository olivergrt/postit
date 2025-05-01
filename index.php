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
    $infoUtilisateur = SelectInfoUtilisateur($idUtilisateur); 
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <title>Accueil</title>
</head>
<body>
    <div class="navbar">
        <a href="index.php" class="tab-link">Accueil</a>
        <a href="index.php?account=true" class="tab-link">Mon Compte</a>
        <a href="connexion/deconnexion.php" class="tab-link">Déconnexion</a>
    </div>


    <?php if (!isset($_GET['account'])){ ?>

    <div class="content">

        <!-- Affichage de Mes post-its -->

        <div class="postit-container">
            <h2>Mes post-it</h2>
            <a href="creation_edition/create_postit.php" class="btn-create">Créer un post-it</a>

            <?php foreach ($infoPostitPerso as $postit) { 

                $couleur = $postit['couleur'];

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

    <!-- Affichage page Mon Compte -->
    <?php } 
    else{ 
        ?>

   <div class="content">
        <div class="card shadow-lg p-4 mb-5 bg-body rounded" style="max-width: 600px; margin: auto;">
            
            <h2 class="text-center mb-4">Mon Compte</h2>

            <form method="POST">
                <div class="mb-3">
                    <label for="prenom" class="form-label">Prénom</label>
                    <input type="text" class="form-control" id="prenom" name="prenom" value="<?= htmlspecialchars($infoUtilisateur['prenom']) ?>">
                </div>

                <div class="mb-3">
                    <label for="nom" class="form-label">Nom</label>
                    <input type="text" class="form-control" id="nom" name="nom" value="<?= htmlspecialchars($infoUtilisateur['nom']) ?>">
                </div>

                <div class="mb-3">
                    <label for="pseudo" class="form-label">Pseudo</label>
                    <input type="text" class="form-control" id="pseudo" name="pseudo" value="<?= htmlspecialchars($infoUtilisateur['pseudo']) ?>">
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Adresse email</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($infoUtilisateur['email']) ?>">
                </div>

                <div class="mb-3">
                    <label for="date_naiss" class="form-label">Date de naissance</label>
                    <input type="date" class="form-control" id="date_naiss" name="date_naiss" value="<?= htmlspecialchars($infoUtilisateur['date_naiss']) ?>">
                </div>

                <button type="submit" class="btn btn-primary w-100">Enregistrer les modifications</button>
            </form>

            <hr class="my-4">

            <div class="text-center">
                <a href="change_password.php" class="btn btn-outline-secondary">Modifier le mot de passe</a>
                <form method="POST" action="supprimer_compte.php" onsubmit="return confirm('Es-tu sûr de vouloir supprimer ton compte ? Cette action est irréversible.')">
                    <button type="submit" class="btn btn-danger mt-3">Supprimer mon compte</button>
                </form>
            </div>

            
    </div>
</div>
    <?php } ?>
</body>
</html>

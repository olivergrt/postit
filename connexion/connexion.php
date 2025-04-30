<?php
session_start();
include("../config.php");
require_once("../functions.php");

verifAlreadyConnected(); 

$error = ""; // Variable pour stocker les erreurs

if (isset($_POST['submit'])) {
    if (!empty($_POST['email']) && !empty($_POST['password'])) {
        
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $pwd = sha1($_POST['password']);

        $reqVerif = $bdd->prepare("SELECT id_utilisateur FROM utilisateur WHERE password = ? AND email = ?");
        $reqVerif->execute([$pwd, $email]);

        $info = $reqVerif->fetch(PDO::FETCH_ASSOC); 

        if ($info) { 
            $_SESSION['idUser'] = $info['id_utilisateur']; 
            header("Location: ../index.php");
            exit();
        } else {
            $error = "Identifiant ou mot de passe incorrect.";
        }
    } else {
        $error = "Veuillez remplir tous les champs.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <title>Connexion - Post IT</title>
</head>
<body>
    <br>

    <div class="container">
    <br><br>
    <center><img style="width: 140px;" src="../img/logo.png" alt="Logo"></center>
    <div class="row justify-content-center">
        <div class="col-sm-6">
            <div class="form-container">
                <h2 class="text-center">Connexion</h2>
                <form method="POST" action="connexion.php">
                    <div class="form-group">
                        <label>Saisir votre adresse mail :</label>
                        <input class="form-control" type="email" value="oliver@test.fr" name="email">
                    </div>
                    <br>
                    <div class="form-group">
                        <label>Saisir votre mot de passe :</label>
                        <input class="form-control" type="password" value="azertyuiop" name="password">
                        <small class="form-text text-muted"><a href="#">Mot de passe oublié.</a></small>
                    </div>
                    <div class="container text-center text-danger">
                        <?php if (!empty($error)) echo "<p>$error</p>"; ?> <!-- Affichage des erreurs -->
                    </div>
                    <br>
                    <div class="d-flex justify-content-between mt-3">
                        <button class="btn btn-connexion" name="submit">Se connecter</button>
                        <a href="../inscription/inscription.php" class="btn btn-inscription">S'inscrire</a>
                    </div>
                </form>      
            </div>
        </div>
    </div>
</div>

</body>
</html>

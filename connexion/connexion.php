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
    <script src="connexion.js"></script>
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
                <form method="POST" action="">
                    <div class="form-group">
                        <label>Saisir votre adresse mail :</label>
                        <input id="email" class="form-control" type="email" value="oliver@test.fr" name="email">
                    </div>
                    <br>
                    <div class="form-group">
                        <label>Saisir votre mot de passe :</label>
                        <input id="password" class="form-control" type="password" value="azertyuiop" name="password">
                        <small class="form-text text-muted"><a href="mailto:oliver.grant@universite-paris-saclay.fr">Mot de passe oublié.</a></small>
                    </div>
                    <div class="container text-center text-danger" id="client-error">
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
    <center>
       <img style="width: 130px;padding-bottom: 40px;padding-top: 40px;" src="../img/logo_upsaclay.png" alt="Logo">
        <img style="width: 90px;" src="../img/logo_miage.png" alt="Logo">
    </center>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector("form");
    const email = document.getElementById("email");
    const password = document.getElementById("password");
    const errorDiv = document.getElementById("client-error");

    form.addEventListener("submit", function (e) {
        // Réinitialisation
        email.classList.remove("input-error");
        password.classList.remove("input-error");
        errorDiv.textContent = "";

        let hasError = false;
        let messages = [];

        // Vérifie si email est vide
        if (email.value.trim() === "") {
            email.classList.add("input-error");
            messages.push("L'adresse email est requise.");
            hasError = true;
        } else {
            // Vérifie le format de l'email
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email.value.trim())) {
                email.classList.add("input-error");
                messages.push("Le format de l'adresse email est invalide.");
                hasError = true;
            }
        }

        // Vérifie si le mot de passe est vide
        if (password.value.trim() === "") {
            password.classList.add("input-error");
            messages.push("Le mot de passe est requis.");
            hasError = true;
        }

        if (hasError) {
            e.preventDefault(); // Bloque l'envoi
            errorDiv.innerHTML = messages.map(msg => `<p>${msg}</p>`).join("");
        }
    });
});

</script>

</body>
</html>



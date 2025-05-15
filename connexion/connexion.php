<?php
session_start();
include("../config.php");
require_once("../functions.php");

autoLoginFromCookie();
verifAlreadyConnected(); 

$error = ""; // Variable pour stocker les erreurs

if (isset($_POST['submit'])) {
    if (!empty($_POST['email']) && !empty($_POST['password'])) {

        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $pwd = $_POST['password'];

        // Récupérer le mot de passe hashé depuis la base pour l'email donné
        $reqVerif = $bdd->prepare("SELECT id_utilisateur, password FROM utilisateur WHERE email = ?");
        $reqVerif->execute([$email]);

        $info = $reqVerif->fetch(PDO::FETCH_ASSOC);

        if ($info && password_verify($pwd, $info['password'])) {
            
            $_SESSION['idUser'] = $info['id_utilisateur'];
            
            /*Creation d'un cookie pour conserver la connexion*/
            if (isset($_POST['remember'])) {
                $token = bin2hex(random_bytes(32));
                $expire = date('Y-m-d H:i:s', time() + 60 * 60 * 24 * 30);

                $ip = $_SERVER['REMOTE_ADDR'];
                $userAgent = $_SERVER['HTTP_USER_AGENT'];

                $updateToken = $bdd->prepare("
                    UPDATE utilisateur 
                    SET remember_token = ?, token_expire = ?, remember_ip = ?, remember_user_agent = ? 
                    WHERE id_utilisateur = ?
                ");
                $updateToken->execute([$token, $expire, $ip, $userAgent, $info['id_utilisateur']]);

                setcookie("remember_token", $token, time() + 60 * 60 * 24 * 30, "/", "", false, true);
            }

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
                <form method="POST" action="">
                    <div class="form-group">
                        <label>Saisir votre adresse mail :</label>
                        <input id="email" class="form-control" type="email" name="email" value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>">
                        <div class="text-danger" id="error-email">
                            <?php if (!empty($_POST) && empty($_POST['email'])) echo "L'adresse email est requise."; ?>
                        </div>
                    </div>
                    <br>
                    <div class="form-group">
                        <label>Saisir votre mot de passe :</label>
                        <input id="password" class="form-control" type="password" name="password">
                        <div class="text-danger" id="error-password">
                            <?php if (!empty($_POST) && empty($_POST['password'])) echo "Le mot de passe est requis."; ?>
                        </div>
                        <small class="form-text text-muted"><a href="mailto:oliver.grant@universite-paris-saclay.fr">Mot de passe oublié.</a></small>
                    </div>

                    <div class="text-danger text-center" id="error-global">
                        <?php if (!empty($error)) echo $error; ?>
                    </div>



                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="remember" id="remember">
                      <label class="form-check-label" for="remember">
                        Se souvenir de moi
                      </label>
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
    <script src="connexion.js"></script>
</body>
</html>



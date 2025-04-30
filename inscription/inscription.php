<?php
session_start();
require_once('../config.php'); 
require_once("../functions.php");

verifAlreadyConnected(); 

// Initialisation des erreurs
$erreur_prenom = $erreur_nom = $erreur_pseudo = $erreur_email = $erreur_datenaiss = $erreur_password = $erreur_password_confirm = $erreur_accept = "";
$values = [];

if (isset($_POST['inscription'])) {
    $prenom = htmlspecialchars($_POST['prenom'] ?? '');
    $nom = htmlspecialchars($_POST['nom'] ?? '');
    $pseudo = htmlspecialchars($_POST['pseudo'] ?? '');
    $email = htmlspecialchars($_POST['email'] ?? '');
    $datenaiss = htmlspecialchars($_POST['datenaiss'] ?? '');
    $password = $_POST['password'] ?? '';
    $password_confirm = $_POST['password_confirm'] ?? '';
    $accept = $_POST['accept'] ?? '';

    $values = compact('prenom', 'nom', 'pseudo', 'email', 'datenaiss');

    $form_valid = true;

    if (empty($prenom)) {
        $erreur_prenom = "Veuillez renseigner votre prénom.";
        $form_valid = false;
    }
    if (empty($nom)) {
        $erreur_nom = "Veuillez renseigner votre nom.";
        $form_valid = false;
    }
    if (empty($pseudo)) {
        $erreur_pseudo = "Veuillez renseigner un pseudo.";
        $form_valid = false;
    }
    if (empty($email)) {
        $erreur_email = "Veuillez renseigner une adresse mail.";
        $form_valid = false;
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erreur_email = "Adresse mail invalide.";
        $form_valid = false;
    }
    if (empty($datenaiss)) {
        $erreur_datenaiss = "Veuillez indiquer votre date de naissance.";
        $form_valid = false;
    }
    if (empty($password)) {
        $erreur_password = "Veuillez renseigner un mot de passe.";
        $form_valid = false;
    } elseif (strlen($password) < 8) {
        $erreur_password = "Le mot de passe doit contenir au moins 8 caractères.";
        $form_valid = false;
    }
    if (empty($password_confirm)) {
        $erreur_password_confirm = "Veuillez confirmer votre mot de passe.";
        $form_valid = false;
    } elseif ($password !== $password_confirm) {
        $erreur_password_confirm = "Les mots de passe ne correspondent pas.";
        $form_valid = false;
    }
    if (empty($accept)) {
        $erreur_accept = "Vous devez accepter les conditions.";
        $form_valid = false;
    }

    if ($form_valid) {
        $password_hashed = password_hash($password, PASSWORD_DEFAULT);

        $insertmbr = $bdd->prepare('
            INSERT INTO utilisateur (email, password, nom, prenom, pseudo, date_naiss) 
            VALUES (?, ?, ?, ?, ?, ?)');
        $insertmbr->execute([$email, $password_hashed, $nom, $prenom, $pseudo, $datenaiss]);

        header("Location: ../connexion/connexion.php");
        exit();
    }
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Inscription</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="styles.css">
</head>
<body>

<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-sm-6">
      <div class="form-container">
        <a href="../connexion/connexion.php" class="btn btn-connexion mb-3">← Retour à la connexion</a>
        <h2 class="text-center mb-4">Inscription</h2>

        <?php if (isset($erreur)): ?>
          <div class="alert alert-danger text-center"><?php echo $erreur; ?></div>
        <?php endif; ?>

	       <form method="POST" action="inscription.php">
			  <div class="form-group mb-3">
			    <label>Votre Prénom :</label>
			    <input class="form-control <?php echo $erreur_prenom ? 'is-invalid' : ''; ?>" type="text" name="prenom" value="<?php echo $values['prenom'] ?? ''; ?>">
			    <div class="invalid-feedback"><?php echo $erreur_prenom; ?></div>
			  </div>

			  <div class="form-group mb-3">
			    <label>Votre Nom :</label>
			    <input class="form-control <?php echo $erreur_nom ? 'is-invalid' : ''; ?>" type="text" name="nom" value="<?php echo $values['nom'] ?? ''; ?>">
			    <div class="invalid-feedback"><?php echo $erreur_nom; ?></div>
			  </div>

			  <div class="form-group mb-3">
			    <label>Pseudo :</label>
			    <input class="form-control <?php echo $erreur_pseudo ? 'is-invalid' : ''; ?>" type="text" name="pseudo" value="<?php echo $values['pseudo'] ?? ''; ?>">
			    <div class="invalid-feedback"><?php echo $erreur_pseudo; ?></div>
			  </div>

			  <div class="form-group mb-3">
			    <label>Votre adresse mail :</label>
			    <input class="form-control <?php echo $erreur_email ? 'is-invalid' : ''; ?>" type="" name="email" value="<?php echo $values['email'] ?? ''; ?>">
			    <div class="invalid-feedback"><?php echo $erreur_email; ?></div>
			  </div>

			  <div class="form-group mb-3">
			    <label>Date de naissance :</label>
			    <input class="form-control <?php echo $erreur_datenaiss ? 'is-invalid' : ''; ?>" type="date" name="datenaiss" value="<?php echo $values['datenaiss'] ?? ''; ?>">
			    <div class="invalid-feedback"><?php echo $erreur_datenaiss; ?></div>
			  </div>

			  <div class="form-group mb-3">
			    <label>Votre mot de passe :</label>
			    <input class="form-control <?php echo $erreur_password ? 'is-invalid' : ''; ?>" type="password" name="password">
			    <div class="invalid-feedback"><?php echo $erreur_password; ?></div>
			  </div>

			  <div class="form-group mb-3">
			    <label>Confirmer le mot de passe :</label>
			    <input class="form-control <?php echo $erreur_password_confirm ? 'is-invalid' : ''; ?>" type="password" name="password_confirm">
			    <div class="invalid-feedback"><?php echo $erreur_password_confirm; ?></div>
			  </div>

			  <div class="form-check mb-4">
			    <input class="form-check-input <?php echo $erreur_accept ? 'is-invalid' : ''; ?>" type="checkbox" name="accept" id="accept" <?php echo isset($accept) ? 'checked' : ''; ?>>
			    <label class="form-check-label" for="accept">
			      J'accepte les <a href="conditions.html">conditions d'utilisation</a>.
			    </label>
			    <div class="invalid-feedback d-block"><?php echo $erreur_accept; ?></div>
			  </div>

			  <button class="btn btn-inscription" name="inscription">Valider l'inscription</button>
			</form>


      </div>
    </div>
  </div>
</div>

</body>
</html>


</body>
</html>

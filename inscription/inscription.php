<?php
session_start();
require_once('../config.php');
require_once('../functions.php');

// Redirection si déjà connecté
verifAlreadyConnected();

// Initialisation des tableaux de gestion des erreurs et des champs remplis
$errors = [];
$values = [];

// Initialiser la case à cocher "accept" à false pour éviter des notices PHP
$values['accept'] = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Champs attendus
    $champsSimples = ['prenom', 'nom', 'pseudo', 'email', 'password', 'password_confirm'];

    foreach ($champsSimples as $champ) {
        if (isset($_POST[$champ])) {
            $values[$champ] = trim($_POST[$champ]);
        } else {
            $values[$champ] = '';
        }
    }

    // Case à cocher : acceptation des conditions
    if (isset($_POST['accept'])) {
        $values['accept'] = true;
    } else {
        $values['accept'] = false;
    }

    // Champs de la date de naissance
    if (isset($_POST['jour'])) {
        $values['jour'] = $_POST['jour'];
    } else {
        $values['jour'] = '';
    }

    if (isset($_POST['mois'])) {
        $values['mois'] = $_POST['mois'];
    } else {
        $values['mois'] = '';
    }

    if (isset($_POST['annee'])) {
        $values['annee'] = $_POST['annee'];
    } else {
        $values['annee'] = '';
    }


    // Prénom
    if ($values['prenom'] === '') {
        $errors['prenom'] = "Prénom requis.";
    }

    // Nom
    if ($values['nom'] === '') {
        $errors['nom'] = "Nom requis.";
    }

    // Pseudo
    if ($values['pseudo'] === '') {
        $errors['pseudo'] = "Pseudo requis.";
    } else {
        $stmt = $bdd->prepare("SELECT COUNT(*) FROM utilisateur WHERE pseudo = ?");
        $stmt->execute([$values['pseudo']]);
        if ($stmt->fetchColumn() > 0) {
            $errors['pseudo'] = "Pseudo déjà utilisé.";
        }
    }

    // Email
    if ($values['email'] === '') {
        $errors['email'] = "Email requis.";
    } elseif (!filter_var($values['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Format d'email invalide.";
    } else {
        $stmt = $bdd->prepare("SELECT COUNT(*) FROM utilisateur WHERE email = ?");
        $stmt->execute([$values['email']]);
        if ($stmt->fetchColumn() > 0) {
            $errors['email'] = "Email déjà utilisé.";
        }
    }

    // Date de naissance
    if ($values['jour'] === '' || $values['mois'] === '' || $values['annee'] === '') {
        $errors['datenaiss'] = "Date de naissance requise.";
    } elseif (!checkdate((int)$values['mois'], (int)$values['jour'], (int)$values['annee'])) {
        $errors['datenaiss'] = "Date invalide.";
    } else {
        $values['datenaiss'] = sprintf('%04d-%02d-%02d',(int)$values['annee'],(int)$values['mois'],(int)$values['jour']);
    }

    // Mot de passe
    if (strlen($values['password']) < 8) {
        $errors['password'] = "Le mot de passe doit contenir au moins 8 caractères.";
    }
    if ($values['password_confirm'] !== $values['password']) {
        $errors['password_confirm'] = "Les mots de passe ne correspondent pas.";
    }

    // Conditions d'utilisation
    if (!$values['accept']) {
        $errors['accept'] = "Vous devez accepter les conditions d'utilisation.";
    }

    /*Enregistrement en base */
    if (empty($errors)) {
        $pwdHash = password_hash($values['password'], PASSWORD_ARGON2ID);

        $stmt = $bdd->prepare(
            "INSERT INTO utilisateur (email, password, nom, prenom, pseudo, date_naiss) VALUES (?, ?, ?, ?, ?, ?)"
        );
        $stmt->execute([$values['email'],$pwdHash,$values['nom'],$values['prenom'],$values['pseudo'],$values['datenaiss']]);

        header("Location: ../connexion/connexion.php");
        exit();
    }
}
?>

?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Inscription</title>
  <link rel="stylesheet" href="styles.css">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <script defer src="inscription.js"></script>
</head>
<body>
  <center><img style="width: 140px;" src="../img/logo.png" alt="Logo"></center>

  <div class="form-container">
    <a href="../connexion/connexion.php" class="btn-return">← Retour à la connexion</a>
    <h2>Inscription</h2>
    <form method="POST" name="inscriptionForm" novalidate>

      <?php
        function showError($field) {
          global $errors;
          if (isset($errors[$field])) {
            echo "<div class='error-message'>{$errors[$field]}</div>";
          }
        }
      ?>

      <input class="form-input <?= isset($errors['prenom']) ? 'is-invalid' : '' ?>"
             name="prenom" placeholder="Prénom" value="<?= htmlspecialchars(isset($values['prenom']) ? $values['prenom'] : '') ?>">
      <?php showError('prenom'); ?>

      <input class="form-input <?= isset($errors['nom']) ? 'is-invalid' : '' ?>"
             name="nom" placeholder="Nom" value="<?= htmlspecialchars(isset($values['nom']) ? $values['nom'] : '') ?>">
      <?php showError('nom'); ?>

      <input class="form-input <?= isset($errors['pseudo']) ? 'is-invalid' : '' ?>"
             name="pseudo" placeholder="Pseudo" value="<?= htmlspecialchars(isset($values['pseudo']) ? $values['pseudo'] : '') ?>">
      <?php showError('pseudo'); ?>

      <input class="form-input <?= isset($errors['email']) ? 'is-invalid' : '' ?>"
             name="email" type="email" placeholder="Email" value="<?= htmlspecialchars(isset($values['email']) ? $values['email'] : '') ?>">
      <?php showError('email'); ?>

      <div class="form-date">
        <!-- Année -->
        <select name="annee" class="form-select <?= isset($errors['datenaiss']) ? 'is-invalid' : '' ?>">
          <option value="">Année</option>
          <?php $curr = date('Y'); for ($i = $curr; $i >= 1900; $i--): ?>
            <option <?= (isset($values['annee']) && $values['annee'] == $i) ? 'selected' : '' ?>><?= $i ?></option>
          <?php endfor; ?>
        </select>

        <!-- Mois -->
        <select name="mois" class="form-select <?= isset($errors['datenaiss']) ? 'is-invalid' : '' ?>">
          <option value="">Mois</option>
          <?php for ($m = 1; $m <= 12; $m++): ?>
            <option <?= (isset($values['mois']) && $values['mois'] == $m) ? 'selected' : '' ?>><?= $m ?></option>
          <?php endfor; ?>
        </select>

        <!-- Jour -->
        <select name="jour" class="form-select <?= isset($errors['datenaiss']) ? 'is-invalid' : '' ?>">
          <option value="">Jour</option>
          <?php for ($d = 1; $d <= 31; $d++): ?>
            <option <?= (isset($values['jour']) && $values['jour'] == $d) ? 'selected' : '' ?>><?= $d ?></option>
          <?php endfor; ?>
        </select>
      </div>
      <?php showError('datenaiss'); ?>

      <input type="password"
             class="form-input <?= isset($errors['password']) ? 'is-invalid' : '' ?>"
             name="password" placeholder="Mot de passe">
      <?php showError('password'); ?>

      <input type="password"
             class="form-input <?= isset($errors['password_confirm']) ? 'is-invalid' : '' ?>"
             name="password_confirm" placeholder="Confirme mot de passe">
      <?php showError('password_confirm'); ?>

      <div class="checkbox-container">
        <input type="checkbox" id="accept" name="accept" <?= isset($values['accept']) && $values['accept'] ? 'checked' : '' ?>>
        <label for="accept">J'accepte <a href="conditions.html">les conditions d'utilisation</a></label>
      </div>
      <?php showError('accept'); ?>

      <button class="submit-button" type="submit">S'inscrire</button

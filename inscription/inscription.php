<?php
session_start();
require_once('../config.php');
require_once("../functions.php");

// Redirige si déjà connecté
verifAlreadyConnected();

// Tableaux pour stocker les erreurs et les valeurs précédemment saisies
$errors = [];
$values = [];

// ** Initialisation obligatoire de 'accept' pour ne plus déclencher de notice **
$values['accept'] = false;

// Si le formulaire a été soumis...
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // 1) Récupération et nettoyage des valeurs basiques
    $fields = ['prenom','nom','pseudo','email','password','password_confirm'];
    foreach ($fields as $f) {
        $values[$f] = trim($_POST[$f] ?? '');
    }
    // Case à cocher
    $values['accept'] = isset($_POST['accept']);
    // Date de naissance en trois champs
    $values['jour']  = $_POST['jour']  ?? '';
    $values['mois']  = $_POST['mois']  ?? '';
    $values['annee']= $_POST['annee'] ?? '';

    // 2) Validation côté serveur (mêmes règles qu’en JS)
    if ($values['prenom']==='') {
        $errors['prenom'] = "Prénom requis.";
    }
    if ($values['nom']==='') {
        $errors['nom'] = "Nom requis.";
    }
    if ($values['pseudo']==='') {
        $errors['pseudo'] = "Pseudo requis.";
    } else {
        
        // Vérifie unicité du pseudo
        $stmt = $bdd->prepare("SELECT COUNT(*) FROM utilisateur WHERE pseudo = ?");
        $stmt->execute([$values['pseudo']]);
        
        if ($stmt->fetchColumn() > 0) {
            $errors['pseudo'] = "Pseudo déjà utilisé.";
        }
    }
    if ($values['email']==='') {
        $errors['email'] = "Email requis.";
    } 
    elseif (!filter_var($values['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Email invalide.";
    } 
    else {
        // Vérifie si l'email a jamais ete utilisé
        $stmt = $bdd->prepare("SELECT COUNT(*) FROM utilisateur WHERE email = ?");
        $stmt->execute([$values['email']]);
        if ($stmt->fetchColumn() > 0) {
            $errors['email'] = "Email déjà utilisé.";
        }
    }
    // Date de naissance
    if ($values['jour']==='' || $values['mois']==='' || $values['annee']==='') {
        $errors['datenaiss'] = "Date de naissance requise.";
    } 
    elseif (!checkdate((int)$values['mois'], (int)$values['jour'], (int)$values['annee'])) {
        $errors['datenaiss'] = "Date invalide.";
    } 
    else {
        // Stocke au format SQL
        $values['datenaiss'] = sprintf(
            '%04d-%02d-%02d',
            (int)$values['annee'],
            (int)$values['mois'],
            (int)$values['jour']
        );
    }
    // Mot de passe
    if (strlen($values['password']) < 8) {
        $errors['password'] = "Minimum 8 caractères.";
    }
    if ($values['password_confirm'] !== $values['password']) {
        $errors['password_confirm'] = "Mots de passe différents.";
    }
    // Case à cocher
    if (!$values['accept']) {
        $errors['accept'] = "Veuillez accepter les conditions.";
    }

    // 3) Si tout est bon, on insère et redirige
    if (empty($errors)) {
        // Utilisation d'Argon2id (recommandé)
        $pwdHash = password_hash($values['password'], PASSWORD_ARGON2ID);

        $stmt = $bdd->prepare(
            'INSERT INTO utilisateur (email, password, nom, prenom, pseudo, date_naiss) VALUES (?, ?, ?, ?, ?, ?)'
        );
        $stmt->execute([
            $values['email'],
            $pwdHash,
            $values['nom'],
            $values['prenom'],
            $values['pseudo'],
            $values['datenaiss']
        ]);

        header("Location: ../connexion/connexion.php");
        exit();
    }
}
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

      <input class="form-input <?php if(isset($errors['prenom'])) echo 'is-invalid'; ?>"
             name="prenom" placeholder="Prénom" value="<?=htmlspecialchars($values['prenom'] ?? '')?>">
      <?php showError('prenom'); ?>

      <input class="form-input <?php if(isset($errors['nom'])) echo 'is-invalid'; ?>"
             name="nom" placeholder="Nom" value="<?=htmlspecialchars($values['nom'] ?? '')?>">
      <?php showError('nom'); ?>

      <input class="form-input <?php if(isset($errors['pseudo'])) echo 'is-invalid'; ?>"
             name="pseudo" placeholder="Pseudo" value="<?=htmlspecialchars($values['pseudo'] ?? '')?>">
      <?php showError('pseudo'); ?>

      <input class="form-input <?php if(isset($errors['email'])) echo 'is-invalid'; ?>"
             name="email" placeholder="Email" type="email" value="<?=htmlspecialchars($values['email'] ?? '')?>">
      <?php showError('email'); ?>

      <div class="form-date">
        <select name="annee" class="form-select <?php if(isset($errors['datenaiss'])) echo 'is-invalid'; ?>">
          <option value="">Année</option>
          <?php $curr = date('Y'); for($i=$curr;$i>=1900;$i--) {
            $sel = (isset($values['annee']) && $values['annee']==$i)?'selected':''; 
            echo "<option $sel>$i</option>";
          } ?>
        </select>
        <select name="mois" class="form-select <?php if(isset($errors['datenaiss'])) echo 'is-invalid'; ?>">
          <option value="">Mois</option>
          <?php for($m=1;$m<=12;$m++){
            $sel=(isset($values['mois'])&&$values['mois']==$m)?'selected':''; 
            echo "<option $sel>$m</option>";
          } ?>
        </select>
        <select name="jour" class="form-select <?php if(isset($errors['datenaiss'])) echo 'is-invalid'; ?>">
          <option value="">Jour</option>
          
          <?php for($d=1;$d<=31;$d++){
            $sel=(isset($values['jour'])&&$values['jour']==$d)?'selected':''; 
            echo "<option $sel>$d</option>";
          } ?>

        </select>
      </div>
      <?php showError('datenaiss'); ?>

      <input type="password"
             class="form-input <?php if(isset($errors['password'])) echo 'is-invalid'; ?>"
             name="password" placeholder="Mot de passe">
      <?php showError('password'); ?>

      <input type="password"
             class="form-input <?php if(isset($errors['password_confirm'])) echo 'is-invalid'; ?>"
             name="password_confirm" placeholder="Confirme mot de passe">
      <?php showError('password_confirm'); ?>

      <div class="checkbox-container">
        <input type="checkbox" id="accept" name="accept" <?= $values['accept']?'checked':'' ?>>
        <label for="accept">J'accepte <a href="conditions.html">les conditions d'utilisation</a></label>
      </div>
      <?php showError('accept'); ?>

      <button class="submit-button" type="submit">S'inscrire</button>
    </form>
  </div>
</body>
</html>

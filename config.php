<?php
try {
    $bdd = new PDO('mysql:host=127.0.0.1;dbname=app_post_it;charset=utf8', 'root', '');
    // Permet d'activer les erreurs PDO en mode exception
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Affichage de l'erreur
    echo 'Erreur de connexion : ' . $e->getMessage();
    die();
}
?>

<?php
$bdd = new PDO('mysql:host=127.0.0.1;dbname=app_post_it;charset=utf8', 'root', '', [
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
]);

$term = $_GET['term'] ?? '';

$query = "SELECT id_utilisateur, email, pseudo, prenom, nom FROM utilisateur WHERE pseudo LIKE :term OR prenom LIKE :term OR nom LIKE :term";

$stmt = $bdd->prepare($query);
$stmt->execute(['term' => "%$term%"]);

echo json_encode($stmt->fetchAll());
?>

<?php
session_start(); 
    
$bdd = new PDO('mysql:host=127.0.0.1;dbname=app_post_it;charset=utf8', 'root', ''); 

$term = $_GET['term'] ?? '';

$query = "SELECT id_utilisateur, email, pseudo, prenom, nom FROM utilisateur WHERE pseudo LIKE :term OR prenom LIKE :term OR nom LIKE :term";

$selectUsers = $bdd->prepare($query);
$selectUsers->execute(['term' => "%$term%"]);

echo json_encode($selectUsers->fetchAll());

?> 

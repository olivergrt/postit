<?php
session_start(); 
require_once('../connectDB.php');
/*header('Content-Type: application/json');*/

//  Vérifie si c’est bien une requête AJAX qui accès à lURL si l'accès est bloqué
if (empty($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest') {
    http_response_code(403);
    echo json_encode(['error' => 'Accès interdit']);
    exit;
}

$term = $_GET['term'] ?? '';


    $reqSelectUser = "SELECT id_utilisateur, email, pseudo, prenom, nom FROM utilisateur WHERE pseudo LIKE :term OR prenom LIKE :term OR nom LIKE :term";

    $selectUsers = $bdd->prepare($reqSelectUser);
    $selectUsers->execute(['term' => "%$term%"]);

    echo json_encode($selectUsers->fetchAll(PDO::FETCH_ASSOC));

?>

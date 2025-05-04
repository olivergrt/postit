<?php
session_start(); 
require_once("../functions.php");
require_once('../config.php');
verifSession();

$idUtilisateur = $_SESSION['idUser']; 

/*header('Content-Type: application/json');*/

//  Vérification si c’est bien une requête AJAX qui accès à l'URL si l'accès est bloqué
if (empty($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest') {
    http_response_code(403);
    echo json_encode(['error' => 'Accès interdit']);
    exit;
}

if (isset($_GET['term'])) {
    $term = $_GET['term'];
} else {
    $term = '';
}

// Suppression de l'id de l'utilisateur connecté pour ne pas le suggérer en partage 
$reqSelectUser = "
SELECT id_utilisateur, email, pseudo, prenom, nom FROM utilisateur WHERE id_utilisateur != :idUtilisateur AND (pseudo LIKE :term OR prenom LIKE :term OR nom LIKE :term)"; 

$selectUsers = $bdd->prepare($reqSelectUser);
$selectUsers->execute(['idUtilisateur' => $idUtilisateur,'term' => "%$term%"]);

echo json_encode($selectUsers->fetchAll(PDO::FETCH_ASSOC)); /* renvoie les résultats de la requete en JSON*/

?>

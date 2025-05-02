<?php
session_start(); 
require_once("../functions.php");
verifSession();
require_once('../config.php');

$idUtilisateur = $_SESSION['idUser']; 

/*header('Content-Type: application/json');*/

//  Vérifie si c’est bien une requête AJAX qui accès à lURL si l'accès est bloqué
if (empty($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest') {
    http_response_code(403);
    echo json_encode(['error' => 'Accès interdit']);
    exit;
}

$term = $_GET['term'] ?? '';


    $reqSelectUser = "
    SELECT id_utilisateur, email, pseudo, prenom, nom 
    FROM utilisateur 
    WHERE id_utilisateur != :idUtilisateur
      AND (pseudo LIKE :term OR prenom LIKE :term OR nom LIKE :term)"; // SUpprime l'id de l'utilisateur connecté pour ne pas le suggerer

    $selectUsers = $bdd->prepare($reqSelectUser);
    $selectUsers->execute([
    'idUtilisateur' => $idUtilisateur,
    'term' => "%$term%"
    ]);

    echo json_encode($selectUsers->fetchAll(PDO::FETCH_ASSOC));

?>

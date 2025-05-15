<?php 
session_start(); 
require_once("../config.php");

if(isset($_SESSION['idUser'])){

	$id = $_SESSION['idUser'];
	// Supprimer le token en base si défini
	if (isset($_SESSION['idUser'])) {
	    $stmt = $bdd->prepare("UPDATE utilisateur SET remember_token = NULL, token_expire = NULL, remember_ip = NULL, remember_user_agent = NULL WHERE id_utilisateur = ?");
	    $stmt->execute([$id]);
	}

	// Supprimer le cookie
	setcookie("remember_token", "", time() - 3600, "/");

	$_SESSION = array(); 
	session_destroy(); 
	header("Location: connexion.php");
	exit();
}
else{
	header("Location: connexion.php");
	exit();
}
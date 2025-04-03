<?php 
session_start(); 

if(isset($_SESSION['idUser'])){

	$_SESSION = array(); 
	session_destroy(); 
	header("Location: connexion/connexion.html");
}
<?php
session_start(); 
include("../connectDB.php");

var_dump($_SESSION['idClient']); 

	if(isset($_POST['submit'])){
	    if(!empty($_POST['email']) AND !empty($_POST['password'])){
	        
            $email =  htmlspecialchars($_POST['email']); 
						$pwd = sha1($_POST['password']); 
						$reqVerif = $bdd->prepare("SELECT id_utilisateur FROM utilisateur WHERE password = ? AND email = ?"); 
						$reqVerif->execute(array($pwd, $email)); 
						$res = $reqVerif->rowCount(); 
			
            if ($res == 1) {
							$info = $reqVerif->fetch();
							$_SESSION['idUser'] = $info['id_utilisateur']; 
						header("Location: ../index.php");
						}	
						else{
							$error =  "Identifiant ou mot de passe incorect !";
						}
	   	}
	}


?>
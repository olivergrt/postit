<?php
 require_once('../connectDB.php'); 

 if(isset($_POST['inscription'])){

 	if(!empty($_POST['prenom']) AND !empty($_POST['nom']) AND !empty($_POST['email']) AND !empty($_POST['accept']) AND !empty($_POST['password_confirm']) AND !empty($_POST['password_confirm'])){

 		$prenom = htmlspecialchars($_POST['prenom']); 
	 	$nom = htmlspecialchars($_POST['nom']); 
	 	$pseudo = htmlspecialchars($_POST['pseudo']); 
	 	$email = htmlspecialchars($_POST['email']); 
	 	$datenaiss = htmlspecialchars($_POST['datenaiss']); 
	 	$password = htmlspecialchars($_POST['password']); 
	 	$password_confirm = htmlspecialchars($_POST['password_confirm']);  


 		if (filter_var($email, FILTER_VALIDATE_EMAIL)){

			$passwordLength = strlen($password);
            $passwordConfirmL = strlen($password_confirm);

            if($passwordLength >= 6){

            	if($password == $password_confirm){

            		$password = sha1($password_confirm);

            		$insertmbr = $bdd->prepare('
    				INSERT INTO utilisateur (email, password, nom, prenom, pseudo, date_naiss) VALUES (?, ?, ?, ?, ?, ?)'); 
                	$insertmbr->execute([$email, $password, $nom, $prenom, $pseudo, $datenaiss]);
                	header("Location: ../connexion/connexion.php");  

	            }
	            else{
                    $erreur = "Vos mots de passe ne correpondent pas"; 
              }
	 		}
	 		else{
                $erreur = "Votre mot de passe doit comporter au minimum	 8 caractères";
      }
	 	}
	 	else{
        $erreur = "Votre adresse mail n'est pas valide";
      }
	}
	else{
      $erreur = "Tous les champs doivent être complétés";
    }
}


?>
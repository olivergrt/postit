<?php
session_start();
require_once('../connectDB.php'); 

 if(isset($_POST['save'])){

 	if(!empty($_POST['title'])){

 		$titre = htmlspecialchars($_POST['title']); 

			$longeur_titre = strlen($titre);
	
            if($titre < 151){
 
        		  	$date_creation = date('Y-m-d H:i:s'); // A la fois date de creation et date de modification 
					$id_proprio = $_SESSION['idUser']; 

            		$insertPostit = $bdd->prepare('INSERT INTO post_it (id_proprietaire,titre, date_creation,date_modification) VALUES (?,?,?,?)'); 
                	$insertPostit->execute([$id_proprio,$titre, $date_creation, $date_creation]);
                	header("Location: ../index.php");  
	 		}
	 		else{
                $erreur = "Votre mot de passe doit comporter au maximum	150 caractères";
      		}
	 	
	}
	else{
      $erreur = "Tous les champs doivent être complétés";
    }
}


?>
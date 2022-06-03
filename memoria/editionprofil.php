<?php
session_start();
require_once ("fonctions.php");	

$connex = connexion_bd();
no_session();
$tabuser = affiche_user($connex);


// si l'utilisateur a modifié une ou plusieurs données on effectue les verifications et on securise avant de les rentrer dans la base
if(isset($_POST['newnom'])AND !empty($_POST['newnom']) AND $_POST['newnom'] != $tabuser['nom']){
	$newnom = mysqli_real_escape_string($connex,$_POST['newnom']);
	$newnomlength = strlen($newnom);
	
	if($newnomlength <= 30){
		$reqnom = "UPDATE user SET nom = '".$newnom."' WHERE id=".$_SESSION['id']."";
		$ligne = mysqli_query($connex, $reqnom);
		
		if (! $ligne){
			page_erreur(ERR_REQUETE,mysqli_error($connex),$connex);
		}
		
		header("Location:profil.php?id=".$_SESSION['id']);
	
	}else{
		$erreuredition = "Ton nom ne peut pas dépasser 30 carectères!!";
	}
}
if(isset($_POST['newprenom'])AND !empty($_POST['newprenom']) AND $_POST['newprenom'] != $tabuser['prenom']){
	$newprenom = mysqli_real_escape_string($connex,$_POST['newprenom']);
	$newprenomlength = strlen($newprenom);
	
	if($newprenomlength <= 30){
		$reqprenom = "UPDATE user SET prenom = '".$newprenom."' WHERE id=".$_SESSION['id']."";
		$ligne = mysqli_query($connex, $reqprenom);
		
		if (! $ligne){
			page_erreur(ERR_REQUETE,mysqli_error($connex),$connex);
		}
		
		header("Location:profil.php?id=".$_SESSION['id']);
			
	}else{
		$erreuredition = "Ton prénom ne doit pas depasser 30 carectères !!";
	}
}
if(isset($_POST['newage'])AND !empty($_POST['newage']) AND $_POST['newage'] != $tabuser['age']){
	$newage = intval($_POST['newage']);
	
	if($newage <= 100 AND $newage >= 0){
		$reqage = "UPDATE user SET age = ".$newage." WHERE id=".$_SESSION['id']."";
		$ligne = mysqli_query($connex, $reqage);
		
		if (! $ligne){
			page_erreur(ERR_REQUETE,mysqli_error($connex),$connex);  
		}
		
		header("Location: profil.php?id=".$_SESSION['id']);
	
	}else{
		$erreuredition = "Tu es trop vieux ... ou peut-être pas encore né ... en tout cas notre site est réservé au plus de 0 ans et au moins de 100 ans ;) ";
	}
}
if(isset($_POST['newpseudo'])AND !empty($_POST['newpseudo']) AND $_POST['newpseudo'] != $tabuser['pseudo']){
	$newpseudo = mysqli_real_escape_string($connex,$_POST['newpseudo']);

	$reqpseudo="SELECT * FROM user WHERE pseudo ='".$newpseudo."'";
	$lignepseudo = mysqli_query($connex, $reqpseudo);
	
	if(mysqli_fetch_row($lignepseudo) == 0){
		$reqpseudo = "UPDATE user SET pseudo = '".$newpseudo."' WHERE id=".$_SESSION['id']."";
		$ligne = mysqli_query($connex, $reqpseudo);
		
		if (! $ligne){
			page_erreur(ERR_REQUETE,mysqli_error($connex),$connex); 
		}
		
		header("Location: profil.php?id=".$_SESSION['id']);
			
	}else{
		$erreuredition = "Desolé, ce pseudo est déjà pris ";
	}
}
if(isset($_POST['newemail'])AND !empty($_POST['newemail']) AND $_POST['newemail'] != $tabuser['email']){
	$newemail = mysqli_real_escape_string($connex,$_POST['newemail']);
	
	if( filter_var($newemail,FILTER_VALIDATE_EMAIL)){
		$req="SELECT * FROM user WHERE email ='".$newemail."'";
		$ligne = mysqli_query($connex, $req);
		
		if(! $ligne){
		    page_erreur(ERR_REQUETE,mysqli_error($connex),$connex); 
		 }
		if(mysqli_fetch_assoc($ligne) == 0){
			$reqemail = "UPDATE user SET email = '".$newemail."' WHERE id=".$_SESSION['id']."";
			$ligne = mysqli_query($connex, $reqemail);
			
			if (! $ligne) {
				page_erreur(ERR_REQUETE,mysqli_error($connex),$connex);
			}
			
			header("Location: profil.php?id=".$_SESSION['id']);
			
		}else{
			$erreuredition = "Cet email est déjà utilisé";
		}
	}else{
		$erreuredition = "Cet email n'est pas valide!!";
	}
}
if(isset($_POST['oldmdp'])AND !empty($_POST['oldmdp']) AND isset($_POST['newmdp'])AND !empty($_POST['newmdp']) AND !( $_POST['oldmdp']==$_POST['newmdp'])){
	$oldmdp = mysqli_real_escape_string($connex,$_POST['oldmdp']);
	$newmdp = mysqli_real_escape_string($connex,$_POST['newmdp']);
	$newmdplength = strlen($newmdp);
	
	if(password_verify($oldmdp,$tabuser['mdp'])){
		if($newmdplength > 7){
			if(yes_maj($newmdp)){
				if(yes_num($newmdp)){
					if(verif_alphaNum($newmdp)){
						$newmdp = password_hash($newmdp,PASSWORD_DEFAULT);
						$reqmdp = "UPDATE user SET mdp = '".$newmdp."' WHERE id=".$_SESSION['id']."";
						$ligne = mysqli_query($connex, $reqmdp);
						
						if (! $ligne) {
							page_erreur(ERR_REQUETE,mysqli_error($connex),$connex);
						}
						
						header("Location:profil.php?id=".$_SESSION['id']);
						
					}else{
						$erreur = "Ton mot de passe ne doit pas contenir de caractères spéciaux";
					}
				}else{
					$erreuredition = "Ton mot de passe doit contenir au moins un chiffre";
				}
			}else{
				$erreuredition = "Ton mot de passe doit contenir au moins une majuscule";
			}
		}else{
			$erreuredition = "Ton mot de passe doit contenir au minimum 8 caractères alphanumériques ";
		}
	}else{
	$erreuredition = "L'ancien mot de passe est incorrect";
	}
}

mysqli_close($connex);
?>
<!--============================================================= partie HTML =======================================================================-->
<!DOCTYPE html>
	<html lang ="fr">
	<head>
		<meta charset ="utf-8">
		<title >Memoria-Editer mon profil </title>
		<link rel="stylesheet" type="text/css" href="css/editionprofil.css">
	</head>
	<body >
		<div id = "content">
			<div class ="accueil">
				<a href = "accueil.php">accueil </a> <br>
			</div>
	
			<h1>  Edition de mon compte </h1>
		
			<div class="contenu" >
					<div class="erreur">
					<?php 
						if(isset($erreuredition)) echo'<font color="red">'.$erreuredition."</font>";
					?>
					</div>	
					
				<form method="post" action="editionprofil.php" name="editionprofil">
					<p>
						<label>nom:</label> <br>
						<input type="text" placeholder=" entre ton nom" name="newnom" value="<?php  echo htmlspecialchars( $tabuser['nom']) ;?>"/> 
					</p>
					<p>
						<label>prénom:</label><br>
						<input type="text" placeholder=" entre ton prénom" name="newprenom" value="<?php  echo htmlspecialchars($tabuser['prenom']) ;?>"/> 
					</p>
					<p>
						<label>âge:</label><br>
						<input type="number" name="newage"  min="0" max="100" value="<?php echo htmlspecialchars($tabuser['age']);?>"/> 
					</p>
					<p>
						<label>pseudo:</label><br>
						<input type="text" placeholder="entre ton pseudo" name="newpseudo" value="<?php  echo htmlspecialchars($tabuser['pseudo']);?>"/> 
					</p>
					<p>
						<label>email:</label><br>
						<input type="email" placeholder="entre ton email" name="newemail" value="<?php  echo htmlspecialchars($tabuser['email']);?>" />
					</p>
				 
					<div class = "mdp">
						<div class = "modif">
							modification du mot de passe: <br><br>
						</div>
						<p>
							<label> ancien mot de passe:</label><br>
							<input type="password" placeholder="entre l'ancien mot de passe" name="oldmdp" /> 
						</p>
						<p>
							<label>nouveau mot de passe:</label><br>
							<input type="password" placeholder="entre le nouveau mdp" name="newmdp" /> 
						</p>
					</div>	
					<div class ="valider">
						<input type="submit" name="valideredition" value="Enregistrer les modifications" />
					</div>
				</form>
			</div>
			<div class = "reseau" >
				<p class = "reseau">
					<h3>
						Nos réseaux 
					</h3>
					<h4> 
						MIKIA Benidy         NODIN Aurélie
					</h4>
				</p>
			</div>
			<div class = "reseaux">
				<a class = "b" href = "https://www.instagram.com/beni.mk/?hl=fr" target ="_BLANK"><img src = "img/darkmode-instagram-1200x650" width ="30" height="20" alt="logo instagram"></a>
			
				<a class = "n" href = "https://www.instagram.com/aurelie_ndn/?hl=fr" target ="_BLANK"><img src = "img/darkmode-instagram-1200x650" width ="30" height="20" alt="logo instagram"></a>
			</div>
			<div class ="image">
				<div class = "img">
					<img src = "img/book.png" width ="200" height="200" alt="school book">
				</div>
				<div class ="img2">		
					<img src = "img/school.png" width ="200" height="200" alt="school">
				</div>
				<div class ='img3'>
					<img src = "img/folder.png" width ="250" height="250" alt="school folder">
				</div>
				<div class ="img4">		
					<img src = "img/man.png" width ="350" height="200" alt="man">
				</div>
			</div>
		</div>
		<footer>
			<h5>
				Ce site a été créé par MIKIA Benidy et NODIN Aurélie dans le cadre d'un projet en L1 informatique.
			</h5>
		</footer>
	</body>
	</html>
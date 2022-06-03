<?php
session_start();
require_once ("fonctions.php");

$connex = connexion_bd();

	if(isset($_POST['valider_connexion'])){
		
		if(!empty($_POST['pseudo_connexion'] AND $_POST['mdp_connexion'])){
			 
			//on securise chaque données entrées par l'utilisateur pour éviter de l'injection sql et xss ( on est jamais trop prudent)
			$pseudo_connexion = mysqli_real_escape_string($connex,$_POST['pseudo_connexion']);
			$mdp_connexion = mysqli_real_escape_string($connex,$_POST['mdp_connexion']);
		
			$req="SELECT * FROM user WHERE pseudo ='".$pseudo_connexion."'";
			$ligne = mysqli_query($connex, $req);
			
			if (! $ligne) {
				page_erreur(ERR_REQUETE,mysqli_error($connex),$connex); 		 
			}
			
			$tab =  mysqli_fetch_assoc($ligne);
			
				if($tab !== 0){	
				
					if(password_verify($mdp_connexion,$tab['mdp'])){
						
						$_SESSION['id'] = $tab['id'];
						$_SESSION['pseudo'] = $tab['pseudo'];
						$_SESSION['admin'] = $tab['admin'];
						
						header("Location: Accueil.php?id=".$_SESSION['id']);
						mysqli_close($connex);
					}else{
						$erreur = "mot de passe incorrect ";
					}
				}else{
					$erreur = "pseudo incorrect";
				}
		}else{
			 $erreur = "Entres  tes informations pour te connecter ";
		}
	}
	mysqli_close($connex);		
?>
<!--============================================================= partie HTML =======================================================================-->
<!DOCTYPE html>
	<html lang ="fr">
	<head>
		<meta charset ="utf-8">
		<title >Memoria-Connexion</title>
		<link rel="stylesheet" type="text/css" href="css/connexion.css">
	</head>
	<body>
		<div id="content">
			<div class = "debut">
				<p>Connecte-toi pour accéder au site</p> <br><br>
			</div>
			<div class="erreur">
				<?php 
					if(isset($erreur)) echo'<font color="red">'.$erreur."</font>";
				?>
			</div>

				<div class = "formulaire">
				<form method="POST" action="connexion.php" name="connexion">
					<p>
						<label>pseudo:</label><br>
						<input type="text" placeholder="entre ton pseudo" name="pseudo_connexion" value="<?php if(isset($pseudo_connexion)){ echo $pseudo_connexion;}?>"/> 
					</p>
					<p>
						<label>mot de passe:</label><br>
						<input type="password"  name="mdp_connexion" /> 
					</p>
					<div class = "bouton">
						<input type="submit" value="valider" name="valider_connexion">
					</div>
				</form>
				</div>
			<div class = "quoi">
				<p>
					Quoi ! Pas encore de compte? <a href="inscription.php"> Inscris-toi ici</a> 
				</p>
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
					<img src = "img/book.png" width ="150" height="150" alt="school book">
				</div>
				<div class ="img2">		
					<img src = "img/school.png" width ="150" height="150" alt="school">
				</div>
				<div class ='img3'>
					<img src = "img/folder.png" width ="200" height="200" alt="school folder">
				</div>
				<div class ="img4">		
					<img src = "img/man.png" width ="300" height="150" alt="man">
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
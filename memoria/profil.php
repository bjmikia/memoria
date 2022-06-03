<?php
session_start();
require_once("fonctions.php");

$connex = connexion_bd();
no_session();	
$tabuser = affiche_user($connex);
	
mysqli_close($connex);					
?>	
	<!--============================================================= partie HTML =======================================================================-->
<!DOCTYPE html>
	<html lang ="fr">
	<head>
		<meta charset ="utf-8">
		<title>Memoria-Mon compte </title>
		<link rel="stylesheet" type="text/css" href="css/profil.css"> 
	</head>
	<body >
		<div id = "content">
			<div class = "accueil">
				<a href = "accueil.php">Accueil </a> <br>
			</div>
			<div class="deco">
				 <a href="deconnexion.php">Deconnexion</a>
			</div>
			<p> <U> Mon profil</U> </p>
			<div class="info-perso">
				Nom : <?php echo htmlspecialchars($tabuser['nom']); ?>
				<br>
				Prénom : <?php echo htmlspecialchars($tabuser['prenom']); ?>
				<br>
				Age: <?php echo htmlspecialchars($tabuser['age']); ?>
				<br>
				Pseudo : <?php echo htmlspecialchars($tabuser['pseudo']); ?>
				<br>
				Email: <?php echo htmlspecialchars($tabuser['email']); ?>
				<br>	
			
				<br>
				<div class = "editer">
					<a href="editionprofil.php" >Editer mon profil</a> 
				</div>
				<br>
				<div class = "suppression">
					<a href="suppressioncompte.php">Supprimer mon compte</a>
				</div>
				<br>
				<br>
			    <div class = "admin">
					<?php if($_SESSION['admin']==1){ ?>
						<a href="admin.php"> Administration</a>
					<?php } ?>
				</div>
			</div>
			<div class = "reseau">
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
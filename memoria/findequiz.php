<?php 
session_start(); 
require_once("fonctions.php");

$connex = connexion_bd();
no_session();

$total = $_SESSION['total'];
unset($_SESSION['total']);

$score = $_SESSION['score'];
unset($_SESSION['score']) ;

unset($_SESSION['tab']);
unset($_SESSION['bonneRep']);

mysqli_close($connex);
?>
<!DOCTYPE html>
	<html lang ="fr">
	<head>
		<meta charset ="utf-8">
		<link rel="stylesheet" type="text/css" href="css/findequiz.css">
		<title> Memoria-quiz </title>
	</head>
	<body >
		<div class ="accueil">
		 <a href="Accueil.php"> Accueil</a>
		</div>
		<div class = "ecriture" align="center">
			<h2>Tu as fini !!</h2> <br><br>
			<p> Score final:<?php echo $score?>/<?php echo $total ?></p>
			<?php if($score == $total){ ?>
				<p>Tu as repondu correctement à toutes les question!! BRAVO tu peux maintenant faire les autres jeux pour en apprendre davantage.</p>
				<p>Refais ce jeu régulièrement pour garder tes connaissances au frais</p> <br>
			<?php }else if($score == ($total/2)){ ?>
				<p> Tu as pile  la moyenne. Entraine-toi pour augmenter ton score . </p>
			<?php }else if($score < ($total/2)){ ?>
				<p> Aie ! c'est pas un très bon score. Entraine-toi pour augmenter ton score . </p>
			<?php }else{ ?>
				<p> C'est pas mal ! Entraine-toi pour augmenter ton score .</p>
			<?php }?>
			<div class = "cartes">
			 <a href="menucartes.php"> cartes memoires</a>
			</div>
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
		<footer>
			<h5>
			Ce site a été créé par MIKIA Benidy et NODIN Aurélie dans le cadre d'un projet en L1 informatique.
			</h5>
		</footer>		
	</body>
	</html>
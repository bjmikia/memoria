<?php
session_start();
require_once("fonctions.php");

$connex = connexion_bd();
no_session();

//si l'utilisateur ne valide pas son paquet on unset les variables utilisées pour qu'il puisse quand même faire un aute paquet
if(isset($_SESSION['id_paquet'])){
unset($_SESSION['id_paquet']);
}

if(isset($_SESSION['paquet'])){
unset($_SESSION['paquet']);
}
if(isset($_SESSION['toAdmin'])){
unset($_SESSION['toAdmin']);
}
mysqli_close($connex);	
?>
<!DOCTYPE html>
<html lang ="fr">
<head>
	<title>Memoria-Accueil</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/accueil.css">
</head>
<body>

	<h1>
		~Memoria~ 
	</h1>
	<div id="content">
		<div class = "compte">
		<nav class = "compte">
			<ul>
				<li>
					<a href = "profil.php">Mon compte </a>
				</li>
			</ul>
		</nav>
	</div>
	<div class="deco">
		<nav class = "deco">
			<ul>
				<li>
				 	<a href="deconnexion.php">Déconnexion</a>
				</li>
			</ul>
		</nav>
	</div>
	
	<div class = "carte">
			<nav class = "cartes2">
				<ul>
					<li>
						<a href = "menucartes.php">Cartes mémoires </a>
					</li>
				</ul>
			</nav>
			<p>
				<span><img src = "img/image1.3" width ="300" height="300" alt = "image"></span>
				<span>
					Ici se trouve tes propres paquets de cartes mémoires crées mais aussi des paquets déjà générés par nous, les créateurs du site et également ceux des autres utilisateurs du site ! Bien sûr, tu pourras supprimer des cartes d'un paquet que tu as créé ou carrément supprimer ton paquet créé.<br>
				</span>			
		</p>
	</div>
	<div class = "contact">
			<nav class="contact2">
				<ul>
					<li>
						<a href ="contact.php">A Propos/Contact </a>
					</li>
				</ul>
			</nav>
			<p>
			
			<span>
			 Une question ? Une bug à signaler ? Un problème ? C'est ici que ça se passe ! Nous répondrons à tes questions mais pense à regarder la mini FAQ présente pour savoir si ta question ne s'y trouve pas.<br>
			</span>
			<span><img src = "img/image0.1" width ="300" height="300" alt= "image"></span>
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
	<footer>
		<h5>
			Ce site a été créé par MIKIA Benidy et NODIN Aurélie dans le cadre d'un projet en L1 informatique.
		</h5>
	</footer>
</div>
</body>
</html>
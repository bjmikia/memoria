<?php
session_start();
require_once("fonctions.php");

$connex = connexion_bd();
no_session();

// on récupère chaque paquet pour les afficher
$req = "SELECT * FROM paquets WHERE id_user=".$_SESSION['id']."";
$ligne = mysqli_query($connex, $req);
if (! $ligne) {
	page_erreur(ERR_REQUETE,mysqli_error($connex),$connex);  
}

$req = "SELECT * FROM paquets WHERE id_user !=".$_SESSION['id']."";
$ligne_p = mysqli_query($connex, $req);
if (! $ligne) {
	page_erreur(ERR_REQUETE,mysqli_error($connex),$connex);  
}

//si l'utilisateur ne valide pas son paquet on unset les variables utilisées pour qu'il puisse quand même faire un aute paquet
if(isset($_SESSION['id_paquet'])){
unset($_SESSION['id_paquet']);
}

if(isset($_SESSION['paquet'])){
unset($_SESSION['paquet']);
}

mysqli_close($connex);	
?>

<!DOCTYPE html>
	<html lang="fr">
	<head>
		<title>Memoria-Cartes memoires</title>
		<link rel="stylesheet" type="text/css" href="css/menucartes.css">
		<meta charset="utf-8">

	</head>
	<body>
		<div id="content">
			<div class = "accueil">
				<a href = "Accueil.php">Accueil </a>
			</div>
			<div class="deco">
				<a href="deconnexion.php">Deconnexion</a>
			</div>
			<div class="Mes_Paquets">
				<h1>Mes paquets</h1>
				<?php while($resultat = mysqli_fetch_assoc($ligne)){ ?>
					<div class="paquet">
						<a href="preqcm.php?n=<?php echo htmlspecialchars($resultat['id']);?>"><h2> <?php echo htmlspecialchars($resultat['nom']); ?></h2></a>
					</div>
					<br>
					<br>
					<div class="modifier">
						<a href="editionpaquet.php?p=<?php echo $resultat['id'] ?>">Modifier</a>
					</div>
					<br>
					<br>
					<br>
				<?php } ?>
				<div class="modifier">
					<a href="ajoutercartes.php">Créer mon paquet de cartes</a>
				</div> 
			</div>
			<div class="Autres_Paquets">

				<h1>Autres Paquets</h1>		
				<?php while($res = mysqli_fetch_assoc($ligne_p)){ ?>
					<div class="paquet">
						<a href="preqcm.php?n=<?php echo htmlspecialchars($res['id']);?>"><h2> <?php echo htmlspecialchars($res['nom']); ?></h2></a>
					</div>
				<?php } ?>
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
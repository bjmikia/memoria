<?php
session_start(); 
require_once("fonctions.php");

$connex = connexion_bd();
no_session();

$numero =(int)$_GET['p'];

 if(isset($_GET['id'])){
	 $question =(int)$_GET['id'];
 }

$req = "SELECT * FROM paquets WHERE id =".$numero."";
$ligne = mysqli_query($connex, $req);
			if (! $ligne) {
				page_erreur(ERR_REQUETE,mysqli_error($connex),$connex); 
			}
$res = mysqli_fetch_assoc($ligne);

$req = "SELECT * FROM cartes_questions WHERE id_paquet=".$numero."";
$ligne_question = mysqli_query($connex, $req);
			if (! $ligne_question) {
				page_erreur(ERR_REQUETE,mysqli_error($connex),$connex); 
			}
mysqli_close($connex);	
?>
	<!--============================================================= partie HTML =======================================================================-->
<!DOCTYPE html>
	<html lang ="fr">
	<head>
		<meta charset ="utf-8">
		<link rel="stylesheet" type="text/css" href="css/editionpaquet.css">
		<title >Memoria-Mon Paquet</title>
	</head>
	<body >
		<h1><?php echo $res['nom'] ?> </h1>
		<div class="accueil">
			<a href="Accueil.php">Accueil</a>
		</div>
		<div class="retour">
			<a href="menucartes.php">Retour</a>
		</div>
		<div class="content">
			<?php while($tab = mysqli_fetch_assoc($ligne_question)){ ?>
				<li><?=htmlspecialchars($tab['question']) ?> - <a href="editioncarte.php?p=<?php echo $numero ?>&id=<?=htmlspecialchars($tab['id']) ?>">   modifier</a>-<a href="suppressioncarte.php?id=<?php echo htmlspecialchars( $tab['id']) ?>&p=<?php echo $numero ?>">   supprimer</a></li>
			<?php }?>
			<br>
			<br>
			<div class="add">
				<a href="creationcartes.php?p=<?php echo $numero?>">ajouter une carte</a> <br> <br> <br>
				<a href="suppressionpaquet.php?p=<?php echo $numero ?>">supprimer ce paquet</a>
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
<?php 
session_start();
require_once("fonctions.php");

$connex = connexion_bd();
no_session();
$tabuser = affiche_user($connex); 

$numero = (int)$_GET['p'];
$question_id =(int) $_GET['id'];
if(isset($_POST['annuler'])){
	if($_SESSION['toAdmin'] == 1 ){
			header("Location:admin.php?");
		}else{
			header("Location:editionpaquet.php?p=".$numero);
		}			
}

if(isset($_POST['supprimer'])){
	$reqsup = "DELETE FROM cartes_questions WHERE id=".$question_id."";
	$ligne = mysqli_query($connex, $reqsup);
	if (! $ligne) {
		page_erreur(ERR_REQUETE,mysqli_error($connex),$connex); 
	}
	if($_SESSION['toAdmin'] == 1 ){
				header("Location:admin.php?");
			}else{
				header("Location:editionpaquet.php?p=".$numero);
			}	
}	
		
mysqli_close($connex);	
?>
<!DOCTYPE html>
	<html lang ="fr">
	<head>
		<meta charset ="utf-8">
		<title >Memoria-Supprimer ma carte </title>
		<link rel="stylesheet" type="text/css" href="css/supprimer.css">
	</head>
	<body>
		<div class ="supp">
			<p>Es-tu sûr(e) de vouloir supprimer cette carte ? Cette action est irréversible.</p>
			<form method="post" action="suppressioncarte.php?id=<?php echo $question_id ?>&p=<?php echo $numero?>">
				<input type="submit" name="annuler" value="annuler">
				<input type="submit" name="supprimer" value="supprimer la carte">
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
		<footer>
			<h5>
				Ce site a été créé par MIKIA Benidy et NODIN Aurélie dans le cadre d'un projet en L1 informatique.
			</h5>
		</footer>
	</body>
	</html>
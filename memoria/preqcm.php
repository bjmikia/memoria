<?php
session_start(); 
require_once("fonctions.php");

$connex = connexion_bd();
no_session();

//si l'utilisateur n'a pas termier un paquet cela permet de remettre le score à 0
if(isset($_SESSION['score'])){
unset($_SESSION['score']) ;
}

if(isset ($_SESSION['bonneRep'])){
 unset($_SESSION['bonneRep']);
}
 
$question_paquet =(int)$_GET['n'];

$req = "SELECT * FROM paquets WHERE id =".$question_paquet."";
$ligne = mysqli_query($connex, $req);

	if (! $ligne) {
		page_erreur(ERR_REQUETE,mysqli_error($connex),$connex); 
	}
			
$res = mysqli_fetch_assoc($ligne);
mysqli_free_result($ligne);

$req = "SELECT * FROM cartes_questions WHERE id_paquet=".$question_paquet."";
$ligne_question = mysqli_query($connex, $req);

	if (! $ligne_question) {
		page_erreur(ERR_REQUETE,mysqli_error($connex),$connex); 
	}
			
$_SESSION['total'] = mysqli_num_rows($ligne_question);

$tab = array();
$i=1;

while($resultat = mysqli_fetch_assoc($ligne_question)){
	$tab[$i]= $resultat['question'];
	$i++;	
}
	
$_SESSION['tab'] = $tab;	
$i= 1;
	
mysqli_close($connex);	
?>


<!DOCTYPE html>
	<html lang ="fr">
	<head>
		<meta charset ="utf-8">
		<title ><?php echo $res['nom'];?> </title>
		<link rel="stylesheet" type="text/css" href="css/preqcm.css">
	</head>
	<body >
		<div class = "ecriture" align="center">
			<h2><U><?php echo $res['nom'];?></U></h2><br><br>
			<p>Entraîne-toi pour enrichir tes connaissances</p>
			<p>Les questions posées peuvent avoir plusieurs réponses</p>
			<p>Nombres de questions: <?php echo $_SESSION['total'] ;?> </p>
		
			<div class ="commencer">
		 		<a href="questions.php?n=<?php echo $i ;?>&p=<?php echo $question_paquet ;?>">Commencer</a>
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
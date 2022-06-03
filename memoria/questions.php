<?php
session_start();
require_once("fonctions.php");

$connex = connexion_bd();
no_session();


//on recupère les varibles qui nous permettent de passer de page en page 
$num = (int)$_GET['n'];
$question_paquet = (int)$_GET['p'];
$question = $_SESSION['tab'][$num];
$next = $num+1;
$question = mysqli_real_escape_string($connex,$question);

// on récupère chaque question pour les afficher
$req = "SELECT * FROM cartes_questions WHERE question ='".$question."' AND id_paquet=".$question_paquet."";
$ligne_question = mysqli_query($connex, $req);

if (!$ligne_question) {
	page_erreur(ERR_REQUETE,mysqli_error($connex),$connex); 
}

$resultat_question = mysqli_fetch_assoc($ligne_question);
	
//on récupère chaque proposition pour les afficher
$req = "SELECT * FROM cartes_reponses WHERE id_question=".$resultat_question['id']."";
$ligne_reponse = mysqli_query($connex, $req);
if (! $ligne_reponse) {
	page_erreur(ERR_REQUETE,mysqli_error($connex),$connex); 
}

$req = "SELECT * FROM cartes_reponses WHERE id_question=".$resultat_question['id']." AND correct =1";
$ligne_correct = mysqli_query($connex, $req);
if (! $ligne_reponse) {
	page_erreur(ERR_REQUETE,mysqli_error($connex),$connex); 
}
$req = "SELECT explication FROM cartes_reponses WHERE id_question=".$resultat_question['id']." AND correct =1";
$correct = mysqli_query($connex, $req);
if (! $correct) {
	page_erreur(ERR_REQUETE,mysqli_error($connex),$connex); 
}

$res_correct = mysqli_fetch_assoc($correct);

mysqli_close($connex);	
?>

<!DOCTYPE html>
	<html lang ="fr">
	<head>
		<meta charset ="utf-8">
		<link rel="stylesheet" type="text/css" href="css/questions.css">
		<title >Memoria-Questions</title>
	</head>
	<body >
		<div class ="accueil">
			<a href = "Accueil.php">Accueil </a>
	    </div>
	    <?php if( !isset($_SESSION['isOk']) OR $_SESSION['isOk'] != 1){ ?>
			<h2><U><?php echo htmlspecialchars( $resultat_question['matiere'])?></U></h2> <br><br><br><br>
			<div class = "image">
				<img src = "img/front.png" width ="600" height="600" alt = "image">
			</div>
			<div class = "ecriture" >
				<div class = "question">
					<p><?php echo htmlspecialchars( $resultat_question['question']) ?></p>
				</div>
				<form method="post" action="verification.php?n=<?php echo $num ?>&p=<?php echo $question_paquet ;?>">
					<?php while($resultat_reponse = mysqli_fetch_assoc($ligne_reponse)){ ?>
						 <li> <input  type="checkbox" name="choix[]" value="<?php echo htmlspecialchars($resultat_reponse['id']); ?>" /><?php echo htmlspecialchars($resultat_reponse['proposition']); ?> </li>
					<?php }?>	
		<br>
		<br>
		<br>
		<br>
		<br>
		
				<input type="submit" value="valider" name="valider"/>
			</form>
		</div>

		<?php }else{ ?>
				<h2><?php echo htmlspecialchars( $resultat_question['matiere'])?></h2> <br><br>
				<div class = "image">
					<img src = "img/back.png" width ="600" height="600" alt = "image">
				</div>
				<div class = "ecriture2" >
					<?php if($_SESSION['bonneRep'] == 1) { ?>
						<h3> Bonne réponse !</h3>
					<?php }else{ ?>
						<h3>Mauvaise réponse !</h3>
					<?php } ?>
				
					<?php while($resultat_correct = mysqli_fetch_assoc($ligne_correct)){ ?>
						<?php echo $resultat_correct['proposition'] ?><br>
					<?php } ?>
				<br>
					<?php echo $res_correct['explication'] ?>
			<br>
			<br>
			<br>
			<br>
			<br>
			<br>
					<?php if($_SESSION['total']== $num) { ?>
						<div class = "suivant1">
							<a href="findequiz.php"> Terminer le quizz </a>
						</div>
					<?php }else{ ?>
						<div class = "suivant2">
							<a href="questions.php?n=<?php echo $next?>&p=<?php echo $question_paquet ;?>"> Question suivante </a>
						</div>
					<?php } ?>
			<?php }?>
			<?php $_SESSION['isOk']= 0; ?>	
			<?php $_SESSION['bonneRep']=0;?>
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
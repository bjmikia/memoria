<?php
session_start();
require_once("fonctions.php");

$connex = connexion_bd();
no_session();	

$requser = "SELECT * FROM user WHERE admin = 0";
$ligne = mysqli_query($connex, $requser);
if (! $ligne) {
	page_erreur(ERR_REQUETE,mysqli_error($connex),$connex);
}

$req = "SELECT * FROM paquets";
$ligne_p = mysqli_query($connex, $req);
if (! $ligne_p) {
	page_erreur(ERR_REQUETE,mysqli_error($connex),$connex);  
}


if(isset($_GET['id'])){
	$member = intval($_GET['id']);
	
	$reqmember = "SELECT * FROM user WHERE id=".$member.""; 

	$lignemember = mysqli_query($connex, $reqmember);
	if (! $lignemember) {
		page_erreur(ERR_REQUETE,mysqli_error($connex),$connex); 
	}
	
	$tabmember = mysqli_fetch_assoc($lignemember);
		
}	
if(isset($_GET['p'])){
	$paquet =  intval($_GET['p']);
	$req = "SELECT * FROM cartes_questions WHERE id_paquet=".$paquet.""; 

	$ligne_q = mysqli_query($connex, $req);
	if (! $ligne_q) {
		page_erreur(ERR_REQUETE,mysqli_error($connex),$connex); 
	}
}
	
if(isset($_GET['pseudo'])){
	$pseudo = $_GET['pseudo'];
	$req = "DELETE FROM user WHERE pseudo='".$pseudo."'"; 

	$ligne_ps = mysqli_query($connex, $req);
	if (! $ligne_ps) {
		page_erreur(ERR_REQUETE,mysqli_error($connex),$connex); 
	}
	header("Location: admin.php" );
}	

mysqli_close($connex);			
?>	
	<!--============================================================= partie HTML =======================================================================-->
<!DOCTYPE html>
	<html lang ="fr">
	<head>
		<meta charset ="utf-8">
		<title > espace admin </title>
		<link rel="stylesheet" type="text/css" href="css/admin.css">
	</head>
	<body >
		<div class="accueil">
			<a href="Accueil.php"> Accueil</a>
		</div>
		<div class="Administration">
		<?php if($_SESSION['admin']==1){ ?>
			<h1><U> Administration</U></h1>
			<ul>
				<?php while($tab = mysqli_fetch_assoc($ligne)){ ?>
				<li><?=htmlspecialchars( $tab['pseudo']) ?> - <?= htmlspecialchars($tab['email']) ?> - <a href="admin.php?id=<?=htmlspecialchars($tab['id']) ?>">Gérer</a></li>
				<?php }?>
			</ul>
			
			<?php if(isset($member)){ ?>
				<h3>Gérer : <?= htmlspecialchars($tabmember['pseudo']) ?></h3>
				 <p>nom:<?php echo htmlspecialchars($tabmember['nom'])?> </p>
				  <p>prenom:<?php echo htmlspecialchars($tabmember['prenom'])?></p>
				  <p>age:<?php echo htmlspecialchars($tabmember['age'])?> </p>
				  <p>email:<?php echo htmlspecialchars($tabmember['email'])?> </p>
					 
					<font color="red"><h2> ATTENTION CETTE ACTION EST DEFINITIVE  !!!!</h2>
					<a href="admin.php?pseudo=<?php echo $tabmember['pseudo']?>"> Supprimer ce compte </a></font>
				
			<?php } ?>
		</div>
		<div class="Paquets">
			 <h1><U>paquet de cartes</U> </h1>
			 <ul>
				<?php while($res = mysqli_fetch_assoc($ligne_p)){ ?>
				<li><?= htmlspecialchars($res['nom']) ?> - <a href="admin.php?p=<?=htmlspecialchars($res['id']) ?>">modifier</a></li>
				<?php }?>
			</ul>
			<?php if(isset($paquet)){ ?>
				<h2> Questions:</h2>
				<ul>
				<?php while($question = mysqli_fetch_assoc($ligne_q)){ ?>
					<li><?=htmlspecialchars($question['question']) ?> - <a href="editioncarte.php?p=<?php echo $paquet ?>&id=<?=htmlspecialchars($question['id']) ?>">modifier</a>-<a href="suppressioncarte.php?id=<?php echo htmlspecialchars( $question['id']) ?>&p=<?php echo $paquet ?>">supprimer</a></li>
				<?php }?>
				</ul>
				<br> <br> <br>
				<div class="supprimer">
				<a href="suppressionpaquet.php?p=<?php echo $paquet?>">supprimer ce paquet</a>
			</div>
				<?php $_SESSION['toAdmin']=1; ?>
			<?php } ?>
		</div>
		<?php }else{?>
			<div class="what">
		<p> Tu n'es pas censé(e) être ici :) </p>
		<?php }?>
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
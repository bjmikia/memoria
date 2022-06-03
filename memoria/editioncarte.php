<?php
session_start();
require_once("fonctions.php");

$connex = connexion_bd();
no_session();

$numero = $_GET['p'];
$id_question = $_GET['id'];

////***** afficher les données dans le formulaire
$req = "SELECT * FROM cartes_reponses WHERE id_question =".$id_question."";
$ligneq = mysqli_query($connex,$req);

if (! $ligneq){
		page_erreur(ERR_REQUETE,mysqli_error($connex),$connex); 
	}
	
$reponse = array();
$choix =array();
$id_reponses = array();
$i=1;
while($resultat = mysqli_fetch_assoc($ligneq)){
	$reponse[$i] = $resultat['proposition'];
	$choix[$i] = $resultat['correct'];
	$id_reponses[$i] = $resultat['id'];
	$i++;
}
	
$req = "SELECT explication FROM cartes_reponses WHERE id_question =".$id_question." AND correct = 1";
$ligne = mysqli_query($connex,$req);

if (! $ligne){
		page_erreur(ERR_REQUETE,mysqli_error($connex),$connex); 
	}
	
$resultat_exp = mysqli_fetch_assoc($ligne);	


$req = "SELECT * FROM cartes_questions WHERE id =".$id_question."";
$ligne = mysqli_query($connex,$req);

if (! $ligne){
		page_erreur(ERR_REQUETE,mysqli_error($connex),$connex); 
	}
$res = mysqli_fetch_assoc($ligne);

//////***********	
				
if(isset($_POST['newmatiere']) AND !empty($_POST['newmatiere']) AND $_POST['newmatiere'] != $res['matiere']){
	
	$newmatiere = mysqli_real_escape_string($connex,$_POST['newmatiere']);
	
	$reqmatiere = "UPDATE cartes_questions SET matiere = '".$newmatiere."' WHERE id=".$id_question."";
	$ligne = mysqli_query($connex, $reqmatiere);
		
	if (! $ligne){
		page_erreur(ERR_REQUETE,mysqli_error($connex),$connex);
	}
	
	if($_SESSION['toAdmin'] == 1 ){
				header("Location:admin.php?");
			}else{
				header("Location:editionpaquet.php?p=".$numero);
			}
}
		
if(isset($_POST['newquestion']) AND !empty($_POST['newquestion']) AND $_POST['newquestion'] != $res['question']){
	
	$newquestion = mysqli_real_escape_string($connex,$_POST['newquestion']);
	
	$reqquestion= "UPDATE cartes_questions SET question = '".$newquestion."' WHERE id=".$id_question.""; 
	$ligne = mysqli_query($connex, $reqquestion);
		
	if (! $ligne){
		page_erreur(ERR_REQUETE,mysqli_error($connex),$connex);
	}
	
	if($_SESSION['toAdmin'] == 1 ){
				header("Location:admin.php?");
			}else{
				header("Location:editionpaquet.php?p=".$numero);
			}		
}
if (isset($_POST['modifier_carte'])){
	
	if (isset($_POST['newchoix1'])AND empty($_POST['newchoix1']) AND isset($id_reponses[1])){
		$reponse1 = $id_reponses[1];
		$req = "DELETE FROM cartes_reponses WHERE id =".$reponse1."";
		$ligner = mysqli_query($connex,$req);

		if (! $ligner){
				page_erreur(ERR_REQUETE,mysqli_error($connex),$connex); 
		}			
	}

	if (isset($_POST['newchoix2'])AND empty($_POST['newchoix2']) AND isset($id_reponses[2])){
		$reponse2 = $id_reponses[2];	
		$req = "DELETE FROM cartes_reponses WHERE id =".$reponse2."";
		$ligner = mysqli_query($connex,$req);

		if (! $ligner){
				page_erreur(ERR_REQUETE,mysqli_error($connex),$connex); 
		}		
	}

	if (isset($_POST['newchoix3'])AND empty($_POST['newchoix3']) AND isset($id_reponses[3])){
		$reponse3 = $id_reponses[3];	
		$req = "DELETE FROM cartes_reponses WHERE id =".$reponse3."";
		$ligner = mysqli_query($connex,$req);

		if (! $ligner){
				page_erreur(ERR_REQUETE,mysqli_error($connex),$connex); 
		}		
	}

	if (isset($_POST['newchoix4'])AND empty($_POST['newchoix4'])AND isset($id_reponses[4])){
		$reponse4 = $id_reponses[4];	
		$req = "DELETE FROM cartes_reponses WHERE id =".$reponse4."";
		$ligner = mysqli_query($connex,$req);

		if (! $ligner){
				page_erreur(ERR_REQUETE,mysqli_error($connex),$connex); 
		}		
	}
}
	
	if((isset($_POST['newchoix1']) AND $_POST['newchoix1'] != $reponse[1]) OR (isset($_POST['c1'])AND !empty($_POST['newchoix1'])) ){
		$newchoix1 = mysqli_real_escape_string($connex,$_POST['newchoix1']);
		$tmp=0;
	
		for($i=0;$i<count($_POST['c1']);$i++){
		
			if(1 == intval($_POST['c1'][$i])){
				$tmp++; 
			}
		}
		
		if($tmp == 1){
			$newcorrect = 1;
		}else{
			$newcorrect = 0;
		}
		
		if(isset($id_reponses[1])){	
			if(isset($_POST['c1'])){
				
				
				$reqchoix1= "UPDATE cartes_reponses SET correct=".$newcorrect." WHERE id=".$id_reponses[1]." AND id_question=".$id_question."";
				$ligne = mysqli_query($connex, $reqchoix1);
				
				if (! $ligne){
					page_erreur(ERR_REQUETE,mysqli_error($connex),$connex);
				}
			}
			
			if (isset($_POST['newchoix1']) AND $_POST['newchoix1'] != $reponse[1]){
				
				$reqchoix1= "UPDATE cartes_reponses SET proposition = '".$newchoix1."' WHERE id=".$id_reponses[1]." AND id_question=".$id_question."";
				$ligne = mysqli_query($connex, $reqchoix1);
				
				if (! $ligne){
					page_erreur(ERR_REQUETE,mysqli_error($connex),$connex);
				}		
			}
		}else{
			$req = "INSERT INTO cartes_reponses (id_question,correct,proposition) VALUES (".$id_question.",".$newcorrect.",'".$newchoix1."')";
				$ligne = mysqli_query($connex, $req);
				
				if (! $ligne) {
					page_erreur(ERR_REQUETE,mysqli_error($connex),$connex); 
				}
			
		}
		if($_SESSION['toAdmin'] == 1 ){
			header("Location:admin.php?");
		}else{
			header("Location:editionpaquet.php?p=".$numero);
		}	
	}
	if((isset($_POST['newchoix2']) AND $_POST['newchoix2'] != $reponse[2]) OR (isset($_POST['c1'])AND !empty($_POST['newchoix2']) ) ){
		$newchoix2 = mysqli_real_escape_string($connex,$_POST['newchoix2']);
		$tmp=0;
	
		for($i=0;$i<count($_POST['c1']);$i++){
		
			if(2 == intval($_POST['c1'][$i])){
				$tmp++; 
			}
		
		}
		
		if($tmp == 1){
			$newcorrect = 1;
		}else{
			$newcorrect = 0;
		}
		
		if(isset($id_reponses[2])){	
			if(isset($_POST['c1'])){
				
				
				$reqchoix2= "UPDATE cartes_reponses SET correct=".$newcorrect." WHERE id=".$id_reponses[2]." AND id_question=".$id_question."";
				$ligne = mysqli_query($connex, $reqchoix2);
				
				if (! $ligne){
					page_erreur(ERR_REQUETE,mysqli_error($connex),$connex);
				}	
			}
			
			if (isset($_POST['newchoix2'])AND !empty($_POST['newchoix2'])  AND $_POST['newchoix2'] != $reponse[2]){
				
				$reqchoix2= "UPDATE cartes_reponses SET proposition = '".$newchoix2."' WHERE id=".$id_reponses[2]." AND id_question=".$id_question."";
				$ligne = mysqli_query($connex, $reqchoix2);
				
				if (! $ligne){
					page_erreur(ERR_REQUETE,mysqli_error($connex),$connex);
				}	
			}
		}else{
			$req = "INSERT INTO cartes_reponses (id_question,correct,proposition) VALUES (".$id_question.",".$newcorrect.",'".$newchoix2."')";
				$ligne = mysqli_query($connex, $req);
				
				if (! $ligne) {
					page_erreur(ERR_REQUETE,mysqli_error($connex),$connex); 
				}
		}
		if($_SESSION['toAdmin'] == 1 ){
			header("Location:admin.php?");
		}else{
			header("Location:editionpaquet.php?p=".$numero);
		}
	}
	
	if((isset($_POST['newchoix3'])  AND $_POST['newchoix3'] != $reponse[3]) OR (isset($_POST['c1'])AND !empty($_POST['newchoix3']) ) ){
		$newchoix3 = mysqli_real_escape_string($connex,$_POST['newchoix3']);
		$tmp=0;
	
		for($i=0;$i<count($_POST['c1']);$i++){
		
			if(3 == intval($_POST['c1'][$i])){
				$tmp++; 
			}
		}
		
		if($tmp == 1){
			$newcorrect = 1;
		}else{
			$newcorrect = 0;
		}
		
		if(isset($id_reponses[3])){	
			if(isset($_POST['c1'])){
				
				
				$reqchoix3= "UPDATE cartes_reponses SET correct=".$newcorrect." WHERE id=".$id_reponses[3]." AND id_question=".$id_question."";
				$ligne = mysqli_query($connex, $reqchoix3);
				
				if (! $ligne){
					page_erreur(ERR_REQUETE,mysqli_error($connex),$connex);
				}

			}
			
			if (isset($_POST['newchoix3'])AND !empty($_POST['newchoix3'])  AND $_POST['newchoix3'] != $reponse[3]){
				
				$reqchoix3= "UPDATE cartes_reponses SET proposition = '".$newchoix3."' WHERE id=".$id_reponses[3]." AND id_question=".$id_question."";
				$ligne = mysqli_query($connex, $reqchoix3);
				
				if (! $ligne){
					page_erreur(ERR_REQUETE,mysqli_error($connex),$connex);
				}
					
			}
		}else{
			$req = "INSERT INTO cartes_reponses (id_question,correct,proposition) VALUES (".$id_question.",".$newcorrect.",'".$newchoix3."')";
				$ligne = mysqli_query($connex, $req);
				
				if (! $ligne) {
					page_erreur(ERR_REQUETE,mysqli_error($connex),$connex); 
				}
		}
		if($_SESSION['toAdmin'] == 1 ){
			header("Location:admin.php?");
		}else{
			header("Location:editionpaquet.php?p=".$numero);
		}
	}
	
	if((isset($_POST['newchoix4']) AND $_POST['newchoix4'] != $reponse[4]) OR (isset($_POST['c1'])AND !empty($_POST['newchoix4']) ) ){
		$newchoix4 = mysqli_real_escape_string($connex,$_POST['newchoix4']);
		$tmp=0;
	
		for($i=0;$i<count($_POST['c1']);$i++){
		
			if(4 == intval($_POST['c1'][$i])){
				$tmp++; 
			}
		}
		
		if($tmp == 1){
			$newcorrect = 1;
		}else{
			$newcorrect = 0;
		}
		
		if(isset($id_reponses[4])){	
			if(isset($_POST['c1'])){
				
				
				$reqchoix4= "UPDATE cartes_reponses SET correct=".$newcorrect." WHERE id=".$id_reponses[4]." AND id_question=".$id_question."";
				$ligne = mysqli_query($connex, $reqchoix1);
				
				if (! $ligne){
					page_erreur(ERR_REQUETE,mysqli_error($connex),$connex);
				}
			}
			
			if (isset($_POST['newchoix4'])AND !empty($_POST['newchoix4'])  AND $_POST['newchoix4'] != $reponse[4]){
				
				$reqchoix4= "UPDATE cartes_reponses SET proposition = '".$newchoix4."' WHERE id=".$id_reponses[4]." AND id_question=".$id_question."";
				$ligne = mysqli_query($connex, $reqchoix4);
				
				if (! $ligne){
					page_erreur(ERR_REQUETE,mysqli_error($connex),$connex);
				}
					
			}
		}else{
			$req = "INSERT INTO cartes_reponses (id_question,correct,proposition) VALUES (".$id_question.",".$newcorrect.",'".$newchoix4."')";
				$ligne = mysqli_query($connex, $req);
				
				if (! $ligne) {
					page_erreur(ERR_REQUETE,mysqli_error($connex),$connex); 
				}
		}
		
		if($_SESSION['toAdmin'] == 1 ){
			header("Location:admin.php?");
		}else{
			header("Location:editionpaquet.php?p=".$numero);
		}
	}

	
	if( isset($_POST['newexplication'])AND !empty($_POST['newexplication'])){
		$newexplication = mysqli_real_escape_string($connex,$_POST['newexplication']);

		$req = "UPDATE cartes_reponses SET explication = '".$newexplication."' WHERE id_question=".$id_question." AND correct = 1";
		$ligne = mysqli_query($connex, $req);
		
		if (! $ligne) {
			page_erreur(ERR_REQUETE,mysqli_error($connex),$connex); 
		}
							
		if($_SESSION['admin'] == 1 ){
			header("Location:admin.php?");
		}else{
			header("Location:editionpaquet.php?p=".$numero);
		}										
	}	
	
mysqli_close($connex);	
?>
<!--============================================================= partie HTML =======================================================================-->
<!DOCTYPE html>
	<html lang ="fr">
	<head>
		<meta charset ="utf-8">
		<title >Memoria-Editer une carte</title>
		<link rel="stylesheet" type="text/css" href="css/editioncarte.css">
	</head>
	<body >
		<h1>Editer une carte</h1>
	
		<div class ="accueil">
			<a href = "Accueil.php">Accueil </a>
		</div>
		<br>
		<div class = "retour">
			<a href = "editionpaquet.php?p=<?php echo $numero ?>">Retour</a>
		</div>
		<div class="debut">
			<p>Lorsque tu as fini cliques sur modifier la carte pour l'enregistrer.</p>
		</div>
		<div class="content">
		
					
			<div class="formulaire">
				<form method="post" action="editioncarte.php?p=<?php echo $numero?>&id=<?php echo $id_question?>">
				
					<p>
						<label> Matière </label><br>
						<input type="text" name="newmatiere"value="<?php echo $res['matiere']?>"/>
					</p>
					<p>
						<label>Question</label><br>
						<input type="text" name="newquestion" value="<?php echo $res['question']?>"/>
					</p>
					<p> Coches la/les proposition(s) correcte(s)</p>
					<div class ="proposition">
						<p>
							<label>Proposition 1</label><br>
							<input type="text" name="newchoix1" value="<?php if(isset($reponse[1]) AND !empty($reponse[1])) echo htmlspecialchars($reponse[1])?>"/><input  type="checkbox" name="c1[]" value="1" <?php if(isset($choix[1]) AND $choix[1]==1) echo 'checked'?>/> 
								
						</p>
						<p>
							<label>Proposition 2</label><br>
							<input type="text" name="newchoix2" value="<?php if(isset($reponse[2]) AND !empty($reponse[2])) echo htmlspecialchars($reponse[2])?>"/><input  type="checkbox" name="c1[]" value="2" <?php if(isset($choix[2]) AND $choix[2]==1) echo 'checked'?>/> 
						
						</p>
						<p>
							<label> Proposition 3</label><br>
							<input type="text" name="newchoix3" value="<?php if(isset($reponse[3]) AND !empty($reponse[3])) echo htmlspecialchars($reponse[3])?>"/><input  type="checkbox" name="c1[]" value="3" <?php if(isset($choix[3]) AND $choix[3]==1) echo 'checked'?>/> 
						</p>
						<p>
							<label>Proposition 4</label><br>
							<input type="text" name="newchoix4" value="<?php if(isset($reponse[4]) AND !empty($reponse[4])) echo htmlspecialchars($reponse[4])?>"/><input  type="checkbox" name="c1[]" value="4" <?php if(isset($choix[4]) AND $choix[4]==1) echo 'checked'?>/> 	
						</p>
					</div>
					<p>
						<div class="exp">
							<label> Explication </label><br>
							<input type="text"  name="explication" placeholder="facultatif" <?php if($resultat_exp['explication']!= NULL) echo htmlspecialchars($resultat_exp['explication'])?> />
						</div>
					</p>
					<div class="bouton">
					
						<input type="submit" name="modifier_carte"  value="modifier la carte" />
					</div>
				</form>	
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
			<div class ="image">
				<div class = "img">
					<img src = "img/book.png" width ="250" height="250" alt="school book">
				</div>
				<div class ="img2">		
					<img src = "img/school.png" width ="250" height="250" alt="school">
				</div>
				<div class ='img3'>
					<img src = "img/folder.png" width ="300" height="300" alt="school folder">
				</div>
				<div class ="img4">		
					<img src = "img/man.png" width ="400" height="250" alt="man">
				</div>
			</div>
			<footer>
				<h5>
					Ce site a été créé par MIKIA Benidy et NODIN Aurélie dans le cadre d'un projet en L1 informatique.
				</h5>
		</footer> 
	</body>
	</html>
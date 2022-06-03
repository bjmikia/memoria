<?php
session_start();
require_once("fonctions.php");

$connex = connexion_bd(); 

//création de la variable score qui comptera le nb de questions justes
if(!isset($_SESSION['score'])){
 $_SESSION['score'] = 0;
}

 if(!isset($_SESSION['bonneRep'])){
	$_SESSION['bonneRep'];
 }

//on recupère le n° de la question ainsi que les propositions choisis
if(isset($_POST['valider'])){
	
	if(empty($_POST['choix'])){
		header("Location:questions.php?n=".$_GET['n']."&p=".$_GET['p']);
	}
	
	
	$question_paquet = (int)$_GET['p'];
	$num =(int)$_GET['n'];
	
	$question = $_SESSION['tab'][$num];
	$question = mysqli_real_escape_string($connex,$question);
	$choix = $_POST['choix'];
	
	
	$req = "SELECT * FROM cartes_questions WHERE id_paquet = ".$question_paquet." AND question ='".$question."'";
	$ligne = mysqli_query($connex,$req);
	
	if (! $ligne) {
		page_erreur(ERR_REQUETE,mysqli_error($connex),$connex); 
	}
	$res = mysqli_fetch_assoc($ligne);
		
	
	//on récupère les ids dans la bd pour les mettre dans un tableau tab puis on compare les tableaux choix/tab	
	$req = "SELECT * FROM cartes_reponses WHERE id_question =".$res['id']." AND correct = 1";
	$ligne = mysqli_query($connex,$req);
	
	if (! $ligne) {
		page_erreur(ERR_REQUETE,mysqli_error($connex),$connex); 
	}

	$tableau=array();
	$i=0;
	while($resultat = mysqli_fetch_assoc($ligne)){
		$tableau[$i]= $resultat['id'];
		$i++;
	
	}
	
	
	if(count($choix) == count($tableau)){
		if(array_diff($choix,$tableau)== NULL){
			$_SESSION['score']++;
			$_SESSION['bonneRep']=1;
			header("Location: questions.php?n=".$num."&p=".$question_paquet);
		}else{
			header("Location: questions.php?n=".$num."&p=".$question_paquet);
		}
	}
	if(count($choix) < count($tab) OR count($choix) > count($tab) ){
		header("Location: questions.php?n=".$num."&p=".$question_paquet);
	}
//cette variable permet d'afficher les réponses  
 $_SESSION['isOk']=1;
}

mysqli_close($connex);	
?>
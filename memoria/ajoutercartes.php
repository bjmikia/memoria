<?php
session_start();
require_once("fonctions.php");

$connex = connexion_bd();
no_session();

if(isset($_POST['valider_paquet'])){
	header("Location:menucartes.php");
	
	unset($_SESSION['id_paquet']);
	unset($_SESSION['paquet']);
	
	mysqli_close($connex);
	exit;
}

if(isset($_POST['ajouter_carte'])){
	
	if(!isset($_SESSION['id_paquet'])){
	
			if(!empty($_POST['nom_paquet'])){
				$paquet = mysqli_real_escape_string($connex,$_POST['nom_paquet']);
				
				$req = "SELECT * FROM paquets WHERE nom ='".$paquet."'";
				$ligne = mysqli_query($connex, $req);
				
				if (! $ligne) {
					page_erreur(ERR_REQUETE,mysqli_error($connex),$connex);  
				}
				
				if(mysqli_num_rows($ligne) == 0){

					$req = "INSERT INTO paquets (nom,id_user) VALUES ('".$paquet."',".$_SESSION['id'].")";
					$ligne = mysqli_query($connex, $req);
					
					if (! $ligne) {
						page_erreur(ERR_REQUETE,mysqli_error($connex),$connex);
					}
					
					$req = "SELECT id FROM paquets WHERE nom ='".$paquet."'";
					$ligne = mysqli_query($connex, $req);
					
					if (! $ligne) {
						page_erreur(ERR_REQUETE,mysqli_error($connex),$connex);  
					}
					
					$id_paquet = mysqli_fetch_assoc($ligne);
				
					
					$_SESSION['id_paquet'] = $id_paquet['id'];
					$_SESSION['paquet']=$paquet;
					
								
			}else{
				$erreur=" Ce nom de paquet est déjà pris !! ";
			}
		}else{
				$erreur="Tu dois renseigner un nom de paquet !! ";
		}
	}


	
	if(!empty($_POST['matiere'] AND $_POST['question']) ){
		
			if(!empty($_POST['choix1']OR $_POST['choix2'] OR $_POST['choix3'] OR $_POST['choix4'] )){
				
				if(isset($_POST['c1'])){
					
					$matiere = mysqli_real_escape_string($connex,$_POST['matiere']);
					$question = mysqli_real_escape_string($connex,$_POST['question']);
					$choix1 = mysqli_real_escape_string($connex,$_POST['choix1']);
					$choix2 = mysqli_real_escape_string($connex,$_POST['choix2']);
					$choix3 = mysqli_real_escape_string($connex,$_POST['choix3']);
					$choix4 = mysqli_real_escape_string($connex,$_POST['choix4']);
			
					$choix = array();
					$choix[1] = $choix1;
					$choix[2] = $choix2;
					$choix[3] = $choix3;
					$choix[4] = $choix4;
					
					//on rentre la question et la matière
					$req="INSERT INTO cartes_questions(id_user,matiere,question,id_paquet) VALUES (".$_SESSION['id'].",'".$matiere."','".$question."',".$_SESSION['id_paquet'].")";
					$ligne = mysqli_query($connex, $req);
					
					if (! $ligne) {
						page_erreur(ERR_REQUETE,mysqli_error($connex),$connex); 
					}
					
					
					
					//on recupère l'id pour l'associer aux réponses	
					$req = "SELECT id FROM cartes_questions WHERE question='".$question."' AND id_paquet =".$_SESSION['id_paquet']."";
					$ligne = mysqli_query($connex, $req);
					
					if (! $ligne) {
						page_erreur(ERR_REQUETE,mysqli_error($connex),$connex);  
					}
					
					$id_question = mysqli_fetch_assoc($ligne);
					
					
					//on rentre les réponses
					foreach($choix as $choice => $valeur){
						
						if(!empty($valeur)){
							$tmp=0;
							
							for($i=0;$i<count($_POST['c1']);$i++){
								
								if($choice == intval($_POST['c1'][$i])){
									$tmp++; 
								}
							}
							
							if($tmp == 1){
								$correct = 1;
							}else{
								$correct = 0;
							}
							
							$req = "INSERT INTO cartes_reponses (id_question,correct,proposition) VALUES (".$id_question['id'].",".$correct.",'".$valeur."')";
								$ligne = mysqli_query($connex, $req);
								
								if (! $ligne) {
									page_erreur(ERR_REQUETE,mysqli_error($connex),$connex); 
								}	
						}
					}	
					
					if( isset($_POST['explication'])AND !empty($_POST['explication'])){
						$explication = mysqli_real_escape_string($connex,$_POST['explication']);
					
						$req = "UPDATE cartes_reponses SET explication = '".$explication."' WHERE id_question=".$id_question['id']." AND correct = 1";
						$ligne = mysqli_query($connex, $req);
						
						if (! $ligne) {
							page_erreur(ERR_REQUETE,mysqli_error($connex),$connex); 
						}
					}
					$message = "La question a bien été ajoutée ";
					header("refresh:4;url=ajoutercartes.php");
							
	
				}else{
					$erreur = " Tu dois cocher au moins une proposition";	
				}
			}else{
				$erreur="Tu dois donner au moins deux propositions de réponses";
			}
	}else{
		$erreur="Tu dois renseigner la matière et la question  ";
	}
}

mysqli_close($connex);	
?>
<!--============================================================= partie HTML =======================================================================-->
<!DOCTYPE html>
	<html lang ="fr">
	<head>
		<meta charset ="utf-8">
		<title >Memoria-Créer son jeu</title>
		<link rel="stylesheet" type="text/css" href="css/ajoutercartes.css">
	</head>
	<body >
		<h1>Créer une carte</h1>
		<br>
		<br>
		<p> Ajoutes autant de carte que tu veux, pour pouvoir le faire, remplis le formulaire puis clique sur ajouter un carte.</p>
		<p>Lorsque tu as fini cliques sur valider mon paquet pour l'enregistrer.</p>
		<div class ="accueil">
			<a href = "Accueil.php">Accueil </a>
		</div>
		<br>
		<div class = "retour">
			<a href = "menucartes.php">Retour</a>
		</div>
			<div class="content">
					<h2>Choisis un nom pour ton paquet de cartes mémoires </h2>
					<h2><U> il doit être unique </U></h2>
					<?php 
						if(isset($erreur)) echo'<h2><font color="red">'.$erreur."</font><h2>";
					?>
					<?php 
						if(isset($message)) echo'<h2><font color="green">'.$message."</font></h2>";
					?>
			<div class="formulaire">
				<form method="post" action="ajoutercartes.php">
					<p>
						<label> <h2>Nom du paquet : </label> </h2>
						<input type="text" name="nom_paquet" value="<?php if(isset($_SESSION['paquet'])) echo $_SESSION['paquet'] ?>" <?php if(isset($_SESSION['paquet'])) echo 'disabled' ?> />
					</p>
					<p>
						<label> Matière </label><br>
						<input type="text" name="matiere" />
					</p>
					<p>
						<label>Question</label><br>
						<input type="text" name="question" />
					</p>
					<p> Coches la/les proposition(s) correcte(s)</p>
					<div class ="proposition">
					<p>
						<label>Proposition 1</label><br>
						<input type="text" name="choix1" /><input  type="checkbox" name="c1[]" value="1" />
					</p>
					<p>
				
						<label>Proposition 2</label><br>
						<input type="text" name="choix2" /><input  type="checkbox" name="c1[]" value="2"/>
					</p>
					<p>
				
						<label> Proposition 3</label><br>
						<input type="text" name="choix3" /><input  type="checkbox" name="c1[]" value="3"/>
					</p>
					<p>
						<label>Proposition 4</label><br>
						<input type="text" name="choix4" /><input  type="checkbox" name="c1[]" value="4"/>
					</p>
				</div>
					<p>
						<label>Explication</label><br>
						<input type="text"  name="explication" placeholder="facultatif" />
					</p>
				</div>
					<div class="bouton">
				<input type="submit" name="valider_paquet"  value="Je valide mon paquet" />
				<input type="submit" name="ajouter_carte"  value="ajouter une carte" />
				
			</div>
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
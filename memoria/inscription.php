<?php
session_start();
require_once ("fonctions.php");

$connex = connexion_bd();
			
 if(isset($_POST['valider'])){
	 if(!empty($_POST['nom'] AND $_POST['prenom'] AND $_POST['age'] AND $_POST['pseudo'] AND  $_POST['mdp'] AND $_POST['mdp2'] AND $_POST['email'] )){
					
		//on securise chaque données entrées par l'utilisateur pour éviter de l'injection sql  
		$nom = mysqli_real_escape_string($connex,$_POST['nom']);
		$prenom = mysqli_real_escape_string($connex,$_POST['prenom']);
		$age = intval($_POST['age']);
		$mdp = mysqli_real_escape_string($connex,$_POST['mdp']);
		$mdp2 = mysqli_real_escape_string($connex,$_POST['mdp2']);
		$pseudo = mysqli_real_escape_string($connex,$_POST['pseudo']);
		$email = mysqli_real_escape_string($connex,$_POST['email']);
		
		

		//traitement de chaque variable du formulaire
		$nomlength = strlen($nom);
		if($nomlength <= 30){  //en soit vérifier la longueur du nom, prénom et pseudo ainsi que verifier l'age est inutile mais on a limité ces données dans la base 
			$prenomlength = strlen($prenom);
			
			if($prenomlength <= 30){
				
				if($age <= 100 AND $age >= 0){
					$pseudolength = strlen($pseudo);
					
					if($pseudolength <=30){
						$req="SELECT * FROM user WHERE pseudo ='".$pseudo."'";
						$ligne = mysqli_query($connex, $req);
						
						if (! $ligne) {
							page_erreur(ERR_REQUETE,mysqli_error($connex),$connex);  
						}
						
						if(mysqli_fetch_assoc($ligne) == 0){	//on recupere le resultat de la requete dans un tableau, si le tableau n'a pas de ligne cela veut dire qu'il n'y a pas d'utilisateur avec ce pseudo
								
							$mdplength = strlen($mdp);
							
							if($mdplength > 7){
								
								if( yes_maj($mdp)){
									
									if(yes_num($mdp)){
										
										if(verif_alphaNum($mdp)){
											
											if($mdp == $mdp2 ){
												$mdp = password_hash($mdp,PASSWORD_DEFAULT); //on "hache" les deux mots de passe même si on en rentre que un dans la base
												$mdp2 = password_hash($mdp2,PASSWORD_DEFAULT);
												
												if( filter_var($email,FILTER_VALIDATE_EMAIL)){
													$req="SELECT * FROM user WHERE email ='".$email."'";
													$ligne = mysqli_query($connex, $req);
													
													if (! $ligne) {
														page_erreur(ERR_REQUETE,mysqli_error($connex),$connex); 
													}
													
													if(mysqli_fetch_assoc($ligne) == 0){
															
														
														//si tout est bon on rentre les données dans la base de données et on redirige l'utilisateur vers l'accueil
														$reqinscrip = "INSERT INTO user(nom,prenom,age,pseudo,mdp,email,admin) VALUES ('".$nom."','".$prenom."',".$age.",'".$pseudo."','".$mdp."','".$email."',0)";
														$ligneinscrip = mysqli_query($connex, $reqinscrip);
														
														if (! $ligneinscrip) {
															page_erreur(ERR_REQUETE,mysqli_error($connex),$connex); 
														}
														
														
														$req ="select * from user where pseudo ='".$pseudo."'";
														$ligne = mysqli_query($connex, $req);
														
														if (! $ligne) {
															page_erreur(ERR_REQUETE,mysqli_error($connex));  
														}
														
														$tab = mysqli_fetch_assoc($ligne);
														
														$_SESSION['pseudo']= $tab['pseudo'];
														$_SESSION['id'] = $tab['id'];
														$_SESSION['admin'] = $tab['admin'];
														
														
														header("Location:profil.php?id=".$_SESSION['id']);
														
														mysqli_close($connex);
													}else{
														$erreur = "Cet email est déjà utilisé";
													}
												}else{
													$erreur = " Rentre un email valide!!";
												}
											}else{
											 $erreur = "Tes mots de passe ne correspondent pas !!";
											}
										}else{
											$erreur = "Ton mot de passe ne doit pas contenir de caractères spéciaux";
										}
									}else{
										$erreur = "Ton mot de passe doit contenir au moins un chiffre";
									}
								}else{
									$erreur = "Ton mot de passe doit contenir au moins une majuscule";
								}			
								}else{
									$erreur = "Ton mot de passe doit contenir au minimum 8 caractères alphanumériques ";
								}
							}else{
								$erreur = "Ce pseudo est déjà pris ";
							}
						}else{
							$erreur = "Ton pseudo ne doit pas dépasser 30 caractères";
						}
				}else{
					$erreur = "Tu  es trop vieux ... ou peut-être pas encore né ... en tout cas notre site est réservé au plus de 0 ans et au moins de 100 ans ;) "; // hihi
				}
			}else{
				$erreur = "Ton prénom ne doit pas dépasser 30 carectères !!";
			}
				
		}else{
			$erreur = "Ton nom ne peut pas dépasser 30 carectères!!";
		}
	}else{
		$erreur = "Tous les champs doivent être complétés !!";
	}
 }
?>
<!--============================================================= partie HTML =======================================================================-->
<!DOCTYPE html>
	<html lang ="fr">
	<head>
		<meta charset ="utf-8">
		<title >Memoria-Inscription</title>
		<link rel="stylesheet" type="text/css" href="css/inscription.css">
	</head>
	<body >
		<div id = "content" >
			<div class ="debut" >
				<p> Inscris-toi gratuitement !</p> <br><br/>
			</div>
			<div class="erreur">
			<?php 
			if(isset($erreur)) echo'<font color="red">'.$erreur."</font>";
			?>
			</div>
			<div  class="contenu" align="center" >
			<form method="POST" action="inscription.php" name="inscription">
						<p>
							<label>nom:</label> <br>
							<input type="text" placeholder=" entre ton nom"  name="nom" value="<?php if(isset($nom)){ echo $nom ;}?>"/> 
						</p>
						<p>
							<label>prénom:</label><br>
							<input type="text" placeholder=" entre ton prénom"  name="prenom" value="<?php if(isset($prenom)){ echo $prenom ;}?>"/>
						</p>
						<p>
							<label>âge:</label><br>
							<input type="number" name="age"  min="0" max="100" value="<?php if(isset($age)){ echo $age;}?>"/> <br><br>
						</p>
						<p>
							<label>pseudo:</label><br>
							<input type="text" placeholder="entre ton pseudo"  name="pseudo" value="<?php if(isset($pseudo)){ echo $pseudo;}?>"/> 
						</p>
						<p>
							<label>mot de passe:</label><br>
							<input type="password"  name="mdp" /> 
						</p>
						<p>
							<label>retape ton mot de passe:</label><br>
							 <input type="password" name="mdp2" />
						</p>
						<p>
							<label>email:</label><br>
							<input type="email" placeholder="entre ton email" name="email" value="<?php if(isset($email)){ echo $email;}?>" /> 
						</p>
				<div class ="bouton" >
					<input type="reset" value="réinisialiser" />
					<input type="submit" name="valider" value="Je m'inscris" />
				</div>
			</form>
		</div>
		<div class = "inscrit">
			<p>Déjà inscris ? <a href="connexion.php"> Connecte-toi ici</a> !</p>
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
			<img src = "img/book.png" width ="200" height="200" alt="school book">
		</div>
		<div class ="img2">		
			<img src = "img/school.png" width ="200" height="200" alt="school">
		</div>
		<div class ='img3'>
			<img src = "img/folder.png" width ="250" height="250" alt="school folder">
		</div>
		<div class ="img4">		
			<img src = "img/man.png" width ="350" height="200" alt="man">
		</div>
		</div>
		</div>
		<footer>
			<h5>
				Ce site a été créé par MIKIA Benidy et NODIN Aurélie dans le cadre d'un projet en L1 informatique.
			</h5>
	</footer> 
</body>
</html>
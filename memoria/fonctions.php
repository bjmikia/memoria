<?php
//connexion à la base de données
 function connexion_bd(){
	//********* modifiez cette partie*********// 
	 $serv = "127.0.0.1";
	 $nom ="root" ; 
	 $mdp ="" ;
	 $base = "memoria";
	 //**************************************//
	 $connex = new mysqli($serv,$nom,$mdp,$base);
	 if (! $connex) {
		page_erreur(ERR_CONNEXION,mysqli_connect_error($connex)); 
		exit; 
	 }
	 return $connex;
			
 }
 //vérifie si une session est en cours
  function no_session(){
	 if(!isset($_SESSION['id'])) {
		header("Location: connexion.php");
		exit;
	 }
	
 }
 //récupère les données d'un utilisateur si besoin
 function affiche_user($connexion_bd){
	$sessionid = $_SESSION['id'];
	$requser="SELECT * FROM user WHERE id =".$sessionid."";
	$ligneuser = mysqli_query($connexion_bd,$requser);
	
	if (! $ligneuser) {
		page_erreur(ERR_REQUETE,mysqli_error($connexion_bd),$connexion_bd); 
		exit; 
	}
	$tabuser =  mysqli_fetch_assoc($ligneuser);
	
	return $tabuser;
 }
 
 
 //affiche les erreurs
 define('ERR_CONNEXION',0);
 define('ERR_REQUETE',1);
 
function page_erreur ($err_code,$error,$connexion){
	switch ($err_code){
		case ERR_CONNEXION:
		echo "<h2>Désolé, connexion impossible </h2>";
		break;
		case ERR_REQUETE:
		echo "<h2> Erreur dans l'execution de la requête </h2>";
		break;
	}
	echo "<p>".$error."</p>";
	mysqli_close($connexion);	
	exit;
}
 
 // vérifie qu'il y est bien une majuscule
 function yes_maj($str){
	
	 $lettre = 'A';
	for($lettre; $lettre<= 'Z'; $lettre++){
		if(strpos($str,$lettre)!== FALSE){
			return true;
		}
	}
	return false;
 }
 
 //verifie qu'il est bien un chiffre
 function yes_num($str){
      preg_match("/([^A-Za-z\s])/",$str,$result);
	  if(!empty($result)){
        return true;
      }
      return false;
    }
	
	//vérifie qu'il n'y a pas de caractères speciaux
  function verif_alphaNum($str){
    preg_match("/([^A-Za-z0-9\s])/",$str,$result);
   if(!empty($result)){
        return false;
      }
      return true;
    }
?>
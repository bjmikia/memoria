<?php 
session_start();
$_SESSION = array(); //on vide le tableau de session 
session_destroy();
header("Location: connexion.php");
?>
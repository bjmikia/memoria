<?php
   if(isset($_POST['message'])) {
        $position_arobase = strpos($_POST['email'], '@');
        if ($position_arobase === false)
            echo '<h6>Votre email doit comporter un arobase.</h6>';
        else {
            $retour = mail('aurelienodin05@gmail.com', 'Envoi depuis la page Contact', $_POST['message'], 'From: '.$_POST['email']);
            if($retour)
                echo '<h6>Votre message a été envoyé.</h6>';
            else
                echo '<h6>Erreur.</h6>';
        }
    }
    ?>
<!DOCTYPE html>
	<html lang ="fr">
	<head>
		<title>Memoria-A propos/Contact</title>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="css/contact.css">
	</head>
	<body>
		<h1> 
			A Propos/Contact
		</h1>
		<h2>
			<U>F.A.Q</U>
		</h2>
		<div id = "content">
			<div class = "accueil">
			<nav >
				<ul>
					<li>
						<a href = "Accueil.php"> Accueil </a>
					</li>
				</ul>
			</nav>
		</div>
			<div class = "faq">
		<p>
			<U>Question</U> : Peut-on supprimer un jeu de carte créé ?
			<br>
			<U>Réponse</U> :Tu peux supprimer un jeu du carte du site avec le bouton modifier qui se trouve dans ton menu de carte ! Mais attention ! Cette action est IRREVERSIBLE, il faudra alors recréer un autre paquet entier ensuite !
			<br>
			<br>
			<U>Question</U> : Mon paquet de carte n'a pas été supprimé ! Pourquoi ?
			<br>
			<U>Réponse</U> : Plusieurs possibilités ici,
			<ul>
				<li> Vous avez écrit un terme interdit tel qu'une insulte, un terme sexuel etc...</li>
				<li> Ce que vous avez écrit est incompréhensible (par exemple : lejfgshrfuz)</li>
				<li> Nous avons remarqué que la solution était incorrecte </li>
			</ul>
			Si vous pensez que c'est injuste, n'hésitez pas a nous envoyer un message avec le formulaire en bas.
			<br>
			<br>
			<br>
			<U>Le signalement</U> : Si vous trouvez une carte fausse ou bien une carte qui ne respecte pas les règles, veuillez signaler la carte avec le formulaire ci dessous.
		</p>
		</div>
		<br>
		<div class = "poser">
		<p>
			<U>Posez votre propre question/Signaler:</U>
		</p>
		</div>
		<div class = "form">
		 <form method="post">
			<label>Nom</label><br>
			<input type="text" name="nom" required><br>
			<label>Email</label><br>
			<input name="email" required><br>
			<label>Message</label><br>
			<textarea name="message" style="width: 500px; height: 200px;" required></textarea><br>
			<input type="submit">
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
	</div>
		<footer>
			<h5>
				Ce site a été créé par MIKIA Benidy et NODIN Aurélie dans le cadre d'un projet en L1 informatique.
			</h5>
		</footer>

	</body>
	</html>
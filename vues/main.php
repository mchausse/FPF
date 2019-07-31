<html>
	<head>
		<meta http-equiv="Content-Language" content="en-ca">
		<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<link rel="stylesheet" href="./css/css.css" type="text/css" />
	</head>
	<?php
	// Utiliser la bonne image de font
		require_once('./modele/CompteDAO.class.php');
		$cDao=new CompteDAO();
		$background="theme1";
		if (!ISSET($_SESSION)) session_start();
		if (ISSET($_SESSION["connected"])){
			$compte=$cDao->find($_SESSION["connected"]);
			$background=$compte->getBackground();
		}
	?>
	<body id="<?=$background?>">
	<div id="menu">
			<nav id="nav-bar" class="navbar navbar-inverse">
		    	<div class="container-fluid">
		    		 <div class="navbar-header">
		      			<a class="navbar-brand">Logo</a>
		    		 </div>
					<ul class="nav navbar-nav navbar-left">
						<?php
						//if (!ISSET($_SESSION)) session_start();
						if (ISSET($_SESSION["connected"])){
						?>
							<li><a href="?action=accueil">Accueil</a></li>
							<li><a href="?action=revenues">Revenues</a></li>
							<li><a href="?action=depenses">Dépenses</a></li>
							<li><a href="?action=budget">Budget</a></li>
							<li><a href="?action=compte">Votre compte</a></li>
						<?php	
						}
						?>
					</ul>
					<ul class="nav navbar-nav navbar-right">
						<?php
						if (!ISSET($_SESSION)) session_start();
						if (ISSET($_SESSION["connected"])){
						?>
							<li><a href="?action=deconnecter">Déconnecter <?php echo $_SESSION["nom"]; ?></a></li>
						<?php	
						}
						else{
						?>
							<li><a href="?action=connecter">Se connecter</a></li>
							<li><a href="?action=inscrire">S'inscrire</a></li>
						<?php	
						}
						?>			
	    			</ul>
		  		</div>
			</nav>
		</div>
		<div class="container">
			<div id="content">
			<?php
				// Ici sera afficher la vue
				include $vue.".php";
			?>
			<br /><br />
			</div>
		</div>
		<div class="container">
			<div class="row">
				<div id="footer">
					&copy; 2018 FPF. Tous droits réservés.
				</div>
			</div>
		</div>
	</body>
</html>
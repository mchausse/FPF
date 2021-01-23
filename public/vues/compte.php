<div id="accueil">
	<?php
	if(!ISSET($_SESSION["connected"]))return "Vous devez vous connecter par la page d'accueil!"; // A tester
	include_once("./modele/CompteDAO.class.php");
	$cDao=new CompteDAO();
	$idCompte="";
	$adresse="";
	$prenom="";
	$nom="";
	$password="";
	$btnSubmit="Modifier";
	if (ISSET($_REQUEST["adresse"])){
		$adresse = $_REQUEST["adresse"];
		if (ISSET($_REQUEST["prenom"]))$prenom = $_REQUEST["prenom"];
		if (ISSET($_REQUEST["nom"]))$nom = $_REQUEST["nom"];
		if (ISSET($_REQUEST["password"]))$password = $_REQUEST["password"];
		if(ISSET($_REQUEST["idCompte"]))$idCompte = $_REQUEST["idCompte"];
	}
	else{
		$c=$cDao->find($_SESSION["connected"]);
		$adresse=$c->getEmail();
		$prenom=$c->getPrenom();
		$nom=$c->getNom();
		$password=$c->getMotDePasse();
		$c=$cDao->find($_SESSION["connected"]);
		$idCompte=$c->getId();
	}
	if (ISSET($_REQUEST["modifier"]))$btnSubmit = "Sauvegarder"; // A verifier si necessaire
	?>
	<h2>Votre compte <?php echo $_SESSION["nom"]; ?></h2>
	<div class="row">
		<div class="infoPanel">
			<div class="col-sm-12 col-md-5 col-lg-5">
				<div class="panel panel-default">
				    <div class="panel-heading">
				    	<h3>Informations du compte</h3>
				    </div>
				    <div class="panel-body">
						<form action="" method="post">
							<label for="adresse">Addresse courriel :</label><br /><input name="adresse" type="text" value="<?=$adresse?>" size=45 disabled/>
							<?php if (ISSET($_REQUEST["field_messages"]["adresse"]))echo "<span class=\"warningMessage\">".$_REQUEST["field_messages"]["adresse"]."</span>";
							?>
							<br />
							<label for="prenom">Prenom :</label><br /><input name="prenom" type="text" value="<?=$prenom?>" size=45/>
							<?php if (ISSET($_REQUEST["field_messages"]["prenom"]))echo "<span class=\"warningMessage\">".$_REQUEST["field_messages"]["prenom"]."</span>";
							?>
							<br />
							<label for="nom">Nom :</label><br /><input name="nom" type="text" value="<?=$nom?>" size=45/>
							<?php if (ISSET($_REQUEST["field_messages"]["nom"]))echo "<span class=\"warningMessage\">".$_REQUEST["field_messages"]["nom"]."</span>";
							?>
							<br />
							<label for="password">Mot de passe :</label><br /><input name="password" type="password" value="<?=$password?>" size=55/>
							<?php if (ISSET($_REQUEST["field_messages"]["password"]))echo "<span class=\"warningMessage\">".$_REQUEST["field_messages"]["password"]."</span>";
							?>
							<br />
							<input name="idCompte" value="<?=$idCompte?>" type="hidden" />
							<input name="background" value="<?=$background?>" type="hidden" />
							<input name="action" value="modifierCompte" type="hidden" />
							<br />
							<input value=" <?=$btnSubmit?> " type="submit" />
						</form>
					</div>
				</div>
			</div>
		</div>
		<div class="col-sm-1">
		</div>
		<div class="infoPanel">
			<div class="col-sm-12 col-md-6 col-lg-6">
				<div class="panel panel-default">
				    <div  class="panel-heading">
				    	<h3>Fonds d'écrans</h3>
				    </div>
				    <div class="panel-body">
				    	<div id="images">
					    	<div class="row">
					    		<div class="col-sm-4" class="imgs" onmouseover="survolImage(this)" onmouseleave="quitterImage(this)">
					    			<a href="?action=changerBackground&idCompte=<?=$idCompte?>&background=theme1"><img src="./css/images/banner.jpeg" height="100px" width="120px"></a>
					    		</div>
					    		<div class="col-sm-4" class="imgs" onmouseover="survolImage(this)" onmouseleave="quitterImage(this)">
					    			<a href="?action=changerBackground&idCompte=<?=$idCompte?>&background=theme2"><img src="./css/images/bateau.jpg" height="100px" width="120px"></a>
					    		</div>
					    		<div class="col-sm-4" class="imgs" onmouseover="survolImage(this)" onmouseleave="quitterImage(this)">
					    			<a href="?action=changerBackground&idCompte=<?=$idCompte?>&background=theme3"><img src="./css/images/ciel.jpg" height="100px" width="120px"></a>
					    		</div>
					    		<div class="col-sm-4" class="imgs" onmouseover="survolImage(this)" onmouseleave="quitterImage(this)">
					    			<a href="?action=changerBackground&idCompte=<?=$idCompte?>&background=theme4"><img src="./css/images/ville.jpg" height="100px" width="120px"></a>
					    		</div>
					    		<div class="col-sm-4" class="imgs" onmouseover="survolImage(this)" onmouseleave="quitterImage(this)">
					    			<a href="?action=changerBackground&idCompte=<?=$idCompte?>&background=theme5"><img src="./css/images/fleurs.jpg" height="100px" width="120px"></a>
					    		</div>
					    		<div class="col-sm-4" class="imgs" onmouseover="survolImage(this)" onmouseleave="quitterImage(this)">
					    			<a href="?action=changerBackground&idCompte=<?=$idCompte?>&background=theme6"><img src="./css/images/tropic.jpg" height="100px" width="120px"></a>
					    		</div>
					    	</div>
					    </div>
				    </div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
// Changer la couleur du contour de limage lorsque on passe par dessus et la quitte.
function survolImage(img){
	img.style.backgroundColor="grey";
}
function quitterImage(img){
	img.style.backgroundColor="white";
}
</script>
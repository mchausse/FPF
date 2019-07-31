<div id="inscrire">
<?php
	if (ISSET($_REQUEST["global_message"]))
	   $msg="<span class=\"warningMessage\">".$_REQUEST["global_message"]."</span>";
	$adresse="";
	$prenom="";
	$nom="";
	if (ISSET($_REQUEST["adresse"]))$adresse = $_REQUEST["adresse"];
	if (ISSET($_REQUEST["prenom"]))$prenom = $_REQUEST["prenom"];
	if (ISSET($_REQUEST["nom"]))$nom = $_REQUEST["nom"];
	?>	
	<div class="row">
		<div  class="col-sm-12 col-md-6 col-lg-5">
			<div id="inscrireForm">
				<h2>Inscription</h2>
				<form action="" method="post">
					<label for="adresse">Addresse courriel :</label><br /> <input name="adresse" type="text" value="<?=$adresse?>" size=45/>
					<?php if (ISSET($_REQUEST["field_messages"]["adresse"])) 
							echo "<span class=\"warningMessage\">".$_REQUEST["field_messages"]["adresse"]."</span>";
					?>
					<br />
					<label for="prenom">Prenom :</label><br /> <input name="prenom" type="text" value="<?=$prenom?>" size=45/>
					<?php if (ISSET($_REQUEST["field_messages"]["prenom"])) 
							echo "<span class=\"warningMessage\">".$_REQUEST["field_messages"]["prenom"]."</span>";
					?>
					<br />
					<label for="nom">Nom :</label><br /> <input name="nom" type="text" value="<?=$nom?>" size=45/>
					<?php if (ISSET($_REQUEST["field_messages"]["nom"])) 
							echo "<span class=\"warningMessage\">".$_REQUEST["field_messages"]["nom"]."</span>";
					?>
					<br />
					<label for="password">Mot de passe :</label><br /> <input name="password" type="password" size=55/>
					<?php if (ISSET($_REQUEST["field_messages"]["password"])) 
							echo "<span class=\"warningMessage\">".$_REQUEST["field_messages"]["password"]."</span>";
					?>
					<br />
					<label for="password2">Re-entrer votre Mot de passe :</label><br /> <input name="password2" type="password" size=55 />
					<?php if (ISSET($_REQUEST["field_messages"]["passwDifferent"])) 
							echo "<span class=\"warningMessage\">".$_REQUEST["field_messages"]["passwDifferent"]."</span>";
					?>
					<br />
					<input name="action" value="inscription" type="hidden" />
					<input value=" OK " type="submit" />
				</form>
			</div>
		</div>
	</div>
</div>
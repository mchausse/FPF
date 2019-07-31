<div id="accueil">
<?php
	if (ISSET($_REQUEST["global_message"]))
	   $msg="<span class=\"warningMessage\">".$_REQUEST["global_message"]."</span>";
	$adresse = "";
	if (ISSET($_REQUEST["adresse"]))
		$adresse = $_REQUEST["adresse"];
?>
	<div class="row">
		<div  class="col-sm-12 col-md-3 col-lg-3">
			<div id="loginForm">
			<h2>Connexion</h2>
			<form action="" method="post">
				<label for="adresse">Nom utilisateur :</label><br /> <input name="adresse" type="text" value="<?php echo $adresse?>" size="45" />
				<?php if (ISSET($_REQUEST["field_messages"]["adresse"])) 
						echo "<span class=\"warningMessage\">".$_REQUEST["field_messages"]["adresse"]."</span>";
				?>
				<br />
				<label for="password">Mot de passe    :</label><br /> <input name="password" type="password" size="45"/>
				<?php if (ISSET($_REQUEST["field_messages"]["password"])) 
						echo "<span class=\"warningMessage\">".$_REQUEST["field_messages"]["password"]."</span>";
				?>
				<br />
				<input name="action" value="connecter" type="hidden" />
				<input value=" OK " type="submit" />
			</form>
			</div>
		</div>
	</div>
</div>
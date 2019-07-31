<?php
require_once('./controleur/Action.interface.php');
require_once('./modele/CompteDAO.class.php');
class ModifierCompteAction implements Action {
	public function execute(){
		if (!ISSET($_SESSION)) session_start();
		if (!ISSET($_SESSION["connected"]))return "inscrire";
		$cDao=new CompteDAO();
		$c=new Compte();
		$c->setId($_REQUEST["idCompte"]);
		$c->setEmail($_REQUEST["adresse"]);
		$c->setNom($_REQUEST["nom"]);
		$c->setPrenom($_REQUEST["prenom"]);
		$c->setMotDePasse($_REQUEST["password"]);
		$c->setBackground($_REQUEST["background"]);
		$cDao->update($c);
		$_SESSION["connected"]=$_REQUEST["adresse"];
		$_SESSION["nom"]=$_REQUEST["prenom"]." ".$_REQUEST["nom"];
		return "compte";
	}
}
?>
<?php
require_once('./controleur/Action.interface.php');
require_once('./modele/RevenueDAO.class.php');
require_once('./modele/CompteDAO.class.php');
class ModifierRevenueAction implements Action {
	public function execute(){
		if (!ISSET($_SESSION)) session_start();
		if (!ISSET($_SESSION["connected"]))return "inscrire";
		$cDao=new CompteDAO();
		$rDao=new RevenueDAO();
		$r=$rDao->find($cDao->findIdByEmail($_SESSION["connected"]),$_REQUEST["numeroRevenue"]);
		$_REQUEST['idRevenue']=$r->getId();
		$_REQUEST["montant"]=$r->getMontant();
		$_REQUEST["nom"]=$r->getNom();
		$_REQUEST["recurence"]=$r->getRecurence();
		$_REQUEST["date"]=substr($r->getDate(),0,10);
		$_REQUEST["idCompte"]=$r->getIdCompte();
		$_REQUEST["btnNom"]="Sauvegarder"; // Changer le nom du bouton de soumition
		$_REQUEST["actionRevenue"]="sauvegarderRevenue"; // Changer l'action a executer
		$_REQUEST["afficherFormRevenue"]=true;// Ouvrir el formulaire apres 
		return "revenues";
	}
}
?>
<?php
require_once('../controleur/Action.interface.php');
require_once('../modele/DepenseDAO.class.php');
require_once('../modele/CompteDAO.class.php');
class ModifierDepenseAction implements Action {
	public function execute(){
		if (!ISSET($_SESSION)) session_start();
		if (!ISSET($_SESSION["connected"]))return "inscrire";
		$cDao=new CompteDAO();
		$dDao=new DepenseDAO();
		$d=$dDao->find($cDao->findIdByEmail($_SESSION["connected"]),$_REQUEST["numeroDepense"]);
		$_REQUEST['idDepense']=$d->getId();
		$_REQUEST["montant"]=$d->getMontant();
		$_REQUEST["nom"]=$d->getNom();
		$_REQUEST["recurence"]=$d->getRecurence();
		$_REQUEST["note"]=$d->getNote();
		$_REQUEST["remboursable"]=$d->getRemboursable();
		$_REQUEST["personne"]=$d->getNomPersonne();
		$_REQUEST["date"]=substr($d->getDate(),0,10);
		$_REQUEST["idCategorie"]=$d->getIdCategorie();
		$_REQUEST["idCompte"]=$d->getIdCompte();
		$_REQUEST["btnNom"]="Sauvegarder"; // Changer le nom du bouton de soumition
		$_REQUEST["actionDepense"]="sauvegarderDepense"; // Changer l'action a executer
		$_REQUEST["afficherFormDepense"]=true;// Ouvrir el formulaire apres 
		return "depenses";
	}
}
?>
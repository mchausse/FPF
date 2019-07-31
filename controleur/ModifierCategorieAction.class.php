<?php
require_once('./controleur/Action.interface.php');
require_once('./modele/CategorieDAO.class.php');
require_once('./modele/CompteDAO.class.php');
class ModifierCategorieAction implements Action {
	public function execute(){
		if (!ISSET($_SESSION)) session_start();
		if (!ISSET($_SESSION["connected"]))return "inscrire";
		$cDao=new CompteDAO();
		$catDao=new CategorieDAO();
		$cat=$catDao->find($cDao->findIdByEmail($_SESSION["connected"]),$_REQUEST["numeroCategorie"]);
		$_REQUEST["nomCat"]=$cat->getNom();
		$_REQUEST["idCategorie"]=$cat->getId();
		$_REQUEST["btnCategorie"]="Sauvegarder"; // Changer le nom du bouton de soumition
		$_REQUEST["actionCategorie"]="sauvegarderCategorie"; // Changer l'action a executer
		$_REQUEST["afficherFormCategorie"]=true;// Ouvrir le formulaire apres 
		return "depenses";
	}
}
?>
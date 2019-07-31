<?php
require_once('./controleur/Action.interface.php');
require_once('./modele/CategorieDAO.class.php');
class SupprimerCategorieAction implements Action {
	public function execute(){
		if (!ISSET($_SESSION)) session_start();
		if (!ISSET($_SESSION["connected"]))return "inscrire";
		$catDao=new CategorieDAO();
		$catDao->delete($_REQUEST["numASupprimer"]);
		return "depenses";
	}
}
?>
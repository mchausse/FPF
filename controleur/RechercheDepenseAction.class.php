<?php
require_once('./controleur/Action.interface.php');
require_once('./modele/DepenseDAO.class.php');
class RechercherDepenseAction implements Action {
	public function execute(){
		if (!ISSET($_SESSION)) session_start();
		if (!ISSET($_SESSION["connected"]))return "inscrire";
		$dDao=new DepenseDAO();
		$dDao->delete($_REQUEST["numASupprimer"]);
		return "depenses";
	}
}
?>
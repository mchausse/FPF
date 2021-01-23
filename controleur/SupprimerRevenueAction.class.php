<?php
require_once('../controleur/Action.interface.php');
require_once('../modele/RevenueDAO.class.php');
class SupprimerRevenueAction implements Action {
	public function execute(){
		if (!ISSET($_SESSION)) session_start();
		if (!ISSET($_SESSION["connected"]))return "inscrire";
		$rDao=new RevenueDAO();
		$rDao->delete($_REQUEST["numASupprimer"]);
		return "revenues";
	}
}
?>
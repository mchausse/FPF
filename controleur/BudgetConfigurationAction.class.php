<?php
require_once('./controleur/Action.interface.php');
require_once('./modele/CompteDAO.class.php');
class BudgetConfigurationAction implements Action {
	public function execute(){
		if (!ISSET($_SESSION)) session_start();
		if (!ISSET($_SESSION["connected"]))return "default";
		$cDao=new CompteDAO();
		$c=$cDao->find($_SESSION["connected"]);
		$c->setConfig($_REQUEST["valConfig"]);
		$c->setIdCategorieConfig($_REQUEST["categorie"]);
		$cDao->update($c);
		return "budget";
	}
}
?>
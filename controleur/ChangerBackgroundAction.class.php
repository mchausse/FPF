<?php
require_once('./controleur/Action.interface.php');
require_once('./modele/CompteDAO.class.php');
require_once('./modele/classes/Compte.class.php');
class ChangerBackgroundAction implements Action {
	public function execute(){
		if (!ISSET($_SESSION)) session_start();
		if (!ISSET($_SESSION["connected"]))return "inscrire";
		$cDao=new CompteDAO();
		$c=new Compte();
		$c=$cDao->find($_SESSION["connected"]);
		$c->setBackground($_REQUEST['background']);
		$cDao->update($c);
		return "compte";
	}
}
?>
<?php
require_once('./controleur/Action.interface.php');
require_once('./modele/RevenueDAO.class.php');
require_once('./modele/CompteDAO.class.php');
class RevenuesAction implements Action {
	public function execute(){
		if (!ISSET($_SESSION)) session_start();
		if (!ISSET($_SESSION["connected"]))return "login";
		// Trouver le id du compte celon le email
		$cDao=new CompteDAO();
		$rDao=new RevenueDAO();
		$compte=$cDao->findIdByEmail($_SESSION["connected"]);
		// Faire le verification des depenses recurentes
		if (!ISSET($_REQUEST['numPage'])){
			if(!ISSET($_REQUEST['sequence']))$_REQUEST["sequence"]='mois';
			$_REQUEST['numPage']= 1;
			$liste=$rDao->findAllBySequence($compte,$_REQUEST["sequence"]);
			$nbResultats=$liste->taille();
			$_SESSION["navig"] = array();
			$_SESSION["navig"]["nbResultats"] = $nbResultats;
			$_SESSION["navig"]["taillePage"] = 20;
	        $_SESSION["navig"]["nbPages"] = (int)(($_SESSION["navig"]["nbResultats"]-1)/20)+1;
    	}
		return "revenues";
	}
}
?>
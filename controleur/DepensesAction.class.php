<?php
require_once('./controleur/Action.interface.php');
require_once('./modele/DepenseDAO.class.php');
require_once('./modele/CompteDAO.class.php');
class DepensesAction implements Action {
	public function execute(){
		if (!ISSET($_SESSION)) session_start();
		if (!ISSET($_SESSION["connected"]))return "default";
		// Trouver le id du compte celon le email
		$cDao=new CompteDAO();
		$dDao=new DepenseDAO();
		$compte=$cDao->findIdByEmail($_SESSION["connected"]);
		if (!ISSET($_REQUEST['numPage'])){
			if(!ISSET($_REQUEST['sequence']))$_REQUEST["sequence"]='mois';
			$_REQUEST['numPage']= 1;
			$liste=$dDao->findAllBySequence($compte,$_REQUEST["sequence"]);
			$nbResultats=$liste->taille();
			$_SESSION["navig"] = array();
			$_SESSION["navig"]["nbResultats"] = $nbResultats;
			$_SESSION["navig"]["taillePage"] = 20;
	        $_SESSION["navig"]["nbPages"] = (int)(($_SESSION["navig"]["nbResultats"]-1)/15)+1;
    	}
		return "depenses";
	}
}
?>
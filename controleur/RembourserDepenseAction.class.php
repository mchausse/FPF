<?php
require_once('../controleur/Action.interface.php');
require_once('../modele/DepenseDAO.class.php');
require_once('../modele/classes/Depense.class.php');
class RembourserDepenseAction implements Action {
	public function execute(){
		if (!ISSET($_SESSION)) session_start();
		if (!ISSET($_SESSION["connected"]))return "inscrire";
		$dDao=new DepenseDao();
		$d=new Depense();
		$d=$dDao->find($_REQUEST["numeroCompte"],$_REQUEST["numeroDepense"]);
		$d->ajouterNote("\n Rembourser ".$d->getMontant()."$ par ".$d->getNomPersonne().".");
		$d->setRemboursable(0);
		$d->setNomPersonne("");
		$d->setMontant(0);
		$dDao->update($d);
		return "depenses";
	}
}
?>
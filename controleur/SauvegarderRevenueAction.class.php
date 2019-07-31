<?php
require_once('./controleur/Action.interface.php');
class SauvegarderRevenueAction implements Action {
	public function execute(){
		if(!$this->valide())return "revenues";
		require_once('./modele/RevenueDao.class.php');
		require_once('./modele/classes/Revenue.class.php');
		$rDao=new RevenueDao();
		$r=new Revenue();
		$r->setId($_REQUEST['idRevenue']);
		$r->setMontant($_REQUEST['montant']);
		$r->setRecurence($_REQUEST['recurence']);
		$r->setNom($_REQUEST["nom"]);
		$r->setIdCompte($_REQUEST['idCompte']);
		$r->setDate($_REQUEST['date']);
		$rDao->update($r);
		// Vider les champs des information de la depense ajouter
		$_REQUEST['idRevenue']='';
		$_REQUEST['montant']='';
		$_REQUEST["nom"]='';
		$_REQUEST['date']='';
		$_REQUEST['recurence']='';
		$_REQUEST['idCategorie']='';
		return "revenues";
	}
	public function valide(){
		$result = true;
		if ($_REQUEST['montant'] == ""){
			$_REQUEST["field_messages"]["montant"] = "Donnez un montant";
			$result = false;
		}
		if ($_REQUEST['montant'] <0){
			$_REQUEST["field_messages"]["montant"] = "Le montant doit etre positif.";
			$result = false;
		}
		if ($_REQUEST['nom'] == ""){
			$_REQUEST["field_messages"]["nom"] = "Nom obligatoire";
			$result = false;
		}
		if ($_REQUEST['date'] == ""){
			$_REQUEST["field_messages"]["date"] = "Date obligatoire";
			$result = false;
		}
		return $result;

	}
}
?>
<?php
require_once('../controleur/Action.interface.php');
class AjoutRevenueAction implements Action {
	public function execute(){
		if($_REQUEST["montant"]=="") return "revenues";
		if(!$this->valide())return "revenues";
		require_once('./modele/RevenueDao.class.php');
		require_once('./modele/classes/Revenue.class.php');
		$rDao=new RevenueDao();
		$r=new Revenue();
		$r->setMontant($_REQUEST['montant']);
		$r->setNom($_REQUEST["nom"]);
		$r->setRecurence($_REQUEST['recurence']);
		$r->setIdCompte($_REQUEST['idCompte']);
		$r->setDate($_REQUEST['date']);
		$rDao->create($r);
		// Vider les champs des information de la depense ajouter
		$_REQUEST['montant']='';
		$_REQUEST["nom"]='';
		$_REQUEST['recurence']='';
		$_REQUEST['date']='';
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
		if($result==false)$_REQUEST["afficherFormRevenue"]=true;// Ouvrir el formulaire apres 
		return $result;

	}
}
?>
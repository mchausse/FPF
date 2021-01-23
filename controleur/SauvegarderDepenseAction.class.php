<?php
require_once('../controleur/Action.interface.php');
class SauvegarderDepenseAction implements Action {
	public function execute(){
		if($_REQUEST["montant"]=="") return "depenses";
		if(!$this->valide())return "depenses";
		require_once('./modele/DepenseDao.class.php');
		require_once('./modele/CategorieDao.class.php');
		require_once('./modele/classes/Depense.class.php');
		if(!(ISSET($_REQUEST['remboursable'])))$_REQUEST['remboursable']=0;
		$dDao=new DepenseDao();
		$catDao=new CategorieDao();
		$d=new Depense();
		$d->setId($_REQUEST['idDepense']);
		$d->setMontant($_REQUEST['montant']);
		$d->setNom($_REQUEST["nom"]);
		$d->setRecurence($_REQUEST['recurence']);
		$d->setNote($_REQUEST['note']);
		$d->setRemboursable(($_REQUEST['personne']=="")?0:1);
		$d->setNomPersonne($_REQUEST['personne']);
		$d->setIdCategorie($catDao->findNom($_REQUEST['idCompte'],$_REQUEST['idCategorie'])->getId());
		$d->setIdCompte($_REQUEST['idCompte']);
		$d->setDate($_REQUEST['date']);
		$dDao->update($d);
		// Vider les champs des information de la depense ajouter
		$_REQUEST['idDepense']='';
		$_REQUEST['montant']='';
		$_REQUEST["nom"]='';
		$_REQUEST['recurence']='';
		$_REQUEST['note']='';
		$_REQUEST['remboursable']='';
		$_REQUEST['personne']='';
		$_REQUEST['date']='';
		$_REQUEST['idCategorie']='';
		return "depenses";
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
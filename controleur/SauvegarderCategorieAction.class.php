<?php
require_once('./controleur/Action.interface.php');
class SauvegarderCategorieAction implements Action {
	public function execute(){
		if(!$this->valide())return "depenses";
		require_once('./modele/CategorieDao.class.php');
		require_once('./modele/classes/Categorie.class.php');
		$catDao=new CategorieDao();
		$c=new Categorie();
		// Si la categorie existe deja
		if($catDao->exists($_REQUEST['idCompte'],$_REQUEST['nomCat'])){
			$_REQUEST["field_messages"]["nomCat"] = "Cette categorie existe deja";
		}
		else{
			$c->setId($_REQUEST['idCategorie']);
			$c->setNom($_REQUEST["nomCat"]);
			$c->setIdCompte($_REQUEST['idCompte']);
			$catDao->update($c);
		}
		// Effacer les champs
		$_REQUEST['idCategorie']='';
		$_REQUEST["nomCat"]='';
		return "depenses";
	}
	public function valide(){
		$result = true;
		if ($_REQUEST['nomCat'] == ""){
			$_REQUEST["field_messages"]["nomCat"] = "Nom obligatoire";
			$result = false;
		}
		return $result;
	}
}
?>
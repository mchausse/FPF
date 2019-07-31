<?php
require_once('./controleur/Action.interface.php');
class AjoutCategorieAction implements Action {
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
			$c->setNom($_REQUEST["nomCat"]);
			$c->setIdCompte($_REQUEST['idCompte']);
			$catDao->create($c);
		}
		return "depenses";
	}
	public function valide(){
		$result = true;
		if ($_REQUEST['nomCat'] == ""){
			$_REQUEST["field_messages"]["nomCat"] = "Nom obligatoire";
			$result = false;
		}
		if($result==false)$_REQUEST["afficherFormCategorie"]=true;// Ouvrir le formulaire apres 
		return $result;
	}
}
?>
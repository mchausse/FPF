<?php
require_once('../controleur/Action.interface.php');
class InscriptionAction implements Action {
	public function execute(){
		if($_REQUEST["adresse"]=="") return "inscrire";
		if(!$this->valide())return "inscrire";
		require_once('../modele/CompteDao.class.php');
		require_once('../modele/CategorieDao.class.php');
		require_once('../modele/classes/Compte.class.php');
		require_once('../modele/classes/Categorie.class.php');
		$cDao=new CompteDao();
		$catDao=new CategorieDao();
		$compte=new Compte();
		$c=new Categorie();
		$compte->setEmail($_REQUEST['adresse']);
		$compte->setPrenom($_REQUEST["prenom"]);
		$compte->setNom($_REQUEST['nom']);
		$compte->setMotDePasse($_REQUEST['password']);
		$compte->setBackground("theme1");
		$cDao->create($compte);
		// Ajouter les categorie par default
		$idCompte=$cDao->findIdByEmail($_REQUEST['adresse']);
		$c->setNom("Restaurants");
		$c->setIdCompte($idCompte);
		$catDao->create($c);
		$c=new Categorie();
		$c->setNom("Épicerie");
		$c->setIdCompte($idCompte);
		$catDao->create($c);
		$c=new Categorie();
		$c->setNom("Voiture");
		$c->setIdCompte($idCompte);
		$catDao->create($c);
		return "login";
	}
	public function valide(){
		$result = true;
		if ($_REQUEST['adresse'] == ""){
			$_REQUEST["field_messages"]["adresse"] ="Donnez votre adresse courriel";
			$result = false;
		}
		if ($_REQUEST['nom'] == ""){
			$_REQUEST["field_messages"]["nom"] = "Nom obligatoire";
			$result = false;
		}
		if ($_REQUEST['prenom'] == ""){
			$_REQUEST["field_messages"]["prenom"] = "Prenom obligatoire";
			$result = false;
		}
		if ($_REQUEST['password'] == ""){
			$_REQUEST["field_messages"]["password"] = "Mot de passe obligatoire";
			$result = false;
		}
		if ($_REQUEST['password'] != $_REQUEST['password2']){
			$_REQUEST["field_messages"]["passwDifferent"] = "Les mots de passe doivent etre identique";
			$result = false;
		}
		return $result;
	}
}
?>
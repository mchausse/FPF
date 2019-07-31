<?php
require_once('./controleur/DefaultAction.class.php');
require_once('./controleur/LoginAction.class.php');
require_once('./controleur/LogoutAction.class.php');
require_once('./controleur/AfficherAction.class.php');
require_once('./controleur/InscrireAction.class.php');
require_once('./controleur/InscriptionAction.class.php');
require_once('./controleur/DepensesAction.class.php');
require_once('./controleur/RevenuesAction.class.php');
require_once('./controleur/BudgetAction.class.php');
require_once('./controleur/CompteAction.class.php');
require_once('./controleur/AjoutDepenseAction.class.php');
require_once('./controleur/AjoutCategorieAction.class.php');
require_once('./controleur/AfficherDepensesAction.class.php');
require_once('./controleur/SupprimerDepenseAction.class.php');
require_once('./controleur/ModifierDepenseAction.class.php');
require_once('./controleur/ModifierCompteAction.class.php');
require_once('./controleur/RechercheDepenseAction.class.php');
require_once('./controleur/SupprimerCategorieAction.class.php');
require_once('./controleur/ModifierCategorieAction.class.php');
require_once('./controleur/SauvegarderCategorieAction.class.php');
require_once('./controleur/SauvegarderDepenseAction.class.php');
require_once('./controleur/AjoutRevenueAction.class.php');
require_once('./controleur/ModifierRevenueAction.class.php');
require_once('./controleur/SauvegarderRevenueAction.class.php');
require_once('./controleur/SupprimerRevenueAction.class.php');
require_once('./controleur/RembourserDepenseAction.class.php');
require_once('./controleur/ChangerBackgroundAction.class.php');
require_once('./controleur/BudgetConfigurationAction.class.php');

class ActionBuilder{
	public static function getAction($nomAction){
		switch ($nomAction){
			case "connecter" :
				return new LoginAction();
				break;
			case "deconnecter" :
				return new LogoutAction();
				break;
			case "afficher" :
				return new AfficherAction();
				break;
			case "inscrire" :
				return new InscrireAction();
				break;
			case "inscription" :
				return new InscriptionAction();
				break;
			case "accueil" :
				return new DefaultAction();
				break;
			case "depenses" :
				return new DepensesAction();
				break;
			case "revenues" :
				return new RevenuesAction();
				break;
			case "budget" :
				return new BudgetAction();
				break;
			case "compte" :
				return new CompteAction();
				break;
			case "ajoutDepense" :
				return new AjoutDepenseAction();
				break;
			case "ajoutCategorie" :
				return new AjoutCategorieAction();
				break;
			case "afficherDepenses" :
				return new AfficherDepensesAction();
				break;
			case "supprimerDepense" :
				return new SupprimerDepenseAction();
				break;
			case "modifierDepense" :
				return new ModifierDepenseAction();
				break;
			case "modifierCompte" :
				return new ModifierCompteAction();
				break;
			case "rechercheDepense" :
				return new RechercheDepenseAction();
				break;
			case "supprimerCategorie" :
				return new SupprimerCategorieAction();
				break;
			case "modifierCategorie" :
				return new ModifierCategorieAction();
				break;
			case "sauvegarderCategorie" :
				return new SauvegarderCategorieAction();
				break;
			case "sauvegarderDepense" :
				return new SauvegarderDepenseAction();
				break;
			case "ajoutRevenue" :
				return new AjoutRevenueAction();
				break;
			case "modifierRevenue" :
				return new ModifierRevenueAction();
				break;
			case "sauvegarderRevenue" :
				return new SauvegarderRevenueAction();
				break;
			case "supprimerRevenue" :
				return new SupprimerRevenueAction();
				break;
			case "rembourserDepense" :
				return new RembourserDepenseAction();
				break;
			case "changerBackground" :
				return new ChangerBackgroundAction();
				break;
			case "budgetConfiguration" :
				return new BudgetConfigurationAction();
				break;
			default :
				return new DefaultAction();
		}
	}
}
?>

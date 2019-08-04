<?php
/**
 * ================================
 * @titre : DepenseDAO.class.php
 * @author : Maxime Chausse
 * @date : 21.03.2018
 * @description : DAO d'une depense
 * ================================
 */
 // ----- Import -----
include_once('/classes/Database.class.php');
include_once('/classes/Depense.class.php');
include_once('/classes/Liste.class.php');
// ========== Code ==========
class DepenseDAO{
	public static function find($c,$id){
		// Connection a la base de donnee
		$db = Database::getInstance();
		// construction de la requete
		$pstmt = $db->prepare("SELECT * FROM depense WHERE idCompte='".$c."' and idDepense = :x");
		$pstmt->execute(array(':x' => $id));
		$result = $pstmt->fetch(PDO::FETCH_OBJ);
		$d = new Depense();
		if ($result){
			$d->setId($result->idDepense);
			$d->setMontant($result->montantDepense);
			$d->setNom($result->nomDepense);
			$d->setRecurence($result->recurenceDepense);
			$d->setNote($result->note);
			$d->setIdCategorie($result->idCategorie);
			$d->setIdCompte($result->idCompte);
			$d->setDate($result->dateDepense);
			$d->setRemboursable($result->remboursable);
			$d->setNomPersonne($result->nomPersonne);
			$pstmt->closeCursor();
			return $d;
		}
		$pstmt->closeCursor();
		return null;
	}
	public function create($p){
		// La requete
		$requete="INSERT INTO depense (montantDepense,nomDepense,recurenceDepense,note,idCategorie,idCompte,dateDepense,remboursable,nomPersonne)
				  VALUES ('".$p->getMontant()."','".$p->getNom()."','".$p->getRecurence()."',
				  		 '".$p->getNote()."','".$p->getIdCategorie()."','".$p->getIdCompte()."','".$p->getDate()."',
				  		'".$p->getRemboursable()."','".$p->getNomPersonne()."')";
		try{return Database::getInstance()->exec($requete);}
		catch(PDOException $e){return $e;}
	}
	// Tout trouver les depenses relier a un compte
	public static function findAll($id){
		try{
			$liste=new Liste();
			$db=Database::getInstance();
			$requete="SELECT * FROM depense WHERE idCompte='".$id."'";
			$resultat=$db->query($requete);// **** Pourquoi pas en exec? *****
			foreach($resultat as $dep) {
				$d=new Depense();
				$d->loadFromArray($dep);
				$liste->add($d);
			}
			//$resultat->closeCursor(); // Cause une erreur!!!
			$db=null;
			return $liste;
		}
		catch(PDOexception $e){
			echo "Error : ".$e->getMessage();
			return $liste;
		}
	}
	// Tout trouver les depenses dun compte selon une categorie
	public static function findAllCat($id,$c){
		try{
			$liste=new Liste();
			$db=Database::getInstance();
			$requete="SELECT * FROM depense WHERE idCompte='".$id."' and idCategorie='".$c."'";
			$resultat=$db->query($requete);// **** Pourquoi pas en exec? *****
			foreach($resultat as $dep) {
				$d=new Depense();
				$d->loadFromArray($dep);
				$liste->add($d);
			}
			//$resultat->closeCursor(); // Cause une erreur!!!
			$db=null;
			return $liste;
		}
		catch(PDOexception $e){
			echo "Error : ".$e->getMessage();
			return $liste;
		}
	}
	// Tout trouver les depenses dun compte selon une date
	public static function findAllDate($id,$d){
			try{
				$liste=new Liste();
				$db=Database::getInstance();
				$requete="SELECT * FROM depense WHERE idCompte='".$id."' and dateDepense='".$d."'";
				$resultat=$db->query($requete);// **** Pourquoi pas en exec? *****
				foreach($resultat as $dep) {
					$d=new Depense();
					$d->loadFromArray($dep);
					$liste->add($d);
				}
				//$resultat->closeCursor(); // Cause une erreur!!!
				$db=null;
				return $liste;
			}
			catch(PDOexception $e){
				echo "Error : ".$e->getMessage();
				return $liste;
			}
	}
	// Tout trouver les depenses dun compte selon une date et une categorie
	public static function findAllDateCat($id,$d,$c){
		try{
			$liste=new Liste();
			$db=Database::getInstance();
			$requete="SELECT *
						FROM depense
						WHERE idCompte='".$id."' and dateDepense='".$d."' and idCategorie='".$c."'";
			$resultat=$db->query($requete);// **** Pourquoi pas en exec? *****
			foreach($resultat as $dep) {
				$d=new Depense();
				$d->loadFromArray($dep);
				$liste->add($d);
			}
			//$resultat->closeCursor(); // Cause une erreur!!!
			$db=null;
			return $liste;
		}
		catch(PDOexception $e){
			echo "Error : ".$e->getMessage();
			return $liste;
		}
	}
	// Trouver toutes les depenses recurentes d'un compte
	public static function findAllRecurentes($id){
		try{
			$liste=new Liste();
			$db=Database::getInstance();
			$requete="SELECT * FROM depense WHERE idCompte='".$id."' and (recurenceDepense='quo' or recurenceDepense='heb' or recurenceDepense='men' or recurenceDepense='ann')";
			$resultat=$db->query($requete);// **** Pourquoi pas en exec? *****
			foreach($resultat as $dep) {
				$d=new Depense();
				$d->loadFromArray($dep);
				//if(!($liste->isPresent($d))) // Pour la funciont unique
					$liste->add($d);
			}
			//$resultat->closeCursor(); // Cause une erreur!!!
			$db=null;
			return $liste;
		}
		catch(PDOexception $e){
			echo "Error : ".$e->getMessage();
			return $liste;
		}
	}
	// Trouver toutes les depenses recurentes d'un compte
	public static function findRecurentes($id,$req){
		try{
			$liste=new Liste();
			$db=Database::getInstance();
			$requete="SELECT * FROM depense WHERE idCompte='".$id."' and recurenceDepense='".$req."'";
			$resultat=$db->query($requete);// **** Pourquoi pas en exec? *****
			foreach($resultat as $dep) {
				$d=new Depense();
				$d->loadFromArray($dep);
				$liste->add($d);
			}
			//$resultat->closeCursor(); // Cause une erreur!!!
			$db=null;
			return $liste;
		}
		catch(PDOexception $e){
			echo "Error : ".$e->getMessage();
			return $liste;
		}
	}
	// Trouver toutes les depenses recurentes d'un compte
	public static function findAllRemboursables($id){
		try{
			$liste=new Liste();
			$db=Database::getInstance();
			$requete="SELECT * FROM depense WHERE idCompte='".$id."' and remboursable=1";
			$resultat=$db->query($requete);// **** Pourquoi pas en exec? *****
			foreach($resultat as $dep) {
				$d=new Depense();
				$d->loadFromArray($dep);
				$liste->add($d);
			}
			//$resultat->closeCursor(); // Cause une erreur!!!
			$db=null;
			return $liste;
		}
		catch(PDOexception $e){
			echo "Error : ".$e->getMessage();
			return $liste;
		}
	}
	public static function findAllBySequence($id,$sequence){
		try{
			$liste=new Liste();
			$db=Database::getInstance();
			// Par default la requete est executer par mois
			$r="SELECT * FROM depense WHERE idCompte='".$id."' and MONTH(dateDepense)=MONTH(CURRENT_DATE())";
			if($sequence=="jour")$r="SELECT * FROM depense WHERE idCompte='".$id."' and dateDepense=(SELECT CURDATE())";
			if($sequence=="semaine")$r="SELECT * FROM depense WHERE idCompte='".$id."' and YEARWEEK(dateDepense,1)=YEARWEEK(CURDATE(),1)";
			if($sequence=="annee")$r="SELECT * FROM depense WHERE idCompte='".$id."' and YEAR(dateDepense)=YEAR(CURDATE())";
			$resultat=$db->query($r);
			foreach($resultat as $dep) {
				$d=new Depense();
				$d->loadFromArray($dep);
				$liste->add($d);
			}
			$db=null;
			return $liste;
		}
		catch(PDOexception $e){
			echo "Error : ".$e->getMessage();
			return $liste;
		}
	}
	public function update($d){
		$r="UPDATE depense
			SET montantDepense='".$d->getMontant()."',nomDepense='".$d->getNom()."',recurenceDepense='".$d->getRecurence()."',
			note='".$d->getNote()."',idCategorie='".$d->getIdCategorie()."',idCompte='".$d->getIdCompte()."',
			dateDepense='".$d->getDate()."',remboursable='".$d->getRemboursable()."',nomPersonne='".$d->getNomPersonne()."'
			WHERE idDepense='".$d->getId()."'";
		try{return Database::getInstance()->exec($r);}
		catch(PDOException $e){throw $e;}
	}
	public function delete($d){
		$r="DELETE FROM depense WHERE idDepense='".$d."'";
		try{return Database::getInstance()->exec($r);}
		catch(PDOException $e){throw $e;}
	}
	public function findNbDepCat($compte,$cat){
		try{
			$db=Database::getInstance();
			$r="SELECT COUNT(idCategorie) as NB FROM Depense WHERE idCategorie='".$cat."' and idCompte='".$compte."'";
			$resultat=$db->query($r);
			$db=null;
			return $resultat;
		}catch(PDOException $e){throw $e;}
	}
	public function findTotalMontant($compte,$cat){
		try{
			$db=Database::getInstance();
			$r="SELECT SUM(montantDepense) as montantTot FROM Depense WHERE idCategorie='".$cat."' and idCompte='".$compte."'";
			$resultat=$db->query($r);
			$db=null;
			return $resultat;
		}catch(PDOException $e){throw $e;}
	}
	public function findTotalMontantSequence($compte,$cat,$sequence){
		try{
			$db=Database::getInstance();
			// Par default la requete va etre effectuer celon le mois 
			$r="SELECT SUM(montantDepense) as montantTot FROM depense WHERE idCompte='".$compte."' and idCategorie='".$cat."' and MONTH(dateDepense)=MONTH(CURRENT_DATE())";
			if($sequence=="jour")$r="SELECT SUM(montantDepense) as montantTot FROM depense WHERE idCompte='".$compte."' and idCategorie='".$cat."' and dateDepense=(SELECT CURDATE())";
			if($sequence=="semaine")$r="SELECT SUM(montantDepense) as montantTot FROM depense WHERE idCompte='".$compte."' and idCategorie='".$cat."' and YEARWEEK(dateDepense,1)=YEARWEEK(CURDATE(),1)";
			if($sequence=="annee")$r="SELECT SUM(montantDepense) as montantTot FROM depense WHERE idCompte='".$compte."' and idCategorie='".$cat."' and YEAR(dateDepense)=YEAR(CURDATE())";
			$resultat=$db->query($r);
			$db=null;
			return $resultat;
		}catch(PDOException $e){throw $e;}
	}
	public function findNbDepCatSequence($compte,$cat,$sequence){
		try{
			$db=Database::getInstance();
			// Par default la requete va etre effectuer celon le mois
			$r="SELECT COUNT(idCategorie) as NB FROM Depense WHERE idCategorie='".$cat."' and idCompte='".$compte."' and MONTH(dateDepense)=MONTH(CURRENT_DATE())";
			if($sequence=="jour")$r="SELECT COUNT(idCategorie) as NB FROM Depense WHERE idCategorie='".$cat."' and idCompte='".$compte."' and dateDepense=(SELECT CURDATE())";
			if($sequence=="semaine")$r="SELECT COUNT(idCategorie) as NB FROM Depense WHERE idCategorie='".$cat."' and idCompte='".$compte."' and YEARWEEK(dateDepense,1)=YEARWEEK(CURDATE(),1)";
			if($sequence=="annee")$r="SELECT COUNT(idCategorie) as NB FROM Depense WHERE idCategorie='".$cat."' and idCompte='".$compte."' and YEAR(dateDepense)=YEAR(CURRENT_DATE())";
			$resultat=$db->query($r);
			$db=null;
			return $resultat;
		}catch(PDOException $e){throw $e;}
	}
//Cette méthode vérifie que les paramètres dans la clause LIMIT (et GROUP BY) ne fonctionnent pas.	
	public static function getPageWithParam($numPage, $taillePage)
	{
		try {
			$liste = new Liste();
			$debut = ($numPage - 1)*$taillePage;
			$db = Database::getInstance();
			$pstmt = $db->prepare('SELECT * FROM depense LIMIT :lim, :taille');
			$pstmt->execute(array(':lim' => $debut,':taille' => $taillePage));
			while ($result = $pstmt->fetch(PDO::FETCH_OBJ)){
				$d = new Depense();
				$d->setId($result->idDepense);
				$d->setMontant($result->montantDepense);
				$d->setNom($result->nomDepense);
				$d->setRecurence($result->recurenceDepense);
				$d->setNote($result->note);
				$d->setIdCategorie($result->idCategorie);
				$d->setIdCompte($result->idCompte);
				$d->setDate($result->dateDepense);
				$d->setRemboursable($result->remboursable);
				$d->setNomPersonne($result->nomPersonne);
				$liste->add($d);
			}
			$pstmt->closeCursor();
		    $db = null;
			return $liste;
		} catch (PDOException $e) {
		    print "Error!: " . $e->getMessage() . "<br/>";
		    return $liste;
		}	
	}
	public static function getPage($idCompte,$numPage,$taillePage,$sequence){
		try {
			$liste = new Liste();
			$debut = ($numPage - 1)*$taillePage;
			$r="SELECT * FROM depense WHERE idCompte='".$idCompte."' and MONTH(dateDepense)=MONTH(CURRENT_DATE()) ORDER BY dateDepense DESC LIMIT ".$debut.", ".$taillePage."";
			if($sequence=="jour")
				$r="SELECT * FROM depense WHERE idCompte='".$idCompte."' and dateDepense=(SELECT CURDATE()) ORDER BY dateDepense DESC LIMIT ".$debut.", ".$taillePage."";
			if($sequence=="semaine")
				$r="SELECT * FROM depense WHERE idCompte='".$idCompte."' and YEARWEEK(dateDepense,1)=YEARWEEK(CURDATE(),1) ORDER BY dateDepense DESC LIMIT ".$debut.", ".$taillePage."";
			if($sequence=="annee")
				$r="SELECT * FROM depense WHERE idCompte='".$idCompte."' and YEAR(dateDepense)=YEAR(CURRENT_DATE()) ORDER BY dateDepense DESC LIMIT ".$debut.", ".$taillePage."";
			$cnx = Database::getInstance();
			$res = $cnx->query($r);
		    foreach($res as $row) {
				$d = new Depense();
				$d->loadFromArray($row);
				$liste->add($d);
		    }
			$res->closeCursor();
		    $cnx = null;
			return $liste;
		} catch (PDOException $e) {
		    print "Error!: " . $e->getMessage() . "<br/>";
		    return $liste;
		}	
	}
	public static function verifierRecurentes($idCompte){//  Verifie caque depense recurecive pour voir si elle deverais etre ajouter 
		date_default_timezone_set(DateTimeZone::listIdentifiers(DateTimeZone::UTC)[0]);
		$liste=self::findAllRecurentes($idCompte);
		while($liste->next()){
			$d=$liste->current();
			if($d->getRecurence()=="men"){
				$mois = substr($d->getDate(),5,7);
				$moisNow=date("m");
			}
		}
	}
	public function findTotalDepenseMois($compte,$mois){
		try{
			$db=Database::getInstance();
			$r="SELECT SUM(montantDepense) as montantTot FROM depense WHERE idCompte='".$compte."' and MONTH(dateDepense)='".$mois."'";
			$resultat=$db->query($r);
			$db=null;
			return $resultat;
		}catch(PDOException $e){throw $e;}
	}
	public function findTotalDepenseMoisCat($compte,$cat,$mois){
		try{
			$db=Database::getInstance();
			$r="SELECT SUM(montantDepense) as montantTot FROM depense WHERE idCompte='".$compte."' and idCategorie='".$cat."' and MONTH(dateDepense)='".$mois."'";
			$resultat=$db->query($r);
			$db=null;
			return $resultat;
		}catch(PDOException $e){throw $e;}
	}
	
	public static function getPageRecherche($idCompte,$numPage,$taillePage,$parametre,$recherche){
		try {
			$liste = new Liste();
			$debut = ($numPage - 1)*$taillePage;
			// Par defaul on recherche le ontant
			$r="SELECT * FROM depense WHERE idCompte='".$idCompte."' and montantDepense like '".$recherche."%' ORDER BY montantDepense LIMIT ".$debut.", ".$taillePage."";
			if($parametre=="nom")
				$r="SELECT * FROM depense WHERE idCompte='".$idCompte."' and nomDepense like '".$recherche."%' ORDER BY nomDepense LIMIT ".$debut.", ".$taillePage."";
			if($parametre=="date")
				$r="SELECT * FROM depense WHERE idCompte='".$idCompte."' and dateDepense like '".$recherche."%' ORDER BY dateDepense LIMIT ".$debut.", ".$taillePage."";
			if($parametre=="categorie")
				$r="SELECT * FROM depense WHERE idCompte='".$idCompte."' and categorieDepense like '".$recherche."%'LIMIT ".$debut.", ".$taillePage."";
			if($parametre=="recurence")
				$r="SELECT * FROM depense WHERE idCompte='".$idCompte."' and montantDepense like '".$recherche."%' LIMIT ".$debut.", ".$taillePage."";
			$cnx = Database::getInstance();
			$res = $cnx->query($r);
		    foreach($res as $row) {
				$d = new Depense();
				$d->loadFromArray($row);
				$liste->add($d);
		    }
			//$res->closeCursor();
		    $cnx = null;
			return $liste;
		} catch (PDOException $e) {
		    print "Error!: " . $e->getMessage() . "<br/>";
		    return $liste;
		}	
	}
	public function findTotalMontantQMois($compte,$cat){
		try{
			$db=Database::getInstance();
			$r="SELECT SUM(montantDepense) as montantTot FROM Depense WHERE idCategorie='".$cat."' and idCompte='".$compte."' and (dateDepense >= DATE_SUB(CURRENT_DATE(),INTERVAL 4 MONTH) and MONTH(dateDepense)<MONTH(Current_Date()))";
			$resultat=$db->query($r);
			$db=null;
			return $resultat;
		}catch(PDOException $e){throw $e;}
	}
	
}
?>
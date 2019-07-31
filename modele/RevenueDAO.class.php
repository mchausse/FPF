<?php
/**
 * ================================
 * @titre : Revenue.class.php
 * @author : Samuel Laverdure
 * @date : 25.03.2018
 * @description : DAO d'un Revenue
 * ================================
 */
 // ----- Import -----
include_once('/classes/Database.class.php');
include_once('/classes/Revenue.class.php');
include_once('/classes/Liste.class.php');
// ========== Code ==========
class RevenueDAO{
	public static function find($c,$id){
		// Connection a la base de donnee
		$db = Database::getInstance();
		// construction de la requete
		$pstmt = $db->prepare("SELECT * FROM revenue WHERE idCompte='".$c."' and idRevenue = :x");
		$pstmt->execute(array(':x' => $id));
		$result = $pstmt->fetch(PDO::FETCH_OBJ);
		$r = new Revenue();
		if ($result){
			$r->setId($result->idRevenue);
			$r->setMontant($result->montantRevenue);
			$r->setNom($result->nomRevenue);
			$r->setRecurence($result->recurenceRevenue);
			$r->setIdCompte($result->idCompte);
			$r->setDate($result->date);
			$pstmt->closeCursor();
			return $r;
		}
		$pstmt->closeCursor();
		return null;
	}
	public function create($p){
		// La requete
		$db=Database::getInstance();
		$pstmt=$db->prepare("INSERT INTO revenue (montantRevenue,nomRevenue,recurenceRevenue,idCompte,date)
				  VALUES (:montant , :nom , :rec , :compte , :date )");
		try{
			return $pstmt->execute(array(':montant'=>$p->getMontant(),':nom'=>$p->getNom(),':rec'=>$p->getRecurence(),':compte'=>$p->getIdCompte(),':date'=>$p->getDate()));
		}
		catch(PDOException $e){return $e;}
	}
	// Tout trouver les revenue relier a un compte
	public static function findAll($id){
		try{
			$liste=new Liste();
			$db=Database::getInstance();
			$pstmt=$db->prepare("SELECT * FROM revenue WHERE idCompte= :id ");
			$pstmt->execute(array(':id'=>$id));
			$resultat=$pstmt->fetch(PDO::FETCH_OBJ);
			foreach($resultat as $rev) {
				$r=new Revenue();
				$r->loadFromArray($rev);
				$liste->add($r);
			}
			$pstmt->closeCursor();
			$db=null;
			return $liste;
		}
		catch(PDOexception $e){
			echo "Error : ".$e->getMessage();
			return $liste;
		}
	}
	
	// Tout trouver les revenues dun compte selon une date
	public static function findAllDate($id,$r){
			try{
				$liste=new Liste();
				$db=Database::getInstance();
				$requete="SELECT * FROM revenue WHERE idCompte='".$id."' and date='".$r."'";
				$resultat=$db->query($requete);// **** Pourquoi pas en exec? *****
				foreach($resultat as $rev) {
					$r=new Revenue();
					$r->loadFromArray($rev);
					$liste->add($r);
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
	
	// Trouver toutes les revenues recurentes d'un compte
	public static function findAllRecurentes($id,$req){
		try{
			$liste=new Liste();
			$db=Database::getInstance();
			$requete="SELECT * FROM revenue WHERE idCompte='".$id."' and recurenceRevenue='".$req."'";
			$resultat=$db->query($requete);// **** Pourquoi pas en exec? *****
			foreach($resultat as $rev) {
				$r=new Revenue();
				$r->loadFromArray($rev);
				$liste->add($r);
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
	public static function findAllNom($idCompte){// Fonction qui trouve tous les nom differant d;un compte
		try{
			$liste=new Liste();
			$db=Database::getInstance();
			$requete="SELECT DISTINCT nomRevenue FROM revenue WHERE idCompte='".$idCompte."'";
			$resultat=$db->query($requete);
			foreach($resultat as $rev) {
				$liste->add($rev);
			}
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
			$r=							"SELECT * FROM revenue WHERE idCompte='".$id."' and MONTH(date)=MONTH(CURRENT_DATE())";
			if($sequence=="jour")$r=    "SELECT * FROM revenue WHERE idCompte='".$id."' and date=(SELECT CURDATE())";
			if($sequence=="semaine")$r= "SELECT * FROM revenue WHERE idCompte='".$id."' and YEARWEEK(date,1)=YEARWEEK(CURDATE(),1)";
			if($sequence=="annee")$r=	"SELECT * FROM revenue WHERE idCompte='".$id."' and YEAR(date)=YEAR(CURDATE())";
			$resultat=$db->query($r);
			foreach($resultat as $rev) {
				$x=new Revenue();
				$x->loadFromArray($rev);
				$liste->add($x);
			}
			$db=null;
			return $liste;
		}
		catch(PDOexception $e){
			echo "Error : ".$e->getMessage();
			return $liste;
		}
	}
	public function findTotalMontantNomSequence($compte,$nom,$sequence){
		try{
			$db=Database::getInstance();
			// Par default la requete va etre effectuer celon le mois
			$r=							"SELECT SUM(montantRevenue) as montantTot FROM revenue WHERE idCompte='".$compte."' and nomRevenue='".$nom."' and MONTH(date)=MONTH(CURRENT_DATE())";
			if($sequence=="jour")$r=    "SELECT SUM(montantRevenue) as montantTot FROM revenue WHERE idCompte='".$compte."' and nomRevenue='".$nom."' and date=(SELECT CURDATE())";
			if($sequence=="semaine")$r= "SELECT SUM(montantRevenue) as montantTot FROM revenue WHERE idCompte='".$compte."' and nomRevenue='".$nom."' and YEARWEEK(date,1)=YEARWEEK(CURDATE(),1)";
			if($sequence=="annee")$r=   "SELECT SUM(montantRevenue) as montantTot FROM revenue WHERE idCompte='".$compte."' and nomRevenue='".$nom."' and YEAR(date)=YEAR(CURDATE())";
			$resultat=$db->query($r);
			$db=null;
			return $resultat;
		}catch(PDOException $e){throw $e;}
	}
	public function findTotalRevenueMois($compte,$mois){
		try{
			$db=Database::getInstance();
			$r="SELECT SUM(montantRevenue) as montantTot FROM revenue WHERE idCompte='".$compte."' and MONTH(date)='".$mois."'";
			$resultat=$db->query($r);
			$db=null;
			return $resultat;
		}catch(PDOException $e){throw $e;}
	}
	public static function getPage($idCompte,$numPage,$taillePage,$sequence){
		try {
			$liste = new Liste();
			$debut = ($numPage - 1)*$taillePage;
			$r="SELECT * FROM revenue WHERE idCompte='".$idCompte."' and MONTH(date)=MONTH(CURRENT_DATE()) ORDER BY date DESC LIMIT ".$debut.", ".$taillePage."";
			if($sequence=="jour")$r=	"SELECT * FROM revenue WHERE idCompte='".$idCompte."' and date=(SELECT CURDATE()) ORDER BY date DESC LIMIT ".$debut.", ".$taillePage."";
			if($sequence=="semaine")$r= "SELECT * FROM revenue WHERE idCompte='".$idCompte."' and YEARWEEK(date,1)=YEARWEEK(CURDATE(),1) ORDER BY date DESC LIMIT ".$debut.", ".$taillePage."";
			if($sequence=="annee")$r=	"SELECT * FROM revenue WHERE idCompte='".$idCompte."' and YEAR(date)=YEAR(CURRENT_DATE()) ORDER BY date DESC LIMIT ".$debut.", ".$taillePage."";
			$cnx = Database::getInstance();
			$res = $cnx->query($r);
		    foreach($res as $row) {
				$x = new Revenue();
				$x->loadFromArray($row);
				$liste->add($x);
		    }
			$res->closeCursor();
		    $cnx = null;
			return $liste;
		} catch (PDOException $e) {
		    print "Error!: " . $e->getMessage() . "<br/>";
		    return $liste;
		}	
	}
	// Fonction qui sert lors d'une recherche specifique
	public static function getPageRecherche($idCompte,$numPage,$taillePage,$parametre,$recherche){
		try {
			$liste = new Liste();
			$debut = ($numPage - 1)*$taillePage;
			// Par defaul on recherche le ontant
			$r="SELECT * FROM revenue WHERE idCompte='".$idCompte."' and montantrevenue like '".$recherche."%' ORDER BY montantRevenue LIMIT ".$debut.", ".$taillePage."";
			if($parametre=="nom")
				$r="SELECT * FROM revenue WHERE idCompte='".$idCompte."' and nomRevenue like '".$recherche."%' ORDER BY nomRevenue LIMIT ".$debut.", ".$taillePage."";
			if($parametre=="date")
				$r="SELECT * FROM revenue WHERE idCompte='".$idCompte."' and date like '".$recherche."%' ORDER BY date LIMIT ".$debut.", ".$taillePage."";
			if($parametre=="recurence")
				$r="SELECT * FROM revenue WHERE idCompte='".$idCompte."' and montantRevenue like '".$recherche."%' LIMIT ".$debut.", ".$taillePage."";
			$cnx = Database::getInstance();
			$res = $cnx->query($r);
		    foreach($res as $row) {
				$rev = new Revenue();
				$rev->loadFromArray($row);
				$liste->add($rev);
		    }
			//$res->closeCursor();
		    $cnx = null;
			return $liste;
		} catch (PDOException $e) {
		    print "Error!: " . $e->getMessage() . "<br/>";
		    return $liste;
		}	
	}
	public function update($r){
		$requete="UPDATE revenue
			SET montantRevenue='".$r->getMontant()."',nomRevenue='".$r->getNom()."',recurenceRevenue='".$r->getRecurence()."',idCompte='".$r->getIdCompte()."',
			date='".$r->getDate()."'
			WHERE idRevenue='".$r->getId()."'";
		try{return Database::getInstance()->exec($requete);}
		catch(PDOException $e){throw $e;}
	}
	public function delete($r){
		$requete="DELETE FROM revenue WHERE idRevenue='".$r."'";
		try{return Database::getInstance()->exec($requete);}
		catch(PDOException $e){throw $e;}
	}
	public function findTotalRevenuMois($compte,$mois){
		try{
			$db=Database::getInstance();
			$r=	"SELECT sum(montantRevenue) as MR FROM revenue WHERE idCompte='".$compte."' and MONTH(date)=(MONTH(Current_Date())-'".$mois."') and YEAR(date)=YEAR(Current_Date())";
			$resultat=$db->query($r);
			$db=null;
			return $resultat;
		}catch(PDOException $e){throw $e;}
	}
	
	public function findNomRevenuMois($compte,$mois){
		try{
			$db=Database::getInstance();
				$r=	"SELECT MONTHNAME(DATE_SUB(CURRENT_DATE(),INTERVAL '".$mois."' MONTH)) as NM";
			$resultat=$db->query($r);
			$db=null;
			return $resultat;
		}catch(PDOException $e){throw $e;}
	}
	
	public function findTotalRevenueQMois($compte){
		try{
			$db=Database::getInstance();
			$r="SELECT SUM(montantRevenue) as revenueTot FROM Revenue WHERE idCompte='".$compte."' and (date >= DATE_SUB(CURRENT_DATE(),INTERVAL 4 MONTH)and MONTH(date)<MONTH(Current_Date()))";
			$resultat=$db->query($r);
			$db=null;
			return $resultat;
		}catch(PDOException $e){throw $e;}
	}
}
?>
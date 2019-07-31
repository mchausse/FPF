<?php
/**
 * ================================
 * @titre : CategorieDAO.class.php
 * @author : Maxime Chausse
 * @date : 25.03.2018
 * @description : DAO d'une categorie
 * ================================
 */
 // ----- Import -----
include_once('/classes/Database.class.php');
include_once('/classes/Categorie.class.php');
include_once('/classes/Liste.class.php');
// ========== Code ==========
class CategorieDAO{
	public static function find($id,$c){
		// Connection a la base de donnee
		$db = Database::getInstance();
		// construction de la requete
		$pstmt = $db->prepare("SELECT * FROM categorie WHERE idCompte=:x and idCategorie = '".$c."'");
		$pstmt->execute(array(':x' => $id));
		$result = $pstmt->fetch(PDO::FETCH_OBJ);
		$cat = new Categorie();
		if ($result){
			$cat->setId($result->idCategorie);
			$cat->setNom($result->nomCategorie);
			$cat->setIdCompte($result->idCompte);
			$pstmt->closeCursor();
			return $cat;
		}
		$pstmt->closeCursor();
		return null;
	}
	public static function findNom($id,$nom){
		// Connection a la base de donnee
		$db = Database::getInstance();
		// construction de la requete
		$pstmt = $db->prepare("SELECT * FROM categorie WHERE idCompte=:x and nomCategorie = '".$nom."'");
		$pstmt->execute(array(':x' => $id));
		$result = $pstmt->fetch(PDO::FETCH_OBJ);
		$cat = new Categorie();
		if ($result){
			$cat->setId($result->idCategorie);
			$cat->setNom($result->nomCategorie);
			$cat->setIdCompte($result->idCompte);
			$pstmt->closeCursor();
			return $cat;
		}
		$pstmt->closeCursor();
		return null;
	}
	public function create($p){
		// La requete
		$r="INSERT INTO categorie (idCompte,nomCategorie)
				  VALUES ('".$p->getIdCompte()."','".$p->getNom()."')";
		try{return Database::getInstance()->exec($r);}
		catch(PDOException $e){return $e;}
	}
	// Tout trouver les depenses relier a un compte
	public static function findAll($id){
		try{
			$liste=new Liste();
			$db=Database::getInstance();
			$requete="SELECT * FROM categorie WHERE idCompte='".$id."'";
			$resultat=$db->query($requete);// **** Pourquoi pas en exec? *****
			foreach($resultat as $cat) {
				$c=new Categorie();
				$c->loadFromArray($cat);
				$liste->add($c);
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
	public function update($d){
		$r="UPDATE categorie
			SET idCompte='".$d->getIdCompte()."',nomCategorie='".$d->getNom()."'
			WHERE idCategorie='".$d->getId()."'";
		try{return Database::getInstance()->exec($r);}
		catch(PDOException $e){throw $e;}
	}
	public function delete($d){
		$r="DELETE FROM categorie WHERE idCategorie='".$d."'";
		try{return Database::getInstance()->exec($r);}
		catch(PDOException $e){throw $e;}
	}
	public function exists($id,$nom){
		$exists=false;
		if(!(self::findNom($id,$nom)==null))$exists=true;
		return $exists;
	}
}
?>
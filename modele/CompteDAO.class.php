<?php
/**
 * ================================
 * @titre : CompteDAO.class.php
 * @author : Maxime Chausse
 * @date : 21.03.2018
 * @description : DAO d'un compte
 * ================================
 */
 // ----- Import -----
include_once('/classes/Database.class.php');
include_once('/classes/Compte.class.php');
// ========== Code ==========
class CompteDAO{
	public static function find($id){
		// Connection a la base de donnee
		$db = Database::getInstance();
		// construction de la requete
		$pstmt = $db->prepare("SELECT * FROM compte WHERE email = :x");
		$pstmt->execute(array(':x' => $id));
		$result = $pstmt->fetch(PDO::FETCH_OBJ);
		if ($result){
			$c = new Compte();
			$c->setId($result->idCompte);
			$c->setEmail($result->email);
			$c->setPrenom($result->prenom);
			$c->setNom($result->nom);
			$c->setMotDePasse($result->motDePasse);
			$c->setBackground($result->background);
			$c->setConfig($result->config);
			$c->setIdCategorieConfig($result->idCategorieConfig);
			$pstmt->closeCursor();
			return $c;
		}
		$pstmt->closeCursor();
		return null;
	}
	public static function findNomByEmail($email){
		// Connection a la base de donnee
		$db = Database::getInstance();
		// construction de la requete
		$pstmt = $db->prepare("SELECT prenom,nom FROM compte WHERE email = :x");
		$pstmt->execute(array(':x' => $email));
		$result = $pstmt->fetch(PDO::FETCH_OBJ);
		if ($result)return $result->prenom." ".$result->nom;
		$pstmt->closeCursor();
		return null;
	}
	public static function findIdByEmail($email){
		// Connection a la base de donnee
		$db = Database::getInstance();
		// construction de la requete
		$pstmt = $db->prepare("SELECT idCompte FROM compte WHERE email = :x");
		$pstmt->execute(array(':x' => $email));
		$result = $pstmt->fetch(PDO::FETCH_OBJ);
		if ($result)return $result->idCompte;
		$pstmt->closeCursor();
		return null;
	}
	public function create($c) {
		$r="INSERT INTO compte (email ,prenom ,nom ,motDePasse,background,config,idCategorieConfig) 
			VALUES ('".$c->getEmail()."','".$c->getPrenom()."','".$c->getNom()."','".$c->getMotDePasse()."','".$c->getBackground()."',1,'".$c->getIdCategorieConfig()."')";
		try{
			$db=Database::getInstance();
			return $db->exec($r);
		}
		catch(PDOexception $e){;return $e;}
	}
	public function update($c){
		$r="UPDATE compte
			SET email='".$c->getEmail()."',prenom='".$c->getPrenom()."',nom='".$c->getNom()."',motDePasse='".$c->getMotDePasse()."',background='".$c->getBackground()."',config='".$c->getConfig()."',idCategorieConfig='".$c->getIdCategorieConfig()."'
			WHERE idCompte='".$c->getId()."'";
		try{
			$db=Database::getInstance();
			return $db->exec($r);
		}
		catch(PDOException $e){throw $e;}
	}
	public function delete($c) {
		$r="DELETE FROM compte WHERE idCompte='".$c."'";
		try{
			$db=Database::getInstance();
			return $db->exec($r);
		}
		catch(PDOException $e){throw $e;}
	}
}
?>

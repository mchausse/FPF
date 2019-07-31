<?php
/**
 * ================================
 * @description : Classe qui represente la categorie d'une depense
 * @titre : Categorie.php
 * @author : Maxime Chausse
 * @date : 07.03.2018
 * ================================
 */
class Categorie{
    // ---------- Variables ----------
    private $id,$idCompte,$nom;
    // ---------- Methodes ----------
    // ----- Getter
    public function getId(){return $this->id;}
    public function getIdCompte(){return $this->idCompte;}
    public function getNom(){return $this->nom;}
    // ----- Setter
    public function setId($_id){$this->id=$_id;}
    public function setIdCompte($_id){$this->idCompte=$_id;}
    public function setNom($_nom){$this->nom=$_nom;}
    // ----- Autre
    public function loadFromArray($_a){
        $this->id=$_a["idCategorie"];
        $this->idCompte=$_a["idCompte"];
        $this->nom=$_a["nomCategorie"];
    }
    public function loadFromObject($_o){
        $this->id=$_o->id;
        $this->idCompte=$_o->idCompte;
        $this->nom=$_o->nom;
    }
    // ---------- Affichage ----------
}

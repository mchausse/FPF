<?php
/**
 * ================================
 * @description : Classe qui represente un revenue d'un compte
 * @titre : Revenue.php
 * @author : Maxime Chausse
 * @date : 07.03.2018
 * ================================
 */
class Revenue{
    // ---------- Variables ----------
    private $id,$montant,$nom,$recurence,$idCompte,$date;
    // ---------- Methodes ----------
    // ----- Getter
    public function getId(){return $this->id;}
    public function getMontant(){return $this->montant;}
    public function getNom(){return $this->nom;}
    public function getRecurence(){return $this->recurence;}
    public function getIdCompte(){return $this->idCompte;}
	public function getDate(){return $this->date;}
    // ----- Setter
    public function setId($_id){$this->id=$_id;}
    public function setMontant($_montant){$this->montant=$_montant;}
    public function setNom($_nom){$this->nom=$_nom;}
    public function setRecurence($_value){$this->recurence=$_value;}
    public function setIdCompte($_id){$this->idCompte=$_id;}
	public function setDate($_d){$this->date=$_d;}
    // ----- Autre
    public function loadFromArray($_a){
        $this->id=$_a["idRevenue"];
        $this->montant=$_a["montantRevenue"];
        $this->nom=$_a["nomRevenue"];
        $this->recurence=$_a["recurenceRevenue"];
        $this->idCompte=$_a["idCompte"];
		$this->date=$_a["date"];
    }
    public function loadFromObject($_o){
        $this->id=$_o->idRevenue;
        $this->montant=$_o->montantRevenue;
        $this->nom=$_o->nomRevenue;
        $this->recurence=$_o->recurenceRevenue;
        $this->idCompte=$_o->idCompte;
		$this->date=$_o->date;
    }
    // ---------- Affichage ----------
}

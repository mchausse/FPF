<?php
/**
 * ================================
 * @description : Classe qui represente une depense d'un compte
 * @titre : Depense.php
 * @author : Maxime Chausse
 * @date : 07.03.2018
 * ================================
 */
class Depense{
    // ---------- Variables ----------
    private $id,$montant,$nom,$recurence,$note,$idCategorie,$idCompte,$date,$remboursable,$nomPersonne;
    // ---------- Methodes ----------
    // ----- Getter
    public function getId(){return $this->id;}
    public function getMontant(){return $this->montant;}
    public function getNom(){return $this->nom;}
    public function getRecurence(){return $this->recurence;}
    public function getNote(){return $this->note;}
    public function getIdCategorie(){return $this->idCategorie;}
    public function getIdCompte(){return $this->idCompte;}
    public function getDate(){return $this->date;}
    public function getRemboursable(){return $this->remboursable;}
    public function getNomPersonne(){return $this->nomPersonne;}
    // ----- Setter
    public function setId($_id){$this->id=$_id;}
    public function setMontant($_montant){$this->montant=$_montant;}
    public function setNom($_nom){$this->nom=$_nom;}
    public function setRecurence($_value){$this->recurence=$_value;}
    public function setNote($_note){$this->note=$_note;}
    public function setIdCategorie($_id){$this->idCategorie=$_id;}
    public function setIdCompte($_id){$this->idCompte=$_id;}
    public function setDate($_d){$this->date=$_d;}
    public function setRemboursable($_valeur){$this->remboursable=$_valeur;}
    public function setNomPersonne($_nom){$this->nomPersonne=$_nom;}
    // ----- Autre
    public function ajouterNote($s){$this->note.=$s;}
    public function loadFromArray($_a){
        $this->id=$_a["idDepense"];
        $this->montant=$_a["montantDepense"];
        $this->nom=$_a["nomDepense"];
        $this->recurence=$_a["recurenceDepense"];
        $this->note=$_a["note"];
        $this->idCategorie=$_a["idCategorie"];
        $this->idCompte=$_a["idCompte"];
        $this->date=$_a["dateDepense"];
        $this->remboursable=$_a["remboursable"];
        $this->nomPersonne=$_a["nomPersonne"];
    }
    public function loadFromObject($_o){
        $this->id=$_o->id;
        $this->montant=$_o->montant;
        $this->nom=$_o->nom;
        $this->recurence=$_o->recurence;
        $this->note=$_o->note;
        $this->idCategorie=$_o->idCategorie;
        $this->idCompte=$_o->idCompte;
        $this->date=$_o->date;
        $this->remboursable=$_o->remboursable;
        $this->nomPersonne=$_o->nomPersonne;
    }
    // ---------- Affichage ----------
}

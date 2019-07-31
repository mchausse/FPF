<?php
/**
 * ================================
 * @description : Classe qui represente un compte d'un usager
 * @titre : Compte.class.php
 * @author : Maxime Chausse
 * @date : 07.03.2018
 * ================================
 */
class Compte{
    // ---------- Variables ----------
    private $id,$email,$prenom,$nom,$motDePasse,$background,$config,$idCategorieConfig;
    // ---------- Methodes ----------
    // ----- Getter
    public function getId(){return $this->id;}
    public function getEmail(){return $this->email;}
    public function getPrenom(){return $this->prenom;}
    public function getNom(){return $this->nom;}
    public function getMotDePasse(){return $this->motDePasse;}
    public function getBackground(){return $this->background;}
    public function getConfig(){return $this->config;}
    public function getIdCategorieConfig(){return $this->idCategorieConfig;}
    // ----- Setter
    public function setId($_id){$this->id=$_id;}
    public function setEmail($_email){$this->email=$_email;}
    public function setPrenom($_prenom){$this->prenom=$_prenom;}
    public function setNom($_nom){$this->nom=$_nom;}
    public function setMotDePasse($_motDePasse){$this->motDePasse=$_motDePasse;}
    public function setBackground($_background){$this->background=$_background;}
    public function setConfig($_config){$this->config=$_config;}
    public function setIdCategorieConfig($_idCategorieConfig){$this->idCategorieConfig=$_idCategorieConfig;}
    // ----- Autre
    public function loadFromArray($_a){
        $this->id=$_a["idCompte"];
        $this->email=$_a["email"];
        $this->prenom=$_a["prenom"];
        $this->nom=$_a["nom"];
        $this->motDePasse=$_a["motDePasse"];
        $this->background=$_a["background"];
        $this->config=$_a["config"];
        $this->idCategorieConfig=$_a["idCategorieConfig"];
    }
    public function loadFromObject($_a){
        $this->id=$_a->id;
        $this->email=$_a->email;
        $this->prenom=$_a->prenom;
        $this->nom=$_a->nom;
        $this->motDePasse=$_a->motDePasse;
        $this->background=$_a->background;
        $this->config=$_a->config;
        $this->idCategorieConfig=$_a->idCategorieConfig;
    }
    // ---------- Affichage ----------
}

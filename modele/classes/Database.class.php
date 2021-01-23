<?php
/**
 * ================================
 * @description : Classe de connexion a la base de donnees
 * @titre : Database.php
 * @author : Maxime Chausse
 * @date : 07.03.2018
 * ================================
 */
require_once('../modele/config/config.php');
class Database {
    // ---------- Variables ----------
    private static $instance = NULL;
    // ---------- Constructeur ----------
    private function __construct(){} // C par defaut
    // ---------- Methodes ----------
    public static function getInstance(){
        if(self::$instance == NULL)
            try {
                self::$instance = new PDO(
                        "mysql:host=".Config::DB_HOST.";dbname=".Config::DB_NAME."",Config::DB_USER, Config::DB_PWD);
            }
            catch (PDOException $ex){self::$instance = NULL;}
        return self::$instance;
    }
    public static function close(){self::$instance = NULL;}
}

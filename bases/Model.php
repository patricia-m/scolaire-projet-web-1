<?php

class Model {
    /**
     * Toutes les instances contiennent la même connexion
     *
     * @var PDO|null
     */
    private static $pdo = null;
    protected $table = null;

    /**
     * Constructeur   
     */
    public function __construct(){}

    /**
     * Retourne la connexion PDO et se connecte au besoin
     *
     * @return PDO
     */
    protected function pdo(){
        if(static::$pdo == null){
            require "config/database.php";
            static::$pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

            // Options de connexion
            static::$pdo->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, "SET NAMES 'utf8'");
            static::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            static::$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        }

        // Message d'erreur au développeur si le nom de la table n'a pas été défini dans le modèle-enfant
        if($this->table == null){
            trigger_error("Le nom de la table n'a pas été défini dans le modèle " . get_called_class(), E_USER_ERROR);
        }
        return static::$pdo;
    }

    /**
     * Retourne tous les résultats de la table associée au modèle
     *
     * @return array|false Tableau associatif ou false si erreur
     */
    public function tout(){
    
        $sql = "SELECT *
                FROM $this->table";

        $stmt = $this->pdo()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Retourne un élément du modèle selon un id
     *
     * @param int $id
     * @return array|false Tableau associatif ou false si erreur
     */
    public function parId(int $id) {

        $sql = "SELECT *
                FROM $this->table
                WHERE id = :id";
        
        $stmt = $this->pdo()->prepare($sql);
        $stmt->execute([
            ":id" => $id
        ]);

        return $stmt->fetch();
    }

    /**
     * Supprime une colonne de la base ed données selon un id spécifique
     *
     * @param int $id
     * @return boolean
     */
    public function supprimerParId(int $id) {
        $sql = "DELETE FROM $this->table
                WHERE id = :id";

        $stmt = $this->pdo()->prepare($sql); 
        return $stmt->execute([
            ":id" => $id
        ]);
    }
}
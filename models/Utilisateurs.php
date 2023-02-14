<?php
require_once("bases/Model.php");

class Utilisateurs extends Model {
    protected $table = "utilisateurs";

    /**
     * Retourne les informations d'un utilisateur selon un courriel spécifique
     * 
     * @param string $courriel
     * @return array|false Retourne les informations de l'utilisateur ou faux si l'utilisateur n'existe pas
     */
    public function parCourriel(string $courriel) {

        $sql = "SELECT *
                FROM $this->table
                WHERE courriel = :courriel";

        $stmt = $this->pdo()->prepare($sql);

        $stmt->execute([
            ":courriel" => $courriel
        ]);

        return $stmt->fetch();
    }

    /**
     * Création d'un nouvel utilisateur
     *
     * @param string $prenom
     * @param string $nom
     * @param string $courriel   
     * @param string $mot_de_passe  Mot de passe non encrypté
     * 
     * @return bool Retourne false si erreur d'insertion
     */
    public function creer(string $prenom, string $nom, string $courriel, string $mot_de_passe) {

        // type : 2 = utilisateur régulier
        $sql = "INSERT INTO $this->table (prenom, nom, courriel, mot_de_passe, type) 
                VALUES (:prenom, :nom, :courriel, :mot_de_passe, 2)";

        $stmt = $this->pdo()->prepare($sql);

        return $stmt->execute([
            ":prenom" => $prenom,
            ":nom" => $nom,
            ":courriel" => $courriel,
            ":mot_de_passe" => password_hash($mot_de_passe, PASSWORD_DEFAULT),
        ]);
    }

    /**
     * Modification d'un utilisateur existant
     *
     * @param int $id
     * @param string $prenom
     * @param string $nom
     * @param string $courriel   
     * 
     * @return bool Retourne false si erreur d'insertion
     */
    public function modifier(int $id, string $prenom, string $nom, string $courriel) {
        $sql = "UPDATE $this->table 
                SET prenom = :prenom, nom = :nom, courriel = :courriel
                WHERE $this->table.id = :id";

        $stmt = $this->pdo()->prepare($sql);

        return $stmt->execute([
            ":id" => $id,
            ":prenom" => $prenom,
            ":nom" => $nom,
            ":courriel" => $courriel,
        ]);
    }
}
<?php
require_once("bases/Model.php");

class Plats extends Model {
    protected $table = "plats";

    /**
     * Retourne tous les plats associées à une categorie spécifique
     *
     * @param int $categorie_id
     * @return array|false Tableau associatif contenant tous les plats d'une catégorie ou false si erreur
     */    
    public function toutParCategorie(int $categorie_id) {

        $sql = "SELECT $this->table.*
                FROM $this->table
                JOIN categories ON $this->table.categorie_id = categories.id
                WHERE $this->table.categorie_id = :categorie_id";

        $stmt = $this->pdo()->prepare($sql);
        $stmt->execute([
            ":categorie_id" => $categorie_id
        ]);

        return $stmt->fetchAll();
    }

    /**
     * Création d'un nouveau plat
     *
     * @param string $nom
     * @param string $prix
     * @param string $description
     * @param int $categorie
     * @param string|null $image
     * @return bool Retourne false si erreur d'insertion
     */
    public function creer(string $nom, string $prix, string $description, int $categorie, string $image = null) {

        $sql = "INSERT INTO $this->table (nom, prix, description, categorie_id, image) 
                VALUES (:nom, :prix, :description, :categorie, :image)";

        $stmt = $this->pdo()->prepare($sql);

        return $stmt->execute([
            ":nom" => $nom,
            ":prix" => $prix,
            ":description" => $description,
            ":categorie" => $categorie,
            ":image" => $image,
        ]);
    }

    /**
     * Retourne tous les plats ET la catégorie associée
     *
     * @param int $id
     * @return array|false Tableau associatif ou false si erreur
     */
    public function parIdAvecCategorie(int $id) {

        $sql = "SELECT $this->table.*, categories.nom AS categorie_nom
                FROM $this->table
                JOIN categories ON $this->table.categorie_id = categories.id
                WHERE $this->table.id = :id";
        
        $stmt = $this->pdo()->prepare($sql);
        $stmt->execute([
            ":id" => $id
        ]);

        return $stmt->fetch();
    }

    /**
     * Modification d'un plat existant
     *
     * @param int $id
     * @param string $nom
     * @param string $prix
     * @param string $description
     * @param int $categorie
     * @param string $image
     * 
     * @return bool Retourne false si erreur d'insertion
     */
    public function modifier(int $id, string $nom, string $prix, string $description, int $categorie_id, string $image = null) {

        $sql = "UPDATE $this->table 
                SET nom = :nom, prix = :prix, description = :description, categorie_id = :categorie_id, image = :image 
                WHERE $this->table.id = :id";

        $stmt = $this->pdo()->prepare($sql);

        return $stmt->execute([
            ":id" => $id,
            ":nom" => $nom,
            ":prix" => $prix,
            ":description" => $description,
            ":categorie_id" => $categorie_id,
            ":image" => $image,
        ]);
    }

}
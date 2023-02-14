<?php
require_once("bases/Model.php");

class Categories extends Model {
    protected $table = "categories";

    /**
     * Retourne toutes les catégorie en ordre
     *
     * @return array|false Tableau associatif contenant toutes les catégorie en ordre ou false si erreur
     */
    public function toutParOrdre(){
    
        $sql = "SELECT *
                FROM $this->table
                ORDER BY $this->table.ordre ASC";

        $stmt = $this->pdo()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Création d'une nouvelle catégorie
     *
     * @param string $nom
     * @param int $ordre
     * 
     * @return bool Retourne false si erreur d'insertion
     */
    public function creer(string $nom, int $ordre) {
        $sql = "INSERT INTO $this->table (nom, ordre) 
                VALUES (:nom, :ordre)";
        // 2 = utilisateur régulier

        $stmt = $this->pdo()->prepare($sql);

        return $stmt->execute([
            ":nom" => $nom,
            ":ordre" => $ordre,
        ]);
    }

    /**
     * Modification d'une catégorie existante
     *
     * @param int $id
     * @param string $nom
     * @param int $ordre
     * 
     * @return bool Retourne false si erreur d'insertion
     */
    public function modifier(int $id, string $nom, int $ordre) {
        $sql = "UPDATE $this->table 
                SET nom = :nom, ordre = :ordre 
                WHERE $this->table.id = :id";

        $stmt = $this->pdo()->prepare($sql);

        return $stmt->execute([
            ":id" => $id,
            ":nom" => $nom,
            ":ordre" => $ordre,
        ]);
    }

    /**
     * Décale l'ordre des catégories à partir de la catégorie sélectionnée
     *
     * @param int $nouvel_ordre
     * @return bool Retourne false si erreur d'insertion
     */
    public function decalerOrdre(int $nouvel_ordre) {
        $sql = "UPDATE $this->table 
                SET ordre = (ordre + 1) 
                WHERE ordre >= :nouvel_ordre";

        $stmt = $this->pdo()->prepare($sql);

        return $stmt->execute([
            ":nouvel_ordre" => $nouvel_ordre,
        ]);
    }

}
<?php
require_once("bases/Model.php");

class InscriptionsInfolettre extends Model {
    protected $table = "inscriptions_infolettre";

    /**
     * Création d'une nouvelle inscription à l'infolettre
     *
     * @param string $nom
     * @param string $courriel   
     * 
     * @return bool Retourne false si erreur d'insertion
     */
    public function creer(string $nom, string $courriel) {
        $sql = "INSERT INTO $this->table (nom, courriel) 
                VALUES (:nom, :courriel)";

        $stmt = $this->pdo()->prepare($sql);

        return $stmt->execute([
            ":nom" => $nom,
            ":courriel" => $courriel,
        ]);
    }

}
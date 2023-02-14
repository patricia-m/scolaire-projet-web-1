<?php

abstract class Controller {
    public function __construct(){}

    /**
     * Affiche la page d'erreur 404
     *
     * @return void
     */
    public function erreur404(){
       $this->vue("erreur404", ["titre" => "Erreur 404"]);
    }

    /**
     * Téléverse un fichier dans le dossier public/uploads
     *
     * @param string $nom L'attribut name de la balise input de type file
     * @param array|null $type_valides (facultatif) Une tableau contenant la liste des extensions possibles
     * 
     * @return string|null
     */
    protected function televerser(string $nom, ?array $type_valides = null){
        // Traitement du fichier
        $upload = new Upload($nom, $type_valides);

        // Déplacement du fichier et récupération du chemin (ou null) 
        return $upload->estValide() ? $upload->placerDans("public/uploads") : null;
    }

     /**
     * Redirige à une route
     *
     * @param string $route
     * @param array|null $parametres (facultatif) Tableau associatif du nom du paramètre (clé) et de la valeur du paramètre
     * @param string $hash
     * 
     * @return void
     */
    protected function rediriger(string $route, ?array $parametres = null, string $hash = ""){
        $chemin = $route;

        if($parametres){
            $chemin .= "?";
            $compteur = 0;
            $taille = count($parametres);

            foreach($parametres as $nom => $valeur){
                $chemin .= $nom . "=" . $valeur;
                if($compteur < $taille - 1){
                    $chemin .= "&";
                }
                $compteur++;
            }            
        }

        header("location:" . $chemin . $hash);
        exit();
    }

    /**
     * Valide la réception d'un formulaire sur la route et redirige si ce n'est pas le cas
     *
     * @param string $route
     * @return void
     */
    protected function validerReceptionFormulaire(string $route){
        if (empty($_POST)) {
            $this->rediriger($route);
        }
    }

    /**
     * Valide les champs d'un formulaire
     *
     * @param array $champs Tableau indexé contenant le nom des champs 
     * @return bool
     */
    protected function validerChamps(array $champs){
        foreach($champs as $champ){
            if(empty($_POST[$champ])){
                return false;
            }
        }
        return true;
    }

    /**
     * Valide la connexion de l'utilisateur
     *
     * @param string $cle
     * @return bool
     */
    protected function validerConnexion(string $cle){
        return ! empty($_SESSION[$cle]);
    }

    /**
     * Affiche une vue
     *
     * @param string $nom
     * @param array $donnees
     * @return void
     */
    protected function vue(string $nom, ?array $donnees = null){
        if($donnees) extract($donnees);
        include("views/" . $nom . ".view.php");
    }

    /**
     * Vérifie le format du prix saisi par l'utilisateur
     * 
     * Remplace la virgule par un point
     * Vérifie le format du prix
     *
     * @param string $prix
     * @param string $chemin
     * @param array $params
     * 
     * @return float $prix
     */
    protected function verifierPrix(string $prix_a_verifier, string $chemin, array $params) {
        $prix = str_replace(',', ".", $prix_a_verifier);
        $regex = "/^[0-9]+(\.[0-9]+)?$/";
        if(preg_match($regex, $prix) != 1) {
            $this->rediriger($chemin, $params);
        }
        return $prix;
    }
}
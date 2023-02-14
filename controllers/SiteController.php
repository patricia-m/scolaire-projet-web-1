<?php

require_once("bases/Controller.php");
require_once("utils/Upload.php");

require_once("models/InscriptionsInfolettre.php");
require_once("models/Plats.php");
require_once("models/Categories.php");
require_once("models/Utilisateurs.php");


class SiteController extends Controller {

    /**
     * Affiche la page d'accueil
     *
     * @return void
     */
    public function index() {
        $this->vue("index", ["titre" => "Accueil | PUB G4"]);
    }

    /**
     * Affiche la page de menu
     *
     * @return void
     */
    public function afficherMenu() {
        $this->vue("menu", [
            "titre" => "Menu | PUB G4", 
            "categories" =>(new Categories())->toutParOrdre(),
            "plats" => (new Plats()),
        ]);
    }

    /**
     * Affiche la page à propos
     *
     * @return void
     */
    public function afficherAPropos() {
        $this->vue("a-propos", ["titre" => "À propos | PUB G4"]);
    }

    /**
     * Affiche la page nous joindre
     *
     * @return void
     */
    public function afficherNousJoindre() {
        $this->vue("nous-joindre", ["titre" => "Nous joindre | PUB G4"]);
    }

    /**
     * Ajoute une inscription à l'infolettre
     *
     * @return void
     */
    public function ajouterInfolettreSubmit() {
        $this->validerReceptionFormulaire("index");

        // Traitement de l'url - effacer les paramètres de l'url précédent
        $url_a_traiter = strpos($_SERVER['HTTP_REFERER'], "?", 0);
        
        if($url_a_traiter != false) {
            $url = substr($_SERVER['HTTP_REFERER'], 0, $url_a_traiter);
        } else {
            $url = $_SERVER['HTTP_REFERER'];
        }
        
        if(! $this->validerChamps(["nom", "courriel"])){
            $this->rediriger($url, ["champs_vide" => 1], "#infolettre");
        }

        // Validation du maximum de caractères 
        if(strlen($_POST["nom"]) > 100) {
            $this->rediriger($url, ["erreur_max_nom" => 1], "#infolettre");
        }
        if(strlen($_POST["courriel"]) > 255) {
            $this->rediriger($url, ["erreur_max_courriel" => 1], "#infolettre");
        }

        // Création de l'utilisateur
        try { 
            $succes_ajout_infolettre = (new InscriptionsInfolettre())->creer($_POST["nom"], $_POST["courriel"]);
        } catch (\Throwable $th) {
            $this->rediriger($url, ["erreur_existant" => 1], "#infolettre");
        }

        // Redirection en cas de succes
        if($succes_ajout_infolettre){
            $this->rediriger($url, ["succes" => 1], "#infolettre");
        }

        // Redirection en cas d'erreur
        $this->rediriger($url, ["erreur" => 1], "#infolettre");
    }

    // -------------------------------------------------------------------------------------------------------- SECTION ADMIN

    /**
     * Affiche la page de connexion à l'administration
     *
     * @return void
     */
    public function afficherConnexion() {
        // Si un utilisateur est déjà connecté, rediriger à l'acceuil de l'administration
        if($this->validerConnexion("utilisateur_id")) {
            $this->rediriger("administration");
        }

        $this->vue("admin-connexion", ["titre" => "Connexion | Administration"]);
    }

    /**
     * Traite les informations de connexion
     *
     * @return void
     */
    public function connecterSubmit(){
        $this->validerReceptionFormulaire("admin");

        if(!$this->validerChamps(["courriel", "mot_de_passe"])) {
            $this->rediriger("admin", ["champs_vide" => 1]);
        }

        // Récupération des information de l'utilisateur
        $succes_utilisateur = (new Utilisateurs())->parCourriel($_POST["courriel"]);

        // Vérification que l'utilisateur existe
        // Vérification du mot de passe
        // Redirection en cas d'erreur
        if(!$succes_utilisateur || !password_verify($_POST["mot_de_passe"], $succes_utilisateur["mot_de_passe"])) {
            $this->rediriger("admin", ["erreur" => 1]);
        }

        // Redirection si la connexion est réussie
        $_SESSION["utilisateur_id"] = $succes_utilisateur["id"];
        $_SESSION["utilisateur_prenom"] = $succes_utilisateur["prenom"];
        $_SESSION["utilisateur_type"] = $succes_utilisateur["type"];

        $this->rediriger("administration");
    }

    /**
     * Affiche l'administration 
     * 
     * Affiche les catégories, les plats et les utilisateurs (utilisateurs si admin seulement)
     *
     * @return void
     */
    public function afficherAdministration() {
        if(!$this->validerConnexion("utilisateur_id")) {
            $this->rediriger("admin");
        }

        // Inclusion de la vue et envoi des données
        $this->vue("admin-accueil", [
            "titre" => "Accueil | Administration",
            "utilisateurs" => (new Utilisateurs())->tout(),
            "categories" => (new Categories())->toutParOrdre(),
            "plats" => (new Plats()),
        ]);
    }

    /**
     * Déconnecte l'utilisateur
     *
     * @return void
     */
    public function deconnecterCompte() {
        if(!$this->validerConnexion("utilisateur_id")) {
            $this->rediriger("admin");
        }

        // Oublier/effacer les données de l'utilisateur
        $_SESSION["utilisateur_id"] = null;
        $_SESSION["utilisateur_prenom"] = null;
        $_SESSION["utilisateur_type"] = null;

        $this->rediriger("admin", ["deconnexion" => 1]);
    }

    // -------------------------------------------------------------------------------------------------------- AJOUTS

    /**
     * Affiche la page d'ajout d'une categorie
     *
     * @return void
     */
    public function afficherAjoutCategorie() {
        $this->vue("admin-ajout-categorie", [
            "titre" => "Ajout d'une catégorie | Administration",
            "categories" => (new Categories())->toutParOrdre(),
        ]);
    }

    /**
     * Traite les informations soumises lors de la création d'une catégorie
     *
     * @return void
     */
    public function ajouterCategorieSubmit(){
        $this->validerReceptionFormulaire("ajout-categorie");

        if(! $this->validerChamps(["nom", "ordre"])){
            $this->rediriger("ajout-categorie", ["champs_vide" => 1]);
        }

        // Validation du maximum de caractères 
        if(strlen($_POST["nom"]) > 100) {
            $this->rediriger("ajout-categorie", ["erreur_max_nom" => 1]);
        }

        // Gestion de l'ordre des catégories
        $categorie_model = new Categories();
        $categorie_model->decalerOrdre($_POST["ordre"]);

        // Création de la catégorie
        $succes_creation_categorie = $categorie_model->creer($_POST["nom"], $_POST["ordre"]);  

        // Redirection en cas de succes
        if($succes_creation_categorie){
            $this->rediriger("administration", ["categorie_succes" => 1]); 
        }
        // Redirection en cas d'erreur
        $this->rediriger("ajout-categorie", ["erreur" => 1]);
    }

    /**
     * Affiche la page d'ajout d'un utilisateur
     *
     * @return void
     */
    public function afficherAjoutUtilisateur() {
        $this->vue("admin-ajout-utilisateur", ["titre" => "Ajout d'un utilisateur | Administration"]);
    }

    /**
     * Traite les informations soumises lors de la création d'un utilisateur
     *
     * @return void
     */
    public function ajouterUtilisateurSubmit(){
        $this->validerReceptionFormulaire("ajout-utilisateur");

        if(! $this->validerChamps(["prenom", "nom", "courriel", "mot_de_passe"])){
            $this->rediriger("ajout-utilisateur", ["champs_vide" => 1]);
        }

        // Validation du maximum de caractères 
        if(strlen($_POST["prenom"]) > 100) {
            $this->rediriger("ajout-utilisateur", ["erreur_max_prenom" => 1]);
        }
        if(strlen($_POST["nom"]) > 100) {
            $this->rediriger("ajout-utilisateur", ["erreur_max_nom" => 1]);
        }
        if(strlen($_POST["courriel"]) > 255) {
            $this->rediriger("ajout-utilisateur", ["erreur_max_courriel" => 1]);
        }
        if(strlen($_POST["mot_de_passe"]) > 100) {
            $this->rediriger("ajout-utilisateur", ["erreur_max_mdp" => 1]);
        }

        // Création de l'utilisateur
        try { 
            $succes_ajout_utilisateur = (new Utilisateurs())->creer($_POST["prenom"], $_POST["nom"], $_POST["courriel"], $_POST["mot_de_passe"]);
        } catch (\Throwable $th) {
            $this->rediriger("ajout-utilisateur", ["erreur_existant" => 1]);
        }

        // Redirection en cas de succes
        if($succes_ajout_utilisateur){
            $this->rediriger("administration", ["compte_succes" => 1]); 
        }

        // Redirection en cas d'erreur
        $this->rediriger("ajout-utilisateur", ["erreur" => 1]);
    }

    /**
     * Affiche la page d'ajout d'un repas
     *
     * @return void
     */
    public function afficherAjoutPlat() {
        $this->vue("admin-ajout-plat", [
            "titre" => "Ajout d'un repas | Administration",
            "categories" => (new Categories())->toutParOrdre(),
        ]);
    }
    
    /**
     * Traite les informations soumises lors de la création d'un repas
     *
     * @return void
     */
    public function ajouterPlatSubmit() {
        $this->validerReceptionFormulaire("ajout-plat");
        
        if(! $this->validerChamps(["nom", "prix", "description", "categorie"])){
            $this->rediriger("ajout-plat", ["champs_vide" => 1]);
        }

        // Validation du maximum de caractères 
        if(strlen($_POST["nom"]) > 100) {
            $this->rediriger("ajout-plat", ["erreur_max_nom" => 1]);
        }
        
        // Vérification et formatage du prix
        $prix = $this->verifierPrix($_POST["prix"], "ajout-plat", [
            "id" => $_POST["id"],
            "erreur_prix" => 1,
        ]);
        
        // Téléversement de l'image
        $image = $this->televerser("image", ["jpg", "jpeg", "png", "webp"]);
        
        $succes_creation_plat = (new Plats())->creer($_POST["nom"], $prix, $_POST["description"], $_POST["categorie"], $image);
        
        // Redirection en cas de succès
        if($succes_creation_plat){
            $this->rediriger("administration", ["plat_succes" => 1]); 
        }
        
        // Redirection en cas d'erreur
        $this->rediriger("ajout-plat", ["erreur" => 1]); 
    }

    // -------------------------------------------------------------------------------------------------------- MODIFICATIONS

    /**
     * Affiche le formulaire de modification d'une catégorie
     *
     * @return void
     */
    public function afficherModificationCategorie()
    {
        if (empty($_GET["id"])) {
            $this->rediriger("administration");
        }

        // Récupération de la catégorie sélectionnée
        $categorie = (new Categories())->parId($_GET["id"]);
        // Récupération de toutes les catégories pour le select
        $categories = (new Categories())->toutParOrdre();

        // Trouver l'index de $categorie dans $categories
        $index_categorie = null;

        foreach ($categories as $i => $cat) {
            if ($categorie["id"] == $cat["id"]) {
                $index_categorie = $i;
            }
        }

        $this->vue("admin-modification-categorie", [
            "titre" => "Modification d'une catégorie | Administration",
            "categorie" => $categorie,
            "categories" => $categories,
            "index_categorie" => $index_categorie,
        ]);
    }

    /**
     * Traite les informations soumises lors de la modification d'une catégorie
     *
     * @return void
     */
    public function modifierCategorieSubmit()
    {
        $this->validerReceptionFormulaire("administration");

        if (!$this->validerChamps(["nom", "ordre"])) {
            $this->rediriger("modification-categorie", [
                "id" => $_POST["id"],
                "champs_vide" => 1,
            ]);
        }

        // Validation du maximum de caractères 
        if(strlen($_POST["nom"]) > 100) {
            $this->rediriger("modification-categorie", ["id" => $_POST["id"], "erreur_max_nom" => 1]);
        }

        // Gestion de l'ordre des catégories
        $categorie_model = new Categories();

        if ($_POST["ordre"] != $_POST["ancien_ordre"]) {
            $categorie_model->decalerOrdre($_POST["ordre"]);
        }

        // Modification de la catégorie
        $succes_modification_categorie = $categorie_model->modifier($_POST["id"], $_POST["nom"], $_POST["ordre"]);

        // Redirection en cas de succes
        if ($succes_modification_categorie) {
            $this->rediriger("administration", ["categorie_modif_succes" => 1]);
        }

        // Redirection en cas d'erreur
        $this->rediriger("modification-categorie", [
            "id" => $_POST["id"],
            "erreur" => 1,
        ]);
    }
    
    /**
     * Affiche le formulaire de modification d'un utilisateur
     *
     * @return void
     */
    public function afficherModificationUtilisateur() {
        if(empty($_GET["id"])) {
            $this->rediriger("administration");
        }

        $this->vue("admin-modification-utilisateur", [
            "titre" => "Modification d'un utilisateur | Administration",
            "utilisateur" =>(new Utilisateurs())->parId($_GET["id"]),
        ]);
    }

    /**
     * Traite les informations soumises lors de la modification d'un utilisateur
     *
     * @return void
     */
    public function modifierUtilisateurSubmit(){
        $this->validerReceptionFormulaire("administration");

        if(! $this->validerChamps(["prenom", "nom", "courriel"])){
            $this->rediriger("modification-utilisateur", [
                "id" => $_POST["id"],
                "champs_vide" => 1
            ]);
        }

        // Validation du maximum de caractères 
        if(strlen($_POST["prenom"]) > 100) {
            $this->rediriger("modification-utilisateur", ["id" => $_POST["id"], "erreur_max_prenom" => 1]);
        }
        if(strlen($_POST["nom"]) > 100) {
            $this->rediriger("modification-utilisateur", ["id" => $_POST["id"], "erreur_max_nom" => 1]);
        }
        if(strlen($_POST["courriel"]) > 255) {
            $this->rediriger("modification-utilisateur", ["id" => $_POST["id"], "erreur_max_courriel" => 1]);
        }
        if(strlen($_POST["mot_de_passe"]) > 100) {
            $this->rediriger("modification-utilisateur", ["id" => $_POST["id"], "erreur_max_mdp" => 1]);
        }

        // Modification de l'utilisateur
        try { 
            $succes_modification_utilisateur = (new Utilisateurs())->modifier($_POST["id"], $_POST["prenom"], $_POST["nom"], $_POST["courriel"]);
        } catch (\Throwable $th) {
            $this->rediriger("modification-utilisateur", ["id" => $_POST["id"], "erreur_existant" => 1]);
        }

        // Redirection en cas de succes
        if($succes_modification_utilisateur){
            $this->rediriger("administration", ["compte_modif_succes" => 1]); 
        }

        // Redirection en cas d'erreur
        $this->rediriger("modification-utilisateur", [
            "id" => $_POST["id"],
            "erreur" => 1
        ]);
    }

    /**
     * Affiche le formulaire de modification d'un plat
     *
     * @return void
     */
    public function afficherModificationPlat() {
        if(empty($_GET["id"])) {
            $this->rediriger("administration");
        }

        $this->vue("admin-modification-plat", [
            "titre" => "Modification d'un plat | Administration",
            "plat" =>(new Plats())->parIdAvecCategorie($_GET["id"]),
            "categories" => (new Categories())->toutParOrdre(),
        ]);
    }

    /**
     * Traite les informations soumises lors de la modification d'un plat
     *
     * @return void
     */
    public function modifierPlatSubmit() {
        $this->validerReceptionFormulaire("administration");

        if(!$this->validerChamps(["nom", "prix", "description", "categorie"])){
            $this->rediriger("modification-plat", [
                "id" => $_POST["id"],
                "champs_vide" => 1
            ]);
        }

        // Validation du maximum de caractères 
        if(strlen($_POST["nom"]) > 100) {
            $this->rediriger("modification-plat", ["id" => $_POST["id"], "erreur_max_nom" => 1]);
        }

        // Vérification et formatage du prix
        $prix = $this->verifierPrix($_POST["prix"], "modification-plat", [
            "id" => $_POST["id"],
            "erreur_prix" => 1,
        ]);
        
        // Gestion de la modification de l'image
        if(is_uploaded_file($_FILES["image"]["tmp_name"])) {
            // Téléversement de la nouvelle image si nouvelle image il y a
            $image = $this->televerser("image", ["jpg", "jpeg", "png", "webp"]);
        } else {
            // Sinon, récupération de la valeur de l'image actuelle ou null
            $image = empty($_POST["image_actuelle"]) ? null : $_POST["image_actuelle"];
        }

        // Modification du plat
        $succes_modification_plat = (new Plats())->modifier($_POST["id"], $_POST["nom"], $prix, $_POST["description"], $_POST["categorie"], $image);

        // Redirection en cas de succes
        if($succes_modification_plat){
            $this->rediriger("administration", ["plat_modif_succes" => 1]);
        }

        // Redirection en cas d'erreur
        $this->rediriger("modification-plat", [
            "id" => $_POST["id"],
            "erreur" => 1
        ]);
    }

    // -------------------------------------------------------------------------------------------------------- SUPPRESSIONS

    /**
     * Supprime un utilisateur
     *
     * @return void
     */
    public function supprimerUtilisateurSubmit() {
        if(!$this->validerConnexion("utilisateur_id")) {
            $this->rediriger("administration");
        }

        // Validation qu'on a bien reçu un id d'un utilisateur
        if(!$_GET["id"]){
            $this->rediriger("administration", ["erreur" => 1]);
        }

        // Ne pas supprimer Gaston !!
        if($_GET["id"] == 1){
            $this->rediriger("administration");
        }

        // Récupération de l'id de l'utilisateur à supprimer
        $utilisateur_id = $_GET["id"];

        // Supression d'un utilisateur
        $succes_suppression_utilisateur = (new Utilisateurs())->supprimerParId($utilisateur_id); 
        
        // Redirection si l'utilisateur a bien été supprimé
        if($succes_suppression_utilisateur){
            $this->rediriger("administration", ["suppression_utilisateur" => 1]);
        }

        // Redirection si erreur
        $this->rediriger("administration", ["erreur" => 1]);
    }

    /**
     * Supprime une catégorie
     *
     * @return void
     */
    public function supprimerCategorieSubmit() {
        if(!$this->validerConnexion("utilisateur_id")) {
            $this->rediriger("administration");
        }

        // Validation qu'on a bien reçu un id de catégorie
        if(!$_GET["id"]){
            $this->rediriger("administration", ["erreur" => 1]);
        }

        // Récupération de l'id de la catégorie à supprimer
        $categorie_id = $_GET["id"];

        // Supression de la catégorie ou erreur si la catégorie n'est pas vide (plats)
        try { 
            $succes_supppression_categorie = (new Categories())->supprimerParId($categorie_id);
        } catch (\Throwable $th) {
            $this->rediriger("administration", ["erreur_categorie" => 1]);
        }

        
        // Redirection si la catégorie a bien été supprimé
        if($succes_supppression_categorie){
            $this->rediriger("administration", ["suppression_categorie" => 1]);
        }

        // Redirection si erreur
        $this->rediriger("administration", ["erreur" => 1]);
    }

    /**
     * Supprimer un plat
     *
     * @return void
     */
    public function supprimerPlatSubmit() {
        if(!$this->validerConnexion("utilisateur_id")) {
            $this->rediriger("administration");
        }

        // Validation qu'on a bien reçu un id d'un plat
        if(!$_GET["id"]){
            $this->rediriger("administration", ["erreur" => 1]);
        }

        // Récupération de l'id du plat à supprimer
        $plat_id = $_GET["id"];

        // Supression d'un plat
        $succes_supppression_plat = (new Plats())->supprimerParId($plat_id);
        
        // Redirection si le plat a bien été supprimé
        if($succes_supppression_plat){
            $this->rediriger("administration", ["suppression_plat" => 1]);
        }

        // Redirection si erreur
        $this->rediriger("administration", ["erreur" => 1]);
    }
}
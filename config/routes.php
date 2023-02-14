<?php

// Tableau associatif qui associe une route à une méthode du controller. Syntaxe : "nom de la route" => "nom de la méthode"
$routes = [
    "index" => "index",
    "menu" => "afficherMenu",
    "a-propos" => "afficherAPropos",
    "nous-joindre" => "afficherNousJoindre",
    "ajout-infolettre-submit" => "ajouterInfolettreSubmit",

    "admin" => "afficherConnexion",
    "compte-connexion-submit" => "connecterSubmit",
    "administration" => "afficherAdministration",
    "compte-deconnexion-submit" => "deconnecterCompte",

    "ajout-utilisateur" => "afficherAjoutUtilisateur",
    "ajout-utilisateur-submit" => "ajouterUtilisateurSubmit",

    "ajout-plat" => "afficherAjoutPlat",
    "ajout-plat-submit" => "ajouterPlatSubmit",

    "ajout-categorie" => "afficherAjoutCategorie",
    "ajout-categorie-submit" => "ajouterCategorieSubmit",

    "modification-categorie" => "afficherModificationCategorie",
    "modification-categorie-submit" => "modifierCategorieSubmit",

    "modification-utilisateur" => "afficherModificationUtilisateur",
    "modification-utilisateur-submit" => "modifierUtilisateurSubmit",

    "modification-plat" => "afficherModificationPlat",
    "modification-plat-submit" => "modifierPlatSubmit",
    
    "supression-utilisateur-submit" => "supprimerUtilisateurSubmit",
    "supression-plat-submit" => "supprimerPlatSubmit",
    "supression-categorie-submit" => "supprimerCategorieSubmit",
];
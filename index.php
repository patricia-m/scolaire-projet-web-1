<?php

// Affichage de toutes les erreurs pendant le développement ---------
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// ------------------------------------------------------------------

require_once "controllers/SiteController.php";
require_once("config/routes.php");

session_start();
$controller = new SiteController();

// Gestion de la route demandée et appel de la méthode
$chemin = $_GET["path"] ?? "index";
$methode = $routes[$chemin] ?? "erreur404";
$controller->{$methode}();
<?php

// Point d'entree du site : session, securite et routage.

// session

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// token csrf

if (empty($_SESSION["csrf_token"])) {
    $_SESSION["csrf_token"] = bin2hex(random_bytes(32));
}

// déconnexion

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["logout"])) {
    if (!hash_equals($_SESSION["csrf_token"], (string) ($_POST["csrf_token"] ?? ""))) {
        die("csrf invalide");
    }

    session_destroy();

    header("location: index.php?page=home");
    exit();
}

// chargement contrôleur principal

require_once __DIR__ . "/controleur/controleur_class.php";

$unControleur = new Controleur();

// page demandée

$page = $_GET["page"] ?? "home";
$vue = "home.php";

// routage

switch ($page) {

    // accueil

    case "home":
        require_once __DIR__ . "/controleur/gestion_home.php";
        $vue = "home.php";
        break;

    // connexion

    case "login":
        require_once __DIR__ . "/controleur/gestion_login.php";
        require_once __DIR__ . "/controleur/gestion_home.php";
        $vue = "home.php";
        break;

    // inscription

    case "register":
        require_once __DIR__ . "/controleur/gestion_register.php";
        require_once __DIR__ . "/controleur/gestion_home.php";
        $vue = "home.php";
        break;

    case "about":
        $vue = "about.php";
        break;  

    // recherche globale

    case "recherche":
        require_once __DIR__ . "/controleur/gestion_recherche.php";
        $vue = "home.php";
        break;

    // destinations

    case "destinations":
        require_once __DIR__ . "/controleur/gestion_destinations.php";
        $vue = "destinations.php";
        break;

    case "destination_detail":
        require_once __DIR__ . "/controleur/gestion_destination_detail.php";
        $vue = "destination_detail.php";
        break;

    // voyages

    case "voyages":
        require_once __DIR__ . "/controleur/gestion_voyages.php";
        $vue = "voyages.php";
        break;

    case "voyage_detail":
        require_once __DIR__ . "/controleur/gestion_voyage_detail.php";
        $vue = "voyage_detail.php";
        break;

    // offres

    case "offres":
        require_once __DIR__ . "/controleur/gestion_offres.php";
        $vue = "offres.php";
        break;

    // réservation client

    case "reservation":
        $unControleur->verifConnexion();

        require_once __DIR__ . "/controleur/gestion_reservations.php";
        $vue = "reservation.php";
        break;

    // espace client

    case "dashboard_client":
        $unControleur->verifConnexion();

        require_once __DIR__ . "/controleur/gestion_dashboard_client.php";
        $vue = "dashboard_client.php";
        break;

    case "profile":
        $unControleur->verifConnexion();

        require_once __DIR__ . "/controleur/gestion_profile.php";
        $vue = "profile.php";
        break;

    // admin dashboard

    case "admin_dashboard":
        $unControleur->verifAdmin();

        require_once __DIR__ . "/controleur/gestion_admin_dashboard.php";
        $vue = "admin_dashboard.php";
        break;

    // admin clients

    case "admin_clients":
        $unControleur->verifAdmin();

        require_once __DIR__ . "/controleur/gestion_admin_clients.php";
        $vue = "admin_clients.php";
        break;

    case "admin_client_detail":
        $unControleur->verifAdmin();

        require_once __DIR__ . "/controleur/gestion_admin_client_detail.php";
        $vue = "admin_client_detail.php";
        break;

    // admin destinations

    case "admin_destinations":
        $unControleur->verifAdmin();

        require_once __DIR__ . "/controleur/gestion_admin_destinations.php";
        $vue = "admin_destinations.php";
        break;

    // admin voyages

    case "admin_voyages":
        $unControleur->verifAdmin();

        require_once __DIR__ . "/controleur/gestion_admin_voyages.php";
        $vue = "admin_voyages.php";
        break;

    // admin offres

    case "admin_offres":
        $unControleur->verifAdmin();

        require_once __DIR__ . "/controleur/gestion_admin_offres.php";
        $vue = "admin_offres.php";
        break;

    // admin réservations

    case "admin_reservations":
        $unControleur->verifAdmin();

        require_once __DIR__ . "/controleur/gestion_admin_reservations.php";
        $vue = "admin_reservations.php";
        break;

    // page par défaut

    default:
        require_once __DIR__ . "/controleur/gestion_home.php";
        $vue = "home.php";
        break;
}

// affichage layout

require_once __DIR__ . "/vue/layout.php";

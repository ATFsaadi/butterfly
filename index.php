<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// csrf token

if (empty($_SESSION["csrf_token"])) {
    $_SESSION["csrf_token"] = bin2hex(random_bytes(32));
}

// logout post

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["logout"])) {
    if (!hash_equals($_SESSION["csrf_token"], $_POST["csrf_token"] ?? "")) {
        die("csrf invalide");
    }

    session_destroy();
    header("location: index.php?page=home");
    exit();
}

// initialisation controleur

require_once __DIR__ . "/controleur/controleur_class.php";
$unControleur = new Controleur();

// routage

$page = $_GET["page"] ?? "home";
$vue = "home.php";

switch ($page) {

    // pages publiques

    
    case "login":
        require_once __DIR__ . "/controleur/gestion_login.php";
        $vue = "login.php";
        break;

    case "home":
        require_once __DIR__ . "/controleur/gestion_home.php";
        $vue = "home.php";
        break;

    case "register":
        require_once __DIR__ . "/controleur/gestion_register.php";
        $vue = "register.php";
        break;

    case "destinations":
        require_once __DIR__ . "/controleur/gestion_destinations.php";
        $vue = "destinations.php";
        break;

    case "destination_detail":
        require_once __DIR__ . "/controleur/gestion_destination_detail.php";
        $vue = "destination_detail.php";
        break;

    case "offres":
        require_once __DIR__ . "/controleur/gestion_offres.php";
        $vue = "offres.php";
        break;

    // pages client

    case "reservation":
        $unControleur->verifConnexion();
        require_once __DIR__ . "/controleur/gestion_reservations.php";
        $vue = "reservation.php";
        break;

    case "dashboard_client":
        $unControleur->verifConnexion();
        require_once __DIR__ . "/controleur/gestion_dashboard_client.php";
        $vue = "dashboard_client.php";
        break;

    // pages admin

    case "admin_offres":
        $unControleur->verifAdmin();
        require_once __DIR__ . "/controleur/gestion_admin_offres.php";
        $vue = "admin_offres.php";
        break;

    case "admin_destinations":
        $unControleur->verifAdmin();
        require_once __DIR__ . "/controleur/gestion_admin_destinations.php";
        $vue = "admin_destinations.php";
        break;
    
     case "admin_reservations":
        $unControleur->verifAdmin();
        require_once "controleur/gestion_admin_reservations.php";
        $vue = "admin_reservations.php";
        break;

    // fallback

    default:
        require_once __DIR__ . "/controleur/gestion_home.php";
        $vue = "home.php";
        break;
}

// layout

require_once __DIR__ . "/vue/layout.php";

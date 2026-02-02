<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// CSRF token
if (empty($_SESSION["csrf_token"])) {
    $_SESSION["csrf_token"] = bin2hex(random_bytes(32));
}

// Logout POST
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["logout"])) {
    if (!hash_equals($_SESSION["csrf_token"], $_POST["csrf_token"] ?? "")) {
        die("CSRF invalide");
    }
    session_destroy();
    header("Location: index.php?page=home");
    exit();
}

require_once __DIR__ . "/controleur/controleur_class.php";
$unControleur = new Controleur();

$page = $_GET["page"] ?? "home";
$vue  = "home.php";

switch ($page) {

    case "home":
        require_once __DIR__ . "/controleur/gestion_home.php";
        $vue = "home.php";
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

    case "login":
        require_once __DIR__ . "/controleur/gestion_login.php";
        $vue = "login.php";
        break;

    case "register":
        require_once __DIR__ . "/controleur/gestion_register.php";
        $vue = "register.php";
        break;

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

    default:
        require_once __DIR__ . "/controleur/gestion_home.php";
        $vue = "home.php";
        break;
}

require_once __DIR__ . "/vue/layout.php";

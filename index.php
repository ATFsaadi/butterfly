<?php

/* session */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/* dependances */
require_once __DIR__ . "/controleur/controleur.class.php";
$unControleur = new Controleur();

/* page + messages */
$page = $_GET['page'] ?? 'home';
$error = '';
$inscription_error = '';
$inscription_success = '';

/* logout */
if ($page === 'logout') {
    session_destroy();
    header("Location: index.php?page=home");
    exit;
}

/* login */
if (isset($_POST['Connexion']) && isset($_POST['email'], $_POST['mot_de_passe'])) {

    $email = trim((string) $_POST['email']);
    $mdp = (string) $_POST['mot_de_passe'];

    /* recuperation user */
    $unUser = $unControleur->select_user($email);

    /* verification */
    if (!$unUser || !password_verify($mdp, $unUser['mot_de_passe'])) {
        $error = "Email ou mot de passe incorrect";
    } else {

        /* session user */
        $_SESSION['user'] = [
            'id'     => $unUser['idutil'],
            'idutil' => $unUser['idutil'],
            'nom'    => $unUser['nom'],
            'prenom' => $unUser['prenom'],
            'email'  => $unUser['email'],
            'role'   => $unUser['role'],
        ];

        /* redirection */
        $redirect = ($unUser['role'] === 'admin')
            ? "index.php?page=dashboard_admin"
            : "index.php?page=dashboard_client";

        header("Location: $redirect");
        exit;
    }
}

/* register */
if (isset($_POST['inscription_submit'])) {

    $nom = trim((string) ($_POST['nom'] ?? ''));
    $prenom = trim((string) ($_POST['prenom'] ?? ''));
    $email = trim((string) ($_POST['email'] ?? ''));
    $mdp = (string) ($_POST['mot_de_passe'] ?? '');
    $confirmer_mdp = (string) ($_POST['confirmer_mot_de_passe'] ?? '');
    $telephone = !empty($_POST['telephone']) ? trim((string) $_POST['telephone']) : null;

    /* verification mdp */
    if ($mdp !== $confirmer_mdp) {
        $inscription_error = "Les mots de passe ne correspondent pas";
    } else {

        /* verification email */
        $userExist = $unControleur->select_user($email);

        if ($userExist) {
            $inscription_error = "Cet email est déjà utilisé";
        } else {

            /* creation user */
            $mdpHash = password_hash($mdp, PASSWORD_DEFAULT);
            $unControleur->addUser($nom, $prenom, $email, $mdpHash, $telephone);

            $inscription_success = "Inscription réussie ! Vous pouvez vous connecter.";
        }
    }
}

/* donnees communes */
$continents = method_exists($unControleur, 'getAllContinents')
    ? $unControleur->getAllContinents()
    : [];

/* =========================
   routing pages publiques
========================= */

/* home */
if ($page === 'home') {

    /* slides */
    $slides = $unControleur->getSlidesActifs();

    /* voyages */
    $voyages = method_exists($unControleur, 'getAllVoyages')
        ? $unControleur->getAllVoyages()
        : [];

    /* destinations */
    $destinations = $unControleur->getAllDestinations();

    /* villes depart (placeholder) */
    $villesDepart = [];

    /* offres */
    $offres = method_exists($unControleur, 'getOffresActives')
        ? $unControleur->getOffresActives()
        : [];
}

/* destinations */
if ($page === 'destinations') {

    /* filtre continent */
    $idContinent = (isset($_GET['continent']) && $_GET['continent'] !== '')
        ? (int) $_GET['continent']
        : null;

    $destinations = $idContinent
        ? $unControleur->getDestinationsByContinent($idContinent)
        : $unControleur->getAllDestinations();
}

/* voyages */
if ($page === 'voyages') {
    $voyages = method_exists($unControleur, 'getAllVoyages')
        ? $unControleur->getAllVoyages()
        : [];
}

/* voyage detail */
if ($page === 'voyage_detail') {
    $id = (int) ($_GET['id'] ?? 0);
    $voyage = $unControleur->getVoyageById($id);
}

/* offres */
if ($page === 'offres') {
    $offres = method_exists($unControleur, 'getOffresActives')
        ? $unControleur->getOffresActives()
        : [];
}

/* =========================
   routing reservations
========================= */

/* reservation */
if ($page === 'reservation') {
    require_once __DIR__ . '/controleur/gestion.reservations.php';
}

/* recap reservation */
if ($page === 'reservation_recap') {
    require_once __DIR__ . '/controleur/gestion.reservation_recap.php';
}

/* admin reservations (utilise le meme controleur) */
if ($page === 'admin_reservations') {
    require_once __DIR__ . '/controleur/gestion.reservations.php';
}

/* dashboard client */
if ($page === 'dashboard_client') {

    /* securite client */
    if (!isset($_SESSION['user'])) {
        header("Location: index.php?page=home");
        exit;
    }

    /* id user */
    $idUser = (int) ($_SESSION['user']['idutil'] ?? ($_SESSION['user']['id'] ?? 0));

    $reservations = ($idUser > 0)
        ? $unControleur->getReservationsByUser($idUser)
        : [];
}

/* =========================
   routing admin
========================= */

if (str_starts_with($page, 'admin')) {

    /* securite admin */
    if (!isset($_SESSION['user']) || ($_SESSION['user']['role'] ?? '') !== 'admin') {
        header('Location: index.php?page=home');
        exit();
    }

    /* admin slides */
    if ($page === 'admin_slides') {
        require_once __DIR__ . '/controleur/gestion.slides.php';
    }

    /* admin destinations */
    if ($page === 'admin_destinations') {
        require_once __DIR__ . '/controleur/gestion.destinations.php';
    }

    /* admin voyages */
    if ($page === 'admin_voyages') {
        require_once __DIR__ . '/controleur/gestion.voyages.php';
    }

    /* admin offres */
    if ($page === 'admin_offres') {
        require_once __DIR__ . '/controleur/gestion.offres.php';
    }
}

/* =========================
   chargement vue + layout
========================= */

/* vue */
$viewFile = __DIR__ . "/vue/{$page}.php";
if (!file_exists($viewFile)) {
    $viewFile = __DIR__ . "/vue/home.php";
}

/* layout */
require_once __DIR__ . "/vue/layout.php";

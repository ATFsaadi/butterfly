<?php

if (session_status() === PHP_SESSION_NONE) session_start();

require_once "controleur/controleur.class.php";
$unControleur = new Controleur();

/* page */
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
    $email = trim($_POST['email']);
    $mdp = $_POST['mot_de_passe'];

    $unUser = $unControleur->select_user($email);

    if (!$unUser || !password_verify($mdp, $unUser['mot_de_passe'])) {
        $error = "Email ou mot de passe incorrect";
    } else {
        session_regenerate_id(true);
        $_SESSION['user'] = [
            'id' => $unUser['idutil'],
            'nom' => $unUser['nom'],
            'prenom' => $unUser['prenom'],
            'role' => $unUser['role']
        ];

        $redirect = ($unUser['role'] === 'admin')
            ? "index.php?page=dashboard_admin"
            : "index.php?page=dashboard_client";

        header("Location: $redirect");
        exit;
    }
}

/* register */
if (isset($_POST['inscription_submit'])) {
    $nom = trim($_POST['nom'] ?? '');
    $prenom = trim($_POST['prenom'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $mdp = $_POST['mot_de_passe'] ?? '';
    $confirmer_mdp = $_POST['confirmer_mot_de_passe'] ?? '';
    $telephone = !empty($_POST['telephone']) ? trim($_POST['telephone']) : null;

    if ($mdp !== $confirmer_mdp) {
        $inscription_error = "Les mots de passe ne correspondent pas";
    } else {
        $userExist = $unControleur->select_user($email);
        if ($userExist) {
            $inscription_error = "Cet email est déjà utilisé";
        } else {
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

/* home */
if ($page === 'home') {
    $slides = $unControleur->getSlidesActifs();

    $voyages = method_exists($unControleur, 'getAllVoyages')
        ? $unControleur->getAllVoyages()
        : [];

    $villesDepart = [];
    $destinations = $unControleur->getAllDestinations();

    $offres = method_exists($unControleur, 'getOffresActives')
        ? $unControleur->getOffresActives()
        : [];
}

/* destinations */
if ($page === 'destinations') {
    $idContinent = isset($_GET['continent']) && $_GET['continent'] !== '' ? (int)$_GET['continent'] : null;

    if ($idContinent) {
        $destinations = $unControleur->getDestinationsByContinent($idContinent);
    } else {
        $destinations = $unControleur->getAllDestinations();
    }
}

/* voyages */
if ($page === 'voyages') {
    $voyages = method_exists($unControleur, 'getAllVoyages')
        ? $unControleur->getAllVoyages()
        : [];
}

/* offres */
if ($page === 'offres') {
    $offres = method_exists($unControleur, 'getOffresActives')
        ? $unControleur->getOffresActives()
        : [];
}

/* admin */
if (str_starts_with($page, 'admin')) {

    /* securite admin */
    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
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

/* vue */
$viewFile = "vue/{$page}.php";
if (!file_exists($viewFile)) {
    $viewFile = "vue/home.php";
}

/* layout */
require_once "vue/layout.php";

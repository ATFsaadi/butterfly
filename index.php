<?php
session_start();
require_once("controleur/controleur.class.php");
$unControleur = new Controleur();

// Gestion page
$page = $_GET['page'] ?? 'home';
$error = '';
$inscription_error = '';
$inscription_success = '';

// Gestion deconnexion
if ($page === 'logout') {
    session_destroy();
    header("Location: index.php?page=home");
    exit;
}

// Gestion connexion
if (isset($_POST['Connexion']) && isset($_POST['email'], $_POST['mot_de_passe'])) {
    $email = trim($_POST['email']);
    $mdp = $_POST['mot_de_passe'];

    $unUser = $unControleur->select_user($email, $mdp);

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

// Gestion inscription
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
        $userExist = $unControleur->select_user($email, $mdp);
        if ($userExist) {
            $inscription_error = "Cet email est déjà utilisé";
        } else {
            $mdpHash = password_hash($mdp, PASSWORD_DEFAULT);
            $unControleur->addUser($nom, $prenom, $email, $mdpHash, $telephone);
            $inscription_success = "Inscription réussie ! Vous pouvez vous connecter.";
        }
    }
}

// Détermination de la vue à inclure
$viewFile = "vue/{$page}.php";
if (!file_exists($viewFile)) {
    $viewFile = "vue/home.php";
}

require_once("vue/layout.php");

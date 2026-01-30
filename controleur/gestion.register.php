<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/controleur.class.php';
$controleur = new Controleur();

// On déclenche si POST + marqueur hidden (fiable même avec Entrée)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register_form'])) {

    $nom        = trim($_POST['nom'] ?? '');
    $prenom     = trim($_POST['prenom'] ?? '');
    $email      = trim($_POST['email'] ?? '');
    $mdp        = $_POST['mot_de_passe'] ?? '';
    $conf_mdp   = $_POST['confirmer_mot_de_passe'] ?? '';
    $telephone  = trim($_POST['telephone'] ?? '');

    $errors = [];

    if ($nom === '' || $prenom === '' || $email === '' || $mdp === '' || $conf_mdp === '') {
        $errors[] = "Veuillez remplir tous les champs obligatoires.";
    }

    if (empty($errors) && $mdp !== $conf_mdp) {
        $errors[] = "Les mots de passe ne correspondent pas.";
    }

    if (empty($errors)) {
        $existingUser = $controleur->select_user($email);
        if ($existingUser) {
            $errors[] = "Cet email est déjà utilisé.";
        }
    }

    if (!empty($errors)) {
        $_SESSION['register_errors'] = $errors;
        $_SESSION['old_register'] = [
            'nom' => $nom,
            'prenom' => $prenom,
            'email' => $email,
            'telephone' => $telephone
        ];

        header('Location: ../index.php?page=inscription');
        exit();
    }

    $hashMdp = password_hash($mdp, PASSWORD_DEFAULT);
    // après addUser(...)
    $controleur->addUser($nom, $prenom, $email, $hashMdp, $telephone);

    // ✅ message succès
    $_SESSION['flash_success'] = "Inscription réussie. Vous pouvez vous connecter.";

    // Optionnel : pré-remplir email dans login
    $_SESSION['old_email'] = $email;

    // (si tu ne veux pas connecter automatiquement)
    unset($_SESSION['register_errors'], $_SESSION['old_register']);

    header('Location: ../index.php?page=login');
    exit();

}

header('Location: ../index.php?page=home');
exit();

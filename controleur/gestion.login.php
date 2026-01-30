<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/controleur.class.php';
$controleur = new Controleur();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['Connexion'])) {

    $email = trim($_POST['email'] ?? '');
    $mdp   = $_POST['mot_de_passe'] ?? '';

    $errors = [];

    if ($email === '' || $mdp === '') {
        $errors[] = "Veuillez remplir tous les champs.";
    } else {
        $user = $controleur->select_user($email);

        // Message unique (ne révèle pas si l'email existe)
        if (!$user || !password_verify($mdp, $user['mot_de_passe'])) {
            $errors[] = "Email ou mot de passe incorrect.";
        } else {

            // Bonus sécurité : évite session fixation
            session_regenerate_id(true);

            $_SESSION['user'] = [
                'idutil' => $user['idutil'],
                'nom'    => $user['nom'],
                'prenom' => $user['prenom'],
                'email'  => $user['email'],
                'role'   => $user['role']
            ];

            unset($_SESSION['auth_errors'], $_SESSION['old_email']);
            header('Location: ../index.php?page=home');
            exit();
        }
    }

    // Erreur => stocke en session + retourne sur index avec ouverture de modale
    $_SESSION['auth_errors'] = $errors;
    $_SESSION['old_email'] = $email;

    header('Location: ../index.php?page=login');
    exit();
}

// Accès direct => renvoie home
header('Location: ../index.php?page=home');
exit();

?>

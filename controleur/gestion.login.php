<?php

if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/controleur.class.php';

$controleur = new Controleur();
$errors = [];

/* traitement connexion */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['Connexion'])) {

    $email = trim($_POST['email'] ?? '');
    $mdp = $_POST['mot_de_passe'] ?? '';

    if (empty($email) || empty($mdp)) {
        $errors[] = "Veuillez remplir tous les champs.";
    } else {

        /* recuperation utilisateur */
        $user = $controleur->select_user($email);

        if (!$user) {
            $errors[] = "Utilisateur introuvable.";
        } elseif (!password_verify($mdp, $user['mot_de_passe'])) {
            $errors[] = "Mot de passe incorrect.";
        } else {

            /* session utilisateur */
            $_SESSION['user'] = [
                'idutil' => $user['idutil'],
                'nom' => $user['nom'],
                'prenom' => $user['prenom'],
                'email' => $user['email'],
                'role' => $user['role']
            ];

            /* redirection */
            header('Location: ../index.php?page=home');
            exit();
        }
    }
}
?>

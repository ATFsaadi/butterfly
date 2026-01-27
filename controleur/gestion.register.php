<?php

if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/controleur.class.php';

$controleur = new Controleur();
$erreur = "";

/* traitement inscription */
if (isset($_POST['inscription_submit'])) {

    $nom = trim($_POST['nom'] ?? '');
    $prenom = trim($_POST['prenom'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $mdp = $_POST['mot_de_passe'] ?? '';
    $conf_mdp = $_POST['confirmer_mot_de_passe'] ?? '';
    $telephone = trim($_POST['telephone'] ?? '');

    /* verification champs */
    if (empty($nom) || empty($prenom) || empty($email) || empty($mdp) || empty($conf_mdp)) {
        $erreur = "Veuillez remplir tous les champs obligatoires.";
    } elseif ($mdp !== $conf_mdp) {
        $erreur = "Les mots de passe ne correspondent pas.";
    } else {

        /* verification email */
        $existingUser = $controleur->select_user($email);

        if ($existingUser) {
            $erreur = "Cet email est déjà utilisé.";
        } else {

            /* creation utilisateur */
            $hashMdp = password_hash($mdp, PASSWORD_DEFAULT);
            $controleur->addUser($nom, $prenom, $email, $hashMdp, $telephone);

            /* session utilisateur */
            $_SESSION['user'] = $controleur->select_user($email);

            /* redirection */
            header('Location: ../index.php?page=home');
            exit();
        }
    }
}
?>

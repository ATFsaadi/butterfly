<?php
// Démarrer la session si elle n'est pas déjà démarrée
if (session_status() === PHP_SESSION_NONE) session_start();

// Inclure le contrôleur
require_once __DIR__ . '/controleur.class.php';

$controleur = new Controleur();
$erreur = "";

// Traitement du formulaire d'inscription
if (isset($_POST['inscription_submit'])) {
    $nom = trim($_POST['nom'] ?? '');
    $prenom = trim($_POST['prenom'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $mdp = $_POST['mot_de_passe'] ?? '';
    $conf_mdp = $_POST['confirmer_mot_de_passe'] ?? '';
    $telephone = trim($_POST['telephone'] ?? '');

    // Vérifications
    if (empty($nom) || empty($prenom) || empty($email) || empty($mdp) || empty($conf_mdp)) {
        $erreur = "Veuillez remplir tous les champs obligatoires.";
    } elseif ($mdp !== $conf_mdp) {
        $erreur = "Les mots de passe ne correspondent pas.";
    } else {
        // Vérifier si l'email existe déjà
        $existingUser = $controleur->select_user($email);
        if ($existingUser) {
            $erreur = "Cet email est déjà utilisé.";
        } else {
            // Hasher le mot de passe
            $hashMdp = password_hash($mdp, PASSWORD_DEFAULT);
            $controleur->addUser($nom, $prenom, $email, $hashMdp, $telephone);

            // Auto-login après inscription
            $_SESSION['user'] = $controleur->select_user($email);

            // Redirection vers home
            header('Location: ../index.php?page=home');
            exit();
        }
    }
}
?>

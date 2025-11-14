<?php
require_once("controleur.class.php");
$unControleur = new Controleur();

$message = '';

// Vérifie si le formulaire est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom']);
    $prenom = trim($_POST['prenom']);
    $email = trim($_POST['email']);
    $mot_de_passe = $_POST['mot_de_passe'];
    $confirmer_mot_de_passe = $_POST['confirmer_mot_de_passe'];
    $telephone = !empty($_POST['telephone']) ? trim($_POST['telephone']) : null;

    if ($mot_de_passe !== $confirmer_mot_de_passe) {
        $message = "<p class='text-danger text-center mt-3'>Les mots de passe ne correspondent pas.</p>";
    } else {
        $userExist = $unControleur->getUserByEmail($email);
        if ($userExist) {
            $message = "<p class='text-danger text-center mt-3'>Cet email est déjà utilisé.</p>";
        } else {
            $mdpHash = password_hash($mot_de_passe, PASSWORD_DEFAULT);
            $unControleur->addUser($nom, $prenom, $email, $mdpHash, $telephone);
            $message = "<p class='text-success text-center mt-3'>Inscription réussie ! Vous pouvez vous connecter.</p>";
        }
    }
}

require_once("vue/vue_inscription.php");
?>

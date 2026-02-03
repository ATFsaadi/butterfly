<?php

// variables de retour ui

$erreurRegister = $erreurRegister ?? "";
$successRegister = $successRegister ?? "";
$openLoginAfterRegister = $openLoginAfterRegister ?? false;

// csrf

if (empty($_SESSION["csrf_token"])) {
    $_SESSION["csrf_token"] = bin2hex(random_bytes(32));
}

// traitement inscription

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["inscrire"])) {

    if (
        !isset($_POST["csrf_token"], $_SESSION["csrf_token"]) ||
        !hash_equals($_SESSION["csrf_token"], $_POST["csrf_token"])
    ) {
        $erreurRegister = "action non autorisée. veuillez réessayer.";
    } else {

        $nom = trim($_POST["nom"] ?? "");
        $prenom = trim($_POST["prenom"] ?? "");
        $email = trim($_POST["email"] ?? "");
        $mdp = $_POST["mdp"] ?? "";
        $mdp2 = $_POST["mdp2"] ?? "";

        if ($nom === "" || $prenom === "" || $email === "" || $mdp === "" || $mdp2 === "") {
            $erreurRegister = "tous les champs sont obligatoires.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $erreurRegister = "email invalide.";
        } elseif ($mdp !== $mdp2) {
            $erreurRegister = "les mots de passe ne correspondent pas.";
        } elseif (strlen($mdp) < 6) {
            $erreurRegister = "le mot de passe doit faire au moins 6 caractères.";
        } else {

            $userExist = $unControleur->selectWhere_utilisateur_by_email($email);

            if ($userExist) {
                $erreurRegister = "cet email est déjà utilisé.";
            } else {

                try {
                    $hash = password_hash($mdp, PASSWORD_DEFAULT);

                    $unControleur->inscription_complete(
                        [
                            "email" => $email,
                            "mot_de_passe_hash" => $hash,
                            "role" => "client",
                        ],
                        [
                            "nom" => $nom,
                            "prenom" => $prenom,
                            "telephone" => null,
                            "adresse" => null,
                            "ville" => null,
                            "pays" => null,
                        ]
                    );

                    $_SESSION["csrf_token"] = bin2hex(random_bytes(32));

                    header("location: index.php?page=home&register=ok");
                    exit();
                } catch (Exception $e) {
                    $erreurRegister = "erreur lors de l'inscription. veuillez réessayer.";
                }
            }
        }
    }
}

// retour inscription ok

if (isset($_GET["register"]) && $_GET["register"] === "ok") {
    $successRegister = "inscription réussie ! vous pouvez vous connecter.";
    $openLoginAfterRegister = true;
}

<?php

// Controleur inscription : valide les champs et cree le compte client.

// variables d'inscription

$erreurRegister = $erreurRegister ?? "";
$successRegister = $successRegister ?? "";
$openLoginAfterRegister = $openLoginAfterRegister ?? false;

// token csrf

if (empty($_SESSION["csrf_token"])) {
    $_SESSION["csrf_token"] = bin2hex(random_bytes(32));
}

// traitement du formulaire d'inscription

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["inscrire"])) {
    if (!isset($_POST["csrf_token"], $_SESSION["csrf_token"]) || !hash_equals($_SESSION["csrf_token"], (string) ($_POST["csrf_token"] ?? ""))) {
        $erreurRegister = "action non autorisée. veuillez réessayer.";
    } else {
        // récupération des champs

        $nom = trim((string) ($_POST["nom"] ?? ""));
        $prenom = trim((string) ($_POST["prenom"] ?? ""));
        $email = trim((string) ($_POST["email"] ?? ""));
        $mdp = (string) ($_POST["mdp"] ?? "");
        $mdp2 = (string) ($_POST["mdp2"] ?? "");

        if ($email !== "") {
            $email = mb_strtolower($email);
        }

        // validation des champs

        if ($nom === "" || $prenom === "" || $email === "" || $mdp === "" || $mdp2 === "") {
            $erreurRegister = "tous les champs sont obligatoires.";
        } elseif (mb_strlen($nom) > 80 || mb_strlen($prenom) > 80 || mb_strlen($email) > 150) {
            $erreurRegister = "valeurs trop longues.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $erreurRegister = "email invalide.";
        } elseif ($mdp !== $mdp2) {
            $erreurRegister = "les mots de passe ne correspondent pas.";
        } elseif (mb_strlen($mdp) < 6) {
            $erreurRegister = "le mot de passe doit faire au moins 6 caractères.";
        } elseif (mb_strlen($mdp) > 255) {
            $erreurRegister = "mot de passe trop long.";
        } else {
            // vérification email existant

            $userExist = $unControleur->selectWhere_utilisateur_by_email($email);

            if ($userExist) {
                $erreurRegister = "cet email est déjà utilisé.";
            } else {
                // création du compte

                $hash = password_hash($mdp, PASSWORD_DEFAULT);

                $result = $unControleur->inscription_complete(
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

                if ($result) {
                    $_SESSION["csrf_token"] = bin2hex(random_bytes(32));

                    header("location: index.php?page=home&register=ok");
                    exit();
                }

                $erreurRegister = "erreur lors de l'inscription. veuillez réessayer.";
            }
        }
    }
}

// message après inscription

if (isset($_GET["register"]) && $_GET["register"] === "ok") {
    $successRegister = "inscription réussie ! vous pouvez vous connecter.";
    $openLoginAfterRegister = true;
}

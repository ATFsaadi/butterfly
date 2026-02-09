<?php

$erreurRegister = $erreurRegister ?? "";
$successRegister = $successRegister ?? "";
$openLoginAfterRegister = $openLoginAfterRegister ?? false;

if (empty($_SESSION["csrf_token"])) {
    $_SESSION["csrf_token"] = bin2hex(random_bytes(32));
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["inscrire"])) {
    if (!isset($_POST["csrf_token"], $_SESSION["csrf_token"]) || !hash_equals($_SESSION["csrf_token"], (string)($_POST["csrf_token"] ?? ""))) {
        $erreurRegister = "action non autorisée. veuillez réessayer.";
    } else {
        $nom = trim((string)($_POST["nom"] ?? ""));
        $prenom = trim((string)($_POST["prenom"] ?? ""));
        $email = trim((string)($_POST["email"] ?? ""));
        $mdp = (string)($_POST["mdp"] ?? "");
        $mdp2 = (string)($_POST["mdp2"] ?? "");

        if ($email !== "") {
            $email = mb_strtolower($email);
        }

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
            $userExist = $unControleur->selectWhere_utilisateur_by_email($email);

            if ($userExist) {
                $erreurRegister = "cet email est déjà utilisé.";
            } else {
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

if (isset($_GET["register"]) && $_GET["register"] === "ok") {
    $successRegister = "inscription réussie ! vous pouvez vous connecter.";
    $openLoginAfterRegister = true;
}

/*
si tu veux connecter l'utilisateur directement après inscription, remplace la redirection par :

if ($result) {
    session_regenerate_id(true);
    $_SESSION["user"] = [
        "id_utilisateur" => (int)$result["id_utilisateur"],
        "id_client" => (int)$result["id_client"],
        "email" => $email,
        "role" => "client",
        "nom" => $nom,
        "prenom" => $prenom,
    ];
    $_SESSION["csrf_token"] = bin2hex(random_bytes(32));
    header("location: index.php?page=dashboard_client");
    exit();
}
*/

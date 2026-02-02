<?php
// controleur/gestion_register.php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/* =========================
   CSRF
========================= */
if (empty($_SESSION["csrf_token"])) {
    $_SESSION["csrf_token"] = bin2hex(random_bytes(32));
}

function csrf_ok_register(): bool {
    return isset($_POST["csrf_token"], $_SESSION["csrf_token"])
        && hash_equals($_SESSION["csrf_token"], $_POST["csrf_token"]);
}

/* =========================
   TRAITEMENT REGISTER
========================= */
$erreurRegister = $erreurRegister ?? "";
$successRegister = $successRegister ?? "";
$openLoginAfterRegister = $openLoginAfterRegister ?? false;

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["inscrire"])) {

    // 1) CSRF
    if (!csrf_ok_register()) {
        $erreurRegister = "Action non autorisée. Veuillez réessayer.";
    } else {

        $nom    = trim($_POST["nom"] ?? "");
        $prenom = trim($_POST["prenom"] ?? "");
        $email  = trim($_POST["email"] ?? "");
        $mdp    = $_POST["mdp"] ?? "";
        $mdp2   = $_POST["mdp2"] ?? "";

        // 2) Vérifs
        if ($nom === "" || $prenom === "" || $email === "" || $mdp === "" || $mdp2 === "") {
            $erreurRegister = "Tous les champs sont obligatoires.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $erreurRegister = "Email invalide.";
        } elseif ($mdp !== $mdp2) {
            $erreurRegister = "Les mots de passe ne correspondent pas.";
        } elseif (strlen($mdp) < 6) {
            $erreurRegister = "Le mot de passe doit faire au moins 6 caractères.";
        } else {

            // 3) Email déjà utilisé ?
            $userExist = $unControleur->selectWhere_utilisateur_by_email($email);

            if ($userExist) {
                $erreurRegister = "Cet email est déjà utilisé.";
            } else {

                // 4) Transaction : utilisateur + client
                try {
                    $hash = password_hash($mdp, PASSWORD_DEFAULT);

                    $unControleur->inscription_complete(
                        [
                            "email" => $email,
                            "mot_de_passe_hash" => $hash,
                            "role" => "client"
                        ],
                        [
                            "nom" => $nom,
                            "prenom" => $prenom,
                            "telephone" => null,
                            "adresse" => null,
                            "ville" => null,
                            "pays" => null
                        ]
                    );

                    // ✅ Redirection (évite double insertion si refresh)
                    header("Location: index.php?page=home&register=ok");
                    exit();

                } catch (Exception $e) {
                    $erreurRegister = "Erreur lors de l'inscription. Veuillez réessayer.";
                }
            }
        }
    }
}

/* =========================
   Message après redirection
========================= */
if (isset($_GET["register"]) && $_GET["register"] === "ok") {
    $successRegister = "Inscription réussie ! Vous pouvez vous connecter.";
    $openLoginAfterRegister = true;
}

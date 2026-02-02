<?php
// controleur/gestion_login.php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// CSRF
if (empty($_SESSION["csrf_token"])) {
    $_SESSION["csrf_token"] = bin2hex(random_bytes(32));
}

$erreurLogin  = "";
$successLogin = "";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["Connexion"])) {

    // 1) CSRF check
    if (!isset($_POST["csrf_token"]) || !hash_equals($_SESSION["csrf_token"], $_POST["csrf_token"])) {
        $erreurLogin = "Action non autorisée. Veuillez réessayer.";
    } else {

        // 2) Récup champs
        $email = trim($_POST["email"] ?? "");
        $mdp   = $_POST["mdp"] ?? "";

        // 3) Champs obligatoires
        if ($email === "" || $mdp === "") {
            $erreurLogin = "Veuillez remplir tous les champs.";
        } else {

            // 4) Récup user actif
            $unUser = $unControleur->select_user_login($email);

            // 5) Vérif identifiants
            if (!$unUser || !password_verify($mdp, $unUser["mot_de_passe_hash"])) {
                $erreurLogin = "Email ou mot de passe incorrect.";
            } else {

                // 6) OK -> session
                session_regenerate_id(true);

                $_SESSION["user"] = [
                    "id_utilisateur" => (int)$unUser["id_utilisateur"],
                    "email" => $unUser["email"],
                    "role"  => $unUser["role"]
                ];

                // Client en session (si rôle client)
                unset($_SESSION["client"]);
                if (($unUser["role"] ?? "") === "client") {
                    $client = $unControleur->selectWhere_client_by_user((int)$unUser["id_utilisateur"]);
                    if ($client) {
                        $_SESSION["client"] = [
                            "id_client" => (int)$client["id_client"],
                            "nom" => $client["nom"],
                            "prenom" => $client["prenom"]
                        ];
                    }
                }

                header("Location: index.php?page=home");
                exit();
            }
        }
    }
}

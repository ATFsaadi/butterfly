<?php

// Controleur connexion : verifie les identifiants et cree la session.

// variables de connexion

$erreurLogin = "";
$successLogin = "";

// token csrf

if (empty($_SESSION["csrf_token"])) {
    $_SESSION["csrf_token"] = bin2hex(random_bytes(32));
}

// traitement du formulaire de connexion

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["Connexion"])) {
    if (!isset($_POST["csrf_token"]) || !hash_equals($_SESSION["csrf_token"], (string) ($_POST["csrf_token"] ?? ""))) {
        $erreurLogin = "action non autorisée. veuillez réessayer.";
    } else {
        // récupération des champs

        $email = trim((string) ($_POST["email"] ?? ""));
        $mdp = (string) ($_POST["mdp"] ?? "");

        if ($email !== "") {
            $email = mb_strtolower($email);
        }

        // validation des champs

        if ($email === "" || $mdp === "") {
            $erreurLogin = "veuillez remplir tous les champs.";
        } elseif (mb_strlen($email) > 150 || mb_strlen($mdp) > 255) {
            $erreurLogin = "valeurs trop longues.";
        } else {
            // recherche de l'utilisateur

            $unUser = $unControleur->select_user_login($email);

            if (!$unUser) {
                $erreurLogin = "email ou mot de passe incorrect.";
            } else {
                // vérification du mot de passe

                $hash = (string) ($unUser["mot_de_passe_hash"] ?? "");

                if ($hash === "" || !password_verify($mdp, $hash)) {
                    $erreurLogin = "email ou mot de passe incorrect.";
                } else {
                    // création de la session

                    session_regenerate_id(true);

                    $_SESSION["user"] = [
                        "id_utilisateur" => (int) $unUser["id_utilisateur"],
                        "email" => (string) $unUser["email"],
                        "role" => (string) $unUser["role"],
                    ];

                    // ajout des informations client

                    if ((string) ($unUser["role"] ?? "") === "client") {
                        $client = $unControleur->selectWhere_client_by_user((int) $unUser["id_utilisateur"]);

                        if ($client) {
                            $_SESSION["user"]["id_client"] = (int) $client["id_client"];
                            $_SESSION["user"]["nom"] = (string) $client["nom"];
                            $_SESSION["user"]["prenom"] = (string) $client["prenom"];
                        }
                    }

                    // nettoyage ancienne session

                    unset($_SESSION["client"]);

                    // renouvellement csrf

                    $_SESSION["csrf_token"] = bin2hex(random_bytes(32));

                    // redirection après connexion

                    $redirect = (string) ($_POST["redirect"] ?? "");
                    $idVoyage = (int) ($_POST["id_voyage"] ?? 0);
                    $idDestination = (int) ($_POST["id_destination"] ?? 0);

                    if ($redirect === "reservation" && $idVoyage > 0) {
                        header("location: index.php?page=reservation&id_voyage=" . $idVoyage);
                        exit();
                    }

                    if ($redirect === "reservation" && $idDestination > 0) {
                        header("location: index.php?page=reservation&id_destination=" . $idDestination);
                        exit();
                    }

                    if ($redirect === "voyage_detail" && $idVoyage > 0) {
                        header("location: index.php?page=voyage_detail&id_voyage=" . $idVoyage);
                        exit();
                    }

                    if ($redirect === "destination_detail" && $idDestination > 0) {
                        header("location: index.php?page=destination_detail&id_destination=" . $idDestination);
                        exit();
                    }

                    header("location: index.php?page=home");
                    exit();
                }
            }
        }
    }
}

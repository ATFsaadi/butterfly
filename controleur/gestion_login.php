<?php

$erreurLogin = "";
$successLogin = "";

if (empty($_SESSION["csrf_token"])) {
    $_SESSION["csrf_token"] = bin2hex(random_bytes(32));
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["Connexion"])) {
    if (!isset($_POST["csrf_token"]) || !hash_equals($_SESSION["csrf_token"], (string)($_POST["csrf_token"] ?? ""))) {
        $erreurLogin = "action non autorisée. veuillez réessayer.";
    } else {
        $email = trim((string)($_POST["email"] ?? ""));
        $mdp = (string)($_POST["mdp"] ?? "");

        if ($email !== "") {
            $email = mb_strtolower($email);
        }

        if ($email === "" || $mdp === "") {
            $erreurLogin = "veuillez remplir tous les champs.";
        } elseif (mb_strlen($email) > 150 || mb_strlen($mdp) > 255) {
            $erreurLogin = "valeurs trop longues.";
        } else {
            $unUser = $unControleur->select_user_login($email);

            if (!$unUser) {
                $erreurLogin = "email ou mot de passe incorrect.";
            } else {
                $hash = (string)($unUser["mot_de_passe_hash"] ?? "");

                if ($hash === "" || !password_verify($mdp, $hash)) {
                    $erreurLogin = "email ou mot de passe incorrect.";
                } else {
                    session_regenerate_id(true);

                    $_SESSION["user"] = [
                        "id_utilisateur" => (int)$unUser["id_utilisateur"],
                        "email" => (string)$unUser["email"],
                        "role" => (string)$unUser["role"],
                    ];

                    if ((string)($unUser["role"] ?? "") === "client") {
                        $client = $unControleur->selectWhere_client_by_user((int)$unUser["id_utilisateur"]);
                        if ($client) {
                            $_SESSION["user"]["id_client"] = (int)$client["id_client"];
                            $_SESSION["user"]["nom"] = (string)$client["nom"];
                            $_SESSION["user"]["prenom"] = (string)$client["prenom"];
                        }
                    }

                    unset($_SESSION["client"]);

                    $_SESSION["csrf_token"] = bin2hex(random_bytes(32));

                    $redirect = (string)($_POST["redirect"] ?? "");
                    $id_voyage = (int)($_POST["id_voyage"] ?? 0);

                    if ($redirect === "reservation" && $id_voyage > 0) {
                        header("location: index.php?page=reservation&id_voyage=" . $id_voyage);
                        exit();
                    }

                    header("location: index.php?page=home");
                    exit();
                }
            }
        }
    }
}

<?php

// variables de retour ui

$erreurLogin = "";
$successLogin = "";

// csrf

if (empty($_SESSION["csrf_token"])) {
    $_SESSION["csrf_token"] = bin2hex(random_bytes(32));
}

// traitement connexion

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["Connexion"])) {

    if (
        !isset($_POST["csrf_token"]) ||
        !hash_equals($_SESSION["csrf_token"], $_POST["csrf_token"])
    ) {
        $erreurLogin = "action non autorisée. veuillez réessayer.";
    } else {

        $email = trim($_POST["email"] ?? "");
        $mdp = $_POST["mdp"] ?? "";

        if ($email === "" || $mdp === "") {
            $erreurLogin = "veuillez remplir tous les champs.";
        } else {

            $unUser = $unControleur->select_user_login($email);
            $hash = $unUser["mot_de_passe_hash"] ?? "";

            if (!$unUser || $hash === "" || !password_verify($mdp, $hash)) {
                $erreurLogin = "email ou mot de passe incorrect.";
            } else {

                session_regenerate_id(true);

                $_SESSION["user"] = [
                    "id_utilisateur" => (int) $unUser["id_utilisateur"],
                    "email" => $unUser["email"],
                    "role" => $unUser["role"],
                ];

                unset($_SESSION["client"]);

                if (($unUser["role"] ?? "") === "client") {
                    $client = $unControleur->selectWhere_client_by_user(
                        (int) $unUser["id_utilisateur"]
                    );

                    if ($client) {
                        $_SESSION["client"] = [
                            "id_client" => (int) $client["id_client"],
                            "nom" => $client["nom"],
                            "prenom" => $client["prenom"],
                        ];
                    }
                }

                $_SESSION["csrf_token"] = bin2hex(random_bytes(32));

                header("location: index.php?page=home");
                exit();
            }
        }
    }
}

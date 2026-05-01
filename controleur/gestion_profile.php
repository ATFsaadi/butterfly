<?php

if (!isset($_SESSION["user"])) {
    header("Location: index.php?page=home");
    exit();
}

$idUtilisateur = (int)($_SESSION["user"]["id_utilisateur"] ?? 0);
$message = "";
$erreur = "";

/* modification du profil */
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["modifier_profil"])) {
    if (!hash_equals($_SESSION["csrf_token"], (string)($_POST["csrf_token"] ?? ""))) {
        die("csrf invalide");
    }

    $nom = trim((string)($_POST["nom"] ?? ""));
    $prenom = trim((string)($_POST["prenom"] ?? ""));
    $email = trim((string)($_POST["email"] ?? ""));
    $telephone = trim((string)($_POST["telephone"] ?? ""));
    $adresse = trim((string)($_POST["adresse"] ?? ""));
    $ville = trim((string)($_POST["ville"] ?? ""));
    $pays = trim((string)($_POST["pays"] ?? ""));

    $motDePasseActuel = (string)($_POST["mot_de_passe_actuel"] ?? "");
    $nouveauMotDePasse = (string)($_POST["nouveau_mot_de_passe"] ?? "");
    $confirmationMotDePasse = (string)($_POST["confirmation_mot_de_passe"] ?? "");

    if ($nom === "" || $prenom === "" || $email === "") {
        $erreur = "Nom, prénom et email sont obligatoires.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erreur = "Email invalide.";
    } elseif ($unControleur->emailExistePourAutreUtilisateur($email, $idUtilisateur)) {
        $erreur = "Cet email est déjà utilisé.";
    } else {
        $unControleur->updateProfilClient([
            "id_utilisateur" => $idUtilisateur,
            "nom" => $nom,
            "prenom" => $prenom,
            "email" => $email,
            "telephone" => $telephone,
            "adresse" => $adresse,
            "ville" => $ville,
            "pays" => $pays
        ]);

        $_SESSION["user"]["prenom"] = $prenom;
        $_SESSION["user"]["email"] = $email;

        if ($motDePasseActuel !== "" || $nouveauMotDePasse !== "" || $confirmationMotDePasse !== "") {
            if ($motDePasseActuel === "" || $nouveauMotDePasse === "" || $confirmationMotDePasse === "") {
                $erreur = "Pour changer le mot de passe, remplissez tous les champs mot de passe.";
            } elseif ($nouveauMotDePasse !== $confirmationMotDePasse) {
                $erreur = "La confirmation du nouveau mot de passe ne correspond pas.";
            } elseif (strlen($nouveauMotDePasse) < 6) {
                $erreur = "Le nouveau mot de passe doit contenir au moins 6 caractères.";
            } else {
                $utilisateur = $unControleur->selectMotDePasseUtilisateur($idUtilisateur);

                if (!$utilisateur || !password_verify($motDePasseActuel, $utilisateur["mot_de_passe_hash"])) {
                    $erreur = "Mot de passe actuel incorrect.";
                } else {
                    $hash = password_hash($nouveauMotDePasse, PASSWORD_DEFAULT);
                    $unControleur->updateMotDePasseUtilisateur($idUtilisateur, $hash);
                    $message = "Profil et mot de passe mis à jour avec succès.";
                }
            }
        } else {
            $message = "Profil mis à jour avec succès.";
        }
    }
}

/* suppression du compte */
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["supprimer_compte"])) {
    if (!hash_equals($_SESSION["csrf_token"], (string)($_POST["csrf_token"] ?? ""))) {
        die("csrf invalide");
    }

    $motDePasseSuppression = (string)($_POST["mot_de_passe_suppression"] ?? "");
    $confirmationSuppression = trim((string)($_POST["confirmation_suppression"] ?? ""));

    if ($motDePasseSuppression === "") {
        $erreur = "Veuillez saisir votre mot de passe pour supprimer le compte.";
    } elseif ($confirmationSuppression !== "SUPPRIMER") {
        $erreur = "Vous devez écrire SUPPRIMER pour confirmer.";
    } else {
        $utilisateur = $unControleur->selectMotDePasseUtilisateur($idUtilisateur);

        if (!$utilisateur || !password_verify($motDePasseSuppression, $utilisateur["mot_de_passe_hash"])) {
            $erreur = "Mot de passe incorrect.";
        } else {
           $unControleur->setUtilisateurActif($idUtilisateur, 0);
session_destroy();
header("Location: index.php?page=home");
exit();
        }
    }
}

$profil = $unControleur->getProfilClient($idUtilisateur);

if (!$profil) {
    $profil = [];
}
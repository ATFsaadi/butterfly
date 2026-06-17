<?php

// Controleur admin offres : CRUD des promotions et tri de la liste.

// sécurité admin

$unControleur->verifAdmin();

// variables de base

$errors = [];
$success = (string) ($_SESSION["flash_success_admin_offres"] ?? "");

unset($_SESSION["flash_success_admin_offres"]);

$offre = null;

// action supprimer ou modifier

if (isset($_GET["action"], $_GET["id_offre"])) {
    $action = $_GET["action"];
    $idOffre = (int) $_GET["id_offre"];

    if ($action === "sup") {
        $offreExistante = $unControleur->selectWhere_offre($idOffre);

        if ($offreExistante) {
            $unControleur->delete_offre($idOffre);
            $_SESSION["flash_success_admin_offres"] = "L'offre a été désactivée avec succès";
        }

        header("location: index.php?page=admin_offres");
        exit();
    }

    if ($action === "reactiver") {
        $offreExistante = $unControleur->selectWhere_offre($idOffre);

        if ($offreExistante) {
            $unControleur->set_offre_actif($idOffre, 1);
            $_SESSION["flash_success_admin_offres"] = "L'offre a été réactivée avec succès";
        }

        header("location: index.php?page=admin_offres");
        exit();
    }

    if ($action === "edit") {
        $offre = $unControleur->selectWhere_offre($idOffre);

        if (!$offre) {
            header("location: index.php?page=admin_offres");
            exit();
        }
    }
}

// récupération des destinations

$destinations = $unControleur->selectAll_destinations_admin();

// traitement du formulaire

if (isset($_POST["Valider"]) || isset($_POST["Modifier"])) {
    $isEdit = isset($_POST["Modifier"]);

    // préparation des données

    $tab = [
        "id_destination" => (int) ($_POST["id_destination"] ?? 0),
        "titre" => trim((string) ($_POST["titre"] ?? "")),
        "pourcentage_reduction" => (int) ($_POST["pourcentage_reduction"] ?? 0),
        "date_debut" => trim((string) ($_POST["date_debut"] ?? "")),
        "date_fin" => trim((string) ($_POST["date_fin"] ?? "")),
    ];

    if ($isEdit) {
        $tab["id_offre"] = (int) ($_POST["id_offre"] ?? 0);
        $tab["actif"] = isset($_POST["actif"]) ? 1 : 0;
    }

    // validation destination

    if ($tab["id_destination"] <= 0) {
        $errors[] = "la destination est obligatoire.";
    } else {
        $destination = $unControleur->selectWhere_destination($tab["id_destination"]);

        if (!$destination) {
            $errors[] = "la destination sélectionnée est invalide.";
        }
    }

    // validation titre

    if ($tab["titre"] === "") {
        $errors[] = "le titre est obligatoire.";
    }

    // validation pourcentage

    if ($tab["pourcentage_reduction"] <= 0 || $tab["pourcentage_reduction"] > 100) {
        $errors[] = "le pourcentage de réduction doit être compris entre 1 et 100.";
    }

    // validation dates

    if ($tab["date_debut"] === "") {
        $errors[] = "la date de début est obligatoire.";
    }

    if ($tab["date_fin"] === "") {
        $errors[] = "la date de fin est obligatoire.";
    }

    if ($tab["date_debut"] !== "" && $tab["date_fin"] !== "" && $tab["date_fin"] < $tab["date_debut"]) {
        $errors[] = "la date de fin doit être supérieure ou égale à la date de début.";
    }

    // vérification offre à modifier

    if ($isEdit) {
        $offreExistante = $unControleur->selectWhere_offre($tab["id_offre"]);

        if (!$offreExistante) {
            header("location: index.php?page=admin_offres");
            exit();
        }
    }

    // insertion ou modification

    if (empty($errors)) {
        if ($isEdit) {
            $unControleur->update_offre($tab);
        } else {
            $unControleur->insert_offre($tab);
        }

        header("location: index.php?page=admin_offres");
        exit();
    }

    // conservation du formulaire en cas d'erreur

    if ($isEdit) {
        $offre = $tab;
    }
}

// filtre de recherche

$filtre = trim((string) ($_GET["filtre"] ?? ($_POST["filtre"] ?? "")));

if ($filtre !== "") {
    $lesOffres = $unControleur->selectLike_offre($filtre);
} else {
    $lesOffres = $unControleur->selectAll_offres();
}

// tri

$tri = (string) ($_GET["tri"] ?? "titre");
$ordre = (string) ($_GET["ordre"] ?? "asc");
$trisAutorises = ["titre", "destination", "reduction", "date_debut", "date_fin", "actif"];

if (!in_array($tri, $trisAutorises, true)) {
    $tri = "titre";
}

if ($ordre !== "desc") {
    $ordre = "asc";
}

// comparaison utilisee pour trier les offres
usort($lesOffres, function (array $a, array $b) use ($tri, $ordre): int {
    if ($tri === "destination") {
        $valeurA = trim((string) ($a["pays"] ?? "") . " " . (string) ($a["ville"] ?? ""));
        $valeurB = trim((string) ($b["pays"] ?? "") . " " . (string) ($b["ville"] ?? ""));
        $comparaison = strcasecmp($valeurA, $valeurB);
    } elseif ($tri === "reduction") {
        $comparaison = (int) ($a["pourcentage_reduction"] ?? 0) <=> (int) ($b["pourcentage_reduction"] ?? 0);
    } elseif ($tri === "actif") {
        $comparaison = (int) ($a["actif"] ?? 0) <=> (int) ($b["actif"] ?? 0);
    } else {
        $comparaison = strcasecmp((string) ($a[$tri] ?? ""), (string) ($b[$tri] ?? ""));
    }

    return $ordre === "desc" ? -$comparaison : $comparaison;
});

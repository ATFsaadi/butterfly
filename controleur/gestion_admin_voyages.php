<?php

// sécurité admin

$unControleur->verifAdmin();

// variables de base

$errors = [];
$success = "";

$voyageToEdit = null;
$destinations = $unControleur->selectAll_destinations_admin();

// action supprimer ou modifier

if (isset($_GET["action"], $_GET["id_voyage"])) {
    $action = (string) $_GET["action"];
    $idVoyage = (int) $_GET["id_voyage"];

    if ($action === "sup") {
        $voyageExistant = $unControleur->selectWhere_voyage($idVoyage);

        if ($voyageExistant) {
            $unControleur->delete_voyage($idVoyage);
        }

        header("location: index.php?page=admin_voyages");
        exit();
    }

    if ($action === "edit") {
        $voyageToEdit = $unControleur->selectWhere_voyage($idVoyage);

        if (!$voyageToEdit) {
            header("location: index.php?page=admin_voyages");
            exit();
        }
    }
}

// upload image voyage

function handleVoyageImageUpload(array $file): ?string
{
    if (($file["error"] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
        return null;
    }

    $extensionsAutorisees = ["jpg", "jpeg", "png", "gif", "webp"];
    $extension = strtolower(pathinfo($file["name"] ?? "", PATHINFO_EXTENSION));

    if ($extension === "" || !in_array($extension, $extensionsAutorisees, true)) {
        return null;
    }

    $dossierVoyages = "images/voyages/";

    if (!is_dir($dossierVoyages)) {
        mkdir($dossierVoyages, 0755, true);
    }

    $nomFichier = "voyage_" . time() . "_" . bin2hex(random_bytes(6)) . "." . $extension;
    $cheminFichier = $dossierVoyages . $nomFichier;

    if (is_uploaded_file($file["tmp_name"] ?? "") && move_uploaded_file($file["tmp_name"], $cheminFichier)) {
        return $cheminFichier;
    }

    return null;
}

// traitement du formulaire

if (isset($_POST["submit"])) {
    $isEdit = !empty($_POST["id_voyage"]);

    // récupération des champs

    $idVoyage = (int) ($_POST["id_voyage"] ?? 0);
    $idDestination = (int) ($_POST["id_destination"] ?? 0);
    $titre = trim((string) ($_POST["titre"] ?? ""));
    $description = trim((string) ($_POST["description"] ?? ""));
    $dateDepart = trim((string) ($_POST["date_depart"] ?? ""));
    $dateRetour = trim((string) ($_POST["date_retour"] ?? ""));
    $prix = (float) ($_POST["prix"] ?? 0);
    $nbPlaces = (int) ($_POST["nb_places"] ?? 0);
    $nbPlacesRestantes = (int) ($_POST["nb_places_restantes"] ?? 0);
    $statut = trim((string) ($_POST["statut"] ?? "actif"));

    // récupération du voyage en modification

    if ($isEdit) {
        if ($voyageToEdit === null || (int) ($voyageToEdit["id_voyage"] ?? 0) !== $idVoyage) {
            $voyageToEdit = $unControleur->selectWhere_voyage($idVoyage);
        }

        if (!$voyageToEdit) {
            header("location: index.php?page=admin_voyages");
            exit();
        }
    }

    // validation destination

    if ($idDestination <= 0) {
        $errors[] = "la destination est obligatoire.";
    } else {
        $destination = $unControleur->selectWhere_destination($idDestination);

        if (!$destination) {
            $errors[] = "la destination sélectionnée est invalide.";
        }
    }

    // validation titre

    if ($titre === "") {
        $errors[] = "le titre est obligatoire.";
    }

    // validation dates

    if ($dateDepart === "") {
        $errors[] = "la date départ est obligatoire.";
    }

    if ($dateRetour === "") {
        $errors[] = "la date retour est obligatoire.";
    }

    if ($dateDepart !== "" && $dateRetour !== "" && $dateRetour < $dateDepart) {
        $errors[] = "la date retour doit être supérieure ou égale à la date départ.";
    }

    // validation prix et places

    if ($prix <= 0) {
        $errors[] = "le prix doit être supérieur à 0.";
    }

    if ($nbPlaces <= 0) {
        $errors[] = "le nombre de places doit être supérieur à 0.";
    }

    if ($nbPlacesRestantes < 0) {
        $errors[] = "les places restantes doivent être supérieures ou égales à 0.";
    }

    if ($nbPlaces > 0 && $nbPlacesRestantes > $nbPlaces) {
        $errors[] = "les places restantes doivent être inférieures ou égales au nombre de places.";
    }

    // validation statut

    $statutsAutorises = ["actif", "complet", "annule"];

    if (!in_array($statut, $statutsAutorises, true)) {
        $errors[] = "statut invalide.";
    }

    if ($statut === "actif" && $nbPlacesRestantes === 0) {
        $statut = "complet";
    }

    // traitement de l'image

    $imageUrl = null;

    if (!empty($_FILES["image"]["name"] ?? "")) {
        $imageUrl = handleVoyageImageUpload($_FILES["image"]);

        if ($imageUrl === null) {
            $errors[] = "image invalide ou upload échoué (jpg/jpeg/png/gif/webp).";
        }
    } else {
        $imageUrl = $isEdit ? ($voyageToEdit["image_url"] ?? null) : null;
    }

    // préparation des données

    $tab = [
        "id_destination" => $idDestination,
        "titre" => $titre,
        "description" => $description !== "" ? $description : null,
        "date_depart" => $dateDepart,
        "date_retour" => $dateRetour,
        "prix" => $prix,
        "nb_places" => $nbPlaces,
        "nb_places_restantes" => $nbPlacesRestantes,
        "image_url" => $imageUrl,
        "statut" => $statut,
    ];

    if ($isEdit) {
        $tab["id_voyage"] = $idVoyage;
    }

    // insertion ou modification

    if (empty($errors)) {
        if ($isEdit) {
            $unControleur->update_voyage($tab);
        } else {
            $unControleur->insert_voyage($tab);
        }

        header("location: index.php?page=admin_voyages");
        exit();
    }

    // conservation du formulaire en cas d'erreur

    if ($isEdit) {
        $voyageToEdit = $tab;
        $voyageToEdit["id_voyage"] = $idVoyage;
    } else {
        $voyageToEdit = $tab;
    }
}

// filtre de recherche

if (isset($_POST["Filtrer"])) {
    $filtre = trim((string) ($_POST["filtre"] ?? ""));
    $tousLesVoyages = $unControleur->selectAll_voyages_admin();

    if ($filtre !== "") {
        $filtreMin = mb_strtolower($filtre);

        $lesVoyages = array_values(array_filter($tousLesVoyages, function ($voyage) use ($filtreMin) {
            return str_contains(mb_strtolower((string) ($voyage["titre"] ?? "")), $filtreMin)
                || str_contains(mb_strtolower((string) ($voyage["pays"] ?? "")), $filtreMin)
                || str_contains(mb_strtolower((string) ($voyage["ville"] ?? "")), $filtreMin)
                || str_contains(mb_strtolower((string) ($voyage["statut"] ?? "")), $filtreMin);
        }));
    } else {
        $lesVoyages = $tousLesVoyages;
    }
} else {
    $lesVoyages = $unControleur->selectAll_voyages_admin();
}

// variables pour la vue

$voyages = $lesVoyages;
$voyage = $voyageToEdit;
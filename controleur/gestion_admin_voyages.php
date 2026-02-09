<?php

$unControleur->verifAdmin();

$errors = [];
$success = "";

$voyageToEdit = null;

$destinations = $unControleur->selectAll_destinations_admin();

if (isset($_GET["action"], $_GET["id_voyage"])) {
    $action = (string) $_GET["action"];
    $id_voyage = (int) $_GET["id_voyage"];

    if ($action === "sup") {
        $unControleur->delete_voyage($id_voyage);
        header("location: index.php?page=admin_voyages");
        exit();
    }

    if ($action === "edit") {
        $voyageToEdit = $unControleur->selectWhere_voyage($id_voyage);
    }
}

function handleVoyageImageUpload(array $file): ?string
{
    if (!isset($file) || ($file["error"] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
        return null;
    }

    $allowed = ["jpg", "jpeg", "png", "gif", "webp"];
    $ext = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));

    if (!in_array($ext, $allowed, true)) {
        return null;
    }

    $targetDir = "images/voyages/";

    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0755, true);
    }

    $fileName = "voyage_" . time() . "_" . uniqid() . "." . $ext;
    $targetFile = $targetDir . $fileName;

    if (move_uploaded_file($file["tmp_name"], $targetFile)) {
        return $targetFile;
    }

    return null;
}

if (isset($_POST["submit"])) {

    $isEdit = !empty($_POST["id_voyage"]);

    $id_destination = (int) ($_POST["id_destination"] ?? 0);
    $titre = trim($_POST["titre"] ?? "");
    $description = trim($_POST["description"] ?? "");
    $date_depart = trim($_POST["date_depart"] ?? "");
    $date_retour = trim($_POST["date_retour"] ?? "");
    $prix = (float) ($_POST["prix"] ?? 0);
    $nb_places = (int) ($_POST["nb_places"] ?? 0);
    $nb_places_restantes = (int) ($_POST["nb_places_restantes"] ?? 0);
    $statut = trim($_POST["statut"] ?? "actif");

    if ($id_destination <= 0) {
        $errors[] = "la destination est obligatoire.";
    }

    if ($titre === "") {
        $errors[] = "le titre est obligatoire.";
    }

    if ($date_depart === "") {
        $errors[] = "la date depart est obligatoire.";
    }

    if ($date_retour === "") {
        $errors[] = "la date retour est obligatoire.";
    }

    if ($date_depart !== "" && $date_retour !== "" && $date_retour < $date_depart) {
        $errors[] = "la date retour doit être >= date depart.";
    }

    if ($prix <= 0) {
        $errors[] = "le prix doit être > 0.";
    }

    if ($nb_places <= 0) {
        $errors[] = "le nombre de places doit être > 0.";
    }

    if ($nb_places_restantes < 0) {
        $errors[] = "les places restantes doivent être >= 0.";
    }

    if ($nb_places > 0 && $nb_places_restantes > $nb_places) {
        $errors[] = "les places restantes doivent être <= nb places.";
    }

    $statutsOk = ["actif", "complet", "annule"];
    if (!in_array($statut, $statutsOk, true)) {
        $errors[] = "statut invalide.";
    }

    if ($isEdit) {
        $idEdit = (int) $_POST["id_voyage"];

        if ($voyageToEdit === null || (int) ($voyageToEdit["id_voyage"] ?? 0) !== $idEdit) {
            $voyageToEdit = $unControleur->selectWhere_voyage($idEdit);
        }
    }

    if (!empty($_FILES["image"]["name"])) {
        $imgPath = handleVoyageImageUpload($_FILES["image"]);
        if ($imgPath) {
            $_POST["image_url"] = $imgPath;
        } else {
            $errors[] = "image invalide ou upload échoué (jpg/jpeg/png/gif/webp).";
        }
    } else {
        if ($isEdit) {
            $_POST["image_url"] = $voyageToEdit["image_url"] ?? null;
        } else {
            $_POST["image_url"] = null;
        }
    }

    $_POST["id_destination"] = $id_destination;
    $_POST["titre"] = $titre;
    $_POST["description"] = ($description !== "") ? $description : null;
    $_POST["date_depart"] = $date_depart;
    $_POST["date_retour"] = $date_retour;
    $_POST["prix"] = $prix;
    $_POST["nb_places"] = $nb_places;
    $_POST["nb_places_restantes"] = $nb_places_restantes;
    $_POST["statut"] = $statut;

    if (empty($errors)) {
        if ($isEdit) {
            $unControleur->update_voyage($_POST);
            header("location: index.php?page=admin_voyages");
            exit();
        } else {
            $unControleur->insert_voyage($_POST);
            header("location: index.php?page=admin_voyages");
            exit();
        }
    }
}

if (isset($_POST["Filtrer"])) {
    $filtre = trim($_POST["filtre"] ?? "");
    $all = $unControleur->selectAll_voyages_admin();

    if ($filtre !== "") {
        $f = mb_strtolower($filtre);

        $lesVoyages = array_values(array_filter($all, function ($v) use ($f) {
            return str_contains(mb_strtolower($v["titre"] ?? ""), $f)
                || str_contains(mb_strtolower($v["pays"] ?? ""), $f)
                || str_contains(mb_strtolower($v["ville"] ?? ""), $f)
                || str_contains(mb_strtolower($v["statut"] ?? ""), $f);
        }));
    } else {
        $lesVoyages = $all;
    }
} else {
    $lesVoyages = $unControleur->selectAll_voyages_admin();
}

$voyages = $lesVoyages;
$voyage = $voyageToEdit;

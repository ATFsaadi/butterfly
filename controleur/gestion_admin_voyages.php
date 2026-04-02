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
        $voyageExistant = $unControleur->selectWhere_voyage($id_voyage);

        if ($voyageExistant) {
            $unControleur->delete_voyage($id_voyage);
        }

        header("location: index.php?page=admin_voyages");
        exit();
    }

    if ($action === "edit") {
        $voyageToEdit = $unControleur->selectWhere_voyage($id_voyage);

        if (!$voyageToEdit) {
            header("location: index.php?page=admin_voyages");
            exit();
        }
    }
}

function handleVoyageImageUpload(array $file): ?string
{
    if (($file["error"] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
        return null;
    }

    $allowed = ["jpg", "jpeg", "png", "gif", "webp"];
    $ext = strtolower(pathinfo($file["name"] ?? "", PATHINFO_EXTENSION));

    if ($ext === "" || !in_array($ext, $allowed, true)) {
        return null;
    }

    $targetDir = "images/voyages/";

    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0755, true);
    }

    $fileName = "voyage_" . time() . "_" . bin2hex(random_bytes(6)) . "." . $ext;
    $targetFile = $targetDir . $fileName;

    if (is_uploaded_file($file["tmp_name"] ?? "") && move_uploaded_file($file["tmp_name"], $targetFile)) {
        return $targetFile;
    }

    return null;
}

if (isset($_POST["submit"])) {
    $isEdit = !empty($_POST["id_voyage"]);

    $id_voyage = (int) ($_POST["id_voyage"] ?? 0);
    $id_destination = (int) ($_POST["id_destination"] ?? 0);
    $titre = trim((string) ($_POST["titre"] ?? ""));
    $description = trim((string) ($_POST["description"] ?? ""));
    $date_depart = trim((string) ($_POST["date_depart"] ?? ""));
    $date_retour = trim((string) ($_POST["date_retour"] ?? ""));
    $prix = (float) ($_POST["prix"] ?? 0);
    $nb_places = (int) ($_POST["nb_places"] ?? 0);
    $nb_places_restantes = (int) ($_POST["nb_places_restantes"] ?? 0);
    $statut = trim((string) ($_POST["statut"] ?? "actif"));

    if ($isEdit) {
        if ($voyageToEdit === null || (int) ($voyageToEdit["id_voyage"] ?? 0) !== $id_voyage) {
            $voyageToEdit = $unControleur->selectWhere_voyage($id_voyage);
        }

        if (!$voyageToEdit) {
            header("location: index.php?page=admin_voyages");
            exit();
        }
    }

    if ($id_destination <= 0) {
        $errors[] = "la destination est obligatoire.";
    } else {
        $destination = $unControleur->selectWhere_destination($id_destination);
        if (!$destination) {
            $errors[] = "la destination sélectionnée est invalide.";
        }
    }

    if ($titre === "") {
        $errors[] = "le titre est obligatoire.";
    }

    if ($date_depart === "") {
        $errors[] = "la date départ est obligatoire.";
    }

    if ($date_retour === "") {
        $errors[] = "la date retour est obligatoire.";
    }

    if ($date_depart !== "" && $date_retour !== "" && $date_retour < $date_depart) {
        $errors[] = "la date retour doit être supérieure ou égale à la date départ.";
    }

    if ($prix <= 0) {
        $errors[] = "le prix doit être supérieur à 0.";
    }

    if ($nb_places <= 0) {
        $errors[] = "le nombre de places doit être supérieur à 0.";
    }

    if ($nb_places_restantes < 0) {
        $errors[] = "les places restantes doivent être supérieures ou égales à 0.";
    }

    if ($nb_places > 0 && $nb_places_restantes > $nb_places) {
        $errors[] = "les places restantes doivent être inférieures ou égales au nombre de places.";
    }

    $statutsOk = ["actif", "complet", "annule"];
    if (!in_array($statut, $statutsOk, true)) {
        $errors[] = "statut invalide.";
    }

    if ($statut === "actif" && $nb_places_restantes === 0) {
        $statut = "complet";
    }

    $image_url = null;

    if (!empty($_FILES["image"]["name"] ?? "")) {
        $image_url = handleVoyageImageUpload($_FILES["image"]);

        if ($image_url === null) {
            $errors[] = "image invalide ou upload échoué (jpg/jpeg/png/gif/webp).";
        }
    } else {
        $image_url = $isEdit ? ($voyageToEdit["image_url"] ?? null) : null;
    }

    $tab = [
        "id_destination" => $id_destination,
        "titre" => $titre,
        "description" => $description !== "" ? $description : null,
        "date_depart" => $date_depart,
        "date_retour" => $date_retour,
        "prix" => $prix,
        "nb_places" => $nb_places,
        "nb_places_restantes" => $nb_places_restantes,
        "image_url" => $image_url,
        "statut" => $statut,
    ];

    if ($isEdit) {
        $tab["id_voyage"] = $id_voyage;
    }

    if (empty($errors)) {
        if ($isEdit) {
            $unControleur->update_voyage($tab);
        } else {
            $unControleur->insert_voyage($tab);
        }

        header("location: index.php?page=admin_voyages");
        exit();
    }

    if ($isEdit) {
        $voyageToEdit = $tab;
        $voyageToEdit["id_voyage"] = $id_voyage;
    } else {
        $voyageToEdit = $tab;
    }
}

if (isset($_POST["Filtrer"])) {
    $filtre = trim((string) ($_POST["filtre"] ?? ""));
    $all = $unControleur->selectAll_voyages_admin();

    if ($filtre !== "") {
        $f = mb_strtolower($filtre);

        $lesVoyages = array_values(array_filter($all, function ($v) use ($f) {
            return str_contains(mb_strtolower((string) ($v["titre"] ?? "")), $f)
                || str_contains(mb_strtolower((string) ($v["pays"] ?? "")), $f)
                || str_contains(mb_strtolower((string) ($v["ville"] ?? "")), $f)
                || str_contains(mb_strtolower((string) ($v["statut"] ?? "")), $f);
        }));
    } else {
        $lesVoyages = $all;
    }
} else {
    $lesVoyages = $unControleur->selectAll_voyages_admin();
}

$voyages = $lesVoyages;
$voyage = $voyageToEdit;
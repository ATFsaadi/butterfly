<?php

$unControleur->verifAdmin();

$errors = [];
$success = "";

$destinationToEdit = null;
$continents = $unControleur->selectAll_continents();

// actions get

if (isset($_GET["action"], $_GET["id_destination"])) {
    $action = $_GET["action"];
    $id_destination = (int) $_GET["id_destination"];

    if ($action === "sup") {
        $unControleur->delete_destination($id_destination);
        header("location: index.php?page=admin_destinations");
        exit();
    }

    if ($action === "edit") {
        $destinationToEdit = $unControleur->selectWhere_destination($id_destination);
    }
}

// upload image

function handleImageUpload(array $file): ?string
{
    if (!isset($file) || ($file["error"] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
        return null;
    }

    $allowed = ["jpg", "jpeg", "png", "gif", "webp"];
    $ext = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));

    if (!in_array($ext, $allowed, true)) {
        return null;
    }

    $targetDir = "images/destinations/";

    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0755, true);
    }

    $fileName = "dest_" . time() . "_" . uniqid() . "." . $ext;
    $targetFile = $targetDir . $fileName;

    if (move_uploaded_file($file["tmp_name"], $targetFile)) {
        return $targetFile;
    }

    return null;
}

// actions post

if (isset($_POST["submit"])) {

    // ajout

    if (empty($_POST["id_destination"])) {

        $pays = trim($_POST["pays"] ?? "");
        $ville = trim($_POST["ville"] ?? "");
        $prix_base = (float) ($_POST["prix_base"] ?? 0);

        if ($pays === "") {
            $errors[] = "le pays est obligatoire.";
        }

        if ($ville === "") {
            $errors[] = "la ville est obligatoire.";
        }

        if ($prix_base <= 0) {
            $errors[] = "le prix base doit être > 0.";
        }

        if (!empty($_FILES["image"]["name"])) {
            $imgPath = handleImageUpload($_FILES["image"]);

            if ($imgPath) {
                $_POST["image_url"] = $imgPath;
            } else {
                $errors[] = "image invalide ou upload échoué (jpg/jpeg/png/gif/webp).";
            }
        } else {
            $_POST["image_url"] = null;
        }

        $_POST["actif"] = isset($_POST["actif"]) ? 1 : 0;

        if (empty($errors)) {
            $unControleur->insert_destination($_POST);
            $success = "✅ destination ajoutée.";
        }
    }

    // modification

    if (!empty($_POST["id_destination"])) {

        $idEdit = (int) $_POST["id_destination"];

        if ($destinationToEdit === null || (int) ($destinationToEdit["id_destination"] ?? 0) !== $idEdit) {
            $destinationToEdit = $unControleur->selectWhere_destination($idEdit);
        }

        if (!empty($_FILES["image"]["name"])) {
            $imgPath = handleImageUpload($_FILES["image"]);

            if ($imgPath) {
                $_POST["image_url"] = $imgPath;
            } else {
                $errors[] = "image invalide ou upload échoué (jpg/jpeg/png/gif/webp).";
            }
        } else {
            $_POST["image_url"] = $destinationToEdit["image_url"] ?? null;
        }

        $_POST["actif"] = isset($_POST["actif"]) ? 1 : 0;

        if (empty($errors)) {
            $unControleur->update_destination($_POST);
            header("location: index.php?page=admin_destinations");
            exit();
        }
    }
}

// liste et filtre admin

if (isset($_POST["Filtrer"])) {
    $filtre = trim($_POST["filtre"] ?? "");
    $all = $unControleur->selectAll_destinations_admin();

    if ($filtre !== "") {
        $f = mb_strtolower($filtre);

        $lesDestinations = array_values(array_filter($all, function ($d) use ($f) {
            return str_contains(mb_strtolower($d["pays"] ?? ""), $f)
                || str_contains(mb_strtolower($d["ville"] ?? ""), $f)
                || str_contains(mb_strtolower($d["continent"] ?? ""), $f);
        }));
    } else {
        $lesDestinations = $all;
    }
} else {
    $lesDestinations = $unControleur->selectAll_destinations_admin();
}

// variables pour les vues

$destinations = $lesDestinations;
$destination = $destinationToEdit;

// chargement des vues

require_once "vue/vue_insert_destinations.php";
require_once "vue/vue_select_destinations.php";

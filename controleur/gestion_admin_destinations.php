<?php

$unControleur->verifAdmin();

$errors = [];
$success = "";

$destinationToEdit = null;
$continents = $unControleur->selectAll_continents();

if (isset($_GET["action"], $_GET["id_destination"])) {
    $action = $_GET["action"];
    $id_destination = (int)$_GET["id_destination"];

    if ($action === "sup") {
        $unControleur->delete_destination($id_destination);
        header("location: index.php?page=admin_destinations");
        exit();
    }

    if ($action === "edit") {
        $destinationToEdit = $unControleur->selectWhere_destination($id_destination);
    }
}

function handleImageUpload(array $file): ?string
{
    if (($file["error"] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
        return null;
    }

    $allowed = ["jpg", "jpeg", "png", "gif", "webp"];
    $ext = strtolower(pathinfo($file["name"] ?? "", PATHINFO_EXTENSION));

    if ($ext === "" || !in_array($ext, $allowed, true)) {
        return null;
    }

    $targetDir = "images/destinations/";
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0755, true);
    }

    $fileName = "dest_" . time() . "_" . bin2hex(random_bytes(6)) . "." . $ext;
    $targetFile = $targetDir . $fileName;

    if (is_uploaded_file($file["tmp_name"] ?? "") && move_uploaded_file($file["tmp_name"], $targetFile)) {
        return $targetFile;
    }

    return null;
}

if (isset($_POST["submit"])) {
    $isEdit = isset($_POST["id_destination"]) && $_POST["id_destination"] !== "";
    $pays = trim((string)($_POST["pays"] ?? ""));
    $ville = trim((string)($_POST["ville"] ?? ""));
    $prix_base = (float)($_POST["prix_base"] ?? 0);

    if ($pays === "") {
        $errors[] = "le pays est obligatoire.";
    }

    if ($ville === "") {
        $errors[] = "la ville est obligatoire.";
    }

    if ($prix_base <= 0) {
        $errors[] = "le prix base doit être > 0.";
    }

    if ($isEdit) {
        $idEdit = (int)$_POST["id_destination"];
        if ($destinationToEdit === null || (int)($destinationToEdit["id_destination"] ?? 0) !== $idEdit) {
            $destinationToEdit = $unControleur->selectWhere_destination($idEdit);
        }
        if (!$destinationToEdit) {
            header("location: index.php?page=admin_destinations");
            exit();
        }
    }

    $imgPath = null;
    if (!empty($_FILES["image"]["name"] ?? "")) {
        $imgPath = handleImageUpload($_FILES["image"]);
        if ($imgPath === null) {
            $errors[] = "image invalide ou upload échoué (jpg/jpeg/png/gif/webp).";
        }
    }

    $tab = [
        "pays" => $pays,
        "ville" => $ville,
        "id_continent" => ($_POST["id_continent"] ?? "") !== "" ? (int)$_POST["id_continent"] : null,
        "description" => ($_POST["description"] ?? "") !== "" ? (string)$_POST["description"] : null,
        "prix_base" => $prix_base,
        "image_url" => $imgPath ?? ($isEdit ? ($destinationToEdit["image_url"] ?? null) : null),
        "actif" => isset($_POST["actif"]) ? 1 : 0,
    ];

    if ($isEdit) {
        $tab["id_destination"] = (int)$_POST["id_destination"];
    }

    if (empty($errors)) {
        if ($isEdit) {
            $unControleur->update_destination($tab);
        } else {
            $unControleur->insert_destination($tab);
        }

        header("location: index.php?page=admin_destinations");
        exit();
    }
}

if (isset($_POST["Filtrer"])) {
    $filtre = trim((string)($_POST["filtre"] ?? ""));
    if ($filtre !== "") {
        $destinations = $unControleur->selectLike_destination($filtre);
        $all = $unControleur->selectAll_destinations_admin();
        $ids = array_flip(array_map(fn($d) => (int)$d["id_destination"], $all));
        $destinations = array_values(array_filter($destinations, fn($d) => isset($ids[(int)$d["id_destination"]])));
    } else {
        $destinations = $unControleur->selectAll_destinations_admin();
    }
} else {
    $destinations = $unControleur->selectAll_destinations_admin();
}

$destination = $destinationToEdit;

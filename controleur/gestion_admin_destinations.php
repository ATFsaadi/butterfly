<?php

$unControleur->verifAdmin();

$errors = [];
$success = "";

$destinationToEdit = null;
$continents = $unControleur->selectAll_continents();

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

        if (!$destinationToEdit) {
            header("location: index.php?page=admin_destinations");
            exit();
        }
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

    $pays = trim((string) ($_POST["pays"] ?? ""));
    $ville = trim((string) ($_POST["ville"] ?? ""));
    $prix_base = (float) ($_POST["prix_base"] ?? 0);

    $id_continent = null;
    if (($_POST["id_continent"] ?? "") !== "") {
        $id_continent = (int) $_POST["id_continent"];
    }

    if ($pays === "") {
        $errors[] = "le pays est obligatoire.";
    }

    if ($ville === "") {
        $errors[] = "la ville est obligatoire.";
    }

    if ($prix_base <= 0) {
        $errors[] = "le prix de base doit être supérieur à 0.";
    }

    if ($id_continent !== null) {
        $continent = $unControleur->selectWhere_continent($id_continent);
        if (!$continent) {
            $errors[] = "le continent sélectionné est invalide.";
        }
    }

    if ($isEdit) {
        $idEdit = (int) $_POST["id_destination"];

        if ($destinationToEdit === null || (int) ($destinationToEdit["id_destination"] ?? 0) !== $idEdit) {
            $destinationToEdit = $unControleur->selectWhere_destination($idEdit);
        }

        if (!$destinationToEdit) {
            header("location: index.php?page=admin_destinations");
            exit();
        }
    }

    // vérification du doublon (pays, ville)
    if ($pays !== "" && $ville !== "") {
        if ($isEdit) {
            $doublon = $unControleur->selectWhere_destination_by_pays_ville_except_id(
                $pays,
                $ville,
                (int) $_POST["id_destination"]
            );
        } else {
            $doublon = $unControleur->selectWhere_destination_by_pays_ville($pays, $ville);
        }

        if ($doublon) {
            $errors[] = "cette destination existe déjà pour ce pays et cette ville.";
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
        "id_continent" => $id_continent,
        "description" => ($_POST["description"] ?? "") !== "" ? trim((string) $_POST["description"]) : null,
        "prix_base" => $prix_base,
        "image_url" => $imgPath ?? ($isEdit ? ($destinationToEdit["image_url"] ?? null) : null),
        "actif" => isset($_POST["actif"]) ? 1 : 0,
    ];

    if ($isEdit) {
        $tab["id_destination"] = (int) $_POST["id_destination"];
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

$destinations = $unControleur->selectAll_destinations_admin();

if (isset($_POST["Filtrer"])) {
    $filtre = trim((string) ($_POST["filtre"] ?? ""));

    if ($filtre !== "") {
        $filtreMin = mb_strtolower($filtre);

        $destinations = array_values(array_filter($destinations, function ($d) use ($filtreMin) {
            $pays = mb_strtolower((string) ($d["pays"] ?? ""));
            $ville = mb_strtolower((string) ($d["ville"] ?? ""));
            $continent = mb_strtolower((string) ($d["continent"] ?? ""));
            $description = mb_strtolower((string) ($d["description"] ?? ""));
            $etat = ((int) ($d["actif"] ?? 0) === 1) ? "actif" : "inactif";

            return str_contains($pays, $filtreMin)
                || str_contains($ville, $filtreMin)
                || str_contains($continent, $filtreMin)
                || str_contains($description, $filtreMin)
                || str_contains($etat, $filtreMin);
        }));
    }
}

$destination = $destinationToEdit;
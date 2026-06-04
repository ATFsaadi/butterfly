<?php

// Controleur admin destinations : CRUD, upload image, filtre et tri.

// sécurité admin
$unControleur->verifAdmin();

// variables de base
$errors = [];

$destinationToEdit = null;
$continents = $unControleur->selectAll_continents();

// action supprimer ou modifier
if (isset($_GET["action"], $_GET["id_destination"])) {
    $action = $_GET["action"];
    $idDestination = (int) $_GET["id_destination"];

    if ($action === "sup" && $idDestination > 0) {
        $unControleur->delete_destination($idDestination);

        header("location: index.php?page=admin_destinations");
        exit();
    }

    if ($action === "edit" && $idDestination > 0) {
        $destinationToEdit = $unControleur->selectWhere_destination($idDestination);

        if (!$destinationToEdit) {
            header("location: index.php?page=admin_destinations");
            exit();
        }
    }
}

// upload image destination
function handleImageUpload(array $file): ?string
{
    if (($file["error"] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
        return null;
    }

    $extensionsAutorisees = ["jpg", "jpeg", "png", "gif", "webp"];
    $extension = strtolower(pathinfo($file["name"] ?? "", PATHINFO_EXTENSION));

    if ($extension === "" || !in_array($extension, $extensionsAutorisees, true)) {
        return null;
    }

    // Vérification réelle du type MIME
    $typesAutorises = ["image/jpeg", "image/png", "image/gif", "image/webp"];
    $typeMime = mime_content_type($file["tmp_name"]);

    if (!in_array($typeMime, $typesAutorises, true)) {
        return null;
    }

    $dossierDestination = "images/destinations/";

    if (!is_dir($dossierDestination)) {
        mkdir($dossierDestination, 0755, true);
    }

    try {
        $nomFichier = "dest_" . time() . "_" . bin2hex(random_bytes(6)) . "." . $extension;
    } catch (Exception $e) {
        return null;
    }

    $cheminFichier = $dossierDestination . $nomFichier;

    if (
        is_uploaded_file($file["tmp_name"] ?? "") &&
        move_uploaded_file($file["tmp_name"], $cheminFichier)
    ) {
        return $cheminFichier;
    }

    return null;
}

// traitement du formulaire
if (isset($_POST["submit"])) {
    $isEdit = isset($_POST["id_destination"]) && $_POST["id_destination"] !== "";

    $pays = trim((string) ($_POST["pays"] ?? ""));
    $ville = trim((string) ($_POST["ville"] ?? ""));
    $prixBase = (float) ($_POST["prix_base"] ?? 0);

    $idContinent = null;

    if (($_POST["id_continent"] ?? "") !== "") {
        $idContinent = (int) $_POST["id_continent"];
    }

    // validation des champs
    if ($pays === "") {
        $errors[] = "Le pays est obligatoire.";
    }

    if ($ville === "") {
        $errors[] = "La ville est obligatoire.";
    }

    if ($prixBase <= 0) {
        $errors[] = "Le prix de base doit être supérieur à 0.";
    }

    if ($idContinent !== null) {
        $continent = $unControleur->selectWhere_continent($idContinent);

        if (!$continent) {
            $errors[] = "Le continent sélectionné est invalide.";
        }
    }

    // récupération destination en modification
    if ($isEdit) {
        $idEdit = (int) $_POST["id_destination"];

        if ($idEdit <= 0) {
            header("location: index.php?page=admin_destinations");
            exit();
        }

        if (
            $destinationToEdit === null ||
            (int) ($destinationToEdit["id_destination"] ?? 0) !== $idEdit
        ) {
            $destinationToEdit = $unControleur->selectWhere_destination($idEdit);
        }

        if (!$destinationToEdit) {
            header("location: index.php?page=admin_destinations");
            exit();
        }
    }

    // vérification doublon pays et ville
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
            $errors[] = "Cette destination existe déjà pour ce pays et cette ville.";
        }
    }

    // traitement de l'image
    $imagePath = null;

    if (!empty($_FILES["image"]["name"] ?? "")) {
        $imagePath = handleImageUpload($_FILES["image"]);

        if ($imagePath === null) {
            $errors[] = "Image invalide ou upload échoué. Formats acceptés : jpg, jpeg, png, gif, webp.";
        }
    }

    // préparation des données
    $tab = [
        "pays" => $pays,
        "ville" => $ville,
        "id_continent" => $idContinent,
        "description" => ($_POST["description"] ?? "") !== ""
            ? trim((string) $_POST["description"])
            : null,
        "prix_base" => $prixBase,
        "image_url" => $imagePath ?? ($isEdit ? ($destinationToEdit["image_url"] ?? null) : null),
        "actif" => isset($_POST["actif"]) ? 1 : 0,
    ];

    if ($isEdit) {
        $tab["id_destination"] = (int) $_POST["id_destination"];
    }

    // insertion ou modification
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

// récupération des destinations
$destinations = $unControleur->selectAll_destinations_admin();

// filtre de recherche

$filtre = trim((string) ($_GET["filtre"] ?? ($_POST["filtre"] ?? "")));

if ($filtre !== "") {
    $filtreMin = mb_strtolower($filtre);

    // fonction de filtre appliquee a chaque destination
    $destinations = array_values(array_filter($destinations, function ($destination) use ($filtreMin) {
        $pays = mb_strtolower((string) ($destination["pays"] ?? ""));
        $ville = mb_strtolower((string) ($destination["ville"] ?? ""));
        $continent = mb_strtolower((string) ($destination["continent"] ?? ""));
        $description = mb_strtolower((string) ($destination["description"] ?? ""));
        $etat = ((int) ($destination["actif"] ?? 0) === 1) ? "actif" : "inactif";

        return strpos($pays, $filtreMin) !== false
            || strpos($ville, $filtreMin) !== false
            || strpos($continent, $filtreMin) !== false
            || strpos($description, $filtreMin) !== false
            || strpos($etat, $filtreMin) !== false;
    }));
}

// tri

$tri = (string) ($_GET["tri"] ?? "pays");
$ordre = (string) ($_GET["ordre"] ?? "asc");
$trisAutorises = ["pays", "ville", "continent", "prix_base", "actif"];

if (!in_array($tri, $trisAutorises, true)) {
    $tri = "pays";
}

if ($ordre !== "desc") {
    $ordre = "asc";
}

// comparaison utilisee pour trier les destinations
usort($destinations, function (array $a, array $b) use ($tri, $ordre): int {
    if ($tri === "prix_base") {
        $comparaison = (float) ($a[$tri] ?? 0) <=> (float) ($b[$tri] ?? 0);
    } elseif ($tri === "actif") {
        $comparaison = (int) ($a[$tri] ?? 0) <=> (int) ($b[$tri] ?? 0);
    } else {
        $comparaison = strcasecmp((string) ($a[$tri] ?? ""), (string) ($b[$tri] ?? ""));
    }

    return $ordre === "desc" ? -$comparaison : $comparaison;
});

// destination à afficher dans le formulaire
$destination = $destinationToEdit;
?>

<?php
$unControleur->verifAdmin();

$errors = [];
$success = "";

$destinationToEdit = null;
$continents = $unControleur->selectAll_continents();

/* =========================
   ACTIONS GET (sup / edit)
========================= */
if (isset($_GET['action'], $_GET['id_destination'])) {
    $action = $_GET['action'];
    $id_destination = (int) $_GET['id_destination'];

    switch ($action) {
        case "sup":
            $unControleur->delete_destination($id_destination);
            header("Location: index.php?page=admin_destinations");
            exit();

        case "edit":
            $destinationToEdit = $unControleur->selectWhere_destination($id_destination);
            break;
    }
}

/* =========================
   UPLOAD IMAGE
========================= */
function handleImageUpload($file)
{
    if (!isset($file) || $file['error'] !== UPLOAD_ERR_OK) {
        return null;
    }

    $allowed = ["jpg","jpeg","png","gif","webp"];
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

    if (!in_array($ext, $allowed, true)) {
        return null;
    }

    $targetDir = "images/destinations/";
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0755, true);
    }

    $fileName = "dest_" . time() . "_" . uniqid() . "." . $ext;
    $targetFile = $targetDir . $fileName;

    if (move_uploaded_file($file['tmp_name'], $targetFile)) {
        return $targetFile; // chemin relatif stocké en BDD
    }
    return null;
}

/* =========================
   ACTIONS POST (submit / Filtrer)
========================= */

// AJOUT
if (isset($_POST['submit']) && empty($_POST['id_destination'])) {

    // validation mini
    $pays = trim($_POST["pays"] ?? "");
    $ville = trim($_POST["ville"] ?? "");
    $prix_base = (float)($_POST["prix_base"] ?? 0);

    if ($pays === "") $errors[] = "Le pays est obligatoire.";
    if ($ville === "") $errors[] = "La ville est obligatoire.";
    if ($prix_base <= 0) $errors[] = "Le prix base doit être > 0.";

    // upload image (input name = image)
    if (!empty($_FILES['image']['name'])) {
        $imgPath = handleImageUpload($_FILES['image']);
        if ($imgPath) {
            $_POST['image_url'] = $imgPath;
        } else {
            $errors[] = "Image invalide ou upload échoué (jpg/jpeg/png/gif/webp).";
        }
    } else {
        $_POST['image_url'] = null;
    }

    // actif checkbox
    $_POST['actif'] = isset($_POST['actif']) ? 1 : 0;

    if (empty($errors)) {
        $unControleur->insert_destination($_POST);
        $success = "✅ Destination ajoutée.";
    }
}

// MODIFICATION
if (isset($_POST['submit']) && !empty($_POST['id_destination'])) {

    // on recharge la destination si pas déjà dispo (au cas où)
    $idEdit = (int)$_POST['id_destination'];
    if ($destinationToEdit === null || (int)($destinationToEdit['id_destination'] ?? 0) !== $idEdit) {
        $destinationToEdit = $unControleur->selectWhere_destination($idEdit);
    }

    // upload si nouvelle image sinon conserver
    if (!empty($_FILES['image']['name'])) {
        $imgPath = handleImageUpload($_FILES['image']);
        if ($imgPath) {
            $_POST['image_url'] = $imgPath;
        } else {
            $errors[] = "Image invalide ou upload échoué (jpg/jpeg/png/gif/webp).";
        }
    } else {
        $_POST['image_url'] = $destinationToEdit['image_url'] ?? null;
    }

    // actif checkbox
    $_POST['actif'] = isset($_POST['actif']) ? 1 : 0;

    if (empty($errors)) {
        $unControleur->update_destination($_POST);
        header("Location: index.php?page=admin_destinations");
        exit();
    }
}

// LISTE + FILTRE ADMIN
if (isset($_POST['Filtrer'])) {
    $filtre = trim($_POST['filtre'] ?? '');

    // IMPORTANT: selectLike_destination filtre actif=1 dans ton modèle,
    // donc pour l'admin on filtre sur la liste complète (actif + inactif)
    $all = $unControleur->selectAll_destinations_admin();

    if ($filtre !== "") {
        $f = mb_strtolower($filtre);
        $lesDestinations = array_values(array_filter($all, function ($d) use ($f) {
            return str_contains(mb_strtolower($d['pays'] ?? ''), $f)
                || str_contains(mb_strtolower($d['ville'] ?? ''), $f)
                || str_contains(mb_strtolower($d['continent'] ?? ''), $f);
        }));
    } else {
        $lesDestinations = $all;
    }
} else {
    // ADMIN => tout
    $lesDestinations = $unControleur->selectAll_destinations_admin();
}

/* =========================
   VARIABLES ATTENDUES PAR TES VUES
========================= */
$destinations = $lesDestinations;         // certaines de tes vues utilisent $destinations
$destination  = $destinationToEdit;       // si tu avais déjà $destination
$destinationToEdit = $destinationToEdit;  // pour les vues corrigées

/* =========================
   CHARGEMENT DES VUES
========================= */
require_once("vue/vue_insert_destinations.php");
require_once("vue/vue_select_destinations.php");
?>

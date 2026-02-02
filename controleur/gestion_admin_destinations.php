<?php
$unControleur->verifAdmin();

$destination = null;

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
            $destination = $unControleur->selectWhere_destination($id_destination);
            break;
    }
}

/* =========================
   UPLOAD IMAGE (comme l'école)
========================= */
function handleImageUpload($file)
{
    if (!isset($file) || $file['error'] !== UPLOAD_ERR_OK) {
        return null;
    }

    $targetDir = "images/destinations/";
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0755, true);
    }

    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $fileName = time() . "_" . uniqid() . "." . $ext;
    $targetFile = $targetDir . $fileName;

    move_uploaded_file($file['tmp_name'], $targetFile);
    return $targetFile;
}

/* =========================
   ACTIONS POST (Valider / Modifier / Filtrer)
========================= */

// ajout
if (isset($_POST['Valider'])) {

    // image (optionnelle)
    if (!empty($_FILES['image_url']['name'])) {
        $imgPath = handleImageUpload($_FILES['image_url']);
        if ($imgPath) {
            $_POST['image_url'] = $imgPath;
        }
    }

    $unControleur->insert_destination($_POST);
    echo '<div style="text-align:center; color:green; font-weight:bold;">&#10004; Destination ajoutée.</div>';
}

// modification
if (isset($_POST['Modifier'])) {

    // si nouvelle image -> upload, sinon on garde l'ancienne
    if (!empty($_FILES['image_url']['name'])) {
        $imgPath = handleImageUpload($_FILES['image_url']);
        if ($imgPath) {
            $_POST['image_url'] = $imgPath;
        }
    } else {
        $_POST['image_url'] = $destination['image_url'] ?? null;
    }

    $unControleur->update_destination($_POST);
    header("Location: index.php?page=admin_destinations");
    exit();
}

// filtrage
if (isset($_POST['Filtrer'])) {
    $filtre = $_POST['filtre'] ?? '';
    $lesDestinations = $unControleur->selectLike_destination($filtre);
} else {
    $lesDestinations = $unControleur->selectAll_destinations();
}

/* =========================
   CHARGEMENT DES VUES
========================= */
require_once("vue/vue_insert_destination.php");
require_once("vue/vue_select_destinations.php");
?>

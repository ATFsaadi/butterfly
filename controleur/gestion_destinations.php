<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/controleur_class.php';

$unControleur = new Controleur();
$unControleur->verifAdmin();

$uploadDir = __DIR__ . '/../images/destinations/';
$errors = [];

$allowedExt  = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
$allowedMime = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
$maxSize     = 5 * 1024 * 1024;

/* =========================
   AJOUT / MODIFICATION
   ========================= */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {

    $id = !empty($_POST['id_destination']) ? (int) $_POST['id_destination'] : null;

    $pays        = trim($_POST['pays'] ?? '');
    $ville       = trim($_POST['ville'] ?? '');
    $continent   = trim($_POST['continent'] ?? '');
    $prix_base   = (float) ($_POST['prix_base'] ?? 0);
    $description = trim($_POST['description'] ?? '');

    // image locale (stockée dans destinations.image_url)
    $imageName = $_POST['existing_image'] ?? null;

    /* validations */
    if ($pays === '') $errors[] = "Le pays est obligatoire.";
    if ($ville === '') $errors[] = "La ville est obligatoire.";
    if ($prix_base <= 0) $errors[] = "Le prix de base doit être > 0.";

    /* upload image */
    if (!empty($_FILES['image']['name']) && ($_FILES['image']['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_OK) {

        if (!empty($_FILES['image']['size']) && $_FILES['image']['size'] > $maxSize) {
            $errors[] = "Image trop volumineuse (max 5 Mo).";
        } else {

            $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
            if (!in_array($ext, $allowedExt, true)) {
                $errors[] = "Format image invalide.";
            } else {

                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $mime  = finfo_file($finfo, $_FILES['image']['tmp_name']);
                finfo_close($finfo);

                if (!in_array($mime, $allowedMime, true)) {
                    $errors[] = "Type de fichier non autorisé.";
                } else {

                    $imageName = uniqid('dest_') . '.' . $ext;

                    if (!move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $imageName)) {
                        $errors[] = "Erreur lors de l'upload de l'image.";
                    } else {
                        // suppression ancienne image si update
                        if (!empty($_POST['existing_image'])) {
                            $old = basename((string) $_POST['existing_image']);
                            $oldPath = $uploadDir . $old;
                            if (is_file($oldPath)) @unlink($oldPath);
                        }
                    }
                }
            }
        }
    }

    /* enregistrement */
    if (empty($errors)) {

        $data = [
            'pays'        => $pays,
            'ville'       => $ville,
            'continent'   => ($continent === '') ? null : $continent,
            'description' => ($description === '') ? null : $description,
            'prix_base'   => $prix_base,
            'image_url'   => $imageName,
            'actif'       => 1
        ];

        if ($id) {
            $data['id_destination'] = $id;
            $unControleur->updateDestination($data);
        } else {
            $unControleur->addDestination($data);
        }

        header('Location: index.php?page=admin_destinations');
        exit();
    }
}

/* =========================
   SUPPRESSION
   ========================= */
if (isset($_GET['delete'])) {

    $id = (int) $_GET['delete'];
    $dest = $unControleur->getDestinationById($id);

    if ($dest && !empty($dest['image_url'])) {
        $img = basename((string) $dest['image_url']);
        $imgPath = $uploadDir . $img;
        if (is_file($imgPath)) @unlink($imgPath);
    }

    $unControleur->deleteDestination($id);

    header('Location: index.php?page=admin_destinations');
    exit();
}

/* =========================
   DONNÉES POUR LA VUE
   ========================= */

$destinationToEdit = isset($_GET['edit'])
    ? $unControleur->getDestinationById((int) $_GET['edit'])
    : null;

/* OPTION : filtre/recherche côté admin */
$q = trim($_GET['q'] ?? '');
$continentFilter = trim($_GET['continent'] ?? '');
$prix_max = ($_GET['prix_max'] ?? '') !== '' ? (float) $_GET['prix_max'] : null;

if ($q !== '' || $continentFilter !== '' || $prix_max !== null) {
    $destinations = $unControleur->searchDestinations($q, $continentFilter, $prix_max);
} else {
    $destinations = $unControleur->getAllDestinations();
}

/* Pour la barre (si tu veux l’alimenter depuis ici) */
$continents  = $unControleur->getDistinctContinents();
// $villesDepart = $unControleur->getDistinctVillesDepart(); // seulement si table voyages existe

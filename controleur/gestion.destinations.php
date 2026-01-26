<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/controleur.class.php';

$unControleur = new Controleur();

// Sécurité admin
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: index.php?page=home');
    exit();
}

$uploadDir = __DIR__ . '/../images/destinations/';
$errors = [];

$allowedExt = ['jpg','jpeg','png','gif','webp'];
$allowedMime = ['image/jpeg','image/png','image/gif','image/webp'];
$maxSize = 5 * 1024 * 1024; // 5 Mo

/* ===== AJOUT / MODIFICATION ===== */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $id = !empty($_POST['id_destination']) ? (int)$_POST['id_destination'] : null;

    $nom = trim($_POST['nom'] ?? '');
    $ville = trim($_POST['ville'] ?? ''); // ✅ AJOUT
    $id_continent = isset($_POST['id_continent']) && $_POST['id_continent'] !== '' ? (int)$_POST['id_continent'] : null;

    $description = trim($_POST['description'] ?? '');
    $imageName = $_POST['existing_image'] ?? null;

    if ($nom === '') $errors[] = "Le nom est obligatoire.";
    if ($ville === '') $errors[] = "La ville est obligatoire."; // ✅ AJOUT
    if ($id_continent === null) $errors[] = "Le continent est obligatoire.";

    // Upload nouvelle image si présente
    if (!empty($_FILES['image']['name']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {

        if (!empty($_FILES['image']['size']) && $_FILES['image']['size'] > $maxSize) {
            $errors[] = "Image trop volumineuse (max 5 Mo).";
        } else {
            $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));

            if (!in_array($ext, $allowedExt, true)) {
                $errors[] = "Format image invalide.";
            } else {
                // Vérification MIME réelle
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $mime = finfo_file($finfo, $_FILES['image']['tmp_name']);
                finfo_close($finfo);

                if (!in_array($mime, $allowedMime, true)) {
                    $errors[] = "Type de fichier non autorisé.";
                } else {
                    $imageName = uniqid('dest_') . '.' . $ext;

                    if (!move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $imageName)) {
                        $errors[] = "Erreur lors de l'upload de l'image.";
                    } else {
                        // Supprime ancienne image si elle existe
                        if (!empty($_POST['existing_image'])) {
                            $old = basename((string)$_POST['existing_image']);
                            $oldPath = $uploadDir . $old;
                            if (is_file($oldPath)) {
                                @unlink($oldPath);
                            }
                        }
                    }
                }
            }
        }
    }

    if (empty($errors)) {
        $data = [
            'nom' => $nom,
            'ville' => $ville,              // ✅ AJOUT
            'id_continent' => $id_continent,
            'description' => $description,
            'image' => $imageName
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

/* ===== SUPPRESSION ===== */
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $dest = $unControleur->getDestinationById($id);

    if ($dest && !empty($dest['image'])) {
        $img = basename((string)$dest['image']);
        $imgPath = $uploadDir . $img;
        if (is_file($imgPath)) {
            @unlink($imgPath);
        }
    }

    $unControleur->deleteDestination($id);
    header('Location: index.php?page=admin_destinations');
    exit();
}

/* ===== RÉCUPÉRATION ===== */
$destinations = $unControleur->getAllDestinations();
$destinationToEdit = isset($_GET['edit']) ? $unControleur->getDestinationById((int)$_GET['edit']) : null;

// Liste des continents pour le dropdown
$continents = $unControleur->getAllContinents();

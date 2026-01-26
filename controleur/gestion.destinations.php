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

/* ===== AJOUT / MODIFICATION ===== */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $id = !empty($_POST['id_destination']) ? (int)$_POST['id_destination'] : null;
    $nom = trim($_POST['nom'] ?? '');
    $continent = trim($_POST['continent'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $imageName = $_POST['existing_image'] ?? null;

    if ($nom === '') $errors[] = "Le nom est obligatoire.";
    if ($continent === '') $errors[] = "Le continent est obligatoire.";

    // Upload nouvelle image si présente
    if (!empty($_FILES['image']['name']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $allowedExt = ['jpg','jpeg','png','gif','webp'];
        $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));

        if (!in_array($ext, $allowedExt)) {
            $errors[] = "Format image invalide.";
        } else {
            $imageName = uniqid('dest_') . '.' . $ext;
            move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $imageName);

            // Supprime ancienne image si elle existe
            if (!empty($_POST['existing_image'])) {
                @unlink($uploadDir . $_POST['existing_image']);
            }
        }
    }

    if (empty($errors)) {
        $data = compact('nom','continent','description','imageName');
        $data['image'] = $imageName;

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
        @unlink($uploadDir . $dest['image']);
    }

    $unControleur->deleteDestination($id);
    header('Location: index.php?page=admin_destinations');
    exit();
}

/* ===== RÉCUPÉRATION ===== */
$destinations = $unControleur->getAllDestinations();
$destinationToEdit = isset($_GET['edit']) ? $unControleur->getDestinationById((int)$_GET['edit']) : null;

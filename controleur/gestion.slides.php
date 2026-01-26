<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/controleur.class.php';

$unControleur = new Controleur();

// Sécurité admin
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: index.php?page=home');
    exit();
}

$uploadDir = __DIR__ . '/../images/slides/';
$errors = [];

/* ===== AJOUT / MODIFICATION ===== */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_slide'])) {

    $id_slide = !empty($_POST['id_slide']) ? intval($_POST['id_slide']) : null;
    $titre = trim($_POST['titre'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $lien = trim($_POST['lien'] ?? '');
    $ordre = intval($_POST['ordre'] ?? 1);
    $actif = isset($_POST['actif']) ? 1 : 0;
    $imageName = $_POST['existing_image'] ?? null;

    if ($titre === '') $errors[] = "Le titre est obligatoire.";
    if (!$id_slide && empty($_FILES['image']['name'])) {
        $errors[] = "Image obligatoire pour une nouvelle slide.";
    }

    if (!empty($_FILES['image']['name']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $allowedExt = ['jpg','jpeg','png','gif','webp'];
        $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));

        if (!in_array($ext, $allowedExt)) {
            $errors[] = "Format image invalide.";
        } else {
            $imageName = uniqid('slide_') . '.' . $ext;
            move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $imageName);

            if (!empty($_POST['existing_image'])) {
                @unlink($uploadDir . $_POST['existing_image']);
            }
        }
    }

    if (empty($errors)) {
        $data = compact('titre','description','imageName','lien','ordre','actif');
        $data['image'] = $imageName;

        if ($id_slide) {
            $data['id_slide'] = $id_slide;
            $unControleur->updateSlide($data);
        } else {
            $unControleur->addSlide($data);
        }

        header('Location: index.php?page=admin_slides&success=1');
        exit();
    }
}

/* ===== SUPPRESSION ===== */
if (isset($_GET['delete'])) {
    $id_slide = intval($_GET['delete']);
    $slide = $unControleur->getSlideById($id_slide);

    if ($slide) {
        @unlink($uploadDir . $slide['image']);
        $unControleur->deleteSlide($id_slide);
    }

    header('Location: index.php?page=admin_slides&deleted=1');
    exit();
}

/* ===== RÉCUPÉRATION ===== */
$slides = $unControleur->getAllSlides();
$slideToEdit = isset($_GET['edit']) ? $unControleur->getSlideById((int)$_GET['edit']) : null;

<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/controleur_class.php';

$unControleur = new Controleur();
$unControleur->verifAdmin();

$uploadDir = __DIR__ . '/../images/slides/';
$errors = [];

/* extensions autorisees */
$allowedExt = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

/* ajout / modification */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_slide'])) {

    $id_slide   = !empty($_POST['id_slide']) ? (int) $_POST['id_slide'] : null;
    $titre      = trim($_POST['titre'] ?? '');
    $sous_titre = trim($_POST['sous_titre'] ?? '');
    $ordre      = (int) ($_POST['ordre'] ?? 1);
    $actif      = isset($_POST['actif']) ? 1 : 0;

    // image existante (update)
    $imageName  = $_POST['existing_image_url'] ?? null;

    /* validations */
    if ($titre === '') {
        $errors[] = "Le titre est obligatoire.";
    }

    if (!$id_slide && empty($_FILES['image']['name'])) {
        $errors[] = "Image obligatoire pour une nouvelle slide.";
    }

    /* upload image */
    if (!empty($_FILES['image']['name']) && ($_FILES['image']['error'] ?? null) === UPLOAD_ERR_OK) {

        $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, $allowedExt, true)) {
            $errors[] = "Format image invalide.";
        } else {

            $imageName = uniqid('slide_') . '.' . $ext;

            if (!move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $imageName)) {
                $errors[] = "Erreur lors de l'upload de l'image.";
            } else {

                /* suppression ancienne image */
                if (!empty($_POST['existing_image_url'])) {
                    $old = basename((string) $_POST['existing_image_url']);
                    $oldPath = $uploadDir . $old;

                    if (is_file($oldPath)) {
                        @unlink($oldPath);
                    }
                }
            }
        }
    }

    /* enregistrement */
    if (empty($errors)) {

        $data = [
            'titre'      => $titre,
            'sous_titre' => ($sous_titre === '') ? null : $sous_titre,
            'image_url'  => $imageName,
            'ordre'      => $ordre,
            'actif'      => $actif
        ];

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

/* suppression */
if (isset($_GET['delete'])) {

    $id_slide = (int) $_GET['delete'];
    $slide = $unControleur->getSlideById($id_slide);

    if ($slide) {

        if (!empty($slide['image_url'])) {
            $img = basename((string) $slide['image_url']);
            $imgPath = $uploadDir . $img;

            if (is_file($imgPath)) {
                @unlink($imgPath);
            }
        }

        $unControleur->deleteSlide($id_slide);
    }

    header('Location: index.php?page=admin_slides&deleted=1');
    exit();
}

/* liste slides + slide edit */
$slides = $unControleur->getAllSlides();

$slideToEdit = isset($_GET['edit'])
    ? $unControleur->getSlideById((int) $_GET['edit'])
    : null;

<?php

/* session */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/* dependances */
require_once __DIR__ . '/controleur.class.php';

/* initialisation controleur */
$unControleur = new Controleur();

/* ============================= */
/* securite admin */
/* ============================= */

if (!isset($_SESSION['user']) || ($_SESSION['user']['role'] ?? '') !== 'admin') {
    header('Location: index.php?page=home');
    exit();
}

/* ============================= */
/* configuration upload */
/* ============================= */

$uploadDir = __DIR__ . '/../images/slides/';
$errors = [];

/* extensions autorisees */
$allowedExt = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

/* ============================= */
/* ajout / modification */
/* ============================= */

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_slide'])) {

    /* recuperation champs */
    $id_slide     = !empty($_POST['id_slide']) ? (int) $_POST['id_slide'] : null;
    $titre        = trim($_POST['titre'] ?? '');
    $description  = trim($_POST['description'] ?? '');
    $lien         = trim($_POST['lien'] ?? '');
    $ordre        = (int) ($_POST['ordre'] ?? 1);
    $actif        = isset($_POST['actif']) ? 1 : 0;
    $imageName    = $_POST['existing_image'] ?? null;

    /* validations */
    if ($titre === '') {
        $errors[] = "Le titre est obligatoire.";
    }

    if (!$id_slide && empty($_FILES['image']['name'])) {
        $errors[] = "Image obligatoire pour une nouvelle slide.";
    }

    /* upload image */
    if (!empty($_FILES['image']['name']) && ($_FILES['image']['error'] ?? null) === UPLOAD_ERR_OK) {

        /* verification extension */
        $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, $allowedExt, true)) {
            $errors[] = "Format image invalide.";
        } else {

            /* generation nom image */
            $imageName = uniqid('slide_') . '.' . $ext;

            /* deplacement fichier */
            if (!move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $imageName)) {
                $errors[] = "Erreur lors de l'upload de l'image.";
            } else {

                /* suppression ancienne image */
                if (!empty($_POST['existing_image'])) {
                    $old = basename((string) $_POST['existing_image']);
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

        /* preparation donnees */
        $data = [
            'titre'       => $titre,
            'description' => $description,
            'image'       => $imageName,
            'lien'        => $lien,
            'ordre'       => $ordre,
            'actif'       => $actif
        ];

        /* update ou insert */
        if ($id_slide) {
            $data['id_slide'] = $id_slide;
            $unControleur->updateSlide($data);
        } else {
            $unControleur->addSlide($data);
        }

        /* redirection */
        header('Location: index.php?page=admin_slides&success=1');
        exit();
    }
}

/* ============================= */
/* suppression */
/* ============================= */

if (isset($_GET['delete'])) {

    /* recuperation slide */
    $id_slide = (int) $_GET['delete'];
    $slide = $unControleur->getSlideById($id_slide);

    if ($slide) {

        /* suppression image */
        if (!empty($slide['image'])) {
            $img = basename((string) $slide['image']);
            $imgPath = $uploadDir . $img;

            if (is_file($imgPath)) {
                @unlink($imgPath);
            }
        }

        /* suppression en base */
        $unControleur->deleteSlide($id_slide);
    }

    /* redirection */
    header('Location: index.php?page=admin_slides&deleted=1');
    exit();
}

/* ============================= */
/* recuperation donnees */
/* ============================= */

/* liste slides */
$slides = $unControleur->getAllSlides();

/* slide a modifier */
$slideToEdit = isset($_GET['edit'])
    ? $unControleur->getSlideById((int) $_GET['edit'])
    : null;

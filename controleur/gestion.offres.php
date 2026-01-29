<?php

/* session */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/* dependances */
require_once __DIR__ . '/controleur.class.php';

/* initialisation controleur */
$unControleur = new Controleur();

/* securite admin */
$unControleur->verifAdmin();

/* erreurs */
$errors = [];

/* ============================= */
/* ajout / modification */
/* ============================= */

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {

    /* recuperation champs */
    $id_offre = !empty($_POST['id_offre']) ? (int) $_POST['id_offre'] : null;

    $titre       = trim($_POST['titre'] ?? '');
    $reduction   = isset($_POST['reduction']) ? (int) $_POST['reduction'] : 0;
    $date_debut  = $_POST['date_debut'] ?? '';
    $date_fin    = $_POST['date_fin'] ?? '';
    $actif       = isset($_POST['actif']) ? 1 : 0;
    $id_voyage   = isset($_POST['id_voyage']) ? (int) $_POST['id_voyage'] : 0;

    /* validations */
    if ($titre === '') {
        $errors[] = "Le titre est obligatoire.";
    }

    if ($id_voyage <= 0) {
        $errors[] = "Le voyage est obligatoire.";
    }

    if ($date_debut === '' || $date_fin === '') {
        $errors[] = "Les dates sont obligatoires.";
    }

    if ($reduction < 0 || $reduction > 100) {
        $errors[] = "Réduction doit être entre 0 et 100.";
    }

    /* enregistrement */
    if (empty($errors)) {

        /* preparation donnees */
        $data = compact(
            'titre',
            'reduction',
            'date_debut',
            'date_fin',
            'actif',
            'id_voyage'
        );

        /* update ou insert */
        if ($id_offre) {
            $data['id_offre'] = $id_offre;
            $unControleur->updateOffre($data);
        } else {
            $unControleur->addOffre($data);
        }

        /* redirection */
        header('Location: index.php?page=admin_offres');
        exit();
    }
}

/* ============================= */
/* suppression */
/* ============================= */

if (isset($_GET['delete'])) {

    $unControleur->deleteOffre((int) $_GET['delete']);

    /* redirection */
    header('Location: index.php?page=admin_offres');
    exit();
}

/* ============================= */
/* recuperation donnees */
/* ============================= */

/* liste offres */
$offres = $unControleur->getAllOffres();

/* offre a modifier */
$offreToEdit = isset($_GET['edit'])
    ? $unControleur->getOffreById((int) $_GET['edit'])
    : null;

/* liste voyages */
$voyages = method_exists($unControleur, 'getAllVoyages')
    ? $unControleur->getAllVoyages()
    : [];

<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/controleur_class.php';

$unControleur = new Controleur();
$unControleur->verifAdmin();

$errors = [];

/* ajout / modification */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {

    $id_offre = !empty($_POST['id_offre']) ? (int) $_POST['id_offre'] : null;

    $titre      = trim($_POST['titre'] ?? '');
    $pourcentage_reduction = isset($_POST['pourcentage_reduction']) ? (int) $_POST['pourcentage_reduction'] : 0;

    $date_debut = $_POST['date_debut'] ?? '';
    $date_fin   = $_POST['date_fin'] ?? '';

    $actif      = isset($_POST['actif']) ? 1 : 0;

    // ✅ nouvelle BDD : destination
    $id_destination = isset($_POST['id_destination']) ? (int) $_POST['id_destination'] : 0;

    /* validations */
    if ($titre === '') {
        $errors[] = "Le titre est obligatoire.";
    }

    if ($id_destination <= 0) {
        $errors[] = "La destination est obligatoire.";
    }

    if ($date_debut === '' || $date_fin === '') {
        $errors[] = "Les dates sont obligatoires.";
    }

    if ($pourcentage_reduction < 1 || $pourcentage_reduction > 100) {
        $errors[] = "La réduction doit être entre 1 et 100.";
    }

    /* enregistrement */
    if (empty($errors)) {

        $data = [
            'titre' => $titre,
            'pourcentage_reduction' => $pourcentage_reduction,
            'date_debut' => $date_debut,
            'date_fin' => $date_fin,
            'actif' => $actif,
            'id_destination' => $id_destination
        ];

        if ($id_offre) {
            $data['id_offre'] = $id_offre;
            $unControleur->updateOffre($data);
        } else {
            $unControleur->addOffre($data);
        }

        header('Location: index.php?page=admin_offres');
        exit();
    }
}

/* suppression */
if (isset($_GET['delete'])) {
    $unControleur->deleteOffre((int) $_GET['delete']);
    header('Location: index.php?page=admin_offres');
    exit();
}

/* recuperation donnees */
$offres = $unControleur->getAllOffres();

$offreToEdit = isset($_GET['edit'])
    ? $unControleur->getOffreById((int) $_GET['edit'])
    : null;

/* liste destinations (au lieu des voyages) */
$destinations = $unControleur->getAllDestinations();

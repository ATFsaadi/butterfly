<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/controleur.class.php';

$unControleur = new Controleur();

/* sécurité */
if (!isset($_SESSION['user']['idutil'])) {
    header("Location: index.php?page=home");
    exit;
}

$errors = [];
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$reservation = ($id > 0) ? $unControleur->getReservationById($id) : null;

if (!$reservation) {
    $errors[] = "Réservation introuvable.";
} else {
    // sécurité : empêcher un autre user de voir la réservation
    if ((int)$reservation['id_utilisateur'] !== (int)$_SESSION['user']['idutil']
        && ($_SESSION['user']['role'] ?? '') !== 'admin') {
        header("Location: index.php?page=home");
        exit;
    }

    $voyage = $unControleur->getVoyageById((int)$reservation['id_voyage']);
}

<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/controleur.class.php';

$unControleur = new Controleur();

if (!isset($_SESSION['user']['idutil'])) {
    header('Location: index.php?page=home');
    exit();
}

$errors = [];
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

/* recuperation reservation */

$reservation = ($id > 0) ? $unControleur->getReservationById($id) : null;

if (!$reservation) {

    /* reservation introuvable */
    $errors[] = "Réservation introuvable.";

} else {

    /* securite acces reservation */
    $isOwner = (int) $reservation['id_utilisateur'] === (int) $_SESSION['user']['idutil'];
    $isAdmin = ($_SESSION['user']['role'] ?? '') === 'admin';

    if (!$isOwner && !$isAdmin) {
        header('Location: index.php?page=home');
        exit();
    }

    /* recuperation voyage */
    $voyage = $unControleur->getVoyageById((int) $reservation['id_voyage']);
}

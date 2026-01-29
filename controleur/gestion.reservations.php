<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/controleur.class.php';

$unControleur = new Controleur();

/* =========================
   PARTIE ADMIN
========================= */
if (($_GET['page'] ?? '') === 'admin_reservations') {

    $unControleur->verifAdmin();

    /* confirmation */
    if (isset($_GET['confirm'])) {
        $unControleur->confirmReservation((int)$_GET['confirm']);
        header("Location: index.php?page=admin_reservations");
        exit;
    }

    $reservations = $unControleur->getAllReservations();
    return; // IMPORTANT : on sort ici (pas de code client)
}

/* =========================
   PARTIE CLIENT
========================= */

/* sécurité client */
if (!isset($_SESSION['user']['idutil'])) {
    header("Location: index.php?page=home");
    exit;
}

$errors  = [];
$success = "";

/* URL : index.php?page=reservation&id=ID_VOYAGE */
$id_voyage = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$voyage = ($id_voyage > 0) ? $unControleur->getVoyageById($id_voyage) : null;

if (!$voyage) {
    $errors[] = "Voyage introuvable.";
}

/* Offre */
$id_offre = 0;
if (isset($_POST['offre']))      $id_offre = (int)$_POST['offre'];
elseif (isset($_GET['offre']))   $id_offre = (int)$_GET['offre'];

$offre = ($id_offre > 0) ? $unControleur->getOffreById($id_offre) : null;

/* traitement */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_reservation']) && $voyage) {

    $adultes = max(1, (int)($_POST['adultes'] ?? 1));
    $enfants = max(0, (int)($_POST['enfants'] ?? 0));
    $bebes   = max(0, (int)($_POST['bebes']   ?? 0));

    $coef = 1;
    if ($offre && isset($offre['reduction'])) {
        $coef = (100 - (int)$offre['reduction']) / 100;
    }

    $prix_total =
        ($adultes * $voyage['prix_adulte'] * $coef) +
        ($enfants * $voyage['prix_enfant'] * $coef) +
        ($bebes   * $voyage['prix_bebe']   * $coef);

    $id_reservation = $unControleur->addReservation([
        'id_utilisateur'  => (int)$_SESSION['user']['idutil'],
        'id_voyage'       => (int)$voyage['id_voyage'],
        'date_depart'     => $voyage['date_depart'],
        'date_retour'     => $voyage['date_retour'],
        'nombre_adultes'  => $adultes,
        'nombre_enfants'  => $enfants,
        'nombre_bebes'    => $bebes,
        'prix_total'      => round($prix_total, 2),
        'statut'           => 'en attente'
    ]);

    if ($id_reservation) {
        header("Location: index.php?page=reservation_recap&id=".$id_reservation);
        exit;
    }

    $errors[] = "Erreur lors de la réservation.";
}

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
/* partie admin */
/* ============================= */

if (($_GET['page'] ?? '') === 'admin_reservations') {

    /* securite admin */
    $unControleur->verifAdmin();

    /* confirmer reservation */
    if (isset($_GET['confirm'])) {

        $id = (int) $_GET['confirm'];
        if ($id > 0) {
            $unControleur->confirmReservation($id);
        }

        /* redirection */
        header('Location: index.php?page=admin_reservations');
        exit();
    }

    /* marquer reservation payee */
    if (isset($_GET['pay'])) {

        $id = (int) $_GET['pay'];
        if ($id > 0) {
            $unControleur->markReservationPaid($id);
        }

        /* redirection */
        header('Location: index.php?page=admin_reservations');
        exit();
    }

    /* liste reservations */
    $reservations = $unControleur->getAllReservations();
    return;
}

/* ============================= */
/* partie client */
/* ============================= */

/* securite client */
if (!isset($_SESSION['user']['idutil'])) {
    header('Location: index.php?page=home');
    exit();
}

/* variables */
$errors  = [];
$success = "";

/* ============================= */
/* recuperation voyage */
/* ============================= */

/* url : index.php?page=reservation&id=id_voyage */
$id_voyage = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$voyage = ($id_voyage > 0) ? $unControleur->getVoyageById($id_voyage) : null;

if (!$voyage) {
    $errors[] = "Voyage introuvable.";
}

/* ============================= */
/* recuperation offre */
/* ============================= */

$id_offre = 0;

if (isset($_POST['offre'])) {
    $id_offre = (int) $_POST['offre'];
} elseif (isset($_GET['offre'])) {
    $id_offre = (int) $_GET['offre'];
}

$offre = ($id_offre > 0) ? $unControleur->getOffreById($id_offre) : null;

/* ============================= */
/* traitement reservation */
/* ============================= */

if (
    $_SERVER['REQUEST_METHOD'] === 'POST'
    && isset($_POST['submit_reservation'])
    && $voyage
) {

    /* recuperation quantites */
    $adultes = max(1, (int) ($_POST['adultes'] ?? 1));
    $enfants = max(0, (int) ($_POST['enfants'] ?? 0));
    $bebes   = max(0, (int) ($_POST['bebes'] ?? 0));

    /* calcul coefficient reduction */
    $coef = 1;
    if ($offre && isset($offre['reduction'])) {
        $coef = (100 - (int) $offre['reduction']) / 100;
    }

    /* calcul prix total */
    $prix_total =
        ($adultes * $voyage['prix_adulte'] * $coef) +
        ($enfants * $voyage['prix_enfant'] * $coef) +
        ($bebes   * $voyage['prix_bebe']   * $coef);

    /* insertion reservation */
    $id_reservation = $unControleur->addReservation([
        'id_utilisateur'  => (int) $_SESSION['user']['idutil'],
        'id_voyage'       => (int) $voyage['id_voyage'],
        'date_depart'     => $voyage['date_depart'],
        'date_retour'     => $voyage['date_retour'],
        'nombre_adultes'  => $adultes,
        'nombre_enfants'  => $enfants,
        'nombre_bebes'    => $bebes,
        'prix_total'      => round($prix_total, 2),
        'statut'          => 'en attente'
    ]);

    /* redirection recap */
    if ($id_reservation) {
        header('Location: index.php?page=reservation_recap&id=' . $id_reservation);
        exit();
    }

    /* erreur reservation */
    $errors[] = "Erreur lors de la réservation.";
}

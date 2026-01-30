<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/controleur_class.php';

$unControleur = new Controleur();

/* =========================
   PARTIE ADMIN
   ========================= */
if (($_GET['page'] ?? '') === 'admin_reservations') {

    $unControleur->verifAdmin();

    // Confirmer
    if (isset($_GET['confirm'])) {
        $id = (int) $_GET['confirm'];
        if ($id > 0) {
            $unControleur->updateReservationStatut($id, 'confirmee');
        }
        header('Location: index.php?page=admin_reservations');
        exit();
    }

    // Annuler
    if (isset($_GET['cancel'])) {
        $id = (int) $_GET['cancel'];
        if ($id > 0) {
            $unControleur->updateReservationStatut($id, 'annulee');
        }
        header('Location: index.php?page=admin_reservations');
        exit();
    }

    // Liste
    $reservations = $unControleur->getAllReservations();
    return; // ton layout affichera vue/admin_reservations.php
}

/* =========================
   PARTIE CLIENT
   ========================= */

$unControleur->verifConnexion();

// On a besoin du profil client en session
if (!isset($_SESSION['client']['id_client'])) {
    header('Location: index.php?page=home');
    exit();
}

$errors  = [];
$success = "";

/* destination */
$id_destination = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$destination = ($id_destination > 0) ? $unControleur->getDestinationById($id_destination) : null;

if (!$destination) {
    $errors[] = "Destination introuvable.";
}

/* offre active automatique */
$offre = null;
$reduc = 0;
$prix_unitaire = 0;

if ($destination) {
    $offre = $unControleur->getOffreActiveByDestination($id_destination);
    $prix_unitaire = (float) $unControleur->getPrixDestinationAvecOffre($id_destination);

    if ($offre) {
        $reduc = (int) ($offre['pourcentage_reduction'] ?? 0);
    }
}

/* traitement reservation */
if (
    $_SERVER['REQUEST_METHOD'] === 'POST'
    && isset($_POST['submit_reservation'])
    && $destination
) {
    $date_depart = $_POST['date_depart'] ?? '';
    $date_retour = $_POST['date_retour'] ?? '';
    $nb_personnes = max(1, (int) ($_POST['nb_personnes'] ?? 1));

    if ($date_depart === '' || $date_retour === '') {
        $errors[] = "Les dates sont obligatoires.";
    }

    if (empty($errors)) {

        $prix_total = round($nb_personnes * $prix_unitaire, 2);

        $id_reservation = $unControleur->addReservation([
            'id_client'      => (int) $_SESSION['client']['id_client'],
            'id_destination' => (int) $destination['id_destination'],
            'date_depart'    => $date_depart,
            'date_retour'    => $date_retour,
            'nb_personnes'   => $nb_personnes,
            'prix_total'     => $prix_total,
            'statut'         => 'en_attente'
        ]);

        if ($id_reservation) {
            // tu peux rediriger vers recap si tu la gardes
            header('Location: index.php?page=dashboard_client');
            exit();
        }

        $errors[] = "Erreur lors de la réservation.";
    }
}

<?php

// Controleur detail client admin : affiche le profil et ses reservations.

// sécurité admin

$unControleur->verifAdmin();

// récupération de l'id client

$idUtilisateur = (int) ($_GET["id_utilisateur"] ?? 0);

if ($idUtilisateur <= 0) {
    header("Location: index.php?page=admin_clients");
    exit();
}

// récupération des informations du client

$client = $unControleur->selectWhere_client_admin($idUtilisateur);

if (!$client) {
    header("Location: index.php?page=admin_clients");
    exit();
}

// récupération des réservations du client

$reservationsDestinations = $unControleur->selectReservationsDestinationsByUtilisateur($idUtilisateur);
$reservationsVoyages = $unControleur->selectReservationsVoyagesByUtilisateur($idUtilisateur);

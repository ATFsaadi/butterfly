<?php

$unControleur->verifAdmin();

$idUtilisateur = (int)($_GET["id_utilisateur"] ?? 0);

if ($idUtilisateur <= 0) {
    header("Location: index.php?page=admin_clients");
    exit();
}

$client = $unControleur->selectWhere_client_admin($idUtilisateur);

if (!$client) {
    header("Location: index.php?page=admin_clients");
    exit();
}

$reservationsDestinations = $unControleur->selectReservationsDestinationsByUtilisateur($idUtilisateur);
$reservationsVoyages = $unControleur->selectReservationsVoyagesByUtilisateur($idUtilisateur);
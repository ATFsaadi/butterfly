<?php

$unControleur->verifConnexion();

$erreur = "";

// recuperer le client

$idUser = (int) ($_SESSION["user"]["id_utilisateur"] ?? 0);
$client = $unControleur->selectWhere_client_by_user($idUser);

$id_client = (int) ($client["id_client"] ?? 0);

if ($id_client <= 0) {
    header("location: index.php?page=home");
    exit();
}

// recuperer les reservations du client

$lesReservations = $unControleur->selectWhere_reservations_by_client($id_client);

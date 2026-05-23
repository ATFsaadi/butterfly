<?php

// sécurité client

$unControleur->verifConnexion();

// récupération du client connecté

$idClient = $unControleur->getIdClientConnecte();

// récupération des réservations du client

$lesReservationsDestinations = $unControleur->selectWhere_reservations_destinations_by_client($idClient) ?? [];
$lesReservationsVoyages = $unControleur->selectWhere_reservations_voyages_by_client($idClient) ?? [];
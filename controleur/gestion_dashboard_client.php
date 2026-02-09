<?php

$unControleur->verifConnexion();

$idClient = $unControleur->getIdClientConnecte();

$lesReservationsDestinations = $unControleur->selectWhere_reservations_destinations_by_client($idClient) ?? [];
$lesReservationsVoyages = $unControleur->selectWhere_reservations_voyages_by_client($idClient) ?? [];

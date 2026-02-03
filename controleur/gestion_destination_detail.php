<?php

// recuperation de l'id destination

$id_destination = (int) ($_GET["id_destination"] ?? 0);

$destination = null;
$offreActive = null;

// chargement des donnees

if ($id_destination > 0) {
    $destination = $unControleur->selectWhere_destination($id_destination);
    $offreActive = $unControleur->selectWhere_offre_active_by_destination($id_destination);
}

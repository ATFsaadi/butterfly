<?php

// Controleur detail voyage : charge le voyage demande.

// récupération du voyage

$idVoyage = (int) ($_GET["id_voyage"] ?? 0);

$voyage = null;

// chargement du voyage

if ($idVoyage > 0) {
    $voyage = $unControleur->selectWhere_voyage_actif($idVoyage);
}

// redirection si voyage introuvable ou desactive

if (!$voyage) {
    header("location: index.php?page=destinations");
    exit();
}

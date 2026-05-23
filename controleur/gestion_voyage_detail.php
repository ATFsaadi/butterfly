<?php

// récupération du voyage

$idVoyage = (int) ($_GET["id_voyage"] ?? 0);

$voyage = null;

// chargement du voyage

if ($idVoyage > 0) {
    $voyage = $unControleur->selectWhere_voyage($idVoyage);
}

// redirection si voyage introuvable

if (!$voyage) {
    header("location: index.php?page=destinations");
    exit();
}
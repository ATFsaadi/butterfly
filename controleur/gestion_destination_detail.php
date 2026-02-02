<?php
$id_destination = (int)($_GET['id_destination'] ?? 0);

$destination = null;
$offreActive = null;

if ($id_destination > 0) {
    $destination = $unControleur->selectWhere_destination($id_destination);
    $offreActive = $unControleur->selectWhere_offre_active_by_destination($id_destination);
}

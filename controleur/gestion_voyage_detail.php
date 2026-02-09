<?php

$id_voyage = (int)($_GET["id_voyage"] ?? 0);

$voyage = null;

if ($id_voyage > 0) {
    $voyage = $unControleur->selectWhere_voyage($id_voyage);
}

if (!$voyage) {
    header("location: index.php?page=destinations");
    exit();
}

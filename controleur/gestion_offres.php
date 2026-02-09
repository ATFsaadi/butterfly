<?php

$q = trim((string)($_GET["q"] ?? ""));

if ($q !== "" && mb_strlen($q) >= 2) {
    $offres = $unControleur->selectLike_offres_actives($q);
} else {
    $offres = $unControleur->selectAll_offres_actives();
}

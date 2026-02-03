<?php
$q = trim((string)($_GET["q"] ?? ""));

if ($q !== "") {
    $offres = $unControleur->selectLike_offres_actives($q);
} else {
    $offres = $unControleur->selectAll_offres_actives();
}

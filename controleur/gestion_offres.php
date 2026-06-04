<?php

// Controleur offres : charge les offres actives avec recherche.

// récupération de la recherche

$recherche = trim((string) ($_GET["q"] ?? ""));

// récupération des offres

if ($recherche !== "" && mb_strlen($recherche) >= 2) {
    $offres = $unControleur->selectLike_offres_actives($recherche);
} else {
    $offres = $unControleur->selectAll_offres_actives();
}

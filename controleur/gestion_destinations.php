<?php

// récupération de la recherche

$recherche = trim((string) ($_GET["q"] ?? ""));

// récupération des destinations

if ($recherche !== "" && mb_strlen($recherche) >= 2) {
    $destinations = $unControleur->selectLike_destination($recherche);
} else {
    $destinations = $unControleur->selectAll_destinations();
}
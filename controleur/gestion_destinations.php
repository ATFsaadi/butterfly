<?php

// champs venant du formulaire ui

$ville_depart = trim($_GET["ville_depart"] ?? "");
$date_depart = trim($_GET["date_depart"] ?? "");
$date_retour = trim($_GET["date_retour"] ?? "");

// champ recherche destination

$q = trim($_GET["q"] ?? "");

// filtrage destinations

if ($q !== "") {
    $destinations = $unControleur->selectLike_destination($q);
} else {
    $destinations = $unControleur->selectAll_destinations();
}

// liste villes de depart pour l'ui

$villesDepart = [
    "Tout endroit",
    "Paris",
    "Lyon",
    "Marseille",
];

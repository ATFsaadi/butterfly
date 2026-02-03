<?php
// controleur/gestion_destinations.php

// Champs venant du formulaire UI
$ville_depart = trim($_GET["ville_depart"] ?? "");   // UI uniquement
$date_depart  = trim($_GET["date_depart"] ?? "");
$date_retour  = trim($_GET["date_retour"] ?? "");

// Champ recherche destination (filtre SQL)
$q = trim($_GET["q"] ?? "");

// Filtrage LIKE %q% sur pays/ville/continent
if ($q !== "") {
    $destinations = $unControleur->selectLike_destination($q);
} else {
    $destinations = $unControleur->selectAll_destinations();
}

// Liste villes départ (UI)
$villesDepart = ["Tout endroit", "Paris", "Lyon", "Marseille"];

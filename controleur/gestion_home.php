<?php

// Controleur accueil : charge les elements affiches sur la page d'accueil.

// récupération des données d'accueil

$voyages = $unControleur->selectAll_voyages_actifs();
$offres = $unControleur->selectAll_offres_actives();
$destinations = $unControleur->selectAll_destinations();

// variables de recherche

$villesDepart = [];

// message après inscription

$successRegister = "";
$openLoginAfterRegister = false;

if (isset($_GET["register"]) && $_GET["register"] === "ok") {
    $successRegister = "inscription réussie ! vous pouvez vous connecter.";
    $openLoginAfterRegister = true;
}

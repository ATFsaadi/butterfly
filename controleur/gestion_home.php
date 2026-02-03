<?php

// donnees pour la page d'accueil

$slides = $unControleur->selectAll_slides_actifs();
$offres = $unControleur->selectAll_offres_actives();
$destinations = $unControleur->selectAll_destinations();
$villesDepart = [];

// message apres inscription

$successRegister = "";
$openLoginAfterRegister = false;

if (isset($_GET["register"]) && $_GET["register"] === "ok") {
    $successRegister = "inscription réussie ! vous pouvez vous connecter.";
    $openLoginAfterRegister = true;
}

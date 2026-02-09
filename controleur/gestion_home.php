<?php

$voyages = $unControleur->selectAll_voyages_actifs();
$offres = $unControleur->selectAll_offres_actives();
$destinations = $unControleur->selectAll_destinations();
$villesDepart = [];

$successRegister = "";
$openLoginAfterRegister = false;

if (isset($_GET["register"]) && $_GET["register"] === "ok") {
    $successRegister = "inscription réussie ! vous pouvez vous connecter.";
    $openLoginAfterRegister = true;
}

<?php
// controleur/gestion_home.php

$slides       = $unControleur->selectAll_slides_actifs();
$offres       = $unControleur->selectAll_offres_actives();
$destinations = $unControleur->selectAll_destinations();
$villesDepart = [];

// Message après inscription (register ok)
$successRegister = "";
$openLoginAfterRegister = false;

if (isset($_GET["register"]) && $_GET["register"] === "ok") {
    $successRegister = "Inscription réussie ! Vous pouvez vous connecter.";
    $openLoginAfterRegister = true;
}

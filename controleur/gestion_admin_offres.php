<?php

$unControleur->verifAdmin();

$offre = null;

// actions get

if (isset($_GET["action"], $_GET["id_offre"])) {
    $action = $_GET["action"];
    $id_offre = (int) $_GET["id_offre"];

    if ($action === "sup") {
        $unControleur->delete_offre($id_offre);
        header("location: index.php?page=admin_offres");
        exit();
    }

    if ($action === "edit") {
        $offre = $unControleur->selectWhere_offre($id_offre);
    }
}

// donnees pour select

$destinations = $unControleur->selectAll_destinations();

// actions post

if (isset($_POST["Valider"])) {
    $unControleur->insert_offre($_POST);
    echo '<div style="text-align:center; color:green; font-weight:bold;">&#10004; offre ajoutée.</div>';
}

if (isset($_POST["Modifier"])) {
    $unControleur->update_offre($_POST);
    header("location: index.php?page=admin_offres");
    exit();
}

// liste et filtre

if (isset($_POST["Filtrer"])) {
    $filtre = $_POST["filtre"] ?? "";
    $lesOffres = $unControleur->selectLike_offre($filtre);
} else {
    $lesOffres = $unControleur->selectAll_offres();
}


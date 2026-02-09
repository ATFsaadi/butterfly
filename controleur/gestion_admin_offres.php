<?php

$unControleur->verifAdmin();

$offre = null;

if (isset($_GET["action"], $_GET["id_offre"])) {
    $action = $_GET["action"];
    $id_offre = (int)$_GET["id_offre"];

    if ($action === "sup") {
        $unControleur->delete_offre($id_offre);
        header("location: index.php?page=admin_offres");
        exit();
    }

    if ($action === "edit") {
        $offre = $unControleur->selectWhere_offre($id_offre);
    }
}

$destinations = $unControleur->selectAll_destinations_admin();

if (isset($_POST["Valider"])) {
    $tab = [
        "id_destination" => (int)($_POST["id_destination"] ?? 0),
        "titre" => trim((string)($_POST["titre"] ?? "")),
        "pourcentage_reduction" => (int)($_POST["pourcentage_reduction"] ?? 0),
        "date_debut" => $_POST["date_debut"] ?? "",
        "date_fin" => $_POST["date_fin"] ?? "",
    ];

    $unControleur->insert_offre($tab);
    header("location: index.php?page=admin_offres");
    exit();
}

if (isset($_POST["Modifier"])) {
    $tab = [
        "id_offre" => (int)($_POST["id_offre"] ?? 0),
        "id_destination" => (int)($_POST["id_destination"] ?? 0),
        "titre" => trim((string)($_POST["titre"] ?? "")),
        "pourcentage_reduction" => (int)($_POST["pourcentage_reduction"] ?? 0),
        "date_debut" => $_POST["date_debut"] ?? "",
        "date_fin" => $_POST["date_fin"] ?? "",
        "actif" => isset($_POST["actif"]) ? 1 : 0,
    ];

    $unControleur->update_offre($tab);
    header("location: index.php?page=admin_offres");
    exit();
}

if (isset($_POST["Filtrer"])) {
    $filtre = trim((string)($_POST["filtre"] ?? ""));
    $lesOffres = $filtre !== "" ? $unControleur->selectLike_offre($filtre) : $unControleur->selectAll_offres();
} else {
    $lesOffres = $unControleur->selectAll_offres();
}

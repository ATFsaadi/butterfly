<?php

$unControleur->verifAdmin();

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["changer_statut_client"])) {
    if (!hash_equals($_SESSION["csrf_token"], (string)($_POST["csrf_token"] ?? ""))) {
        die("csrf invalide");
    }

    $idUtilisateur = (int)($_POST["id_utilisateur"] ?? 0);
    $actif = (int)($_POST["actif"] ?? 0);

    if ($idUtilisateur > 0) {
        $unControleur->setUtilisateurActif($idUtilisateur, $actif);
    }

    header("Location: index.php?page=admin_clients");
    exit();
}

$filtre = trim((string)($_GET["filtre"] ?? ""));

if ($filtre !== "") {
    $clients = $unControleur->selectLike_clients_admin($filtre);
} else {
    $clients = $unControleur->selectAll_clients_admin();
}
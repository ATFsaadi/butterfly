<?php

// sécurité admin

$unControleur->verifAdmin();

// changement du statut client

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["changer_statut_client"])) {
    if (!hash_equals($_SESSION["csrf_token"], (string) ($_POST["csrf_token"] ?? ""))) {
        die("csrf invalide");
    }

    $idUtilisateur = (int) ($_POST["id_utilisateur"] ?? 0);
    $actif = (int) ($_POST["actif"] ?? 0);

    if ($idUtilisateur > 0) {
        $unControleur->setUtilisateurActif($idUtilisateur, $actif);
    }

    header("Location: index.php?page=admin_clients");
    exit();
}

// recherche des clients

$filtre = trim((string) ($_GET["filtre"] ?? ""));

// récupération des clients

if ($filtre !== "") {
    $clients = $unControleur->selectLike_clients_admin($filtre);
} else {
    $clients = $unControleur->selectAll_clients_admin();
}

// tri clients

$tri = (string) ($_GET["tri"] ?? "nom");
$ordre = (string) ($_GET["ordre"] ?? "asc");

$trisAutorises = ["nom", "prenom", "email", "telephone", "ville", "pays", "actif"];

if (!in_array($tri, $trisAutorises, true)) {
    $tri = "nom";
}

if ($ordre !== "desc") {
    $ordre = "asc";
}

usort($clients, function (array $a, array $b) use ($tri, $ordre): int {
    $valeurA = $a[$tri] ?? "";
    $valeurB = $b[$tri] ?? "";

    if ($tri === "actif") {
        $comparaison = (int) $valeurA <=> (int) $valeurB;
    } else {
        $comparaison = strcasecmp((string) $valeurA, (string) $valeurB);
    }

    return $ordre === "desc" ? -$comparaison : $comparaison;
});

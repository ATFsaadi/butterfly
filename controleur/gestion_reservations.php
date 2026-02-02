<?php
// controleur/gestion_reservations.php

$unControleur->verifConnexion();

$erreurReservation = "";
$successReservation = "";

/* =========================
   1) Recuperer l'utilisateur + client
========================= */
$idUser = (int)($_SESSION['user']['id_utilisateur'] ?? $_SESSION['user']['id'] ?? 0);

$client = null;
$id_client = 0;

if ($idUser > 0) {
    $client = $unControleur->selectWhere_client_by_user($idUser);
    $id_client = (int)($client['id_client'] ?? 0);
}

if ($id_client <= 0) {
    header("Location: index.php?page=home");
    exit();
}

/* =========================
   2) Recuperer la destination
========================= */
$id_destination = (int)($_GET["id_destination"] ?? 0);

$destination = null;
$offreActive = null;

if ($id_destination <= 0) {
    $erreurReservation = "Destination invalide.";
} else {
    $destination = $unControleur->selectWhere_destination($id_destination);
    if (!$destination) {
        $erreurReservation = "Destination introuvable.";
    } else {
        $offreActive = $unControleur->selectWhere_offre_active_by_destination($id_destination);
    }
}

/* =========================
   3) Pré-remplissage (GET)
========================= */
$date_depart = trim($_GET["date_depart"] ?? "");
$date_retour = trim($_GET["date_retour"] ?? "");

$adultes = (int)($_GET["adultes"] ?? 1);
$enfants = (int)($_GET["enfants"] ?? 0);
$bebes   = (int)($_GET["bebes"] ?? 0);

$nb_personnes = $adultes + $enfants + $bebes;
if ($nb_personnes < 1) $nb_personnes = 1;

/* =========================
   4) Validation + INSERT (POST)
========================= */
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["confirmer_reservation"])) {

    // si destination invalide, on n'insère pas
    if (!$destination) {
        $erreurReservation = "Impossible de réserver : destination invalide.";
    } else {

        $date_depart = trim($_POST["date_depart"] ?? "");
        $date_retour = trim($_POST["date_retour"] ?? "");
        $nb_personnes = (int)($_POST["nb_personnes"] ?? 1);

        if ($nb_personnes < 1) $nb_personnes = 1;

        if ($date_depart === "" || $date_retour === "") {
            $erreurReservation = "Veuillez renseigner la date de départ et la date de retour.";
        } elseif ($date_retour < $date_depart) {
            $erreurReservation = "La date de retour doit être après la date de départ.";
        } else {

            // Calcul prix
            $prix_base = (float)($destination["prix_base"] ?? 0);
            $prix_unitaire = $prix_base;

            if (!empty($offreActive)) {
                $reduc = (int)($offreActive["pourcentage_reduction"] ?? 0);
                $prix_unitaire = $prix_base * (1 - ($reduc / 100));
            }

            $prix_total = $prix_unitaire * $nb_personnes;

            // Insert réservation
            $unControleur->insert_reservation([
                "id_client"      => $id_client,
                "id_destination" => $id_destination,
                "date_depart"    => $date_depart,
                "date_retour"    => $date_retour,
                "nb_personnes"   => $nb_personnes,
                "prix_total"     => $prix_total
            ]);

            $successReservation = "Réservation confirmée avec succès.";
        }
    }
}

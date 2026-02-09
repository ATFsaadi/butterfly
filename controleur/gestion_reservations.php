<?php

$unControleur->verifConnexion();

$erreurReservation = "";
$successReservation = "";

// CSRF
if (empty($_SESSION["csrf_token"])) {
    $_SESSION["csrf_token"] = bin2hex(random_bytes(32));
}

// Flash PRG
if (!empty($_SESSION["flash_success_reservation_voyage"])) {
    $successReservation = (string)$_SESSION["flash_success_reservation_voyage"];
    unset($_SESSION["flash_success_reservation_voyage"]);
}

$idClient = $unControleur->getIdClientConnecte();
$id_voyage = (int)($_GET["id_voyage"] ?? 0);

$voyage = null;
$offreActive = null;

$adultes = (int)($_GET["adultes"] ?? 1);
$enfants = (int)($_GET["enfants"] ?? 0);
$bebes = (int)($_GET["bebes"] ?? 0);

$nb_personnes = $adultes + $enfants + $bebes;
if ($nb_personnes < 1) $nb_personnes = 1;

// Chargement voyage + offre (GET)
if ($id_voyage > 0) {
    $voyage = $unControleur->selectWhere_voyage($id_voyage);
    if ($voyage) {
        $id_destination = (int)($voyage["id_destination"] ?? 0);
        if ($id_destination > 0) {
            $offreActive = $unControleur->selectWhere_offre_active_by_destination($id_destination);
        }
    } else {
        $erreurReservation = "voyage introuvable.";
    }
} else {
    $erreurReservation = "voyage invalide.";
}

// POST : réserver
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["confirmer_reservation"])) {

    if (!hash_equals($_SESSION["csrf_token"], (string)($_POST["csrf_token"] ?? ""))) {
        $erreurReservation = "action non autorisée. veuillez réessayer.";
    } elseif ($id_voyage <= 0 || $idClient <= 0) {
        $erreurReservation = "réservation impossible.";
    } else {

        // ✅ recharger voyage + offre au moment du POST (important)
        $voyage = $unControleur->selectWhere_voyage($id_voyage);
        if (!$voyage) {
            $erreurReservation = "impossible de réserver : voyage introuvable.";
        } else {

            $id_destination = (int)($voyage["id_destination"] ?? 0);
            $offreActive = $id_destination > 0
                ? $unControleur->selectWhere_offre_active_by_destination($id_destination)
                : null;

            $nb_personnes = (int)($_POST["nb_personnes"] ?? 1);
            if ($nb_personnes < 1) $nb_personnes = 1;

            $statut = (string)($voyage["statut"] ?? "");
            $placesRestantes = (int)($voyage["nb_places_restantes"] ?? 0);

            if ($statut !== "actif") {
                $erreurReservation = "ce voyage n'est pas réservable.";
            } elseif ($placesRestantes <= 0) {
                $erreurReservation = "ce voyage est complet.";
            } elseif ($nb_personnes > $placesRestantes) {
                $erreurReservation = "places insuffisantes. il reste " . $placesRestantes . " place(s).";
            } else {

                $prix_voyage = (float)($voyage["prix"] ?? 0);
                if ($prix_voyage <= 0) {
                    $erreurReservation = "prix du voyage invalide.";
                } else {

                    $prix_unitaire = $prix_voyage;
                    if ($offreActive) {
                        $reduc = (int)($offreActive["pourcentage_reduction"] ?? 0);
                        if ($reduc > 0 && $reduc <= 100) {
                            $prix_unitaire = $prix_voyage * (1 - ($reduc / 100));
                        }
                    }

                    $prix_total = round($prix_unitaire * $nb_personnes, 2);

                    $ok = $unControleur->reserver_voyage([
                        "id_client" => $idClient,
                        "id_voyage" => $id_voyage,
                        "nb_personnes" => $nb_personnes,
                        "prix_total" => $prix_total,
                    ]);

                    if ($ok) {
                        $_SESSION["csrf_token"] = bin2hex(random_bytes(32));
                        $_SESSION["flash_success_reservation_voyage"] = "demande de réservation envoyée.";

                        // ✅ PRG : évite double envoi au refresh
                        header("location: index.php?page=reservation&id_voyage=" . $id_voyage);
                        exit();
                    } else {
                        $erreurReservation = "impossible de réserver. (places peut-être prises entre temps)";
                    }
                }
            }
        }
    }
}

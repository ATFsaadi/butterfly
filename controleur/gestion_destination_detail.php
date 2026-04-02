<?php

$erreurReservation = "";
$successReservation = "";

// CSRF
if (empty($_SESSION["csrf_token"])) {
    $_SESSION["csrf_token"] = bin2hex(random_bytes(32));
}

$id_destination = (int) ($_GET["id_destination"] ?? 0);

$date_depart = (string) ($_GET["date_depart"] ?? "");
$date_retour = (string) ($_GET["date_retour"] ?? "");
$nb_personnes = (int) ($_GET["nb_personnes"] ?? 1);

if ($nb_personnes < 1) {
    $nb_personnes = 1;
}

// message flash (PRG)
if (!empty($_SESSION["flash_success_reservation_destination"])) {
    $successReservation = (string) $_SESSION["flash_success_reservation_destination"];
    unset($_SESSION["flash_success_reservation_destination"]);
}

$destination = null;
$offreActive = null;

// Charge destination + offre (GET)
if ($id_destination > 0) {
    $destination = $unControleur->selectWhere_destination($id_destination);

    if (!$destination) {
        $erreurReservation = "destination introuvable.";
    } elseif ((int) ($destination["actif"] ?? 1) !== 1) {
        $erreurReservation = "cette destination n'est pas disponible.";
    } else {
        $offreActive = $unControleur->selectWhere_offre_active_by_destination($id_destination);
    }
} else {
    $erreurReservation = "destination invalide.";
}

// POST : réserver
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["confirmer_reservation_destination"])) {
    $unControleur->verifConnexion();
    $idClient = $unControleur->getIdClientConnecte();

    if (!hash_equals($_SESSION["csrf_token"], (string) ($_POST["csrf_token"] ?? ""))) {
        $erreurReservation = "action non autorisée. veuillez réessayer.";
    } elseif ($id_destination <= 0) {
        $erreurReservation = "destination invalide.";
    } elseif ($idClient <= 0) {
        $erreurReservation = "compte client introuvable.";
    } else {
        // recharger destination + offre au moment du POST
        $destination = $unControleur->selectWhere_destination($id_destination);

        if (!$destination || (int) ($destination["actif"] ?? 1) !== 1) {
            $erreurReservation = "impossible de réserver : destination indisponible.";
        } else {
            $offreActive = $unControleur->selectWhere_offre_active_by_destination($id_destination);

            $date_depart = trim((string) ($_POST["date_depart"] ?? ""));
            $date_retour = trim((string) ($_POST["date_retour"] ?? ""));
            $nb_personnes = (int) ($_POST["nb_personnes"] ?? 1);

            if ($nb_personnes < 1) {
                $nb_personnes = 1;
            }

            // validations
            if ($date_depart === "" || $date_retour === "") {
                $erreurReservation = "dates obligatoires.";
            } elseif ($date_retour < $date_depart) {
                $erreurReservation = "la date de retour doit être après la date de départ.";
            } else {
                $prix_base = (float) ($destination["prix_base"] ?? 0);

                if ($prix_base <= 0) {
                    $erreurReservation = "prix de la destination invalide.";
                } else {
                    $prix_unitaire = $prix_base;

                    if ($offreActive) {
                        $reduc = (int) ($offreActive["pourcentage_reduction"] ?? 0);
                        if ($reduc > 0 && $reduc <= 100) {
                            $prix_unitaire = $prix_base * (1 - ($reduc / 100));
                        }
                    }

                    $prix_total = round($prix_unitaire * $nb_personnes, 2);

                    $ok = $unControleur->reserver_destination([
                        "id_client" => $idClient,
                        "id_destination" => $id_destination,
                        "date_depart" => $date_depart,
                        "date_retour" => $date_retour,
                        "nb_personnes" => $nb_personnes,
                        "prix_total" => $prix_total,
                    ]);

                    if ($ok) {
                        $_SESSION["csrf_token"] = bin2hex(random_bytes(32));
                        $_SESSION["flash_success_reservation_destination"] = "demande de réservation envoyée.";

                        header("location: index.php?page=destination_detail&id_destination=" . $id_destination);
                        exit();
                    } else {
                        $erreurReservation = "impossible d'enregistrer la réservation.";
                    }
                }
            }
        }
    }
}
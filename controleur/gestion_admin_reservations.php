<?php

// sécurité admin

$unControleur->verifAdmin();

// token csrf

if (empty($_SESSION["csrf_token"])) {
    $_SESSION["csrf_token"] = bin2hex(random_bytes(32));
}

// changement du statut d'une réservation

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["maj_statut"])) {
    if (!hash_equals($_SESSION["csrf_token"], (string) ($_POST["csrf_token"] ?? ""))) {
        die("csrf invalide");
    }

    $type = (string) ($_POST["type"] ?? "");
    $idReservation = (int) ($_POST["id_reservation"] ?? 0);
    $action = (string) ($_POST["action"] ?? "");

    // choix du statut

    $statut = "";

    if ($action === "confirmer") {
        $statut = "confirmee";
    }

    if ($action === "annuler") {
        $statut = "annulee";
    }

    // mise à jour de la réservation

    if ($idReservation > 0 && $statut !== "") {
        if ($type === "destination") {
            $unControleur->update_reservation_destination_statut([
                "id_reservation_destination" => $idReservation,
                "statut" => $statut,
            ]);
        }

        if ($type === "voyage") {
            $unControleur->update_reservation_voyage_statut([
                "id_reservation_voyage" => $idReservation,
                "statut" => $statut,
            ]);

            // vérification du voyage complet

            if ($statut === "confirmee") {
                $idVoyage = $unControleur->select_id_voyage_by_reservation_voyage($idReservation);

                if ($idVoyage > 0) {
                    $unControleur->maj_statut_voyage_si_complet($idVoyage);
                }
            }
        }
    }

    header("location: index.php?page=admin_reservations");
    exit();
}

// récupération des réservations

$lesReservations = $unControleur->selectAll_reservations();
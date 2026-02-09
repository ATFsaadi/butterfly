<?php

$unControleur->verifAdmin();

if (empty($_SESSION["csrf_token"])) {
    $_SESSION["csrf_token"] = bin2hex(random_bytes(32));
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["maj_statut"])) {

    if (!hash_equals($_SESSION["csrf_token"], (string)($_POST["csrf_token"] ?? ""))) {
        die("csrf invalide");
    }

    $type = (string)($_POST["type"] ?? "");
    $id_reservation = (int)($_POST["id_reservation"] ?? 0);
    $action = (string)($_POST["action"] ?? ""); // confirmer|annuler

    $statut = "";
    if ($action === "confirmer") $statut = "confirmee";
    if ($action === "annuler")   $statut = "annulee";

    if ($id_reservation > 0 && $statut !== "") {

        if ($type === "destination") {

            $unControleur->update_reservation_destination_statut([
                "id_reservation_destination" => $id_reservation,
                "statut" => $statut,
            ]);

        } elseif ($type === "voyage") {

            $unControleur->update_reservation_voyage_statut([
                "id_reservation_voyage" => $id_reservation,
                "statut" => $statut,
            ]);

            // ✅ si confirmation → vérifier si le voyage devient complet
            if ($statut === "confirmee") {
                $idVoyage = $unControleur->select_id_voyage_by_reservation_voyage($id_reservation);
                if ($idVoyage > 0) {
                    $unControleur->maj_statut_voyage_si_complet($idVoyage);
                }
            }
        }
    }

    header("location: index.php?page=admin_reservations");
    exit();
}

$lesReservations = $unControleur->selectAll_reservations();

<?php

$unControleur->verifAdmin();

// recuperer toutes les reservations
$lesReservations = $unControleur->selectAll_reservations();

// action changer statut
if (isset($_GET["action"], $_GET["id_reservation"])) {

    $id_reservation = (int) $_GET["id_reservation"];
    $action = $_GET["action"];

    if ($action === "confirmer") {
        $unControleur->update_reservation_statut([
            "id_reservation" => $id_reservation,
            "statut" => "confirmee"
        ]);
    }

    if ($action === "annuler") {
        $unControleur->update_reservation_statut([
            "id_reservation" => $id_reservation,
            "statut" => "annulee"
        ]);
    }

    header("location: index.php?page=admin_reservations");
    exit();
}

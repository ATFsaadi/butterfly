<?php

// Controleur admin reservations : confirme ou annule les demandes.

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

// tri

$tri = (string) ($_GET["tri"] ?? "date");
$ordre = (string) ($_GET["ordre"] ?? "desc");
$trisAutorises = ["id", "client", "destination", "voyage", "date", "voyageurs", "total", "statut", "type"];

if (!in_array($tri, $trisAutorises, true)) {
    $tri = "date";
}

if ($ordre !== "asc") {
    $ordre = "desc";
}

// comparaison utilisee pour trier les reservations
usort($lesReservations, function (array $a, array $b) use ($tri, $ordre): int {
    if ($tri === "id") {
        $comparaison = (int) ($a["id_reservation"] ?? 0) <=> (int) ($b["id_reservation"] ?? 0);
    } elseif ($tri === "client") {
        $valeurA = trim((string) ($a["prenom"] ?? "") . " " . (string) ($a["nom"] ?? ""));
        $valeurB = trim((string) ($b["prenom"] ?? "") . " " . (string) ($b["nom"] ?? ""));
        $comparaison = strcasecmp($valeurA, $valeurB);
    } elseif ($tri === "destination") {
        $valeurA = trim((string) ($a["ville"] ?? "") . " " . (string) ($a["pays"] ?? ""));
        $valeurB = trim((string) ($b["ville"] ?? "") . " " . (string) ($b["pays"] ?? ""));
        $comparaison = strcasecmp($valeurA, $valeurB);
    } elseif ($tri === "voyage") {
        $comparaison = strcasecmp((string) ($a["voyage_titre"] ?? ""), (string) ($b["voyage_titre"] ?? ""));
    } elseif ($tri === "voyageurs") {
        $comparaison = (int) ($a["nb_personnes"] ?? 0) <=> (int) ($b["nb_personnes"] ?? 0);
    } elseif ($tri === "total") {
        $comparaison = (float) ($a["prix_total"] ?? 0) <=> (float) ($b["prix_total"] ?? 0);
    } elseif ($tri === "type") {
        $comparaison = strcasecmp((string) ($a["type_reservation"] ?? ""), (string) ($b["type_reservation"] ?? ""));
    } elseif ($tri === "statut") {
        $comparaison = strcasecmp((string) ($a["statut"] ?? ""), (string) ($b["statut"] ?? ""));
    } else {
        $comparaison = strcmp((string) ($a["date_depart"] ?? ""), (string) ($b["date_depart"] ?? ""));
    }

    return $ordre === "desc" ? -$comparaison : $comparaison;
});

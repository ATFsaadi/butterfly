<?php

// Controleur detail destination : charge une destination et sa reservation.

// variables de base

$erreurReservation = "";
$successReservation = "";

$destination = null;
$offreActive = null;

// token csrf

if (empty($_SESSION["csrf_token"])) {
    $_SESSION["csrf_token"] = bin2hex(random_bytes(32));
}

// récupération des paramètres

$idDestination = (int) ($_GET["id_destination"] ?? 0);

$dateDepart = (string) ($_GET["date_depart"] ?? "");
$dateRetour = (string) ($_GET["date_retour"] ?? "");
$nbPersonnes = (int) ($_GET["nb_personnes"] ?? 1);

if ($nbPersonnes < 1) {
    $nbPersonnes = 1;
}

// message flash

if (!empty($_SESSION["flash_success_reservation_destination"])) {
    $successReservation = (string) $_SESSION["flash_success_reservation_destination"];
    unset($_SESSION["flash_success_reservation_destination"]);
}

// chargement de la destination

if ($idDestination > 0) {
    $destination = $unControleur->selectWhere_destination($idDestination);

    if (!$destination) {
        $erreurReservation = "destination introuvable.";
    } elseif ((int) ($destination["actif"] ?? 1) !== 1) {
        $erreurReservation = "cette destination n'est pas disponible.";
    } else {
        $offreActive = $unControleur->selectWhere_offre_active_by_destination($idDestination);
    }
} else {
    $erreurReservation = "destination invalide.";
}

// validation de la réservation

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["confirmer_reservation_destination"])) {
    $unControleur->verifConnexion();

    $idClient = $unControleur->getIdClientConnecte();

    // vérification csrf

    if (!hash_equals($_SESSION["csrf_token"], (string) ($_POST["csrf_token"] ?? ""))) {
        $erreurReservation = "action non autorisée. veuillez réessayer.";
    } elseif ($idDestination <= 0) {
        $erreurReservation = "destination invalide.";
    } elseif ($idClient <= 0) {
        $erreurReservation = "compte client introuvable.";
    } else {
        // rechargement de la destination

        $destination = $unControleur->selectWhere_destination($idDestination);

        if (!$destination || (int) ($destination["actif"] ?? 1) !== 1) {
            $erreurReservation = "impossible de réserver : destination indisponible.";
        } else {
            $offreActive = $unControleur->selectWhere_offre_active_by_destination($idDestination);

            // récupération du formulaire

            $dateDepart = trim((string) ($_POST["date_depart"] ?? ""));
            $dateRetour = trim((string) ($_POST["date_retour"] ?? ""));
            $nbPersonnes = (int) ($_POST["nb_personnes"] ?? 1);

            if ($nbPersonnes < 1) {
                $nbPersonnes = 1;
            }

            // validation des dates

            if ($dateDepart === "" || $dateRetour === "") {
                $erreurReservation = "dates obligatoires.";
            } elseif ($dateRetour < $dateDepart) {
                $erreurReservation = "la date de retour doit être après la date de départ.";
            } else {
                // calcul du prix

                $prixBase = (float) ($destination["prix_base"] ?? 0);

                if ($prixBase <= 0) {
                    $erreurReservation = "prix de la destination invalide.";
                } else {
                    $prixUnitaire = $prixBase;

                    if ($offreActive) {
                        $reduction = (int) ($offreActive["pourcentage_reduction"] ?? 0);

                        if ($reduction > 0 && $reduction <= 100) {
                            $prixUnitaire = $prixBase * (1 - ($reduction / 100));
                        }
                    }

                    $prixTotal = round($prixUnitaire * $nbPersonnes, 2);

                    // insertion de la réservation

                    $ok = $unControleur->reserver_destination([
                        "id_client" => $idClient,
                        "id_destination" => $idDestination,
                        "date_depart" => $dateDepart,
                        "date_retour" => $dateRetour,
                        "nb_personnes" => $nbPersonnes,
                        "prix_total" => $prixTotal,
                    ]);

                    if ($ok) {
                        $_SESSION["csrf_token"] = bin2hex(random_bytes(32));
                        $_SESSION["flash_success_reservation_destination"] = "demande de réservation envoyée.";

                        header("location: index.php?page=destination_detail&id_destination=" . $idDestination);
                        exit();
                    }

                    $erreurReservation = "impossible d'enregistrer la réservation.";
                }
            }
        }
    }
}

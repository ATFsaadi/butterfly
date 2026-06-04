<?php

// Controleur reservation : gere les reservations voyages et destinations.

// sécurité client

$unControleur->verifConnexion();

// variables de base

$erreurReservation = "";
$successReservation = "";

$voyage = null;
$destination = null;
$offreActive = null;

// token csrf

if (empty($_SESSION["csrf_token"])) {
    $_SESSION["csrf_token"] = bin2hex(random_bytes(32));
}

// message flash

if (!empty($_SESSION["flash_success_reservation"])) {
    $successReservation = (string) $_SESSION["flash_success_reservation"];
    unset($_SESSION["flash_success_reservation"]);
}

// récupération du client

$idClient = (int) $unControleur->getIdClientConnecte();

// récupération des paramètres

$idVoyage = (int) ($_GET["id_voyage"] ?? 0);
$idDestination = (int) ($_GET["id_destination"] ?? 0);

// détection du type de réservation

$type = "";

if ($idVoyage > 0) {
    $type = "voyage";
} elseif ($idDestination > 0) {
    $type = "destination";
} else {
    $erreurReservation = "réservation invalide.";
}

// nombre de personnes

$adultes = (int) ($_GET["adultes"] ?? 1);
$enfants = (int) ($_GET["enfants"] ?? 0);
$bebes = (int) ($_GET["bebes"] ?? 0);

$nbPersonnes = $adultes + $enfants + $bebes;

if ($nbPersonnes < 1) {
    $nbPersonnes = 1;
}

// dates destination

$dateDepart = (string) ($_POST["date_depart"] ?? ($_GET["date_depart"] ?? ""));
$dateRetour = (string) ($_POST["date_retour"] ?? ($_GET["date_retour"] ?? ""));

// chargement des informations

if ($erreurReservation === "") {
    if ($type === "voyage") {
        $voyage = $unControleur->selectWhere_voyage($idVoyage);

        if ($voyage) {
            $idDestinationVoyage = (int) ($voyage["id_destination"] ?? 0);

            if ($idDestinationVoyage > 0) {
                $offreActive = $unControleur->selectWhere_offre_active_by_destination($idDestinationVoyage);
            }
        } else {
            $erreurReservation = "voyage introuvable.";
        }
    }

    if ($type === "destination") {
        $destination = $unControleur->selectWhere_destination($idDestination);

        if ($destination) {
            $offreActive = $unControleur->selectWhere_offre_active_by_destination($idDestination);
        } else {
            $erreurReservation = "destination introuvable.";
        }
    }
}

// traitement du formulaire

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $postVoyage = isset($_POST["confirmer_reservation_voyage"]);
    $postDestination = isset($_POST["confirmer_reservation_destination"]);

    if ($postVoyage || $postDestination) {
        // vérification csrf

        if (!hash_equals($_SESSION["csrf_token"], (string) ($_POST["csrf_token"] ?? ""))) {
            $erreurReservation = "action non autorisée. veuillez réessayer.";
        } elseif ($idClient <= 0) {
            $erreurReservation = "réservation impossible.";
        } else {
            // réservation voyage

            if ($postVoyage) {
                if ($idVoyage <= 0) {
                    $erreurReservation = "voyage invalide.";
                } else {
                    $voyage = $unControleur->selectWhere_voyage($idVoyage);

                    if (!$voyage) {
                        $erreurReservation = "impossible de réserver : voyage introuvable.";
                    } else {
                        $idDestinationVoyage = (int) ($voyage["id_destination"] ?? 0);

                        $offreActive = $idDestinationVoyage > 0
                            ? $unControleur->selectWhere_offre_active_by_destination($idDestinationVoyage)
                            : null;

                        $nbPersonnes = (int) ($_POST["nb_personnes"] ?? 1);

                        if ($nbPersonnes < 1) {
                            $nbPersonnes = 1;
                        }

                        $statut = (string) ($voyage["statut"] ?? "");
                        $placesRestantes = (int) ($voyage["nb_places_restantes"] ?? 0);

                        if ($statut !== "actif") {
                            $erreurReservation = "ce voyage n'est pas réservable.";
                        } elseif ($placesRestantes <= 0) {
                            $erreurReservation = "ce voyage est complet.";
                        } elseif ($nbPersonnes > $placesRestantes) {
                            $erreurReservation = "places insuffisantes. il reste " . $placesRestantes . " place(s).";
                        } else {
                            $prixVoyage = (float) ($voyage["prix"] ?? 0);

                            if ($prixVoyage <= 0) {
                                $erreurReservation = "prix du voyage invalide.";
                            } else {
                                // calcul du prix voyage

                                $prixUnitaire = $prixVoyage;

                                if ($offreActive) {
                                    $reduction = (int) ($offreActive["pourcentage_reduction"] ?? 0);

                                    if ($reduction > 0 && $reduction <= 100) {
                                        $prixUnitaire = $prixVoyage * (1 - ($reduction / 100));
                                    }
                                }

                                $prixTotal = round($prixUnitaire * $nbPersonnes, 2);

                                // insertion réservation voyage

                                $ok = $unControleur->reserver_voyage([
                                    "id_client" => $idClient,
                                    "id_voyage" => $idVoyage,
                                    "nb_personnes" => $nbPersonnes,
                                    "prix_total" => $prixTotal,
                                ]);

                                if ($ok) {
                                    $_SESSION["csrf_token"] = bin2hex(random_bytes(32));
                                    $_SESSION["flash_success_reservation"] = "demande de réservation envoyée.";

                                    header("location: index.php?page=reservation&id_voyage=" . $idVoyage);
                                    exit();
                                }

                                $erreurReservation = "impossible de réserver. places peut-être prises entre temps.";
                            }
                        }
                    }
                }
            }

            // réservation destination

            if ($postDestination) {
                if ($idDestination <= 0) {
                    $erreurReservation = "destination invalide.";
                } else {
                    $destination = $unControleur->selectWhere_destination($idDestination);

                    if (!$destination) {
                        $erreurReservation = "impossible de réserver : destination introuvable.";
                    } else {
                        $offreActive = $unControleur->selectWhere_offre_active_by_destination($idDestination);

                        $nbPersonnes = (int) ($_POST["nb_personnes"] ?? 1);

                        if ($nbPersonnes < 1) {
                            $nbPersonnes = 1;
                        }

                        $dateDepart = (string) ($_POST["date_depart"] ?? "");
                        $dateRetour = (string) ($_POST["date_retour"] ?? "");

                        // validation des dates

                        if ($dateDepart === "" || $dateRetour === "") {
                            $erreurReservation = "veuillez choisir des dates.";
                        } elseif ($dateRetour < $dateDepart) {
                            $erreurReservation = "date de retour invalide.";
                        } else {
                            $prixBase = (float) ($destination["prix_base"] ?? 0);

                            if ($prixBase <= 0) {
                                $erreurReservation = "prix base invalide.";
                            } else {
                                // calcul du prix destination

                                $prixUnitaire = $prixBase;

                                if ($offreActive) {
                                    $reduction = (int) ($offreActive["pourcentage_reduction"] ?? 0);

                                    if ($reduction > 0 && $reduction <= 100) {
                                        $prixUnitaire = $prixBase * (1 - ($reduction / 100));
                                    }
                                }

                                $timestampDepart = strtotime($dateDepart);
                                $timestampRetour = strtotime($dateRetour);

                                $nbNuits = (int) (($timestampRetour - $timestampDepart) / 86400);

                                if ($nbNuits < 1) {
                                    $nbNuits = 1;
                                }

                                $prixTotal = round($prixUnitaire * $nbPersonnes * $nbNuits, 2);

                                // insertion réservation destination

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
                                    $_SESSION["flash_success_reservation"] = "demande de réservation envoyée.";

                                    header("location: index.php?page=reservation&id_destination=" . $idDestination);
                                    exit();
                                }

                                $erreurReservation = "impossible de réserver.";
                            }
                        }
                    }
                }
            }
        }
    }
}

// variables attendues par la vue

$nb_personnes = $nbPersonnes;
$date_depart = $dateDepart;
$date_retour = $dateRetour;

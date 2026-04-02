<?php

$unControleur->verifConnexion();

$erreurReservation = "";
$successReservation = "";

// CSRF
if (empty($_SESSION["csrf_token"])) {
    $_SESSION["csrf_token"] = bin2hex(random_bytes(32));
}

// Flash PRG (unique pour les 2)
if (!empty($_SESSION["flash_success_reservation"])) {
    $successReservation = (string)$_SESSION["flash_success_reservation"];
    unset($_SESSION["flash_success_reservation"]);
}

$idClient = (int)$unControleur->getIdClientConnecte();

// Détecter si on réserve un voyage ou une destination
$id_voyage = (int)($_GET["id_voyage"] ?? 0);
$id_destination = (int)($_GET["id_destination"] ?? 0);

$type = "";
if ($id_voyage > 0) {
    $type = "voyage";
} elseif ($id_destination > 0) {
    $type = "destination";
} else {
    $erreurReservation = "réservation invalide.";
}

$voyage = null;
$destination = null;
$offreActive = null;

// Pour voyage (si tu gardes adultes/enfants/bebes en GET)
$adultes = (int)($_GET["adultes"] ?? 1);
$enfants = (int)($_GET["enfants"] ?? 0);
$bebes   = (int)($_GET["bebes"] ?? 0);
$nb_personnes = $adultes + $enfants + $bebes;
if ($nb_personnes < 1) $nb_personnes = 1;

// Pour destination (dates optionnelles selon ta view)
$date_depart = (string)($_POST["date_depart"] ?? ($_GET["date_depart"] ?? ""));
$date_retour = (string)($_POST["date_retour"] ?? ($_GET["date_retour"] ?? ""));


// =====================
// GET : Charger infos
// =====================
if ($erreurReservation === "") {

    if ($type === "voyage") {

        $voyage = $unControleur->selectWhere_voyage($id_voyage);
        if ($voyage) {
            $id_destination_from_voyage = (int)($voyage["id_destination"] ?? 0);
            if ($id_destination_from_voyage > 0) {
                $offreActive = $unControleur->selectWhere_offre_active_by_destination($id_destination_from_voyage);
            }
        } else {
            $erreurReservation = "voyage introuvable.";
        }

    } else { // destination

        $destination = $unControleur->selectWhere_destination($id_destination);
        if ($destination) {
            $offreActive = $unControleur->selectWhere_offre_active_by_destination($id_destination);
        } else {
            $erreurReservation = "destination introuvable.";
        }
    }
}


// =====================
// POST : Réserver
// =====================
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $postVoyage = isset($_POST["confirmer_reservation_voyage"]);
    $postDest   = isset($_POST["confirmer_reservation_destination"]);

    if ($postVoyage || $postDest) {

        if (!hash_equals($_SESSION["csrf_token"], (string)($_POST["csrf_token"] ?? ""))) {
            $erreurReservation = "action non autorisée. veuillez réessayer.";
        } elseif ($idClient <= 0) {
            $erreurReservation = "réservation impossible.";
        } else {

            // ========= VOYAGE =========
            if ($postVoyage) {

                if ($id_voyage <= 0) {
                    $erreurReservation = "voyage invalide.";
                } else {

                    $voyage = $unControleur->selectWhere_voyage($id_voyage);
                    if (!$voyage) {
                        $erreurReservation = "impossible de réserver : voyage introuvable.";
                    } else {

                        $id_destination_from_voyage = (int)($voyage["id_destination"] ?? 0);
                        $offreActive = $id_destination_from_voyage > 0
                            ? $unControleur->selectWhere_offre_active_by_destination($id_destination_from_voyage)
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

                                // nb_nuits : au minimum 1
                                    //   VOYAGE : prix par personne (pas par nuit)
$prix_total = round($prix_unitaire * $nb_personnes, 2);



                                $ok = $unControleur->reserver_voyage([
                                    "id_client" => $idClient,
                                    "id_voyage" => $id_voyage,
                                    "nb_personnes" => $nb_personnes,
                                    "prix_total" => $prix_total,
                                ]);

                                if ($ok) {
                                    $_SESSION["csrf_token"] = bin2hex(random_bytes(32));
                                    $_SESSION["flash_success_reservation"] = "demande de réservation envoyée.";

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

            // ========= DESTINATION =========
            if ($postDest) {

                if ($id_destination <= 0) {
                    $erreurReservation = "destination invalide.";
                } else {

                    $destination = $unControleur->selectWhere_destination($id_destination);
                    if (!$destination) {
                        $erreurReservation = "impossible de réserver : destination introuvable.";
                    } else {

                        $offreActive = $unControleur->selectWhere_offre_active_by_destination($id_destination);

                        $nb_personnes = (int)($_POST["nb_personnes"] ?? 1);
                        if ($nb_personnes < 1) $nb_personnes = 1;

                        $date_depart = (string)($_POST["date_depart"] ?? "");
                        $date_retour = (string)($_POST["date_retour"] ?? "");

                        // Si tu ne veux PAS les dates, supprime ces 2 contrôles
                        if ($date_depart === "" || $date_retour === "") {
                            $erreurReservation = "veuillez choisir des dates.";
                        } elseif ($date_retour < $date_depart) {
                            $erreurReservation = "date de retour invalide.";
                        } else {

                            $prix_base = (float)($destination["prix_base"] ?? 0);
                            if ($prix_base <= 0) {
                                $erreurReservation = "prix base invalide.";
                            } else {

                                $prix_unitaire = $prix_base;
                                if ($offreActive) {
                                    $reduc = (int)($offreActive["pourcentage_reduction"] ?? 0);
                                    if ($reduc > 0 && $reduc <= 100) {
                                        $prix_unitaire = $prix_base * (1 - ($reduc / 100));
                                    }
                                }

                                $ts_depart = strtotime($date_depart);
$ts_retour = strtotime($date_retour);

// nb_nuits : au minimum 1
$nb_nuits = (int)(($ts_retour - $ts_depart) / 86400);
if ($nb_nuits < 1) $nb_nuits = 1;

//   DESTINATION : prix par nuit ET par personne
$prix_total = round($prix_unitaire * $nb_personnes * $nb_nuits, 2);


                                // appelle une méthode à ajouter (voir plus bas)
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
                                    $_SESSION["flash_success_reservation"] = "demande de réservation envoyée.";

                                    header("location: index.php?page=reservation&id_destination=" . $id_destination);
                                    exit();
                                } else {
                                    $erreurReservation = "impossible de réserver.";
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}

<?php
$voyage = $voyage ?? null;
$nb_personnes = $nb_personnes ?? 1;
$offreActive = $offreActive ?? null;
$erreurReservation = $erreurReservation ?? "";
$successReservation = $successReservation ?? "";
?>


<div class="container py-5">

    <h2 class="section-title text-center mb-4">réservation</h2>

    <?php if (empty($voyage)): ?>

        <div class="alert alert-danger">
            <?= $erreurReservation !== "" ? htmlspecialchars($erreurReservation) : "voyage introuvable." ?>
        </div>

    <?php else: ?>

        <?php
        $idVoyage = (int)($voyage["id_voyage"] ?? 0);
        $idDestination = (int)($voyage["id_destination"] ?? 0);

        $prix_voyage = (float)($voyage["prix"] ?? 0);
        $reduc = !empty($offreActive) ? (int)($offreActive["pourcentage_reduction"] ?? 0) : 0;

        $prix_unitaire = $prix_voyage;
        if ($prix_voyage > 0 && $reduc > 0 && $reduc <= 100) {
            $prix_unitaire = $prix_voyage * (1 - ($reduc / 100));
        }

        $nb_personnes_int = (int)$nb_personnes;
        if ($nb_personnes_int < 1) {
            $nb_personnes_int = 1;
        }

        $total_sans_promo = $prix_voyage * $nb_personnes_int;
        $total_avec_promo = $prix_unitaire * $nb_personnes_int;
        $economies = $total_sans_promo - $total_avec_promo;

        $imageVoyage = (string)($voyage["image_url"] ?? "");
        $imageDestination = (string)($voyage["destination_image_url"] ?? "");
        $image = $imageVoyage !== "" ? $imageVoyage : $imageDestination;

        $titre = (string)($voyage["titre"] ?? "");
        $pays = (string)($voyage["pays"] ?? "");
        $ville = (string)($voyage["ville"] ?? "");
        $continent = (string)($voyage["continent"] ?? "");
        $dateDepart = (string)($voyage["date_depart"] ?? "");
        $dateRetour = (string)($voyage["date_retour"] ?? "");
        $placesRestantes = (int)($voyage["nb_places_restantes"] ?? 0);

        $statutVoyage = (string)($voyage["statut"] ?? "");
        $bloque = ($statutVoyage !== "actif" || $placesRestantes <= 0);
        ?>

        <?php if (!empty($erreurReservation)): ?>
            <div class="alert alert-danger">
                <?= htmlspecialchars($erreurReservation) ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($successReservation)): ?>
            <div class="alert alert-success">
                <?= htmlspecialchars($successReservation) ?>
            </div>
        <?php endif; ?>

        <div class="row g-4 align-items-start">

            <div class="col-lg-6">
                <div class="card shadow-sm">

                    <?php if ($image !== ""): ?>
                        <img
                            src="<?= htmlspecialchars($image) ?>"
                            alt="voyage"
                            class="card-img-top"
                            style="height:260px; object-fit:cover;"
                        >
                    <?php endif; ?>

                    <div class="card-body">

                        <h4 class="mb-1"><?= htmlspecialchars($titre) ?></h4>

                        <div class="text-muted mb-2">
                            <?= htmlspecialchars(trim($ville . " — " . $pays, " —")) ?>
                            <?php if ($continent !== ""): ?>
                                · <?= htmlspecialchars($continent) ?>
                            <?php endif; ?>
                        </div>

                        <div class="mb-2">
                            <strong>dates :</strong>
                            <?= htmlspecialchars($dateDepart) ?> → <?= htmlspecialchars($dateRetour) ?>
                        </div>

                        <div class="mb-2">
                            <strong>places restantes :</strong>
                            <?= $placesRestantes ?>
                        </div>

                        <div class="mb-2">
                            <?php if ($statutVoyage === "annule"): ?>
                                <span class="badge bg-danger">annulé</span>
                            <?php elseif ($statutVoyage === "complet" || $placesRestantes <= 0): ?>
                                <span class="badge bg-secondary">complet</span>
                            <?php else: ?>
                                <span class="badge bg-success">actif</span>
                            <?php endif; ?>
                        </div>

                        <?php if (!empty($offreActive)): ?>
                            <div class="alert alert-warning py-2 mb-3">
                                offre appliquée :
                                <strong><?= htmlspecialchars((string)$offreActive["titre"]) ?></strong>
                                — <strong>-<?= (int)$offreActive["pourcentage_reduction"] ?>%</strong>
                            </div>
                        <?php endif; ?>

                        <div class="small">
                            <div>
                                prix voyage :
                                <strong><?= number_format($prix_voyage, 2, ",", " ") ?> €</strong>
                            </div>

                            <?php if ($reduc > 0): ?>
                                <div>
                                    prix unitaire (promo) :
                                    <strong><?= number_format($prix_unitaire, 2, ",", " ") ?> €</strong>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="mt-3">
                            <a class="btn btn-outline-primary btn-sm"
                               href="index.php?page=voyage_detail&id_voyage=<?= $idVoyage ?>">
                                retour au voyage
                            </a>
                            <?php if ($idDestination > 0): ?>
                                <a class="btn btn-outline-secondary btn-sm"
                                   href="index.php?page=destination_detail&id_destination=<?= $idDestination ?>">
                                    voir destination
                                </a>
                            <?php endif; ?>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card shadow-sm">
                    <div class="card-body">

                        <h5 class="mb-3">choisissez le nombre de voyageurs</h5>

                        <?php if ($bloque): ?>
                            <div class="alert alert-info">
                                réservation indisponible pour ce voyage.
                            </div>
                        <?php endif; ?>

                        <form method="post" action="index.php?page=reservation&id_voyage=<?= $idVoyage ?>">
                            <input type="hidden" name="csrf_token"
                                   value="<?= htmlspecialchars($_SESSION["csrf_token"] ?? "") ?>">

                            <div class="row g-3">
                                <div class="col-md-12">
                                    <label class="form-label">nombre de personnes</label>
                                    <input
                                        type="number"
                                        class="form-control"
                                        name="nb_personnes"
                                        min="1"
                                        max="<?= max(1, $placesRestantes) ?>"
                                        value="<?= $nb_personnes_int ?>"
                                        required
                                        <?= $bloque ? "disabled" : "" ?>
                                    >
                                    <div class="form-text">
                                        <?= $placesRestantes ?> place(s) restante(s)
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4">

                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fs-6">total estimé</span>
                                <span class="fs-4 fw-bold">
                                    <?= number_format($total_avec_promo, 2, ",", " ") ?> €
                                </span>
                            </div>

                            <?php if ($reduc > 0 && $economies > 0.01): ?>
                                <div class="text-success small mt-1">
                                    vous payez
                                    <strong><?= number_format($total_avec_promo, 2, ",", " ") ?> €</strong>
                                    au lieu de
                                    <s><?= number_format($total_sans_promo, 2, ",", " ") ?> €</s>
                                    (économie <?= number_format($economies, 2, ",", " ") ?> €)
                                </div>
                            <?php endif; ?>

                            <button
                                type="submit"
                                name="confirmer_reservation"
                                value="1"
                                class="btn btn-primary w-100 mt-3 py-3"
                                <?= $bloque ? "disabled" : "" ?>
                            >
                                confirmer la réservation
                            </button>

                            <div class="text-muted small text-center mt-2">
                                statut : <strong>en attente</strong>
                            </div>

                        </form>

                    </div>
                </div>
            </div>

        </div>

    <?php endif; ?>

</div>

    <?php

    $destination = $destination ?? null;
    $offreActive = $offreActive ?? null;

    $erreurReservation = $erreurReservation ?? "";
    $successReservation = $successReservation ?? "";

    $date_depart = $date_depart ?? "";
    $date_retour = $date_retour ?? "";
    $nb_personnes = $nb_personnes ?? 1;

    ?>

    <?php if (empty($destination)): ?>

        <div class="container mt-4">
            <div class="alert alert-danger">destination introuvable.</div>
        </div>

    <?php else: ?>

        <?php
        $id = (int)($destination["id_destination"] ?? 0);
        $pays = (string)($destination["pays"] ?? "");
        $ville = (string)($destination["ville"] ?? "");
        $continent = (string)($destination["continent"] ?? "");
        $description = (string)($destination["description"] ?? "");
        $prixBase = (float)($destination["prix_base"] ?? 0);
        $image = (string)($destination["image_url"] ?? "");

        $titre = trim($pays . " - " . $ville, " -");
        ?>

        <h3 class="section-title text-center mt-5">
            <?= htmlspecialchars($titre) ?>
        </h3>

        <div class="container mt-4" style="max-width: 700px;">

            <?php if ($erreurReservation !== ""): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($erreurReservation) ?></div>
            <?php endif; ?>

            <?php if ($successReservation !== ""): ?>
                <div class="alert alert-success"><?= htmlspecialchars($successReservation) ?></div>
            <?php endif; ?>

            <!-- ====== 1 COLONNE ====== -->

            <?php if ($continent !== ""): ?>
                <p class="text-muted mb-2"><?= htmlspecialchars($continent) ?></p>
            <?php endif; ?>

            <?php if ($description !== ""): ?>
                <p><?= nl2br(htmlspecialchars($description)) ?></p>
            <?php endif; ?>

            <p class="mb-3">
                <strong>prix base :</strong>
                <?= number_format($prixBase, 2, ",", " ") ?> €
            </p>

            <!-- IMAGE APRES -->
            <?php if ($image !== ""): ?>
                <img
                    src="<?= htmlspecialchars($image) ?>"
                    alt="image destination"
                    class="img-fluid mb-3"
                    style="width:100%; max-height:380px; object-fit:cover; border:1px solid #ccc; padding:2px; border-radius:10px;"
                >
            <?php else: ?>
                <div class="alert alert-secondary mb-3">aucune image disponible.</div>
            <?php endif; ?>

            <!-- RESTE APRES L'IMAGE : offre + reservation -->
            <?php if (!empty($offreActive)): ?>
                <?php
                $offreTitre = (string)($offreActive["titre"] ?? "");
                $offreReduc = (int)($offreActive["pourcentage_reduction"] ?? 0);
                $offreDebut = (string)($offreActive["date_debut"] ?? "");
                $offreFin = (string)($offreActive["date_fin"] ?? "");
                ?>
                <div class="alert alert-success">
                    offre active :
                    <strong><?= htmlspecialchars($offreTitre) ?></strong>
                    (<?= (int)$offreReduc ?>%)
                    <br>
                    du <?= htmlspecialchars($offreDebut) ?>
                    au <?= htmlspecialchars($offreFin) ?>
                </div>
            <?php endif; ?>

            <div class="card mt-3">
                <div class="card-body">
                    <h5 class="mb-3">réservation sur mesure</h5>

                    <form method="post" action="index.php?page=reservation&id_destination=<?= $id ?>">
                        <input type="hidden" name="csrf_token"
                            value="<?= htmlspecialchars($_SESSION["csrf_token"] ?? "") ?>">

                        <div class="mb-2">
                            <label class="form-label">date de départ</label>
                            <input type="date" name="date_depart" class="form-control"
                                value="<?= htmlspecialchars($date_depart) ?>" required>
                        </div>

                        <div class="mb-2">
                            <label class="form-label">date de retour</label>
                            <input type="date" name="date_retour" class="form-control"
                                value="<?= htmlspecialchars($date_retour) ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">nombre de personnes</label>
                            <input type="number" name="nb_personnes" class="form-control"
                                min="1" value="<?= (int)$nb_personnes ?>" required>
                        </div>

                        <button type="submit"
                                name="confirmer_reservation_destination"
                                class="btn btn-success w-100">
                            réserver
                        </button>
                    </form>
                </div>
            </div>

        </div>

    <?php endif; ?>

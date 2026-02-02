<?php
// vue/reservation.php

$destination = $destination ?? null;

$nb_personnes = $nb_personnes ?? 1;
$date_depart  = $date_depart ?? "";
$date_retour  = $date_retour ?? "";

$offreActive = $offreActive ?? null;
$erreurReservation = $erreurReservation ?? "";
$successReservation = $successReservation ?? "";

?>

<div class="container py-5">

  <h2 class="section-title text-center mb-4">Réservation</h2>

  <?php if (empty($destination)): ?>

    <div class="alert alert-danger">Destination introuvable.</div>

  <?php else: ?>

    <?php
    $prix_base = (float)($destination["prix_base"] ?? 0);
    $reduc = (!empty($offreActive)) ? (int)($offreActive["pourcentage_reduction"] ?? 0) : 0;

    $prix_unitaire = $prix_base;
    if ($reduc > 0) {
      $prix_unitaire = $prix_base * (1 - ($reduc / 100));
    }

    $total_sans_promo = $prix_base * $nb_personnes;
    $total_avec_promo = $prix_unitaire * $nb_personnes;
    $economies = $total_sans_promo - $total_avec_promo;
    ?>

    <!-- message erreur -->
    <?php if (!empty($erreurReservation)): ?>
      <div class="alert alert-danger">
        <?= htmlspecialchars($erreurReservation) ?>
      </div>
    <?php endif; ?>

    <!-- message succès -->
    <?php if (!empty($successReservation)): ?>
      <div class="alert alert-success">
        <?= htmlspecialchars($successReservation) ?>
      </div>
    <?php endif; ?>

    <div class="row g-4 align-items-start">

      <!-- recap destination -->
      <div class="col-lg-6">
        <div class="card shadow-sm">

          <img
            src="<?= htmlspecialchars(!empty($destination["image_url"]) ? $destination["image_url"] : "images/destinations/destination.jpg") ?>"
            alt="Destination"
            class="card-img-top"
            style="height:260px; object-fit:cover;"
          >

          <div class="card-body">

            <h4 class="mb-1">
              <?= htmlspecialchars($destination["ville"] ?? "") ?> — <?= htmlspecialchars($destination["pays"] ?? "") ?>
            </h4>

            <div class="text-muted mb-3">
              <?= htmlspecialchars($destination["continent"] ?? "") ?>
            </div>

            <p class="card-text">
              <?= nl2br(htmlspecialchars((string)($destination["description"] ?? ""))) ?>
            </p>

            <?php if (!empty($offreActive)): ?>
              <div class="alert alert-warning py-2 mb-3">
                Offre appliquée : <strong><?= htmlspecialchars($offreActive["titre"] ?? "") ?></strong>
                — <strong>-<?= (int)($offreActive["pourcentage_reduction"] ?? 0) ?>%</strong>
              </div>
            <?php endif; ?>

            <div class="small">
              <div>Prix de base : <strong><?= number_format($prix_base, 2, ",", " ") ?> €</strong></div>
              <?php if ($reduc > 0): ?>
                <div>Prix unitaire (promo) : <strong><?= number_format($prix_unitaire, 2, ",", " ") ?> €</strong></div>
              <?php endif; ?>
            </div>

          </div>
        </div>
      </div>

      <!-- formulaire -->
      <div class="col-lg-6">
        <div class="card shadow-sm">
          <div class="card-body">

            <h5 class="mb-3">Choisissez vos dates et le nombre de voyageurs</h5>

            <!-- ✅ IMPORTANT : id_destination (pas id) -->
            <form method="POST" action="index.php?page=reservation&id_destination=<?= (int)$destination["id_destination"] ?>">

              <div class="row g-3">

                <div class="col-md-6">
                  <label class="form-label">Date départ</label>
                  <input type="date" class="form-control" name="date_depart" value="<?= htmlspecialchars($date_depart) ?>" required>
                </div>

                <div class="col-md-6">
                  <label class="form-label">Date retour</label>
                  <input type="date" class="form-control" name="date_retour" value="<?= htmlspecialchars($date_retour) ?>" required>
                </div>

                <div class="col-md-12">
                  <label class="form-label">Nombre de personnes</label>
                  <input type="number" class="form-control" name="nb_personnes" min="1" value="<?= (int)$nb_personnes ?>" required>
                </div>

              </div>

              <hr class="my-4">

              <div class="d-flex justify-content-between align-items-center">
                <span class="fs-6">Total estimé</span>
                <span class="fs-4 fw-bold"><?= number_format($total_avec_promo, 2, ",", " ") ?> €</span>
              </div>

              <?php if ($reduc > 0 && $economies > 0.01): ?>
                <div class="text-success small mt-1">
                  Vous payez <strong><?= number_format($total_avec_promo, 2, ",", " ") ?> €</strong>
                  au lieu de <s><?= number_format($total_sans_promo, 2, ",", " ") ?> €</s>
                  (économie <?= number_format($economies, 2, ",", " ") ?> €)
                </div>
              <?php endif; ?>

              <button type="submit" name="confirmer_reservation" value="1" class="btn btn-primary w-100 mt-3 py-3">
                Confirmer la réservation
              </button>

              <div class="text-muted small text-center mt-2">
                Statut : <strong>en attente</strong>
              </div>

            </form>

          </div>
        </div>
      </div>

    </div>

  <?php endif; ?>

</div>

<?php
$voyage = $voyage ?? null;
$destination = $destination ?? null;

$nb_personnes = $nb_personnes ?? 1;
$offreActive = $offreActive ?? null;

$erreurReservation = $erreurReservation ?? "";
$successReservation = $successReservation ?? "";

$date_depart = $date_depart ?? "";
$date_retour = $date_retour ?? "";

/* =========================================================
   ✅ Préparer TOUT ce qui est utilisé dans la page
========================================================= */
$idVoyage = 0;
$idDestination = 0;

$image = "";
$titre = "";
$titleLeft = "";
$hrefLeft = "";

$nb_personnes_int = (int)$nb_personnes;
if ($nb_personnes_int < 1) $nb_personnes_int = 1;

$reduc = !empty($offreActive) ? (int)($offreActive["pourcentage_reduction"] ?? 0) : 0;
$prix_unitaire = 0;

$total_sans_promo = 0;
$total_avec_promo = 0;
$economies = 0;

$placesRestantes = 0;
$bloque = false;

/* Cas VOYAGE */
if (!empty($voyage)) {

  $idVoyage = (int)($voyage["id_voyage"] ?? 0);
  $idDestination = (int)($voyage["id_destination"] ?? 0);

  $prix_voyage = (float)($voyage["prix"] ?? 0);

  $prix_unitaire = $prix_voyage;
  if ($prix_voyage > 0 && $reduc > 0 && $reduc <= 100) {
    $prix_unitaire = $prix_voyage * (1 - ($reduc / 100));
  }

  $total_sans_promo = $prix_voyage * $nb_personnes_int;
  $total_avec_promo = $prix_unitaire * $nb_personnes_int;
  $economies = $total_sans_promo - $total_avec_promo;

  $imageVoyage = (string)($voyage["image_url"] ?? "");
  $imageDestination = (string)($voyage["destination_image_url"] ?? "");
  $image = $imageVoyage !== "" ? $imageVoyage : $imageDestination;

  $titleLeft = (string)($voyage["titre"] ?? "");
  $hrefLeft = "index.php?page=voyage_detail&id_voyage=" . $idVoyage;

  $placesRestantes = (int)($voyage["nb_places_restantes"] ?? 0);
  $statutVoyage = (string)($voyage["statut"] ?? "");
  $bloque = ($statutVoyage !== "actif" || $placesRestantes <= 0);

/* Cas DESTINATION */
} elseif (!empty($destination)) {

  $idDestination = (int)($destination["id_destination"] ?? 0);

  $pays = (string)($destination["pays"] ?? "");
  $ville = (string)($destination["ville"] ?? "");

  $titre = trim($ville . " — " . $pays, " —");
  $titleLeft = $titre;
  $hrefLeft = "index.php?page=destination_detail&id_destination=" . $idDestination;

  $image = (string)($destination["image_url"] ?? "");

  $prix_base = (float)($destination["prix_base"] ?? 0);

  $prix_unitaire = $prix_base;
  if ($prix_base > 0 && $reduc > 0 && $reduc <= 100) {
    $prix_unitaire = $prix_base * (1 - ($reduc / 100));
  }

  $nb_nuits = 1;
  if (!empty($date_depart) && !empty($date_retour)) {
    $ts_depart = strtotime($date_depart);
    $ts_retour = strtotime($date_retour);
    if ($ts_depart !== false && $ts_retour !== false) {
      $nb_nuits = (int)(($ts_retour - $ts_depart) / 86400);
      if ($nb_nuits < 1) $nb_nuits = 1;
    }
  }

  $total_sans_promo = $prix_base * $nb_personnes_int * $nb_nuits;
  $total_avec_promo = $prix_unitaire * $nb_personnes_int * $nb_nuits;
  $economies = $total_sans_promo - $total_avec_promo;
}
?>

<div class="container py-5">

  <h2 class="section-title text-center mb-4">réservation</h2>

  <?php if (empty($voyage) && empty($destination)): ?>

    <div class="alert alert-danger">
      <?= $erreurReservation !== "" ? htmlspecialchars($erreurReservation) : "élément introuvable." ?>
    </div>

  <?php else: ?>

    <?php if (!empty($erreurReservation)): ?>
      <div class="alert alert-danger"><?= htmlspecialchars($erreurReservation) ?></div>
    <?php endif; ?>

    <?php if (!empty($successReservation)): ?>
      <div class="alert alert-success"><?= htmlspecialchars($successReservation) ?></div>
    <?php endif; ?>

    <!-- ✅ WRAP flex : même hauteur + droite un peu plus petite -->
    <div class="row g-4 res-wrap align-items-stretch">

      <!-- GAUCHE (plus large) -->
      <!-- GAUCHE (plus large) -->
<div class="col-lg-7 res-left">
  <div class="card shadow-sm res-card h-100">

    <div class="res-media">

      <?php if ($image !== ""): ?>
        <img src="<?= htmlspecialchars($image) ?>" alt="" class="res-img">
      <?php else: ?>
        <div class="res-noimg">aucune image</div>
      <?php endif; ?>

      <?php if ($titleLeft !== ""): ?>
        <h1 class="res-title-overlay" style="font-weight: bold;"><?= htmlspecialchars($titleLeft) ?></h1>
      <?php endif; ?>

      <!-- ✅ Bouton retour DANS l’image (cliquable) -->
      <div class="res-back-overlay">
  <a href="<?= htmlspecialchars($hrefLeft) ?>"
     class="btn btn-outline-primary btn-sm res-btn">
     retour
  </a>
</div>


    </div>

  </div>
</div>


      <!-- DROITE (un peu plus petit) -->
      <div class="col-lg-5 res-right">
        <div class="card shadow-sm res-card h-100">
          <div class="card-body res-form-body">

            <?php if (!empty($voyage)): ?>

              <h5 class="mb-3">choisissez le nombre de voyageurs</h5>

              <?php if ($bloque): ?>
                <div class="alert alert-info">réservation indisponible pour ce voyage.</div>
              <?php endif; ?>

              <form method="post" action="index.php?page=reservation&id_voyage=<?= (int)$idVoyage ?>">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION["csrf_token"] ?? "") ?>">

                <div class="row g-3">
                  <div class="col-md-12">
                    <label class="form-label">nombre de personnes</label>
                    <input
                      type="number"
                      class="form-control"
                      id="voyage_nb_personnes"
                      name="nb_personnes"
                      min="1"
                      max="<?= max(1, (int)$placesRestantes) ?>"
                      value="<?= (int)$nb_personnes_int ?>"
                      required
                      <?= $bloque ? "disabled" : "" ?>
                    >
                    <div class="form-text"><?= (int)$placesRestantes ?> place(s) restante(s)</div>
                  </div>
                </div>

                <hr class="my-4">

                <div class="d-flex justify-content-between align-items-center">
                  <span class="fs-6">total estimé</span>
                  <span class="fs-4 fw-bold" id="voyage_total">
                    <?= number_format((float)$total_avec_promo, 2, ",", " ") ?> €
                  </span>
                </div>

                <?php if ($reduc > 0 && $economies > 0.01): ?>
                  <div class="text-success small mt-1">
                    vous payez <strong><?= number_format((float)$total_avec_promo, 2, ",", " ") ?> €</strong>
                    au lieu de <s><?= number_format((float)$total_sans_promo, 2, ",", " ") ?> €</s>
                    (économie <?= number_format((float)$economies, 2, ",", " ") ?> €)
                  </div>
                <?php endif; ?>

                <button
                  type="submit"
                  name="confirmer_reservation_voyage"
                  value="1"
                  class="btn res-cta w-100 mt-3"
                  <?= $bloque ? "disabled" : "" ?>
                >
                  confirmer la réservation
                </button>

                <div class="text-muted small text-center mt-2">
                  statut : <strong>en attente</strong>
                </div>
              </form>

            <?php else: ?>

              <?php if (!isset($nb_nuits)) $nb_nuits = 1; ?>

              <h5 class="mb-3">réservation sur mesure</h5>

              <form method="post" action="index.php?page=reservation&id_destination=<?= (int)$idDestination ?>">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION["csrf_token"] ?? "") ?>">

                <div class="row g-3">
                  <div class="col-md-6">
                    <label class="form-label">date de départ</label>
                    <input
                      type="date"
                      class="form-control"
                      id="date_depart"
                      name="date_depart"
                      value="<?= htmlspecialchars($date_depart) ?>"
                      required
                      min="<?= date("Y-m-d") ?>"
                    >
                  </div>

                  <div class="col-md-6">
                    <label class="form-label">date de retour</label>
                    <input
                      type="date"
                      class="form-control"
                      id="date_retour"
                      name="date_retour"
                      value="<?= htmlspecialchars($date_retour) ?>"
                      required
                      min="<?= date("Y-m-d") ?>"
                    >
                  </div>

                  <div class="col-md-12">
                    <label class="form-label">nombre de personnes</label>
                    <input
                      type="number"
                      class="form-control"
                      id="nb_personnes"
                      name="nb_personnes"
                      min="1"
                      value="<?= (int)$nb_personnes_int ?>"
                      required
                    >
                  </div>
                </div>

                <hr class="my-4">

                <div class="text-muted small mb-2" id="dest_info">
                  <strong id="dest_nb_personnes"><?= (int)$nb_personnes_int ?></strong> personne(s) ·
                  <strong id="dest_nb_nuits"><?= (int)$nb_nuits ?></strong> nuit(s)
                </div>

                <div class="d-flex justify-content-between align-items-center">
                  <span class="fs-6">total estimé</span>
                  <span class="fs-4 fw-bold" id="dest_total">
                    <?= number_format((float)$total_avec_promo, 2, ",", " ") ?> €
                  </span>
                </div>

                <div class="text-danger small mt-2 d-none" id="dest_err_date">
                  date de retour invalide (doit être après la date de départ).
                </div>

                <?php if ($reduc > 0 && $economies > 0.01): ?>
                  <div class="text-success small mt-1">
                    vous payez <strong><?= number_format((float)$total_avec_promo, 2, ",", " ") ?> €</strong>
                    au lieu de <s><?= number_format((float)$total_sans_promo, 2, ",", " ") ?> €</s>
                    (économie <?= number_format((float)$economies, 2, ",", " ") ?> €)
                  </div>
                <?php endif; ?>

                <button
                  type="submit"
                  id="btn_confirm_dest"
                  name="confirmer_reservation_destination"
                  value="1"
                  class="btn res-cta w-100 mt-3"
                >
                  confirmer la réservation
                </button>

                <div class="text-muted small text-center mt-2">
                  statut : <strong>en attente</strong>
                </div>
              </form>

            <?php endif; ?>

          </div>
        </div>
      </div>

    </div>
  <?php endif; ?>

  <div id="js_dest" data-prix-unitaire="<?= !empty($destination) ? htmlspecialchars(number_format((float)$prix_unitaire, 2, ".", "")) : "0.00" ?>"></div>
  <div id="js_voyage" data-prix-unitaire="<?= !empty($voyage) ? htmlspecialchars(number_format((float)$prix_unitaire, 2, ".", "")) : "0.00" ?>"></div>

</div>

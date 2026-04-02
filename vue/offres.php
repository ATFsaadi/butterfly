<?php
$offres = $offres ?? [];

/* === Afficher plus (par pas de 9) === */
$step  = 9;
$limit = max($step, (int)($_GET["limit"] ?? $step));

$total = count($offres);
$items = array_slice(array_values($offres), 0, $limit);

/* Conserver les paramètres GET existants (search) */
$params = $_GET;
$params["limit"] = $limit + $step;
$queryMore = http_build_query($params);
?>

<div id="voyageBar">
  <?php require_once __DIR__ . "/components/searchOffres.php"; ?>
</div>

<div class="container mt-4">

  <h3 class="section-title text-center mt-5">Offres en cours</h3>

  <?php if (empty($offres)): ?>
    <div class="alert alert-info">aucune offre trouvée.</div>
  <?php else: ?>

    <div class="row g-3">

      <?php foreach ($items as $o): ?>
        <?php
        $reduc = (int)($o["pourcentage_reduction"] ?? 0);
        $prixBase = (float)($o["prix_base"] ?? 0);
        $prixRemise = $prixBase;

        if ($prixBase > 0 && $reduc > 0) $prixRemise = $prixBase * (1 - ($reduc / 100));

        $idDest = (int)($o["id_destination"] ?? 0);
        $image = (string)($o["image_url"] ?? "");
        $titre = (string)($o["titre"] ?? "");
        $lieu = trim((string)($o["pays"] ?? "") . " - " . (string)($o["ville"] ?? ""), " -");

        $hrefDetail = !empty($_SESSION["user"])
          ? "index.php?page=destination_detail&id_destination=" . $idDest
          : "index.php?page=login&redirect=destination_detail&id_destination=" . $idDest;

        $hrefReserver = !empty($_SESSION["user"])
          ? "index.php?page=reservation&id_destination=" . $idDest
          : "index.php?page=login&redirect=reservation&id_destination=" . $idDest;

        $prixAffiche = ($reduc > 0 ? $prixRemise : $prixBase);
        ?>

        <div class="col-12 col-md-6 col-lg-4">
          <div class="card h-100 grid-card">

            <div class="grid-media">

              <!--   TRIANGLE PROMO -->
              <?php if ($reduc > 0): ?>
                <span class="grid-sale" data-sale="-<?= (int)$reduc ?>%"></span>
              <?php endif; ?>

              <?php if ($image !== ""): ?>
                <img src="<?= htmlspecialchars($image) ?>" class="grid-img" alt="<?= htmlspecialchars($lieu) ?>">
              <?php else: ?>
                <div class="d-flex align-items-center justify-content-center bg-light grid-noimg">
                  <span class="text-muted">aucune image</span>
                </div>
              <?php endif; ?>

              <!--   TITRE SUR IMAGE -->
              <div class="grid-title-overlay">
                <?= htmlspecialchars($titre !== "" ? $titre : $lieu) ?>
              </div>

              <!--   PRIX ANGLE -->
              <?php if ($prixAffiche > 0): ?>
                <span class="grid-price-badge">
                  <?= number_format($prixAffiche, 0, ",", " ") ?> €
                </span>
              <?php endif; ?>

            </div>

            <!--   ACTIONS EN BAS -->
            <div class="card-body grid-body">
              <?php if ($idDest > 0): ?>
                <div class="grid-actions">

                  <a class="btn btn-outline-primary btn-sm grid-btn" href="<?= htmlspecialchars($hrefDetail) ?>">
                    voir détail
                  </a>

                  <a class="btn btn-success btn-sm grid-btn" href="<?= htmlspecialchars($hrefReserver) ?>">
                    réserver
                  </a>

                </div>
              <?php endif; ?>
            </div>

          </div>
        </div>

      <?php endforeach; ?>

    </div>

    <!--   Bouton afficher plus -->
    <?php if ($limit < $total): ?>
      <div class="d-flex justify-content-center mt-4">
        <a class="btn btn-outline-primary btn-sm grid-btn" href="?<?= htmlspecialchars($queryMore) ?>">
          afficher plus
        </a>
      </div>
    <?php endif; ?>

  <?php endif; ?>

</div>

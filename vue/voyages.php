<?php
$voyages = $voyages ?? [];

/* === Afficher plus (par pas de 9) === */
$step  = 9;
$limit = max($step, (int)($_GET["limit"] ?? $step));

$total = count($voyages);
$items = array_slice(array_values($voyages), 0, $limit);

/* Conserver paramètres GET (search) */
$params = $_GET;
$params["limit"] = $limit + $step;
$queryMore = http_build_query($params);
?>

<div id="voyageBar">
  <?php require_once __DIR__ . "/components/searchVoyages.php"; ?>
</div>

<div class="container mt-4">

  <h3 class="section-title text-center mt-5">Voyages organisés</h3>

  <?php if (empty($voyages)): ?>
    <div class="alert alert-info">aucun voyage trouvé.</div>
  <?php else: ?>

    <div class="row g-3">
      <?php foreach ($items as $v): ?>
        <?php
        $id = (int)($v["id_voyage"] ?? 0);
        $titre = (string)($v["titre"] ?? "");
        $prix = (float)($v["prix"] ?? 0);
        $places = (int)($v["nb_places_restantes"] ?? 0);
        $statut = (string)($v["statut"] ?? "");

        $imgVoyage = (string)($v["image_url"] ?? "");
        $imgDest   = (string)($v["destination_image_url"] ?? "");
        $img = $imgVoyage !== "" ? $imgVoyage : $imgDest;

        $pays = (string)($v["pays"] ?? "");
        $ville = (string)($v["ville"] ?? "");
        $lieu = trim($pays . " - " . $ville, " -");
        $alt = trim($titre . " " . $lieu);

        $bloque = ($statut !== "actif" || $places <= 0);
        ?>

        <div class="col-12 col-md-6 col-lg-4">
          <div class="card h-100 grid-card">

            <div class="grid-media">

              <?php if ($img !== ""): ?>
                <img src="<?= htmlspecialchars($img) ?>" class="grid-img" alt="<?= htmlspecialchars($alt) ?>">
              <?php else: ?>
                <div class="d-flex align-items-center justify-content-center bg-light grid-noimg">
                  <span class="text-muted">aucune image</span>
                </div>
              <?php endif; ?>

              <!--   TITRE SUR IMAGE -->
              <div class="grid-title-overlay">
                <?= htmlspecialchars($titre) ?>
              </div>

              <!--   PRIX ANGLE -->
              <?php if ($prix > 0): ?>
                <span class="grid-price-badge">
                  <?= number_format($prix, 0, ",", " ") ?> €
                </span>
              <?php endif; ?>

            </div>

            <!--   ACTIONS EN BAS -->
            <div class="card-body grid-body">

              <div class="grid-actions">

                <?php if (!empty($_SESSION["user"])): ?>
                  <a class="btn btn-outline-primary btn-sm grid-btn"
                     href="index.php?page=voyage_detail&id_voyage=<?= $id ?>">
                    voir détail
                  </a>
                <?php else: ?>
                  <a class="btn btn-outline-primary btn-sm grid-btn"
                     href="index.php?page=login&redirect=voyage_detail&id_voyage=<?= $id ?>">
                    voir détail
                  </a>
                <?php endif; ?>

                <?php if (!$bloque): ?>
                  <?php if (!empty($_SESSION["user"])): ?>
                    <a class="btn btn-success btn-sm grid-btn"
                       href="index.php?page=reservation&id_voyage=<?= $id ?>">
                      réserver
                    </a>
                  <?php else: ?>
                    <a class="btn btn-success btn-sm grid-btn"
                       href="index.php?page=login&redirect=reservation&id_voyage=<?= $id ?>">
                      réserver
                    </a>
                  <?php endif; ?>
                <?php else: ?>
                  <button class="btn btn-secondary btn-sm grid-btn" disabled>
                    non réservable
                  </button>
                <?php endif; ?>

              </div>

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

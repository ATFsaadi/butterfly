<?php
$destinations = $destinations ?? [];

/* === Afficher plus (par pas de 9) === */
$step  = 9;
$limit = max($step, (int)($_GET["limit"] ?? $step));

$total = count($destinations);
$items = array_slice(array_values($destinations), 0, $limit);

/* Conserver paramètres GET (search) */
$params = $_GET;
$params["limit"] = $limit + $step;
$queryMore = http_build_query($params);
?>

<div id="voyageBar">
  <?php require_once __DIR__ . "/components/searchDestinations.php"; ?>
</div>

<div class="container mt-4">

  <h3 class="section-title text-center mt-5">destinations en cours</h3>

  <?php if (empty($destinations)): ?>
    <div class="alert alert-info">aucune destination trouvée.</div>
  <?php else: ?>

    <div class="row g-3">
      <?php foreach ($items as $d): ?>
        <?php
        $id = (int)($d["id_destination"] ?? 0);
        $pays = (string)($d["pays"] ?? "");
        $ville = (string)($d["ville"] ?? "");
        $prixBase = (float)($d["prix_base"] ?? 0);
        $image = (string)($d["image_url"] ?? "");

        $titre = trim($pays . " - " . $ville, " -");
        $alt = trim($pays . " " . $ville);
        ?>

        <div class="col-12 col-md-6 col-lg-4">
          <div class="card h-100 grid-card">

            <div class="grid-media">

              <?php if ($image !== ""): ?>
                <img src="<?= htmlspecialchars($image) ?>" class="grid-img" alt="<?= htmlspecialchars($alt) ?>">
              <?php else: ?>
                <div class="d-flex align-items-center justify-content-center bg-light grid-noimg">
                  <span class="text-muted">aucune image</span>
                </div>
              <?php endif; ?>

              <div class="grid-title-overlay">
                <?= htmlspecialchars($titre) ?>
              </div>

              <?php if ($prixBase > 0): ?>
                <span class="grid-price-badge">
                  <?= number_format($prixBase, 0, ",", " ") ?> €
                </span>
              <?php endif; ?>

            </div>

            <div class="card-body grid-body">

              <?php if ($id > 0): ?>
                <div class="grid-actions">

                  <?php if (!empty($_SESSION["user"])): ?>
                    <a class="btn btn-outline-primary btn-sm grid-btn"
                       href="index.php?page=destination_detail&id_destination=<?= $id ?>">
                      voir détail
                    </a>
                    <a class="btn btn-success btn-sm grid-btn"
                       href="index.php?page=destination_detail&id_destination=<?= $id ?>">
                      réserver
                    </a>
                  <?php else: ?>
                    <a class="btn btn-outline-primary btn-sm grid-btn"
                       href="index.php?page=login&redirect=destination_detail&id_destination=<?= $id ?>">
                      voir détail
                    </a>
                    <a class="btn btn-success btn-sm grid-btn"
                       href="index.php?page=login&redirect=destination_detail&id_destination=<?= $id ?>">
                      réserver
                    </a>
                  <?php endif; ?>

                </div>
              <?php endif; ?>

            </div>

          </div>
        </div>

      <?php endforeach; ?>
    </div>

    <?php if ($limit < $total): ?>
      <div class="d-flex justify-content-center mt-4">
        <a class="btn btn-outline-primary btn-sm grid-btn" href="?<?= htmlspecialchars($queryMore) ?>">
          afficher plus
        </a>
      </div>
    <?php endif; ?>

  <?php endif; ?>

</div>

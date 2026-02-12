<?php if (!empty($offres)): ?>

<h3 class="section-title text-center mt-5">Nos offres</h3>
<p class="section-subtitle text-center mb-4">Meilleures offres pour vos aventures</p>

<div id="offresCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="6000">

  <div class="carousel-indicators">
    <?php $nbSlides = (int)ceil(count($offres) / 2); ?>
    <?php for ($k = 0; $k < $nbSlides; $k++): ?>
      <button
        type="button"
        data-bs-target="#offresCarousel"
        data-bs-slide-to="<?= (int)$k ?>"
        class="<?= $k === 0 ? "active" : "" ?>"
        aria-current="<?= $k === 0 ? "true" : "false" ?>"
        aria-label="Slide <?= (int)($k + 1) ?>"
      ></button>
    <?php endfor; ?>
  </div>

  <div class="carousel-inner">
    <?php
    $offresList = array_values($offres);
    $total = count($offresList);
    $slideIndex = 0;

    for ($j = 0; $j < $total; $j += 2):
      $isActive = ($slideIndex === 0) ? "active" : "";
      $slideIndex++;

      $pair = [$offresList[$j]];
      if ($j + 1 < $total) $pair[] = $offresList[$j + 1];
    ?>
      <div class="carousel-item <?= $isActive ?>">
        <div class="row g-3 justify-content-center">

          <?php foreach ($pair as $offre): ?>
            <?php
            $reduc = (int)($offre["pourcentage_reduction"] ?? 0);
            $prixBase = (float)($offre["prix_base"] ?? 0);
            $prixRemise = $prixBase;

            if ($prixBase > 0 && $reduc > 0 && $reduc <= 100) {
              $prixRemise = $prixBase * (1 - ($reduc / 100));
            }

            $img = (string)($offre["image_url"] ?? "");
            $titre = (string)($offre["titre"] ?? "offre");
            $pays = (string)($offre["pays"] ?? "");
            $ville = (string)($offre["ville"] ?? "");
            $dateDebut = (string)($offre["date_debut"] ?? "");
            $dateFin = (string)($offre["date_fin"] ?? "");
            $idDestination = (int)($offre["id_destination"] ?? 0);

            $lieu = trim($pays . " - " . $ville, " -");

            $href = "index.php?page=offres";
            if ($idDestination > 0) {
              if (!empty($_SESSION["user"])) {
                $href = "index.php?page=destination_detail&id_destination=" . (int)$idDestination;
              } else {
                $href = "index.php?page=login&redirect=destination_detail&id_destination=" . (int)$idDestination;
              }
            }
            ?>

            <div class="col-12 col-md-6">
              <a href="<?= htmlspecialchars($href) ?>" class="offer-card">
                <div class="offer-media">
                  <?php if ($reduc > 0): ?>
                    <span class="offer-badge" data-badge="-<?= (int)$reduc ?>%"></span>
                  <?php endif; ?>

                  <?php if ($img !== ""): ?>
                    <img src="<?= htmlspecialchars($img) ?>" alt="<?= htmlspecialchars($titre) ?>">
                  <?php else: ?>
                    <div class="offer-noimg">image non disponible</div>
                  <?php endif; ?>
                </div>

                <div class="offer-body">

  <div class="offer-title"><?= htmlspecialchars($titre) ?></div>

  <div class="offer-info">

    <?php if ($lieu !== ""): ?>
      <div class="offer-line">
        <svg viewBox="0 0 24 24" width="15" height="15" class="offer-icon">
          <path d="M12 2C8 2 5 5 5 9c0 5 7 13 7 13s7-8 7-13c0-4-3-7-7-7zm0 9.5A2.5 2.5 0 1 1 12 6a2.5 2.5 0 0 1 0 5.5z"/>
        </svg>
        <span><?= htmlspecialchars($lieu) ?></span>
      </div>
    <?php endif; ?>

    <?php if ($dateDebut !== "" || $dateFin !== ""): ?>
      <div class="offer-line">
        <svg viewBox="0 0 24 24" width="15" height="15" class="offer-icon">
          <path d="M7 2v2H5a2 2 0 0 0-2 2v2h18V6a2 2 0 0 0-2-2h-2V2h-2v2H9V2H7zm14 8H3v10a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V10z"/>
        </svg>
        <span>du <?= htmlspecialchars($dateDebut) ?> au <?= htmlspecialchars($dateFin) ?></span>
      </div>
    <?php endif; ?>

  </div>

  <?php if ($prixBase > 0): ?>
    <div class="offer-price">
      <?php if ($reduc > 0): ?>
        <del><?= number_format($prixBase, 2, ",", " ") ?> €</del>
        <strong><?= number_format($prixRemise, 2, ",", " ") ?> €</strong>
      <?php else: ?>
        <strong><?= number_format($prixBase, 2, ",", " ") ?> €</strong>
      <?php endif; ?>
    </div>
  <?php endif; ?>

</div>

              </a>
            </div>

          <?php endforeach; ?>

        </div>
      </div>
    <?php endfor; ?>
  </div>

  <button class="carousel-control-prev" type="button" data-bs-target="#offresCarousel" data-bs-slide="prev">
    <span class="carousel-control-prev-icon"></span>
    <span class="visually-hidden">Précédent</span>
  </button>

  <button class="carousel-control-next" type="button" data-bs-target="#offresCarousel" data-bs-slide="next">
    <span class="carousel-control-next-icon"></span>
    <span class="visually-hidden">Suivant</span>
  </button>

</div>

<?php endif; ?>

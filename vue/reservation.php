<?php

/* valeurs par defaut */
$errors  = $errors ?? [];
$success = $success ?? "";
$voyage  = $voyage ?? null;
$offre   = $offre ?? null;

/* verification voyage */
if (!$voyage): ?>
    <div class="container py-5">
        <div class="alert alert-danger">Voyage introuvable.</div>
    </div>
<?php return; endif; ?>

<?php

/* valeurs formulaire (si post echoue) */
$adultes = isset($_POST['adultes']) ? (int) $_POST['adultes'] : 1;
$enfants = isset($_POST['enfants']) ? (int) $_POST['enfants'] : 0;
$bebes   = isset($_POST['bebes'])   ? (int) $_POST['bebes']   : 0;

/* reduction si offre */
$reduc = $offre ? (int) ($offre['reduction'] ?? 0) : 0;
$coef  = (100 - $reduc) / 100;

/* prix unitaires apres reduction */
$pu_adulte = (float) ($voyage['prix_adulte'] ?? 0) * $coef;
$pu_enfant = (float) ($voyage['prix_enfant'] ?? 0) * $coef;
$pu_bebe   = (float) ($voyage['prix_bebe']   ?? 0) * $coef;

/* total estime (preview) */
$total = ($adultes * $pu_adulte) + ($enfants * $pu_enfant) + ($bebes * $pu_bebe);
$total = round($total, 2);

/* total sans reduction (pour economie) */
$pu_adulte_base = (float) ($voyage['prix_adulte'] ?? 0);
$pu_enfant_base = (float) ($voyage['prix_enfant'] ?? 0);
$pu_bebe_base   = (float) ($voyage['prix_bebe']   ?? 0);

$total_base = ($adultes * $pu_adulte_base)
            + ($enfants * $pu_enfant_base)
            + ($bebes * $pu_bebe_base);

$total_base = round($total_base, 2);
$economie   = round($total_base - $total, 2);

?>

<!-- page reservation -->
<div class="container py-5">

    <!-- titre page -->
    <h2 class="section-title text-center mb-4">Réservation</h2>

    <!-- bloc erreurs -->
    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <?php foreach ($errors as $e): ?>
                <div><?= htmlspecialchars((string) $e) ?></div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <!-- bloc success -->
    <?php if (!empty($success)): ?>
        <div class="alert alert-success">
            <?= htmlspecialchars((string) $success) ?>
        </div>
    <?php endif; ?>

    <!-- grille contenu -->
    <div class="row g-4 align-items-start">

        <!-- recap voyage -->
        <div class="col-lg-6">
            <div class="card shadow-sm">

                <!-- image voyage -->
                <?php if (!empty($voyage['image'])): ?>
                    <img
                        src="images/voyages/<?= htmlspecialchars((string) $voyage['image']) ?>"
                        alt="<?= htmlspecialchars((string) ($voyage['titre'] ?? 'Voyage')) ?>"
                        class="card-img-top"
                        style="height:260px; object-fit:cover;"
                    >
                <?php endif; ?>

                <!-- infos voyage -->
                <div class="card-body">

                    <!-- titre voyage -->
                    <h4 class="mb-1"><?= htmlspecialchars((string) ($voyage['titre'] ?? '')) ?></h4>

                    <!-- destination -->
                    <div class="text-muted mb-3">
                        <?= htmlspecialchars((string) ($voyage['destination_nom'] ?? '')) ?>
                    </div>

                    <!-- dates -->
                    <div class="small mb-3">
                        <div>📅 Départ : <strong><?= htmlspecialchars((string) ($voyage['date_depart'] ?? '')) ?></strong></div>
                        <div>📅 Retour : <strong><?= htmlspecialchars((string) ($voyage['date_retour'] ?? '')) ?></strong></div>
                    </div>

                    <!-- offre appliquee -->
                    <?php if ($offre): ?>
                        <div class="alert alert-warning py-2 mb-3">
                            Offre appliquée : <strong><?= htmlspecialchars((string) ($offre['titre'] ?? '')) ?></strong>
                            — <strong>-<?= (int) $reduc ?>%</strong>
                        </div>
                    <?php endif; ?>

                    <!-- prix unitaires -->
                    <div class="small">
                        <div>Adulte : <strong><?= number_format((float) $pu_adulte, 2, ',', ' ') ?> €</strong></div>
                        <div>Enfant : <strong><?= number_format((float) $pu_enfant, 2, ',', ' ') ?> €</strong></div>
                        <div>Bébé : <strong><?= number_format((float) $pu_bebe, 2, ',', ' ') ?> €</strong></div>
                    </div>

                </div>
            </div>
        </div>

        <!-- formulaire reservation -->
        <div class="col-lg-6">
            <div class="card shadow-sm">
                <div class="card-body">

                    <!-- titre formulaire -->
                    <h5 class="mb-3">Choisissez le nombre de voyageurs</h5>

                    <!-- formulaire -->
                    <form method="POST"
                          action="index.php?page=reservation&id=<?= (int) ($voyage['id_voyage'] ?? 0) ?><?= $offre ? '&offre='.(int) ($offre['id_offre'] ?? $offre['idoffre'] ?? 0) : '' ?>">

                        <!-- input hidden offre -->
                        <?php if ($offre): ?>
                            <input type="hidden" name="offre"
                                   value="<?= (int) ($offre['id_offre'] ?? $offre['idoffre'] ?? 0) ?>">
                        <?php endif; ?>

                        <!-- champs voyageurs -->
                        <div class="row g-3">

                            <!-- adultes -->
                            <div class="col-md-4">
                                <label class="form-label">Adultes</label>
                                <input type="number" name="adultes" id="adultes" class="form-control"
                                       min="1" value="<?= (int) $adultes ?>" required
                                       data-prix="<?= htmlspecialchars((string) $pu_adulte) ?>">
                            </div>

                            <!-- enfants -->
                            <div class="col-md-4">
                                <label class="form-label">Enfants</label>
                                <input type="number" name="enfants" id="enfants" class="form-control"
                                       min="0" value="<?= (int) $enfants ?>"
                                       data-prix="<?= htmlspecialchars((string) $pu_enfant) ?>">
                            </div>

                            <!-- bebes -->
                            <div class="col-md-4">
                                <label class="form-label">Bébés</label>
                                <input type="number" name="bebes" id="bebes" class="form-control"
                                       min="0" value="<?= (int) $bebes ?>"
                                       data-prix="<?= htmlspecialchars((string) $pu_bebe) ?>">
                            </div>

                        </div>

                        <!-- separation -->
                        <hr class="my-4">

                        <!-- total preview -->
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fs-6">Total estimé</span>
                            <span class="fs-4 fw-bold" id="totalPreview">
                                <?= number_format((float) $total, 2, ',', ' ') ?> €
                            </span>
                        </div>

                        <!-- economie -->
                        <?php if ($offre && $economie > 0): ?>
                            <div class="text-success small mt-1">
                                Vous payez <strong><?= number_format((float) $total, 2, ',', ' ') ?> €</strong>
                                au lieu de <s><?= number_format((float) $total_base, 2, ',', ' ') ?> €</s>
                                (économie <?= number_format((float) $economie, 2, ',', ' ') ?> €)
                            </div>
                        <?php endif; ?>

                        <!-- bouton submit -->
                        <button type="submit" name="submit_reservation" class="btn btn-primary w-100 mt-3 py-3">
                            Confirmer la réservation
                        </button>

                        <!-- info statut -->
                        <div class="text-muted small text-center mt-2">
                            Statut : <strong>en attente</strong>
                        </div>

                    </form>

                </div>
            </div>
        </div>

    </div>
</div>

<!-- script preview total -->
<script>
(function () {
  const adultes = document.getElementById('adultes');
  const enfants = document.getElementById('enfants');
  const bebes   = document.getElementById('bebes');
  const totalEl = document.getElementById('totalPreview');

  function toNumber(v) {
    const n = parseInt(v, 10);
    return Number.isFinite(n) ? n : 0;
  }

  function formatEuro(n) {
    return n.toLocaleString('fr-FR', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + ' €';
  }

  function calc() {
    const a = Math.max(1, toNumber(adultes.value));
    const e = Math.max(0, toNumber(enfants.value));
    const b = Math.max(0, toNumber(bebes.value));

    /* force adultes >= 1 */
    if (adultes.value !== String(a)) adultes.value = a;

    const pa = parseFloat(adultes.dataset.prix || '0') || 0;
    const pe = parseFloat(enfants.dataset.prix || '0') || 0;
    const pb = parseFloat(bebes.dataset.prix || '0') || 0;

    const total = (a * pa) + (e * pe) + (b * pb);
    totalEl.textContent = formatEuro(Math.round(total * 100) / 100);
  }

  ['input', 'change'].forEach(evt => {
    adultes.addEventListener(evt, calc);
    enfants.addEventListener(evt, calc);
    bebes.addEventListener(evt, calc);
  });

  /* init */
  calc();
})();
</script>

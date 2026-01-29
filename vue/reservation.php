<?php
$errors  = $errors ?? [];
$success = $success ?? "";
$voyage  = $voyage ?? null;
$offre   = $offre ?? null;

if (!$voyage): ?>
    <div class="container py-5">
        <div class="alert alert-danger">Voyage introuvable.</div>
    </div>
<?php return; endif; ?>

<?php
// Valeurs par défaut (affichage + si POST échoue)
$adultes = isset($_POST['adultes']) ? (int)$_POST['adultes'] : 1;
$enfants = isset($_POST['enfants']) ? (int)$_POST['enfants'] : 0;
$bebes   = isset($_POST['bebes']) ? (int)$_POST['bebes'] : 0;

// Réduction si offre
$reduc = $offre ? (int)($offre['reduction'] ?? 0) : 0;
$coef  = (100 - $reduc) / 100;

// Prix unitaires après réduction
$pu_adulte = (float)$voyage['prix_adulte'] * $coef;
$pu_enfant = (float)$voyage['prix_enfant'] * $coef;
$pu_bebe   = (float)$voyage['prix_bebe']   * $coef;

// Total (preview)
$total = ($adultes * $pu_adulte) + ($enfants * $pu_enfant) + ($bebes * $pu_bebe);
$total = round($total, 2);

$pu_adulte_base = (float)$voyage['prix_adulte'];
$pu_enfant_base = (float)$voyage['prix_enfant'];
$pu_bebe_base   = (float)$voyage['prix_bebe'];

$total_base = ($adultes * $pu_adulte_base)
            + ($enfants * $pu_enfant_base)
            + ($bebes * $pu_bebe_base);

$total_base = round($total_base, 2);

$economie = round($total_base - $total, 2);
?>

<div class="container py-5">

    <h2 class="section-title text-center mb-4">Réservation</h2>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <?php foreach ($errors as $e): ?>
                <div><?= htmlspecialchars($e) ?></div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <div class="alert alert-success">
            <?= htmlspecialchars($success) ?>
        </div>
    <?php endif; ?>

    <div class="row g-4 align-items-start">

        <!-- Récap voyage -->
        <div class="col-lg-6">
            <div class="card shadow-sm">
                <?php if (!empty($voyage['image'])): ?>
                    <img src="images/voyages/<?= htmlspecialchars((string)$voyage['image']) ?>"
                         alt="<?= htmlspecialchars((string)$voyage['titre']) ?>"
                         class="card-img-top"
                         style="height:260px; object-fit:cover;">
                <?php endif; ?>

                <div class="card-body">
                    <h4 class="mb-1"><?= htmlspecialchars((string)$voyage['titre']) ?></h4>
                    <div class="text-muted mb-3">
                        <?= htmlspecialchars((string)($voyage['destination_nom'] ?? '')) ?>
                    </div>

                    <div class="small mb-3">
                        <div>📅 Départ : <strong><?= htmlspecialchars((string)($voyage['date_depart'] ?? '')) ?></strong></div>
                        <div>📅 Retour : <strong><?= htmlspecialchars((string)($voyage['date_retour'] ?? '')) ?></strong></div>
                    </div>

                    <?php if ($offre): ?>
                        <div class="alert alert-warning py-2 mb-3">
                            Offre appliquée : <strong><?= htmlspecialchars((string)$offre['titre']) ?></strong>
                            — <strong>-<?= (int)$reduc ?>%</strong>
                        </div>
                    <?php endif; ?>

                    <div class="small">
                        <div>Adulte : <strong><?= number_format($pu_adulte, 2, ',', ' ') ?> €</strong></div>
                        <div>Enfant : <strong><?= number_format($pu_enfant, 2, ',', ' ') ?> €</strong></div>
                        <div>Bébé : <strong><?= number_format($pu_bebe, 2, ',', ' ') ?> €</strong></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form réservation -->
        <div class="col-lg-6">
            <div class="card shadow-sm">
                <div class="card-body">

                    <h5 class="mb-3">Choisissez le nombre de voyageurs</h5>

                    <form method="POST" action="index.php?page=reservation&id=<?= (int)$voyage['id_voyage'] ?><?= $offre ? '&offre='.(int)($offre['id_offre'] ?? $offre['idoffre'] ?? 0) : '' ?>">
                        <!-- si tu veux garder l'info offre dans l'URL après POST -->
                        <?php if ($offre): ?>
                            <input type="hidden" name="offre" value="<?= (int)($offre['id_offre'] ?? $offre['idoffre'] ?? 0) ?>">

                        <?php endif; ?>

                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">Adultes</label>
                               <input type="number" name="adultes" id="adultes" class="form-control"
                                    min="1" value="<?= (int)$adultes ?>" required
                                    data-prix="<?= htmlspecialchars((string)$pu_adulte) ?>">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Enfants</label>
                                <input type="number" name="enfants" id="enfants" class="form-control"
                                    min="0" value="<?= (int)$enfants ?>"
                                    data-prix="<?= htmlspecialchars((string)$pu_enfant) ?>">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Bébés</label>
                               <input type="number" name="bebes" id="bebes" class="form-control"
                                    min="0" value="<?= (int)$bebes ?>"
                                    data-prix="<?= htmlspecialchars((string)$pu_bebe) ?>">
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-between align-items-center">
                        <span class="fs-6">Total estimé</span>
                        <span class="fs-4 fw-bold" id="totalPreview"><?= number_format($total, 2, ',', ' ') ?> €</span>
                        </div>

                        <?php if ($offre && $economie > 0): ?>
                        <div class="text-success small mt-1">
                            Vous payez <strong><?= number_format($total, 2, ',', ' ') ?> €</strong>
                            au lieu de <s><?= number_format($total_base, 2, ',', ' ') ?> €</s>
                            (économie <?= number_format($economie, 2, ',', ' ') ?> €)
                        </div>
                        <?php endif; ?>

                        <button type="submit" name="submit_reservation"
                                class="btn btn-primary w-100 mt-3 py-3">
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
</div>
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
    // format FR: 1 234,56 €
    return n.toLocaleString('fr-FR', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + ' €';
  }

  function calc() {
    const a = Math.max(1, toNumber(adultes.value));
    const e = Math.max(0, toNumber(enfants.value));
    const b = Math.max(0, toNumber(bebes.value));

    // force l’input adultes >= 1
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

  calc(); // init
})();
</script>

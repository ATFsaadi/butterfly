<?php
$errors  = $errors ?? [];
$success = $success ?? "";
$destination = $destination ?? null;
$offre = $offre ?? null;

if (!$destination): ?>
    <div class="container py-5">
        <div class="alert alert-danger">Destination introuvable.</div>
    </div>
<?php return; endif; ?>

<?php
$nb_personnes = isset($_POST['nb_personnes']) ? max(1, (int)$_POST['nb_personnes']) : 1;

$prix_base = (float) ($destination['prix_base'] ?? 0);
$prix_unitaire = (float) ($prix_unitaire ?? $prix_base);

$reduc = $offre ? (int)($offre['pourcentage_reduction'] ?? 0) : 0;

$total = round($nb_personnes * $prix_unitaire, 2);
$total_base = round($nb_personnes * $prix_base, 2);
$economie = round($total_base - $total, 2);

$date_depart = $_POST['date_depart'] ?? '';
$date_retour = $_POST['date_retour'] ?? '';
?>

<div class="container py-5">

    <h2 class="section-title text-center mb-4">Réservation</h2>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <?php foreach ($errors as $e): ?>
                <div><?= htmlspecialchars((string) $e) ?></div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <div class="alert alert-success">
            <?= htmlspecialchars((string) $success) ?>
        </div>
    <?php endif; ?>

    <div class="row g-4 align-items-start">

        <!-- recap destination -->
        <div class="col-lg-6">
            <div class="card shadow-sm">

                <?php if (!empty($destination['image_url'])): ?>
                    <img
                        src="images/destinations/<?= htmlspecialchars((string) $destination['image_url']) ?>"
                        alt="<?= htmlspecialchars((string) ($destination['ville'] ?? 'Destination')) ?>"
                        class="card-img-top"
                        style="height:260px; object-fit:cover;"
                    >
                <?php endif; ?>

                <div class="card-body">

                    <h4 class="mb-1">
                        <?= htmlspecialchars((string) ($destination['ville'] ?? '')) ?>
                        <?php if (!empty($destination['pays'])): ?>
                            — <?= htmlspecialchars((string) $destination['pays']) ?>
                        <?php endif; ?>
                    </h4>

                    <?php if (!empty($destination['continent'])): ?>
                        <div class="text-muted mb-3">
                            <?= htmlspecialchars((string) $destination['continent']) ?>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($destination['description'])): ?>
                        <p class="card-text">
                            <?= nl2br(htmlspecialchars((string) $destination['description'])) ?>
                        </p>
                    <?php endif; ?>

                    <?php if ($offre): ?>
                        <div class="alert alert-warning py-2 mb-3">
                            Offre appliquée : <strong><?= htmlspecialchars((string) ($offre['titre'] ?? '')) ?></strong>
                            — <strong>-<?= (int) $reduc ?>%</strong>
                        </div>
                    <?php endif; ?>

                    <div class="small">
                        <div>Prix de base : <strong><?= number_format($prix_base, 2, ',', ' ') ?> €</strong></div>
                        <div>Prix unitaire (promo) : <strong><?= number_format($prix_unitaire, 2, ',', ' ') ?> €</strong></div>
                    </div>

                </div>
            </div>
        </div>

        <!-- formulaire -->
        <div class="col-lg-6">
            <div class="card shadow-sm">
                <div class="card-body">

                    <h5 class="mb-3">Choisissez vos dates et le nombre de voyageurs</h5>

                    <form method="POST"
                          action="index.php?page=reservation&id=<?= (int) ($destination['id_destination'] ?? 0) ?>">

                        <div class="row g-3">

                            <div class="col-md-6">
                                <label class="form-label">Date départ</label>
                                <input type="date" name="date_depart" class="form-control" required
                                       value="<?= htmlspecialchars((string)$date_depart) ?>">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Date retour</label>
                                <input type="date" name="date_retour" class="form-control" required
                                       value="<?= htmlspecialchars((string)$date_retour) ?>">
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Nombre de personnes</label>
                                <input type="number" name="nb_personnes" id="nb_personnes" class="form-control"
                                       min="1" value="<?= (int)$nb_personnes ?>" required
                                       data-prix="<?= htmlspecialchars((string)$prix_unitaire) ?>"
                                       data-prix-base="<?= htmlspecialchars((string)$prix_base) ?>">
                            </div>

                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fs-6">Total estimé</span>
                            <span class="fs-4 fw-bold" id="totalPreview">
                                <?= number_format((float) $total, 2, ',', ' ') ?> €
                            </span>
                        </div>

                        <?php if ($offre && $economie > 0): ?>
                            <div class="text-success small mt-1" id="economiePreview">
                                Vous payez <strong><?= number_format((float) $total, 2, ',', ' ') ?> €</strong>
                                au lieu de <s><?= number_format((float) $total_base, 2, ',', ' ') ?> €</s>
                                (économie <?= number_format((float) $economie, 2, ',', ' ') ?> €)
                            </div>
                        <?php endif; ?>

                        <button type="submit" name="submit_reservation" class="btn btn-primary w-100 mt-3 py-3">
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
  const nb = document.getElementById('nb_personnes');
  const totalEl = document.getElementById('totalPreview');

  function toNumber(v) {
    const n = parseInt(v, 10);
    return Number.isFinite(n) ? n : 0;
  }

  function formatEuro(n) {
    return n.toLocaleString('fr-FR', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + ' €';
  }

  function calc() {
    const q = Math.max(1, toNumber(nb.value));
    if (nb.value !== String(q)) nb.value = q;

    const pu = parseFloat(nb.dataset.prix || '0') || 0;
    const total = q * pu;

    totalEl.textContent = formatEuro(Math.round(total * 100) / 100);
  }

  ['input', 'change'].forEach(evt => nb.addEventListener(evt, calc));
  calc();
})();
</script>

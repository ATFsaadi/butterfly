<?php
if (!isset($offres)) $offres = [];
if (!isset($offreToEdit)) $offreToEdit = null;
if (!isset($destinations)) $destinations = [];
?>

<h3 class="section-title text-center mt-5">Gestion des Offres</h3>

<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <?php foreach ($errors as $err): ?>
            <p><?= htmlspecialchars((string) $err) ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<form action="" method="POST" class="mb-4">

    <input type="hidden" name="id_offre"
           value="<?= htmlspecialchars((string) ($offreToEdit['id_offre'] ?? '')) ?>">

    <input type="text" name="titre" class="form-control mb-2" placeholder="Titre offre"
           required value="<?= htmlspecialchars((string) ($offreToEdit['titre'] ?? '')) ?>">

    <input type="number" name="pourcentage_reduction" class="form-control mb-2" placeholder="Réduction (%)"
           min="1" max="100" required
           value="<?= htmlspecialchars((string) ($offreToEdit['pourcentage_reduction'] ?? '')) ?>">

    <div class="row">
        <div class="col-md-6">
            <label>Date début</label>
            <input type="date" name="date_debut" class="form-control mb-2"
                   value="<?= htmlspecialchars((string) ($offreToEdit['date_debut'] ?? '')) ?>" required>
        </div>

        <div class="col-md-6">
            <label>Date fin</label>
            <input type="date" name="date_fin" class="form-control mb-2"
                   value="<?= htmlspecialchars((string) ($offreToEdit['date_fin'] ?? '')) ?>" required>
        </div>
    </div>

    <label>Destination</label>
    <select name="id_destination" class="form-control mb-2" required>
        <option value="">-- Choisir une destination --</option>

        <?php foreach ($destinations as $d): ?>
            <?php
                $selected = '';
                if (!empty($offreToEdit['id_destination']) && (int)$offreToEdit['id_destination'] === (int)$d['id_destination']) {
                    $selected = 'selected';
                }
                $label = trim(($d['ville'] ?? '') . ' — ' . ($d['pays'] ?? ''));
            ?>
            <option value="<?= (int)$d['id_destination'] ?>" <?= $selected ?>>
                <?= htmlspecialchars($label) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <div class="form-check mb-2">
        <input class="form-check-input" type="checkbox" name="actif" id="actif"
            <?= (empty($offreToEdit) || (int)($offreToEdit['actif'] ?? 0) === 1) ? 'checked' : '' ?>>
        <label class="form-check-label" for="actif">Offre active</label>
    </div>

    <div class="d-flex justify-content-center">
        <button type="submit" name="submit" class="btn btn-primary">
            <?= $offreToEdit ? "Modifier l'offre" : "Ajouter l'offre" ?>
        </button>
    </div>
</form>

<hr>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Titre</th>
            <th>Réduction</th>
            <th>Dates</th>
            <th>Destination</th>
            <th>Actif</th>
            <th>Actions</th>
        </tr>
    </thead>

    <tbody>
        <?php if (!empty($offres)): ?>
            <?php foreach ($offres as $o): ?>
                <?php
                    $destLabel = trim(($o['ville'] ?? '') . ' — ' . ($o['pays'] ?? ''));
                ?>
                <tr>
                    <td><?= htmlspecialchars((string) ($o['titre'] ?? '')) ?></td>
                    <td><?= (int) ($o['pourcentage_reduction'] ?? 0) ?>%</td>
                    <td>
                        <?= htmlspecialchars((string) ($o['date_debut'] ?? '')) ?>
                        → <?= htmlspecialchars((string) ($o['date_fin'] ?? '')) ?>
                    </td>
                    <td><?= htmlspecialchars($destLabel) ?></td>
                    <td><?= ((int) ($o['actif'] ?? 0) === 1) ? 'Oui' : 'Non' ?></td>
                    <td>
                        <a class="btn btn-warning btn-sm"
                           href="index.php?page=admin_offres&edit=<?= (int) $o['id_offre'] ?>">Modifier</a>

                        <a class="btn btn-danger btn-sm"
                           href="index.php?page=admin_offres&delete=<?= (int) $o['id_offre'] ?>"
                           onclick="return confirm('Supprimer cette offre ?');">Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="6">Aucune offre</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

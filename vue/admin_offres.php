<?php
if (!isset($offres)) $offres = [];
if (!isset($offreToEdit)) $offreToEdit = null;
if (!isset($voyages)) $voyages = [];
?>

<h2>Gestion des Offres</h2>

<?php if (!empty($errors)): ?>
<div class="alert alert-danger">
    <?php foreach ($errors as $err) echo "<p>$err</p>"; ?>
</div>
<?php endif; ?>

<form action="" method="POST" class="mb-4">
    <input type="hidden" name="id_offre" value="<?= $offreToEdit['id_offre'] ?? '' ?>">

    <input type="text" name="titre" class="form-control mb-2" placeholder="Titre offre"
           required value="<?= htmlspecialchars($offreToEdit['titre'] ?? '') ?>">

    <input type="number" name="reduction" class="form-control mb-2" placeholder="Réduction (%)"
           min="0" max="100" value="<?= htmlspecialchars($offreToEdit['reduction'] ?? '0') ?>">

    <div class="row">
        <div class="col-md-6">
            <label>Date début</label>
            <input type="date" name="date_debut" class="form-control mb-2"
                   value="<?= htmlspecialchars($offreToEdit['date_debut'] ?? '') ?>" required>
        </div>
        <div class="col-md-6">
            <label>Date fin</label>
            <input type="date" name="date_fin" class="form-control mb-2"
                   value="<?= htmlspecialchars($offreToEdit['date_fin'] ?? '') ?>" required>
        </div>
    </div>

    <label>Voyage</label>
    <select name="id_voyage" class="form-control mb-2" required>
        <option value="">-- Choisir un voyage --</option>
        <?php foreach ($voyages as $v): ?>
            <option value="<?= (int)$v['id_voyage'] ?>"
                <?= (!empty($offreToEdit['id_voyage']) && (int)$offreToEdit['id_voyage'] === (int)$v['id_voyage']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($v['titre']) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <div class="form-check mb-2">
        <input class="form-check-input" type="checkbox" name="actif" id="actif"
               <?= (!isset($offreToEdit) || empty($offreToEdit)) ? 'checked' : ((int)($offreToEdit['actif'] ?? 0) === 1 ? 'checked' : '') ?>>
        <label class="form-check-label" for="actif">Offre active</label>
    </div>

    <button type="submit" name="submit" class="btn btn-primary">
        <?= $offreToEdit ? "Modifier l'offre" : "Ajouter l'offre" ?>
    </button>
</form>

<hr>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Titre</th>
            <th>Réduction</th>
            <th>Dates</th>
            <th>Voyage</th>
            <th>Actif</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php if (!empty($offres)): ?>
        <?php foreach ($offres as $o): ?>
            <tr>
                <td><?= htmlspecialchars($o['titre']) ?></td>
                <td><?= (int)$o['reduction'] ?>%</td>
                <td><?= htmlspecialchars($o['date_debut']) ?> → <?= htmlspecialchars($o['date_fin']) ?></td>
                <td><?= htmlspecialchars($o['voyage_titre'] ?? '') ?></td>
                <td><?= ((int)$o['actif'] === 1) ? 'Oui' : 'Non' ?></td>
                <td>
                    <a class="btn btn-warning btn-sm" href="index.php?page=admin_offres&edit=<?= (int)$o['id_offre'] ?>">Modifier</a>
                    <a class="btn btn-danger btn-sm" href="index.php?page=admin_offres&delete=<?= (int)$o['id_offre'] ?>"
                       onclick="return confirm('Supprimer cette offre ?');">Supprimer</a>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr><td colspan="6">Aucune offre</td></tr>
    <?php endif; ?>
    </tbody>
</table>

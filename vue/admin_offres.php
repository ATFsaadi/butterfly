<?php

if (!isset($offres)) $offres = [];
if (!isset($offreToEdit)) $offreToEdit = null;
if (!isset($voyages)) $voyages = [];
?>

<h3 class="section-title text-center mt-5">Gestion des Offres</h3>

<!-- erreurs -->
<?php if (!empty($errors)): ?>
<div class="alert alert-danger">
    <?php foreach ($errors as $err) echo "<p>$err</p>"; ?>
</div>
<?php endif; ?>

<!-- formulaire -->
<form action="" method="POST" class="mb-4">

    <!-- id -->
    <input type="hidden" name="id_offre" value="<?= $offreToEdit['id_offre'] ?? '' ?>">

    <!-- titre -->
    <input type="text" name="titre" class="form-control mb-2" placeholder="Titre offre"
           required value="<?= htmlspecialchars($offreToEdit['titre'] ?? '') ?>">

    <!-- reduction -->
    <input type="number" name="reduction" class="form-control mb-2" placeholder="Réduction (%)"
           min="0" max="100" value="<?= htmlspecialchars($offreToEdit['reduction'] ?? '') ?>">

    <!-- dates -->
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

    <!-- voyage -->
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

    <!-- actif -->
    <div class="form-check mb-2">
        <input class="form-check-input" type="checkbox" name="actif" id="actif"
               <?= (!isset($offreToEdit) || empty($offreToEdit)) ? 'checked' : ((int)($offreToEdit['actif'] ?? 0) === 1 ? 'checked' : '') ?>>
        <label class="form-check-label" for="actif">Offre active</label>
    </div>

    <!-- action -->
    <button type="submit" name="submit" class="btn btn-primary">
        <?= $offreToEdit ? "Modifier l'offre" : "Ajouter l'offre" ?>
    </button>
</form>

<!-- separation -->
<hr>

<!-- liste offres -->
<table class="table table-bordered">

    <!-- entete -->
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

    <!-- contenu -->
    <tbody>
    <?php if (!empty($offres)): ?>

        <?php foreach ($offres as $o): ?>
            <tr>

                <!-- titre -->
                <td><?= htmlspecialchars($o['titre']) ?></td>

                <!-- reduction -->
                <td><?= (int)$o['reduction'] ?>%</td>

                <!-- dates -->
                <td><?= htmlspecialchars($o['date_debut']) ?> → <?= htmlspecialchars($o['date_fin']) ?></td>

                <!-- voyage -->
                <td><?= htmlspecialchars($o['voyage_titre'] ?? '') ?></td>

                <!-- actif -->
                <td><?= ((int)$o['actif'] === 1) ? 'Oui' : 'Non' ?></td>

                <!-- actions -->
                <td>
                    <a class="btn btn-warning btn-sm" href="index.php?page=admin_offres&edit=<?= (int)$o['id_offre'] ?>">Modifier</a>
                    <a class="btn btn-danger btn-sm" href="index.php?page=admin_offres&delete=<?= (int)$o['id_offre'] ?>"
                       onclick="return confirm('Supprimer cette offre ?');">Supprimer</a>
                </td>

            </tr>
        <?php endforeach; ?>

    <?php else: ?>

        <!-- vide -->
        <tr><td colspan="6">Aucune offre</td></tr>

    <?php endif; ?>
    </tbody>
</table>

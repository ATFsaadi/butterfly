<?php

/* valeurs par defaut */
if (!isset($offres)) {
    $offres = [];
}
if (!isset($offreToEdit)) {
    $offreToEdit = null;
}
if (!isset($voyages)) {
    $voyages = [];
}

?>

<!-- titre page -->
<h3 class="section-title text-center mt-5">Gestion des Offres</h3>

<!-- bloc erreurs -->
<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <?php foreach ($errors as $err): ?>
            <p><?= htmlspecialchars((string) $err) ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<!-- formulaire offre -->
<form action="" method="POST" class="mb-4">

    <!-- champ cache id -->
    <input type="hidden" name="id_offre"
           value="<?= htmlspecialchars((string) ($offreToEdit['id_offre'] ?? '')) ?>">

    <!-- champ titre -->
    <input type="text" name="titre" class="form-control mb-2" placeholder="Titre offre"
           required value="<?= htmlspecialchars((string) ($offreToEdit['titre'] ?? '')) ?>">

    <!-- champ reduction -->
    <input type="number" name="reduction" class="form-control mb-2" placeholder="Réduction (%)"
           min="0" max="100" value="<?= htmlspecialchars((string) ($offreToEdit['reduction'] ?? '')) ?>">

    <!-- champs dates -->
    <div class="row">

        <!-- date debut -->
        <div class="col-md-6">
            <label>Date début</label>
            <input type="date" name="date_debut" class="form-control mb-2"
                   value="<?= htmlspecialchars((string) ($offreToEdit['date_debut'] ?? '')) ?>" required>
        </div>

        <!-- date fin -->
        <div class="col-md-6">
            <label>Date fin</label>
            <input type="date" name="date_fin" class="form-control mb-2"
                   value="<?= htmlspecialchars((string) ($offreToEdit['date_fin'] ?? '')) ?>" required>
        </div>

    </div>

    <!-- select voyage -->
    <label>Voyage</label>
    <select name="id_voyage" class="form-control mb-2" required>
        <option value="">-- Choisir un voyage --</option>

        <?php foreach ($voyages as $v): ?>
            <?php
                /* selection voyage */
                $selected = '';
                if (!empty($offreToEdit['id_voyage']) && (int) $offreToEdit['id_voyage'] === (int) $v['id_voyage']) {
                    $selected = 'selected';
                }
            ?>
            <option value="<?= (int) $v['id_voyage'] ?>" <?= $selected ?>>
                <?= htmlspecialchars((string) ($v['titre'] ?? '')) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <!-- checkbox actif -->
    <div class="form-check mb-2">
        <input class="form-check-input" type="checkbox" name="actif" id="actif"
            <?= (empty($offreToEdit) || (int) ($offreToEdit['actif'] ?? 0) === 1) ? 'checked' : '' ?>>
        <label class="form-check-label" for="actif">Offre active</label>
    </div>

    <!-- bouton action -->
    <div class="d-flex justify-content-center">
        <button type="submit" name="submit" class="btn btn-primary">
            <?= $offreToEdit ? "Modifier l'offre" : "Ajouter l'offre" ?>
        </button>
    </div>

</form>

<!-- separation -->
<hr>

<!-- tableau offres -->
<table class="table table-bordered">

    <!-- entete tableau -->
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

    <!-- corps tableau -->
    <tbody>

        <?php if (!empty($offres)): ?>

            <?php foreach ($offres as $o): ?>
                <tr>

                    <!-- colonne titre -->
                    <td><?= htmlspecialchars((string) ($o['titre'] ?? '')) ?></td>

                    <!-- colonne reduction -->
                    <td><?= (int) ($o['reduction'] ?? 0) ?>%</td>

                    <!-- colonne dates -->
                    <td>
                        <?= htmlspecialchars((string) ($o['date_debut'] ?? '')) ?>
                        → <?= htmlspecialchars((string) ($o['date_fin'] ?? '')) ?>
                    </td>

                    <!-- colonne voyage -->
                    <td><?= htmlspecialchars((string) ($o['voyage_titre'] ?? '')) ?></td>

                    <!-- colonne actif -->
                    <td><?= ((int) ($o['actif'] ?? 0) === 1) ? 'Oui' : 'Non' ?></td>

                    <!-- colonne actions -->
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

            <!-- ligne vide -->
            <tr>
                <td colspan="6">Aucune offre</td>
            </tr>

        <?php endif; ?>

    </tbody>
</table>

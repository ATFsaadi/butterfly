<div class="container mt-4">
    <form method="post" enctype="multipart/form-data"
          class="p-4 border rounded shadow" style="max-width: 800px; margin:auto;">

        <h3 class="text-center mb-4">
            <?= ($destination == null) ? "Ajouter une destination" : "Modifier la destination" ?>
        </h3>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Pays</label>
                <input type="text" name="pays" class="form-control"
                       value="<?= ($destination == null) ? "" : htmlspecialchars($destination['pays']) ?>"
                       required>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Ville</label>
                <input type="text" name="ville" class="form-control"
                       value="<?= ($destination == null) ? "" : htmlspecialchars($destination['ville']) ?>"
                       required>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Continent</label>
                <input type="text" name="continent" class="form-control"
                       value="<?= ($destination == null) ? "" : htmlspecialchars($destination['continent'] ?? '') ?>">
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Prix de base (€)</label>
                <input type="number" step="0.01" name="prix_base" class="form-control"
                       value="<?= ($destination == null) ? "" : htmlspecialchars($destination['prix_base']) ?>"
                       required>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="3"><?= ($destination == null) ? "" : htmlspecialchars($destination['description'] ?? '') ?></textarea>
        </div>

        <!-- Image -->
        <div class="mb-3">
            <label class="form-label">Image (upload)</label>
            <input type="file" name="image_url" class="form-control" accept="image/*">

            <?php if ($destination && !empty($destination['image_url'])): ?>
                <div class="mt-2">
                    <img src="<?= htmlspecialchars($destination['image_url']) ?>"
                         alt="Image destination"
                         style="max-width:200px; border:1px solid #ccc; padding:3px;">
                </div>
            <?php endif; ?>
        </div>

        <!-- Actif -->
        <div class="mb-3">
            <label class="form-label">Actif</label>
            <select name="actif" class="form-select">
                <option value="1" <?= ($destination && (int)$destination['actif'] === 1) ? "selected" : "" ?>>Oui</option>
                <option value="0" <?= ($destination && (int)$destination['actif'] === 0) ? "selected" : "" ?>>Non</option>
            </select>
        </div>

        <div class="d-flex gap-2">
            <button type="reset" class="btn btn-secondary">Annuler</button>
            <button type="submit"
                <?= ($destination == null) ? 'name="Valider"' : 'name="Modifier"' ?>
                class="btn btn-primary">
                <?= ($destination == null) ? "Valider" : "Modifier" ?>
            </button>
        </div>

        <?= ($destination == null) ? '' : '<input type="hidden" name="id_destination" value="'.(int)$destination['id_destination'].'">' ?>

    </form>
</div>

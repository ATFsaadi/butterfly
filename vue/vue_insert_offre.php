<div class="container mt-4">
    <form method="post" class="p-4 border rounded shadow" style="max-width: 700px; margin:auto;">

        <h3 class="text-center mb-4">
            <?= ($offre == null) ? "Ajouter une offre" : "Modifier l'offre" ?>
        </h3>

        <!-- Destination -->
        <div class="mb-3">
            <label class="form-label">Destination</label>
            <select name="id_destination" class="form-select" required>
                <option value="">-- Choisir --</option>
                <?php foreach ($destinations as $d): ?>
                    <option value="<?= (int)$d['id_destination'] ?>"
                        <?= ($offre && (int)$offre['id_destination'] === (int)$d['id_destination']) ? "selected" : "" ?>>
                        <?= htmlspecialchars($d['pays'] . " - " . $d['ville']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Titre -->
        <div class="mb-3">
            <label class="form-label">Titre</label>
            <input type="text" name="titre" class="form-control"
                   value="<?= ($offre == null) ? "" : htmlspecialchars($offre['titre']) ?>"
                   required>
        </div>

        <!-- Réduction -->
        <div class="mb-3">
            <label class="form-label">Réduction (%)</label>
            <input type="number" name="pourcentage_reduction" class="form-control" min="0" max="100"
                   value="<?= ($offre == null) ? "0" : (int)$offre['pourcentage_reduction'] ?>"
                   required>
        </div>

        <!-- Dates -->
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Date début</label>
                <input type="date" name="date_debut" class="form-control"
                       value="<?= ($offre == null) ? "" : htmlspecialchars($offre['date_debut']) ?>"
                       required>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Date fin</label>
                <input type="date" name="date_fin" class="form-control"
                       value="<?= ($offre == null) ? "" : htmlspecialchars($offre['date_fin']) ?>"
                       required>
            </div>
        </div>

        <!-- Actif (optionnel) -->
        <div class="mb-3">
            <label class="form-label">Actif</label>
            <select name="actif" class="form-select">
                <option value="1" <?= ($offre && (int)$offre['actif'] === 1) ? "selected" : "" ?>>Oui</option>
                <option value="0" <?= ($offre && (int)$offre['actif'] === 0) ? "selected" : "" ?>>Non</option>
            </select>
        </div>

        <!-- Boutons -->
        <div class="d-flex gap-2">
            <button type="reset" class="btn btn-secondary">Annuler</button>

            <button type="submit"
                <?= ($offre == null) ? 'name="Valider"' : 'name="Modifier"' ?>
                class="btn btn-primary">
                <?= ($offre == null) ? "Valider" : "Modifier" ?>
            </button>
        </div>

        <!-- Hidden id si edit -->
        <?= ($offre == null) ? '' : '<input type="hidden" name="id_offre" value="'.(int)$offre['id_offre'].'">' ?>

    </form>
</div>

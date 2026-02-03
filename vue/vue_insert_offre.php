<div class="container mt-4">
    <form method="post" class="p-4 border rounded shadow" style="max-width:700px; margin:auto;">

        <?php
        $isEdit = ($offre !== null);
        $idOffre = (int) ($offre["id_offre"] ?? 0);
        $idOffreDestination = (int) ($offre["id_destination"] ?? 0);

        $titre = $offre["titre"] ?? "";
        $reduc = (int) ($offre["pourcentage_reduction"] ?? 0);
        $dateDebut = $offre["date_debut"] ?? "";
        $dateFin = $offre["date_fin"] ?? "";
        $actif = (int) ($offre["actif"] ?? 1);
        ?>

        <h3 class="text-center mb-4">
            <?= $isEdit ? "Modifier l'offre" : "Ajouter une offre" ?>
        </h3>

        <!-- destination -->
        <div class="mb-3">
            <label class="form-label">Destination</label>
            <select name="id_destination" class="form-select" required>
                <option value="">-- choisir --</option>

                <?php foreach ($destinations as $d): ?>
                    <?php
                    $idDest = (int) ($d["id_destination"] ?? 0);
                    $labelDest = trim(($d["pays"] ?? "") . " - " . ($d["ville"] ?? ""));
                    $selected = ($isEdit && $idOffreDestination === $idDest) ? "selected" : "";
                    ?>
                    <option value="<?= $idDest ?>" <?= $selected ?>>
                        <?= htmlspecialchars($labelDest) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- titre -->
        <div class="mb-3">
            <label class="form-label">Titre</label>
            <input
                type="text"
                name="titre"
                class="form-control"
                value="<?= htmlspecialchars($titre) ?>"
                required
            >
        </div>

        <!-- reduction -->
        <div class="mb-3">
            <label class="form-label">Réduction (%)</label>
            <input
                type="number"
                name="pourcentage_reduction"
                class="form-control"
                min="0"
                max="100"
                value="<?= $reduc ?>"
                required
            >
        </div>

        <!-- dates -->
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Date début</label>
                <input
                    type="date"
                    name="date_debut"
                    class="form-control"
                    value="<?= htmlspecialchars($dateDebut) ?>"
                    required
                >
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Date fin</label>
                <input
                    type="date"
                    name="date_fin"
                    class="form-control"
                    value="<?= htmlspecialchars($dateFin) ?>"
                    required
                >
            </div>
        </div>

        <!-- actif -->
        <div class="mb-3">
            <label class="form-label">Actif</label>
            <select name="actif" class="form-select">
                <option value="1" <?= $actif === 1 ? "selected" : "" ?>>Oui</option>
                <option value="0" <?= $actif === 0 ? "selected" : "" ?>>Non</option>
            </select>
        </div>

        <!-- boutons -->
        <div class="d-flex gap-2">
            <button type="reset" class="btn btn-secondary">Annuler</button>

            <button
                type="submit"
                name="<?= $isEdit ? "Modifier" : "Valider" ?>"
                class="btn btn-primary"
            >
                <?= $isEdit ? "Modifier" : "Valider" ?>
            </button>
        </div>

        <!-- hidden id si edit -->
        <?php if ($isEdit): ?>
            <input type="hidden" name="id_offre" value="<?= $idOffre ?>">
        <?php endif; ?>

    </form>
</div>

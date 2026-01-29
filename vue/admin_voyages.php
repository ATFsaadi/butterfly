<?php

/* valeurs par defaut */
if (!isset($voyages)) {
    $voyages = [];
}
if (!isset($voyageToEdit)) {
    $voyageToEdit = null;
}
if (!isset($destinations)) {
    $destinations = [];
}

?>

<!-- titre page -->
<h3 class="section-title text-center mt-5">Gestion des Voyages</h3>

<!-- bloc erreurs -->
<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <?php foreach ($errors as $err): ?>
            <p><?= htmlspecialchars((string) $err) ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<!-- formulaire voyage -->
<form action="" method="POST" enctype="multipart/form-data" class="mb-4">

    <!-- champs caches -->
    <input type="hidden" name="id_voyage"
           value="<?= htmlspecialchars((string) ($voyageToEdit['id_voyage'] ?? '')) ?>">

    <input type="hidden" name="existing_image"
           value="<?= htmlspecialchars((string) ($voyageToEdit['image'] ?? '')) ?>">

    <!-- champ titre -->
    <input type="text" name="titre" placeholder="Titre" required class="form-control mb-2"
           value="<?= htmlspecialchars((string) ($voyageToEdit['titre'] ?? '')) ?>">

    <!-- champ prix adulte -->
    <input type="number" step="0.01" name="prix_adulte" class="form-control mb-2"
           placeholder="Prix adulte"
           value="<?= htmlspecialchars((string) ($voyageToEdit['prix_adulte'] ?? '')) ?>">

    <!-- champ prix enfant -->
    <input type="number" step="0.01" name="prix_enfant" class="form-control mb-2"
           placeholder="Prix enfant"
           value="<?= htmlspecialchars((string) ($voyageToEdit['prix_enfant'] ?? '')) ?>">

    <!-- champ prix bebe -->
    <input type="number" step="0.01" name="prix_bebe" class="form-control mb-2"
           placeholder="Prix bébé"
           value="<?= htmlspecialchars((string) ($voyageToEdit['prix_bebe'] ?? '')) ?>">

    <!-- champs dates -->
    <div class="row">

        <!-- date depart -->
        <div class="col-md-6">
            <label>Date départ</label>
            <input type="date" name="date_depart" required class="form-control mb-2"
                   value="<?= htmlspecialchars((string) ($voyageToEdit['date_depart'] ?? '')) ?>">
        </div>

        <!-- date retour -->
        <div class="col-md-6">
            <label>Date retour</label>
            <input type="date" name="date_retour" required class="form-control mb-2"
                   value="<?= htmlspecialchars((string) ($voyageToEdit['date_retour'] ?? '')) ?>">
        </div>

    </div>

    <!-- select destination -->
    <select name="id_destination" required class="form-control mb-2">
        <option value="">-- Choisir une destination --</option>

        <?php foreach ($destinations as $d): ?>
            <?php
                /* selection destination */
                $selected = '';
                if (!empty($voyageToEdit['id_destination']) && (int) $voyageToEdit['id_destination'] === (int) $d['id_destination']) {
                    $selected = 'selected';
                }
            ?>
            <option value="<?= (int) $d['id_destination'] ?>" <?= $selected ?>>
                <?= htmlspecialchars((string) ($d['nom'] ?? '')) ?> — <?= htmlspecialchars((string) ($d['continent_nom'] ?? '')) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <!-- champ description -->
    <textarea name="description" placeholder="Description" class="form-control mb-2"><?= htmlspecialchars((string) ($voyageToEdit['description'] ?? '')) ?></textarea>

    <!-- champ image -->
    <input type="file" name="image" class="form-control mb-2">

    <!-- preview image actuelle -->
    <?php if (!empty($voyageToEdit['image'])): ?>
        <p>Image actuelle :</p>
        <img src="images/voyages/<?= htmlspecialchars((string) $voyageToEdit['image']) ?>"
             width="150" style="border:1px solid #ccc; padding:2px;">
    <?php endif; ?>

    <!-- bouton action -->
    <div class="d-flex justify-content-center">
        <button type="submit" name="submit" class="btn btn-primary">
            <?= $voyageToEdit ? 'Modifier le voyage' : 'Ajouter le voyage' ?>
        </button>
    </div>

</form>

<!-- separation -->
<hr>

<!-- tableau voyages -->
<table class="table table-bordered">

    <!-- entete tableau -->
    <thead>
        <tr>
            <th>Image</th>
            <th>Titre</th>
            <th>Destination</th>
            <th>Prix</th>
            <th>Départ</th>
            <th>Retour</th>
            <th>Actions</th>
        </tr>
    </thead>

    <!-- corps tableau -->
    <tbody>

        <?php if (!empty($voyages)): ?>

            <?php foreach ($voyages as $v): ?>
                <tr>

                    <!-- colonne image -->
                    <td>
                        <?php if (!empty($v['image'])): ?>
                            <img src="images/voyages/<?= htmlspecialchars((string) $v['image']) ?>" width="100">
                        <?php endif; ?>
                    </td>

                    <!-- colonne titre -->
                    <td><?= htmlspecialchars((string) ($v['titre'] ?? '')) ?></td>

                    <!-- colonne destination -->
                    <td><?= htmlspecialchars((string) ($v['destination_nom'] ?? '')) ?></td>

                    <!-- colonne prix -->
                    <td>
                        Adulte : <?= number_format((float) ($v['prix_adulte'] ?? 0), 2, ',', ' ') ?> €<br>
                        Enfant : <?= number_format((float) ($v['prix_enfant'] ?? 0), 2, ',', ' ') ?> €<br>
                        Bébé : <?= number_format((float) ($v['prix_bebe'] ?? 0), 2, ',', ' ') ?> €
                    </td>

                    <!-- colonne dates -->
                    <td><?= htmlspecialchars((string) ($v['date_depart'] ?? '')) ?></td>
                    <td><?= htmlspecialchars((string) ($v['date_retour'] ?? '')) ?></td>

                    <!-- colonne actions -->
                    <td>
                        <a href="index.php?page=admin_voyages&edit=<?= (int) ($v['id_voyage'] ?? 0) ?>"
                           class="btn btn-warning btn-sm">Modifier</a>

                        <a href="index.php?page=admin_voyages&delete=<?= (int) ($v['id_voyage'] ?? 0) ?>"
                           onclick="return confirm('Supprimer ce voyage ?');"
                           class="btn btn-danger btn-sm">Supprimer</a>
                    </td>

                </tr>
            <?php endforeach; ?>

        <?php else: ?>

            <!-- ligne vide -->
            <tr>
                <td colspan="7">Aucun voyage pour le moment</td>
            </tr>

        <?php endif; ?>

    </tbody>
</table>

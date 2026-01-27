<?php

if (!isset($voyages)) $voyages = [];
if (!isset($voyageToEdit)) $voyageToEdit = null;
if (!isset($destinations)) $destinations = [];
?>

<h3 class="section-title text-center mt-5">Gestion des Voyages</h3>

<!-- erreurs -->
<?php if (!empty($errors)): ?>
<div class="alert alert-danger">
    <?php foreach ($errors as $err) echo "<p>$err</p>"; ?>
</div>
<?php endif; ?>

<!-- formulaire -->
<form action="" method="POST" enctype="multipart/form-data" class="mb-4">

    <!-- champs caches -->
    <input type="hidden" name="id_voyage" value="<?= htmlspecialchars((string)($voyageToEdit['id_voyage'] ?? '')) ?>">
    <input type="hidden" name="existing_image" value="<?= htmlspecialchars((string)($voyageToEdit['image'] ?? '')) ?>">

    <!-- titre -->
    <input type="text" name="titre" placeholder="Titre" required class="form-control mb-2"
           value="<?= htmlspecialchars((string)($voyageToEdit['titre'] ?? '')) ?>">

    <!-- prix adulte -->
    <input type="number" step="0.01" name="prix_adulte" class="form-control mb-2"
           placeholder="Prix adulte"
           value="<?= htmlspecialchars((string)($voyageToEdit['prix_adulte'] ?? '')) ?>">

    <!-- prix enfant -->
    <input type="number" step="0.01" name="prix_enfant" class="form-control mb-2"
           placeholder="Prix enfant"
           value="<?= htmlspecialchars((string)($voyageToEdit['prix_enfant'] ?? '')) ?>">

    <!-- prix bebe -->
    <input type="number" step="0.01" name="prix_bebe" class="form-control mb-2"
           placeholder="Prix bébé"
           value="<?= htmlspecialchars((string)($voyageToEdit['prix_bebe'] ?? '')) ?>">

    <!-- dates -->
<div class="row">
    <div class="col-md-6">
        <label>Date départ</label>
        <input type="date" name="date_depart" required class="form-control mb-2"
               value="<?= htmlspecialchars((string)($voyageToEdit['date_depart'] ?? '')) ?>">
    </div>

    <div class="col-md-6">
        <label>Date retour</label>
        <input type="date" name="date_retour" required class="form-control mb-2"
               value="<?= htmlspecialchars((string)($voyageToEdit['date_retour'] ?? '')) ?>">
    </div>
</div>


    <!-- destinations -->
    <select name="id_destination" required class="form-control mb-2">
        <option value="">-- Choisir une destination --</option>

        <?php foreach ($destinations as $d): ?>
            <?php
            /* selection destination */
            $selected = (!empty($voyageToEdit['id_destination']) && (int)$voyageToEdit['id_destination'] === (int)$d['id_destination'])
                ? 'selected'
                : '';
            ?>
            <option value="<?= (int)$d['id_destination'] ?>" <?= $selected ?>>
                <?= htmlspecialchars((string)$d['nom']) ?> — <?= htmlspecialchars((string)($d['continent_nom'] ?? '')) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <!-- description -->
    <textarea name="description" placeholder="Description" class="form-control mb-2"><?= htmlspecialchars((string)($voyageToEdit['description'] ?? '')) ?></textarea>

    <!-- image -->
    <input type="file" name="image" class="form-control mb-2">

    <!-- image actuelle -->
    <?php if (!empty($voyageToEdit['image'])): ?>
        <p>Image actuelle :</p>
        <img src="images/voyages/<?= htmlspecialchars((string)$voyageToEdit['image']) ?>"
             width="150" style="border:1px solid #ccc; padding:2px;">
    <?php endif; ?>

    <!-- action -->
    <button type="submit" name="submit" class="btn btn-primary">
        <?= $voyageToEdit ? 'Modifier le voyage' : 'Ajouter le voyage' ?>
    </button>
</form>

<!-- separation -->
<hr>

<!-- liste voyages -->
<table class="table table-bordered">

    <!-- entete -->
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

    <!-- contenu -->
    <tbody>
        <?php if (!empty($voyages)): ?>

            <?php foreach ($voyages as $v): ?>
            <tr>

                <!-- image -->
                <td>
                    <?php if (!empty($v['image'])): ?>
                        <img src="images/voyages/<?= htmlspecialchars((string)$v['image']) ?>" width="100">
                    <?php endif; ?>
                </td>

                <!-- titre -->
                <td><?= htmlspecialchars((string)($v['titre'] ?? '')) ?></td>

                <!-- destination -->
                <td><?= htmlspecialchars((string)($v['destination_nom'] ?? '')) ?></td>

                <!-- prix -->
                <td>
                    Adulte : <?= number_format((float)$v['prix_adulte'], 2, ',', ' ') ?> €<br>
                    Enfant : <?= number_format((float)$v['prix_enfant'], 2, ',', ' ') ?> €<br>
                    Bébé : <?= number_format((float)$v['prix_bebe'], 2, ',', ' ') ?> €
                </td>


                <!-- dates -->
                <td><?= htmlspecialchars((string)($v['date_depart'] ?? '')) ?></td>
                <td><?= htmlspecialchars((string)($v['date_retour'] ?? '')) ?></td>

                <!-- actions -->
                <td>
                    <a href="index.php?page=admin_voyages&edit=<?= (int)$v['id_voyage'] ?>" class="btn btn-warning btn-sm">Modifier</a>
                    <a href="index.php?page=admin_voyages&delete=<?= (int)$v['id_voyage'] ?>"
                       onclick="return confirm('Supprimer ce voyage ?');"
                       class="btn btn-danger btn-sm">Supprimer</a>
                </td>

            </tr>
            <?php endforeach; ?>

        <?php else: ?>

            <!-- vide -->
            <tr><td colspan="7">Aucun voyage pour le moment</td></tr>

        <?php endif; ?>
    </tbody>
</table>

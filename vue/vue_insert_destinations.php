<?php
$destinations = $destinations ?? [];
$destinationToEdit = $destinationToEdit ?? null;
$continents = $continents ?? [];
?>

<h3 class="section-title text-center mt-5">Gestion des Destinations</h3>

<form action="" method="POST" enctype="multipart/form-data" class="mb-4">

  <input type="hidden" name="id_destination"
         value="<?= htmlspecialchars((string)($destinationToEdit['id_destination'] ?? '')) ?>">

  <input type="hidden" name="existing_image_url"
         value="<?= htmlspecialchars((string)($destinationToEdit['image_url'] ?? '')) ?>">

  <input type="text" name="pays" placeholder="Pays" required class="form-control mb-2"
         value="<?= htmlspecialchars((string)($destinationToEdit['pays'] ?? '')) ?>">

  <input type="text" name="ville" placeholder="Ville" required class="form-control mb-2"
         value="<?= htmlspecialchars((string)($destinationToEdit['ville'] ?? '')) ?>">

  <select name="id_continent" class="form-control mb-2">
    <option value="">-- Choisir un continent --</option>
    <?php foreach ($continents as $c): ?>
      <?php
        $currentId = $destinationToEdit['id_continent'] ?? '';
        $selected = ((string)$currentId !== '' && (int)$currentId === (int)$c['id_continent']) ? 'selected' : '';
      ?>
      <option value="<?= (int)$c['id_continent'] ?>" <?= $selected ?>>
        <?= htmlspecialchars((string)$c['nom']) ?>
      </option>
    <?php endforeach; ?>
  </select>

  <textarea name="description" placeholder="Description" class="form-control mb-2" rows="3"><?= htmlspecialchars((string)($destinationToEdit['description'] ?? '')) ?></textarea>

  <input type="number" step="0.01" name="prix_base" placeholder="Prix base" required class="form-control mb-2"
         value="<?= htmlspecialchars((string)($destinationToEdit['prix_base'] ?? '')) ?>">

  <input type="file" name="image" class="form-control mb-2" accept="image/*">

  <?php if (!empty($destinationToEdit['image_url'])): ?>
    <p class="mb-1">Image actuelle :</p>
    <img src="<?= htmlspecialchars((string)$destinationToEdit['image_url']) ?>"
         width="150" style="border:1px solid #ccc; padding:2px;">
  <?php endif; ?>

  <?php $isActif = (int)($destinationToEdit['actif'] ?? 1) === 1; ?>
  <div class="form-check mb-3 mt-2">
    <input class="form-check-input" type="checkbox" value="1" id="actif" name="actif" <?= $isActif ? 'checked' : '' ?>>
    <label class="form-check-label" for="actif">Destination active</label>
  </div>

  <div class="d-flex justify-content-center">
    <button type="submit" name="submit" class="btn btn-primary">
      <?= $destinationToEdit ? 'Modifier la destination' : 'Ajouter la destination' ?>
    </button>
  </div>

</form>

<hr>

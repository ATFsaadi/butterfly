<?php
// vue/admin_destinations.php

$errors = $errors ?? [];
$success = $success ?? "";

$destinations = $destinations ?? [];
$destinationToEdit = $destinationToEdit ?? null;

// Valeurs par défaut (edit ou vide)
$id_destination = $destinationToEdit["id_destination"] ?? "";
$pays = $destinationToEdit["pays"] ?? "";
$ville = $destinationToEdit["ville"] ?? "";
$continent = $destinationToEdit["continent"] ?? "";
$description = $destinationToEdit["description"] ?? "";
$prix_base = $destinationToEdit["prix_base"] ?? "";
$image_url = $destinationToEdit["image_url"] ?? "";
$actif = isset($destinationToEdit["actif"]) ? (int)$destinationToEdit["actif"] : 1;
?>

<div class="container py-5">

  <h2 class="section-title text-center mb-4">Admin - Destinations</h2>

  <?php if (!empty($success)): ?>
    <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
  <?php endif; ?>

  <?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
      <ul class="mb-0">
        <?php foreach ($errors as $e): ?>
          <li><?= htmlspecialchars($e) ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
  <?php endif; ?>

  <div class="row g-4">

    <!-- FORM -->
    <div class="col-lg-5">
      <div class="card shadow-sm">
        <div class="card-body">

          <h5 class="mb-3"><?= $id_destination ? "Modifier" : "Ajouter" ?> une destination</h5>

        <form method="POST"
                action="index.php?page=admin_destinations"
                enctype="multipart/form-data">

            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION["csrf_token"]) ?>">

            <?php if ($id_destination): ?>
              <input type="hidden" name="id_destination" value="<?= (int)$id_destination ?>">
              <input type="hidden" name="existing_image" value="<?= htmlspecialchars($image_url) ?>">
            <?php endif; ?>


            <div class="mb-3">
              <label class="form-label">Pays</label>
              <input class="form-control" type="text" name="pays" value="<?= htmlspecialchars($pays) ?>" required>
            </div>

            <div class="mb-3">
              <label class="form-label">Ville</label>
              <input class="form-control" type="text" name="ville" value="<?= htmlspecialchars($ville) ?>" required>
            </div>

            <div class="mb-3">
              <label class="form-label">Continent</label>
              <input class="form-control" type="text" name="continent" value="<?= htmlspecialchars($continent) ?>">
            </div>

            <div class="mb-3">
              <label class="form-label">Description</label>
              <textarea class="form-control" name="description" rows="4"><?= htmlspecialchars($description) ?></textarea>
            </div>

            <div class="mb-3">
              <label class="form-label">Prix de base (€)</label>
              <input class="form-control" type="number" step="0.01" name="prix_base"
                     value="<?= htmlspecialchars((string)$prix_base) ?>" required>
            </div>

            <div class="mb-3">
              <label class="form-label">Image</label>
              <input class="form-control" type="file" name="image" accept="image/*">
              <?php if (!empty($image_url)): ?>
                <div class="small text-muted mt-1">
                  Image actuelle : <?= htmlspecialchars($image_url) ?>
                </div>
              <?php endif; ?>
            </div>

            <div class="form-check mb-3">
              <input class="form-check-input" type="checkbox" name="actif" id="actifDest"
                     <?= ($actif === 1) ? "checked" : "" ?>>
              <label class="form-check-label" for="actifDest">Active</label>
            </div>

            <button class="btn btn-primary w-100"
                    type="submit"
                    name="submit_destination">
              Enregistrer
            </button>

            <?php if ($id_destination): ?>
              <a class="btn btn-outline-secondary w-100 mt-2" href="index.php?page=admin_destinations">
                Annuler édition
              </a>
            <?php endif; ?>

          </form>

        </div>
      </div>
    </div>

    <!-- LISTE -->
    <div class="col-lg-7">
      <div class="card shadow-sm">
        <div class="card-body">

          <h5 class="mb-3">Liste des destinations</h5>

          <?php if (empty($destinations)): ?>
            <div class="alert alert-secondary">Aucune destination.</div>
          <?php else: ?>
            <div class="table-responsive">
              <table class="table table-sm align-middle">
                <thead>
                  <tr>
                    <th>Destination</th>
                    <th>Prix</th>
                    <th>Active</th>
                    <th style="width:140px;">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($destinations as $d): ?>
                    <tr>
                      <td>
                        <strong><?= htmlspecialchars($d["ville"]) ?></strong>
                        — <?= htmlspecialchars($d["pays"]) ?>
                        <?php if (!empty($d["continent"])): ?>
                          <div class="small text-muted"><?= htmlspecialchars($d["continent"]) ?></div>
                        <?php endif; ?>
                      </td>
                      <td><?= number_format((float)$d["prix_base"], 2, ",", " ") ?> €</td>
                      <td><?= ((int)$d["actif"] === 1) ? "Oui" : "Non" ?></td>
                      <td>
                        <a class="btn btn-sm btn-outline-primary"
                           href="index.php?page=admin_destinations&edit=<?= (int)$d["id_destination"] ?>">
                          Modifier
                        </a>
                       <form method="POST"
      action="index.php?page=admin_destinations"
      style="display:inline;">
  <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION["csrf_token"]) ?>">
  <input type="hidden" name="id_destination" value="<?= (int)$d["id_destination"] ?>">

  <button class="btn btn-sm btn-outline-danger"
          type="submit"
          name="delete_destination"
          onclick="return confirm('Supprimer cette destination ?');">
    Supprimer
  </button>
</form>

                      </td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          <?php endif; ?>

        </div>
      </div>
    </div>

  </div>
</div>

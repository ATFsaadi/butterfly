<?php
$lesDestinations = $lesDestinations ?? ($destinations ?? []);
?>

<h3 class="text-center mt-5 mb-4">Liste des destinations</h3>

<form method="post" class="mb-4">
  <input type="text"
         name="filtre"
         placeholder="Filtrer (pays / ville / continent)"
         class="form-control mb-2"
         value="<?= htmlspecialchars($_POST['filtre'] ?? '') ?>">

  <div class="d-flex justify-content-center">
    <button type="submit" name="Filtrer" class="btn btn-primary">Filtrer</button>
  </div>
</form>

<div class="container mt-4">
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>Image</th>
        <th>Pays</th>
        <th>Ville</th>
        <th>Continent</th>
        <th>Prix base</th>
        <th>Actif</th>
        <th>Actions</th>
      </tr>
    </thead>

    <tbody>
      <?php if (!empty($lesDestinations)): ?>
        <?php foreach ($lesDestinations as $d): ?>
          <tr>
            <td>
              <?php if (!empty($d['image_url'])): ?>
                <img src="<?= htmlspecialchars((string)$d['image_url']) ?>" width="100">
              <?php endif; ?>
            </td>

            <td><?= htmlspecialchars((string)($d['pays'] ?? '')) ?></td>
            <td><?= htmlspecialchars((string)($d['ville'] ?? '')) ?></td>
            <td><?= htmlspecialchars((string)($d['continent'] ?? '')) ?></td>
            <td><?= number_format((float)($d['prix_base'] ?? 0), 2, ',', ' ') ?> €</td>
            <td><?= ((int)($d['actif'] ?? 0) === 1) ? 'Oui' : 'Non' ?></td>

            <td>
              <a href="index.php?page=admin_destinations&action=edit&id_destination=<?= (int)$d['id_destination'] ?>"
                 class="btn btn-warning btn-sm">Modifier</a>

              <a href="index.php?page=admin_destinations&action=sup&id_destination=<?= (int)$d['id_destination'] ?>"
                 onclick="return confirm('Supprimer (désactiver) cette destination ?');"
                 class="btn btn-danger btn-sm">Supprimer</a>
            </td>
          </tr>
        <?php endforeach; ?>
      <?php else: ?>
        <tr>
          <td colspan="7">Aucune destination pour le moment</td>
        </tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>

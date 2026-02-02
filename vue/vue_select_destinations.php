<h3 class="text-center mt-5 mb-4">Liste des destinations</h3>

<form method="post" class="container mt-3 p-3 border rounded shadow" style="max-width: 600px;">
    <div class="input-group">
        <input type="text" name="filtre" class="form-control" placeholder="Filtrer (pays / ville / continent)">
        <button type="submit" name="Filtrer" class="btn btn-primary">Filtrer</button>
    </div>
</form>

<div class="container mt-4">
    <table class="table table-striped table-bordered">
        <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Pays</th>
            <th>Ville</th>
            <th>Continent</th>
            <th>Prix base</th>
            <th>Actif</th>
            <th>Image</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php if (!empty($lesDestinations)): ?>
            <?php foreach ($lesDestinations as $d): ?>
                <tr>
                    <td><?= (int)$d['id_destination'] ?></td>
                    <td><?= htmlspecialchars($d['pays'] ?? '') ?></td>
                    <td><?= htmlspecialchars($d['ville'] ?? '') ?></td>
                    <td><?= htmlspecialchars($d['continent'] ?? '') ?></td>
                    <td><?= number_format((float)($d['prix_base'] ?? 0), 2, ',', ' ') ?> €</td>
                    <td><?= ((int)($d['actif'] ?? 0) === 1) ? "Oui" : "Non" ?></td>
                    <td>
                        <?php if (!empty($d['image_url'])): ?>
                            <img src="<?= htmlspecialchars($d['image_url']) ?>" alt="img"
                                 style="width:80px; height:50px; object-fit:cover;">
                        <?php endif; ?>
                    </td>
                    <td>
                        <a class="btn btn-danger btn-sm"
                           href="index.php?page=admin_destinations&action=sup&id_destination=<?= (int)$d['id_destination'] ?>"
                           onclick="return confirm('Voulez-vous vraiment supprimer cette destination ?');">
                            🗑
                        </a>

                        <a class="btn btn-warning btn-sm"
                           href="index.php?page=admin_destinations&action=edit&id_destination=<?= (int)$d['id_destination'] ?>">
                            ✏️
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
</div>

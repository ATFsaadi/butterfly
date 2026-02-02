<h3 class="text-center mt-5 mb-4">Liste des offres</h3>

<form method="post" class="container mt-3 p-3 border rounded shadow" style="max-width: 600px;">
    <div class="input-group">
        <input type="text" name="filtre" class="form-control" placeholder="Filtrer (titre / pays / ville)">
        <button type="submit" name="Filtrer" class="btn btn-primary">Filtrer</button>
    </div>
</form>

<div class="container mt-4">
    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Titre</th>
                <th>Destination</th>
                <th>Réduction</th>
                <th>Début</th>
                <th>Fin</th>
                <th>Actif</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php if (!empty($lesOffres)): ?>
            <?php foreach ($lesOffres as $o): ?>
                <tr>
                    <td><?= (int)$o['id_offre'] ?></td>
                    <td><?= htmlspecialchars($o['titre'] ?? '') ?></td>
                    <td><?= htmlspecialchars(($o['pays'] ?? '') . " - " . ($o['ville'] ?? '')) ?></td>
                    <td><?= (int)($o['pourcentage_reduction'] ?? 0) ?>%</td>
                    <td><?= htmlspecialchars($o['date_debut'] ?? '') ?></td>
                    <td><?= htmlspecialchars($o['date_fin'] ?? '') ?></td>
                    <td><?= ((int)($o['actif'] ?? 0) === 1) ? "Oui" : "Non" ?></td>
                    <td>
                        <a class="btn btn-danger btn-sm"
                           href="index.php?page=admin_offres&action=sup&id_offre=<?= (int)$o['id_offre'] ?>"
                           onclick="return confirm('Voulez-vous vraiment supprimer cette offre ?');">
                           🗑
                        </a>

                        <a class="btn btn-warning btn-sm"
                           href="index.php?page=admin_offres&action=edit&id_offre=<?= (int)$o['id_offre'] ?>">
                           ✏️
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
</div>

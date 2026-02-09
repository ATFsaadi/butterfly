<?php
$lesDestinations = $lesDestinations ?? ($destinations ?? []);
?>

<h3 class="section-title text-center mt-5">liste des destinations</h3>

<form method="post" class="mb-4">
    <input
        type="text"
        name="filtre"
        placeholder="filtrer (pays / ville / continent)"
        class="form-control mb-2"
        value="<?= htmlspecialchars((string)($_POST["filtre"] ?? "")) ?>"
    >

    <div class="d-flex justify-content-center">
        <button type="submit" name="Filtrer" class="btn btn-primary">
            filtrer
        </button>
    </div>
</form>

<div class="container mt-4">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>image</th>
                <th>pays</th>
                <th>ville</th>
                <th>continent</th>
                <th>prix base</th>
                <th>actif</th>
                <th>actions</th>
            </tr>
        </thead>

        <tbody>
            <?php if (!empty($lesDestinations)): ?>
                <?php foreach ($lesDestinations as $d): ?>

                    <?php
                    $id = (int)($d["id_destination"] ?? 0);
                    $pays = (string)($d["pays"] ?? "");
                    $ville = (string)($d["ville"] ?? "");
                    $continent = (string)($d["continent"] ?? "");
                    $prixBase = (float)($d["prix_base"] ?? 0);
                    $actif = ((int)($d["actif"] ?? 0) === 1);
                    $image = (string)($d["image_url"] ?? "");
                    ?>

                    <tr>
                        <td>
                            <?php if ($image !== ""): ?>
                                <img
                                    src="<?= htmlspecialchars($image) ?>"
                                    width="100"
                                    alt="destination"
                                >
                            <?php else: ?>
                                <span class="text-muted">—</span>
                            <?php endif; ?>
                        </td>

                        <td><?= htmlspecialchars($pays) ?></td>
                        <td><?= htmlspecialchars($ville) ?></td>
                        <td><?= htmlspecialchars($continent) ?></td>
                        <td><?= number_format($prixBase, 2, ",", " ") ?> €</td>
                        <td><?= $actif ? "oui" : "non" ?></td>

                        <td>
                            <a
                                href="index.php?page=admin_destinations&action=edit&id_destination=<?= $id ?>"
                                class="btn btn-warning btn-sm"
                            >
                                modifier
                            </a>

                            <a
                                href="index.php?page=admin_destinations&action=sup&id_destination=<?= $id ?>"
                                onclick="return confirm('supprimer (désactiver) cette destination ?');"
                                class="btn btn-danger btn-sm"
                            >
                                supprimer
                            </a>
                        </td>
                    </tr>

                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" class="text-center text-muted">
                        aucune destination pour le moment
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

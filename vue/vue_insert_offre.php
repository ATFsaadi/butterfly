<?php
$destinations = $destinations ?? [];
$offre = $offre ?? null;

// mode edition
$isEdit = ($offre !== null);

$idOffre = (int) ($offre["id_offre"] ?? 0);
$idOffreDestination = (int) ($offre["id_destination"] ?? 0);

$titre = $offre["titre"] ?? "";
$reduc = (int) ($offre["pourcentage_reduction"] ?? 0);
$dateDebut = $offre["date_debut"] ?? "";
$dateFin = $offre["date_fin"] ?? "";
$isActif = ((int) ($offre["actif"] ?? 1) === 1);
?>

<h3 class="section-title text-center mt-5">Gestion des Offres</h3>

<form action="" method="post" class="mb-4">

    <!-- hidden id si edit -->
    <input type="hidden" name="id_offre" value="<?= htmlspecialchars((string) $idOffre) ?>">

    <!-- destination -->
    <select name="id_destination" class="form-control mb-2" required>
        <option value="">-- choisir une destination --</option>

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

    <!-- titre -->
    <input
        type="text"
        name="titre"
        placeholder="titre"
        required
        class="form-control mb-2"
        value="<?= htmlspecialchars($titre) ?>"
    >

    <!-- reduction -->
    <input
        type="number"
        name="pourcentage_reduction"
        placeholder="réduction (%)"
        required
        min="0"
        max="100"
        class="form-control mb-2"
        value="<?= htmlspecialchars((string) $reduc) ?>"
    >

    <!-- dates -->
    <input
        type="date"
        name="date_debut"
        required
        class="form-control mb-2"
        value="<?= htmlspecialchars($dateDebut) ?>"
    >

    <input
        type="date"
        name="date_fin"
        required
        class="form-control mb-2"
        value="<?= htmlspecialchars($dateFin) ?>"
    >

    <!-- actif (checkbox comme destinations) -->
    <div class="form-check mb-3 mt-2">
        <input
            class="form-check-input"
            type="checkbox"
            value="1"
            id="actif"
            name="actif"
            <?= $isActif ? "checked" : "" ?>
        >
        <label class="form-check-label" for="actif">offre active</label>
    </div>

    <div class="d-flex justify-content-center">
        <button
            type="submit"
            name="<?= $isEdit ? "Modifier" : "Valider" ?>"
            class="btn btn-primary"
        >
            <?= $isEdit ? "modifier l'offre" : "ajouter l'offre" ?>
        </button>
    </div>

</form>

<hr>

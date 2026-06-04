<?php

// Composant recherche offres : filtre les promotions publiques.

// récupération de la recherche

$q = trim((string) ($_GET["q"] ?? ""));

?>

<!-- formulaire recherche offres -->

<form
    class="voyage-menu container-fluid py-3 justify-content-center align-items-center gap-3 d-flex flex-column flex-lg-row"
    method="get"
    action="index.php"
>
    <input type="hidden" name="page" value="offres">

    <!-- champ offres -->

    <div class="voyage-field">
        <label class="form-label">Offres</label>
        <input
            type="text"
            name="q"
            class="form-control"
            placeholder="pays, ville, titre ou continent..."
            value="<?= htmlspecialchars($q) ?>"
        >
    </div>

    <!-- boutons recherche -->

    <div class="voyage-search-group">
        <button class="voyage-search-btn" type="submit">
            <span>rechercher</span>
            <img src="icons/loupe.png" class="search-icon" alt="search">
        </button>

        <a class="voyage-reset-icon" href="index.php?page=offres">
            <img src="icons/reste.png" width="18" height="18" alt="reset">
        </a>
    </div>
</form>

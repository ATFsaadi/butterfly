<?php
$q = trim((string)($_GET["q"] ?? ""));
$page = (string)($_GET["page"] ?? "destinations");
$allowed = ["home", "destinations", "offres", "voyages"];
if (!in_array($page, $allowed, true)) {
    $page = "destinations";
}
?>

<form
    class="voyage-menu container-fluid py-3 justify-content-center align-items-center gap-3 d-flex flex-column flex-lg-row"
    method="get"
    action="index.php"
>
    <input type="hidden" name="page" value="<?= htmlspecialchars($page) ?>">

    <div class="voyage-field">
        <label class="form-label">Destination</label>
        <input
            type="text"
            name="q"
            class="form-control"
            placeholder="pays, ville ou continent..."
            value="<?= htmlspecialchars($q) ?>"
        >
    </div>

    <div class="voyage-search-group">
        <button class="voyage-search-btn" type="submit">
            <span>rechercher</span>
            <img src="icons/loupe.png" class="search-icon" alt="search">
        </button>

        <a class="voyage-reset-icon" href="index.php?page=<?= htmlspecialchars($page) ?>">
            <img src="icons/reste.png" width="18" height="18" alt="reset">
        </a>
    </div>
</form>

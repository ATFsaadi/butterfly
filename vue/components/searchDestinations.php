<?php
$destinations = $destinations ?? [];
?>

<!-- =========================
     FILTRE DESKTOP (FORMULAIRE PRINCIPAL)
     ========================= -->
<form class="voyage-menu d-none d-lg-flex container-fluid py-3 justify-content-center align-items-center gap-3"
      method="get"
      action="index.php">

    <input type="hidden" name="page" value="destinations">

    <!-- valeurs envoyées -->
    <input type="hidden" name="depart" id="departInput">
    <input type="hidden" name="destination" id="destinationInput">

    <!-- depart -->
    <div class="voyage-dropdown">
        <button class="voyage-btn" type="button">
            Ville de départ
            <span id="departSuggestion" class="voyage-suggestion">Tout endroit</span>
        </button>
        <ul class="voyage-dropdown-content" id="departList">
            <li data-value="">Tout endroit</li>
            <li data-value="Paris">Paris</li>
            <li data-value="Lyon">Lyon</li>
            <li data-value="Marseille">Marseille</li>
        </ul>
    </div>

    <!-- destination -->
    <div class="voyage-dropdown">
        <button class="voyage-btn" type="button">
            Destination
            <span id="destinationSuggestion" class="voyage-suggestion">N'importe où</span>
        </button>
        <ul class="voyage-dropdown-content" id="destinationList">
            <li data-value="">N'importe où</li>
            <li data-value="Paris">Paris</li>
            <li data-value="Barcelone">Barcelone</li>
            <li data-value="Marrakech">Marrakech</li>
        </ul>
    </div>

    <!-- dates -->
    <div class="voyage-dropdown">
        <button class="voyage-btn" type="button">
            Départ / Retour
            <span class="voyage-suggestion">Aujourd'hui</span>
        </button>

        <div class="voyage-dropdown-content p-3">
            <label class="form-label small">Départ</label>
            <input type="date" name="date_depart" class="form-control form-control-sm">

            <label class="form-label small mt-2">Retour</label>
            <input type="date" name="date_retour" class="form-control form-control-sm">
        </div>
    </div>

    <!-- actions -->
    <div class="voyage-search-group">
        <button class="voyage-search-btn" type="submit">
            <span>Rechercher</span>
            <img src="icons/loupe.png" class="search-icon" alt="search">
        </button>

        <a class="voyage-reset-icon" href="index.php?page=destinations">
            <img src="icons/reste.png" width="18" height="18" alt="reset">
        </a>
    </div>
</form>

<!-- =========================
     FILTRE MOBILE
     ========================= -->
<button class="mobile-search-toggle d-lg-none mx-auto d-flex align-items-center justify-content-center gap-3"
        type="button">
    🔍 Rechercher un voyage
</button>

<div class="voyage-mobile-drawer">

    <div class="container py-4">

        <form method="get" action="index.php">
            <input type="hidden" name="page" value="destinations">
            <input type="hidden" name="depart" id="departInputMobile">
            <input type="hidden" name="destination" id="destinationInputMobile">

            <div class="voyage-dropdown">
                <button class="voyage-btn w-100 text-start" type="button">
                    Ville de départ
                    <span id="departSuggestionMobile" class="voyage-suggestion float-end">Tout endroit</span>
                </button>
                <ul class="voyage-dropdown-content" id="departListMobile">
                    <li data-value="">Tout endroit</li>
                    <li data-value="Paris">Paris</li>
                    <li data-value="Lyon">Lyon</li>
                    <li data-value="Marseille">Marseille</li>
                </ul>
            </div>

            <div class="voyage-dropdown">
                <button class="voyage-btn w-100 text-start" type="button">
                    Destination
                    <span id="destinationSuggestionMobile" class="voyage-suggestion float-end">N'importe où</span>
                </button>
                <ul class="voyage-dropdown-content" id="destinationListMobile">
                    <li data-value="">N'importe où</li>
                    <li data-value="Paris">Paris</li>
                    <li data-value="Barcelone">Barcelone</li>
                    <li data-value="Marrakech">Marrakech</li>
                </ul>
            </div>

            <div class="voyage-dropdown">
                <button class="voyage-btn w-100 text-start" type="button">
                    Départ / Retour
                </button>
                <div class="voyage-dropdown-content p-3">
                    <label class="form-label small">Départ</label>
                    <input type="date" name="date_depart" class="form-control form-control-sm">

                    <label class="form-label small mt-2">Retour</label>
                    <input type="date" name="date_retour" class="form-control form-control-sm">
                </div>
            </div>

            <div class="d-flex flex-column gap-3 mt-4">
                <button class="voyage-search-btn w-100 py-4 fs-5" type="submit">
                    Rechercher
                </button>
                <a href="index.php?page=destinations"
                   class="btn btn-outline-secondary mx-auto px-5">
                    Réinitialiser
                </a>
            </div>
        </form>

    </div>
</div>

<!-- =========================
     LISTE DES DESTINATIONS
     ========================= -->
<div class="container mt-5">

    <?php if (empty($destinations)): ?>
        <div class="alert alert-info text-center">
            Aucune destination trouvée.
        </div>
    <?php else: ?>

        <div class="row g-4">
            <?php foreach ($destinations as $d): ?>
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm">

                        <?php if (!empty($d['image_url'])): ?>
                            <img src="<?= htmlspecialchars($d['image_url']) ?>"
                                 class="card-img-top"
                                 style="height:200px; object-fit:cover;">
                        <?php endif; ?>

                        <div class="card-body">
                            <h5 class="card-title">
                                <?= htmlspecialchars($d['ville']) ?> — <?= htmlspecialchars($d['pays']) ?>
                            </h5>

                            <p class="text-muted small">
                                <?= htmlspecialchars($d['continent'] ?? '') ?>
                            </p>

                            <p class="fw-bold">
                                <?= number_format((float)$d['prix_base'], 2, ',', ' ') ?> €
                            </p>

                            <a href="index.php?page=destination_detail&id_destination=<?= (int)$d['id_destination'] ?>"
                               class="btn btn-primary w-100">
                                Voir
                            </a>
                        </div>

                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    <?php endif; ?>
</div>


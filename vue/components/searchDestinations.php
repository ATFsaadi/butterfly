<?php

$villesDepart = $villesDepart ?? [];
$destinations = $destinations ?? [];
?>

<!-- version desktop -->
<div class="voyage-menu d-none d-lg-flex container-fluid py-3 justify-content-center align-items-center gap-3">

    <!-- depart -->
    <div class="voyage-dropdown">
        <button id="departBtn" class="voyage-btn">
            Ville de départ
            <span id="departSuggestion" class="voyage-suggestion">Tout endroit</span>
        </button>
        <ul class="voyage-dropdown-content">
            <li onclick="selectOption('depart', this)">Tout endroit</li>
            <?php foreach ($villesDepart as $ville): ?>
                <li onclick="selectOption('depart', this)"><?= htmlspecialchars($ville) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>

    <!-- destination -->
    <div class="voyage-dropdown">
        <button id="destinationBtn" class="voyage-btn">
            Destination
            <span id="destinationSuggestion" class="voyage-suggestion">N'importe où</span>
        </button>
        <ul class="voyage-dropdown-content">
            <li onclick="selectOption('destination', this)">N'importe où</li>
            <?php foreach ($destinations as $dest): ?>
                <li onclick="selectOption('destination', this)"><?= htmlspecialchars($dest['nom']) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>

    <!-- personnes -->
    <div class="voyage-dropdown">
        <button id="personnesBtn" class="voyage-btn">
            Personnes
            <span id="personnesSuggestion" class="voyage-suggestion">1 adulte</span>
        </button>

        <!-- compteur personnes -->
        <div class="voyage-dropdown-content p-3">
            <div class="personne-row">
                <span class="label">Adultes</span>
                <div class="counter">
                    <button class="btn-counter" onclick="updateCount('adultes', -1)">−</button>
                    <span id="adultesCount" class="count">1</span>
                    <button class="btn-counter" onclick="updateCount('adultes', 1)">+</button>
                </div>
            </div>

            <div class="personne-row">
                <span class="label">Enfants</span>
                <div class="counter">
                    <button class="btn-counter" onclick="updateCount('enfants', -1)">−</button>
                    <span id="enfantsCount" class="count">0</span>
                    <button class="btn-counter" onclick="updateCount('enfants', 1)">+</button>
                </div>
            </div>

            <div class="personne-row">
                <span class="label">Bébés</span>
                <div class="counter">
                    <button class="btn-counter" onclick="updateCount('bebes', -1)">−</button>
                    <span id="bebesCount" class="count">0</span>
                    <button class="btn-counter" onclick="updateCount('bebes', 1)">+</button>
                </div>
            </div>
        </div>
    </div>

    <!-- dates -->
    <div class="voyage-dropdown">
        <button id="dateButton" class="voyage-btn">
            Départ / Retour
            <span id="dateSuggestion" class="voyage-suggestion">Aujourd'hui</span>
        </button>

        <!-- selection dates -->
        <div class="voyage-dropdown-content p-3">
            <label class="form-label small">Départ</label>
            <input type="date" id="dateDepart" class="form-control form-control-sm" onchange="updateDateSuggestion()">

            <label class="form-label small mt-2">Retour</label>
            <input type="date" id="dateArrivee" class="form-control form-control-sm" onchange="updateDateSuggestion()">
        </div>
    </div>

    <!-- actions -->
    <div class="voyage-search-group">
        <div class="voyage-search-btn">
            <span>Rechercher</span>
            <img src="icons/loupe.png" alt="rechercher" class="search-icon">
        </div>
        <button class="voyage-reset-icon" onclick="resetFilters()">
            <img src="icons/reste.png" width="18" height="18" alt="reset">
        </button>
    </div>
</div>

<!-- version mobile -->
<button class="mobile-search-toggle d-lg-none mx-auto d-flex align-items-center justify-content-center gap-3" onclick="openDrawer()">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.8" stroke-linecap="round" stroke-linejoin="round">
        <circle cx="11" cy="11" r="8"></circle>
        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
    </svg>
    <span>Rechercher un voyage</span>
</button>

<!-- drawer mobile -->
<div class="voyage-mobile-drawer" id="voyageDrawer">

    <!-- entete -->
    <div class="drawer-header">
        <h4 style="margin:0; color:var(--primary-color); font-family:'Lavishly Yours',cursive; font-size:2rem;">
            Rechercher votre voyage
        </h4>
        <button class="close-drawer" onclick="closeDrawer()">×</button>
    </div>

    <!-- contenu -->
    <div class="container py-4">

        <!-- depart -->
        <div class="voyage-dropdown">
            <button class="voyage-btn w-100 text-start">
                Ville de départ
                <span id="departSuggestionMobile" class="voyage-suggestion float-end">Tout endroit</span>
            </button>
            <ul class="voyage-dropdown-content">
                <li onclick="selectOption('depart', this, true)">Tout endroit</li>
                <?php foreach ($villesDepart as $ville): ?>
                    <li onclick="selectOption('depart', this, true)"><?= htmlspecialchars($ville) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>

        <!-- destination -->
        <div class="voyage-dropdown">
            <button class="voyage-btn w-100 text-start">
                Destination
                <span id="destinationSuggestionMobile" class="voyage-suggestion float-end">N'importe où</span>
            </button>
            <ul class="voyage-dropdown-content">
                <li onclick="selectOption('destination', this, true)">N'importe où</li>
                <?php foreach ($destinations as $dest): ?>
                    <li onclick="selectOption('destination', this, true)"><?= htmlspecialchars($dest['nom']) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>

        <!-- personnes -->
        <div class="voyage-dropdown">
            <button class="voyage-btn w-100 text-start">
                Personnes
                <span id="personnesSuggestionMobile" class="voyage-suggestion float-end">1 adulte</span>
            </button>

            <!-- compteur personnes -->
            <div class="voyage-dropdown-content p-3">
                <div class="personne-row">
                    <span class="label">Adultes</span>
                    <div class="counter">
                        <button class="btn-counter" onclick="updateCount('adultes', -1, true)">−</button>
                        <span id="adultesCountMobile" class="count">1</span>
                        <button class="btn-counter" onclick="updateCount('adultes', 1, true)">+</button>
                    </div>
                </div>

                <div class="personne-row">
                    <span class="label">Enfants</span>
                    <div class="counter">
                        <button class="btn-counter" onclick="updateCount('enfants', -1, true)">−</button>
                        <span id="enfantsCountMobile" class="count">0</span>
                        <button class="btn-counter" onclick="updateCount('enfants', 1, true)">+</button>
                    </div>
                </div>

                <div class="personne-row">
                    <span class="label">Bébés</span>
                    <div class="counter">
                        <button class="btn-counter" onclick="updateCount('bebes', -1, true)">−</button>
                        <span id="bebesCountMobile" class="count">0</span>
                        <button class="btn-counter" onclick="updateCount('bebes', 1, true)">+</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- dates -->
        <div class="voyage-dropdown">
            <button class="voyage-btn w-100 text-start">
                Départ / Retour
                <span id="dateSuggestionMobile" class="voyage-suggestion float-end">Aujourd'hui</span>
            </button>

            <!-- selection dates -->
            <div class="voyage-dropdown-content p-3">
                <label class="form-label small">Départ</label>
                <input type="date" id="dateDepartMobile" class="form-control form-control-sm" onchange="updateDateSuggestion(true)">

                <label class="form-label small mt-2">Retour</label>
                <input type="date" id="dateArriveeMobile" class="form-control form-control-sm" onchange="updateDateSuggestion(true)">
            </div>
        </div>

        <!-- actions -->
        <div class="d-flex flex-column gap-3 mt-5">
            <button class="voyage-search-btn w-100 py-4 fs-5">Rechercher</button>
            <button class="btn btn-outline-secondary mx-auto px-5" onclick="resetFilters(true)">Réinitialiser</button>
        </div>

    </div>
</div>

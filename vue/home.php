<section class="voyage-menu-section">
    <div class="voyage-container">
        <!-- titre normal -->
        <div class="voyage-menu-title" id="voyageTitle">
            <h1>Pour un Voyage inoubliable ...</h1>
        </div>
    </div>
</section>

<!-- MENU STICKY – VERSION PARFAITE & SYNCHRONISÉE -->
<div id="voyageBar" class="position-sticky top-0 start-0 w-100 bg-white" style="z-index: 1030; border-bottom: 1px solid #eee;">

    <!-- VERSION DESKTOP : menu horizontal -->
    <div class="voyage-menu d-none d-lg-flex container-fluid py-3 justify-content-center align-items-center gap-3">
        <!-- Ville de départ -->
        <div class="voyage-dropdown">
            <button id="departBtn" class="voyage-btn">
                Ville de départ
                <span id="departSuggestion" class="voyage-suggestion">Tout endroit</span>
            </button>
            <ul class="voyage-dropdown-content">
                <li onclick="selectOption('depart', this)">Tout endroit</li>
                <li onclick="selectOption('depart', this)">Paris</li>
                <li onclick="selectOption('depart', this)">Marseille</li>
                <li onclick="selectOption('depart', this)">Lyon</li>
            </ul>
        </div>

        <!-- Destination -->
        <div class="voyage-dropdown">
            <button id="destinationBtn" class="voyage-btn">
                Destination
                <span id="destinationSuggestion" class="voyage-suggestion">N'importe où</span>
            </button>
            <ul class="voyage-dropdown-content">
                <li onclick="selectOption('destination', this)">N'importe où</li>
                <li onclick="selectOption('destination', this)">France</li>
                <li onclick="selectOption('destination', this)">États-Unis</li>
                <li onclick="selectOption('destination', this)">Japon</li>
            </ul>
        </div>

        <!-- Personnes -->
        <div class="voyage-dropdown">
            <button id="personnesBtn" class="voyage-btn">
                Personnes
                <span id="personnesSuggestion" class="voyage-suggestion">1 adulte</span>
            </button>
            <div class="voyage-dropdown-content p-3">
                <div class="personne-row"><span class="label">Adultes</span><div class="counter"><button class="btn-counter" onclick="updateCount('adultes', -1)">−</button><span id="adultesCount" class="count">1</span><button class="btn-counter" onclick="updateCount('adultes', 1)">+</button></div></div>
                <div class="personne-row"><span class="label">Enfants</span><div class="counter"><button class="btn-counter" onclick="updateCount('enfants', -1)">−</button><span id="enfantsCount" class="count">0</span><button class="btn-counter" onclick="updateCount('enfants', 1)">+</button></div></div>
                <div class="personne-row"><span class="label">Bébés</span><div class="counter"><button class="btn-counter" onclick="updateCount('bebes', -1)">−</button><span id="bebesCount" class="count">0</span><button class="btn-counter" onclick="updateCount('bebes', 1)">+</button></div></div>
            </div>
        </div>

        <!-- Dates -->
        <div class="voyage-dropdown">
            <button id="dateButton" class="voyage-btn">
                Départ / Retour
                <span id="dateSuggestion" class="voyage-suggestion">Aujourd'hui</span>
            </button>
            <div class="voyage-dropdown-content p-3">
                <label class="form-label small">Départ</label>
                <input type="date" id="dateDepart" class="form-control form-control-sm" onchange="updateDateSuggestion()">
                <label class="form-label small mt-2">Retour</label>
                <input type="date" id="dateArrivee" class="form-control form-control-sm" onchange="updateDateSuggestion()">
            </div>
        </div>

        <!-- Boutons -->
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

    <!-- VERSION MOBILE : Bouton unique -->
    <button class="mobile-search-toggle d-lg-none mx-auto d-flex align-items-center justify-content-center gap-3" onclick="openDrawer()">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.8" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="11" cy="11" r="8"></circle>
            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
        </svg>
        <span>Rechercher un voyage</span>
    </button>

    <!-- DRAWER MOBILE – Utilise les MÊMES IDs que desktop → tout est synchronisé ! -->
    <div class="voyage-mobile-drawer" id="voyageDrawer">
        <div class="drawer-header">
            <h4 style="margin:0; color:var(--primary-color); font-family:'Lavishly Yours',cursive; font-size:2rem;">
                Rechercher votre voyage
            </h4>
            <button class="close-drawer" onclick="closeDrawer()">×</button>
        </div>

        <div class="container py-4">
            <!-- On réutilise exactement les mêmes éléments (IDs identiques) -->
            <div class="voyage-dropdown">
                <button class="voyage-btn w-100 text-start">Ville de départ <span id="departSuggestion" class="voyage-suggestion float-end">Tout endroit</span></button>
                <ul class="voyage-dropdown-content">
                    <li onclick="selectOption('depart', this)">Tout endroit</li>
                    <li onclick="selectOption('depart', this)">Paris</li>
                    <li onclick="selectOption('depart', this)">Marseille</li>
                    <li onclick="selectOption('depart', this)">Lyon</li>
                </ul>
            </div>

            <div class="voyage-dropdown">
                <button class="voyage-btn w-100 text-start">Destination <span id="destinationSuggestion" class="voyage-suggestion float-end">N'importe où</span></button>
                <ul class="voyage-dropdown-content">
                    <li onclick="selectOption('destination', this)">N'importe où</li>
                    <li onclick="selectOption('destination', this)">France</li>
                    <li onclick="selectOption('destination', this)">États-Unis</li>
                    <li onclick="selectOption('destination', this)">Japon</li>
                </ul>
            </div>

            <div class="voyage-dropdown">
                <button class="voyage-btn w-100 text-start">Personnes <span id="personnesSuggestion" class="voyage-suggestion float-end">1 adulte</span></button>
                <div class="voyage-dropdown-content p-3">
                    <div class="personne-row"><span class="label">Adultes</span><div class="counter"><button class="btn-counter" onclick="updateCount('adultes', -1)">−</button><span id="adultesCount" class="count">1</span><button class="btn-counter" onclick="updateCount('adultes', 1)">+</button></div></div>
                    <div class="personne-row"><span class="label">Enfants</span><div class="counter"><button class="btn-counter" onclick="updateCount('enfants', -1)">−</button><span id="enfantsCount" class="count">0</span><button class="btn-counter" onclick="updateCount('enfants', 1)">+</button></div></div>
                    <div class="personne-row"><span class="label">Bébés</span><div class="counter"><button class="btn-counter" onclick="updateCount('bebes', -1)">−</button><span id="bebesCount" class="count">0</span><button class="btn-counter" onclick="updateCount('bebes', 1)">+</button></div></div>
                </div>
            </div>

            <div class="voyage-dropdown">
                <button class="voyage-btn w-100 text-start">Départ / Retour <span id="dateSuggestion" class="voyage-suggestion float-end">Aujourd'hui</span></button>
                <div class="voyage-dropdown-content p-3">
                    <label class="form-label small">Départ</label>
                    <input type="date" id="dateDepart" class="form-control form-control-sm" onchange="updateDateSuggestion()">
                    <label class="form-label small mt-2">Retour</label>
                    <input type="date" id="dateArrivee" class="form-control form-control-sm" onchange="updateDateSuggestion()">
                </div>
            </div>

            <div class="d-flex flex-column gap-3 mt-5">
                <button class="voyage-search-btn w-100 py-4 fs-5">Rechercher</button>
                <button class="btn btn-outline-secondary mx-auto px-5" onclick="resetFilters()">Réinitialiser</button>
            </div>
        </div>
    </div>
</div>

<!-- section selection -->
<section class="selection-section mt-5 py-5 bg-light">
    <div class="container text-center">
         <h3 class="section-title">notre selection</h3>
        <p class="section-subtitle">decouvrez nos destinations preferees</p>
        <div id="selectionCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <!-- slide 1 -->
                <div class="carousel-item active">
                    <div class="row g-4">
                        <div class="col-md-6"><div class="card h-100 shadow-sm">
                            <img src="slides/mountains-862870_1280.jpg" class="card-img-top" alt="montagnes">
                            <div class="card-body d-flex flex-column">
                                <h6 class="card-title">montagnes enchantees</h6>
                                <p class="card-text flex-grow-1">explorez les sommets de bejaia.</p>
                                <a href="#" class="btn btn-outline-dark rounded-pill mt-auto">decouvrir</a>
                            </div>
                        </div></div>
                        <div class="col-md-6"><div class="card h-100 shadow-sm">
                            <img src="slides/maldives-5071309_1280.jpg" class="card-img-top" alt="plages">
                            <div class="card-body d-flex flex-column">
                                <h6 class="card-title">plages de reve</h6>
                                <p class="card-text flex-grow-1">eaux cristallines de la mediterranee.</p>
                                <a href="#" class="btn btn-outline-dark rounded-pill mt-auto">decouvrir</a>
                            </div>
                        </div></div>
                    </div>
                </div>
                <!-- autres slides (simplifiées) -->
                <?php for ($i = 1; $i <= 2; $i++): ?>
                <div class="carousel-item">
                    <div class="row g-4">
                        <div class="col-md-6"><div class="card h-100 shadow-sm">
                            <img src="images/slides/<?= $i === 1 ? 'Mont-saint-michel.avif' : 'surf.jpg' ?>" class="card-img-top" alt="">
                            <div class="card-body d-flex flex-column">
                                <h6 class="card-title"><?= $i === 1 ? 'villages authentiques' : 'aventures en mer' ?></h6>
                                <p class="card-text flex-grow-1"><?= $i === 1 ? 'culture locale pittoresque.' : 'naviguez vers l\'inconnu.' ?></p>
                                <a href="#" class="btn btn-outline-dark rounded-pill mt-auto">decouvrir</a>
                            </div>
                        </div></div>
                        <div class="col-md-6"><div class="card h-100 shadow-sm">
                            <img src="slides/<?= $i === 1 ? 'forest-3409907_1280.jpg' : 'mountain-4635428_1920.jpg' ?>" class="card-img-top" alt="">
                            <div class="card-body d-flex flex-column">
                                <h6 class="card-title"><?= $i === 1 ? 'forets mysterieuses' : 'paysages epoustouflants' ?></h6>
                                <p class="card-text flex-grow-1"><?= $i === 1 ? 'sentiers secrets anciens.' : 'vues a couper le souffle.' ?></p>
                                <a href="#" class="btn btn-outline-dark rounded-pill mt-auto">decouvrir</a>
                            </div>
                        </div></div>
                    </div>
                </div>
                <?php endfor; ?>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#selectionCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#selectionCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
            </button>
        </div>
    </div>
</section>

<!-- section offres -->
<section class="offers-section mt-5 py-5">
    <div class="container text-center">
        <h3 class="section-title">nos offres</h3>
        <p class="section-subtitle">meilleures offres pour vos aventures</p>
        <div id="offerCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <?php
                $offers = [
                    ['forest-6364913_1280.jpg', 'montagnes enchantees', 'reduction exclusive sur les sommets'],
                    ['maldives-5071306_1280.jpg', 'plages de reve', 'evadez-vous vers le paradis'],
                    ['norway-5215881_1280.jpg', 'forets mysterieuses', 'offre speciale nature']
                ];
                foreach ($offers as $i => [$img, $title, $text]):
                ?>
                <div class="carousel-item <?= $i === 0 ? 'active' : '' ?>">
                    <div class="card big-card mx-auto shadow-lg" style="max-width: 500px;">
                        <img src="slides/<?= $img ?>" class="card-img-top" alt="<?= $title ?>">
                        <div class="card-body text-center">
                            <h6 class="card-title"><?= $title ?></h6>
                            <p class="card-text"><?= $text ?></p>
                            <a href="#" class="btn btn-outline-dark rounded-pill px-5">reserver maintenant</a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#offerCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#offerCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
            </button>
        </div>
    </div>
</section>

<!-- chargement du script specifique -->
<script src="js/home.js" defer></script>

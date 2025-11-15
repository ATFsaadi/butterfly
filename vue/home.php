<!-- section menu voyage -->
<section class="voyage-menu-section">
    <div class="voyage-container">
        <div class="voyage-menu-title">
            <h1>Pour un Voyage inoubliable ...</h1>
        </div>
        <div class="voyage-menu">

            <!-- ville de départ -->
            <div class="voyage-dropdown">
                <button id="departBtn" class="voyage-btn" aria-label="sélectionner la ville de départ">
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
            
            <!-- destination -->
            <div class="voyage-dropdown">
                <button id="destinationBtn" class="voyage-btn" aria-label="sélectionner la destination">
                    destination
                    <span id="destinationSuggestion" class="voyage-suggestion">N'importe où</span>
                </button>
                <ul class="voyage-dropdown-content">
                    <li onclick="selectOption('destination', this)">N'importe où</li>
                    <li onclick="selectOption('destination', this)">France</li>
                    <li onclick="selectOption('destination', this)">États-unis</li>
                    <li onclick="selectOption('destination', this)">Japon</li>
                </ul>
            </div>

            <!-- dates départ /  retour -->
            <div class="voyage-dropdown">
                <button id="dateButton" class="voyage-btn" aria-label="ouvrir le sélecteur de dates">
                    Départ / Retour
                    <span id="dateSuggestion" class="voyage-suggestion"></span>
                </button>
                <div class="voyage-dropdown-content p-3">
                    <div class="mb-2">
                        <label for="dateDepart" class="form-label small">Départ</label>
                        <input type="date" id="dateDepart" class="form-control form-control-sm" onchange="updateDateSuggestion()">
                    </div>
                    <div>
                        <label for="dateArrivee" class="form-label small">Retour</label>
                        <input type="date" id="dateArrivee" class="form-control form-control-sm" onchange="updateDateSuggestion()">
                    </div>
                </div>
            </div>

            <!-- personnes -->
            <div class="voyage-dropdown">
                <button id="personnesBtn" class="voyage-btn" aria-label="sélectionner le nombre de personnes">
                    Personnes
                    <span id="personnesSuggestion" class="voyage-suggestion">1 adulte</span>
                </button>
                <div class="voyage-dropdown-content p-2">
                    <!-- Adultes -->
                    <div class="personne-row">
                        <span class="label">Adultes</span>
                        <div class="counter">
                            <button type="button" class="btn-counter" onclick="updateCount('adultes', -1)">−</button>
                            <span id="adultesCount" class="count">1</span>
                            <button type="button" class="btn-counter" onclick="updateCount('adultes', 1)">+</button>
                        </div>
                    </div>
                    <!-- Enfants -->
                    <div class="personne-row">
                        <span class="label">Enfants</span>
                        <div class="counter">
                            <button type="button" class="btn-counter" onclick="updateCount('enfants', -1)">−</button>
                            <span id="enfantsCount" class="count">0</span>
                            <button type="button" class="btn-counter" onclick="updateCount('enfants', 1)">+</button>
                        </div>
                    </div>
                    <!-- Bébés -->
                    <div class="personne-row">
                        <span class="label">Bébés</span>
                        <div class="counter">
                            <button type="button" class="btn-counter" onclick="updateCount('bebes', -1)">−</button>
                            <span id="bebesCount" class="count">0</span>
                            <button type="button" class="btn-counter" onclick="updateCount('bebes', 1)">+</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- boutons rechercher / reset -->
            <table>
                <tr>
                    <td>
                        <button class="voyage-search-btn" aria-label="lancer la recherche">
                            <img src="icons/loupe.png" width="18" height="18" alt="rechercher" class="search-icon">
                            Rechercher
                        </button>
                    </td>
                    <td>
                        <button class="voyage-reset-icon" aria-label="réinitialiser les filtres">
                            <img src="icons/reste.png" width="20" height="20" alt="réinitialiser">
                        </button>
                    </td>
                </tr>
            </table>

        </div>
    </div>
</section>

<!-- carousel principal -->
<div id="mainCarousel" class="carousel slide mt-4" data-bs-ride="carousel">
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="0" class="active"></button>
        <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="1"></button>
        <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="2"></button>
        <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="3"></button>
    </div>
    <div class="carousel-inner">
        <?php
        $slides = [
            ['oran2.jpg', 'decouvrir oran', 'el bahia, ville cotiere algerienne...'],
            ['motagne.png', 'magnifique montagne', 'la beaute des montagnes...'],
            ['mer.jpg', 'voyage en mer', 'explorez les horizons marins...'],
            ['le monde.png', 'explorer le monde', 'un voyage inoubliable...']
        ];
        foreach ($slides as $i => [$img, $title, $text]):
        ?>
        <div class="carousel-item <?= $i === 0 ? 'active' : '' ?>">
            <img src="images/slides/<?= $img ?>" class="d-block w-100 carousel-image" alt="<?= $title ?>">
            <div class="carousel-caption d-flex h-100 align-items-center justify-content-center">
                <div class="text-center text-white">
                    <h6><?= $title ?></h6>
                    <p class="d-none d-md-block"><?= $text ?></p>
                    <button class="btn btn-outline-light rounded-pill px-4 mt-2">decouvrir</button>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#mainCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#mainCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
    </button>
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
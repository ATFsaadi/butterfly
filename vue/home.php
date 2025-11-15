<!-- section menu voyage -->
<section class="voyage-menu-section">
    <div class="voyage-container">
        <div class="voyage-menu-title">
            <h1>Pour un Voyage inoubliable ...</h1>
        </div>
        <div class="voyage-menu">

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

            <!-- dates départ / arrivée -->
            <div class="voyage-dropdown">
                <button id="dateButton" class="voyage-btn" aria-label="ouvrir le sélecteur de dates">
                    Départ / Arrivée
                    <span id="dateSuggestion" class="voyage-suggestion"></span>
                </button>
                <div class="voyage-dropdown-content p-3">
                    <div class="mb-2">
                        <label for="dateDepart" class="form-label small">Départ</label>
                        <input type="date" id="dateDepart" class="form-control form-control-sm" onchange="updateDateSuggestion()">
                    </div>
                    <div>
                        <label for="dateArrivee" class="form-label small">Arrivée</label>
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
                    <!-- adultes -->
                    <div class="personne-row">
                        <span class="label">Adultes</span>
                        <div class="counter">
                            <button type="button" class="btn-counter" onclick="updateCount('adultes', -1)">−</button>
                            <span id="adultesCount" class="count">1</span>
                            <button type="button" class="btn-counter" onclick="updateCount('adultes', 1)">+</button>
                        </div>
                    </div>
                    <!-- enfants -->
                    <div class="personne-row">
                        <span class="label">Enfants</span>
                        <div class="counter">
                            <button type="button" class="btn-counter" onclick="updateCount('enfants', -1)">−</button>
                            <span id="enfantsCount" class="count">0</span>
                            <button type="button" class="btn-counter" onclick="updateCount('enfants', 1)">+</button>
                        </div>
                    </div>
                    <!-- bébés -->
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
<div id="carouselExampleIndicators" class="carousel slide mt-4" data-bs-ride="carousel">
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="slide 1"></button>
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="slide 2"></button>
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="slide 3"></button>
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="3" aria-label="slide 4"></button>
    </div>
    <div class="carousel-inner">
        <!-- slide 1 -->
        <div class="carousel-item active">
            <img src="images/slides/oran2.jpg" class="d-block w-100 carousel-image" alt="vue d'Oran, algérie">
            <div class="carousel-caption d-flex justify-content-center align-items-center h-100">
                <div class="text-center">
                    <h6>Découvrir oran</h6>
                    <p>El bahia, ville côtière algérienne, mêle charme méditerranéen, histoire riche et culture vivante.</p>
                    <div class="col-md d-grid">
                        <button type="button" class="btn btn-outline-dark w-100 rounded-pill py-2">découvrir</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- slide 2 -->
        <div class="carousel-item">
            <img src="images/slides/motagne.png" class="d-block w-100 carousel-image" alt="paysage montagneux">
            <div class="carousel-caption d-flex justify-content-center align-items-center h-100">
                <div class="text-center">
                    <h6>Magnifique montagne</h6>
                    <p>La beauté des montagnes qui vous attend.</p>
                    <div class="col-md d-grid">
                        <button type="button" class="btn btn-outline-dark w-100 rounded-pill py-2">découvrir</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- slide 3 -->
        <div class="carousel-item">
            <img src="images/slides/mer.jpg" class="d-block w-100 carousel-image" alt="paysage marin">
            <div class="carousel-caption d-flex justify-content-center align-items-center h-100">
                <div class="text-center">
                    <h6>Voyage en mer</h6>
                    <p>Explorez les horizons marins comme jamais auparavant.</p>
                    <div class="col-md d-grid">
                        <button type="button" class="btn btn-outline-dark w-100 rounded-pill py-2">découvrir</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- slide 4 -->
        <div class="carousel-item">
            <img src="images/slides/le monde.png" class="d-block w-100 carousel-image" alt="paysages mondiaux">
            <div class="carousel-caption d-flex justify-content-center align-items-center h-100">
                <div class="text-center">
                    <h6>Explorer le monde</h6>
                    <p>Un voyage inoubliable à travers des paysages incroyables.</p>
                    <div class="col-md d-grid">
                        <button type="button" class="btn btn-outline-dark w-100 rounded-pill py-2">découvrir</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev" aria-label="précédent">
        <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next" aria-label="suivant">
        <span class="carousel-control-next-icon"></span>
    </button>
</div>

<!-- section sélection -->
<section class="selection-section mt-5">
    <div class="container text-center">
        <h3 class="section-title">Notre sélection</h3>
        <p class="section-subtitle">Découvrez nos destinations préférées pour vos prochaines aventures.</p>
        <div id="cardCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <!-- slide 1 -->
                <div class="carousel-item active">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <img src="slides/mountains-862870_1280.jpg" class="card-img-top" alt="montagnes de bejaia">
                                <div class="card-body">
                                    <h6 class="card-title">Montagnes enchantées</h6>
                                    <p class="card-text">Explorez les sommets majestueux de bejaia.</p>
                                    <a href="#" class="btn btn-outline-dark rounded-pill">Découvrir</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <img src="slides/maldives-5071309_1280.jpg" class="card-img-top" alt="plages de la méditerranée">
                                <div class="card-body">
                                    <h6 class="card-title">Plages de rêve</h6>
                                    <p class="card-text">Profitez des eaux cristallines de la méditerranée.</p>
                                    <a href="#" class="btn btn-outline-dark rounded-pill">Découvrir</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- slide 2 -->
                <div class="carousel-item">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <img src="images/slides/Mont-saint-michel.avif" class="card-img-top" alt="villages pittoresques">
                                <div class="card-body">
                                    <h6 class="card-title">Villages authentiques</h6>
                                    <p class="card-text">Découvrez la culture locale dans des villages pittoresques.</p>
                                    <a href="#" class="btn btn-outline-dark rounded-pill">Découvrir</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <img src="slides/forest-3409907_1280.jpg" class="card-img-top" alt="forêts anciennes">
                                <div class="card-body">
                                    <h6 class="card-title">Forêts mystérieuses</h6>
                                    <p class="card-text">Parcourez les sentiers secrets des forêts anciennes.</p>
                                    <a href="#" class="btn btn-outline-dark rounded-pill">Découvrir</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- slide 3 -->
                <div class="carousel-item">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <img src="images/slides/surf.jpg" class="card-img-top" alt="aventures marines">
                                <div class="card-body">
                                    <h6 class="card-title">Aventures en mer</h6>
                                    <p class="card-text">Naviguez vers l'inconnu sur des eaux turquoise.</p>
                                    <a href="#" class="btn btn-outline-dark rounded-pill">Découvrir</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <img src="slides/mountain-4635428_1920.jpg" class="card-img-top" alt="paysages de bejaia">
                                <div class="card-body">
                                    <h6 class="card-title">Paysages époustouflants</h6>
                                    <p class="card-text">Admirez les paysages à couper le souffle de bejaia.</p>
                                    <a href="#" class="btn btn-outline-dark rounded-pill">Découvrir</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#cardCarousel" data-bs-slide="prev" aria-label="précédent">
                <span class="carousel-control-prev-icon"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#cardCarousel" data-bs-slide="next" aria-label="suivant">
                <span class="carousel-control-next-icon"></span>
            </button>
        </div>
    </div>
</section>

<!-- section offres -->
<section class="offers-section mt-5">
    <div class="container text-center">
        <h3 class="section-title">Nos offres</h3>
        <p class="section-subtitle">Découvrez nos meilleures offres pour vos prochaines aventures.</p>
        <div id="offerCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <!-- offre 1 -->
                <div class="carousel-item active">
                    <div class="card big-card mx-auto">
                        <img src="slides/forest-6364913_1280.jpg" class="card-img-top" alt="offre montagnes enchantées">
                        <div class="card-body">
                            <h6 class="card-title">Offre spéciale : montagnes enchantées</h6>
                            <p class="card-text">Profitez d'une réduction exclusive pour découvrir les sommets majestueux.</p>
                            <a href="#" class="btn btn-outline-dark rounded-pill">Réserver maintenant</a>
                        </div>
                    </div>
                </div>
                <!-- offre 2 -->
                <div class="carousel-item">
                    <div class="card big-card mx-auto">
                        <img src="slides/maldives-5071306_1280.jpg" class="card-img-top" alt="offre plages de rêve">
                        <div class="card-body">
                            <h6 class="card-title">Offre plages de rêve</h6>
                            <p class="card-text">Évadez-vous vers des plages paradisiaques avec notre offre limitée.</p>
                            <a href="#" class="btn btn-outline-dark rounded-pill">Réserver maintenant</a>
                        </div>
                    </div>
                </div>
                <!-- offre 3 -->
                <div class="carousel-item">
                    <div class="card big-card mx-auto">
                        <img src="slides/norway-5215881_1280.jpg" class="card-img-top" alt="offre forêts mystérieuses">
                        <div class="card-body">
                            <h6 class="card-title">Offre forêts mystérieuses</h6>
                            <p class="card-text">Explorez les forêts anciennes avec une offre spéciale pour les amateurs de nature.</p>
                            <a href="#" class="btn btn-outline-dark rounded-pill">Réserver maintenant</a>
                        </div>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#offerCarousel" data-bs-slide="prev" aria-label="précédent">
                <span class="carousel-control-prev-icon"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#offerCarousel" data-bs-slide="next" aria-label="suivant">
                <span class="carousel-control-next-icon"></span>
            </button>
        </div>
    </div>
</section>

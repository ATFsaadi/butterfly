<?php include 'includes/header.php';?>
<section class="voyage-menu-section">
    <div class="voyage-container">
        <div class="voyage-menu-title">
            <h1>Pour un voyage de rêve ...</h1>
        </div>
        <div class="voyage-menu">
            <div class="voyage-dropdown">
                <button class="voyage-btn" aria-label="Sélectionner le type de voyage">Type de Voyage
                    <span class="voyage-suggestion">Séjour</span>
                </button>
                <ul class="voyage-dropdown-content">
                    <li>Séjour</li>
                    <li>Aventure</li>
                    <li>Plage</li>
                    <li>Culture</li>
                </ul>
            </div>
            <div class="voyage-dropdown">
                <button class="voyage-btn" aria-label="Sélectionner la destination">Destination
                    <span class="voyage-suggestion">N'importe où</span>
                </button>
                <ul class="voyage-dropdown-content">
                    <li>N'importe où</li>
                    <li>France</li>
                    <li>États-Unis</li>
                    <li>Japon</li>
                </ul>
            </div>
            <div class="voyage-dropdown">
                <button class="voyage-btn" aria-label="Sélectionner la ville de départ">Ville de Départ
                    <span class="voyage-suggestion">Tout endroit</span>
                </button>
                <ul class="voyage-dropdown-content">
                    <li>Tout endroit</li>
                    <li>Paris</li>
                    <li>Marseille</li>
                    <li>Lyon</li>
                </ul>
            </div>
            <div class="voyage-dropdown">
                <button id="dateButton" class="voyage-btn" aria-label="Ouvrir le sélecteur de date de départ">Date de Départ
                    <span class="voyage-suggestion"></span>
                </button>
                <div class="voyage-dropdown-content">
                    <input type="date" id="dateDepart" class="voyage-date-picker" aria-label="Sélectionner la date de départ">
                </div>
            </div>
            <div class="voyage-dropdown">
                <button class="voyage-btn" aria-label="Sélectionner la durée du voyage">Durée
                    <span class="voyage-suggestion">Peu importe</span>
                </button>
                <ul class="voyage-dropdown-content">
                    <li>Peu importe</li>
                    <li>1 jour</li>
                    <li>3 jours</li>
                    <li>1 semaine</li>
                    <li>2 semaines</li>
                </ul>
            </div>
            <div class="voyage-reset-icon-container">
                <button class="voyage-reset-icon" aria-label="Réinitialiser les filtres">
                    <img src="icons/reste.png" width="20" height="20" alt="Réinitialiser">
                </button>
            </div>
            <div class="voyage-search-container">
                <button class="voyage-search-btn" aria-label="Lancer la recherche">
                    <img src="icons/loupe.png" width="18" height="18" alt="Rechercher" class="search-icon">
                    Rechercher
                </button>
            </div>
        </div>
    </div>
</section>
<div id="carouselExampleIndicators" class="carousel slide mt-4" data-bs-ride="carousel">
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="3" aria-label="Slide 4"></button>
    </div>
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="carousel/oran2.jpg" class="d-block w-100 carousel-image" alt="Vue d'Oran, Algérie">
            <div class="carousel-caption d-flex justify-content-center align-items-center h-100">
                <div class="text-center">
                    <h6>Découvrir Oran</h6>
                    <p>El Bahia, ville côtière algérienne, mêle charme méditerranéen, histoire riche et culture vivante. Idéale pour découvrir paysages maritimes, architecture coloniale et musique raï.</p>
                      <div class="col-md d-grid">
                        <button type="button" class="btn btn-outline-dark w-100 rounded-pill py-2">Découvrir</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="carousel-item">
            <img src="carousel/motagne.png" class="d-block w-100 carousel-image" alt="Paysage montagneux">
            <div class="carousel-caption d-flex justify-content-center align-items-center h-100">
                <div class="text-center">
                    <h6>Magnifique Montagne</h6>
                    <p>La beauté des montagnes qui vous attend.</p>
                    <div class="col-md d-grid">
                        <button type="button" class="btn btn-outline-dark w-100 rounded-pill py-2">Découvrir</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="carousel-item">
            <img src="carousel/mer.jpg" class="d-block w-100 carousel-image" alt="Paysage marin">
            <div class="carousel-caption d-flex justify-content-center align-items-center h-100">
                <div class="text-center">
                    <h6>Voyage en Mer</h6>
                    <p>Explorez les horizons marins comme jamais auparavant.</p>
                    <div class="col-md d-grid">
                        <button type="button" class="btn btn-outline-dark w-100 rounded-pill py-2">Découvrir</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="carousel-item">
            <img src="carousel/le monde.png" class="d-block w-100 carousel-image" alt="Paysages mondiaux">
            <div class="carousel-caption d-flex justify-content-center align-items-center h-100">
                <div class="text-center">
                    <h6>Explorer le Monde</h6>
                    <p>Un voyage inoubliable à travers des paysages incroyables.</p>
                    <div class="col-md d-grid">
                        <button type="button" class="btn btn-outline-dark w-100 rounded-pill py-2">Découvrir</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev" aria-label="Précédent">
        <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next" aria-label="Suivant">
        <span class="carousel-control-next-icon"></span>
    </button>
</div>
<section class="selection-section mt-5">
    <div class="container text-center">
        <h3 class="section-title">Notre Sélection</h3>
        <p class="section-subtitle">Découvrez nos destinations préférées pour vos prochaines aventures.</p>
        <div id="cardCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <img src="slides/mountains-862870_1280.jpg" class="card-img-top" alt="Montagnes de Bejaia">
                                <div class="card-body">
                                    <h6 class="card-title">Montagnes Enchantées</h6>
                                    <p class="card-text">Explorez les sommets majestueux de Bejaia.</p>
                                    <a href="#" class="btn btn-outline-dark rounded-pill">Découvrir</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <img src="slides/maldives-5071309_1280.jpg" class="card-img-top" alt="Plages de la Méditerranée">
                                <div class="card-body">
                                    <h6 class="card-title">Plages de Rêve</h6>
                                    <p class="card-text">Profitez des eaux cristallines de la Méditerranée.</p>
                                    <a href="#" class="btn btn-outline-dark rounded-pill">Découvrir</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <img src="carousel/Mont-saint-michel.avif" class="card-img-top" alt="Villages pittoresques">
                                <div class="card-body">
                                    <h6 class="card-title">Villages Authentiques</h6>
                                    <p class="card-text">Découvrez la culture locale dans des villages pittoresques.</p>
                                    <a href="#" class="btn btn-outline-dark rounded-pill">Découvrir</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <img src="slides/forest-3409907_1280.jpg" class="card-img-top" alt="Forêts anciennes">
                                <div class="card-body">
                                    <h6 class="card-title">Forêts Mystérieuses</h6>
                                    <p class="card-text">Parcourez les sentiers secrets des forêts anciennes.</p>
                                    <a href="#" class="btn btn-outline-dark rounded-pill">Découvrir</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <img src="carousel/surf.jpg" class="card-img-top" alt="Aventures marines">
                                <div class="card-body">
                                    <h6 class="card-title">Aventures en Mer</h6>
                                    <p class="card-text">Naviguez vers l'inconnu sur des eaux turquoise.</p>
                                    <a href="#" class="btn btn-outline-dark rounded-pill">Découvrir</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <img src="slides/mountain-4635428_1920.jpg" class="card-img-top" alt="Paysages de Bejaia">
                                <div class="card-body">
                                    <h6 class="card-title">Paysages Époustouflants</h6>
                                    <p class="card-text">Admirez les paysages à couper le souffle de Bejaia.</p>
                                    <a href="#" class="btn btn-outline-dark rounded-pill">Découvrir</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#cardCarousel" data-bs-slide="prev" aria-label="Précédent">
                <span class="carousel-control-prev-icon"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#cardCarousel" data-bs-slide="next" aria-label="Suivant">
                <span class="carousel-control-next-icon"></span>
            </button>
        </div>
    </div>
</section>
<section class="offers-section mt-5">
    <div class="container text-center">
        <h3 class="section-title">Nos Offres</h3>
        <p class="section-subtitle">Découvrez nos meilleures offres pour vos prochaines aventures.</p>
        <div id="offerCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <div class="card big-card mx-auto">
                        <img src="slides/forest-6364913_1280.jpg" class="card-img-top" alt="Offre Montagnes Enchantées">
                        <div class="card-body">
                            <h6 class="card-title">Offre Spéciale : Montagnes Enchantées</h6>
                            <p class="card-text">Profitez d'une réduction exclusive pour découvrir les sommets majestueux.</p>
                            <a href="#" class="btn btn-outline-dark rounded-pill">Réserver Maintenant</a>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="card big-card mx-auto">
                        <img src="slides/maldives-5071306_1280.jpg" class="card-img-top" alt="Offre Plages de Rêve">
                        <div class="card-body">
                            <h6 class="card-title">Offre Plages de Rêve</h6>
                            <p class="card-text">Évadez-vous vers des plages paradisiaques avec notre offre limitée.</p>
                            <a href="#" class="btn btn-outline-dark rounded-pill">Réserver Maintenant</a>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="card big-card mx-auto">
                        <img src="slides/norway-5215881_1280.jpg" class="card-img-top" alt="Offre Forêts Mystérieuses">
                        <div class="card-body">
                            <h6 class="card-title">Offre Forêts Mystérieuses</h6>
                            <p class="card-text">Explorez les forêts anciennes avec une offre spéciale pour les amateurs de nature.</p>
                            <a href="#" class="btn btn-outline-dark rounded-pill">Réserver Maintenant</a>
                        </div>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#offerCarousel" data-bs-slide="prev" aria-label="Précédent">
                <span class="carousel-control-prev-icon"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#offerCarousel" data-bs-slide="next" aria-label="Suivant">
                <span class="carousel-control-next-icon"></span>
            </button>
        </div>
    </div>
</section>
<?php include 'includes/footer.php';?>
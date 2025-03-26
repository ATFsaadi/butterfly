
<?php include 'includes/header.php';?>
 <!-- Section de recherche de voyage -->
<section class="voyage-menu-section">
    <div class="voyage-container">
        <!-- Titre de la section -->
        <div class="voyage-menu-title">
            <h1>Pour un voyage de rêve ...</h1>
        </div>
        <!-- Barre de recherche avec plusieurs filtres -->
        <div
            class="voyage-menu"
            style="width: 100%; display: flex; justify-content: center; flex-wrap: wrap; gap: 0; padding: 40px 0; overflow: visible; position: relative;">
            
            <!-- Filtre pour le type de voyage -->
            <div
                class="voyage-dropdown"
                style="position: relative; width: 180px; text-align: center;">
                <button class="voyage-btn">Type de Voyage
                    <span class="voyage-suggestion">Séjour</span></button>
                <ul class="voyage-dropdown-content">
                    <li>Séjour</li>
                    <li>Aventure</li>
                    <li>Plage</li>
                    <li>Culture</li>
                </ul>
            </div>
            <!-- Filtre pour la destination -->
            <div
                class="voyage-dropdown"
                style="position: relative; width: 180px; text-align: center;">
                <button class="voyage-btn">Destination
                    <span class="voyage-suggestion">N'importe où</span></button>
                <ul class="voyage-dropdown-content">
                    <li>N'importe où</li>
                    <li>France</li>
                    <li>États-Unis</li>
                    <li>Japon</li>
                </ul>
            </div>
            <!-- Filtre pour la ville de départ -->
            <div
                class="voyage-dropdown"
                style="position: relative; width: 180px; text-align: center;">
                <button class="voyage-btn">Ville de Départ
                    <span class="voyage-suggestion">Tout endroit</span></button>
                <ul class="voyage-dropdown-content">
                    <li>Tout endroit</li>
                    <li>Paris</li>
                    <li>Marseille</li>
                    <li>Lyon</li>
                </ul>
            </div>
            <!-- Filtre pour la date de départ -->
            <div
                class="voyage-dropdown"
                style="width: 180px; text-align: center; position: relative;">
                <button id="dateButton" class="voyage-btn">Date de Départ
                    <span class="voyage-suggestion"></span></button>
                <input type="date" id="dateDepart" class="voyage-date-picker">
            </div>
            <!-- Filtre pour la durée du voyage -->
            <div
                class="voyage-dropdown"
                style="position: relative; width: 180px; text-align: center;">
                <button class="voyage-btn">Durée
                    <span class="voyage-suggestion">Peu importe</span></button>
                <ul class="voyage-dropdown-content">
                    <li>Peu importe</li>
                    <li>1 jour</li>
                    <li>3 jours</li>
                    <li>1 semaine</li>
                    <li>2 semaines</li>
                </ul>
            </div>

            <!-- Bouton Réinitialiser (positionné au-dessus du bouton Rechercher) -->
            <div class="voyage-reset-icon-container">
                <button class="voyage-reset-icon">
                    <img src="icons/reste.png" width="20px" alt="Réinitialiser">
                </button>
            </div>

            <!-- Bouton Rechercher -->
            <div class="voyage-search-container">
                <button class="voyage-search-btn">
                    <img src="icons/loupe.png" width="18px" alt="Rechercher" class="search-icon">
                    Rechercher
                </button>
            </div>
        </div>
    </div>
</section>
 <!-- Carrousel de slides -->
 <div
 id="carouselExampleIndicators"
 class="carousel slide mt-4"
 data-bs-ride="carousel">
 <div class="carousel-indicators">
     <button
         type="button"
         data-bs-target="#carouselExampleIndicators"
         data-bs-slide-to="0"
         class="active"></button>
     <button
         type="button"
         data-bs-target="#carouselExampleIndicators"
         data-bs-slide-to="1"></button>
     <button
         type="button"
         data-bs-target="#carouselExampleIndicators"
         data-bs-slide-to="2"></button>
     <button
         type="button"
         data-bs-target="#carouselExampleIndicators"
         data-bs-slide-to="3"></button>
 </div>
 <div class="carousel-inner">
     <div class="carousel-item active">
         <img src="algerie/oran2.jpg" class="d-block w-100 carousel-image" alt="Slide 1">
         <div
             class="carousel-caption d-flex justify-content-center align-items-center h-100">
             <div class="text-center">
                 <h6>Découvrir Oran</h6>
                 <p>El Bahia, ville côtière algérienne, mêle charme 
                    méditerranéen, histoire riche et culture vivante.
                     Idéale pour découvrir paysages maritimes, architecture 
                     coloniale et musique raï.</p>
                 <div class="col-md d-grid">
                     <button type="submit" class="btn btn-outline-dark w-100 rounded-pill py-2">Découvrir</button>
                 </div>
             </div>
         </div>
     </div>
     <div class="carousel-item">
         <img
             src="slides/haifoss-4692722_1280.jpg"
             class="d-block w-100 carousel-image"
             alt="Slide 2">
         <div
             class="carousel-caption d-flex justify-content-center align-items-center h-100">
             <div class="text-center">
                 <h6>Magnifique Montagne</h6>
                 <p>La beauté des montagnes qui vous attend.</p>
                 <div class="col-md d-grid">
                     <button type="submit" class="btn btn-outline-dark w-100 rounded-pill py-2">Découvrir</button>
                 </div>
             </div>
         </div>
     </div>
     <div class="carousel-item">
         <img
             src="slides/dolomites-2897602_1280.jpg"
             class="d-block w-100 carousel-image"
             alt="Slide 3">
         <div
             class="carousel-caption d-flex justify-content-center align-items-center h-100">
             <div class="text-center">
                 <h6>Voyage en Mer</h6>
                 <p>Explorez les horizons marins comme jamais auparavant.</p>
                 <div class="col-md d-grid">
                     <button type="submit" class="btn btn-outline-dark w-100 rounded-pill py-2">Découvrir</button>
                 </div>
             </div>
         </div>
     </div>
     <div class="carousel-item">
         <img
             src="slides/camel-7081952_1280.jpg"
             class="d-block w-100 carousel-image"
             alt="Slide 4">
         <div
             class="carousel-caption d-flex justify-content-center align-items-center h-100">
             <div class="text-center">
                 <h6>Explorer le Monde</h6>
                 <p>Un voyage inoubliable à travers des paysages incroyables.</p>
                 <div class="col-md d-grid">
                     <button type="submit" class="btn btn-outline-dark w-100 rounded-pill py-2">Découvrir</button>
                 </div>
             </div>
         </div>
     </div>
 </div>
 <button
     class="carousel-control-prev"
     type="button"
     data-bs-target="#carouselExampleIndicators"
     data-bs-slide="prev">
     <span class="carousel-control-prev-icon"></span>
 </button>
 <button
     class="carousel-control-next"
     type="button"
     data-bs-target="#carouselExampleIndicators"
     data-bs-slide="next">
     <span class="carousel-control-next-icon"></span>
 </button>
</div>
<!-- Section Notre Sélection -->
<section class="selection-section mt-5">
    <div class="container text-center">
        <h3 class="section-title">Notre Sélection</h3>
        <p class="section-subtitle">Découvrez nos destinations préférées pour vos prochaines aventures.</p>

        <!-- Carrousel des cartes -->
        <div id="cardCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <!-- Première rangée de cartes -->
                <div class="carousel-item active">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <img src="slides/mountains-862870_1280.jpg" class="card-img-top" alt="Destination 1">
                                <div class="card-body">
                                    <h6 class="card-title">Montagnes Enchantées</h6>
                                    <p class="card-text">Explorez les sommets majestueux de Bejaia.</p>
                                    <a href="#" class="btn btn-outline-dark rounded-pill">Découvrir</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <img src="slides/maldives-5071309_1280.jpg" class="card-img-top" alt="Destination 2">
                                <div class="card-body">
                                    <h6 class="card-title">Plages de Rêve</h6>
                                    <p class="card-text">Profitez des eaux cristallines de la Méditerranée.</p>
                                    <a href="#" class="btn btn-outline-dark rounded-pill">Découvrir</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Deuxième rangée de cartes -->
                <div class="carousel-item">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <img src="slides/camper-5430762_1920.jpg" class="card-img-top" alt="Destination 3">
                                <div class="card-body">
                                    <h6 class="card-title">Villages Authentiques</h6>
                                    <p class="card-text">Découvrez la culture locale dans des villages pittoresques.</p>
                                    <a href="#" class="btn btn-outline-dark rounded-pill">Découvrir</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <img src="slides/forest-3409907_1280.jpg" class="card-img-top" alt="Destination 4">
                                <div class="card-body">
                                    <h6 class="card-title">Forêts Mystérieuses</h6>
                                    <p class="card-text">Parcourez les sentiers secrets des forêts anciennes.</p>
                                    <a href="#" class="btn btn-outline-dark rounded-pill">Découvrir</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Troisième rangée de cartes -->
                <div class="carousel-item">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <img src="slides/sunset-6387462_1280.jpg" class="card-img-top" alt="Destination 5">
                                <div class="card-body">
                                    <h6 class="card-title">Aventures en Mer</h6>
                                    <p class="card-text">Naviguez vers l'inconnu sur des eaux turquoise.</p>
                                    <a href="#" class="btn btn-outline-dark rounded-pill">Découvrir</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <img src="slides/mountain-4635428_1920.jpg" class="card-img-top" alt="Destination 6">
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

            <!-- Contrôles du carrousel -->
            <button class="carousel-control-prev" type="button" data-bs-target="#cardCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#cardCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
            </button>
        </div>
    </div>
</section>
<!-- Section Nos Offres -->
<section class="offers-section mt-5">
    <div class="container text-center">
        <h3 class="section-title">Nos Offres</h3>
        <p class="section-subtitle">Découvrez nos meilleures offres pour vos prochaines aventures.</p>

        <!-- Carrousel des offres -->
        <div id="offerCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <!-- Première offre -->
                <div class="carousel-item active">
                    <div class="card big-card mx-auto">
                        <img src="slides/forest-6364913_1280.jpg" class="card-img-top" alt="Offre 1">
                        <div class="card-body">
                            <h6 class="card-title">Offre Spéciale : Montagnes Enchantées</h6>
                            <p class="card-text">Profitez d'une réduction exclusive pour découvrir les sommets majestueux.</p>
                            <a href="#" class="btn btn-outline-dark rounded-pill">Réserver Maintenant</a>
                        </div>
                    </div>
                </div>

                <!-- Deuxième offre -->
                <div class="carousel-item">
                    <div class="card big-card mx-auto">
                        <img src="slides/maldives-5071306_1280.jpg" class="card-img-top" alt="Offre 2">
                        <div class="card-body">
                            <h6 class="card-title">Offre Plages de Rêve</h6>
                            <p class="card-text">Évadez-vous vers des plages paradisiaques avec notre offre limitée.</p>
                            <a href="#" class="btn btn-outline-dark rounded-pill">Réserver Maintenant</a>
                        </div>
                    </div>
                </div>

                <!-- Troisième offre -->
                <div class="carousel-item">
                    <div class="card big-card mx-auto">
                        <img src="slides/norway-5215881_1280.jpg" class="card-img-top" alt="Offre 3">
                        <div class="card-body">
                            <h6 class="card-title">Offre Forêts Mystérieuses</h6>
                            <p class="card-text">Explorez les forêts anciennes avec une offre spéciale pour les amateurs de nature.</p>
                            <a href="#" class="btn btn-outline-dark rounded-pill">Réserver Maintenant</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contrôles du carrousel -->
            <button class="carousel-control-prev" type="button" data-bs-target="#offerCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#offerCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
            </button>
        </div>
    </div>
</section>
<?php include 'includes/footer.php';?>
       
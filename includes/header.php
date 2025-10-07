<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Bfly</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" crossorigin="anonymous">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="crossorigin">
        <link href="https://fonts.googleapis.com/css2?family=Genos:ital,wght@0,100..900;1,100..900&family=Lavishly+Yours&family=Meow+Script&family=Poiret+One&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <nav class="custom-navbar navbar-expand-lg">
            <div class="container-fluid d-flex justify-content-between" style="padding: 20px 100px;">
                <div class="d-flex align-items-center">
                    <li class="nav-item d-flex flex-column align-items-center">
                        <button class="navbar-toggler d-lg-none nav-link d-flex flex-column align-items-center" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="icon-circle">
                                <svg xmlns="http://www.w3.org/2000/svg" viewbox="0 0 24 24" width="15" height="15">
                                    <path d="M3 18h18v-2H3v2zm0-5h18v-2H3v2zm0-7v2h18V6H3z"/>
                                </svg>
                            </span>
                            <span class="mt-1">Menu</span>
                        </button>
                    </li>
                    <a href="index.php" class="navbar-brand logo-spacing d-none d-lg-flex">
                        <img src="icons/logo-off.png" alt="Logo de l'agence" class="logo-size">
                    </a>
                </div>
                <div class="navbar-right">
                    <ul class="navbar-nav flex-row align-items-center gap-3">
                        <li class="nav-item d-flex flex-column align-items-center">
                            <a class="nav-link d-flex flex-column align-items-center" href="sing.php" aria-label="Envoyer un email">
                                <span class="icon-circle">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewbox="0 0 24 24" width="15" height="15">
                                        <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                                    </svg>
                                </span>
                                <span class="mt-1">Mail</span>
                            </a>
                        </li>
                        <li class="nav-item d-flex flex-column align-items-center">
                            <a class="nav-link d-flex flex-column align-items-center" href="https://wa.me/33648843836" target="_blank" aria-label="Nous contacter via WhatsApp">
                                <span class="icon-circle">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewbox="0 0 24 24" width="15" height="15" fill="currentColor">
                                        <path d="M6.62 10.79C8.06 13.62 10.38 15.94 13.21 17.38L15.41 15.18C15.68 14.91 16.08 14.82 16.43 14.91C17.69 15.22 18.99 15.39 20.32 15.39C20.75 15.39 21.13 15.76 21.13 16.19V20.3C21.13 20.73 20.75 21.1 20.32 21.1C10.71 21.1 3 13.39 3 3.78C3 3.35 3.38 2.97 3.81 2.97H7.92C8.35 2.97 8.72 3.35 8.72 3.78C8.72 5.11 8.89 6.41 9.2 7.67C9.29 8.02 9.2 8.42 8.93 8.69L6.62 10.79Z"/>
                                    </svg>
                                </span>
                                <span class="mt-1">WhatsApp</span>
                            </a>
                        </li>
                        <li class="nav-item adresse-container d-flex flex-column align-items-center d-none d-lg-block">
                            <div class="adresse-hover d-flex flex-column align-items-center">
                                <a class="nav-link d-flex flex-column align-items-center" href="#">
                                    <span class="icon-circle">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewbox="0 0 24 24" width="15" height="15">
                                            <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                                    </svg>
                                </span>
                                <span class="mt-1">Notre agence</span>
                            </a>
                            <div id="adresse-container">
                                <div id="map-container">
                                    <iframe width="100%" height="100%" frameborder="0" style="border:0" allowfullscreen="allowfullscreen" loading="lazy" referrerpolicy="no-referrer" src="https://www.google.com/maps/embed?pb=..."></iframe>
                                </div>
                            </div>
                        </div>
                        </li>
                        <li class="nav-item d-flex flex-column align-items-center d-none d-lg-block">
                            <a class="nav-link d-flex flex-column align-items-center" href="about.php" aria-label="En savoir plus sur nous">
                                <span class="icon-circle">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewbox="0 0 24 24" width="15" height="15">
                                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/>
                                    </svg>
                                </span>
                                <span class="mt-1">À propos</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="custom-navbar navbar-expand-lg navbar-light bg-white sticky-top" role="navigation" aria-label="Menu principal">
            <div class="container-fluid">
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav mx-auto">
                        <li class="nav-item me-4 d-lg-none">
                            <a class="nav-link" href="#">Notre agence</a>
                        </li>
                        <li class="nav-item me-4 d-lg-none">
                            <a class="nav-link" href="about.php">À propos</a>
                        </li>
                        <li class="nav-item dropdown me-4">
                            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                                <i data-feather="home" class="nav-icon"></i>
                                Hôtels
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Hôtels de luxe</a></li>
                                <li><a class="dropdown-item" href="#">Hôtels économiques</a></li>
                                <li><a class="dropdown-item" href="#">Hôtels tout inclus</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown me-4">
                            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                                <i data-feather="tag" class="nav-icon"></i>
                                Promo
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Réductions spéciales</a></li>
                                <li><a class="dropdown-item" href="#">Codes promo</a></li>
                                <li><a class="dropdown-item" href="#">Offres de saison</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown me-4">
                            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                                <i data-feather="clock" class="nav-icon"></i>
                                Dernière Minute
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Offres spéciales</a></li>
                                <li><a class="dropdown-item" href="#">Voyages à petit prix</a></li>
                                <li><a class="dropdown-item" href="#">Destinations populaires</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown me-4">
                            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                                <i data-feather="map" class="nav-icon"></i>
                                Circuits
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Circuits classiques</a></li>
                                <li><a class="dropdown-item" href="#">Circuits aventure</a></li>
                                <li><a class="dropdown-item" href="#">Circuits culturels</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown me-4">
                            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                                <i data-feather="briefcase" class="nav-icon"></i>
                                Séjours
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Séjours en Europe</a></li>
                                <li><a class="dropdown-item" href="#">Séjours en Asie</a></li>
                                <li><a class="dropdown-item" href="#">Séjours en Amérique</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </body>
</html>
<?php
// démarrage session si nécessaire
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!-- NAVBAR SUPÉRIEURE -->
<nav class="custom-navbar navbar-expand-lg">
    <div class="container-fluid d-flex justify-content-between" style="padding: 20px 100px;">
        
        <!-- logo et menu mobile -->
        <div class="d-flex align-items-center">
            <button class="navbar-toggler d-lg-none nav-link d-flex flex-column align-items-center" 
                    type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="icon-circle">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="15" height="15">
                        <path d="M3 18h18v-2H3v2zm0-5h18v-2H3v2zm0-7v2h18V6H3z"/>
                    </svg>
                </span>
                <span class="mt-1">menu</span>
            </button>
            <a href="index.php" class="navbar-brand logo-spacing d-none d-lg-flex">
                <img src="icons/logo-off.png" alt="logo" class="logo-size">
            </a>
        </div>

        <!-- actions utilisateur -->
        <div class="navbar-right">
            <ul class="navbar-nav flex-row align-items-center gap-3">

                <?php if (isset($_SESSION['user'])): ?>
                    <!-- utilisateur connecté -->
                    <li class="nav-item d-flex flex-column align-items-center">
                        <span class="nav-link"><?= htmlspecialchars($_SESSION['user']['prenom']) ?></span>
                    </li>
                    <li class="nav-item d-flex flex-column align-items-center">
                        <a class="nav-link d-flex flex-column align-items-center" href="index.php?page=logout">
                            <span class="icon-circle">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="15" height="15">
                                    <path d="M10 17l5-5-5-5v10zM4 19h6v2H4c-1.1 0-2-.9-2-2V5c0-1.1.9-2 2-2h6v2H4v14z"/>
                                </svg>
                            </span>
                            <span class="mt-1">deconnexion</span>
                        </a>
                    </li>
                <?php else: ?>
                    <!-- utilisateur non connecté -->
                    <li class="nav-item d-flex flex-column align-items-center">
                        <button class="nav-link signin-nav-link d-flex flex-column align-items-center btn p-0" 
                                data-bs-toggle="modal" data-bs-target="#loginModal">
                            <span class="icon-circle">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="15" height="15">
                                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                </svg>
                            </span>
                            <span class="mt-1">connecter</span>
                        </button>
                    </li>
                    <li class="nav-item d-flex flex-column align-items-center">
                        <button class="nav-link d-flex flex-column align-items-center btn p-0" 
                                data-bs-toggle="modal" data-bs-target="#registerModal">
                            <span class="icon-circle">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="15" height="15">
                                    <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
                                </svg>
                            </span>
                            <span class="mt-1">s'inscrire</span>
                        </button>
                    </li>
                <?php endif; ?>

                <!-- adresse avec carte -->
                    <li class="nav-item adresse-container d-flex flex-column align-items-center d-none d-lg-block">
                        <div class="adresse-hover d-flex flex-column align-items-center">
                            <a class="nav-link d-flex flex-column align-items-center" href="#" onclick="openAgenceMap(); return false;">
                                <span class="icon-circle">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="15" height="15">
                                        <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                                    </svg>
                                </span>
                                <span class="mt-1">notre agence</span>
                            </a>
                        </div>
                    </li>



                <!-- a propos -->
                <li class="nav-item d-flex flex-column align-items-center d-none d-lg-block">
                    <a class="nav-link d-flex flex-column align-items-center" href="about.php">
                        <span class="icon-circle">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="15" height="15">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/>
                            </svg>
                        </span>
                        <span class="mt-1">a propos</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- MENU PRINCIPAL STICKY -->
<div class="custom-navbar navbar-expand-lg navbar-light bg-white sticky-top">
    <div class="container-fluid">
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto">

                <!-- liens mobiles (d-lg-none) -->
                <li class="nav-item me-4 d-lg-none"><a class="nav-link" href="#">notre agence</a></li>
                <li class="nav-item me-4 d-lg-none"><a class="nav-link" href="about.php">a propos</a></li>

                <!-- menu principal -->
                <li class="nav-item dropdown me-4">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                        <i class="fas fa-hotel nav-icon"></i> hotels
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">hotels de luxe</a></li>
                        <li><a class="dropdown-item" href="#">hotels economiques</a></li>
                        <li><a class="dropdown-item" href="#">hotels tout inclus</a></li>
                    </ul>
                </li>

                <li class="nav-item dropdown me-4">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                        <i class="fas fa-tags nav-icon"></i> promo
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">reductions speciales</a></li>
                        <li><a class="dropdown-item" href="#">codes promo</a></li>
                        <li><a class="dropdown-item" href="#">offres de saison</a></li>
                    </ul>
                </li>

                <li class="nav-item dropdown me-4">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                        <i class="fas fa-clock nav-icon"></i> derniere minute
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">offres speciales</a></li>
                        <li><a class="dropdown-item" href="#">voyages a petit prix</a></li>
                        <li><a class="dropdown-item" href="#">destinations populaires</a></li>
                    </ul>
                </li>

                <li class="nav-item dropdown me-4">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                        <i class="fas fa-map nav-icon"></i> circuits
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">circuits classiques</a></li>
                        <li><a class="dropdown-item" href="#">circuits aventure</a></li>
                        <li><a class="dropdown-item" href="#">circuits culturels</a></li>
                    </ul>
                </li>

                <li class="nav-item dropdown me-4">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                        <i class="fas fa-briefcase nav-icon"></i> sejours
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">sejours en europe</a></li>
                        <li><a class="dropdown-item" href="#">sejours en asie</a></li>
                        <li><a class="dropdown-item" href="#">sejours en amerique</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>

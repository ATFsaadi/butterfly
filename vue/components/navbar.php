<?php
// Démarrage session si nécessaire
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$pageActuelle = $_GET['page'] ?? '';
$continentActif = isset($_GET['continent']) ? (int)$_GET['continent'] : 0;
?>
<!-- NAVBAR SUPÉRIEURE -->
<nav class="custom-navbar navbar-expand-lg">
    <div class="container-fluid d-flex justify-content-between" style="padding: 20px 100px;">
        
        <!-- Logo et menu mobile -->
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

        <!-- Actions utilisateur -->
        <div class="navbar-right">
            <ul class="navbar-nav flex-row align-items-center gap-3">

                <?php if (isset($_SESSION['user'])): ?>
                    <li class="nav-item d-flex flex-column align-items-center">
                        <span class="nav-link"><?= htmlspecialchars($_SESSION['user']['prenom']) ?></span>
                    </li>

                    <?php if ($_SESSION['user']['role'] === 'admin'): ?>
                        <li class="nav-item d-flex flex-column align-items-center">
                            <a class="nav-link d-flex flex-column align-items-center" href="index.php?page=admin_destinations">
                                <span class="icon-circle">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="15" height="15">
                                        <path d="M12 2L15 8H9L12 2ZM12 22V12H2L12 22ZM22 12H12V2L22 12Z"/>
                                    </svg>
                                </span>
                                <span class="mt-1">Destinations</span>
                            </a>
                        </li>
                        <li class="nav-item d-flex flex-column align-items-center">
                            <a class="nav-link d-flex flex-column align-items-center" href="index.php?page=admin_slides">
                                <span class="icon-circle">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="15" height="15">
                                        <path d="M3 13h2v-2H3v2zm0 4h2v-2H3v2zm0-8h2V7H3v2zm4 8h14v-2H7v2zm0-4h14v-2H7v2zm0-6v2h14V7H7z"/>
                                    </svg>
                                </span>
                                <span class="mt-1">Gestion Slides</span>
                            </a>
                        </li>
                    <?php endif; ?>

                    <li class="nav-item d-flex flex-column align-items-center">
                        <a class="nav-link d-flex flex-column align-items-center" href="index.php?page=logout">
                            <span class="icon-circle">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="15" height="15">
                                    <path d="M10 17l5-5-5-5v10zM4 19h6v2H4c-1.1 0-2-.9-2-2V5c0-1.1.9-2 2-2h6v2H4v14z"/>
                                </svg>
                            </span>
                            <span class="mt-1">Déconnexion</span>
                        </a>
                    </li>

                <?php else: ?>
                    <li class="nav-item d-flex flex-column align-items-center">
                        <button class="nav-link signin-nav-link d-flex flex-column align-items-center btn p-0" 
                                data-bs-toggle="modal" data-bs-target="#loginModal">
                            <span class="icon-circle">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="15" height="15">
                                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                </svg>
                            </span>
                            <span class="mt-1">Se connecter</span>
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
                            <span class="mt-1">S'inscrire</span>
                        </button>
                    </li>
                <?php endif; ?>

                <li class="nav-item adresse-container d-flex flex-column align-items-center d-none d-lg-block">
                    <div class="adresse-hover d-flex flex-column align-items-center">
                        <a class="nav-link d-flex flex-column align-items-center" href="#" onclick="openAgenceMap(); return false;">
                            <span class="icon-circle">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="15" height="15">
                                    <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                                </svg>
                            </span>
                            <span class="mt-1">Notre agence</span>
                        </a>
                    </div>
                </li>

                <li class="nav-item d-flex flex-column align-items-center d-none d-lg-block">
                    <a class="nav-link d-flex flex-column align-items-center" href="about.php">
                        <span class="icon-circle">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="15" height="15">
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

<!-- MENU PRINCIPAL STICKY -->
<div class="custom-navbar navbar-expand-lg navbar-light bg-white sticky-top">
    <div class="container-fluid">
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto">

                <li class="nav-item dropdown me-4">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                        <i class="fas fa-map-marked-alt nav-icon"></i> Destinations
                    </a>

                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="index.php?page=destinations">Toutes les destinations</a></li>
                        <li><hr class="dropdown-divider"></li>

                        <?php if (!empty($continents)): ?>
                            <?php foreach ($continents as $c): ?>
                                <li>
                                    <a class="dropdown-item"
                                       href="index.php?page=destinations&continent=<?= (int)$c['id_continent'] ?>">
                                        <?= htmlspecialchars((string)$c['nom']) ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <li><span class="dropdown-item-text text-muted">Aucun continent</span></li>
                        <?php endif; ?>
                    </ul>
                </li>

                <!-- autres menus inchangés -->
            </ul>
        </div>
    </div>
</div>

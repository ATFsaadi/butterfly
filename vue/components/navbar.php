<?php
/* =========================
   SESSION
   ========================= */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/* =========================
   CONTROLEUR (navbar autonome)
   ========================= */
if (!isset($unControleur)) {
    require_once __DIR__ . '/../../controleur/controleur_class.php';
    $unControleur = new Controleur();
}

/* =========================
   VARIABLES
   ========================= */
$pageActuelle = $_GET['page'] ?? '';
$notifReservations = 0;

/* notification admin */
if (isset($_SESSION['user']) && ($_SESSION['user']['role'] ?? '') === 'admin') {
    $notifReservations = $unControleur->countReservationsEnAttente();
}
?>

<!-- =========================
     NAVBAR SUPERIEURE
     ========================= -->
<nav class="custom-navbar navbar-expand-lg">
    <div class="container-fluid d-flex justify-content-between" style="padding: 20px 100px;">

        <!-- logo + bouton menu mobile -->
        <div class="d-flex align-items-center">

            <!-- bouton menu mobile -->
            <button class="navbar-toggler d-lg-none nav-link d-flex flex-column align-items-center"
                    type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavTop">
                <span class="icon-circle">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="15" height="15">
                        <path d="M3 18h18v-2H3v2zm0-5h18v-2H3v2zm0-7v2h18V6H3z"/>
                    </svg>
                </span>
                <span class="mt-1">menu</span>
            </button>

            <!-- logo desktop -->
            <a href="index.php" class="navbar-brand logo-spacing d-none d-lg-flex">
                <img src="icons/logo-1.png" alt="logo" class="logo-size">
            </a>

        </div>

        <!-- actions utilisateur -->
        <div class="navbar-right">
            <ul class="navbar-nav flex-row align-items-center gap-3">

                <?php if (isset($_SESSION['user'])): ?>

                    <?php if (($_SESSION['user']['role'] ?? '') === 'admin'): ?>

                        <!-- ===== MENU ADMIN ===== -->

                        <!-- destinations -->
                        <li class="nav-item d-flex flex-column align-items-center nav-item-fixed">
                            <a class="nav-link d-flex flex-column align-items-center <?= $pageActuelle === 'admin_destinations' ? 'active' : '' ?>"
                               href="index.php?page=admin_destinations">
                                <span class="icon-circle">📍</span>
                                <span class="mt-1">Destinations</span>
                            </a>
                        </li>

                        <!-- slides -->
                        <li class="nav-item d-flex flex-column align-items-center nav-item-fixed">
                            <a class="nav-link d-flex flex-column align-items-center <?= $pageActuelle === 'admin_slides' ? 'active' : '' ?>"
                               href="index.php?page=admin_slides">
                                <span class="icon-circle">🖼️</span>
                                <span class="mt-1">Slides</span>
                            </a>
                        </li>

                        <!-- offres -->
                        <li class="nav-item d-flex flex-column align-items-center nav-item-fixed">
                            <a class="nav-link d-flex flex-column align-items-center <?= $pageActuelle === 'admin_offres' ? 'active' : '' ?>"
                               href="index.php?page=admin_offres">
                                <span class="icon-circle">🏷️</span>
                                <span class="mt-1">Offres</span>
                            </a>
                        </li>

                        <!-- reservations + badge -->
                        <li class="nav-item d-flex flex-column align-items-center position-relative">
                            <a class="nav-link d-flex flex-column align-items-center"
                               href="index.php?page=admin_reservations">

                                <span class="icon-circle position-relative">📅
                                    <?php if ($notifReservations > 0): ?>
                                        <span class="badge bg-danger rounded-pill position-absolute top-0 start-100 translate-middle"
                                              style="font-size:10px;">
                                            <?= $notifReservations ?>
                                        </span>
                                    <?php endif; ?>
                                </span>

                                <span class="mt-1">Réservations</span>
                            </a>
                        </li>

                        <!-- deconnexion -->
                        <li class="nav-item d-flex flex-column align-items-center nav-item-fixed">
                            <a class="nav-link d-flex flex-column align-items-center" href="index.php?page=logout">
                                <span class="icon-circle">🚪</span>
                                <span class="mt-1">Déconnexion</span>
                            </a>
                        </li>

                        <!-- prenom -->
                        <li class="nav-item d-flex flex-column align-items-center nav-item-fixed">
                            <span class="nav-link"><?= htmlspecialchars($_SESSION['user']['prenom'] ?? '') ?></span>
                        </li>

                    <?php else: ?>

                        <!-- ===== MENU CLIENT ===== -->

                        <li class="nav-item d-flex flex-column align-items-center nav-item-fixed">
                            <a class="nav-link d-flex flex-column align-items-center <?= $pageActuelle === 'dashboard_client' ? 'active' : '' ?>"
                               href="index.php?page=dashboard_client">
                                <span class="icon-circle">📄</span>
                                <span class="mt-1">Mes réservations</span>
                            </a>
                        </li>

                        <li class="nav-item d-flex flex-column align-items-center nav-item-fixed">
                            <a class="nav-link d-flex flex-column align-items-center" href="index.php?page=logout">
                                <span class="icon-circle">🚪</span>
                                <span class="mt-1">Déconnexion</span>
                            </a>
                        </li>

                        <li class="nav-item d-flex flex-column align-items-center nav-item-fixed">
                            <span class="nav-link"><?= htmlspecialchars($_SESSION['user']['prenom'] ?? '') ?></span>
                        </li>

                    <?php endif; ?>

                <?php else: ?>

                    <!-- ===== MENU VISITEUR ===== -->

                    <li class="nav-item d-flex flex-column align-items-center nav-item-fixed">
                        <button class="nav-link d-flex flex-column align-items-center btn p-0"
                                data-bs-toggle="modal" data-bs-target="#loginModal">
                            <span class="icon-circle">👤</span>
                            <span class="mt-1">Se connecter</span>
                        </button>
                    </li>

                    <li class="nav-item d-flex flex-column align-items-center nav-item-fixed">
                        <button class="nav-link d-flex flex-column align-items-center btn p-0"
                                data-bs-toggle="modal" data-bs-target="#registerModal">
                            <span class="icon-circle">➕</span>
                            <span class="mt-1">S'inscrire</span>
                        </button>
                    </li>

                <?php endif; ?>

            </ul>
        </div>

    </div>
</nav>

<!-- =========================
     NAVBAR PRINCIPALE
     ========================= -->
<div class="custom-navbar navbar-expand-lg navbar-light bg-white sticky-top">
    <div class="container-fluid">
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto">

                <li class="nav-item me-4">
                    <a class="nav-link <?= $pageActuelle === 'destinations' ? 'active' : '' ?>"
                       href="index.php?page=destinations">
                        Destinations
                    </a>
                </li>

                <li class="nav-item me-4">
                    <a class="nav-link <?= $pageActuelle === 'offres' ? 'active' : '' ?>"
                       href="index.php?page=offres">
                        Offres
                    </a>
                </li>

            </ul>
        </div>
    </div>
</div>

<?php
if (session_status() === PHP_SESSION_NONE) session_start();

// CSRF token disponible pour tout le site
if (empty($_SESSION["csrf_token"])) {
  $_SESSION["csrf_token"] = bin2hex(random_bytes(32));
}

// page actuelle (par défaut home)
$pageActuelle = $_GET['page'] ?? 'home';
$continentActif  = isset($_GET['continent']) ? (int) $_GET['continent'] : 0;

$notifReservations = 0;

// notification admin (si dispo)
// if (isset($_SESSION['user']) && ($_SESSION['user']['role'] ?? '') === 'admin') {
//   $notifReservations = $unControleur->countReservationsEnAttente();
// }
?>

<!-- =========================
     NAVBAR SUPERIEURE (comme le 1er)
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
            <path d="M3 18h18v-2H3v2zm0-5h18v-2H3v2zm0-7v2h18V6H3z"></path>
          </svg>
        </span>
        <span class="mt-1">menu</span>
      </button>

      <!-- logo desktop -->
      <a href="index.php?page=home" class="navbar-brand logo-spacing d-none d-lg-flex">
        <img src="icons/logo-1.png" alt="logo" class="logo-size">
      </a>

    </div>

    <!-- actions utilisateur -->
    <div class="navbar-right">
      <ul class="navbar-nav flex-row align-items-center gap-3">

        <?php if (isset($_SESSION['user'])): ?>

          <?php if (($_SESSION['user']['role'] ?? '') === 'admin'): ?>

            <!-- =========================
                 MENU ADMIN (comme le 1er)
                 ========================= -->

            <!-- destinations -->
            <li class="nav-item d-flex flex-column align-items-center nav-item-fixed">
              <a class="nav-link d-flex flex-column align-items-center <?= $pageActuelle === 'admin_destinations' ? 'active' : '' ?>"
                 href="index.php?page=admin_destinations">
                <span class="icon-circle">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="15" height="15">
                    <path d="M12 2L15 8H9L12 2ZM12 22V12H2L12 22ZM22 12H12V2L22 12Z"/>
                  </svg>
                </span>
                <span class="mt-1">Destinations</span>
              </a>
            </li>

            <!-- slides -->
            <li class="nav-item d-flex flex-column align-items-center nav-item-fixed">
              <a class="nav-link d-flex flex-column align-items-center <?= $pageActuelle === 'admin_slides' ? 'active' : '' ?>"
                 href="index.php?page=admin_slides">
                <span class="icon-circle">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="15" height="15">
                    <path d="M3 13h2v-2H3v2zm0 4h2v-2H3v2zm0-8h2V7H3v2zm4 8h14v-2H7v2zm0-4h14v-2H7v2zm0-6v2h14V7H7z"/>
                  </svg>
                </span>
                <span class="mt-1">Gestion Slides</span>
              </a>
            </li>

            <!-- offres -->
            <li class="nav-item d-flex flex-column align-items-center nav-item-fixed">
              <a class="nav-link d-flex flex-column align-items-center <?= $pageActuelle === 'admin_offres' ? 'active' : '' ?>"
                 href="index.php?page=admin_offres">
                <span class="icon-circle">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="15" height="15">
                    <path d="M12 2l9 4v6c0 5-4 9-9 10C7 21 3 17 3 12V6l9-4zm4 7H8v2h8V9zm0 4H8v2h8v-2z"/>
                  </svg>
                </span>
                <span class="mt-1">Offres</span>
              </a>
            </li>

            <!-- reservations + badge -->
            <li class="nav-item d-flex flex-column align-items-center position-relative">
              <a class="nav-link d-flex flex-column align-items-center <?= $pageActuelle === 'admin_reservations' ? 'active' : '' ?>"
                 href="index.php?page=admin_reservations">
                <span class="icon-circle position-relative">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="15" height="15">
                    <path d="M7 2v2H5a2 2 0 0 0-2 2v2h18V6a2 2 0 0 0-2-2h-2V2h-2v2H9V2H7zm14 8H3v10a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V10z"/>
                  </svg>

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

            <!-- deconnexion (version POST + CSRF) -->
            <li class="nav-item d-flex flex-column align-items-center nav-item-fixed">
              <form method="POST"
                    action="index.php"
                    class="nav-link d-flex flex-column align-items-center m-0 p-0"
                    style="background:none; border:0;">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION["csrf_token"]) ?>">
                <button type="submit" name="logout"
                        class="d-flex flex-column align-items-center"
                        style="background:none; border:0; padding:0; color:inherit; cursor:pointer;">
                  <span class="icon-circle">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="15" height="15">
                      <path d="M10 17l5-5-5-5v10zM4 19h6v2H4c-1.1 0-2-.9-2-2V5c0-1.1.9-2 2-2h6v2H4v14z"/>
                    </svg>
                  </span>
                  <span class="mt-1">Déconnexion</span>
                </button>
              </form>
            </li>

            <!-- prenom -->
            <li class="nav-item d-flex flex-column align-items-center nav-item-fixed">
              <span class="nav-link"><?= htmlspecialchars($_SESSION['user']['prenom'] ?? '') ?></span>
            </li>

          <?php else: ?>

            <!-- =========================
                 MENU CLIENT CONNECTE (comme le 1er)
                 ========================= -->

            <!-- mes reservations -->
            <li class="nav-item d-flex flex-column align-items-center nav-item-fixed">
              <a class="nav-link d-flex flex-column align-items-center <?= $pageActuelle === 'dashboard_client' ? 'active' : '' ?>"
                 href="index.php?page=dashboard_client">
                <span class="icon-circle">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="15" height="15">
                    <path d="M4 6h16v2H4V6zm0 5h16v2H4v-2zm0 5h10v2H4v-2z"/>
                  </svg>
                </span>
                <span class="mt-1">Mes réservations</span>
              </a>
            </li>

            <!-- deconnexion (POST + CSRF) -->
            <li class="nav-item d-flex flex-column align-items-center nav-item-fixed">
              <form method="POST"
                    action="index.php"
                    class="nav-link d-flex flex-column align-items-center m-0 p-0"
                    style="background:none; border:0;">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION["csrf_token"]) ?>">
                <button type="submit" name="logout"
                        class="d-flex flex-column align-items-center"
                        style="background:none; border:0; padding:0; color:inherit; cursor:pointer;">
                  <span class="icon-circle">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="15" height="15">
                      <path d="M10 17l5-5-5-5v10zM4 19h6v2H4c-1.1 0-2-.9-2-2V5c0-1.1.9-2 2-2h6v2H4v14z"/>
                    </svg>
                  </span>
                  <span class="mt-1">Déconnexion</span>
                </button>
              </form>
            </li>

            <!-- prenom -->
            <li class="nav-item d-flex flex-column align-items-center nav-item-fixed">
              <span class="nav-link"><?= htmlspecialchars($_SESSION['user']['prenom'] ?? '') ?></span>
            </li>

          <?php endif; ?>

        <?php else: ?>

          <!-- =========================
               MENU VISITEUR (comme le 1er)
               ========================= -->

          <!-- notre agence -->
          <li class="nav-item d-flex flex-column align-items-center d-none d-lg-block nav-item-fixed">
            <a class="nav-link d-flex flex-column align-items-center" href="#"
               onclick="openAgenceMap(); return false;">
              <span class="icon-circle">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="15" height="15">
                  <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                </svg>
              </span>
              <span class="mt-1">Notre agence</span>
            </a>
          </li>

          <!-- a propos -->
          <li class="nav-item d-flex flex-column align-items-center d-none d-lg-block nav-item-fixed">
            <a class="nav-link d-flex flex-column align-items-center" href="index.php?page=about">
              <span class="icon-circle">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="15" height="15">
                  <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/>
                </svg>
              </span>
              <span class="mt-1">À propos</span>
            </a>
          </li>

          <!-- bouton connexion -->
          <li class="nav-item d-flex flex-column align-items-center nav-item-fixed">
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

          <!-- bouton inscription -->
          <li class="nav-item d-flex flex-column align-items-center nav-item-fixed">
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

      </ul>
    </div>

  </div>
</nav>

<!-- =========================
     MENU PRINCIPAL STICKY (comme le 1er)
     ========================= -->
<div class="custom-navbar navbar-expand-lg navbar-light bg-white sticky-top">
  <div class="container-fluid">

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav mx-auto">

        <!-- lien destinations -->
        <li class="nav-item me-4">
          <a class="nav-link <?= $pageActuelle === 'destinations' ? 'active' : '' ?>"
             href="index.php?page=destinations">
            <i class="fas fa-map-marked-alt nav-icon"></i> Destinations
          </a>
        </li>

        <!-- lien offres -->
        <li class="nav-item me-4">
          <a class="nav-link <?= $pageActuelle === 'offres' ? 'active' : '' ?>"
             href="index.php?page=offres">
            <i class="fas fa-tags nav-icon"></i> Offres
          </a>
        </li>

      </ul>
    </div>

  </div>
</div>

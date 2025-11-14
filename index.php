<?php
session_start();
require_once("controleur/controleur.class.php");
$unControleur = new Controleur();

$page = $_GET['page'] ?? 'home';
$error = '';

// Gestion du formulaire de connexion
if (isset($_POST['Connexion']) && isset($_POST['email'], $_POST['mot_de_passe'])) {
    $email = trim($_POST['email']);
    $mot_de_passe = $_POST['mot_de_passe'];

    $unUser = $unControleur->getUserByEmail($email);

    if (!$unUser) {
        $error = "Email ou mot de passe incorrect";
    } else {
        if (password_verify($mot_de_passe, $unUser['mot_de_passe'])) {
            session_regenerate_id(true);
            $_SESSION['user'] = [
                'id' => $unUser['idutil'],
                'nom' => $unUser['nom'],
                'prenom' => $unUser['prenom'],
                'role' => $unUser['role']
            ];

            if ($unUser['role'] === 'admin') {
                header("Location: index.php?page=dashboard_admin");
            } else {
                header("Location: index.php?page=dashboard_client");
            }
            exit;
        } else {
            $error = "Email ou mot de passe incorrect";
        }
    }
}

// Déconnexion
if ($page === 'logout') {
    session_destroy();
    header("Location: index.php?page=login");
    exit;
}
?>
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
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="style/page.css">
</head>
<body>

<!-- NAVBAR HAUT -->
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
                <?php if(isset($_SESSION['user'])): ?>
                    <li class="nav-item d-flex flex-column align-items-center">
                        <span class="nav-link"><?= htmlspecialchars($_SESSION['user']['prenom']) ?></span>
                    </li>
                    <li class="nav-item d-flex flex-column align-items-center">
                        <a class="nav-link d-flex flex-column align-items-center" href="index.php?page=logout">
                            <span class="icon-circle">
                                <i class="fas fa-sign-out-alt"></i>
                            </span>
                            <span class="mt-1">Déconnexion</span>
                        </a>
                    </li>
                <?php else: ?>
                    <li class="nav-item d-flex flex-column align-items-center">
                        <!-- Bouton modal pour se connecter -->
                        <button id="openLoginModal" class="nav-link signin-nav-link d-flex flex-column align-items-center" aria-label="Se connecter">
                            <span class="icon-circle">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="15" height="15">
                                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                </svg>
                            </span>
                            <span class="mt-1">Connecter</span>
                        </button>
                    </li>
                <?php endif; ?>

                <li class="nav-item adresse-container d-flex flex-column align-items-center d-none d-lg-block">
                    <div class="adresse-hover d-flex flex-column align-items-center">
                        <a class="nav-link d-flex flex-column align-items-center" href="#">
                            <span class="icon-circle">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="15" height="15">
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

<!-- NAVBAR BOTTOM -->
<div class="custom-navbar navbar-expand-lg navbar-light bg-white sticky-top" role="navigation" aria-label="Menu principal">
    <div class="container-fluid">
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item me-4 d-lg-none"><a class="nav-link" href="#">Notre agence</a></li>
                <li class="nav-item me-4 d-lg-none"><a class="nav-link" href="about.php">À propos</a></li>
                <li class="nav-item dropdown me-4">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                        <i data-feather="home" class="nav-icon"></i> Hôtels
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Hôtels de luxe</a></li>
                        <li><a class="dropdown-item" href="#">Hôtels économiques</a></li>
                        <li><a class="dropdown-item" href="#">Hôtels tout inclus</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown me-4">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                        <i data-feather="tag" class="nav-icon"></i> Promo
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Réductions spéciales</a></li>
                        <li><a class="dropdown-item" href="#">Codes promo</a></li>
                        <li><a class="dropdown-item" href="#">Offres de saison</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown me-4">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                        <i data-feather="clock" class="nav-icon"></i> Dernière Minute
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Offres spéciales</a></li>
                        <li><a class="dropdown-item" href="#">Voyages à petit prix</a></li>
                        <li><a class="dropdown-item" href="#">Destinations populaires</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown me-4">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                        <i data-feather="map" class="nav-icon"></i> Circuits
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Circuits classiques</a></li>
                        <li><a class="dropdown-item" href="#">Circuits aventure</a></li>
                        <li><a class="dropdown-item" href="#">Circuits culturels</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown me-4">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                        <i data-feather="briefcase" class="nav-icon"></i> Séjours
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

<!-- MAIN CONTENT -->
<main>
<?php
if (!isset($_SESSION['user'])) {
    if($page === 'login') {
        require_once("vue/vue_connexion.php");
    } elseif($page === 'inscription') {
        require_once("controleur/gestion_inscription.php");
    } else {
        require_once("vue/home.php");
    }
} else {
    require_once("vue/home.php");
}
?>
</main>

<!-- FOOTER -->
<footer class="text-light pt-4 mt-5">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <h5>Liens Utiles</h5>
                <ul class="list-unstyled">
                    <li><a href="#" class="text-light text-decoration-none">Accueil</a></li>
                    <li><a href="#" class="text-light text-decoration-none">Destinations</a></li>
                    <li><a href="#" class="text-light text-decoration-none">Nos Offres</a></li>
                    <li><a href="#" class="text-light text-decoration-none">Contact</a></li>
                </ul>
                <img src="icons/bfly.png" width="60px" alt="">
            </div>

            <div class="col-md-6 text-center">
                <h5>Suivez-nous</h5>
                <div class="mb-3">
                    <a href="#" class="text-light me-4"><i class="fab fa-facebook fa-2x"></i></a>
                    <a href="#" class="text-light me-4"><i class="fab fa-instagram fa-2x"></i></a>
                    <a href="#" class="text-light me-4"><i class="fab fa-twitter fa-2x"></i></a>
                    <a href="#" class="text-light"><i class="fab fa-youtube fa-2x"></i></a>
                </div>
                <h5>Contact</h5>
                <p><i class="fas fa-map-marker-alt me-2"></i> 123 Rue du Voyage, Paris</p>
                <p><i class="fas fa-phone me-2"></i> +33 1 23 45 67 89</p>
                <p><i class="fas fa-envelope me-2"></i> contact@butterflyvoyage.com</p>
            </div>

            <div class="col-md-3">
                <h5>À Propos de Nous</h5>
                <p>
                    Butterfly Voyage est une agence spécialisée dans les voyages sur mesure.
                    Notre mission est de créer des expériences uniques et inoubliables pour nos clients.
                </p>
            </div>
        </div>
        <hr class="bg-light my-4">
        <div class="text-center pb-3">&copy; 2025 Butterfly Voyage - Tous droits réservés</div>
    </div>
</footer>

<!-- MODAL CONNEXION -->
<div id="loginModal" class="modal">
    <div class="modal-content">
        <span class="close">×</span>
        <?php if ($error && isset($_POST['Connexion'])): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <?php require_once("vue/vue_connexion.php"); ?>
    </div>
</div>

<!-- MODAL INSCRIPTION -->
<div id="registerModal" class="modal">
    <div class="modal-content">
        <span class="close">×</span>
        <?php require_once("vue/vue_inscription.php"); ?>
    </div>
</div>

<!-- SCRIPTS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/script.js"></script>
<script src="js/popup_form.js"></script>

</body>
</html>
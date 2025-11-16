<?php
/* demarrage de session et chargement du controleur */
session_start();
require_once("controleur/controleur.class.php");
$unControleur = new Controleur();

/* recuperation de la page demandee */
$page = $_GET['page'] ?? 'home';
$error = '';

/* gestion du formulaire de connexion */
if (isset($_POST['Connexion']) && isset($_POST['email'], $_POST['mot_de_passe'])) {
    $email = trim($_POST['email']);
    $mot_de_passe = $_POST['mot_de_passe'];

    $unUser = $unControleur->getUserByEmail($email);

    if (!$unUser || !password_verify($mot_de_passe, $unUser['mot_de_passe'])) {
        $error = "email ou mot de passe incorrect";
    } else {
        session_regenerate_id(true);
        $_SESSION['user'] = [
            'id' => $unUser['idutil'],
            'nom' => $unUser['nom'],
            'prenom' => $unUser['prenom'],
            'role' => $unUser['role']
        ];

        $redirect = ($unUser['role'] === 'admin') 
            ? "index.php?page=dashboard_admin" 
            : "index.php?page=dashboard_client";

        header("Location: $redirect");
        exit;
    }
}

/* gestion du formulaire d'inscription */
if (isset($_POST['inscription_submit'])) {
    $nom = trim($_POST['nom'] ?? '');
    $prenom = trim($_POST['prenom'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $mot_de_passe = $_POST['mot_de_passe'] ?? '';
    $confirmer_mot_de_passe = $_POST['confirmer_mot_de_passe'] ?? '';
    $telephone = !empty($_POST['telephone']) ? trim($_POST['telephone']) : null;

    if ($mot_de_passe !== $confirmer_mot_de_passe) {
        $inscription_error = "les mots de passe ne correspondent pas";
    } else {
        $userExist = $unControleur->getUserByEmail($email);
        if ($userExist) {
            $inscription_error = "cet email est deja utilise";
        } else {
            $mdpHash = password_hash($mot_de_passe, PASSWORD_DEFAULT);
            $unControleur->addUser($nom, $prenom, $email, $mdpHash, $telephone);
            $inscription_success = "inscription reussie ! vous pouvez vous connecter.";
        }
    }
}

/* gestion de la deconnexion */
if ($page === 'logout') {
    session_destroy();
    header("Location: index.php?page=home");
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <!-- meta et titre -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>bfly</title>

    <!-- bootstrap et icones -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <!-- polices google -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Genos:ital,wght@0,100..900;1,100..900&family=Lavishly+Yours&family=Meow+Script&family=Poiret+One&display=swap" rel="stylesheet">

    <!-- styles personnalises -->
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="style/page.css">
    <link rel="stylesheet" href="style/responsive.css">
</head>
<body>

    <!-- navbar superieure -->
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
                        <!-- utilisateur connecte -->
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
                        <!-- utilisateur non connecte -->
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

                        <!-- bouton s'inscrire (dans le else) -->
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

    <!-- menu principal (sticky) -->
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
                            <i data-feather="home" class="nav-icon"></i> hotels
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">hotels de luxe</a></li>
                            <li><a class="dropdown-item" href="#">hotels economiques</a></li>
                            <li><a class="dropdown-item" href="#">hotels tout inclus</a></li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown me-4">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                            <i data-feather="tag" class="nav-icon"></i> promo
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">reductions speciales</a></li>
                            <li><a class="dropdown-item" href="#">codes promo</a></li>
                            <li><a class="dropdown-item" href="#">offres de saison</a></li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown me-4">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                            <i data-feather="clock" class="nav-icon"></i> derniere minute
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">offres speciales</a></li>
                            <li><a class="dropdown-item" href="#">voyages a petit prix</a></li>
                            <li><a class="dropdown-item" href="#">destinations populaires</a></li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown me-4">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                            <i data-feather="map" class="nav-icon"></i> circuits
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">circuits classiques</a></li>
                            <li><a class="dropdown-item" href="#">circuits aventure</a></li>
                            <li><a class="dropdown-item" href="#">circuits culturels</a></li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown me-4">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                            <i data-feather="briefcase" class="nav-icon"></i> sejours
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

    <!-- contenu principal -->
    <main>
        <?php require_once("vue/home.php"); ?>
    </main>

    <!-- pied de page -->
    <footer class="text-light pt-4 mt-5">
        
        <div class="container">
            <div class="row">

                <!-- liens utiles -->
                <div class="col-md-3">
                    <h5>liens utiles</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-light text-decoration-none">accueil</a></li>
                        <li><a href="#" class="text-light text-decoration-none">destinations</a></li>
                        <li><a href="#" class="text-light text-decoration-none">nos offres</a></li>
                        <li><a href="#" class="text-light text-decoration-none">contact</a></li>
                    </ul>
                    <img src="icons/bfly.png" width="60px" alt="logo">
                </div>
                
                <!-- MINI-CARTE DANS LE FOOTER -->
                <div class="col-md-6">
                <div class="mini-map-container mt-3">
                    <div id="footerMap" style="width:100%; height:180px; border-radius:12px; cursor:pointer; box-shadow:0 4px 12px rgba(0,0,0,0.15);"></div>
                    <small class="text-center d-block mt-2 text-muted">Cliquez pour ouvrir Google Maps</small>
                </div>
                </div>
                <!-- reseaux sociaux et contact -->
                <div class="col-md-3 text-center">
                    <h5>suivez-nous</h5>
                    <div class="mb-3">
                        <a href="#" class="text-light me-4"><i class="fab fa-facebook fa-2x"></i></a>
                        <a href="#" class="text-light me-4"><i class="fab fa-instagram fa-2x"></i></a>
                        <a href="#" class="text-light me-4"><i class="fab fa-twitter fa-2x"></i></a>
                        <a href="#" class="text-light"><i class="fab fa-youtube fa-2x"></i></a>
                    </div>
                    <h5>contact</h5>
                    <p><i class="fas fa-map-marker-alt me-2"></i> 40 Bd Haussmann 75009 Paris </p>
                    <p><i class="fas fa-phone me-2"></i> +33 1 23 45 67 89</p>
                    <p><i class="fas fa-envelope me-2"></i> contact@butterflyvoyage.com</p>
                </div>

               
            </div>
            <hr class="bg-light my-4">
            <div class="text-center pb-3">© 2025 butterfly voyage - tous droits reserves</div>
        </div>
    </footer>

    <!-- modale de connexion -->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content p-0 overflow-hidden" style="border: none; border-radius: 20px; position: relative;">
                
                <!-- bouton fermer -->
                <button type="button" class="btn-close position-absolute top-0 end-0 m-3" 
                        data-bs-dismiss="modal" style="z-index: 10;"></button>

                <!-- message d'erreur -->
                <?php if ($error): ?>
                    <div class="alert alert-danger mx-4 mt-4 mb-0"><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>

                <!-- formulaire stylise -->
                <?php require_once("vue/vue_connexion.php"); ?>
            </div>
        </div>
    </div>
    <!-- modale d'inscription -->
    <div class="modal fade" id="registerModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content p-0 overflow-hidden" style="border: none; border-radius: 20px; position: relative;">
                
                <!-- bouton fermer -->
                <button type="button" class="btn-close position-absolute top-0 end-0 m-3" 
                        data-bs-dismiss="modal" style="z-index: 10;"></button>

                <!-- messages -->
                <?php if (isset($inscription_error)): ?>
                    <div class="alert alert-danger mx-4 mt-4 mb-0"><?= htmlspecialchars($inscription_error) ?></div>
                <?php elseif (isset($inscription_success)): ?>
                    <div class="alert alert-success mx-4 mt-4 mb-0"><?= htmlspecialchars($inscription_success) ?></div>
                <?php endif; ?>

                <!-- vue stylisee -->
                <?php require_once("vue/vue_inscription.php"); ?>
            </div>
        </div>
    </div>
    <!-- MODALE CARTE AGENCE -->
    <div id="mapModal" class="modal">
        <div class="modal-content">
            <span class="close">×</span>
            <h4 class="text-center mb-3">Notre agence</h4>
            <div id="map" style="width:100%; height:400px; border-radius:12px;"></div>
        </div>
    </div>

    <!-- SCRIPTS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" 
            integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" 
            crossorigin=""></script>
    <script src="js/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
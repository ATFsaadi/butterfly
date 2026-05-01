<?php

if (empty($_SESSION["csrf_token"])) {
    $_SESSION["csrf_token"] = bin2hex(random_bytes(32));
}

$pageActuelle = $_GET["page"] ?? "home";
$continentActif = isset($_GET["continent"]) ? (int)$_GET["continent"] : 0;

$notifReservations = 0;

$prenomAffiche =
    $_SESSION["user"]["prenom"]
    ?? $_SESSION["client"]["prenom"]
    ?? (($_SESSION["user"]["role"] ?? "") === "admin" ? "admin" : "");

?>

<nav class="custom-navbar navbar-expand-lg">
    <div class="container-fluid d-flex justify-content-between" style="padding: 20px 100px;">

        <div class="d-flex align-items-center">

            <button
    class="navbar-toggler d-lg-none nav-link d-flex flex-column align-items-center"
    type="button"
    data-bs-toggle="collapse"
    data-bs-target="#navbarNav"
>
                <span class="icon-circle">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="15" height="15">
                        <path d="M3 18h18v-2H3v2zm0-5h18v-2H3v2zm0-7v2h18V6H3z"></path>
                    </svg>
                </span>
                <span class="mt-1">menu</span>
            </button>

            <a href="index.php?page=home" class="navbar-brand logo-spacing d-none d-lg-flex">
                <img src="icons/logoAcc.png" alt="logo" class="logo-size">
            </a>

        </div>

        <div class="navbar-right">
            <ul class="navbar-nav flex-row align-items-center gap-3">

                <?php if (isset($_SESSION["user"])): ?>

                    <?php if (($_SESSION["user"]["role"] ?? "") === "admin"): ?>

                        <li class="nav-item d-flex flex-column align-items-center position-relative">
                            <a
                                class="nav-link d-flex flex-column align-items-center <?= $pageActuelle === "admin_reservations" ? "active" : "" ?>"
                                href="index.php?page=admin_reservations"
                            >
                                <span class="icon-circle position-relative">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="15" height="15">
                                        <path d="M7 2v2H5a2 2 0 0 0-2 2v2h18V6a2 2 0 0 0-2-2h-2V2h-2v2H9V2H7zm14 8H3v10a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V10z"/>
                                    </svg>

                                    <?php if ($notifReservations > 0): ?>
                                        <span
                                            class="badge bg-danger rounded-pill position-absolute top-0 start-100 translate-middle"
                                            style="font-size:10px;"
                                        >
                                            <?= (int)$notifReservations ?>
                                        </span>
                                    <?php endif; ?>
                                </span>

                                <span class="mt-1">Réservations</span>
                            </a>
                        </li>

                        <li class="nav-item d-flex flex-column align-items-center nav-item-fixed">
    <a
        class="nav-link d-flex flex-column align-items-center <?= $pageActuelle === "admin_voyages" ? "active" : "" ?>"
        href="index.php?page=admin_voyages"
    >
        <span class="icon-circle">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="15" height="15">
                <path d="M3 13h2v-2H3v2zm0 4h2v-2H3v2zm0-8h2V7H3v2zm4 8h14v-2H7v2zm0-4h14v-2H7v2zm0-6v2h14V7H7z"/>
            </svg>
        </span>
        <span class="mt-1">Voyages</span>
    </a>
</li>

                        <li class="nav-item d-flex flex-column align-items-center nav-item-fixed">
                            <a
                                class="nav-link d-flex flex-column align-items-center <?= $pageActuelle === "admin_destinations" ? "active" : "" ?>"
                                href="index.php?page=admin_destinations"
                            >
                                <span class="icon-circle">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="15" height="15">
                                        <path d="M12 2L15 8H9L12 2ZM12 22V12H2L12 22ZM22 12H12V2L22 12Z"/>
                                    </svg>
                                </span>
                                <span class="mt-1">Destinations</span>
                            </a>
                        </li>

                        <li class="nav-item d-flex flex-column align-items-center nav-item-fixed">
                            <a
                                class="nav-link d-flex flex-column align-items-center <?= $pageActuelle === "admin_offres" ? "active" : "" ?>"
                                href="index.php?page=admin_offres"
                            >
                                <span class="icon-circle">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="15" height="15">
                                        <path d="M12 2l9 4v6c0 5-4 9-9 10C7 21 3 17 3 12V6l9-4zm4 7H8v2h8V9zm0 4H8v2h8v-2z"/>
                                    </svg>
                                </span>
                                <span class="mt-1">Offres</span>
                            </a>
                        </li>
                        <li class="nav-item d-flex flex-column align-items-center nav-item-fixed">
    <a
        class="nav-link d-flex flex-column align-items-center <?= $pageActuelle === "admin_clients" ? "active" : "" ?>"
        href="index.php?page=admin_clients"
    >
        <span class="icon-circle">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="15" height="15">
                <path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5s-3 1.34-3 3 1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5C15 14.17 10.33 13 8 13zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/>
            </svg>
        </span>
        <span class="mt-1">Clients</span>
    </a>
</li>
<li class="nav-item d-flex flex-column align-items-center nav-item-fixed">
    <a
        class="nav-link d-flex flex-column align-items-center <?= $pageActuelle === "admin_dashboard" ? "active" : "" ?>"
        href="index.php?page=admin_dashboard"
    >
        <span class="icon-circle">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="15" height="15">
                <path d="M3 13h8V3H3v10zm10 8h8V3h-8v18zM3 21h8v-6H3v6z"/>
            </svg>
        </span>
        <span class="mt-1">Dashboard</span>
    </a>
</li>

                        <li class="nav-item d-flex flex-column align-items-center nav-item-fixed">
                            <form
                                method="post"
                                action="index.php"
                                class="nav-link d-flex flex-column align-items-center m-0 p-0"
                                style="background:none; border:0;"
                            >
                                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars((string)$_SESSION["csrf_token"]) ?>">
                                <button
                                    type="submit"
                                    name="logout"
                                    class="d-flex flex-column align-items-center"
                                    style="background:none; border:0; padding:0; color:inherit; cursor:pointer;"
                                >
                                    <span class="icon-circle">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="15" height="15">
                                            <path d="M10 17l5-5-5-5v10zM4 19h6v2H4c-1.1 0-2-.9-2-2V5c0-1.1.9-2 2-2h6v2H4v14z"/>
                                        </svg>
                                    </span>
                                    <span class="mt-1">déconnexion</span>
                                </button>
                            </form>
                        </li>

                        <li class="nav-item d-flex flex-column align-items-center nav-item-fixed">
                            <span class="nav-link"><?= htmlspecialchars((string)$prenomAffiche) ?></span>
                        </li>

                    <?php else: ?>

                        <li class="nav-item d-flex flex-column align-items-center nav-item-fixed">
                            <a
                                class="nav-link d-flex flex-column align-items-center <?= $pageActuelle === "dashboard_client" ? "active" : "" ?>"
                                href="index.php?page=dashboard_client"
                            >
                                <span class="icon-circle">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="15" height="15">
                                        <path d="M4 6h16v2H4V6zm0 5h16v2H4v-2zm0 5h10v2H4v-2z"/>
                                    </svg>
                                </span>
                                <span class="mt-1">mes réservations</span>
                            </a>
                        </li>

                        <li class="nav-item d-flex flex-column align-items-center nav-item-fixed">
                            <form
                                method="post"
                                action="index.php"
                                class="nav-link d-flex flex-column align-items-center m-0 p-0"
                                style="background:none; border:0;"
                            >
                                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars((string)$_SESSION["csrf_token"]) ?>">
                                <button
                                    type="submit"
                                    name="logout"
                                    class="d-flex flex-column align-items-center"
                                    style="background:none; border:0; padding:0; color:inherit; cursor:pointer;"
                                >
                                    <span class="icon-circle">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="15" height="15">
                                            <path d="M10 17l5-5-5-5v10zM4 19h6v2H4c-1.1 0-2-.9-2-2V5c0-1.1.9-2 2-2h6v2H4v14z"/>
                                        </svg>
                                    </span>
                                    <span class="mt-1">déconnexion</span>
                                </button>
                            </form>
                        </li>

                        <li class="nav-item nav-item-fixed">
    <a
        class="nav-link <?= $pageActuelle === "profile" ? "active" : "" ?>"
        href="index.php?page=profile"
    >
        <?= htmlspecialchars((string)$prenomAffiche) ?>
    </a>
</li>

                    <?php endif; ?>

                <?php else: ?>

                    <li class="nav-item d-flex flex-column align-items-center d-none d-lg-block nav-item-fixed">
                        <a class="nav-link d-flex flex-column align-items-center" href="#" onclick="openAgenceMap(); return false;">
                            <span class="icon-circle">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="15" height="15">
                                    <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                                </svg>
                            </span>
                            <span class="mt-1">notre agence</span>
                        </a>
                    </li>

                    <li class="nav-item d-flex flex-column align-items-center d-none d-lg-block nav-item-fixed">
                        <a class="nav-link d-flex flex-column align-items-center" href="index.php?page=about">
                            <span class="icon-circle">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="15" height="15">
                                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/>
                                </svg>
                            </span>
                            <span class="mt-1">à propos</span>
                        </a>
                    </li>

                    <li class="nav-item d-flex flex-column align-items-center nav-item-fixed">
                        <button
                            class="nav-link signin-nav-link d-flex flex-column align-items-center btn p-0"
                            data-bs-toggle="modal"
                            data-bs-target="#loginModal"
                        >
                            <span class="icon-circle">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="15" height="15">
                                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                </svg>
                            </span>
                            <span class="mt-1">se connecter</span>
                        </button>
                    </li>

                    <li class="nav-item d-flex flex-column align-items-center nav-item-fixed">
                        <button
                            class="nav-link d-flex flex-column align-items-center btn p-0"
                            data-bs-toggle="modal"
                            data-bs-target="#registerModal"
                        >
                            <span class="icon-circle">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="15" height="15">
                                    <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
                                </svg>
                            </span>
                            <span class="mt-1">s'inscrire</span>
                        </button>
                    </li>

                <?php endif; ?>

            </ul>
        </div>

    </div>
</nav>

<div class="custom-navbar navbar-expand-lg navbar-light bg-white sticky-top">
    <div class="container-fluid">
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto">

                <li class="nav-item me-4">
                    <a class="nav-link <?= $pageActuelle === "destinations" ? "active" : "" ?>" href="index.php?page=destinations">
                        <i class="fas fa-map-marked-alt nav-icon"></i> Destinations
                    </a>
                </li>

                <li class="nav-item me-4">
                    <a class="nav-link <?= $pageActuelle === "voyages" ? "active" : "" ?>" href="index.php?page=voyages">
                        <i class="fas fa-route nav-icon"></i> Voyages
                    </a>
                </li>

                <li class="nav-item me-4">
                    <a class="nav-link <?= $pageActuelle === "offres" ? "active" : "" ?>" href="index.php?page=offres">
                        <i class="fas fa-tags nav-icon"></i> Offres
                    </a>
                </li>

            </ul>
        </div>
    </div>
</div>
<section class="voyage-menu-section">
    <div class="voyage-container">
        <div class="voyage-menu-title" id="voyageTitle">
            <h1>Pour un voyage inoubliable …</h1>
        </div>
    </div>
</section>
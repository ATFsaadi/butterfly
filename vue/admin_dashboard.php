<div class="container mt-5">
    <div class="mb-4">
        <h2 class="mb-1">Dashboard administrateur</h2>
        <p class="text-muted mb-0">Vue d’ensemble de l’activité de la plateforme.</p>
    </div>

    <div class="row g-4">
        <div class="col-md-6 col-xl-3">
            <div class="card shadow-sm border-0 rounded-4 h-100">
                <div class="card-body">
                    <h6 class="text-muted">Clients</h6>
                    <h2 class="fw-bold mb-0"><?= (int)($stats["total_clients"] ?? 0) ?></h2>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card shadow-sm border-0 rounded-4 h-100">
                <div class="card-body">
                    <h6 class="text-muted">Clients désactivés</h6>
                    <h2 class="fw-bold mb-0"><?= (int)($stats["total_clients_desactives"] ?? 0) ?></h2>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card shadow-sm border-0 rounded-4 h-100">
                <div class="card-body">
                    <h6 class="text-muted">Réservations</h6>
                    <h2 class="fw-bold mb-0"><?= (int)($stats["total_reservations"] ?? 0) ?></h2>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card shadow-sm border-0 rounded-4 h-100">
                <div class="card-body">
                    <h6 class="text-muted">Chiffre d’affaires</h6>
                    <h2 class="fw-bold mb-0"><?= number_format((float)($stats["chiffre_affaires"] ?? 0), 2, ",", " ") ?> €</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0 rounded-4 mt-5">
        <div class="card-body">
            <h4 class="mb-3">Accès rapide</h4>

            <div class="d-flex flex-wrap gap-3">
                <a href="index.php?page=admin_clients" class="btn btn-outline-dark rounded-pill px-4">Clients</a>
                <a href="index.php?page=admin_reservations" class="btn btn-outline-dark rounded-pill px-4">Réservations</a>
                <a href="index.php?page=admin_destinations" class="btn btn-outline-dark rounded-pill px-4">Destinations</a>
                <a href="index.php?page=admin_voyages" class="btn btn-outline-dark rounded-pill px-4">Voyages</a>
                <a href="index.php?page=admin_offres" class="btn btn-outline-dark rounded-pill px-4">Offres</a>
            </div>
        </div>
    </div>
</div>
<?php

// sécurité des données

$stats = $stats ?? [];

?>

<!-- dashboard admin -->

<div class="container mt-5">

    <!-- en-tête -->

    <div class="mb-4">
        <h2 class="mb-1">Dashboard administrateur</h2>
        <p class="text-muted mb-0">Vue d’ensemble de l’activité de la plateforme.</p>
    </div>

    <!-- statistiques -->

    <div class="row g-4">
        <div class="col-md-6 col-xl-3">
            <div class="card shadow-sm border-0 rounded-4 h-100">
                <div class="card-body">
                    <h6 class="text-muted">Clients</h6>
                    <h2 class="fw-bold mb-0">
                        <?= (int) ($stats["total_clients"] ?? 0) ?>
                    </h2>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card shadow-sm border-0 rounded-4 h-100">
                <div class="card-body">
                    <h6 class="text-muted">Clients désactivés</h6>
                    <h2 class="fw-bold mb-0">
                        <?= (int) ($stats["total_clients_desactives"] ?? 0) ?>
                    </h2>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card shadow-sm border-0 rounded-4 h-100">
                <div class="card-body">
                    <h6 class="text-muted">Réservations</h6>
                    <h2 class="fw-bold mb-0">
                        <?= (int) ($stats["total_reservations"] ?? 0) ?>
                    </h2>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card shadow-sm border-0 rounded-4 h-100">
                <div class="card-body">
                    <h6 class="text-muted">Chiffre d’affaires</h6>
                    <h2 class="fw-bold mb-0">
                        <?= number_format((float) ($stats["chiffre_affaires"] ?? 0), 2, ",", " ") ?> €
                    </h2>
                </div>
            </div>
        </div>
    </div>


    
        </div>
    </div>
</div>
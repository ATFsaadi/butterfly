<?php

// securite donnees

$stats = $stats ?? [];

$totalClients = (int) ($stats["total_clients"] ?? 0);
$clientsDesactives = (int) ($stats["total_clients_desactives"] ?? 0);
$totalReservations = (int) ($stats["total_reservations"] ?? 0);
$chiffreAffaires = (float) ($stats["chiffre_affaires"] ?? 0);

$clientsActifs = max(0, $totalClients - $clientsDesactives);
$panierMoyen = $totalReservations > 0 ? $chiffreAffaires / $totalReservations : 0;

?>

<!-- dashboard admin -->

<div class="container mt-5 admin-dashboard">

    <!-- entete -->


        <h3 class="section-title text-center mt-5">Dashboard administrateur</h3>
        <p class="text-muted mb-0 text-center mt-5">Activite de la plateforme.</p>
        <br>


    <!-- statistiques -->

    <div class="row g-3">
        <div class="col-md-6 col-xl-3">
            <div class="admin-stat-card h-100 p-4">
                <div class="admin-stat-label">clients</div>
                <div class="admin-stat-value"><?= $totalClients ?></div>
                <div class="admin-stat-note"><?= $clientsActifs ?> actif(s)</div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="admin-stat-card h-100 p-4">
                <div class="admin-stat-label">comptes desactives</div>
                <div class="admin-stat-value"><?= $clientsDesactives ?></div>
                <div class="admin-stat-note">suivi clients</div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="admin-stat-card h-100 p-4">
                <div class="admin-stat-label">reservations</div>
                <div class="admin-stat-value"><?= $totalReservations ?></div>
                <div class="admin-stat-note">destinations et voyages</div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="admin-stat-card h-100 p-4">
                <div class="admin-stat-label">chiffre d'affaires</div>
                <div class="admin-stat-value">
                    <?= number_format($chiffreAffaires, 2, ",", " ") ?> &euro;
                </div>
                <div class="admin-stat-note">
                    panier moyen <?= number_format($panierMoyen, 2, ",", " ") ?> &euro;
                </div>
            </div>
        </div>
    </div>
</div>

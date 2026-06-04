<?php

// Controleur dashboard admin : charge les statistiques principales.

// sécurité admin

$unControleur->verifAdmin();

// statistiques du dashboard

$stats = $unControleur->getStatsDashboardAdmin();

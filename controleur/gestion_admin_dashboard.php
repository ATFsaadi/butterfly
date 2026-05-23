<?php

// sécurité admin

$unControleur->verifAdmin();

// statistiques du dashboard

$stats = $unControleur->getStatsDashboardAdmin();
<?php

// Controleur recherche : lance une recherche globale sur le site.

// récupération de la recherche

$recherche = trim((string) ($_GET["q"] ?? ""));

// variables de résultats

$destinations = [];
$voyages = [];
$offres = [];

// recherche globale

if ($recherche !== "") {
    // recherche destinations et offres

    $destinations = $unControleur->selectLike_destination($recherche) ?? [];
    $offres = $unControleur->selectLike_offres_actives($recherche) ?? [];

    // recherche voyages

    $allVoyages = $unControleur->selectAll_voyages_actifs() ?? [];
    $filtreMin = mb_strtolower($recherche);

    // fonction de filtre appliquee aux voyages
    $voyages = array_values(array_filter($allVoyages, function ($voyage) use ($filtreMin) {
        $titre = mb_strtolower((string) ($voyage["titre"] ?? ""));
        $pays = mb_strtolower((string) ($voyage["pays"] ?? ""));
        $ville = mb_strtolower((string) ($voyage["ville"] ?? ""));
        $continent = mb_strtolower((string) ($voyage["continent"] ?? ""));

        return mb_strpos($titre, $filtreMin) !== false
            || mb_strpos($pays, $filtreMin) !== false
            || mb_strpos($ville, $filtreMin) !== false
            || mb_strpos($continent, $filtreMin) !== false;
    }));
}

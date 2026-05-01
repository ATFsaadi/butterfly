<?php

$q = trim((string)($_GET["q"] ?? ""));

$destinations = [];
$voyages = [];
$offres = [];

if ($q !== "") {

    $destinations = $unControleur->selectLike_destination($q) ?? [];
    $offres = $unControleur->selectLike_offres_actives($q) ?? [];

    $allVoyages = $unControleur->selectAll_voyages_actifs() ?? [];

    $f = mb_strtolower($q);

    $voyages = array_values(array_filter($allVoyages, function ($v) use ($f) {
        $titre = mb_strtolower((string)($v["titre"] ?? ""));
        $pays = mb_strtolower((string)($v["pays"] ?? ""));
        $ville = mb_strtolower((string)($v["ville"] ?? ""));
        $continent = mb_strtolower((string)($v["continent"] ?? ""));

        return mb_strpos($titre, $f) !== false
            || mb_strpos($pays, $f) !== false
            || mb_strpos($ville, $f) !== false
            || mb_strpos($continent, $f) !== false;
    }));
}
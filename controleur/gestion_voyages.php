<?php

// récupération de la recherche

$q = trim((string) ($_GET["q"] ?? ""));

// récupération des voyages

$all = $unControleur->selectAll_voyages_actifs();

// filtre de recherche

if ($q !== "" && mb_strlen($q) >= 2) {
    $f = mb_strtolower($q);

    $voyages = array_values(array_filter($all, function ($v) use ($f) {
        $titre = mb_strtolower((string) ($v["titre"] ?? ""));
        $pays = mb_strtolower((string) ($v["pays"] ?? ""));
        $ville = mb_strtolower((string) ($v["ville"] ?? ""));
        $continent = mb_strtolower((string) ($v["continent"] ?? ""));

        return str_contains($titre, $f)
            || str_contains($pays, $f)
            || str_contains($ville, $f)
            || str_contains($continent, $f);
    }));
} else {
    $voyages = $all;
}
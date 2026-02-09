<?php

$q = trim((string)($_GET["q"] ?? ""));

$all = $unControleur->selectAll_voyages_actifs();

if ($q !== "" && mb_strlen($q) >= 2) {
    $f = mb_strtolower($q);

    $voyages = array_values(array_filter($all, function ($v) use ($f) {
        return str_contains(mb_strtolower((string)($v["titre"] ?? "")), $f)
            || str_contains(mb_strtolower((string)($v["pays"] ?? "")), $f)
            || str_contains(mb_strtolower((string)($v["ville"] ?? "")), $f)
            || str_contains(mb_strtolower((string)($v["continent"] ?? "")), $f);
    }));
} else {
    $voyages = $all;
}

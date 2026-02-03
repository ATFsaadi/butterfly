<?php

$q = trim((string) ($_GET["q"] ?? ""));

if ($q !== "") {
    $destinations = $unControleur->selectLike_destination($q);
} else {
    $destinations = $unControleur->selectAll_destinations();
}

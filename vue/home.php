<?php

// valeurs par defaut

$villesDepart = $villesDepart ?? [];
$destinations = $destinations ?? [];
$slides = $slides ?? [];
$offres = $offres ?? [];

?>

<!-- section hero -->
<section class="voyage-menu-section">
    <div class="voyage-container">
        <div class="voyage-menu-title" id="voyageTitle">
            <h1>Pour un Voyage inoubliable ...</h1>
        </div>
    </div>
</section>

<!-- barre recherche -->
<div id="voyageBar" class="w-100 bg-white" style="border-bottom:1px solid #eee;">
    <?php require_once __DIR__ . "/components/searchDestinations.php"; ?>
</div>

<!-- carousel slides -->
<?php require_once __DIR__ . "/components/carouselSlides.php"; ?>

<!-- carousel offres -->
<?php require_once __DIR__ . "/components/carouselOffres.php"; ?>

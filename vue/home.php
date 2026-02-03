<?php
// Valeurs par défaut pour éviter les warnings si une donnée manque
$villesDepart = $villesDepart ?? [];
$destinations = $destinations ?? [];
$slides       = $slides ?? [];
$offres       = $offres ?? [];
?>

<!-- section hero -->
<section class="voyage-menu-section">
    <div class="voyage-container">
        <div class="voyage-menu-title" id="voyageTitle">
            <h1>Pour un Voyage inoubliable ...</h1>
        </div>
    </div>
</section>

<!-- barre recherche sticky -->
<div id="voyageBar"
     class="position-sticky top-0 start-0 w-100 bg-white"
     style="z-index:1030; border-bottom:1px solid #eee;">

    <?php include __DIR__ . "/components/searchDestinations.php"; ?>
</div>

<!-- carousel slides -->
<?php include __DIR__ . "/components/carouselSlides.php"; ?>

<!-- carousel offres -->
<?php include __DIR__ . "/components/carouselOffres.php"; ?>



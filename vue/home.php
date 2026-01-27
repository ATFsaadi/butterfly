<?php

$villesDepart = $villesDepart ?? [];
$destinations = $destinations ?? [];
$voyages = $voyages ?? [];
$slides = $slides ?? [];
?>

<!-- section recherche voyage -->
<section class="voyage-menu-section">
    <div class="voyage-container">
        <div class="voyage-menu-title" id="voyageTitle">
            <h1>Pour un Voyage inoubliable ...</h1>
        </div>
    </div>
</section>

<!-- menu sticky -->
<div id="voyageBar" class="position-sticky top-0 start-0 w-100 bg-white" style="z-index: 1030; border-bottom: 1px solid #eee;">

    <!-- composant recherche -->
    <?php include __DIR__ . '/components/voyageSearch.php'; ?>

</div>

<!-- slides -->
<?php include __DIR__ . '/components/carouselSlides.php'; ?>

<!-- offres -->
<?php include __DIR__ . '/components/carouselOffres.php'; ?>

<!-- script -->
<script src="js/home.js" defer></script>

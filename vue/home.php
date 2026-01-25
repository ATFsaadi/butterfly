<?php
// Vérification variables
$villesDepart = $villesDepart ?? [];
$destinations = $destinations ?? [];
$voyages = $voyages ?? [];
$slides = $slides ?? [];
?>

<!-- SECTION RECHERCHE VOYAGE -->
<section class="voyage-menu-section">
    <div class="voyage-container">
        <div class="voyage-menu-title" id="voyageTitle">
            <h1>Pour un Voyage inoubliable ...</h1>
        </div>
    </div>
</section>

<!-- MENU STICKY -->
<div id="voyageBar" class="position-sticky top-0 start-0 w-100 bg-white" style="z-index: 1030; border-bottom: 1px solid #eee;">
    <?php include __DIR__ . '/components/voyageSearch.php'; ?>
</div>

<!-- SECTION SELECTION (Slides dynamiques) -->
<?php include __DIR__ . '/components/carouselSelection.php'; ?>

<!-- SECTION OFFRES (Voyages dynamiques) -->
<?php include __DIR__ . '/components/carouselOffres.php'; ?>

<script src="js/home.js" defer></script>

<?php

$destinations = $destinations ?? [];
$voyages = $voyages ?? [];
$offres = $offres ?? [];
$successRegister = $successRegister ?? "";
$openLoginAfterRegister = $openLoginAfterRegister ?? false;

?>

<section class="voyage-menu-section">
    <div class="voyage-container">
        <div class="voyage-menu-title" id="voyageTitle">
            <h1>Pour un voyage inoubliable …</h1>
        </div>
    </div>
</section>

<div id="voyageBar" class="w-100 bg-white" style="border-bottom:1px solid #eee;">
    <?php require_once __DIR__ . "/components/searchDestinations.php"; ?>
</div>

<?php if (!empty($voyages)): ?>
    <?php require_once __DIR__ . "/components/carouselVoyages.php"; ?>
<?php endif; ?>

<?php if (!empty($offres)): ?>
    <?php require_once __DIR__ . "/components/carouselOffres.php"; ?>
<?php endif; ?>

<?php if ($successRegister !== ""): ?>
    <div class="container mt-4">
        <div class="alert alert-success text-center">
            <?= htmlspecialchars($successRegister) ?>
        </div>
    </div>
<?php endif; ?>

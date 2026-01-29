<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Butterfly Voyage</title>

    <!-- librairies -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">

    <!-- polices -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Genos&family=Lavishly+Yours&family=Meow+Script&family=Poiret+One&display=swap" rel="stylesheet">

    <!-- styles -->
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="style/page.css">
    <link rel="stylesheet" href="style/responsive.css">
    <link rel="stylesheet" href="style/admin.css">
</head>

<body>

<!-- navigation -->
<?php
require_once __DIR__ . "/components/navbar.php";
require_once __DIR__ . "/modales/login.php";
require_once __DIR__ . "/modales/register.php";
require_once __DIR__ . "/modales/map.php";
?>

<!-- contenu -->
<main>
    <?php
    if (isset($viewFile) && file_exists($viewFile)) {
        include $viewFile;
    } else {
        echo "<p>La page demandée n'existe pas.</p>";
    }
    ?>
</main>

<!-- pied de page -->
<?php require_once __DIR__ . "/components/footer.php"; ?>

<!-- scripts -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="js/script.js"></script>
<script src="js/flatpickr.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/fr.js"></script>

</body>
</html>

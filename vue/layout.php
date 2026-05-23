<!DOCTYPE html>
<html lang="fr">

<head>
    <!-- métadonnées -->

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Butterfly Voyage</title>

    <!-- librairies css -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">

    <!-- polices -->

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Genos&family=Lavishly+Yours&family=Meow+Script&family=Poiret+One&display=swap"
        rel="stylesheet"
    >

    <!-- styles projet -->

    <link rel="stylesheet" href="styles/style.css?v=20260523">
    <link rel="stylesheet" href="styles/page.css?v=20260523">
    <link rel="stylesheet" href="styles/components.css?v=20260523">
    <link rel="stylesheet" href="styles/responsive.css?v=20260523">
    <link rel="stylesheet" href="styles/admin.css?v=20260523">
</head>

<body class="bg-light">

    <!-- navbar -->

    <?php require_once __DIR__ . "/components/navbar.php"; ?>

    <!-- contenu principal -->

    <main class="my-4">
        <?php
        $pathVue = __DIR__ . "/" . ($vue ?? "home.php");

        if (file_exists($pathVue)) {
            require_once $pathVue;
        } else {
            echo "<div class='container mt-4'><div class='alert alert-danger'>vue introuvable : "
                . htmlspecialchars((string) ($vue ?? ""))
                . "</div></div>";
        }
        ?>
    </main>

    <!-- footer -->

    <?php require_once __DIR__ . "/components/footer.php"; ?>

    <!-- modales -->

    <?php

        // modales

        require_once __DIR__ . "/modales/login.php";
        require_once __DIR__ . "/modales/register.php";
        require_once __DIR__ . "/modales/map.php";
        require_once __DIR__ . "/modales/about.php"

    ?>

    <!-- scripts -->

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/script.js"></script>
    <script src="js/compteur.js"></script>
</body>

</html>

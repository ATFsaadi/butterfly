<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Butterfly Voyage</title>

    <!-- css libs -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">

    <!-- fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Genos&family=Lavishly+Yours&family=Meow+Script&family=Poiret+One&display=swap" rel="stylesheet">

    <!-- css projet -->
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="style/page.css">
    <link rel="stylesheet" href="style/responsive.css">
    <link rel="stylesheet" href="style/admin.css">
</head>

<body class="bg-light">

    <!-- navbar -->
    <?php require_once "vue/components/navbar.php"; ?>

    <!-- contenu -->
    <main class="my-4">
        <?php
        // inclusion de la vue

        $pathVue = "vue/" . ($vue ?? "home.php");

        if (file_exists($pathVue)) {
            require_once $pathVue;
        } else {
            echo "<div class='alert alert-danger'>vue introuvable : " . htmlspecialchars($vue ?? "") . "</div>";
        }
        ?>
    </main>

    <!-- footer -->
    <?php require_once "vue/components/footer.php"; ?>

    <!-- modales -->
    <?php
    require_once "vue/modales/login.php";
    require_once "vue/modales/register.php";
    ?>

    <!-- js -->
     <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/script.js"></script>
</body>
</html>

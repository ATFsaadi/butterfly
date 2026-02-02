<!DOCTYPE html>
<html lang="fr">
<head>
    <!-- meta -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- titre -->
    <title>Butterfly Voyage</title>

    <!-- librairies css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">

    <!-- polices -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Genos&family=Lavishly+Yours&family=Meow+Script&family=Poiret+One&display=swap" rel="stylesheet">

    <!-- styles projet -->
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="style/page.css">
    <link rel="stylesheet" href="style/responsive.css">
    <link rel="stylesheet" href="style/admin.css">
</head>


<body class="bg-light">

  <!-- NAVBAR -->
  <?php require_once("vue/components/navbar.php"); ?>

  <!-- CONTENU -->
  <main class="container my-4">
    <?php
      $pathVue = "vue/" . $vue;
      if (file_exists($pathVue)) {
          require_once($pathVue);
      } else {
          echo "<div class='alert alert-danger'>Vue introuvable : ".htmlspecialchars($vue)."</div>";
      }
    ?>
  </main>

  <!-- FOOTER -->
  <?php require_once("vue/components/footer.php"); ?>

  <!-- MODALES AUTH (si tu les gardes séparées) -->
  <?php
    // Tu peux laisser toujours présent, même si l’utilisateur est connecté.
    // Sinon, tu peux conditionner sur !isset($_SESSION['user'])
    require_once("vue/modales/login.php");
    require_once("vue/modales/register.php");
  ?>

  <!-- JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="js/auth-modals.js"></script>
</body>
</html>

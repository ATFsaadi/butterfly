<?php
if(isset($_GET['rechercher'])) {
    $type = $_GET['type'] ?? null;
    $destination = $_GET['destination'] ?? null;
    $villeDepart = $_GET['villeDepart'] ?? null;
    $date = $_GET['date'] ?? null;
    $duree = $_GET['duree'] ?? null;

    $voyages = $controleur->rechercherVoyages($type, $destination, $villeDepart, $date, $duree);
}
?>

<!-- Affichage -->
<?php if(!empty($voyages)): ?>
    <div class="row">
        <?php foreach($voyages as $v): ?>
            <div class="col-md-4">
                <div class="card">
                    <h6 class="card-title"><?= htmlspecialchars($v['destination']) ?></h6>
                    <p class="card-text">Ville départ: <?= htmlspecialchars($v['ville_depart']) ?><br>
                    Date: <?= htmlspecialchars($v['date_depart']) ?><br>
                    Durée: <?= htmlspecialchars($v['duree']) ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

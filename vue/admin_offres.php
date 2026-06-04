<?php

// Vue admin offres : assemble messages, formulaire et tableau.

// sécurité des données

$success = $success ?? "";
$errors = $errors ?? [];

?>

<!-- message succès -->

<?php if (!empty($success)): ?>
    <div class="container mt-4">
        <div class="alert alert-success text-center">
            <?= htmlspecialchars((string) $success) ?>
        </div>
    </div>
<?php endif; ?>

<!-- messages erreurs -->

<?php if (!empty($errors)): ?>
    <div class="container mt-4">
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php foreach ($errors as $err): ?>
                    <li><?= htmlspecialchars((string) $err) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
<?php endif; ?>

<!-- formulaire offre -->

<?php require_once __DIR__ . "/vue_insert_offre.php"; ?>

<!-- liste offres -->

<?php require_once __DIR__ . "/vue_select_offres.php"; ?>

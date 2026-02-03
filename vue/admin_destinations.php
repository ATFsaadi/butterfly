<?php
// vue/admin_destinations.php

// messages
?>

<?php if (!empty($success)): ?>
  <div class="container mt-4">
    <div class="alert alert-success text-center"><?= htmlspecialchars($success) ?></div>
  </div>
<?php endif; ?>

<?php if (!empty($errors)): ?>
  <div class="container mt-4">
    <div class="alert alert-danger">
      <ul class="mb-0">
        <?php foreach ($errors as $err): ?>
          <li><?= htmlspecialchars((string)$err) ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
  </div>
<?php endif; ?>

<?php require_once __DIR__ . "/vue_insert_destinations.php"; ?>
<?php require_once __DIR__ . "/vue_select_destinations.php"; ?>

<?php
// vue/admin_destinations.php
?>

<?php if (!empty($success)): ?>
  <div class="container mt-4">
    <div class="alert alert-success text-center"><?= htmlspecialchars($success) ?></div>
  </div>
<?php endif; ?>

<?php if (!empty($errors)): ?>
  <div class="container mt-4">
    <div class="alert alert-danger">
      <?php foreach ($errors as $err): ?>
        <p class="mb-0"><?= htmlspecialchars((string)$err) ?></p>
      <?php endforeach; ?>
    </div>
  </div>
<?php endif; ?>


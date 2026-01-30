<?php
$hasRegisterErrors = !empty($_SESSION['register_errors']);
$firstRegisterError = $hasRegisterErrors ? ($_SESSION['register_errors'][0] ?? "Erreur d'inscription.") : '';

$old = $_SESSION['old_register'] ?? [];
$oldNom = $old['nom'] ?? '';
$oldPrenom = $old['prenom'] ?? '';
$oldEmail = $old['email'] ?? '';
?>

<div class="modal fade"
     id="registerModal"
     tabindex="-1"
     aria-hidden="true"
     data-open="<?= $hasRegisterErrors ? '1' : '0' ?>">

  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content p-0" style="border-radius:20px; overflow:hidden;">

      <button type="button"
              class="btn-close position-absolute top-0 end-0 m-3"
              data-bs-dismiss="modal"
              aria-label="Close"></button>

      <div class="auth-card">
        <div class="auth-form">
          <h2>Inscription</h2>

          <?php if ($hasRegisterErrors): ?>
            <div class="alert alert-danger">
              <?= htmlspecialchars((string)$firstRegisterError) ?>
            </div>
          <?php endif; ?>

          <form method="POST" action="controleur/gestion.register.php">
            <input type="hidden" name="register_form" value="1">

            <input type="text" name="nom" placeholder="Nom"
                    value="<?= htmlspecialchars((string)$oldNom) ?>" required>

            <input type="text" name="prenom" placeholder="Prénom"
                    value="<?= htmlspecialchars((string)$oldPrenom) ?>" required>

            <input type="email" name="email" placeholder="Adresse email"
                    value="<?= htmlspecialchars((string)$oldEmail) ?>" required>

            <input type="password" name="mot_de_passe" placeholder="Mot de passe" required>

            <input type="password" name="confirmer_mot_de_passe" placeholder="Confirmer le mot de passe" required>

            <button type="submit" class="btn btn-primary w-100">
                S’inscrire
            </button>
            </form>


          <p class="switch-link text-center mt-3">
            Déjà un compte ?
            <a href="#"
               data-bs-toggle="modal"
               data-bs-target="#loginModal"
               data-bs-dismiss="modal">
              Connectez-vous
            </a>
          </p>

        </div>

        <div class="auth-logo text-center p-3">
          <img src="icons/logo-acc.png" alt="Logo de l'agence" style="max-height:80px;">
        </div>

      </div>
    </div>
  </div>
</div>
<?php if ($hasRegisterErrors): ?>
<script>
document.addEventListener("DOMContentLoaded", () => {
  const el = document.getElementById("registerModal");
  if (!el) return;
  if (typeof bootstrap !== "undefined") {
    new bootstrap.Modal(el).show();
  }
});
</script>
<?php endif; ?>

<?php
unset($_SESSION['register_errors'], $_SESSION['old_register']);
?>

<?php
// Nettoyage APRES génération HTML
unset($_SESSION['register_errors'], $_SESSION['old_register']);
?>

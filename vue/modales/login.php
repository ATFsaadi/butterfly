<?php
// vue/modales/login.php
// session déjà démarrée dans index.php
?>

<div class="modal fade"
     id="loginModal"
     tabindex="-1"
     aria-hidden="true">

  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content p-0" style="border-radius:20px; overflow:hidden;">

      <button type="button"
              class="btn-close position-absolute top-0 end-0 m-3"
              data-bs-dismiss="modal"
              aria-label="Close"></button>

      <div class="auth-card">
        <div class="auth-form">
          <h2>Connexion</h2>

          <!-- message erreur -->
          <?php if (!empty($erreurLogin)): ?>
            <div class="alert alert-danger">
              <?= htmlspecialchars($erreurLogin) ?>
            </div>
          <?php endif; ?>

          <!-- message succès (optionnel) -->
          <?php if (!empty($successLogin)): ?>
            <div class="alert alert-success">
              <?= htmlspecialchars($successLogin) ?>
            </div>
          <?php endif; ?>

          <form method="POST" action="index.php?page=login">

            <!-- CSRF -->
            <input type="hidden"
                   name="csrf_token"
                   value="<?= htmlspecialchars($_SESSION["csrf_token"] ?? "") ?>">

            <input type="email"
                   name="email"
                   placeholder="Adresse email"
                   required
                   value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">

            <input type="password"
                   name="mdp"
                   placeholder="Mot de passe"
                   required>

            <div class="form-options d-flex justify-content-end align-items-center mb-2">
              <a href="#" class="auth-link">Mot de passe oublié ?</a>
            </div>

            <button type="submit"
                    name="Connexion"
                    class="btn btn-primary w-100">
              Se connecter
            </button>
          </form>

          <div class="divider my-3 text-center">OU</div>

          <div class="social-buttons d-flex justify-content-center gap-2 mb-3">
            <button class="btn btn-outline-secondary" type="button" disabled>
              <i class="fab fa-google"></i>
            </button>
            <button class="btn btn-outline-secondary" type="button" disabled>
              <i class="fab fa-facebook-f"></i>
            </button>
            <button class="btn btn-outline-secondary" type="button" disabled>
              <i class="fab fa-apple"></i>
            </button>
          </div>

          <p class="switch-link text-center">
            Pas de compte ?
            <a href="#"
               data-bs-toggle="modal"
               data-bs-target="#registerModal"
               data-bs-dismiss="modal">
              Inscrivez-vous
            </a>
          </p>
        </div>

        <div class="auth-logo text-center p-3">
          <img src="icons/logo-acc.png"
               alt="Logo de l'agence"
               style="max-height:80px;">
        </div>

      </div>
    </div>
  </div>
</div>

<!-- Réouverture automatique du modal si erreur -->
<?php if (!empty($erreurLogin)): ?>
<script>
  document.addEventListener("DOMContentLoaded", function () {
    const modal = new bootstrap.Modal(document.getElementById('loginModal'));
    modal.show();
  });
</script>
<?php endif; ?>

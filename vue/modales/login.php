<?php
$hasAuthErrors = !empty($_SESSION['auth_errors']);
$hasSuccess = !empty($_SESSION['flash_success']);

$firstError = $hasAuthErrors ? ($_SESSION['auth_errors'][0] ?? "Email ou mot de passe incorrect.") : '';
$oldEmail = $_SESSION['old_email'] ?? '';
?>


<!-- modal connexion -->
<div class="modal fade"
     id="loginModal"
     tabindex="-1"
     aria-hidden="true"
     data-open="<?= $hasAuthErrors ? '1' : '0' ?>">


  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content p-0" style="border-radius:20px; overflow:hidden;">

      <button type="button"
              class="btn-close position-absolute top-0 end-0 m-3"
              data-bs-dismiss="modal"
              aria-label="Close"></button>

      <div class="auth-card">
        <div class="auth-form">
          <h2>Connexion</h2>
            <?php if (!empty($_SESSION['flash_success'])): ?>
                <div class="alert alert-success">
                    <?= htmlspecialchars((string)$_SESSION['flash_success']) ?>
                </div>
            <?php endif; ?>


          <?php if ($hasAuthErrors): ?>
            <div class="alert alert-danger">
              <?= htmlspecialchars((string)$firstError) ?>
            </div>
          <?php endif; ?>

          <form method="POST" action="controleur/gestion.login.php">
            <input type="email"
                   name="email"
                   placeholder="Adresse email"
                   value="<?= htmlspecialchars((string)$oldEmail) ?>"
                   required>

            <input type="password"
                   name="mot_de_passe"
                   placeholder="Mot de passe"
                   required>

            <div class="form-options d-flex justify-content-between align-items-center mb-2">
              <label>
                <input type="checkbox" name="remember_me">
                Se souvenir de moi
              </label>
              <a href="#" class="auth-link">Mot de passe oublié ?</a>
            </div>

            <button type="submit" name="Connexion" class="btn btn-primary w-100">
              Se connecter
            </button>
          </form>

          <div class="divider my-3 text-center">OU</div>

          <div class="social-buttons d-flex justify-content-center gap-2 mb-3">
            <button class="btn btn-outline-secondary" type="button"><i class="fab fa-google"></i></button>
            <button class="btn btn-outline-secondary" type="button"><i class="fab fa-facebook-f"></i></button>
            <button class="btn btn-outline-secondary" type="button"><i class="fab fa-apple"></i></button>
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
          <img src="icons/logo-acc.png" alt="Logo de l'agence" style="max-height:80px;">
        </div>

      </div>
    </div>
  </div>
</div>

<?php if ($hasAuthErrors || $hasSuccess): ?>
<script>
document.addEventListener("DOMContentLoaded", () => {
  const el = document.getElementById("loginModal");
  if (!el) return;
  if (typeof bootstrap !== "undefined") {
    new bootstrap.Modal(el).show();
  }
});
</script>
<?php endif; ?>

<?php
unset($_SESSION['auth_errors'], $_SESSION['old_email'], $_SESSION['flash_success']);
?>


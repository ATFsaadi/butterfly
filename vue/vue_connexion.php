  <section class="auth-section auth-connexion">
    <div class="auth-container">
      <div class="auth-card">
        <div class="auth-form">
          <h2>Connexion</h2>
          <form method="POST" action="index.php?page=login">
            <input type="email" name="email" placeholder="Adresse email" required>
            <input type="password" name="mot_de_passe" placeholder="Mot de passe" required>
            <div class="form-options">
              <label><input type="checkbox" name="remember_me"> Se souvenir de moi</label>
              <a href="#" class="auth-link">Mot de passe oublié ?</a>
            </div>
            <button type="submit" name="Connexion">Se connecter</button>
          </form>
          <div class="divider">OU</div>
          <div class="social-buttons">
            <button><i class="fab fa-google"></i></button>
            <button><i class="fab fa-facebook-f"></i></button>
            <button><i class="fab fa-apple"></i></button>
          </div>
          <p class="switch-link">
            Pas de compte ? <a href="index.php?page=inscription">Inscrivez-vous</a>
          </p>
        </div>

        <div class="auth-logo">
          <img src="icons/logo-acc.png" alt="Logo de l'agence">
        </div>
      </div>
    </div>
  </section>

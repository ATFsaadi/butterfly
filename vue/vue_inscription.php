<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="crossorigin">
<link rel="stylesheet" href="../style/page.css">

<section class="auth-section">
  <div class="auth-container">
    <div class="auth-card">

      <!-- Formulaire -->
      <div class="auth-form">
        <h2>Inscription</h2>
        <form action="traitement_inscription.php" method="POST">
          <input type="text" name="nom" placeholder="Nom complet" required>
          <input type="email" name="email" placeholder="Adresse email" required>
          <input type="password" name="mot_de_passe" placeholder="Mot de passe" required>
          <input type="password" name="confirmer_mot_de_passe" placeholder="Confirmer le mot de passe" required>
          <input type="text" name="telephone" placeholder="Téléphone (facultatif)">
          <button type="submit">S'inscrire</button>
        </form>
        <div class="divider">OU</div>
        <div class="social-buttons">
          <button><i class="fab fa-google"></i></button>
          <button><i class="fab fa-facebook-f"></i></button>
          <button><i class="fab fa-apple"></i></button>
        </div>
        <p class="switch-link">
          Déjà un compte ? <a href="vue_connexion.php">Connectez-vous</a>
        </p>
      </div>

      <!-- Logo à droite -->
      <div class="auth-logo">
        <img src="icons/logo-acc.png" alt="Logo de l'agence">
      </div>

    </div>
  </div>
</section>

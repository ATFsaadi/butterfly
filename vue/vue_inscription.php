
    <div class="auth-card">
      <div class="auth-form">
        <h2>Inscription</h2>
        <form method="POST" action="<?= $_SERVER['REQUEST_URI'] ?>">
            <input type="text" name="nom" placeholder="nom" value="<?= htmlspecialchars($_POST['nom'] ?? '') ?>" required>
            <input type="text" name="prenom" placeholder="prenom" value="<?= htmlspecialchars($_POST['prenom'] ?? '') ?>" required>
            <input type="email" name="email" placeholder="adresse email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
            <input type="password" name="mot_de_passe" placeholder="mot de passe" required>
            <input type="password" name="confirmer_mot_de_passe" placeholder="confirmer le mot de passe" required>
            <input type="text" name="telephone" placeholder="telephone (facultatif)" value="<?= htmlspecialchars($_POST['telephone'] ?? '') ?>">
            
            <input type="hidden" name="inscription_submit" value="1">
            <button type="submit">s'inscrire</button>
        </form>
        <div class="divider"></div>
      
        <p class="switch-link">
            deja un compte ? 
            <a href="#" data-bs-toggle="modal" data-bs-target="#loginModal" data-bs-dismiss="modal">connectez-vous</a>
        </p>
      </div>
      <div class="auth-logo">
          <img src="icons/logo-acc.png" alt="Logo de l'agence">
        </div>
    </div>


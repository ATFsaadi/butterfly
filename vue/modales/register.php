<div class="modal fade" id="registerModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content p-0" style="border-radius:20px; overflow:hidden;">

            <button type="button" class="btn-close position-absolute top-0 end-0 m-3" data-bs-dismiss="modal"></button>

            <div class="auth-card">
                <div class="auth-form">
                    <h2>Inscription</h2>
                    <form method="POST" action="<?= $_SERVER['REQUEST_URI'] ?>">
                        <input type="text" name="nom" placeholder="Nom" value="<?= htmlspecialchars($_POST['nom'] ?? '') ?>" required>
                        <input type="text" name="prenom" placeholder="Prénom" value="<?= htmlspecialchars($_POST['prenom'] ?? '') ?>" required>
                        <input type="email" name="email" placeholder="Adresse email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
                        <input type="password" name="mot_de_passe" placeholder="Mot de passe" required>
                        <input type="password" name="confirmer_mot_de_passe" placeholder="Confirmer le mot de passe" required>
                        <input type="text" name="telephone" placeholder="Téléphone (facultatif)" value="<?= htmlspecialchars($_POST['telephone'] ?? '') ?>">
                        <input type="hidden" name="inscription_submit" value="1">
                        <button type="submit">S'inscrire</button>
                    </form>
                    <div class="divider"></div>
                    <p class="switch-link">
                        Déjà un compte ? 
                        <a href="#" data-bs-toggle="modal" data-bs-target="#loginModal" data-bs-dismiss="modal">Connectez-vous</a>
                    </p>
                </div>
                <div class="auth-logo">
                    <img src="icons/logo-acc.png" alt="Logo de l'agence">
                </div>
            </div>
        </div>
    </div>
</div>

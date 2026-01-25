<div class="modal fade" id="loginModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content p-0" style="border-radius:20px; overflow:hidden;">

            <button type="button" class="btn-close position-absolute top-0 end-0 m-3" data-bs-dismiss="modal"></button>

            <div class="auth-card">
                <div class="auth-form">
                    <h2>Connexion</h2>
                    <form method="POST" action="index.php?page=home">
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
                        Pas de compte ? 
                        <a href="#" data-bs-toggle="modal" data-bs-target="#registerModal" data-bs-dismiss="modal">Inscrivez-vous</a>
                    </p>
                </div>
                <div class="auth-logo">
                    <img src="icons/logo-acc.png" alt="Logo de l'agence">
                </div>
            </div>
        </div>
    </div>
</div>

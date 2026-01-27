<div class="modal fade" id="loginModal" tabindex="-1" aria-hidden="true">

    <!-- boite modale -->
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content p-0" style="border-radius:20px; overflow:hidden;">

            <!-- bouton fermeture -->
            <button type="button"
                    class="btn-close position-absolute top-0 end-0 m-3"
                    data-bs-dismiss="modal">
            </button>

            <!-- carte authentification -->
            <div class="auth-card">

                <!-- formulaire -->
                <div class="auth-form">
                    <h2>Connexion</h2>

                    <!-- messages erreur -->
                    <?php if (!empty($errors)) : ?>
                        <?php foreach ($errors as $err) : ?>
                            <div class="alert alert-danger"><?= htmlspecialchars($err) ?></div>
                        <?php endforeach; ?>
                    <?php endif; ?>

                    <!-- formulaire connexion -->
                    <form method="POST" action="controleur/gestion.login.php">
                        <input type="email"
                               name="email"
                               placeholder="Adresse email"
                               value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                               required>

                        <input type="password"
                               name="mot_de_passe"
                               placeholder="Mot de passe"
                               required>

                        <!-- options -->
                        <div class="form-options d-flex justify-content-between align-items-center mb-2">
                            <label>
                                <input type="checkbox" name="remember_me">
                                Se souvenir de moi
                            </label>
                            <a href="#" class="auth-link">Mot de passe oublié ?</a>
                        </div>

                        <button type="submit"
                                name="Connexion"
                                class="btn btn-primary w-100">
                            Se connecter
                        </button>
                    </form>

                    <!-- separation -->
                    <div class="divider my-3 text-center">OU</div>

                    <!-- reseaux sociaux -->
                    <div class="social-buttons d-flex justify-content-center gap-2 mb-3">
                        <button class="btn btn-outline-secondary"><i class="fab fa-google"></i></button>
                        <button class="btn btn-outline-secondary"><i class="fab fa-facebook-f"></i></button>
                        <button class="btn btn-outline-secondary"><i class="fab fa-apple"></i></button>
                    </div>

                    <!-- lien inscription -->
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

                <!-- logo -->
                <div class="auth-logo text-center p-3">
                    <img src="icons/logo-acc.png"
                         alt="Logo de l'agence"
                         style="max-height:80px;">
                </div>

            </div>
        </div>
    </div>
</div>

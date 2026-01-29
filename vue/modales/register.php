<!-- modale inscription -->
<div class="modal fade" id="registerModal" tabindex="-1" aria-hidden="true">

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

                <!-- formulaire inscription -->
                <div class="auth-form">
                    <h2>Inscription</h2>

                    <!-- message erreur -->
                    <?php if (!empty($erreur)) : ?>
                        <div class="alert alert-danger">
                            <?= htmlspecialchars($erreur) ?>
                        </div>
                    <?php endif; ?>

                    <!-- formulaire -->
                    <form method="POST" action="controleur/gestion.register.php">

                        <!-- nom -->
                        <input type="text" name="nom" placeholder="Nom"
                               value="<?= htmlspecialchars($_POST['nom'] ?? '') ?>" required>

                        <!-- prenom -->
                        <input type="text" name="prenom" placeholder="Prénom"
                               value="<?= htmlspecialchars($_POST['prenom'] ?? '') ?>" required>

                        <!-- email -->
                        <input type="email" name="email" placeholder="Adresse email"
                               value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>

                        <!-- mot de passe -->
                        <input type="password" name="mot_de_passe" placeholder="Mot de passe" required>

                        <!-- confirmation mot de passe -->
                        <input type="password" name="confirmer_mot_de_passe"
                               placeholder="Confirmer le mot de passe" required>

                        <!-- telephone -->
                        <input type="text" name="telephone"
                               placeholder="Téléphone (facultatif)"
                               value="<?= htmlspecialchars($_POST['telephone'] ?? '') ?>">

                        <!-- flag inscription -->
                        <input type="hidden" name="inscription_submit" value="1">

                        <!-- bouton submit -->
                        <button type="submit" class="btn btn-success w-100">
                            S'inscrire
                        </button>

                    </form>

                    <!-- lien connexion -->
                    <div class="divider my-3 text-center"></div>

                    <p class="switch-link text-center">
                        Déjà un compte ?
                        <a href="#"
                           data-bs-toggle="modal"
                           data-bs-target="#loginModal"
                           data-bs-dismiss="modal">
                            Connectez-vous
                        </a>
                    </p>

                </div>

                <!-- logo -->
                <div class="auth-logo text-center p-3">
                    <img src="icons/logo-acc.png"
                         alt="logo agence"
                         style="max-height:80px;">
                </div>

            </div>
        </div>
    </div>
</div>

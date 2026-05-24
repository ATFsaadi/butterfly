<!-- modale inscription -->

<div
    class="modal fade"
    id="registerModal"
    tabindex="-1"
    aria-hidden="true"
>
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content p-0" style="border-radius:12px; overflow:hidden;">

            <!-- bouton fermeture -->

            <button
                type="button"
                class="btn-close position-absolute top-0 end-0 m-3"
                data-bs-dismiss="modal"
                aria-label="Close"
            ></button>

            <!-- contenu inscription -->

            <div class="auth-card">
                <div class="auth-form">
                    <h2>Inscription</h2>

                    <!-- messages -->

                    <?php if (!empty($successRegister)): ?>
                        <div class="alert alert-success">
                            <?= htmlspecialchars($successRegister) ?>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($erreurRegister)): ?>
                        <div class="alert alert-danger">
                            <?= htmlspecialchars($erreurRegister) ?>
                        </div>
                    <?php endif; ?>

                    <!-- formulaire inscription -->

                    <form method="POST" action="index.php?page=register">
                        <input
                            type="hidden"
                            name="csrf_token"
                            value="<?= htmlspecialchars($_SESSION["csrf_token"] ?? "") ?>"
                        >

                        <input
                            type="text"
                            name="nom"
                            placeholder="Nom"
                            value="<?= htmlspecialchars($_POST["nom"] ?? "") ?>"
                            required
                        >

                        <input
                            type="text"
                            name="prenom"
                            placeholder="Prénom"
                            value="<?= htmlspecialchars($_POST["prenom"] ?? "") ?>"
                            required
                        >

                        <input
                            type="email"
                            name="email"
                            placeholder="Adresse email"
                            value="<?= htmlspecialchars($_POST["email"] ?? "") ?>"
                            required
                        >

                        <input
                            type="password"
                            name="mdp"
                            placeholder="Mot de passe"
                            required
                        >

                        <input
                            type="password"
                            name="mdp2"
                            placeholder="Confirmer le mot de passe"
                            required
                        >

                        <button
                            type="submit"
                            name="inscrire"
                            value="1"
                            class="btn btn-primary w-100"
                        >
                            S’inscrire
                        </button>
                    </form>

                    <!-- lien connexion -->

                    <p class="switch-link text-center mt-3">
                        Déjà un compte ?
                        <a
                            href="#"
                            data-bs-toggle="modal"
                            data-bs-target="#loginModal"
                            data-bs-dismiss="modal"
                        >
                            Connectez-vous
                        </a>
                    </p>
                </div>

                <!-- logo -->

                <div class="auth-logo text-center p-3">
                    <img
                        src="icons/logoForm.png"
                        alt="Logo de l'agence"
                        style="max-height:300px;"
                    >
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ouverture automatique -->

<?php if (!empty($erreurRegister)): ?>
    <script>
        window.__OPEN_REGISTER_MODAL__ = true;
    </script>
<?php endif; ?>

<?php if (!empty($openLoginAfterRegister)): ?>
    <script>
        window.__OPEN_LOGIN_MODAL__ = true;
    </script>
<?php endif; ?>

<!-- ouverture modales -->

<script>
    document.addEventListener("DOMContentLoaded", function () {
        try {
            if (window.__OPEN_REGISTER_MODAL__) {
                new bootstrap.Modal(document.getElementById("registerModal")).show();
            }

            if (window.__OPEN_LOGIN_MODAL__) {
                new bootstrap.Modal(document.getElementById("loginModal")).show();
            }
        } catch (e) {
            // bootstrap non chargé
        }
    });
</script>

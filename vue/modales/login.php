<?php

// Modale connexion : gere le formulaire et la redirection apres login.

// paramètres de redirection

$redirect = (string) ($_GET["redirect"] ?? "");
$id_voyage_redirect = (int) ($_GET["id_voyage"] ?? 0);
$id_destination_redirect = (int) ($_GET["id_destination"] ?? 0);

// action du formulaire

$action = "index.php?page=login";

if ($redirect !== "") {
    $action .= "&redirect=" . urlencode($redirect);
}

if ($id_voyage_redirect > 0) {
    $action .= "&id_voyage=" . $id_voyage_redirect;
}

if ($id_destination_redirect > 0) {
    $action .= "&id_destination=" . $id_destination_redirect;
}

?>

<!-- modale connexion -->

<div
    class="modal fade"
    id="loginModal"
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

            <!-- contenu connexion -->

            <div class="auth-card">
                <div class="auth-form">
                    <h2>Connexion</h2>

                    <!-- messages -->

                    <?php if (!empty($erreurLogin)): ?>
                        <div class="alert alert-danger">
                            <?= htmlspecialchars($erreurLogin) ?>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($successLogin)): ?>
                        <div class="alert alert-success">
                            <?= htmlspecialchars($successLogin) ?>
                        </div>
                    <?php endif; ?>

                    <!-- formulaire connexion -->

                    <form method="POST" action="<?= htmlspecialchars($action) ?>">
                        <input
                            type="hidden"
                            name="csrf_token"
                            value="<?= htmlspecialchars($_SESSION["csrf_token"] ?? "") ?>"
                        >

                        <input
                            type="hidden"
                            name="redirect"
                            value="<?= htmlspecialchars((string) ($_GET["redirect"] ?? "")) ?>"
                        >

                        <input
                            type="hidden"
                            name="id_voyage"
                            value="<?= (int) ($_GET["id_voyage"] ?? 0) ?>"
                        >

                        <input
                            type="hidden"
                            name="id_destination"
                            value="<?= (int) ($_GET["id_destination"] ?? 0) ?>"
                        >

                        <input
                            type="email"
                            name="email"
                            placeholder="Adresse email"
                            required
                            value="<?= htmlspecialchars($_POST["email"] ?? "") ?>"
                        >

                        <input
                            type="password"
                            name="mdp"
                            placeholder="Mot de passe"
                            required
                        >

                        <div class="form-options d-flex justify-content-end align-items-center mb-2">
                            <a href="#" class="auth-link">Mot de passe oublié ?</a>
                        </div>

                        <button
                            type="submit"
                            name="Connexion"
                            class="btn btn-primary w-100"
                        >
                            Se connecter
                        </button>
                    </form>

                    <!-- séparation -->

                    <div class="divider my-3 text-center">OU</div>

                    <!-- boutons sociaux désactivés 

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
                    -->

                    <!-- lien inscription -->

                    <p class="switch-link text-center">
                        Pas de compte ?
                        <a
                            href="#"
                            data-bs-toggle="modal"
                            data-bs-target="#registerModal"
                            data-bs-dismiss="modal"
                        >
                            Inscrivez-vous
                        </a>
                    </p>
                </div>

                <!-- logo -->

                <div class="auth-logo text-center p-3">
                    <img
                        src="icons/LogoForm.png"
                        alt="Logo de l'agence"
                        style="max-height:300px;"
                    >
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ouverture automatique -->

<?php if (!empty($erreurLogin) || (($_GET["page"] ?? "") === "login")): ?>
    <script>
        // ouvre la modale si la connexion a echoue ou est demandee
        document.addEventListener("DOMContentLoaded", function () {
            const modal = new bootstrap.Modal(document.getElementById("loginModal"));
            modal.show();
        });
    </script>
<?php endif; ?>

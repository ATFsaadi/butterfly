<?php

// Vue profil : formulaire de compte, mot de passe et suppression client.

// securite donnees

$profil = $profil ?? [];
$erreur = $erreur ?? "";
$message = $message ?? "";
$isAdminProfil = (($profil["role"] ?? "") === "admin");

?>

<!-- profil -->

<div class="container mt-5">
    <div class="card shadow-sm border-0 rounded-3 p-4">

        <!-- entete -->

        <h2 class="mb-4"><?= $isAdminProfil ? "Profil administrateur" : "Mon profil" ?></h2>

        <!-- messages -->

        <?php if (!empty($erreur)): ?>
            <div class="alert alert-danger">
                <?= htmlspecialchars($erreur) ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($message)): ?>
            <div class="alert alert-success">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($profil)): ?>

            <!-- formulaire profil -->

            <form method="post" action="index.php?page=profile">
                <input
                    type="hidden"
                    name="csrf_token"
                    value="<?= htmlspecialchars((string) ($_SESSION["csrf_token"] ?? "")) ?>"
                >

                <!-- informations -->

                <div class="row">
                    <?php if (!$isAdminProfil): ?>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Nom</label>
                            <input
                                type="text"
                                name="nom"
                                class="form-control"
                                value="<?= htmlspecialchars($profil["nom"] ?? "") ?>"
                                required
                            >
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Prenom</label>
                            <input
                                type="text"
                                name="prenom"
                                class="form-control"
                                value="<?= htmlspecialchars($profil["prenom"] ?? "") ?>"
                                required
                            >
                        </div>
                    <?php endif; ?>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Email</label>
                        <input
                            type="email"
                            name="email"
                            class="form-control"
                            value="<?= htmlspecialchars($profil["email"] ?? "") ?>"
                            required
                        >
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Role</label>
                        <input
                            type="text"
                            class="form-control"
                            value="<?= htmlspecialchars($profil["role"] ?? "") ?>"
                            readonly
                        >
                    </div>

                    <?php if (!$isAdminProfil): ?>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Telephone</label>
                            <input
                                type="text"
                                name="telephone"
                                class="form-control"
                                value="<?= htmlspecialchars($profil["telephone"] ?? "") ?>"
                            >
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Adresse</label>
                            <input
                                type="text"
                                name="adresse"
                                class="form-control"
                                value="<?= htmlspecialchars($profil["adresse"] ?? "") ?>"
                            >
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Ville</label>
                            <input
                                type="text"
                                name="ville"
                                class="form-control"
                                value="<?= htmlspecialchars($profil["ville"] ?? "") ?>"
                            >
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Pays</label>
                            <input
                                type="text"
                                name="pays"
                                class="form-control"
                                value="<?= htmlspecialchars($profil["pays"] ?? "") ?>"
                            >
                        </div>
                    <?php endif; ?>
                </div>

                <hr class="my-4">

                <!-- mot de passe -->

                <h4 class="mb-3">Changer le mot de passe</h4>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Mot de passe actuel</label>
                        <input
                            type="password"
                            name="mot_de_passe_actuel"
                            class="form-control"
                        >
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Nouveau mot de passe</label>
                        <input
                            type="password"
                            name="nouveau_mot_de_passe"
                            class="form-control"
                        >
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Confirmer le mot de passe</label>
                        <input
                            type="password"
                            name="confirmation_mot_de_passe"
                            class="form-control"
                        >
                    </div>
                </div>

                <!-- bouton enregistrer -->

                <button type="submit" name="modifier_profil" class="btn admin-btn admin-btn-primary px-4">
                    Enregistrer
                </button>
            </form>

            <?php if (!$isAdminProfil): ?>

                <hr class="my-5">

                <!-- suppression compte -->

                <div class="border border-danger rounded-3 p-4 bg-light">
                    <h4 class="text-danger mb-3">Supprimer mon compte</h4>

                    <p class="mb-3">
                        Cette action desactivera votre compte. Vos donnees seront conservees.
                    </p>

                    <form method="post" action="index.php?page=profile">
                        <input
                            type="hidden"
                            name="csrf_token"
                            value="<?= htmlspecialchars((string) ($_SESSION["csrf_token"] ?? "")) ?>"
                        >

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Mot de passe actuel</label>
                                <input
                                    type="password"
                                    name="mot_de_passe_suppression"
                                    class="form-control"
                                    required
                                >
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Tapez SUPPRIMER pour confirmer</label>
                                <input
                                    type="text"
                                    name="confirmation_suppression"
                                    class="form-control"
                                    required
                                >
                            </div>
                        </div>

                        <button
                            type="submit"
                            name="supprimer_compte"
                            class="btn admin-btn admin-btn-outline px-4"
                            onclick="return confirm('Supprimer ce compte ?');"
                        >
                            Supprimer mon compte
                        </button>
                    </form>
                </div>

            <?php endif; ?>

        <?php else: ?>

            <!-- profil introuvable -->

            <div class="alert alert-warning mb-0">
                Profil introuvable.
            </div>

        <?php endif; ?>

    </div>
</div>


<link rel="stylesheet" href="style/sing.css">
<?php include 'includes/header.php';?>
<section class="signup-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8 col-sm-10">
                <div class="card signup-card shadow">
                    <div class="row g-0">
                        <div class="col-md-6 d-none d-md-block signup-illustration">
                            <div class="d-flex flex-column justify-content-center h-100 text-white px-4">
                                <h3 class="section-title">Créez votre compte</h3>
                                <p class="section-subtitle mb-4">Inscrivez-vous pour découvrir des voyages uniques et gérer vos réservations.</p>
                                <img src="icons/logo-acc.png" alt="Logo de l'agence" class="logo-signup mb-3">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card-body p-5">
                                <h4 class="text-center mb-4">Inscription</h4>
                                <form>
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control signup-input" id="floatingName" placeholder="Nom complet" required>
                                        <label for="floatingName">Nom complet</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="email" class="form-control signup-input" id="floatingEmail" placeholder="name@example.com" required>
                                        <label for="floatingEmail">Adresse email</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="password" class="form-control signup-input" id="floatingPassword" placeholder="Mot de passe" required>
                                        <label for="floatingPassword">Mot de passe</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="password" class="form-control signup-input" id="floatingConfirmPassword" placeholder="Confirmer le mot de passe" required>
                                        <label for="floatingConfirmPassword">Confirmer le mot de passe</label>
                                    </div>
                                    <button type="submit" class="btn signup-btn w-100 py-3">S'inscrire</button>
                                </form>
                                <div class="position-relative my-4">
                                    <hr class="border border-secondary border-1 opacity-25">
                                    <span class="position-absolute top-50 start-50 translate-middle bg-light px-3 signup-or">OU</span>
                                </div>
                                <div class="d-flex gap-2 justify-content-center">
                                    <button type="button" class="btn btn-outline-secondary signup-social-btn rounded-circle p-2">
                                        <i class="fab fa-google fa-lg"></i>
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary signup-social-btn rounded-circle p-2">
                                        <i class="fab fa-facebook-f fa-lg"></i>
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary signup-social-btn rounded-circle p-2">
                                        <i class="fab fa-apple fa-lg"></i>
                                    </button>
                                </div>
                                <div class="text-center mt-4">
                                    <p class="mb-0 small text-muted">
                                        Déjà un compte ? 
                                        <a href="signin.php" class="text-decoration-none signup-link">Connectez-vous</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include 'includes/footer.php';?>
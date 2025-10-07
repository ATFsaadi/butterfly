
<link rel="stylesheet" href="style/sing.css">
<?php include 'includes/header.php';?>
<section class="signin-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8 col-sm-10">
                <div class="card signin-card shadow">
                    <div class="row g-0">
                        <div class="col-md-6 d-none d-md-block signin-illustration">
                            <div class="d-flex flex-column justify-content-center h-100 text-white px-4">
                                <h3 class="section-title">Bienvenue</h3>
                                <p class="section-subtitle mb-4">Connectez-vous pour accéder à vos réservations et profiter de nos offres exclusives.</p>
                                <img src="icons/logo-acc.png" alt="Logo de l'agence" class="logo-signin mb-3">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card-body p-5">
                                <h4 class="text-center mb-4">Connexion</h4>
                                <form>
                                    <div class="form-floating mb-3">
                                        <input type="email" class="form-control signin-input" id="floatingEmail" placeholder="name@example.com" required>
                                        <label for="floatingEmail">Adresse email</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="password" class="form-control signin-input" id="floatingPassword" placeholder="Mot de passe" required>
                                        <label for="floatingPassword">Mot de passe</label>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="rememberMe">
                                            <label class="form-check-label small text-muted" for="rememberMe">
                                                Se souvenir de moi
                                            </label>
                                        </div>
                                        <a href="#" class="small text-decoration-none signin-link">Mot de passe oublié ?</a>
                                    </div>
                                    <button type="submit" class="btn signin-btn w-100 py-3">Se connecter</button>
                                </form>
                                <div class="position-relative my-4">
                                    <hr class="border border-secondary border-1 opacity-25">
                                    <span class="position-absolute top-50 start-50 translate-middle bg-light px-3 signin-or">OU</span>
                                </div>
                                <div class="d-flex gap-2 justify-content-center">
                                    <button type="button" class="btn btn-outline-secondary signin-social-btn rounded-circle p-2">
                                        <i class="fab fa-google fa-lg"></i>
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary signin-social-btn rounded-circle p-2">
                                        <i class="fab fa-facebook-f fa-lg"></i>
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary signin-social-btn rounded-circle p-2">
                                        <i class="fab fa-apple fa-lg"></i>
                                    </button>
                                </div>
                                <div class="text-center mt-4">
                                    <p class="mb-0 small text-muted">
                                        Vous n'avez pas de compte ? 
                                        <a href="signup.php" class="text-decoration-none signin-link">Inscrivez-vous maintenant</a>
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
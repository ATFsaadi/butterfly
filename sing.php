<?php include 'includes/header.php';?>
<!-- Container principal -->
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8 col-sm-10">
            <!-- Bloc de connexion -->
            <div class="card shadow border-0" style="border-radius: 15px;">
                <div class="row g-0">
                    <!-- Partie gauche avec illustration -->
                    <div class="col-md-6 d-none d-md-block" style="background-color:#F27438; border-top-left-radius:15px; border-bottom-left-radius:15px;">
                        <div class="d-flex flex-column justify-content-center h-100 text-white px-4">
                            <h3 class="fw-bold">Bienvenue</h3>
                            <p class="mb-4">Connectez-vous pour accéder à vos réservations et profiter de nos offres exclusives.</p>
                            <img src="icons/logo-acc.png" alt="Logo" width="100" class="mb-3">
                        </div>
                    </div>
                    
                    <!-- Partie droite avec formulaire -->
                    <div class="col-md-6">
                        <div class="card-body p-5">
                            <!-- Titre -->
                            <h4 class="text-center mb-4" style="color:#F27438;">Connexion</h4>
                            
                            <!-- Formulaire -->
                            <form>
                                <!-- Email -->
                                <div class="form-floating mb-3">
                                    <input type="email" class="form-control" id="floatingEmail" placeholder="name@example.com" required>
                                    <label for="floatingEmail">Adresse email</label>
                                </div>
                                
                                <!-- Mot de passe -->
                                <div class="form-floating mb-3">
                                    <input type="password" class="form-control" id="floatingPassword" placeholder="Mot de passe" required>
                                    <label for="floatingPassword">Mot de passe</label>
                                </div>
                                
                                <!-- Options -->
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="rememberMe">
                                        <label class="form-check-label small text-muted" for="rememberMe">
                                            Se souvenir de moi
                                        </label>
                                    </div>
                                    <a href="#" class="small text-decoration-none" style="color:#F27438;">Mot de passe oublié ?</a>
                                </div>
                                
                                <!-- Bouton Connexion -->
                                <button type="submit" class="btn w-100 py-3" 
                                        style="background-color:#F27438; color:#fff; font-weight:500; border-radius:10px;">
                                    Se connecter
                                </button>
                            </form>
                            
                            <!-- Séparateur -->
                            <div class="position-relative my-4">
                                <hr class="border border-secondary border-1 opacity-25">
                                <span class="position-absolute top-50 start-50 translate-middle bg-light px-3" 
                                      style="font-size:0.85rem; color:#6c757d;">
                                    OU
                                </span>
                            </div>
                            
                            <!-- Connexions sociales -->
                            <div class="d-flex gap-2 justify-content-center">
                                <button type="button" class="btn btn-outline-secondary rounded-circle p-2">
                                    <i class="fab fa-google fa-lg"></i>
                                </button>
                                <button type="button" class="btn btn-outline-secondary rounded-circle p-2">
                                    <i class="fab fa-facebook-f fa-lg"></i>
                                </button>
                                <button type="button" class="btn btn-outline-secondary rounded-circle p-2">
                                    <i class="fab fa-apple fa-lg"></i>
                                </button>
                            </div>
                            
                            <!-- Lien d'inscription -->
                            <div class="text-center mt-4">
                                <p class="mb-0 small text-muted">
                                    Vous n'avez pas de compte ? 
                                    <a href="signup.html" class="text-decoration-none" style="color:#F27438; font-weight:500;">
                                        Inscrivez-vous maintenant
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include 'includes/footer.php';?>
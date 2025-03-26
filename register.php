<?php include 'includes/header.php'?>

<main class="form-signup w-100 m-auto" style="max-width:500px;">
    <div class="text-center mb-4">
        <img src="icons/logo-acc.png" alt="Logo" width="72" height="72">
        <h1 class="h3 mt-3 fw-normal" style="color:#F27438;">Butterfly Voyage</h1>
        <p class="text-muted">Créez votre compte</p>
    </div>

    <form>
        <!-- Nom -->
        <div class="form-floating mb-3">
            <input type="text" class="form-control" id="floatingNom" placeholder="Nom" required>
            <label for="floatingNom">Nom</label>
        </div>
        
        <!-- Prénom -->
        <div class="form-floating mb-3">
            <input type="text" class="form-control" id="floatingPrenom" placeholder="Prénom" required>
            <label for="floatingPrenom">Prénom</label>
        </div>
        
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
        
        <!-- Confirmation du mot de passe -->
        <div class="form-floating mb-3">
            <input type="password" class="form-control" id="floatingConfirmPassword" placeholder="Confirmer le mot de passe" required>
            <label for="floatingConfirmPassword">Confirmer le mot de passe</label>
        </div>
        
        <!-- Conditions générales -->
        <div class="mb-3 form-check">
            <input class="form-check-input" type="checkbox" value="" id="acceptTerms" required>
            <label class="form-check-label" for="acceptTerms">
                J'accepte les <a href="#" class="text-decoration-none" style="color:#F27438;">conditions générales</a>
            </label>
        </div>
        
        <!-- Bouton S'inscrire -->
        <button class="w-100 btn btn-lg" 
                style="background-color:#F27438; color:#fff; font-weight:500;" 
                type="submit">
            S'inscrire
        </button>
        
        <!-- Séparateur -->
        <div class="my-4 position-relative">
            <hr class="border border-secondary border-1 opacity-25">
            <span class="position-absolute top-50 start-50 translate-middle bg-light px-3" 
                  style="font-size:0.85rem; color:#6c757d;">
                OU
            </span>
        </div>
        
        <!-- Inscription avec réseaux sociaux -->
        <div class="d-flex gap-2 justify-content-center mb-3">
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
        
        <!-- Lien vers la page de connexion -->
        <div class="text-center">
            <p class="mb-0" style="font-size:0.9rem;">
                Déjà inscrit ? 
                <a href="signin.html" class="text-decoration-none" style="color:#F27438; font-weight:500;">
                    Connectez-vous
                </a>
            </p>
        </div>
    </form>
</main>
<?php include 'includes/footer.php' ?>
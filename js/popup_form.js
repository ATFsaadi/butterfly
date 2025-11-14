document.addEventListener("DOMContentLoaded", function() {
    const loginModal = document.getElementById("loginModal");
    const registerModal = document.getElementById("registerModal");
    const openLoginBtn = document.getElementById("openLoginModal");
    const openRegisterBtn = document.getElementById("openRegisterModal");

    // Ouvrir modals
    if (openLoginBtn) {
        openLoginBtn.addEventListener("click", () => {
            loginModal.style.display = "block";
            registerModal.style.display = "none";
        });
    }
    if (openRegisterBtn) {
        openRegisterBtn.addEventListener("click", () => {
            registerModal.style.display = "block";
            loginModal.style.display = "none";
        });
    }

    // Fermer modals
    document.querySelectorAll(".close").forEach(close => {
        close.addEventListener("click", () => {
            loginModal.style.display = "none";
            registerModal.style.display = "none";
        });
    });

    // Fermer en cliquant dehors
    window.addEventListener("click", (e) => {
        if (e.target === loginModal) loginModal.style.display = "none";
        if (e.target === registerModal) registerModal.style.display = "none";
    });

    // Switch entre modals
    document.querySelectorAll("#switchToLogin").forEach(link => {
        link.addEventListener("click", (e) => {
            e.preventDefault();
            registerModal.style.display = "none";
            loginModal.style.display = "block";
        });
    });

    document.querySelectorAll("#switchToRegister").forEach(link => {
        link.addEventListener("click", (e) => {
            e.preventDefault();
            loginModal.style.display = "none";
            registerModal.style.display = "block";
        });
    });

    // Ouvrir modal auto si ?page=login ou ?page=inscription
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('page') === 'login') {
        loginModal.style.display = "block";
    }
    if (urlParams.get('page') === 'inscription') {
        registerModal.style.display = "block";
    }
});
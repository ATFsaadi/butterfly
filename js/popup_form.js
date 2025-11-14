// attendre le chargement complet de la page
document.addEventListener("DOMContentLoaded", function() {

    // éléments des modals login et inscription
    const loginModal = document.getElementById("loginModal");
    const registerModal = document.getElementById("registerModal");
    const openLoginBtn = document.getElementById("openLoginModal");
    const openRegisterBtn = document.getElementById("openRegisterModal");

    // ouvrir modal connexion
    if (openLoginBtn) {
        openLoginBtn.addEventListener("click", () => {
            loginModal.style.display = "block";
            registerModal.style.display = "none";
        });
    }

    // ouvrir modal inscription
    if (openRegisterBtn) {
        openRegisterBtn.addEventListener("click", () => {
            registerModal.style.display = "block";
            loginModal.style.display = "none";
        });
    }

    // fermer tous les modals avec la croix
    document.querySelectorAll(".close").forEach(close => {
        close.addEventListener("click", () => {
            loginModal.style.display = "none";
            registerModal.style.display = "none";
        });
    });

    // fermer en cliquant dehors
    window.addEventListener("click", (e) => {
        if (e.target === loginModal) loginModal.style.display = "none";
        if (e.target === registerModal) registerModal.style.display = "none";
    });

    // basculer vers connexion
    document.querySelectorAll("#switchToLogin").forEach(link => {
        link.addEventListener("click", (e) => {
            e.preventDefault();
            registerModal.style.display = "none";
            loginModal.style.display = "block";
        });
    });

    // basculer vers inscription
    document.querySelectorAll("#switchToRegister").forEach(link => {
        link.addEventListener("click", (e) => {
            e.preventDefault();
            loginModal.style.display = "none";
            registerModal.style.display = "block";
        });
    });

    // ouvrir automatiquement selon l'url
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('page') === 'login') {
        loginModal.style.display = "block";
    }
    if (urlParams.get('page') === 'inscription') {
        registerModal.style.display = "block";
    }

    // modal carte avec leaflet
    const mapModal = document.getElementById("mapModal");
    const openMapBtn = document.getElementById("openMapModal");
    const closeMapBtn = mapModal ? mapModal.querySelector(".close") : null;
    let mapInstance = null;

    // ouvrir la carte depuis le bouton
    if (openMapBtn && mapModal) {
        openMapBtn.addEventListener("click", (e) => {
            e.preventDefault();
            mapModal.style.display = "block";

            // initialiser la carte une seule fois
            if (!mapInstance) {
                setTimeout(() => {
                    mapInstance = L.map("map").setView([48.8566, 2.3522], 16);

                    L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
                        attribution: '&copy; OpenStreetMap contributors'
                    }).addTo(mapInstance);

                    L.marker([48.8566, 2.3522])
                        .addTo(mapInstance)
                        .bindPopup("<b>Butterfly Voyage</b><br>123 Rue du Voyage, Paris")
                        .openPopup();
                }, 100);
            }
        });
    }

    // fermer la carte avec la croix
    if (closeMapBtn) {
        closeMapBtn.addEventListener("click", () => {
            mapModal.style.display = "none";
        });
    }

    // fermer la carte en cliquant dehors
    window.addEventListener("click", (e) => {
        if (e.target === mapModal) {
            mapModal.style.display = "none";
        }
    });

    // ouvrir la carte depuis l'adresse dans le footer
    const clickableAddress = document.querySelector('.clickable-address');
    if (clickableAddress && openMapBtn) {
        clickableAddress.addEventListener('click', () => {
            openMapBtn.click();
        });

        // effet au survol
        clickableAddress.addEventListener('mouseenter', () => {
            clickableAddress.style.opacity = '0.8';
        });
        clickableAddress.addEventListener('mouseleave', () => {
            clickableAddress.style.opacity = '1';
        });
    }

});
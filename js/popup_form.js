document.addEventListener("DOMContentLoaded", function() {

    // --- MODALS LOGIN / INSCRIPTION ---
    const loginModal = document.getElementById("loginModal");
    const registerModal = document.getElementById("registerModal");
    const openLoginBtn = document.getElementById("openLoginModal");
    const openRegisterBtn = document.getElementById("openRegisterModal");

    // Ouvrir modals au clic
    if (openLoginBtn) openLoginBtn.addEventListener("click", () => {
        loginModal.style.display = "block";
        registerModal.style.display = "none";
    });

    if (openRegisterBtn) openRegisterBtn.addEventListener("click", () => {
        registerModal.style.display = "block";
        loginModal.style.display = "none";
    });

    // Fermer modals au clic sur la croix
    document.querySelectorAll(".close").forEach(close => close.addEventListener("click", () => {
        loginModal.style.display = "none";
        registerModal.style.display = "none";
    }));

    // Fermer modals au clic en dehors
    window.addEventListener("click", (e) => {
        if (e.target === loginModal) loginModal.style.display = "none";
        if (e.target === registerModal) registerModal.style.display = "none";
    });

    // Switch entre login et inscription
    document.querySelectorAll("#switchToLogin").forEach(link => link.addEventListener("click", (e) => {
        e.preventDefault();
        registerModal.style.display = "none";
        loginModal.style.display = "block";
    }));

    document.querySelectorAll("#switchToRegister").forEach(link => link.addEventListener("click", (e) => {
        e.preventDefault();
        loginModal.style.display = "none";
        registerModal.style.display = "block";
    }));

    // --- Ouverture automatique selon l'URL ou erreur ---
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('page') === 'login' || (loginModal && loginModal.dataset.error === "1")) {
        loginModal.style.display = "block";
    }
    if (urlParams.get('page') === 'inscription') {
        registerModal.style.display = "block";
    }

    // --- MODAL CARTE ---
    const mapModal = document.getElementById("mapModal");
    const openMapBtn = document.getElementById("openMapModal");
    const closeMapBtn = mapModal ? mapModal.querySelector(".close") : null;
    let mapInstance = null;

    if (openMapBtn && mapModal) {
        openMapBtn.addEventListener("click", (e) => {
            e.preventDefault();
            mapModal.style.display = "block";

            if (!mapInstance) {
                setTimeout(() => {
                    mapInstance = L.map("map").setView([48.8566, 2.3522], 16);
                    L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
                        attribution: '&copy; OpenStreetMap contributors'
                    }).addTo(mapInstance);
                    L.marker([48.8566, 2.3522]).addTo(mapInstance)
                        .bindPopup("<b>Butterfly Voyage</b><br>123 Rue du Voyage, Paris").openPopup();
                }, 100);
            }
        });
    }

    if (closeMapBtn) closeMapBtn.addEventListener("click", () => mapModal.style.display = "none");
    window.addEventListener("click", (e) => {
        if (e.target === mapModal) mapModal.style.display = "none";
    });

    // --- Adresse cliquable pour ouvrir la carte ---
    const clickableAddress = document.querySelector('.clickable-address');
    if (clickableAddress && openMapBtn) {
        clickableAddress.addEventListener('click', () => openMapBtn.click());
        clickableAddress.addEventListener('mouseenter', () => clickableAddress.style.opacity = '0.8');
        clickableAddress.addEventListener('mouseleave', () => clickableAddress.style.opacity = '1');
    }

});

document.addEventListener("DOMContentLoaded", () => {
  /*  modals login / inscription (Bootstrap) */
  const loginEl = document.getElementById("loginModal");
  const registerEl = document.getElementById("registerModal");

  const loginModal = loginEl ? new bootstrap.Modal(loginEl) : null;
  const registerModal = registerEl ? new bootstrap.Modal(registerEl) : null;

  // Boutons d’ouverture (si présents)
  const openLoginBtn = document.getElementById("openLoginModal");
  const openRegisterBtn = document.getElementById("openRegisterModal");

  if (openLoginBtn && loginModal) {
    openLoginBtn.addEventListener("click", (e) => {
      e.preventDefault();
      loginModal.show();
    });
  }

  if (openRegisterBtn && registerModal) {
    openRegisterBtn.addEventListener("click", (e) => {
      e.preventDefault();
      registerModal.show();
    });
  }

// Ouverture auto (URL OU data-open=1)
  const urlParams = new URLSearchParams(window.location.search);

  const loginShouldOpen =
    (urlParams.get("page") === "login") ||
    (loginEl && loginEl.dataset.open === "1");

  const registerShouldOpen =
    (urlParams.get("page") === "inscription") ||
    (registerEl && registerEl.dataset.open === "1");

  if (loginShouldOpen && loginModal) loginModal.show();
  if (registerShouldOpen && registerModal) registerModal.show();


  /* modal carte (custom + Leaflet) */
  const mapModal = document.getElementById("mapModal");
  const openMapBtn = document.getElementById("openMapModal");
  const closeMapBtn = mapModal ? mapModal.querySelector(".close") : null;

  let mapInstance = null;

  function showModal(el) {
    el.style.display = "block";
    document.body.style.overflow = "hidden";
  }

  function hideModal(el) {
    el.style.display = "none";
    document.body.style.overflow = "auto";

    // Optionnel : détruire la map à la fermeture si tu veux reset à chaque fois
    // si tu veux la garder, retire ce bloc
    if (el === mapModal && mapInstance) {
      mapInstance.remove();
      mapInstance = null;
    }
  }

  // Ouvrir carte
  if (openMapBtn && mapModal) {
    openMapBtn.addEventListener("click", (e) => {
      e.preventDefault();
      showModal(mapModal);

      // init map 1 seule fois
      if (!mapInstance && typeof L !== "undefined") {
        setTimeout(() => {
          mapInstance = L.map("map").setView([48.8566, 2.3522], 16);

          L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
            attribution: "&copy; OpenStreetMap contributors",
          }).addTo(mapInstance);

          L.marker([48.8566, 2.3522])
            .addTo(mapInstance)
            .bindPopup("<b>Butterfly Voyage</b><br>123 Rue du Voyage, Paris")
            .openPopup();
        }, 100);
      }
    });
  }

  // Fermer carte via croix
  if (closeMapBtn && mapModal) {
    closeMapBtn.addEventListener("click", () => hideModal(mapModal));
  }

  /* clic dehors (fermeture) */
  window.addEventListener("click", (e) => {
    if (mapModal && e.target === mapModal) hideModal(mapModal);
  });

  /* adresse cliquable (ouvre carte) */
  const clickableAddress = document.querySelector(".clickable-address");

  if (clickableAddress && openMapBtn) {
    clickableAddress.addEventListener("click", () => openMapBtn.click());
    clickableAddress.addEventListener("mouseenter", () => (clickableAddress.style.opacity = "0.8"));
    clickableAddress.addEventListener("mouseleave", () => (clickableAddress.style.opacity = "1"));
  }

  /* Escape (optionnel) */
  document.addEventListener("keydown", (e) => {
    if (e.key === "Escape" && mapModal && mapModal.style.display === "block") {
      hideModal(mapModal);
    }
  });
});

document.addEventListener("DOMContentLoaded", function () {

  /* =========================
     modals login / inscription
  ========================= */
  const loginModal = document.getElementById("loginModal");
  const registerModal = document.getElementById("registerModal");
  const openLoginBtn = document.getElementById("openLoginModal");
  const openRegisterBtn = document.getElementById("openRegisterModal");

  /* helpers modals */
  function showModal(el) {
    if (!el) return;
    el.style.display = "block";
  }

  function hideModal(el) {
    if (!el) return;
    el.style.display = "none";
  }

  function hideAuthModals() {
    hideModal(loginModal);
    hideModal(registerModal);
  }

  /* ouvrir login */
  if (openLoginBtn) {
    openLoginBtn.addEventListener("click", () => {
      showModal(loginModal);
      hideModal(registerModal);
    });
  }

  /* ouvrir inscription */
  if (openRegisterBtn) {
    openRegisterBtn.addEventListener("click", () => {
      showModal(registerModal);
      hideModal(loginModal);
    });
  }

  /* fermer auth via croix (classe .close) */
  document.querySelectorAll(".close").forEach(btn => {
    btn.addEventListener("click", () => {
      hideAuthModals();
    });
  });

  /* switch login/register */
  document.querySelectorAll("#switchToLogin").forEach(link => {
    link.addEventListener("click", (e) => {
      e.preventDefault();
      hideModal(registerModal);
      showModal(loginModal);
    });
  });

  document.querySelectorAll("#switchToRegister").forEach(link => {
    link.addEventListener("click", (e) => {
      e.preventDefault();
      hideModal(loginModal);
      showModal(registerModal);
    });
  });

  /* ouverture automatique (url ou erreur) */
  const urlParams = new URLSearchParams(window.location.search);

  if (urlParams.get("page") === "login" || (loginModal && loginModal.dataset.error === "1")) {
    showModal(loginModal);
  }

  if (urlParams.get("page") === "inscription") {
    showModal(registerModal);
  }

  /* =========================
     modal carte (leaflet)
  ========================= */
  const mapModal = document.getElementById("mapModal");
  const openMapBtn = document.getElementById("openMapModal");
  const closeMapBtn = mapModal ? mapModal.querySelector(".close") : null;

  let mapInstance = null;

  /* ouvrir carte */
  if (openMapBtn && mapModal) {
    openMapBtn.addEventListener("click", (e) => {
      e.preventDefault();
      showModal(mapModal);

      /* init map 1 seule fois */
      if (!mapInstance && typeof L !== "undefined") {
        setTimeout(() => {
          mapInstance = L.map("map").setView([48.8566, 2.3522], 16);

          L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
            attribution: "&copy; OpenStreetMap contributors"
          }).addTo(mapInstance);

          L.marker([48.8566, 2.3522])
            .addTo(mapInstance)
            .bindPopup("<b>Butterfly Voyage</b><br>123 Rue du Voyage, Paris")
            .openPopup();
        }, 100);
      }
    });
  }

  /* fermer carte via croix */
  if (closeMapBtn) {
    closeMapBtn.addEventListener("click", () => {
      hideModal(mapModal);
    });
  }

  /* =========================
     clic dehors (fermeture)
  ========================= */
  window.addEventListener("click", (e) => {

    /* fermer auth modals si clic sur fond */
    if (loginModal && e.target === loginModal) hideModal(loginModal);
    if (registerModal && e.target === registerModal) hideModal(registerModal);

    /* fermer map modal si clic sur fond */
    if (mapModal && e.target === mapModal) hideModal(mapModal);
  });

  /* =========================
     adresse cliquable (ouvre carte)
  ========================= */
  const clickableAddress = document.querySelector(".clickable-address");

  if (clickableAddress && openMapBtn) {
    clickableAddress.addEventListener("click", () => openMapBtn.click());
    clickableAddress.addEventListener("mouseenter", () => (clickableAddress.style.opacity = "0.8"));
    clickableAddress.addEventListener("mouseleave", () => (clickableAddress.style.opacity = "1"));
  }

});

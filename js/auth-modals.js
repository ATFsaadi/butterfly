// js/auth-modals.js
document.addEventListener("DOMContentLoaded", () => {

  if (typeof bootstrap === "undefined") return;

  const loginEl = document.getElementById("loginModal");
  const registerEl = document.getElementById("registerModal");

  const loginModal = loginEl ? new bootstrap.Modal(loginEl) : null;
  const registerModal = registerEl ? new bootstrap.Modal(registerEl) : null;

  /* ======================
     OUVERTURE EXTERNE
  ====================== */

  document.querySelectorAll("[data-open-login]").forEach(btn => {
    btn.addEventListener("click", e => {
      e.preventDefault();
      loginModal?.show();
    });
  });

  document.querySelectorAll("[data-open-register]").forEach(btn => {
    btn.addEventListener("click", e => {
      e.preventDefault();
      registerModal?.show();
    });
  });

  /* ======================
     SWITCH ENTRE MODALES
  ====================== */

  document.querySelectorAll("[data-switch-auth]").forEach(link => {
    link.addEventListener("click", e => {
      e.preventDefault();
      const target = link.getAttribute("data-switch-auth");

      if (target === "register") {
        loginModal?.hide();
        setTimeout(() => registerModal?.show(), 150);
      }

      if (target === "login") {
        registerModal?.hide();
        setTimeout(() => loginModal?.show(), 150);
      }
    });
  });

  /* ======================
     AUTO-OPEN (ERREURS PHP)
  ====================== */

  if (window.__OPEN_LOGIN_MODAL__ === true) {
    loginModal?.show();
  }

  if (window.__OPEN_REGISTER_MODAL__ === true) {
    registerModal?.show();
  }

});

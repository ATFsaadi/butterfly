document.addEventListener("DOMContentLoaded", () => {

  /* dropdowns desktop */
  document.querySelectorAll('.voyage-btn').forEach(btn => {
    btn.addEventListener('click', function (e) {
      e.stopPropagation();

      const content = this.parentElement?.querySelector('.voyage-dropdown-content');
      if (!content) return;

      const isOpen = content.style.display === 'block';

      /* ferme tous */
      document.querySelectorAll('.voyage-dropdown-content').forEach(c => {
        c.style.display = 'none';
      });

      /* ouvre le bon */
      if (!isOpen) content.style.display = 'block';
    });
  });

  /* fermeture dropdown si clic dehors */
  document.addEventListener('click', (e) => {
    if (!e.target.closest('.voyage-dropdown')) {
      document.querySelectorAll('.voyage-dropdown-content').forEach(c => {
        c.style.display = 'none';
      });
    }
  });

  /* selection options */
  window.selectOption = function (type, element) {
    const suggestion = document.getElementById(type + 'Suggestion');
    if (suggestion) suggestion.textContent = element.textContent;

    /* ferme le dropdown */
    const dropdown = element.closest('.voyage-dropdown-content');
    if (dropdown) dropdown.style.display = 'none';
  };

  /* dates */
  const dateDepart = document.getElementById('dateDepart');
  const dateArrivee = document.getElementById('dateArrivee');
  const dateSuggestion = document.getElementById('dateSuggestion');

  let datesModifiees = false;

  window.updateDateSuggestion = function () {
    if (!dateDepart || !dateArrivee || !dateSuggestion) return;

    const format = (d) =>
      d
        ? new Date(d).toLocaleDateString('fr-FR', { day: 'numeric', month: 'short' })
        : '';

    dateSuggestion.textContent = !datesModifiees
      ? "Aujourd'hui"
      : `${format(dateDepart.value)} - ${format(dateArrivee.value)}`;
  };

  if (dateDepart && dateArrivee && dateSuggestion) {
    const today = new Date().toISOString().split('T')[0];

    /* init dates */
    dateDepart.min = today;
    dateDepart.value = today;
    dateArrivee.value = today;

    /* change depart */
    dateDepart.addEventListener('change', () => {
      datesModifiees = true;

      dateArrivee.min = dateDepart.value;
      if (dateArrivee.value && dateArrivee.value < dateDepart.value) {
        dateArrivee.value = '';
      }

      window.updateDateSuggestion();
    });

    /* change arrivee */
    dateArrivee.addEventListener('change', () => {
      datesModifiees = true;
      window.updateDateSuggestion();
    });

    window.updateDateSuggestion();
  }

  /* personnes */
  function updatePersonnesSuggestion() {
    const a = parseInt(document.getElementById('adultesCount')?.textContent || '1', 10);
    const e = parseInt(document.getElementById('enfantsCount')?.textContent || '0', 10);
    const b = parseInt(document.getElementById('bebesCount')?.textContent || '0', 10);

    const parts = [];
    if (a) parts.push(`${a} adulte${a > 1 ? 's' : ''}`);
    if (e) parts.push(`${e} enfant${e > 1 ? 's' : ''}`);
    if (b) parts.push(`${b} bébé${b > 1 ? 's' : ''}`);

    const s = document.getElementById('personnesSuggestion');
    if (s) s.textContent = parts.length ? parts.join(', ') : '0 personne';
  }

  window.updateCount = function (type, change) {
    const el = document.getElementById(type + 'Count');
    if (!el) return;

    const current = parseInt(el.textContent || '0', 10);
    const count = Math.max(0, Math.min(10, current + change));

    el.textContent = String(count);
    updatePersonnesSuggestion();
  };

  updatePersonnesSuggestion();

  /* reset filtres */
  window.resetFilters = function () {
    const today = new Date().toISOString().split('T')[0];

    /* reset dates */
    if (dateDepart) dateDepart.value = today;
    if (dateArrivee) dateArrivee.value = today;

    datesModifiees = false;
    window.updateDateSuggestion();

    /* reset personnes */
    ['adultes', 'enfants', 'bebes'].forEach(t => {
      const el = document.getElementById(t + 'Count');
      if (el) el.textContent = (t === 'adultes') ? '1' : '0';
    });
    updatePersonnesSuggestion();

    /* reset suggestions textes */
    const dest = document.getElementById('destinationSuggestion');
    if (dest) dest.textContent = "N'importe où";

    const dep = document.getElementById('departSuggestion');
    if (dep) dep.textContent = "Tout endroit";

    /* ferme dropdowns */
    document.querySelectorAll('.voyage-dropdown-content').forEach(c => {
      c.style.display = 'none';
    });
  };

  document.querySelector('.voyage-reset-icon')?.addEventListener('click', window.resetFilters);

  /* drawer mobile */
  const drawer = document.getElementById('voyageDrawer');

  window.openDrawer = function () {
    if (!drawer) return;
    drawer.classList.add('open');
    document.body.style.overflow = 'hidden';
  };

  window.closeDrawer = function () {
    if (!drawer) return;
    drawer.classList.remove('open');
    document.body.style.overflow = '';
  };

  /* fermeture drawer en cliquant dehors */
  if (drawer) {
    drawer.addEventListener('click', (e) => {
      if (e.target === drawer) window.closeDrawer();
    });
  }

  /* dropdowns mobile */
  document.querySelectorAll('.voyage-mobile-drawer .voyage-dropdown > button').forEach(btn => {
    btn.addEventListener('click', function () {
      const content = this.parentElement?.querySelector('.voyage-dropdown-content');
      if (content) content.classList.toggle('show');
    });
  });

});

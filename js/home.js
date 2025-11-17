// js/home.js → spécifique accueil
document.addEventListener("DOMContentLoaded", function () {

    // === DROPDOWNS CUSTOM (voyage) ===
    document.querySelectorAll('.voyage-btn').forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.stopPropagation();
            const content = this.parentElement.querySelector('.voyage-dropdown-content');
            const isOpen = content.style.display === 'block';
            document.querySelectorAll('.voyage-dropdown-content').forEach(c => c.style.display = 'none');
            if (!isOpen) content.style.display = 'block';
        });
    });

    document.addEventListener('click', e => {
        if (!e.target.closest('.voyage-dropdown')) {
            document.querySelectorAll('.voyage-dropdown-content').forEach(c => c.style.display = 'none');
        }
    });

    // === SÉLECTION OPTION ===
    window.selectOption = function (type, element) {
        const suggestion = document.getElementById(type + 'Suggestion');
        if (suggestion) suggestion.textContent = element.textContent;
        element.parentElement.style.display = 'none';
    };

    /// === DATES ===
    const dateDepart = document.getElementById('dateDepart');
    const dateArrivee = document.getElementById('dateArrivee');
    const dateSuggestion = document.getElementById('dateSuggestion');

    let datesModifiees = false; // 🔹 Déclarée ici pour être accessible partout

    if (dateDepart && dateArrivee && dateSuggestion) {

        const today = new Date().toISOString().split('T')[0];
        dateDepart.min = today;
        dateDepart.value = today;
        dateArrivee.value = today;

        window.updateDateSuggestion = function () {
            const format = d => d ? new Date(d).toLocaleDateString('fr-FR', {
                day: 'numeric',
                month: 'short'
            }) : '';

            const text = !datesModifiees
                ? "Aujourd'hui"
                : `${format(dateDepart.value)} - ${format(dateArrivee.value)}`;

            dateSuggestion.textContent = text;
        };

        dateDepart.addEventListener('change', () => {
            datesModifiees = true;
            dateArrivee.min = dateDepart.value;
            if (dateArrivee.value && dateArrivee.value < dateDepart.value) dateArrivee.value = '';
            updateDateSuggestion();
        });

        dateArrivee.addEventListener('change', () => {
            datesModifiees = true;
            updateDateSuggestion();
        });

        updateDateSuggestion();
    }

    // === PERSONNES ===
    window.updateCount = function (type, change) {
        const el = document.getElementById(type + 'Count');
        if (!el) return;
        let count = Math.max(0, Math.min(10, parseInt(el.textContent) + change));
        el.textContent = count;
        updatePersonnesSuggestion();
    };

    function updatePersonnesSuggestion() {
        const a = parseInt(document.getElementById('adultesCount')?.textContent || 1);
        const e = parseInt(document.getElementById('enfantsCount')?.textContent || 0);
        const b = parseInt(document.getElementById('bebesCount')?.textContent || 0);
        const parts = [];
        if (a) parts.push(`${a} adulte${a>1?'s':''}`);
        if (e) parts.push(`${e} enfant${e>1?'s':''}`);
        if (b) parts.push(`${b} bébé${b>1?'s':''}`);
        const s = document.getElementById('personnesSuggestion');
        if (s) s.textContent = parts.length ? parts.join(', ') : '0 personne';
    }
    updatePersonnesSuggestion();

    // === RESET ===
    window.resetFilters = function () {
        const today = new Date().toISOString().split('T')[0];

        if (dateDepart) dateDepart.value = today;
        if (dateArrivee) dateArrivee.value = today;

        datesModifiees = false;          // 🔹 réinitialise le flag
        updateDateSuggestion();          // 🔹 remet "Aujourd'hui"

        ['adultes','enfants','bebes'].forEach(t => {
            const el = document.getElementById(t + 'Count');
            if (el) el.textContent = t === 'adultes' ? '1' : '0';
        });
        updatePersonnesSuggestion();

        ['destinationSuggestion','departSuggestion'].forEach(id => {
            const el = document.getElementById(id);
            if (el) el.textContent = id === 'destinationSuggestion' ? "N'importe où" : "Tout endroit";
        });

        document.querySelectorAll('.voyage-dropdown-content').forEach(c => c.style.display = 'none');
    };

    document.querySelector('.voyage-reset-icon')?.addEventListener('click', resetFilters);
});
// Ouvrir/Fermer le drawer mobile
function openDrawer() {
    document.getElementById('voyageDrawer').classList.add('open');
    document.body.style.overflow = 'hidden';
}
function closeDrawer() {
    document.getElementById('voyageDrawer').classList.remove('open');
    document.body.style.overflow = '';
}

// Fermer en cliquant dehors
document.getElementById('voyageDrawer').addEventListener('click', function(e) {
    if (e.target === this) closeDrawer();
});

// Ouvrir les dropdowns au clic sur mobile
document.querySelectorAll('.voyage-mobile-drawer .voyage-dropdown > button').forEach(btn => {
    btn.addEventListener('click', function() {
        this.parentElement.querySelector('.voyage-dropdown-content').classList.toggle('show');
    });
});

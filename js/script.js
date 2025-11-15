document.addEventListener("DOMContentLoaded", function () {

    // MENU DROPDOWN NAV
    document.querySelectorAll('.nav-item.dropdown').forEach(item => {
        const toggle = item.querySelector('.dropdown-toggle');
        if (!toggle) return;
        const dropdown = new bootstrap.Dropdown(toggle);
        item.addEventListener('mouseenter', () => dropdown.show());
        item.addEventListener('mouseleave', () => dropdown.hide());
    });

    // DATES
    const dateDepart = document.getElementById('dateDepart');
    const dateArrivee = document.getElementById('dateArrivee');
    const dateSuggestion = document.getElementById('dateSuggestion');

    if (dateDepart && dateArrivee && dateSuggestion) {
        const today = new Date().toISOString().split("T")[0];
        dateDepart.min = today;

        window.updateDateSuggestion = function() {
            const depart = dateDepart.value;
            const arrivee = dateArrivee.value;
            let text = '';
            if (depart && arrivee) text = `${new Date(depart).toLocaleDateString('fr-FR', {day:'numeric',month:'short'})} - ${new Date(arrivee).toLocaleDateString('fr-FR', {day:'numeric',month:'short'})}`;
            else if (depart) text = new Date(depart).toLocaleDateString('fr-FR', {day:'numeric',month:'short'});
            else if (arrivee) text = new Date(arrivee).toLocaleDateString('fr-FR', {day:'numeric',month:'short'});
            dateSuggestion.textContent = text;
        };

        dateDepart.addEventListener("change", () => { dateArrivee.min = dateDepart.value; if (dateArrivee.value < dateDepart.value) dateArrivee.value = ""; updateDateSuggestion(); });
        dateArrivee.addEventListener("change", updateDateSuggestion);
        updateDateSuggestion();
    }

    // COMPTEUR DE PERSONNES
    window.updateCount = function (type, change) {
        const el = document.getElementById(type + 'Count');
        if (!el) return;
        let count = Math.max(0, Math.min(10, parseInt(el.textContent) + change));
        el.textContent = count;
        updatePersonnesSuggestion();
    };

    function updatePersonnesSuggestion() {
        const adultes = parseInt(document.getElementById('adultesCount')?.textContent || 1);
        const enfants = parseInt(document.getElementById('enfantsCount')?.textContent || 0);
        const bebes = parseInt(document.getElementById('bebesCount')?.textContent || 0);
        let parts = [];
        if (adultes>0) parts.push(adultes+' adulte'+(adultes>1?'s':''));
        if (enfants>0) parts.push(enfants+' enfant'+(enfants>1?'s':''));
        if (bebes>0) parts.push(bebes+' bébé'+(bebes>1?'s':''));
        document.getElementById('personnesSuggestion').textContent = parts.join(', ') || '0 personne';
    }
    updatePersonnesSuggestion();

    // SELECT OPTION
    window.selectOption = function(type, element) {
        const suggestion = document.getElementById(type+'Suggestion');
        if (suggestion) suggestion.textContent = element.textContent;
        element.parentElement.style.display = 'none';
    };

    // RESET FILTRES
    window.resetFilters = function() {
        if(dateDepart) dateDepart.value=''; if(dateArrivee) dateArrivee.value='';
        if(dateSuggestion) dateSuggestion.textContent='';
        ['adultes','enfants','bebes'].forEach(t=>{ const el=document.getElementById(t+'Count'); if(el) el.textContent=(t==='adultes')?'1':'0'; });
        updatePersonnesSuggestion();
        ['destinationSuggestion','departSuggestion'].forEach(id=>{ const el=document.getElementById(id); if(el) el.textContent=(id==='destinationSuggestion')?"N'importe où":"Tout endroit"; });
        document.querySelectorAll('.voyage-dropdown-content').forEach(c=>c.style.display='none');
    };

    // DROPDOWNS CUSTOM
    document.querySelectorAll('.voyage-btn').forEach(btn=>{
        btn.addEventListener('click', e=>{
            e.stopPropagation();
            const content = btn.parentElement.querySelector('.voyage-dropdown-content');
            const isOpen = content.style.display==='block';
            document.querySelectorAll('.voyage-dropdown-content').forEach(c=>c.style.display='none');
            if(!isOpen) content.style.display='block';
        });
    });
    document.addEventListener('click', e=>{
        if(!e.target.closest('.voyage-dropdown')) document.querySelectorAll('.voyage-dropdown-content').forEach(c=>c.style.display='none');
    });
});

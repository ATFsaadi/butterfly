// attendre que le dom soit chargé
document.addEventListener("DOMContentLoaded", function () {

    // menu déroulant au survol
    document.querySelectorAll('.nav-item.dropdown').forEach(item => {
        const toggle = item.querySelector('.dropdown-toggle');
        if (!toggle) return;

        const dropdown = new bootstrap.Dropdown(toggle);
        item.addEventListener('mouseenter', () => dropdown.show());
        item.addEventListener('mouseleave', () => dropdown.hide());
    });

    // gestion des dates départ/arrivée
    const dateDepart = document.getElementById('dateDepart');
    const dateArrivee = document.getElementById('dateArrivee');

    if (dateDepart && dateArrivee) {
        const today = new Date().toISOString().split("T")[0];
        dateDepart.min = today;

        dateDepart.addEventListener("change", () => {
            const departValue = dateDepart.value;
            dateArrivee.min = departValue;

            if (dateArrivee.value && dateArrivee.value < departValue) {
                dateArrivee.value = "";
            }
        });
    }

});
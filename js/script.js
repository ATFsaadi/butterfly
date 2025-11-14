// Attendre que toute la page soit chargée
document.addEventListener("DOMContentLoaded", function () {

    // carte maps
    const adresseContainer = document.getElementById('adresse-container');
    const mapContainer = document.getElementById('map-container');

    if (adresseContainer && mapContainer) {
        adresseContainer.addEventListener('mouseenter', () => {
            mapContainer.style.opacity = '1';
            mapContainer.style.visibility = 'visible';
            adresseContainer.setAttribute('aria-expanded', 'true');
            mapContainer.setAttribute('aria-hidden', 'false');
        });

        adresseContainer.addEventListener('mouseleave', () => {
            mapContainer.style.opacity = '0';
            mapContainer.style.visibility = 'hidden';
            adresseContainer.setAttribute('aria-expanded', 'false');
            mapContainer.setAttribute('aria-hidden', 'true');
        });
    }
   
    // MENU DÉROULANT BOOTSTRAP AU SURVOL
        document.querySelectorAll('.nav-item.dropdown').forEach(item => {
        const toggleButton = item.querySelector('.dropdown-toggle');
        const dropdown = new bootstrap.Dropdown(toggleButton);

        item.addEventListener('mouseenter', () => dropdown.show());
        item.addEventListener('mouseleave', () => dropdown.hide());
    });

    // LOGIQUE DES DATES : DÉPART & ARRIVÉE
    const dateDepart = document.getElementById('dateDepart');
    const dateArrivee = document.getElementById('dateArrivee');

    if (dateDepart && dateArrivee) {
        // Départ : impossible de choisir une date passée
        const today = new Date().toISOString().split("T")[0];
        dateDepart.min = today;

        // Arrivée : dépend de la date de départ
        dateDepart.addEventListener("change", () => {
            dateArrivee.min = dateDepart.value;

            // Si la date d'arrivée devient invalide, on la réinitialise
            if (dateArrivee.value < dateDepart.value) {
                dateArrivee.value = "";
            }
        });
    }


   
    // (Tu peux ajouter ici)
   

});

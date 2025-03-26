//carte maps 
const adresseContainer = document.getElementById('adresse-container');
const mapContainer = document.getElementById('map-container');

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
//////////////////////////////////////////////////////////////////


// Ajoute un comportement de survol pour les menus déroulants Bootstrap
document.querySelectorAll('.nav-item.dropdown').forEach(item => {
    const toggleButton = item.querySelector('.dropdown-toggle'); // Bouton qui contrôle le dropdown
    const dropdown = new bootstrap.Dropdown(toggleButton); // Initialisation de l'API Dropdown

    // Afficher le menu au survol
    item.addEventListener('mouseenter', () => dropdown.show());

    // Masquer le menu quand la souris quitte
    item.addEventListener('mouseleave', () => dropdown.hide());
});



//bouton reset 












///slides

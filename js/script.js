// js/script.js → commun à toutes les pages
// Script commun : modales, cartes Leaflet et menus.
document.addEventListener("DOMContentLoaded", function () {

  // modale carte agence
  const modal = document.getElementById('mapModal');
  const closeBtn = document.querySelector('#mapModal .close');

  let map = null;

  // ouverture modale
  function openModal() {
    if (!modal) return;
    modal.style.display = 'block';
    document.body.style.overflow = 'hidden';

    // attente layout
    setTimeout(() => {
      if (!map) {
        initMap();
      } else {
        map.invalidateSize();
      }
    }, 300);
  }

  // fermeture modale
  function closeModal() {
    if (!modal) return;
    modal.style.display = 'none';
    document.body.style.overflow = 'auto';

    // reset map
    if (map) {
      map.remove();
      map = null;
    }
  }

  // fonction globale navbar
  window.openAgenceMap = function () {
    openModal();
  };

  // bouton fermeture
  if (closeBtn) closeBtn.addEventListener('click', closeModal);

  // fermeture clic dehors
  window.addEventListener('click', (e) => {
    if (modal && e.target === modal) closeModal();
  });

  // fermeture echap
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && modal && modal.style.display === 'block') {
      closeModal();
    }
  });

  // carte leaflet
  function initMap() {
    if (typeof L === 'undefined') return;
    if (!document.getElementById('map')) return;

    // coordonnees agence
    const lat = 48.8738;
    const lng = 2.3320;

    // init map
    map = L.map('map').setView([lat, lng], 18);

    // tuiles osm
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '&copy; OpenStreetMap contributors',
      maxZoom: 19
    }).addTo(map);

    // marker custom
    const icon = L.divIcon({
      html: `<div style="background:#F27438;color:white;width:42px;height:42px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:bold;font-size:1.4rem;box-shadow:0 4px 14px rgba(0,0,0,0.4);border:4px solid white;">A</div>`,
      iconSize: [42, 42],
      className: 'custom-marker'
    });

    // marker et popup
    L.marker([lat, lng], { icon })
      .addTo(map)
      .bindPopup(`
        <div style="text-align:center; font-family:'Poiret One',sans-serif;">
          <b style="color:#F27438;">Butterfly Voyage</b><br>
          <span style="font-size:0.95rem;">40 Bd Haussmann</span><br>
          <span style="font-size:0.95rem;">75009 Paris</span><br>
          <a href="#" id="openGoogleMaps"
             style="color:#F27438; font-weight:bold; text-decoration:underline; margin-top:8px; display:inline-block;">
            Itinéraire sur Google Maps
          </a>
        </div>
      `)
      .openPopup()
      // ajout du clic sur le lien Google Maps
      .on('popupopen', function () {

        // lien google maps
        const link = document.getElementById('openGoogleMaps');
        if (!link) return;

        // ouverture de l'itineraire selon l'appareil
        link.onclick = function (e) {
          e.preventDefault();

          const address = encodeURIComponent("40 Boulevard Haussmann, 75009 Paris");
          const isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);

          const url = `https://www.google.com/maps/search/?api=1&query=${address}`;
          if (isMobile) {
            window.location.href = url;
          } else {
            window.open(url, '_blank');
          }
        };
      });
  }

  // mini carte footer
  function initFooterMap() {
    if (typeof L === 'undefined') return;

    const footerEl = document.getElementById('footerMap');
    if (!footerEl) return;

    // coordonnees agence
    const lat = 48.8738;
    const lng = 2.3320;

    // init map
    const footerMap = L.map('footerMap', {
      zoomControl: false,
      dragging: false,
      touchZoom: false,
      doubleClickZoom: false,
      scrollWheelZoom: false,
      boxZoom: false,
      keyboard: false
    }).setView([lat, lng], 16);

    // tuiles osm
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: ''
    }).addTo(footerMap);

    // marker footer
    const icon = L.divIcon({
      html: `<div style="background:#F27438;color:white;width:28px;height:28px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:bold;font-size:0.9rem;border:3px solid white;box-shadow:0 2px 8px rgba(0,0,0,0.3);">A</div>`,
      iconSize: [28, 28],
      className: 'footer-marker'
    });

    L.marker([lat, lng], { icon }).addTo(footerMap);

    // clic footer
    footerEl.addEventListener('click', () => {
      openModal();
    });
  }

  // lancement mini map
  initFooterMap();

  // dropdown hover
  if (window.innerWidth >= 992 && typeof bootstrap !== 'undefined') {
    // activation des menus au survol sur desktop
    document.querySelectorAll('.nav-item.dropdown').forEach(item => {
      const toggle = item.querySelector('.dropdown-toggle');
      if (!toggle) return;

      const dropdown = new bootstrap.Dropdown(toggle);

      item.addEventListener('mouseenter', () => dropdown.show());
      item.addEventListener('mouseleave', () => dropdown.hide());
    });
  }

});

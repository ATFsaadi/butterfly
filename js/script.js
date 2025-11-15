// js/script.js → commun à toutes les pages
document.addEventListener("DOMContentLoaded", function () {

    // === MODALE CARTE AGENCE ===
    const modal = document.getElementById('mapModal');
    const closeBtn = document.querySelector('#mapModal .close');
    let map = null;

    // OUVRIR LA MODALE
    window.openAgenceMap = function () {
        modal.style.display = 'block';
        document.body.style.overflow = 'hidden';

        setTimeout(() => {
            if (!map) {
                initMap();
            } else {
                map.invalidateSize();
            }
        }, 300);
    };

    // FERMER LA MODALE
    function closeModal() {
        modal.style.display = 'none';
        document.body.style.overflow = 'auto';
        if (map) {
            map.remove();
            map = null;
        }
    }

    if (closeBtn) closeBtn.onclick = closeModal;
    window.onclick = (e) => { if (e.target === modal) closeModal(); };
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && modal.style.display === 'block') closeModal();
    });

    // === INITIALISER LA CARTE (dans la modale) ===
    function initMap() {
        const lat = 48.8738;
        const lng = 2.3320;

        map = L.map('map').setView([lat, lng], 18);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors',
            maxZoom: 19
        }).addTo(map);

        const icon = L.divIcon({
            html: `<div style="background:#F27438;color:white;width:42px;height:42px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:bold;font-size:1.4rem;box-shadow:0 4px 14px rgba(0,0,0,0.4);border:4px solid white;">A</div>`,
            iconSize: [42, 42],
            className: 'custom-marker'
        });

        L.marker([lat, lng], { icon }).addTo(map)
            .bindPopup(`
                <div style="text-align:center; font-family:'Poiret One',sans-serif;">
                    <b style="color:#F27438;">Butterfly Voyage</b><br>
                    <span style="font-size:0.95rem;">40 Bd Haussmann</span><br>
                    <span style="font-size:0.95rem;">75009 Paris</span><br>
                    <a href="#" id="openGoogleMaps" style="color:#F27438; font-weight:bold; text-decoration:underline; margin-top:8px; display:inline-block;">
                        Itinéraire sur Google Maps
                    </a>
                </div>
            `)
            .openPopup()
            .on('popupopen', function () {
                const link = document.getElementById('openGoogleMaps');
                if (link) {
                    link.onclick = function (e) {
                        e.preventDefault();
                        const address = encodeURIComponent("40 Boulevard Haussmann, 75009 Paris");
                        const isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);
                        if (isMobile) {
                            window.location.href = `https://www.google.com/maps/search/?api=1&query=${address}`;
                        } else {
                            window.open(`https://www.google.com/maps/search/?api=1&query=${address}`, '_blank');
                        }
                    };
                }
            });
    }

    // === MINI-CARTE DANS LE FOOTER ===
    function initFooterMap() {
        if (!document.getElementById('footerMap')) return;

        const lat = 48.8738;
        const lng = 2.3320;

        const footerMap = L.map('footerMap', {
            zoomControl: false,
            dragging: false,
            touchZoom: false,
            doubleClickZoom: false,
            scrollWheelZoom: false,
            boxZoom: false,
            keyboard: false
        }).setView([lat, lng], 16);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: ''
        }).addTo(footerMap);

        const icon = L.divIcon({
            html: `<div style="background:#F27438;color:white;width:28px;height:28px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:bold;font-size:0.9rem;border:3px solid white;box-shadow:0 2px 8px rgba(0,0,0,0.3);">A</div>`,
            iconSize: [28, 28],
            className: 'footer-marker'
        });

        L.marker([lat, lng], { icon }).addTo(footerMap);

        document.querySelector('#footerMap').onclick = function () {
            const address = encodeURIComponent("40 Boulevard Haussmann, 75009 Paris");
            const isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);
            if (isMobile) {
                window.location.href = `https://www.google.com/maps/search/?api=1&query=${address}`;
            } else {
                window.open(`https://www.google.com/maps/search/?api=1&query=${address}`, '_blank');
            }
        };
    }

    // === LANCER LA MINI-CARTE ===
    initFooterMap();

    // === MENU DROPDOWN HOVER (desktop) ===
    if (window.innerWidth >= 992) {
        document.querySelectorAll('.nav-item.dropdown').forEach(item => {
            const toggle = item.querySelector('.dropdown-toggle');
            if (toggle) {
                const dropdown = new bootstrap.Dropdown(toggle);
                item.addEventListener('mouseenter', () => dropdown.show());
                item.addEventListener('mouseleave', () => dropdown.hide());
            }
        });
    }
});
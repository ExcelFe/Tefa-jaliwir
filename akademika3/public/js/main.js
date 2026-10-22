/* ==========================================================================
   MAIN.JS - shared logic for every page (loaded in <head> with "defer")
   Page-only logic lives in its own file:
   program-sekolah.js | profil-manajemen.js | login.js | dashboard.js
   ========================================================================== */

/* --------------------------------------------------------------------------
   NAV MENU  (hamburger on tablet/phone; CSS shows the button at <= 1024px)
   Markup: button.nav-toggle[aria-controls="nav-panel"] + #nav-panel
   Closes on link click, Escape, and when the screen grows to desktop.
   -------------------------------------------------------------------------- */
function initNavToggle() {
    const toggle = document.querySelector('.nav-toggle');
    const panel = document.getElementById('nav-panel');
    if (!toggle || !panel) return;

    // Sync button state, label and panel
    const setOpen = (isOpen) => {
        toggle.setAttribute('aria-expanded', String(isOpen));
        toggle.setAttribute('aria-label', isOpen ? 'Tutup menu' : 'Buka menu');
        panel.classList.toggle('is-open', isOpen);
    };
    const isOpen = () => toggle.getAttribute('aria-expanded') === 'true';

    toggle.addEventListener('click', () => setOpen(!isOpen()));
    panel.addEventListener('click', (event) => {
        if (event.target.closest('a')) setOpen(false);
    });
    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && isOpen()) {
            setOpen(false);
            toggle.focus();
        }
    });
    window.matchMedia('(min-width: 1025px)').addEventListener('change', (event) => {
        if (event.matches) setOpen(false);
    });
    // Back/forward cache: a restored page must start with the menu closed
    window.addEventListener('pageshow', (event) => {
        if (event.persisted) setOpen(false);
    });
}


/* --------------------------------------------------------------------------
   IMAGE SLOTS  (.img-slot)
   If the image file is missing, remove the <img> so the placeholder label shows.
   -------------------------------------------------------------------------- */
function initImageSlots() {
    document.querySelectorAll('.img-slot img').forEach((img) => {
        img.addEventListener('error', () => img.remove());
        // Image may have failed before this script ran
        if (img.complete && img.naturalWidth === 0) img.remove();
    });
}


initNavToggle();
initImageSlots();

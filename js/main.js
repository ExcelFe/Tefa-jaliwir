/* ==========================================================================
   MAIN.JS - shared logic for every page (loaded in <head> with "defer")
   Page-only logic lives in its own file:
   program-sekolah.js | profil-manajemen.js | login.js | dashboard.js |
   guru-absen-siswa.js | admin-piket.js | cool-cards.js (index 3D cards)
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


/* ==========================================================================
   HOME (index.html)
   Every function returns early on pages without the home markup.
   ========================================================================== */

/* --------------------------------------------------------------------------
   DROPDOWN  (hero "Halaman")
   Markup: [data-dropdown] > button[data-dropdown-toggle] + ul (the menu)
   Closes on outside click, Escape and when focus leaves.
   -------------------------------------------------------------------------- */
function initDropdowns() {
    document.querySelectorAll('[data-dropdown]').forEach((dropdown) => {
        const toggle = dropdown.querySelector('[data-dropdown-toggle]');
        const menu = dropdown.querySelector('ul');
        if (!toggle || !menu) return;

        const setOpen = (isOpen) => {
            toggle.setAttribute('aria-expanded', String(isOpen));
            menu.classList.toggle('is-open', isOpen);
        };
        const isOpen = () => toggle.getAttribute('aria-expanded') === 'true';

        toggle.addEventListener('click', () => setOpen(!isOpen()));
        document.addEventListener('click', (event) => {
            if (!dropdown.contains(event.target)) setOpen(false);
        });
        dropdown.addEventListener('keydown', (event) => {
            if (event.key === 'Escape' && isOpen()) {
                setOpen(false);
                toggle.focus();
            }
        });
        dropdown.addEventListener('focusout', (event) => {
            if (!dropdown.contains(event.relatedTarget)) setOpen(false);
        });
        // Back/forward cache: restored page starts closed
        window.addEventListener('pageshow', (event) => {
            if (event.persisted) setOpen(false);
        });
    });
}


/* --------------------------------------------------------------------------
   FLOATING NAVBAR  (index only)
   Hidden over the hero + transition. Shown once the sentinel at the top of
   the main content has reached the top of the viewport.
   -------------------------------------------------------------------------- */
function initHomeNavbar() {
    const navbar = document.querySelector('.navbar--float');
    const sentinel = document.querySelector('[data-navbar-sentinel]');
    if (!navbar || !sentinel) return;
    if (!('IntersectionObserver' in window)) {
        navbar.classList.add('is-visible');
        return;
    }

    const toggle = navbar.querySelector('.nav-toggle');
    new IntersectionObserver(([entry]) => {
        const show = entry.boundingClientRect.top <= 0;
        navbar.classList.toggle('is-visible', show);
        // Hidden navbar must not keep the mobile menu open
        if (!show && toggle && toggle.getAttribute('aria-expanded') === 'true') toggle.click();
    }).observe(sentinel);
}


/* --------------------------------------------------------------------------
   FASILITAS CAROUSEL  (index only)
   Copies the slide set until it is wider than the screen, then CSS moves the
   track one set to the left in a loop (animation.css).
   Without JS the slides stay a plain scroll row.
   -------------------------------------------------------------------------- */
function initFasilitasCarousel() {
    const marquee = document.querySelector('[data-marquee]');
    if (!marquee) return;
    const track = marquee.querySelector('.fasilitas-track');
    const original = track.querySelector('.fasilitas-set');
    const SPEED = 50;                               // px per second

    const build = () => {
        track.querySelectorAll('[data-clone]').forEach((copy) => copy.remove());
        const setWidth = original.getBoundingClientRect().width;
        if (!setWidth) return;

        const copies = Math.ceil(marquee.clientWidth / setWidth) + 1;
        for (let i = 0; i < copies; i += 1) {
            const copy = original.cloneNode(true);
            copy.dataset.clone = '';
            copy.setAttribute('aria-hidden', 'true');           // screen readers read one set
            copy.querySelectorAll('button').forEach((button) => { button.tabIndex = -1; });
            track.appendChild(copy);
        }
        track.style.setProperty('--marquee-shift', `-${setWidth}px`);
        track.style.setProperty('--marquee-duration', `${setWidth / SPEED}s`);
        marquee.classList.add('is-ready');
        initImageSlots();                                       // missing photos in the copies
    };

    build();
    let timer;
    window.addEventListener('resize', () => {
        window.clearTimeout(timer);
        timer = window.setTimeout(build, 200);
    });
}


/* --------------------------------------------------------------------------
   FASILITAS POP-UP  (index only)
   Click a slide -> full image in <dialog>. Closes on X, Escape (built in)
   and a click outside the photo.
   -------------------------------------------------------------------------- */
function initLightbox() {
    const dialog = document.getElementById('fasilitas-lightbox');
    const marquee = document.querySelector('[data-marquee]');
    if (!dialog || !marquee || typeof dialog.showModal !== 'function') return;

    const image = dialog.querySelector('img');
    const caption = dialog.querySelector('figcaption');

    marquee.addEventListener('click', (event) => {
        const slide = event.target.closest('[data-lightbox-open]');
        const photo = slide && slide.querySelector('img');
        if (!photo) return;
        image.src = photo.currentSrc || photo.src;
        image.alt = photo.alt;
        caption.textContent = photo.alt;
        dialog.showModal();
        document.body.classList.add('has-lightbox');
    });
    dialog.addEventListener('click', (event) => {
        // Target is the dialog itself when the click lands outside the photo
        if (event.target === dialog || event.target.closest('[data-lightbox-close]')) dialog.close();
    });
    dialog.addEventListener('close', () => document.body.classList.remove('has-lightbox'));
}


/* ==========================================================================
   DASHBOARDS: TEACHER / STUDENT / GURU PIKET / ADMIN  (pages/after/ROLE/)
   Every function returns early on pages without the dashboard markup.
   ========================================================================== */

/* --------------------------------------------------------------------------
   THEME  (dark / light)
   Saved in localStorage, applied as <html data-theme="dark|light">.
   Switch: button[data-theme-toggle][role="switch"]
   -------------------------------------------------------------------------- */
function initTheme() {
    if (!document.querySelector('.dash')) return;
    const KEY = 'tefa-theme';
    const root = document.documentElement;

    // localStorage can be blocked (private mode): fall back to light
    let saved = null;
    try { saved = localStorage.getItem(KEY); } catch (error) { /* ignore */ }
    root.dataset.theme = saved === 'dark' ? 'dark' : 'light';

    const toggle = document.querySelector('[data-theme-toggle]');
    if (!toggle) return;
    const sync = () => toggle.setAttribute('aria-checked', String(root.dataset.theme === 'dark'));
    sync();

    toggle.addEventListener('click', () => {
        root.dataset.theme = root.dataset.theme === 'dark' ? 'light' : 'dark';
        try { localStorage.setItem(KEY, root.dataset.theme); } catch (error) { /* ignore */ }
        sync();
    });
}


/* --------------------------------------------------------------------------
   SIDEBAR  (opens to the right, closes to the left)
   State lives in .dash[data-sidebar="open|closed"]; CSS does the rest.
   PC/laptop: open on load. Tablet/phone (<= 1024px): closed, the maximize icon opens it.
   -------------------------------------------------------------------------- */
function initSidebar() {
    const dash = document.querySelector('.dash');
    const sidebar = document.getElementById('sidebar');
    if (!dash || !sidebar) return;

    const desktop = window.matchMedia('(min-width: 1025px)');
    const openButtons = document.querySelectorAll('[data-sidebar-open]');
    const closeButton = sidebar.querySelector('[data-sidebar-close]');

    const setOpen = (isOpen) => {
        dash.dataset.sidebar = isOpen ? 'open' : 'closed';
        openButtons.forEach((button) => button.setAttribute('aria-expanded', String(isOpen)));
    };
    setOpen(desktop.matches);

    document.addEventListener('click', (event) => {
        // Keyboard focus follows the toggle (the clicked button hides itself)
        if (event.target.closest('[data-sidebar-open]')) {
            setOpen(true);
            closeButton.focus();
        } else if (event.target.closest('[data-sidebar-close]')) {
            setOpen(false);
            openButtons[0].focus();
        }
    });
    // Drawer closes with Escape
    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && !desktop.matches && dash.dataset.sidebar === 'open') {
            setOpen(false);
            openButtons[0].focus();
        }
    });
    // Crossing the tablet/desktop breakpoint resets to that layout's default
    desktop.addEventListener('change', (event) => setOpen(event.matches));
}


/* --------------------------------------------------------------------------
   SETTINGS MENU  (opens above the account container)
   Closes on: setting button again, click outside, Escape.
   Learn More: hover on desktop (CSS). Touch/phone: click toggles .is-open.
   -------------------------------------------------------------------------- */
function initSettingsMenu() {
    const toggle = document.querySelector('[data-settings-toggle]');
    const menu = document.getElementById('settings-menu');
    if (!toggle || !menu) return;

    const learn = menu.querySelector('.dash-learn');
    const clickMode = window.matchMedia('(hover: none), (max-width: 600px)');

    const setLearn = (isOpen) => learn.classList.toggle('is-open', isOpen);
    const setOpen = (isOpen) => {
        menu.classList.toggle('is-open', isOpen);
        toggle.setAttribute('aria-expanded', String(isOpen));
        if (!isOpen) setLearn(false);
    };

    toggle.addEventListener('click', () => setOpen(!menu.classList.contains('is-open')));
    learn.querySelector('button').addEventListener('click', () => {
        if (clickMode.matches) setLearn(!learn.classList.contains('is-open'));
    });
    document.addEventListener('click', (event) => {
        // Clicks inside the menu or on its button are handled elsewhere
        if (!event.target.closest('.dash-learn')) setLearn(false);
        if (!event.target.closest('#settings-menu, [data-settings-toggle]')) setOpen(false);
    });
    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && menu.classList.contains('is-open')) {
            setOpen(false);
            toggle.focus();
        }
    });
}


/* --------------------------------------------------------------------------
   POP-UPS  (.dash-modal)
   Open: [data-modal-open="<id>"]. Close: [data-modal-close], click on the
   dimmed area, Escape. Focus returns to the button that opened it.
   -------------------------------------------------------------------------- */
function initModals() {
    const modals = document.querySelectorAll('.dash-modal');
    if (!modals.length) return;
    let lastTrigger = null;

    const open = (modal, trigger) => {
        lastTrigger = trigger;
        modal.classList.add('is-open');
        document.body.classList.add('has-modal');
        modal.querySelector('.dash-modal__box').focus();
    };
    const close = (modal) => {
        modal.classList.remove('is-open');
        document.body.classList.remove('has-modal');
        if (lastTrigger) lastTrigger.focus();
    };

    document.addEventListener('click', (event) => {
        const trigger = event.target.closest('[data-modal-open]');
        if (trigger) {
            open(document.getElementById(trigger.dataset.modalOpen), trigger);
        } else if (event.target.closest('[data-modal-close]')) {
            close(event.target.closest('.dash-modal'));
        } else if (event.target.classList.contains('dash-modal')) {
            close(event.target);                            // click on the dimmed area
        }
    });
    document.addEventListener('keydown', (event) => {
        if (event.key !== 'Escape') return;
        modals.forEach((modal) => { if (modal.classList.contains('is-open')) close(modal); });
    });
    // No backend yet: keep the page and just close the pop-up.
    // Remove this when the forms post to the backend.
    modals.forEach((modal) => {
        modal.querySelector('form').addEventListener('submit', (event) => {
            event.preventDefault();
            close(modal);
        });
    });
}


initNavToggle();
initDropdowns();
initHomeNavbar();
initFasilitasCarousel();
initLightbox();
initImageSlots();
initTheme();
initSidebar();
initSettingsMenu();
initModals();

/* Randomized vertical-strip transitions for public/pre-login pages only. */
(() => {
    'use strict';

    const TRANSITION_KEY = 'smkti-public-page-transition';
    const DIRECTION_KEY = 'smkti-public-page-transition-direction';
    const ORDER_KEY = 'smkti-public-page-transition-order';
    const PANEL_COUNT = 5;
    const STAGGER_MS = 112;
    const DURATION = window.matchMedia('(prefers-reduced-motion: reduce)').matches
        ? 40
        : 620 + (PANEL_COUNT - 1) * STAGGER_MS + 90;

    const PUBLIC_PATHS = [
        '/index.html',
        '/pages/before/profil-manajemen.html',
        '/pages/before/program-sekolah.html',
        '/pages/login.html'
    ];

    const overlay = document.querySelector('[data-page-transition]');
    if (!overlay) return;

    const panels = Array.from(overlay.querySelectorAll('.page-transition__panel'));
    if (panels.length !== PANEL_COUNT) return;

    const isPublicPath = (url) => PUBLIC_PATHS.some(path => url.pathname.endsWith(path));
    const isSameDocumentHash = (url) =>
        url.pathname === location.pathname && url.search === location.search && !!url.hash;

    // Profil Manajemen reveals from top to bottom; the other public pages use bottom to top.
    const directionForPath = (pathname) =>
        pathname.endsWith('/pages/before/profil-manajemen.html') ? 'down' : 'up';

    const randomOrder = () => {
        const order = Array.from({ length: PANEL_COUNT }, (_, index) => index);
        for (let i = order.length - 1; i > 0; i -= 1) {
            const j = Math.floor(Math.random() * (i + 1));
            [order[i], order[j]] = [order[j], order[i]];
        }
        return order;
    };

    const applyOrder = (order) => {
        const safeOrder = Array.isArray(order) && order.length === PANEL_COUNT &&
            new Set(order).size === PANEL_COUNT && order.every(value => Number.isInteger(value) && value >= 0 && value < PANEL_COUNT)
            ? order
            : randomOrder();
        safeOrder.forEach((panelIndex, sequenceIndex) => {
            panels[panelIndex].style.setProperty('--panel-delay', `${sequenceIndex * STAGGER_MS}ms`);
        });
    };

    // Restore the same direction and random order used to cover the previous page.
    let cameFromTransition = false;
    let incomingDirection = 'up';
    let incomingOrder = null;
    try {
        cameFromTransition = sessionStorage.getItem(TRANSITION_KEY) === '1';
        incomingDirection = sessionStorage.getItem(DIRECTION_KEY) || 'up';
        incomingOrder = JSON.parse(sessionStorage.getItem(ORDER_KEY) || 'null');
        if (cameFromTransition) {
            sessionStorage.removeItem(TRANSITION_KEY);
            sessionStorage.removeItem(DIRECTION_KEY);
            sessionStorage.removeItem(ORDER_KEY);
        }
    } catch (_) {}

    applyOrder(incomingOrder);
    overlay.dataset.direction = incomingDirection === 'down' ? 'down' : 'up';

    if (cameFromTransition) {
        overlay.classList.add('is-entering');
        requestAnimationFrame(() => {
            requestAnimationFrame(() => {
                window.setTimeout(() => {
                    overlay.classList.remove('is-entering');
                    overlay.style.visibility = 'hidden';
                }, DURATION + 40);
            });
        });
    }

    let navigating = false;
    document.addEventListener('click', (event) => {
        if (navigating || event.defaultPrevented || event.button !== 0 ||
            event.metaKey || event.ctrlKey || event.shiftKey || event.altKey) return;

        const link = event.target.closest('a[href]');
        if (!link || link.hasAttribute('download') || (link.target && link.target !== '_self') ||
            link.hasAttribute('data-no-transition')) return;

        let destination;
        try { destination = new URL(link.href, location.href); } catch (_) { return; }
        if (destination.origin !== location.origin || !isPublicPath(destination) ||
            isSameDocumentHash(destination) || destination.href === location.href) return;

        event.preventDefault();
        navigating = true;

        const direction = directionForPath(destination.pathname);
        const order = randomOrder();
        overlay.dataset.direction = direction;
        applyOrder(order);
        overlay.style.visibility = 'visible';
        overlay.classList.remove('is-entering');
        overlay.classList.add('is-leaving');

        try {
            sessionStorage.setItem(TRANSITION_KEY, '1');
            sessionStorage.setItem(DIRECTION_KEY, direction);
            sessionStorage.setItem(ORDER_KEY, JSON.stringify(order));
        } catch (_) {}

        window.setTimeout(() => window.location.assign(destination.href), DURATION);
    });

    // Avoid a stuck curtain when a browser restores a page from its back/forward cache.
    window.addEventListener('pageshow', (event) => {
        if (event.persisted) {
            navigating = false;
            overlay.classList.remove('is-leaving', 'is-entering');
            overlay.style.visibility = 'hidden';
        }
    });
    window.addEventListener('pagehide', () => { navigating = true; });
})();

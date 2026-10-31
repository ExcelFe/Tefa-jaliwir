/* ==========================================================================
   ANIMATION.JS - animations that need JavaScript
   CSS-only animations live in css/animation.css
   ========================================================================== */

/* Loaded on every page. Each function returns early on a page without the
   markup it looks for. */

/* --------------------------------------------------------------------------
   SCROLL-SEQUENCE  (index.html, Profil Manajemen, Program Sekolah)
   Each [data-seq] item slides up (translate Y) as it scrolls up the screen
   (cards flip in, see animation.css). Plays ONCE: when an item has fully
   entered it stays in place, scrolling up/down again does not repeat it (a page
   refresh resets it; nothing is stored). Writes --seq (0 to 1) and --seq-dist;
   animation.css uses them.
   Optional per item: data-seq-start (viewport fraction where it starts, 0.9)
                      data-seq-range (viewport fraction it takes, 0.3)
                      data-seq-from="left|right" (slide sideways, translate X, instead of up)
   -------------------------------------------------------------------------- */
function initScrollSequence() {
    const items = Array.from(document.querySelectorAll('[data-seq]'));
    const pending = new Set(items);                 // items that have not fully entered yet
    // Reduced motion: leave everything in place (CSS fallbacks)
    if (!items.length || window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

    const DIST = 96;                                // px an item starts below its place
    const DIST_X = 120;                             // px a sideways item starts away from its place
    const progress = new Map(items.map((item) => [item, 1]));
    let queued = false;

    items.forEach((item) => {
        const side = item.dataset.seqFrom;
        item.style.setProperty('--seq-dist', `${side ? DIST_X : DIST}px`);
        if (side) item.style.setProperty('--seq-dir', side === 'left' ? '-1' : '1');
    });

    const update = () => {
        queued = false;
        const vh = window.innerHeight;
        pending.forEach((item) => {
            const start = vh * (parseFloat(item.dataset.seqStart) || 0.9);
            const range = vh * (parseFloat(item.dataset.seqRange) || 0.3);
            // Rect includes the current translate Y: subtract it to get the real position
            // (sideways items have none)
            const offsetY = item.dataset.seqFrom ? 0 : (1 - progress.get(item)) * DIST;
            const top = item.getBoundingClientRect().top - offsetY;
            const value = Math.min(1, Math.max(0, (start - top) / range));
            if (value !== progress.get(item)) {
                progress.set(item, value);
                item.style.setProperty('--seq', value.toFixed(3));
            }
            if (value === 1) pending.delete(item);  // entered: never animates again
        });
        if (!pending.size) {                        // all played: stop listening
            window.removeEventListener('scroll', queue);
            window.removeEventListener('resize', queue);
        }
    };
    // One update per frame, however many scroll events fire
    const queue = () => {
        if (queued) return;
        queued = true;
        window.requestAnimationFrame(update);
    };

    window.addEventListener('scroll', queue, { passive: true });
    window.addEventListener('resize', queue);
    // First paint: items already on screen must not flash hidden
    items.forEach((item) => item.style.setProperty('--seq', '1'));
    queue();
}

/* --------------------------------------------------------------------------
   HERO ZOOM  (profil-manajemen.html; Beranda + Program Sekolah use HERO PIN, see below)
   The hero is a tall track with a pinned screen (css/webpage.css .pm-hero). While
   it scrolls, the photo zooms a tiny bit (--hero-p, 0 to 1). The H3 + buttons
   fade in once the zoom is under way (--hero-r, 0 to 1). Then the page scrolls on.
   data-hero-state = "default" | "zoomed"; CSS hides the buttons in "default".
   Styles: animation.css. Reduced motion: CSS shows the zoomed state, no pin.
   -------------------------------------------------------------------------- */
function initHeroZoom() {
    const hero = document.querySelector('[data-hero-zoom]');
    if (!hero || window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

    const REVEAL_START = 0.3;                       // zoom progress where the reveal starts
    const REVEAL_RANGE = 0.45;                      // zoom progress the reveal takes
    const clamp = (value) => Math.min(1, Math.max(0, value));
    let queued = false;

    const update = () => {
        queued = false;
        // Scroll distance while the hero is pinned = track height - one screen
        const run = hero.offsetHeight - window.innerHeight;
        const p = run > 0 ? clamp(-hero.getBoundingClientRect().top / run) : 1;
        const r = clamp((p - REVEAL_START) / REVEAL_RANGE);
        hero.style.setProperty('--hero-p', p.toFixed(3));
        hero.style.setProperty('--hero-r', r.toFixed(3));
        hero.dataset.heroState = r > 0 ? 'zoomed' : 'default';
    };
    const queue = () => {
        if (queued) return;
        queued = true;
        window.requestAnimationFrame(update);
    };

    window.addEventListener('scroll', queue, { passive: true });
    window.addEventListener('resize', queue);
    update();                                       // reload mid-page keeps the right state
}


/* --------------------------------------------------------------------------
   HERO PIN  (Beranda + Program Sekolah; Profil Manajemen has its own, above)
   Scrolling through [data-hero-pin] pins the hero (CSS: position: sticky)
   and writes --hero-progress (0 to 1) on .hero-sticky: the photo zooms in a
   touch and the sub-text/CTA fade in (animation.css). Releases into normal
   scroll once progress reaches 1. Reduced motion / no sequencing possible:
   skip the pin, show the reveal content right away.
   -------------------------------------------------------------------------- */
function initHeroPin() {
    const pin = document.querySelector('[data-hero-pin]');
    const sticky = pin && pin.querySelector('.hero-sticky');
    if (!pin || !sticky) return;

    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        pin.classList.add('is-static', 'is-active');
        sticky.style.setProperty('--hero-progress', '1');
        return;
    }

    let queued = false;
    const update = () => {
        queued = false;
        const extra = pin.offsetHeight - window.innerHeight;
        const progress = extra > 0 ? Math.min(1, Math.max(0, -pin.getBoundingClientRect().top / extra)) : 1;
        sticky.style.setProperty('--hero-progress', progress.toFixed(3));
        pin.classList.toggle('is-active', progress > 0.02);
    };
    const queue = () => {
        if (queued) return;
        queued = true;
        window.requestAnimationFrame(update);
    };

    window.addEventListener('scroll', queue, { passive: true });
    window.addEventListener('resize', queue);
    queue();
}


/* --------------------------------------------------------------------------
   REVEAL GRIDS  (Program Sekolah: Program Keahlian / Intra- / Ekstra-kulikuler)
   [data-reveal] cards appear compact, then expand to the full view (headline
   shown) once scrolled further. Plays once: a grid that went full stays full
   (also when it was scrolled past without being seen); a refresh resets it.
   A shrunk root (rootMargin), not intersectionRatio, decides this: expanding
   changes the grid's own height, and a ratio would fight that change.
   -------------------------------------------------------------------------- */
function initRevealGrids() {
    const grids = document.querySelectorAll('[data-reveal]');
    if (!grids.length) return;
    if (!('IntersectionObserver' in window)) {
        grids.forEach((grid) => grid.classList.add('is-full'));
        return;
    }

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            const passed = entry.boundingClientRect.bottom <= 0;   // already above the screen
            if (!entry.isIntersecting && !passed) return;
            entry.target.classList.add('is-full');
            observer.unobserve(entry.target);
        });
    }, { rootMargin: '0px 0px -40% 0px' });
    grids.forEach((grid) => observer.observe(grid));
}


/* --------------------------------------------------------------------------
   KO-KULIKULER CONTENT  (Program Sekolah)
   The row list ([data-koku-list]) fades in only once the panel around it is
   fully inside the viewport (the panel itself enters from the right via
   [data-seq-from="right"], animation.css). Plays once, like the other entries.
   -------------------------------------------------------------------------- */
function initKokuReveal() {
    const list = document.querySelector('[data-koku-list]');
    if (!list) return;
    if (!('IntersectionObserver' in window)) {
        list.classList.add('is-shown');
        return;
    }

    const observer = new IntersectionObserver(([entry]) => {
        const passed = entry.boundingClientRect.bottom <= 0;       // already above the screen
        if (entry.intersectionRatio < 0.98 && !passed) return;
        list.classList.add('is-shown');
        observer.disconnect();
    }, { threshold: [0, 0.98, 1] });
    observer.observe(list);
}


initScrollSequence();
initHeroZoom();
initHeroPin();
initRevealGrids();
initKokuReveal();

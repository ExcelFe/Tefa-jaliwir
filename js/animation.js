/* ==========================================================================
   ANIMATION.JS - animations that need JavaScript
   CSS-only animations live in css/animation.css
   ========================================================================== */

/* Loaded on index.html and Program Sekolah. Every function below returns
   early on a page without the markup it looks for. */

/* --------------------------------------------------------------------------
   SCROLL-SEQUENCE  (index.html, Program Sekolah)
   Each [data-seq] item slides up (translate Y) as it scrolls up the screen
   (cards flip in, see animation.css); scrolling back reverses it. Writes --seq (0 to 1) and
   --seq-dist; animation.css uses them. Add .seq-x to slide in from the right
   (translate X) instead.
   Optional per item: data-seq-start (viewport fraction where it starts, 0.9)
                      data-seq-range (viewport fraction it takes, 0.3)
   -------------------------------------------------------------------------- */
function initScrollSequence() {
    const items = Array.from(document.querySelectorAll('[data-seq]'));
    // Reduced motion: leave everything in place (CSS fallbacks)
    if (!items.length || window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

    const DIST = 96;                                // px an item starts below its place
    const progress = new Map(items.map((item) => [item, 1]));
    let queued = false;

    items.forEach((item) => item.style.setProperty('--seq-dist', `${DIST}px`));

    const update = () => {
        queued = false;
        const vh = window.innerHeight;
        items.forEach((item) => {
            const start = vh * (parseFloat(item.dataset.seqStart) || 0.9);
            const range = vh * (parseFloat(item.dataset.seqRange) || 0.3);
            // Rect includes the current translate: subtract it to get the real position
            const top = item.getBoundingClientRect().top - (1 - progress.get(item)) * DIST;
            const value = Math.min(1, Math.max(0, (start - top) / range));
            if (value === progress.get(item)) return;
            progress.set(item, value);
            item.style.setProperty('--seq', value.toFixed(3));
        });
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
   HERO ZOOM  (Program Sekolah)
   Scrolling through [data-hero-zoom] pins the hero (CSS: position: sticky)
   and writes --hero-progress (0 to 1) on .hero-sticky: the photo zooms in a
   touch and the sub-text/CTA fade in (animation.css). Releases into normal
   scroll once progress reaches 1. Reduced motion / no sequencing possible:
   skip the pin, show the reveal content right away.
   -------------------------------------------------------------------------- */
function initHeroZoom() {
    const pin = document.querySelector('[data-hero-zoom]');
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
   shown) once scrolled further. Reversible (scrolling back re-compacts it).
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
        entries.forEach((entry) => entry.target.classList.toggle('is-full', entry.isIntersecting));
    }, { rootMargin: '0px 0px -40% 0px' });
    grids.forEach((grid) => observer.observe(grid));
}


/* --------------------------------------------------------------------------
   KO-KULIKULER CONTENT  (Program Sekolah)
   The row list ([data-koku-list]) fades in only once the panel around it is
   fully inside the viewport (the panel itself enters from the right via
   [data-seq].seq-x, animation.css).
   -------------------------------------------------------------------------- */
function initKokuReveal() {
    const list = document.querySelector('[data-koku-list]');
    if (!list) return;
    if (!('IntersectionObserver' in window)) {
        list.classList.add('is-shown');
        return;
    }

    new IntersectionObserver(([entry]) => {
        list.classList.toggle('is-shown', entry.intersectionRatio >= 0.98);
    }, { threshold: [0, 0.98, 1] }).observe(list);
}


initScrollSequence();
initHeroZoom();
initRevealGrids();
initKokuReveal();

/* ==========================================================================
   ANIMATION.JS - animations that need JavaScript
   CSS-only animations live in css/animation.css
   ========================================================================== */

/* --------------------------------------------------------------------------
   SCROLL-SEQUENCE  (index.html)
   Each [data-seq] item slides up (translate Y) as it scrolls up the screen
   (cards flip in, see animation.css); scrolling back reverses it. Writes --seq (0 to 1) and
   --seq-dist; animation.css uses them.
   Optional per item: data-seq-start (viewport fraction where it starts, 0.9)
                      data-seq-range (viewport fraction it takes, 0.3)
                      data-seq-from="left|right" (slide sideways, translate X, instead of up)
   -------------------------------------------------------------------------- */
function initScrollSequence() {
    const items = Array.from(document.querySelectorAll('[data-seq]'));
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
        items.forEach((item) => {
            const start = vh * (parseFloat(item.dataset.seqStart) || 0.9);
            const range = vh * (parseFloat(item.dataset.seqRange) || 0.3);
            // Rect includes the current translate Y: subtract it to get the real position
            // (sideways items have none)
            const offsetY = item.dataset.seqFrom ? 0 : (1 - progress.get(item)) * DIST;
            const top = item.getBoundingClientRect().top - offsetY;
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

initScrollSequence();


/* --------------------------------------------------------------------------
   HERO ZOOM  (profil-manajemen.html)
   The hero is a tall track with a pinned screen (css/main.css .pm-hero). While
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

initHeroZoom();

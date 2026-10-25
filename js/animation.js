/* ==========================================================================
   ANIMATION.JS - animations that need JavaScript
   CSS-only animations live in css/animation.css
   ========================================================================== */

/* --------------------------------------------------------------------------
   SCROLL-SEQUENCE  (index.html)
   Each [data-seq] item slides up (translate Y) and fades in as it scrolls up
   the screen; scrolling back reverses it. Writes --seq (0 to 1) and
   --seq-dist; animation.css uses them.
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

initScrollSequence();

/* ==========================================================================
   COOL-CARDS.JS - the 2 angled cards around the naga tail (index.html)
   Only one card can be at the center. The CSS (main.css) does the 3D look
   and the slide; this file only sets which slot is active (.is-center).
   - Mouse: hover a slot. Touch: tap a card (tap again or outside to return).
   - Keyboard: focus a card. Escape returns it.
   ========================================================================== */
(() => {
    const root = document.querySelector('[data-cool-cards]');
    if (!root) return;

    const slots = Array.from(root.querySelectorAll('.cool-slot'));
    let active = null;                              // the one slot at the center, or null

    const setActive = (slot) => {
        if (slot === active) return;
        active = slot;
        slots.forEach((item) => item.classList.toggle('is-center', item === slot));
        root.classList.toggle('has-center', slot !== null);
    };

    slots.forEach((slot) => {
        // Hover is on the fixed slot, not the card, so the sliding card cannot flicker
        slot.addEventListener('pointerenter', (event) => {
            if (event.pointerType === 'mouse') setActive(slot);
        });
        slot.addEventListener('pointerleave', (event) => {
            if (event.pointerType === 'mouse' && active === slot) setActive(null);
        });
        // Touch / pen: tap toggles (mouse already handled by hover)
        slot.addEventListener('click', (event) => {
            if (event.pointerType === 'mouse') return;
            setActive(active === slot ? null : slot);
        });
        // Keyboard focus only (a tap also focuses, but is not :focus-visible)
        slot.addEventListener('focusin', () => {
            if (slot.querySelector(':focus-visible')) setActive(slot);
        });
        slot.addEventListener('focusout', (event) => {
            if (!slot.contains(event.relatedTarget) && active === slot) setActive(null);
        });
    });

    // Tap anywhere but a card, or Escape: back to the sides
    document.addEventListener('click', (event) => {
        if (!event.target.closest('.cool-slot')) setActive(null);
    });
    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') setActive(null);
    });
})();

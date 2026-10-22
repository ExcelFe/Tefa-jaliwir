/* ==========================================================================
   PROGRAM-SEKOLAH.JS - dropdown tabs (Intra- & Ekstra-kulikuler)
   Markup: .dropdown-group > .dropdown-trigger[aria-controls] + .dropdown-panel#id
   - all closed on load/refresh (closed is the HTML default)
   - opening one closes the others in the same group; click it again to close
   - height animation is CSS only (animation.css)
   ========================================================================== */

// Sync one trigger and its panel
function setDropdownState(trigger, isOpen) {
    const panel = document.getElementById(trigger.getAttribute('aria-controls'));
    trigger.setAttribute('aria-expanded', String(isOpen));
    if (panel) panel.classList.toggle('is-open', isOpen);
}

function initDropdownGroups() {
    document.querySelectorAll('.dropdown-group').forEach((group) => {
        const triggers = group.querySelectorAll('.dropdown-trigger');

        // One delegated listener per group
        group.addEventListener('click', (event) => {
            const clicked = event.target.closest('.dropdown-trigger');
            if (!clicked || !group.contains(clicked)) return;

            const shouldOpen = clicked.getAttribute('aria-expanded') !== 'true';

            // Close all, then re-open only the clicked one (unless it was open)
            triggers.forEach((trigger) => setDropdownState(trigger, false));
            if (shouldOpen) setDropdownState(clicked, true);
        });
    });
}

// Back/forward cache: a restored page must start with everything closed
window.addEventListener('pageshow', (event) => {
    if (!event.persisted) return;
    document.querySelectorAll('.dropdown-trigger').forEach((trigger) => setDropdownState(trigger, false));
});

initDropdownGroups();

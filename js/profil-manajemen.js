/* ==========================================================================
   PROFIL-MANAJEMEN.JS - "Selengkapnya" buttons
   Markup: button[data-toggle="id-of-extra-box"] > span (label)
   ========================================================================== */
const LABEL_MORE = 'Selengkapnya';
const LABEL_LESS = 'Lebih sedikit';

function initMoreButtons() {
    document.querySelectorAll('[data-toggle]').forEach((button) => {
        button.addEventListener('click', () => {
            const box = document.getElementById(button.dataset.toggle);
            if (!box) return;

            box.hidden = !box.hidden;
            button.setAttribute('aria-expanded', String(!box.hidden));
            button.querySelector('span').textContent = box.hidden ? LABEL_MORE : LABEL_LESS;
        });
    });
}

initMoreButtons();

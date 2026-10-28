/* ==========================================================================
   PROGRAM-SEKOLAH.JS - interactive cards (pages/before/program-sekolah.html)
   - Program Keahlian (.keahlian-card): click flips the card, click the
     flipped card to open the enlarged pop-up.
   - Intra- / Ekstra-kulikuler ([data-list-card]): click opens a pop-up with
     the subject list (content comes from a <template> in the page).
   - One shared pop-up (#card-modal, css/animation.css). An outside click
     closes it and un-flips any flipped Program Keahlian card. Focus returns
     to whatever opened it, same as the dashboard pop-ups (js/main.js).
   ========================================================================== */
(() => {
    let trigger = null;                                 // element that opened the pop-up

    /* ---------- SHARED POP-UP ---------- */
    const openCardModal = (eyebrow, title, bodyNode, source) => {
        const modal = document.getElementById('card-modal');
        if (!modal) return;
        trigger = source || null;
        modal.querySelector('.card-modal__eyebrow').textContent = eyebrow;
        modal.querySelector('.card-modal__title').textContent = title;
        modal.querySelector('.card-modal__body').replaceChildren(bodyNode);
        modal.classList.add('is-open');
        document.body.classList.add('has-card-modal');
        modal.querySelector('.card-modal__close').focus();
    };

    const closeCardModal = () => {
        const modal = document.getElementById('card-modal');
        if (!modal || !modal.classList.contains('is-open')) return;
        modal.classList.remove('is-open');
        document.body.classList.remove('has-card-modal');
        if (trigger) trigger.focus();
        trigger = null;
    };

    const unflipKeahlianCards = () => {
        document.querySelectorAll('.keahlian-card.is-flipped').forEach((card) => {
            card.classList.remove('is-flipped');
            card.setAttribute('aria-pressed', 'false');
        });
    };

    /* ---------- PROGRAM KEAHLIAN: click to flip, click the flipped card to enlarge ---------- */
    const initKeahlianCards = () => {
        const cards = document.querySelectorAll('.keahlian-card');
        if (!cards.length) return;

        const openEnlarged = (card) => {
            const back = card.querySelector('.keahlian-card__face--back');
            const body = document.createElement('p');
            body.className = 'card-modal__text';
            body.textContent = back.querySelector('p').textContent;
            openCardModal('Program Keahlian', back.querySelector('h3').textContent, body, card);
        };

        cards.forEach((card) => {
            card.addEventListener('click', () => {
                if (card.classList.contains('is-flipped')) {
                    openEnlarged(card);
                } else {
                    unflipKeahlianCards();
                    card.classList.add('is-flipped');
                    card.setAttribute('aria-pressed', 'true');
                }
            });
            card.addEventListener('keydown', (event) => {
                if (event.key !== 'Enter' && event.key !== ' ') return;
                event.preventDefault();             // Space must not scroll the page
                card.click();
            });
        });
    };

    /* ---------- INTRA- / EKSTRA-KULIKULER: click opens the subject list ---------- */
    const initListCards = () => {
        const cards = document.querySelectorAll('[data-list-card]');
        if (!cards.length) return;

        cards.forEach((card) => {
            card.addEventListener('click', () => {
                const template = document.getElementById(card.dataset.listCard);
                if (!template) return;
                openCardModal(card.dataset.listGroup || '', card.dataset.listTitle || '', template.content.cloneNode(true), card);
            });
            card.addEventListener('keydown', (event) => {
                if (event.key !== 'Enter' && event.key !== ' ') return;
                event.preventDefault();
                card.click();
            });
        });
    };

    /* ---------- SHARED POP-UP: close button, outside click, Escape ---------- */
    const initCardModal = () => {
        const modal = document.getElementById('card-modal');
        if (!modal) return;

        modal.addEventListener('click', (event) => {
            // Target is the modal itself when the click lands outside the box
            if (event.target === modal || event.target.closest('[data-card-modal-close]')) {
                closeCardModal();
                unflipKeahlianCards();
            }
        });
        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                closeCardModal();
                unflipKeahlianCards();
            }
        });
        // Click anywhere outside a Program Keahlian card (and outside the pop-up) un-flips it
        document.addEventListener('click', (event) => {
            if (!event.target.closest('.keahlian-card, .card-modal')) unflipKeahlianCards();
        });
    };

    initKeahlianCards();
    initListCards();
    initCardModal();
})();

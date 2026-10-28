/* ==========================================================================
   PROFIL-MANAJEMEN.JS - pop-ups of the Profil Manajemen page
   1. "Cek Profil Guru/Staff": all photos of a group (list copied from the page)
   2. Click a photo: photo + description of that person
   Markup: li.pm-person > button[data-profile] + .pm-desc (hidden description)
   ========================================================================== */
function initProfilPopups() {
    const listDialog = document.getElementById('pm-list');
    const personDialog = document.getElementById('pm-person');
    if (!listDialog || !personDialog || typeof listDialog.showModal !== 'function') return;

    const listTarget = listDialog.querySelector('[data-list-target]');
    const pic = personDialog.querySelector('[data-person-pic]');
    const desc = personDialog.querySelector('[data-person-desc]');

    // Page scroll stays locked while any pop-up is open (class from the Beranda pop-up)
    const syncScroll = () => document.body.classList.toggle('has-lightbox', listDialog.open || personDialog.open);
    listDialog.addEventListener('close', syncScroll);
    personDialog.addEventListener('close', syncScroll);

    // Missing photo: remove the <img> so the grey slot shows (same as main.js initImageSlots)
    const dropBrokenImages = (root) => {
        root.querySelectorAll('img').forEach((img) => {
            img.addEventListener('error', () => img.remove(), { once: true });
            if (img.complete && img.naturalWidth === 0) img.remove();
        });
    };

    // Dialog colors follow the group (data-group on the section)
    const groupOf = (element) => {
        const holder = element.closest('[data-group]');
        return holder ? holder.dataset.group : '';
    };

    const openList = (button) => {
        const source = document.getElementById(button.dataset.listOpen);
        if (!source) return;
        listTarget.replaceChildren(...Array.from(source.children).map((item) => item.cloneNode(true)));
        dropBrokenImages(listTarget);
        listDialog.dataset.group = groupOf(source);
        listDialog.setAttribute('aria-label', button.dataset.label || 'Daftar profil');
        listTarget.parentElement.scrollTop = 0;
        listDialog.showModal();
        syncScroll();
    };

    const openPerson = (card) => {
        const item = card.closest('.pm-person');
        const info = item && item.querySelector('.pm-desc');
        if (!info) return;

        // Photo (left): copy of the card photo, or the grey slot if it is missing
        const photo = card.querySelector('img');
        pic.replaceChildren();
        if (photo) {
            const copy = document.createElement('img');
            copy.src = photo.currentSrc || photo.src;
            copy.alt = info.querySelector('h3').textContent;
            copy.addEventListener('error', () => copy.remove(), { once: true });
            pic.append(copy);
        }
        // Description (right): same text as in the page
        desc.innerHTML = info.innerHTML;
        personDialog.dataset.group = groupOf(card) || listDialog.dataset.group || '';
        personDialog.setAttribute('aria-label', `Profil ${info.querySelector('h3').textContent}`);
        personDialog.showModal();
        syncScroll();
    };

    document.addEventListener('click', (event) => {
        const listButton = event.target.closest('[data-list-open]');
        const card = event.target.closest('[data-profile]');
        if (listButton) {
            openList(listButton);
        } else if (card) {
            openPerson(card);
        } else if (event.target.closest('[data-list-close]')) {
            listDialog.close();
        } else if (event.target.closest('[data-person-close]')) {
            personDialog.close();
        }
    });
    // Click on the dimmed area (target is the dialog itself)
    [listDialog, personDialog].forEach((dialog) => {
        dialog.addEventListener('click', (event) => {
            if (event.target === dialog) dialog.close();
        });
    });
    // Back/forward cache: a restored page starts without pop-ups
    window.addEventListener('pageshow', (event) => {
        if (event.persisted) {
            listDialog.close();
            personDialog.close();
        }
    });
}

initProfilPopups();

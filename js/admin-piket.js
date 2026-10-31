/* ==========================================================================
   ADMIN-PIKET.JS - Pilih Guru Piket page (pop-up "Pilih Guru Piket")
   ========================================================================== */

/* Today's date, placeholder code, copy button */
function initPiketPopup() {
    const date = document.getElementById('piket-tanggal');
    const code = document.getElementById('kode-unik');
    if (!date || !code) return;

    const now = new Date();
    now.setMinutes(now.getMinutes() - now.getTimezoneOffset());     // local time -> ISO string
    date.value = now.toISOString().slice(0, 10);

    // Placeholder only: the real code is created by the backend
    document.querySelector('[data-gen-code]').addEventListener('click', () => {
        const random = Math.random().toString(36).slice(2, 8).toUpperCase();
        code.value = `PKT-${random}-${Date.now().toString(36).slice(-3).toUpperCase()}`;
    });

    const copyButton = document.querySelector('[data-copy]');
    copyButton.addEventListener('click', () => {
        if (!code.value) return;
        // Old browsers / blocked clipboard: fall back to select + copy
        (navigator.clipboard ? navigator.clipboard.writeText(code.value) : Promise.reject())
            .catch(() => { code.select(); document.execCommand('copy'); });
        copyButton.classList.add('is-copied');
        setTimeout(() => copyButton.classList.remove('is-copied'), 1400);
    });
}

initPiketPopup();

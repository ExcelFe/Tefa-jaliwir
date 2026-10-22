/* ==========================================================================
   LOGIN.JS - login page logic
   ========================================================================== */

/* BACK BUTTON  (<a data-back href="../index.html">)
   Goes back in history; with no history (new tab) the link's href (home) is used. */
function initBackButtons() {
    document.querySelectorAll('[data-back]').forEach((button) => {
        button.addEventListener('click', (event) => {
            if (window.history.length > 1) {
                event.preventDefault();
                window.history.back();
            }
        });
    });
}

/* PASSWORD VISIBILITY TOGGLE (show / hide password) */
function initPasswordToggle() {
    const toggleBtn = document.getElementById('password-toggle');
    const passwordInput = document.getElementById('password');
    if (!toggleBtn || !passwordInput) return;

    const icon = toggleBtn.querySelector('.password-toggle__icon');

    toggleBtn.addEventListener('click', (event) => {
        event.preventDefault();
        event.stopPropagation();

        const isHidden = passwordInput.type === 'password';

        if (isHidden) {
            passwordInput.type = 'text';
            toggleBtn.setAttribute('aria-label', 'Sembunyikan password');
            toggleBtn.setAttribute('aria-pressed', 'true');
            if (icon) {
                icon.src = '/media/vector/eye-icon.png';
            }
        } else {
            passwordInput.type = 'password';
            toggleBtn.setAttribute('aria-label', 'Tampilkan password');
            toggleBtn.setAttribute('aria-pressed', 'false');
            if (icon) {
                icon.src = '/media/vector/eye-off.png';
            }
        }

        passwordInput.focus();
    });
}

initBackButtons();
initPasswordToggle();

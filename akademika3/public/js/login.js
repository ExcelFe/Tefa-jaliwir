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

initBackButtons();

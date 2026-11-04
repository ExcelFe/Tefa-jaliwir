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
                icon.src = '../media/vector/eye-icon.png';
            }
        } else {
            passwordInput.type = 'password';
            toggleBtn.setAttribute('aria-label', 'Tampilkan password');
            toggleBtn.setAttribute('aria-pressed', 'false');
            if (icon) {
                icon.src = '../media/vector/eye-off.png';
            }
        }

        passwordInput.focus();
    });
}

/* --------------------------------------------------------------------------
   FORM STATES  (error = red, success = green)
   Both play a fade in-out + ring color on BOTH fields (CSS: animation.css) with a message.
   Error:   fields are cleared only after the animation ends.
   Success: the dashboard loads only after the animation ends.
   -------------------------------------------------------------------------- */
const LOGIN_MESSAGES = {
    error: 'Email/Password Salah!',
    success: 'Berhasil Masuk ke Akun!'
};

/* BACKEND PLACEHOLDER: replace authenticate() with a request to the backend
   (resolve { redirect } for valid data, null otherwise). The demo accounts are
   readable in the browser: delete them when the backend is connected. */
const LOGIN_DEMO_ACCOUNTS = [
    { email: 'admin@globaliti.test', password: 'globaliti123', redirect: 'after/admin/admin-status.html' },
    { email: 'guru@globaliti.test',  password: 'globaliti123', redirect: 'after/guru/guru-jadwal.html' },
    { email: 'piket@globaliti.test', password: 'globaliti123', redirect: 'after/guru-piket/piket-status.html' },
    { email: 'siswa@globaliti.test', password: 'globaliti123', redirect: 'after/siswa/siswa-jadwal.html' }
];

function authenticate(email, password) {
    const account = LOGIN_DEMO_ACCOUNTS.find((item) =>
        item.email === email.trim().toLowerCase() && item.password === password);
    return Promise.resolve(account ? { redirect: account.redirect } : null);
}

// Animation length comes from --state-duration in animation.css ("1.5s" or "1500ms")
function getStateDuration(el) {
    const raw = getComputedStyle(el).getPropertyValue('--state-duration').trim();
    const value = parseFloat(raw);
    if (Number.isNaN(value)) return 1500;
    return raw.endsWith('ms') ? value : value * 1000;
}

function initLoginForm() {
    const form = document.querySelector('.login-form');
    if (!form) return;

    const fields = Array.from(form.querySelectorAll('.login-field'));
    const inputs = Array.from(form.querySelectorAll('input'));
    const submitBtn = form.querySelector('.btn-signin');
    const status = form.querySelector('[data-login-status]');
    let busy = false;                               // blocks double submits during the animation

    // The custom states replace the browser's "Please fill out this field" bubble
    form.noValidate = true;

    // Show a state on every field; resolves when the animation has finished
    const playState = (state) => new Promise((resolve) => {
        let finished = false;
        const finish = () => {
            if (finished) return;
            finished = true;
            window.clearTimeout(timer);
            resolve();
        };
        const timer = window.setTimeout(finish, getStateDuration(fields[0]) + 250);   // fallback

        fields.forEach((field) => {
            field.dataset.state = state;
            field.dataset.msg = LOGIN_MESSAGES[state];
            field.classList.add('is-animating');
        });
        if (state === 'error') inputs.forEach((input) => input.setAttribute('aria-invalid', 'true'));
        if (status) status.textContent = LOGIN_MESSAGES[state];

        fields[0].addEventListener('animationend', finish, { once: true });
    });

    // Back to a normal form (also used when the page is restored with the Back button)
    const reset = () => {
        fields.forEach((field) => {
            field.classList.remove('is-animating');
            delete field.dataset.state;
            delete field.dataset.msg;
        });
        inputs.forEach((input) => {
            input.value = '';
            input.readOnly = false;
            input.removeAttribute('aria-invalid');
        });
        submitBtn.removeAttribute('aria-disabled');
        if (status) status.textContent = '';
        busy = false;
    };

    form.addEventListener('submit', async (event) => {
        event.preventDefault();
        if (busy) return;
        busy = true;
        inputs.forEach((input) => { input.readOnly = true; });
        submitBtn.setAttribute('aria-disabled', 'true');

        // Empty or malformed data counts as an error too (native rules: required, type=email)
        const account = form.checkValidity()
            ? await authenticate(form.elements.email.value, form.elements.password.value)
            : null;

        if (account) {
            await playState('success');
            // Keep the green ring, then open the dashboard
            fields.forEach((field) => field.classList.remove('is-animating'));
            window.location.assign(account.redirect);
        } else {
            await playState('error');
            reset();
            form.elements.email.focus();
        }
    });

    // Back/forward cache: a restored page must not stay locked in the success state
    window.addEventListener('pageshow', (event) => {
        if (event.persisted) reset();
    });
}

initBackButtons();
initPasswordToggle();
initLoginForm();

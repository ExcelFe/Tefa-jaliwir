<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SMK TI Bali Global Badung</title>

    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/animation.css">
    <script defer src="../js/main.js"></script>
    <script defer src="../js/login.js"></script>
    <script defer src="../js/animation.js"></script>
</head>
<body class="page-login theme-warm">
    <main class="login-main">
        <!-- Card: 2 columns. Left = logo + school name | Right = back button, headline, form -->
        <div class="login-card">
            <!-- LEFT: school logo + name -->
            <section class="login-brand">
                <div class="login-logo">
                    <img src="{{ asset('images/logo.webp') }}" alt="Logo sekolah">

                </div>
                <p class="login-school">SMK TI BALI <span>GLOBAL BADUNG</span></p>
            </section>

            <!-- RIGHT: back button (js/login.js), headline, form -->
            <section class="login-panel">
                <!-- Back: previous page, home if there is no history -->
                <a class="back-btn" href="../index.html" data-back aria-label="Kembali ke halaman sebelumnya"></a>

                <div class="login-head">
                    <h1>Sign In</h1>
                    <p>Lorem Ipsum Dolor Sit Amet Consectetur Adipiscing Elit Sint Dolorum</p>
                </div>

                <!-- Email + password, Sign In, Forgot Password (no backend yet) -->
                
<form class="login-form" method="POST" action="{{ route('login.process') }}">
    @csrf

    <div class="login-fields">
        <label class="login-field login-field--email">
            <img src="{{ asset('images/email.png') }}" alt="email">

            <input
                type="email"
                name="email"
                id="email"
                placeholder="Email"
                aria-label="Email"
                autocomplete="email"
                value="{{ old('email') }}"
                required
            >
        </label>

        <label class="login-field">
            <img src="{{ asset('images/lock.png') }}" alt="kunci">

            <input
                type="password"
                name="password"
                id="password"
                placeholder="Password"
                aria-label="Password"
                autocomplete="current-password"
                required
            >
        </label>
    </div>

    @if ($errors->any())
        <p class="login-error">
            {{ $errors->first() }}
        </p>
    @endif

    <div class="login-actions">
        <button type="submit" class="btn-signin">
            Sign In
        </button>
    </div>
</form>

            </section>
        </div>
    </main>
</body>
</html>

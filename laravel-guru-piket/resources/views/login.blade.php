<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SMK TI Bali Global Badung</title>

    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/animation.css') }}">
    <script defer src="{{ asset('js/main.js') }}"></script>
    <script defer src="{{ asset('js/login.js') }}"></script>
    <script defer src="{{ asset('js/animation.js') }}"></script>
</head>
<body class="page-login theme-warm">
    <main class="login-main">
        <!-- Card: 2 columns. Left = logo + school name | Right = back button, headline, form -->
        <div class="login-card">
            <!-- LEFT: school logo + name -->
            <section class="login-brand">
                <div class="login-logo">
                    <img src="{{ asset('media/logo.webp') }}" alt="Logo SMK TI Bali Global Badung" width="136" height="136">
                </div>
                <p class="login-school">SMK TI BALI <span>GLOBAL BADUNG</span></p>
            </section>

            <!-- RIGHT: back button (js/login.js), headline, form -->
            <section class="login-panel">
                <!-- Back: previous page, home if there is no history -->
                <a class="back-btn" href="{{ route('welcome') }}" data-back aria-label="Kembali ke halaman sebelumnya"></a>

                <div class="login-head">
                    <h1>Sign In</h1>
                    <p>Lorem Ipsum Dolor Sit Amet Consectetur Adipiscing Elit Sint Dolorum</p>
                </div>

                <!-- Email + password, Sign In, Forgot Password (no backend yet) -->
                @if ($errors->any())
                    <div style="background-color: #fee2e2; color: #b91c1c; padding: 10px 14px; border-radius: 8px; margin-bottom: 16px; font-size: 14px;">
                        @foreach ($errors->all() as $error)
                            <p style="margin: 0;">{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form class="login-form" method="POST" action="{{ route('login.process') }}">
                    @csrf
                    <div class="login-fields">
                        <label class="login-field login-field--email">
                            <img src="{{ asset('media/vector/email-icon.png') }}" alt="" width="16" height="16">
                            <input type="email" name="email" id="email" value="{{ old('email') }}" placeholder="Email" aria-label="Email" autocomplete="email" required>
                        </label>
                        <label class="login-field login-field--password">
                            <img src="{{ asset('media/vector/lock-icon.png') }}" alt="" width="10" height="10">
                            <input type="password" name="password" id="password" placeholder="Password" aria-label="Password" autocomplete="current-password" required>
                            <button type="button" class="password-toggle" id="password-toggle" aria-label="Tampilkan password" aria-pressed="false">
                                <img src="{{ asset('media/vector/eye-off.png') }}" alt="" class="password-toggle__icon" width="20" height="20">
                            </button>
                        </label>
                    </div>
                    <div class="login-actions">
                        <button type="submit" class="btn-signin">Sign In</button>
                    </div>
                </form>
            </section>
        </div>
    </main>
</body>
</html>

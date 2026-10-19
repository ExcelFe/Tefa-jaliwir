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
        <div class="login-card">
            <section class="login-brand">
                <div class="login-logo">
                    <img src="{{ asset('media/logo.webp') }}" alt="Logo SMK TI Bali Global Badung" width="136" height="136">
                </div>
                <p class="login-school">SMK TI BALI <span>GLOBAL BADUNG</span></p>
            </section>

            <section class="login-panel">
                <a class="back-btn" href="#" data-back aria-label="Kembali ke halaman sebelumnya"></a>

                <div class="login-head">
                    <h1>Sign In</h1>
                    <p>Masukkan email dan password akun murid Anda</p>
                </div>

                @if ($errors->any())
                    <div style="color: red; margin-bottom: 15px;">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form class="login-form" method="POST" action="{{ route('login.post') }}">
                    @csrf
                    <div class="login-fields">
                        <label class="login-field login-field--email">
                            <img src="{{ asset('media/email.png') }}" alt="" width="16" height="16">
                            <input type="email" name="email" id="email" value="{{ old('email') }}" placeholder="Email" aria-label="Email" autocomplete="email" required>
                        </label>
                        <label class="login-field">
                            <img src="{{ asset('media/lock.png') }}" alt="" width="10" height="10">
                            <input type="password" name="password" id="password" placeholder="Password" aria-label="Password" autocomplete="current-password" required>
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

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Akademika</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif;
        }

        body {
            min-height: 100vh;
            background: #f4f6f8;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #17212b;
        }

        .login-wrapper {
            width: 900px;
            min-height: 540px;
            background: #ffffff;
            display: grid;
            grid-template-columns: 1fr 1fr;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.10);
        }

        /* LEFT */

        .visual {
            position: relative;
            background: #155eef;
            padding: 48px;
            overflow: hidden;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .visual::before {
            content: "";
            position: absolute;
            width: 320px;
            height: 320px;
            border: 70px solid rgba(255,255,255,0.08);
            border-radius: 50%;
            right: -130px;
            top: -100px;
        }

        .visual::after {
            content: "";
            position: absolute;
            width: 240px;
            height: 240px;
            border: 45px solid rgba(255,255,255,0.07);
            border-radius: 50%;
            left: -130px;
            bottom: -100px;
        }

        .logo {
            position: relative;
            z-index: 2;
            font-size: 24px;
            font-weight: 800;
            letter-spacing: -1px;
        }

        .visual-content {
            position: relative;
            z-index: 2;
        }

        .visual-content h1 {
            font-size: 46px;
            line-height: 1;
            letter-spacing: -2px;
            margin-bottom: 20px;
        }

        .visual-content p {
            max-width: 320px;
            color: rgba(255,255,255,0.82);
            line-height: 1.6;
            font-size: 15px;
        }

        .bottom-text {
            position: relative;
            z-index: 2;
            font-size: 12px;
            color: rgba(255,255,255,0.6);
        }

        /* RIGHT */

        .form-section {
            padding: 60px 55px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .form-section h2 {
            font-size: 30px;
            margin-bottom: 8px;
        }

        .subtitle {
            color: #7b8794;
            font-size: 14px;
            margin-bottom: 36px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-size: 13px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        input {
            width: 100%;
            height: 50px;
            border: 1px solid #d9dee5;
            border-radius: 10px;
            padding: 0 15px;
            font-size: 14px;
            outline: none;
            transition: 0.2s;
        }

        input:focus {
            border-color: #155eef;
            box-shadow: 0 0 0 3px rgba(21, 94, 239, 0.10);
        }

        .password-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .forgot {
            color: #155eef;
            text-decoration: none;
            font-size: 12px;
        }

        .login-btn {
            width: 100%;
            height: 50px;
            border: none;
            border-radius: 10px;
            background: #155eef;
            color: white;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            margin-top: 8px;
            transition: 0.2s;
        }

        .login-btn:hover {
            background: #0d4dcc;
            transform: translateY(-1px);
        }

        .register {
            text-align: center;
            margin-top: 24px;
            font-size: 13px;
            color: #7b8794;
        }

        .register a {
            color: #155eef;
            text-decoration: none;
            font-weight: 700;
        }

        /* RESPONSIVE */

        @media (max-width: 750px) {
            .login-wrapper {
                width: 92%;
                grid-template-columns: 1fr;
            }

            .visual {
                min-height: 260px;
                padding: 32px;
            }

            .visual-content h1 {
                font-size: 34px;
            }

            .bottom-text {
                display: none;
            }

            .form-section {
                padding: 40px 30px;
            }
        }
    </style>
</head>

<body>

    <div class="login-wrapper">

        <!-- LEFT SIDE -->
        <div class="visual">

            <div class="logo">
                AKADEMIKA.
            </div>

            <div class="visual-content">
                <h1>
                    Learn.<br>
                    Grow.<br>
                    Achieve.
                </h1>

                <p>
                    Kelola aktivitas akademik dengan lebih
                    sederhana, terstruktur, dan terarah.
                </p>
            </div>

            <div class="bottom-text">
                Academic Management System
            </div>

        </div>


        <!-- RIGHT SIDE -->
        <div class="form-section">

            <h2>Welcome back.</h2>

            <p class="subtitle">
                Masuk untuk melanjutkan ke dashboard.
            </p>

            
<form action="{{ route('login.process') }}" method="POST">

    @csrf
  

    <div class="form-group">
        <label for="email">Email</label>

        <input
            type="email"
            id="email"
            name="email"
            placeholder="Masukkan email"
            required
        >
    </div>

    <div class="form-group">
        <label for="password">Password</label>

        <input
            type="password"
            id="password"
            name="password"
            placeholder="Masukkan password"
            required
        >
    </div>

    <button type="submit" class="login-btn">
        Sign In
    </button>
</form>

@if ($errors->any())
    <div class="error">
        {{ $errors->first() }}
    </div>
@endif
            <div class="register">
                Belum memiliki akun?
                <a href="#">Daftar sekarang</a>
            </div>

        </div>

    </div>

</body>
</html>


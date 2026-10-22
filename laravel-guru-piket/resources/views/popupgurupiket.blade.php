
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pop Up Guru Piket</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }

        /* Background overlay */
        .popup-overlay {
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.6);
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            z-index: 9999;
        }

        /* Kotak pop up */
        .popup-card {
            width: 100%;
            max-width: 420px;
            background: white;
            padding: 32px 26px 26px;
            border-radius: 20px;
            text-align: center;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
            animation: muncul 0.3s ease;
        }

        .popup-icon {
            width: 72px;
            height: 72px;
            margin: 0 auto 20px;
            border-radius: 50%;
            background: #dbeafe;
            color: #2563eb;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 34px;
        }

        .popup-card h2 {
            margin: 0 0 12px;
            color: #172554;
            font-size: 23px;
        }

        .popup-card p {
            margin: 0 0 26px;
            color: #64748b;
            font-size: 15px;
            line-height: 1.7;
        }

        /* Tombol lanjut */
        .btn-lanjut {
            display: block;
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 12px;
            background: #2563eb;
            color: white;
            font-size: 15px;
            font-weight: bold;
            text-decoration: none;
            cursor: pointer;
            transition: 0.2s;
        }

        .btn-lanjut:hover {
            background: #1d4ed8;
            transform: translateY(-2px);
        }

        @keyframes muncul {
            from {
                opacity: 0;
                transform: translateY(15px) scale(0.96);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }
    </style>
</head>
<body>

    <div class="popup-overlay">
        <div class="popup-card">

            <div class="popup-icon">✓</div>

            <h2>Guru Piket</h2>

            <p>
                Anda sekarang guru piket.
                Silakan lanjut ke halaman guru piket
                untuk melihat informasi dan tugas Anda.
            </p>

            <a href=" route('guru.piket') "
               class="btn-lanjut">
                Lanjut →
            </a>

        </div>
    </div>

</body>
</html>

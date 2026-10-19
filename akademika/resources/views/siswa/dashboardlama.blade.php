<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard Siswa</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif;
        }

        body {
            background: #f3f6fb;
            color: #1d2433;
        }

        /* =========================
           NAVBAR
        ========================= */

        .navbar {
            width: 100%;
            height: 72px;
            background: white;
            border-bottom: 1px solid #e7ebf2;

            display: flex;
            align-items: center;
            justify-content: space-between;

            padding: 0 7%;
        }

        .logo {
            font-size: 22px;
            font-weight: 800;
            color: #1760ed;
            letter-spacing: -0.5px;
        }

        .nav-menu {
            display: flex;
            align-items: center;
            gap: 30px;
        }

        .nav-menu a {
            text-decoration: none;
            color: #747d8c;
            font-size: 14px;
            font-weight: 600;
        }

        .nav-menu a.active {
            color: #1760ed;
        }

        .profile {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .profile-photo {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: #111827;

            display: flex;
            align-items: center;
            justify-content: center;

            color: white;
            font-size: 17px;
        }

        .profile-info {
            display: flex;
            flex-direction: column;
        }

        .profile-name {
            font-size: 13px;
            font-weight: 700;
        }

        .profile-role {
            font-size: 11px;
            color: #929aaa;
            margin-top: 2px;
        }


        /* =========================
           MAIN
        ========================= */

        .container {
            width: 86%;
            max-width: 1200px;
            margin: 35px auto 60px;
        }

        .welcome {
            margin-bottom: 28px;
        }

        .welcome h1 {
            font-size: 27px;
            margin-bottom: 7px;
            color: #172033;
        }

        .welcome p {
            font-size: 14px;
            color: #858e9d;
        }


        /* =========================
           TOP GRID
        ========================= */

        .dashboard-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 22px;
            margin-bottom: 25px;
        }


        /* =========================
           MAIN SCHEDULE CARD
        ========================= */

        .schedule-card {
            min-height: 260px;
            border-radius: 24px;

            background: #a9eeee;

            padding: 28px;

            position: relative;
            overflow: hidden;

            border: 1px solid #71dada;
            box-shadow: 5px 6px 0 #2753b7;
        }

        .schedule-card::after {
            content: "";
            width: 160px;
            height: 160px;

            background: rgba(255, 255, 255, 0.18);

            border-radius: 50%;

            position: absolute;
            right: -60px;
            top: -65px;
        }

        .schedule-header {
            display: flex;
            justify-content: space-between;
            align-items: center;

            position: relative;
            z-index: 2;
        }

        .schedule-title {
            font-size: 16px;
            font-weight: 700;
        }

        .lesson-number {
            font-size: 12px;
            color: #617878;
        }

        .schedule-content {
            margin-top: 30px;

            display: flex;
            justify-content: space-between;
            align-items: center;

            position: relative;
            z-index: 2;
        }

        .lesson-time {
            font-size: 14px;
            color: #648080;
            margin-bottom: 7px;
        }

        .lesson-name {
            font-size: 24px;
            font-weight: 800;
            color: #172a30;
            margin-bottom: 7px;
        }

        .lesson-status {
            color: #526e70;
            font-size: 13px;
        }

        .teacher {
            text-align: center;
            min-width: 110px;
        }

        .teacher-label {
            font-size: 13px;
            color: #658080;
            margin-bottom: 7px;
        }

        .teacher-photo {
            width: 80px;
            height: 80px;

            background: #d52b72;

            display: flex;
            align-items: center;
            justify-content: center;

            margin: auto;

            font-size: 32px;
            color: white;
        }

        .teacher-status {
            margin-top: 8px;
            font-size: 13px;
            color: #687b7d;
        }


        /* =========================
           ATTENDANCE CARD
        ========================= */

        .attendance-card {
            background: white;
            border: 1px solid #e8ecf2;
            border-radius: 22px;
            padding: 25px;

            box-shadow: 0 8px 25px rgba(31, 45, 61, 0.05);
        }

        .card-title {
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 18px;
        }

        .attendance-circle {
            width: 105px;
            height: 105px;

            border-radius: 50%;

            border: 10px solid #e5eaf3;
            border-top-color: #1760ed;
            border-right-color: #1760ed;

            margin: 5px auto 17px;

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 23px;
            font-weight: 800;
            color: #1760ed;
        }

        .attendance-text {
            text-align: center;
            color: #7e8795;
            font-size: 13px;
        }


        /* =========================
           TODAY SCHEDULE
        ========================= */

        .section-title {
            font-size: 18px;
            font-weight: 800;
            margin-bottom: 15px;
        }

        .schedule-list {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin-bottom: 30px;
        }

        .subject-card {
            background: white;
            border: 1px solid #e8ecf2;

            border-radius: 17px;

            padding: 17px;

            transition: 0.2s;
        }

        .subject-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(31, 45, 61, 0.07);
        }

        .subject-time {
            font-size: 11px;
            color: #9aa2af;
            margin-bottom: 8px;
        }

        .subject-name {
            font-size: 15px;
            font-weight: 700;
            margin-bottom: 6px;
        }

        .subject-teacher {
            font-size: 12px;
            color: #8a93a1;
        }

        .subject-card.active {
            background: #b1eeee;
            border-color: #74dddd;
        }


        /* =========================
           QUICK MENU
        ========================= */

        .quick-menu {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 14px;
        }

        .quick-button {
            background: white;
            border: 1px solid #e8ecf2;

            border-radius: 15px;

            padding: 18px;

            text-decoration: none;
            color: #263142;

            display: flex;
            align-items: center;
            gap: 12px;

            transition: 0.2s;
        }

        .quick-button:hover {
            border-color: #1760ed;
            transform: translateY(-2px);
        }

        .quick-icon {
            width: 38px;
            height: 38px;

            border-radius: 10px;

            background: #eef3ff;
            color: #1760ed;

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 17px;
        }

        .quick-text {
            font-size: 13px;
            font-weight: 700;
        }


        /* =========================
           RESPONSIVE
        ========================= */

        @media (max-width: 900px) {

            .navbar {
                padding: 0 5%;
            }

            .nav-menu {
                gap: 15px;
            }

            .dashboard-grid {
                grid-template-columns: 1fr;
            }

            .schedule-list {
                grid-template-columns: repeat(2, 1fr);
            }

            .quick-menu {
                grid-template-columns: repeat(2, 1fr);
            }
        }


        @media (max-width: 600px) {

            .navbar {
                height: auto;
                min-height: 70px;
                padding: 15px 5%;
                gap: 15px;
            }

            .nav-menu {
                display: none;
            }

            .profile-info {
                display: none;
            }

            .container {
                width: 90%;
                margin-top: 25px;
            }

            .welcome h1 {
                font-size: 23px;
            }

            .schedule-card {
                padding: 21px;
                min-height: 250px;
            }

            .schedule-content {
                align-items: flex-start;
            }

            .lesson-name {
                font-size: 20px;
            }

            .teacher-photo {
                width: 65px;
                height: 65px;
            }

            .teacher {
                min-width: 80px;
            }

            .schedule-list {
                grid-template-columns: 1fr;
            }

            .quick-menu {
                grid-template-columns: 1fr 1fr;
            }
        }
    </style>
</head>


<body>

    <!-- =========================
         NAVBAR
    ========================== -->

    <nav class="navbar">

        <div class="logo">
            AKADEMIKA.
        </div>

        <div class="nav-menu">
            <a href="#" class="active">Dashboard</a>
            <a href="#">Jadwal</a>
            <a href="#">Absensi</a>
            <a href="#">Nilai</a>
        </div>

        <div class="profile">

            <div class="profile-photo">
                ●
            </div>

            <div class="profile-info">
                <span class="profile-name">
                    Excel Febriano
                </span>

                <span class="profile-role">
                    Siswa
                </span>
            </div>

        </div>

    </nav>


    <div class="current-schedule">

    <div>
        <p id="jadwal-hari">Jadwal saat ini</p>

        <span id="jadwal-jam">Memuat...</span>

        <h1 id="jadwal-mapel">Memuat...</h1>

        <p id="jadwal-guru">Memuat...</p>

        <small id="jadwal-status"></small>
    </div>

</div>

    <!-- =========================
         MAIN CONTENT
    ========================== -->

    <main class="container">

        <!-- WELCOME -->

        <div class="welcome">

            <h1>
                Selamat datang, Excel 👋
            </h1>

            <p>
                Berikut informasi kegiatan sekolah kamu hari ini.
            </p>

        </div>


        <!-- =========================
             TOP DASHBOARD
        ========================== -->

        <div class="dashboard-grid">


            <!-- JADWAL SEKARANG -->

            <div class="schedule-card">

                <div class="schedule-header">

                    <div class="schedule-title">
                        Jadwal saat ini
                    </div>

                    <div class="lesson-number">
                        Jam ke-1
                    </div>

                </div>


                <div class="schedule-content">

                    <div class="lesson">

                        <div class="lesson-time">
                            08:00 - 08:30
                        </div>

                        <div class="lesson-name">
                            Bahasa Semut
                        </div>

                        <div class="lesson-status">
                            Berlangsung saat ini
                        </div>

                    </div>


                    <div class="teacher">

                        <div class="teacher-label">
                            Pengajar
                        </div>

                        <div class="teacher-photo">
                            ●
                        </div>

                        <div class="teacher-status">
                            Tidak hadir
                        </div>

                    </div>

                </div>

            </div>


            <!-- ABSENSI -->

            <div class="attendance-card">

                <div class="card-title">
                    Kehadiran
                </div>

                <div class="attendance-circle">
                    92%
                </div>

                <div class="attendance-text">
                    Kehadiran semester ini
                </div>

            </div>

        </div>





        <!-- =========================
             JADWAL HARI INI
        ========================== -->

        <div class="section-title">
            Jadwal hari ini
        </div>


        <div class="schedule-list">


            <div class="subject-card active">

                <div class="subject-time">
                    08:00 - 08:30
                </div>

                <div class="subject-name">
                    Ilmu Hitam
                </div>

                <div class="subject-teacher">
                    Pak Asep
                </div>

            </div>


            <div class="subject-card">

                <div class="subject-time">
                    08:30 - 09:15
                </div>

                <div class="subject-name">
                    Bahasa Alien
                </div>

                <div class="subject-teacher">
                    Bu Sinta
                </div>

            </div>


            <div class="subject-card">

                <div class="subject-time">
                    09:15 - 10:00
                </div>

                <div class="subject-name">
                    Bahasa Anjing
                </div>

                <div class="subject-teacher">
                    Pak Budi
                </div>

            </div>


        </div>


        <!-- =========================
             MENU CEPAT
        ========================== -->

        <div class="section-title">
            Akses cepat
        </div>


        <div class="quick-menu">

            <a href="#" class="quick-button">

                <div class="quick-icon">
                    📅
                </div>

                <div class="quick-text">
                    Seluruh Jadwal
                </div>

            </a>


            <a href="#" class="quick-button">

                <div class="quick-icon">
                    ✓
                </div>

                <div class="quick-text">
                    Absensi
                </div>

            </a>


            <a href="#" class="quick-button">

                <div class="quick-icon">
                    ★
                </div>

                <div class="quick-text">
                    Nilai Saya
                </div>

            </a>


            <a href="#" class="quick-button">

                <div class="quick-icon">
                    👤
                </div>

                <div class="quick-text">
                    Profil
                </div>

            </a>

        </div>

    </main>
<script>
async function updateJadwalSiswa() {

    try {

        const response = await fetch('/api/siswa/jadwal-sekarang');

        const jadwal = await response.json();

        const jam = document.getElementById('jadwal-jam');
        const mapel = document.getElementById('jadwal-mapel');
        const guru = document.getElementById('jadwal-guru');
        const status = document.getElementById('jadwal-status');

        if (jadwal) {

            jam.textContent = jadwal.jam;
            mapel.textContent = jadwal.mapel;
            guru.textContent = 'Guru: ' + jadwal.guru_id;
            status.textContent = 'Berlangsung saat ini';

        } else {

            jam.textContent = '-';
            mapel.textContent = 'Tidak ada jadwal';
            guru.textContent = '';
            status.textContent = 'Tidak ada pelajaran saat ini';

        }

    } catch (error) {

        console.error('Gagal mengambil jadwal:', error);

    }
}

updateJadwalSiswa();

setInterval(updateJadwalSiswa, 30000);
</script>
    
</body>

</html>
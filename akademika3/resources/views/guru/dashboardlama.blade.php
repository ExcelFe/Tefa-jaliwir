<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard Guru - AKADEMIKA</title>

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
            background: #1760ed;

            display: flex;
            align-items: center;
            justify-content: center;

            color: white;
            font-size: 16px;
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
           STAT CARDS
        ========================= */

        .stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
            margin-bottom: 24px;
        }

        .stat-card {
            background: white;
            border: 1px solid #e8ecf2;
            border-radius: 18px;

            padding: 20px;

            box-shadow: 0 7px 20px rgba(31, 45, 61, 0.04);
        }

        .stat-label {
            font-size: 12px;
            color: #8c95a4;
            margin-bottom: 10px;
        }

        .stat-number {
            font-size: 26px;
            font-weight: 800;
            color: #172033;
        }

        .stat-description {
            margin-top: 6px;
            font-size: 11px;
            color: #9ba3af;
        }

        .stat-icon {
            float: right;

            width: 36px;
            height: 36px;

            border-radius: 10px;

            background: #eef3ff;
            color: #1760ed;

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 16px;
        }


        /* =========================
           MAIN GRID
        ========================= */

        .main-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 22px;
            margin-bottom: 25px;
        }


        /* =========================
           SCHEDULE CARD
        ========================= */

        .schedule-card {
            background: #a9eeee;

            border: 1px solid #72dada;
            border-radius: 24px;

            padding: 28px;

            min-height: 275px;

            position: relative;
            overflow: hidden;

            box-shadow: 5px 6px 0 #2753b7;
        }

        .schedule-card::after {
            content: "";

            width: 170px;
            height: 170px;

            background: rgba(255, 255, 255, 0.18);

            border-radius: 50%;

            position: absolute;
            right: -55px;
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

        .schedule-period {
            font-size: 12px;
            color: #627b7c;
        }

        .schedule-content {
            margin-top: 32px;

            position: relative;
            z-index: 2;
        }

        .schedule-time {
            font-size: 14px;
            color: #607d7e;
            margin-bottom: 8px;
        }

        .schedule-subject {
            font-size: 25px;
            font-weight: 800;

            color: #172a30;

            margin-bottom: 7px;
        }

        .schedule-class {
            font-size: 14px;
            color: #587071;
        }

        .schedule-room {
            margin-top: 20px;

            display: inline-block;

            padding: 7px 12px;

            border-radius: 8px;

            background: rgba(255, 255, 255, 0.35);

            font-size: 12px;
            color: #506b6d;
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
            margin-bottom: 20px;
        }

        .attendance-row {
            display: flex;
            justify-content: space-between;

            padding: 13px 0;

            border-bottom: 1px solid #edf0f4;
        }

        .attendance-row:last-child {
            border-bottom: none;
        }

        .attendance-name {
            font-size: 13px;
            color: #5f6877;
        }

        .attendance-number {
            font-size: 13px;
            font-weight: 700;
            color: #1760ed;
        }


        /* =========================
           SECTION
        ========================= */

        .section-title {
            font-size: 18px;
            font-weight: 800;

            margin-bottom: 15px;
        }


        /* =========================
           TODAY SCHEDULE
        ========================= */

        .lesson-list {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;

            margin-bottom: 30px;
        }

        .lesson-card {
            background: white;

            border: 1px solid #e8ecf2;
            border-radius: 17px;

            padding: 18px;

            transition: 0.2s;
        }

        .lesson-card:hover {
            transform: translateY(-3px);

            box-shadow: 0 10px 25px rgba(31, 45, 61, 0.07);
        }

        .lesson-card.active {
            background: #b1eeee;
            border-color: #74dddd;
        }

        .lesson-time {
            font-size: 11px;
            color: #9099a7;
            margin-bottom: 8px;
        }

        .lesson-name {
            font-size: 15px;
            font-weight: 700;

            margin-bottom: 7px;
        }

        .lesson-class {
            font-size: 12px;
            color: #858e9b;
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
            width: 40px;
            height: 40px;

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

            .stats {
                grid-template-columns: repeat(2, 1fr);
            }

            .main-grid {
                grid-template-columns: 1fr;
            }

            .lesson-list {
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

            .stats {
                grid-template-columns: 1fr 1fr;
            }

            .stat-card {
                padding: 16px;
            }

            .stat-number {
                font-size: 22px;
            }

            .schedule-card {
                padding: 22px;
            }

            .schedule-subject {
                font-size: 21px;
            }

            .lesson-list {
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

            <a href="#" class="active">
                Dashboard
            </a>

            <a href="#">
                Jadwal
            </a>

            <a href="#">
                Siswa
            </a>

            <a href="#">
                Nilai
            </a>

        </div>


        <div class="profile">

            <div class="profile-photo">
                ●
            </div>

            <div class="profile-info">

                <span class="profile-name">
                    Budi Santoso
                </span>

                <span class="profile-role">
                    Guru
                </span>

            </div>

        </div>

    </nav>



    <!-- =========================
         MAIN
    ========================== -->

    <main class="container">


        <!-- WELCOME -->

        <div class="welcome">

            <h1>
                Selamat datang, Pak Budi 👋
            </h1>

            <p>
                Berikut ringkasan kegiatan mengajar dan informasi kelas Anda hari ini.
            </p>

        </div>



        <!-- =========================
             STATISTIK
        ========================== -->

        <div class="stats">


            <div class="stat-card">

                <div class="stat-icon">
                    👨‍🎓
                </div>

                <div class="stat-label">
                    Total Siswa
                </div>

                <div class="stat-number">
                    128
                </div>

                <div class="stat-description">
                    Siswa yang diajar
                </div>

            </div>


            <div class="stat-card">

                <div class="stat-icon">
                    📚
                </div>

                <div class="stat-label">
                    Kelas Diampu
                </div>

                <div class="stat-number">
                    4
                </div>

                <div class="stat-description">
                    Kelas aktif
                </div>

            </div>


            <div class="stat-card">

                <div class="stat-icon">
                    📅
                </div>

                <div class="stat-label">
                    Jadwal Hari Ini
                </div>

                <div class="stat-number">
                    5
                </div>

                <div class="stat-description">
                    Jam mengajar
                </div>

            </div>


            <div class="stat-card">

                <div class="stat-icon">
                    ✓
                </div>

                <div class="stat-label">
                    Kehadiran Siswa
                </div>

                <div class="stat-number">
                    94%
                </div>

                <div class="stat-description">
                    Rata-rata bulan ini
                </div>

            </div>


        </div>



        <!-- =========================
             JADWAL + ABSENSI
        ========================== -->

        <div class="main-grid">


            <!-- JADWAL SEKARANG -->

            <div class="schedule-card">

                <div class="schedule-header">

                    <div class="schedule-title">
                        Jadwal mengajar sekarang
                    </div>

                    <div class="schedule-period">
                        Jam ke-2
                    </div>

                </div>


                <div class="schedule-content">

                    <div class="schedule-time">
                        09:00 - 10:30
                    </div>

                    <div class="schedule-subject">
                        Pemrograman Web
                    </div>

                    <div class="schedule-class">
                        Kelas XI PPLG 1
                    </div>

                    <div class="schedule-room">
                        Ruang Lab Komputer 2
                    </div>

                </div>

            </div>



            <!-- ABSENSI -->

            <div class="attendance-card">

                <div class="card-title">
                    Kehadiran kelas terakhir
                </div>


                <div class="attendance-row">

                    <span class="attendance-name">
                        Hadir
                    </span>

                    <span class="attendance-number">
                        30 siswa
                    </span>

                </div>


                <div class="attendance-row">

                    <span class="attendance-name">
                        Izin
                    </span>

                    <span class="attendance-number">
                        2 siswa
                    </span>

                </div>


                <div class="attendance-row">

                    <span class="attendance-name">
                        Sakit
                    </span>

                    <span class="attendance-number">
                        1 siswa
                    </span>

                </div>


                <div class="attendance-row">

                    <span class="attendance-name">
                        Alfa
                    </span>

                    <span class="attendance-number">
                        0 siswa
                    </span>

                </div>

            </div>


        </div>



        <!-- =========================
             JADWAL HARI INI
        ========================== -->

        <div class="section-title">
            Jadwal mengajar hari ini
        </div>


        <div class="lesson-list">


            <div class="lesson-card active">

                <div class="lesson-time">
                    08:00 - 08:45
                </div>

                <div class="lesson-name">
                    Pemrograman Web
                </div>

                <div class="lesson-class">
                    XI PPLG 1
                </div>

            </div>


            <div class="lesson-card">

                <div class="lesson-time">
                    09:00 - 10:30
                </div>

                <div class="lesson-name">
                    Pemrograman Web
                </div>

                <div class="lesson-class">
                    XI PPLG 2
                </div>

            </div>


            <div class="lesson-card">

                <div class="lesson-time">
                    10:45 - 11:30
                </div>

                <div class="lesson-name">
                    Basis Data
                </div>

                <div class="lesson-class">
                    X PPLG 1
                </div>

            </div>


        </div>



        <!-- =========================
             AKSES CEPAT
        ========================== -->

        <div class="section-title">
            Akses cepat
        </div>


        <div class="quick-menu">


            <a href="#" class="quick-button">

                <div class="quick-icon">
                    👨‍🎓
                </div>

                <div class="quick-text">
                    Data Siswa
                </div>

            </a>


            <a href="#" class="quick-button">

                <div class="quick-icon">
                    ✓
                </div>

                <div class="quick-text">
                    Input Absensi
                </div>

            </a>


            <a href="#" class="quick-button">

                <div class="quick-icon">
                    📝
                </div>

                <div class="quick-text">
                    Kelola Nilai
                </div>

            </a>


            <a href="#" class="quick-button">

                <div class="quick-icon">
                    📅
                </div>

                <div class="quick-text">
                    Jadwal Mengajar
                </div>

            </a>


        </div>


    </main>

</body>

</html>
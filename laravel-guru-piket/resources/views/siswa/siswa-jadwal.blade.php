<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal - Dashboard Siswa - SMK TI Bali Global Badung</title>

    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/animation.css') }}">
    <script defer src="{{ asset('js/main.js') }}"></script>
    <script defer src="{{ asset('js/animation.js') }}"></script>
</head>
<body class="dash-body">
    <div class="dash">
        <!-- Dimmed area behind the sidebar on tablet/phone (click closes it) -->
        <div class="dash-scrim" data-sidebar-close></div>

        <!-- Sidebar: minimize + brand (top) | page menu (middle) | account + settings (bottom) -->
        <aside class="dash-sidebar" id="sidebar" aria-label="Menu siswa">
            <div class="dash-sidebar__top">
                <button type="button" class="dash-icon-btn" data-sidebar-close aria-label="Tutup sidebar">
                    <img class="dash-icon" src="../../../media/vector/minimize-icon.png" alt="" width="24" height="24">
                </button>
                <span class="dash-brand">Globaliti Badung</span>
            </div>

            <nav class="dash-menu" aria-label="Halaman siswa">
                <a class="dash-menu__item" href="{{ route('siswa.jadwal') }}" aria-current="page">
                    <img class="dash-icon" src="{{ asset('media/vector/jadwal-icon.png') }}" alt="" width="24" height="24">
                    Jadwal
                </a>
                <a class="dash-menu__item" href="{{ route('siswa.status') }}">
                    <img class="dash-icon" src="{{ asset('media/vector/status-icon.png') }}" alt="" width="24" height="24">
                    Status Guru
                </a>
                <a class="dash-menu__item" href="{{ route('siswa.denah') }}">
                    <img class="dash-icon" src="{{ asset('media/vector/map-icon.png') }}" alt="" width="24" height="24">
                    Denah Sekolah
                </a>
            </nav>

            <div class="dash-account">
                <div class="dash-account__info">
                    <span class="dash-avatar"><img class="dash-icon" src="{{ asset('media/vector/absensi-icon.png') }}" alt="" width="24" height="24"></span>
                    <span class="dash-account__name">{{ session('email_akun') ?? 'Siswa' }}</span>
                </div>
                <button type="button" class="dash-icon-btn" data-settings-toggle aria-label="Pengaturan" aria-expanded="false" aria-controls="settings-menu">
                    <img class="dash-icon" src="{{ asset('media/vector/setting-icon.png') }}" alt="" width="24" height="24">
                </button>

                <!-- Settings menu: opens above the account container -->
                <div class="dash-settings" id="settings-menu">
                    <button type="button" class="dash-settings__item" role="switch" aria-checked="false" data-theme-toggle>
                        <img class="dash-icon dash-icon--light" src="{{ asset('media/vector/lightmode-icon.png') }}" alt="" width="24" height="24">
                        <img class="dash-icon dash-icon--dark" src="{{ asset('media/vector/darkmode-icon.png') }}" alt="" width="24" height="24">
                        Appearance Mode
                        <span class="dash-switch" aria-hidden="true"></span>
                    </button>

                    <!-- Learn More: sub-menu shows on hover, to the right -->
                    <div class="dash-learn">
                        <button type="button" class="dash-settings__item" aria-haspopup="true">
                            <img class="dash-icon" src="{{ asset('media/vector/info-icon.png') }}" alt="" width="24" height="24">
                            Learn More
                            <img class="dash-icon dash-icon--end" src="{{ asset('media/vector/right-arrow-icon.png') }}" alt="" width="24" height="24">
                        </button>
                        <div class="dash-submenu">
                            <div class="dash-submenu__box">
                                <a class="dash-settings__item" href="#">Kebijakan Privasi</a>
                                <a class="dash-settings__item" href="#">Syarat &amp; Ketentuan</a>
                                <a class="dash-settings__item" href="#">Panduan Pengguna</a>
                            </div>
                        </div>
                    </div>

                    <!-- Log Out -->
                    <a class="dash-settings__item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form-siswa-jadwal').submit();">
                        <img class="dash-icon" src="{{ asset('media/vector/log-out-icon.png') }}" alt="" width="24" height="24">
                        Log Out
                    </a>
                    <form id="logout-form-siswa-jadwal" action="{{ route('logout') }}" method="POST" style="display:none;">
                        @csrf
                    </form>
                </div>
            </div>
        </aside>

        <!-- Shown while the sidebar is closed (always above the page on tablet/phone) -->
        <div class="dash-topbar">
            <button type="button" class="dash-icon-btn" data-sidebar-open aria-label="Buka sidebar" aria-expanded="true" aria-controls="sidebar">
                <img class="dash-icon" src="../../../media/vector/maximize-icon.png" alt="" width="24" height="24">
            </button>
            <span class="dash-brand">Globaliti Badung</span>
        </div>


        <main class="dash-main">
            <div class="dash-content">
                <header class="dash-head">
                    <div class="dash-head__title">
                        <h1 class="dash-title">Jadwal Pelajaran (Per Kelas)</h1>
                    </div>
                </header>

                <!-- Placeholder schedule: green = running now, red = not running -->
                <section class="dash-section" aria-labelledby="jadwal-hari-ini">
                    <h2 class="dash-subtitle" id="jadwal-hari-ini">Jadwal Hari Ini</h2>

                    <!-- Day-of-week tabs -->
                    <div class="dash-daytabs" role="tablist" aria-label="Pilih hari">
                        <button type="button" class="dash-daytab is-active" role="tab" aria-selected="true">Senin</button>
                        <button type="button" class="dash-daytab" role="tab" aria-selected="false">Selasa</button>
                        <button type="button" class="dash-daytab" role="tab" aria-selected="false">Rabu</button>
                        <button type="button" class="dash-daytab" role="tab" aria-selected="false">Kamis</button>
                        <button type="button" class="dash-daytab" role="tab" aria-selected="false">Jumat</button>
                    </div>

                    <!-- Schedule cards: green left border = running, red = not running -->
                    <ul class="dash-list">
                        <li>
                            <div class="dash-jadwal-card dash-jadwal-card--on">
                                <div class="dash-jadwal-card__info">
                                    <span class="dash-jadwal-card__subject">Sejarah</span>
                                    <span class="dash-jadwal-card__teacher">Made Aldo Jusventus sr</span>
                                </div>
                                <span class="dash-jadwal-card__time">07:00 - 08:00</span>
                            </div>
                        </li>
                        <li>
                            <div class="dash-jadwal-card dash-jadwal-card--off">
                                <div class="dash-jadwal-card__info">
                                    <span class="dash-jadwal-card__subject">Sejarah</span>
                                    <span class="dash-jadwal-card__teacher">Made Aldo Jusventus sr</span>
                                </div>
                                <span class="dash-jadwal-card__time">08:00 - 09:00</span>
                            </div>
                        </li>
                        <li>
                            <div class="dash-jadwal-card dash-jadwal-card--off">
                                <div class="dash-jadwal-card__info">
                                    <span class="dash-jadwal-card__subject">Sejarah</span>
                                    <span class="dash-jadwal-card__teacher">Made Aldo Jusventus sr</span>
                                </div>
                                <span class="dash-jadwal-card__time">09:00 - 10:30</span>
                            </div>
                        </li>
                    </ul>
                </section>

            </div>
        </main>
    </div>
</body>
</html>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Guru - Dashboard Admin - SMK TI Bali Global Badung</title>

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
        <aside class="dash-sidebar" id="sidebar" aria-label="Menu admin">
            <div class="dash-sidebar__top">
                <button type="button" class="dash-icon-btn" data-sidebar-close aria-label="Tutup sidebar">
                    <img class="dash-icon" src="../../../media/vector/minimize-icon.png" alt="" width="24" height="24">
                </button>
                <span class="dash-brand">Globaliti Badung</span>
            </div>

            <nav class="dash-menu" aria-label="Halaman admin">
                <a class="dash-menu__item" href="{{ route('admin.status') }}" aria-current="page">
                    <img class="dash-icon" src="{{ asset('media/vector/status-icon.png') }}" alt="" width="24" height="24">
                    Status Guru
                </a>
                <a class="dash-menu__item" href="{{ route('admin.piket') }}">
                    <img class="dash-icon" src="{{ asset('media/vector/authority-icon.png') }}" alt="" width="24" height="24">
                    Pilih Guru Piket
                </a>
                <a class="dash-menu__item" href="{{ route('admin.rekap.siswa') }}">
                    <img class="dash-icon" src="{{ asset('media/vector/clipboard-icon.png') }}" alt="" width="24" height="24">
                    Rekap Siswa
                </a>
                <a class="dash-menu__item" href="{{ route('admin.rekap.guru') }}">
                    <img class="dash-icon" src="{{ asset('media/vector/clipboard-icon.png') }}" alt="" width="24" height="24">
                    Rekap Guru
                </a>
                <a class="dash-menu__item" href="{{ route('admin.edit') }}">
                    <img class="dash-icon" src="{{ asset('media/vector/edit-icon.png') }}" alt="" width="24" height="24">
                    Edit App
                </a>
            </nav>

            <div class="dash-account">
                <div class="dash-account__info">
                    <span class="dash-avatar"><img class="dash-icon" src="{{ asset('media/vector/absensi-icon.png') }}" alt="" width="24" height="24"></span>
                    <span class="dash-account__name">{{ session('email_akun') ?? 'Admin' }}</span>
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
                    <a class="dash-settings__item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form-admin-status').submit();">
                        <img class="dash-icon" src="{{ asset('media/vector/log-out-icon.png') }}" alt="" width="24" height="24">
                        Log Out
                    </a>
                    <form id="logout-form-admin-status" action="{{ route('logout') }}" method="POST" style="display:none;">
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
                        <h1 class="dash-title">Status Guru</h1>
                    </div>
                    <div class="dash-tools">
                        <div class="dash-search" role="search">
                            <input type="search" placeholder="Search name" aria-label="Search name">
                            <img class="dash-icon" src="../../../media/vector/search-icon.png" alt="" width="24" height="24">
                        </div>
                        <button type="button" class="dash-icon-btn" aria-label="Filter">
                            <img class="dash-icon" src="../../../media/vector/filter-icon.png" alt="" width="24" height="24">
                        </button>
                    </div>
                </header>

                <!-- Placeholder teachers: green = hadir, red = tidak hadir -->
                <ul class="dash-list">
                    <li class="dash-item">
                        <div class="dash-card">
                            <span class="dash-card__name">Nama Guru 1</span>
                            <span class="dash-card__meta">Senin, 19 Oktober 2026</span>
                        </div>
                        <span class="dash-status dash-status--on" role="img" aria-label="Hadir"></span>
                    </li>
                    <li class="dash-item">
                        <div class="dash-card">
                            <span class="dash-card__name">Nama Guru 2</span>
                            <span class="dash-card__meta">Senin, 19 Oktober 2026</span>
                        </div>
                        <span class="dash-status dash-status--off" role="img" aria-label="Tidak hadir"></span>
                    </li>
                    <li class="dash-item">
                        <div class="dash-card">
                            <span class="dash-card__name">Nama Guru 3</span>
                            <span class="dash-card__meta">Senin, 19 Oktober 2026</span>
                        </div>
                        <span class="dash-status dash-status--on" role="img" aria-label="Hadir"></span>
                    </li>
                    <li class="dash-item">
                        <div class="dash-card">
                            <span class="dash-card__name">Nama Guru 4</span>
                            <span class="dash-card__meta">Senin, 19 Oktober 2026</span>
                        </div>
                        <span class="dash-status dash-status--on" role="img" aria-label="Hadir"></span>
                    </li>
                    <li class="dash-item">
                        <div class="dash-card">
                            <span class="dash-card__name">Nama Guru 5</span>
                            <span class="dash-card__meta">Senin, 19 Oktober 2026</span>
                        </div>
                        <span class="dash-status dash-status--on" role="img" aria-label="Hadir"></span>
                    </li>
                    <li class="dash-item">
                        <div class="dash-card">
                            <span class="dash-card__name">Nama Guru 6</span>
                            <span class="dash-card__meta">Senin, 19 Oktober 2026</span>
                        </div>
                        <span class="dash-status dash-status--off" role="img" aria-label="Tidak hadir"></span>
                    </li>
                    <li class="dash-item">
                        <div class="dash-card">
                            <span class="dash-card__name">Nama Guru 7</span>
                            <span class="dash-card__meta">Senin, 19 Oktober 2026</span>
                        </div>
                        <span class="dash-status dash-status--off" role="img" aria-label="Tidak hadir"></span>
                    </li>
                </ul>
            </div>
        </main>
    </div>
</body>
</html>

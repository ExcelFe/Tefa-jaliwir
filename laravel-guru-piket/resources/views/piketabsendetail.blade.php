<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Absensi Guru - {{ $tanggalLabel }} - SMK TI Bali Global Badung</title>

    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/animation.css') }}">
    <script defer src="{{ asset('js/main.js') }}"></script>
    <style>
        .badge-status {
            display: inline-block;
            padding: 0.25rem 0.8rem;
            border-radius: var(--radius-pill);
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: capitalize;
            letter-spacing: 0.02em;
        }
        .badge-status--hadir {
            background: color-mix(in srgb, var(--status-ok) 18%, transparent);
            color: #15803d;
            border: 1px solid color-mix(in srgb, var(--status-ok) 40%, transparent);
        }
        .badge-status--tidak-hadir {
            background: color-mix(in srgb, var(--status-bad) 18%, transparent);
            color: #b91c1c;
            border: 1px solid color-mix(in srgb, var(--status-bad) 40%, transparent);
        }
        .badge-status--izin {
            background: color-mix(in srgb, #eab308 18%, transparent);
            color: #a16207;
            border: 1px solid color-mix(in srgb, #eab308 40%, transparent);
        }
        .badge-status--sakit {
            background: color-mix(in srgb, #0284c7 18%, transparent);
            color: #0369a1;
            border: 1px solid color-mix(in srgb, #0284c7 40%, transparent);
        }
        .badge-status--belum {
            background: color-mix(in srgb, var(--dash-muted) 15%, transparent);
            color: var(--dash-muted);
            border: 1px solid color-mix(in srgb, var(--dash-muted) 35%, transparent);
        }
        html[data-theme="dark"] .badge-status--hadir {
            color: #4ade80;
        }
        html[data-theme="dark"] .badge-status--tidak-hadir {
            color: #f87171;
        }
        html[data-theme="dark"] .badge-status--izin {
            color: #facc15;
        }
        html[data-theme="dark"] .badge-status--sakit {
            color: #38bdf8;
        }
        .table-responsive-card {
            border: 1px solid var(--dash-edge);
            border-radius: var(--radius-md);
            background: var(--dash-surface);
            box-shadow: var(--dash-shadow);
            overflow: hidden;
        }
        .table-date-banner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: var(--space-2);
            padding: var(--space-3) var(--space-4);
            border-bottom: 1px solid var(--dash-edge);
            background: color-mix(in srgb, var(--dash-hover) 40%, var(--dash-surface));
        }
        .table-date-banner__label {
            font-size: 0.85rem;
            color: var(--dash-muted);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            font-weight: 600;
        }
        .table-date-banner__value {
            font-family: var(--font-heading);
            font-size: 1.25rem;
            color: var(--dash-ink);
            letter-spacing: 0.02em;
        }
    </style>
</head>
<body class="dash-body">
    <div class="dash">
        <!-- Dimmed area behind the sidebar on tablet/phone (click closes it) -->
        <div class="dash-scrim" data-sidebar-close></div>

        <!-- Sidebar: minimize + brand (top) | page menu (middle) | account + settings (bottom) -->
        <aside class="dash-sidebar" id="sidebar" aria-label="Menu guru piket">
            <div class="dash-sidebar__top">
                <button type="button" class="dash-icon-btn" data-sidebar-close aria-label="Tutup sidebar">
                    <img class="dash-icon" src="{{ asset('media/vector/minimize-icon.png') }}" alt="" width="24" height="24">
                </button>
                <span class="dash-brand">Globaliti Badung</span>
            </div>

            <nav class="dash-menu" aria-label="Halaman guru piket">
                <a class="dash-menu__item" href="{{ route('piket.status') }}">
                    <img class="dash-icon" src="{{ asset('media/vector/status-icon.png') }}" alt="" width="24" height="24">
                    Status Guru
                </a>
                <a class="dash-menu__item" href="{{ route('piket.absen') }}" aria-current="page">
                    <img class="dash-icon" src="{{ asset('media/vector/absensi-icon.png') }}" alt="" width="24" height="24">
                    Absen Guru
                </a>
            </nav>

            <div class="dash-account">
                <div class="dash-account__info">
                    <span class="dash-avatar"><img class="dash-icon" src="{{ asset('media/vector/absensi-icon.png') }}" alt="" width="24" height="24"></span>
                    <span class="dash-account__name">{{ session('email_akun') ?? 'Guru Piket' }}</span>
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
                    <a class="dash-settings__item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form-piket-detail').submit();">
                        <img class="dash-icon" src="{{ asset('media/vector/log-out-icon.png') }}" alt="" width="24" height="24">
                        Log Out
                    </a>
                    <form id="logout-form-piket-detail" action="{{ route('logout') }}" method="POST" style="display:none;">
                        @csrf
                    </form>
                </div>
            </div>
        </aside>

        <!-- Shown while the sidebar is closed (always above the page on tablet/phone) -->
        <div class="dash-topbar">
            <button type="button" class="dash-icon-btn" data-sidebar-open aria-label="Buka sidebar" aria-expanded="true" aria-controls="sidebar">
                <img class="dash-icon" src="{{ asset('media/vector/maximize-icon.png') }}" alt="" width="24" height="24">
            </button>
            <span class="dash-brand">Globaliti Badung</span>
        </div>


        <main class="dash-main">
            <div class="dash-content">
                <header class="dash-head">
                    <div class="dash-head__title">
                        <h1 class="dash-title">Detail Absensi Guru</h1>
                    </div>
                    <div class="dash-tools">
                        <a href="{{ route('piket.absen') }}" class="dash-btn dash-btn--ghost" aria-label="Kembali ke Log Absensi Guru">
                            &larr; Kembali
                        </a>
                        <div class="dash-search" role="search">
                            <input type="search" placeholder="Search nama..." aria-label="Search nama guru" id="search-guru" oninput="filterTable()">
                            <img class="dash-icon" src="{{ asset('media/vector/search-icon.png') }}" alt="" width="24" height="24">
                        </div>
                    </div>
                </header>

                <div class="table-responsive-card">
                    <div class="table-date-banner">
                        <div>
                            <span class="table-date-banner__label">Hari &amp; Tanggal Absensi</span>
                            <div class="table-date-banner__value">{{ $tanggalLabel }}</div>
                        </div>
                        <div>
                            <span class="table-date-banner__label">Total Guru: <strong>{{ count($absensi) }}</strong></span>
                        </div>
                    </div>

                    <div style="overflow-x: auto;">
                        <table class="dash-table" id="table-absensi">
                            <caption class="dash-sr">Data kehadiran guru tanggal {{ $tanggalLabel }}</caption>
                            <thead>
                                <tr>
                                    <th scope="col" style="width: 4rem;">No.</th>
                                    <th scope="col" class="dash-table__name">Nama Guru</th>
                                    <th scope="col" style="width: 10rem;">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($absensi as $index => $item)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td class="dash-table__name guru-name" style="font-weight: 600;">
                                            {{ $item->nama }}
                                        </td>
                                        <td>
                                            @php
                                                $status = mb_strtolower($item->status ?? 'hadir');
                                                $badgeClass = match($status) {
                                                    'hadir' => 'badge-status--hadir',
                                                    'tidak hadir', 'tidak-hadir', 'alpa' => 'badge-status--tidak-hadir',
                                                    'izin' => 'badge-status--izin',
                                                    'sakit' => 'badge-status--sakit',
                                                    'belum diabsen' => 'badge-status--belum',
                                                    default => 'badge-status--hadir',
                                                };
                                            @endphp
                                            <span class="badge-status {{ $badgeClass }}">
                                                {{ $item->status ?? 'Hadir' }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" style="padding: 2rem; color: var(--dash-muted);">
                                            Belum ada data guru.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        function filterTable() {
            const input = document.getElementById('search-guru');
            const filter = input.value.toLowerCase();
            const table = document.getElementById('table-absensi');
            const tr = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');

            for (let i = 0; i < tr.length; i++) {
                const td = tr[i].getElementsByClassName('guru-name')[0];
                if (td) {
                    const txtValue = td.textContent || td.innerText;
                    tr[i].style.display = txtValue.toLowerCase().indexOf(filter) > -1 ? '' : 'none';
                }
            }
        }
    </script>
</body>
</html>
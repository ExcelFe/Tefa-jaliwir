<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absen Guru - Dashboard Guru Piket - SMK TI Bali Global Badung</title>

    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/animation.css') }}">
    <script defer src="{{ asset('js/main.js') }}"></script>
    <script defer src="{{ asset('js/guru-absen-siswa.js') }}"></script>
    <script defer src="{{ asset('js/animation.js') }}"></script>
    <style>
        .alert-success-piket {
            background-color: #dcfce7;
            color: #15803d;
            border: 1px solid #86efac;
            padding: 0.75rem 1rem;
            border-radius: var(--radius-md);
            margin-bottom: var(--space-4);
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .dash-modal__box--scrollable {
            max-height: 85vh;
            display: flex;
            flex-direction: column;
        }
        .dash-modal__body--scrollable {
            overflow-y: auto;
            flex: 1;
        }
        .modal-date-picker {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: var(--dash-hover);
            padding: 0.35rem 0.75rem;
            border-radius: var(--radius-pill);
            border: 1px solid var(--dash-edge);
        }
        .modal-date-picker input[type="date"] {
            border: none;
            background: transparent;
            font-family: inherit;
            font-size: 0.875rem;
            color: var(--dash-ink);
            outline: none;
            cursor: pointer;
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
                    <span class="dash-account__name">{{ session('nama_guru') ?? session('email_akun') ?? 'Guru Piket' }}</span>
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
                    <a class="dash-settings__item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form-piket-absen').submit();">
                        <img class="dash-icon" src="{{ asset('media/vector/log-out-icon.png') }}" alt="" width="24" height="24">
                        Log Out
                    </a>
                    <form id="logout-form-piket-absen" action="{{ route('logout') }}" method="POST" style="display:none;">
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
                        <h1 class="dash-title">Log Absensi Guru</h1>
                    </div>
                    <div class="dash-tools">
                        <div class="dash-search" role="search">
                            <input type="search" placeholder="Search log..." aria-label="Search log" id="search-log" oninput="filterLogs()">
                            <img class="dash-icon" src="{{ asset('media/vector/search-icon.png') }}" alt="" width="24" height="24">
                        </div>
                        <button type="button" class="dash-btn" data-modal-open="modal-absen">
                            {{ $sudahAbsen ? 'Edit Absensi Hari Ini' : 'Mulai Absensi' }}
                            <img class="dash-icon" src="{{ asset('media/vector/add-icon.png') }}" alt="" width="24" height="24">
                        </button>
                    </div>
                </header>

                @if (session('sukses'))
                    <div class="alert-success-piket">
                        <span>{{ session('sukses') }}</span>
                        <button type="button" onclick="this.parentElement.remove()" style="background:none; border:none; color:inherit; cursor:pointer; font-weight:bold;">&times;</button>
                    </div>
                @endif

                <ul class="dash-list" id="log-list">
                    @forelse ($logAbsensi as $item)
                        <li class="dash-item log-item" data-meta="{{ strtolower($item->tanggal_formatted) }}">
                            <div class="dash-card">
                                <span class="dash-card__name">Absensi Guru</span>
                                <span class="dash-card__meta">{{ $item->tanggal_formatted }}</span>
                            </div>
                            <a href="{{ route('piket.absen.detail', ['tanggal' => $item->tanggal]) }}" class="dash-action" aria-label="Lihat detail absensi guru, {{ $item->tanggal_formatted }}" title="Lihat Detail Absensi">
                                <img class="dash-icon" src="{{ asset('media/vector/edit-icon.png') }}" alt="Detail" width="24" height="24">
                            </a>
                        </li>
                    @empty
                        <li class="dash-item">
                            <div class="dash-card">
                                <span class="dash-card__name">Belum ada riwayat absensi guru. Klik "Mulai Absensi" untuk memulai.</span>
                            </div>
                        </li>
                    @endforelse
                </ul>
            </div>
        </main>
    </div>

    <!-- Pop-up: Form Absensi Guru (Real data dari database) -->
    <div class="dash-modal" id="modal-absen" role="dialog" aria-modal="true" aria-labelledby="modal-absen-title">
        <form class="dash-modal__box dash-modal__box--wide dash-modal__box--scrollable" action="{{ route('piket.absen.simpan') }}" method="POST" tabindex="-1">
            @csrf
            <div class="dash-modal__head" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.75rem; border-bottom: 1px solid var(--dash-edge);">
                <div>
                    <h2 class="dash-modal__title" id="modal-absen-title">
                        {{ $sudahAbsen ? 'Edit Absensi Guru' : 'Mulai Absensi Guru' }}
                    </h2>
                    <p style="margin: 0.2rem 0 0; color: var(--dash-muted); font-size: 0.85rem;">
                        {{ $tanggalHariIni }} &bull; Total Guru: {{ count($guruList) }}
                    </p>
                </div>
                <div class="modal-date-picker">
                    <label for="tanggal_input" style="font-size: 0.8rem; font-weight: 600; color: var(--dash-muted);">Tanggal:</label>
                    <input type="date" id="tanggal_input" name="tanggal" value="{{ date('Y-m-d') }}" required>
                </div>
            </div>

            <div class="dash-modal__body dash-modal__body--table dash-modal__body--scrollable">
                <table class="dash-table">
                    <caption class="dash-sr">Daftar kehadiran guru</caption>
                    <thead>
                        <tr>
                            <th scope="col" rowspan="2" style="width: 3.5rem;">No.</th>
                            <th scope="col" rowspan="2" class="dash-table__name">Nama Guru</th>
                            <th scope="colgroup" colspan="2" style="text-align: center;">Kehadiran</th>
                        </tr>
                        <tr>
                            <th scope="col" style="width: 5.5rem; text-align: center;">Hadir</th>
                            <th scope="col" style="width: 5.5rem; text-align: center;">Tidak Hadir</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($guruList as $index => $guru)
                            @php
                                $absenRecord = $absenHariIni[$guru->kode_guru] ?? null;
                                $currentStatus = $absenRecord ? $absenRecord->status : 'H';
                            @endphp
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td class="dash-table__name" style="font-weight: 600;">{{ $guru->nama }}</td>
                                <td style="text-align: center;">
                                    <input class="dash-check dash-check--ok" type="radio" name="kehadiran[{{ $guru->kode_guru }}]" value="H" {{ $currentStatus === 'H' ? 'checked' : '' }} aria-label="Hadir: {{ $guru->nama }}" required>
                                </td>
                                <td style="text-align: center;">
                                    <input class="dash-check dash-check--bad" type="radio" name="kehadiran[{{ $guru->kode_guru }}]" value="T" {{ $currentStatus === 'T' ? 'checked' : '' }} aria-label="Tidak hadir: {{ $guru->nama }}">
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="dash-modal__foot" style="border-top: 1px solid var(--dash-edge);">
                <button type="button" class="dash-btn dash-btn--ghost" data-modal-close>Batal</button>
                <button type="submit" class="dash-btn">Simpan Absensi</button>
            </div>
        </form>
    </div>

    <script>
        function filterLogs() {
            const input = document.getElementById('search-log');
            const filter = input.value.toLowerCase().trim();
            const items = document.querySelectorAll('.log-item');

            items.forEach(item => {
                const meta = item.getAttribute('data-meta') || '';
                if (meta.indexOf(filter) > -1) {
                    item.style.display = '';
                } else {
                    item.style.display = 'none';
                }
            });
        }
    </script>
</body>
</html>

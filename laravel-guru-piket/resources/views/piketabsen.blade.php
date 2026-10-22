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
                            <input type="search" placeholder="Search log" aria-label="Search log" id="search-log" oninput="filterLog()">
                            <img class="dash-icon" src="{{ asset('media/vector/search-icon.png') }}" alt="" width="24" height="24">
                        </div>
                        <button type="button" class="dash-icon-btn" aria-label="Filter">
                            <img class="dash-icon" src="{{ asset('media/vector/filter-icon.png') }}" alt="" width="24" height="24">
                        </button>
                        <button type="button" class="dash-btn" data-modal-open="modal-absen">
                            Mulai Absensi
                            <img class="dash-icon" src="{{ asset('media/vector/add-icon.png') }}" alt="" width="24" height="24">
                        </button>
                    </div>
                </header>

                @if (session('sukses'))
                    <div role="status" style="margin-bottom: var(--space-4); padding: var(--space-3) var(--space-4); border: 1px solid color-mix(in srgb, var(--status-ok) 40%, transparent); border-radius: var(--radius-md); background: color-mix(in srgb, var(--status-ok) 14%, transparent);">
                        {{ session('sukses') }}
                    </div>
                @endif
                @if ($errors->any())
                    <div role="alert" style="margin-bottom: var(--space-4); padding: var(--space-3) var(--space-4); border: 1px solid color-mix(in srgb, var(--status-bad) 40%, transparent); border-radius: var(--radius-md); background: color-mix(in srgb, var(--status-bad) 14%, transparent);">
                        {{ $errors->first() }}
                    </div>
                @endif

                <ul class="dash-list" id="log-absen-list">
                    @forelse ($riwayat as $row)
                        <li class="dash-item log-item" data-label="{{ mb_strtolower($row->label) }}">
                            <div class="dash-card">
                                <span class="dash-card__name">Absensi Guru</span>
                                <span class="dash-card__meta">{{ $row->label }}</span>
                            </div>
                            <a href="{{ route('piket.absen.detail', ['tanggal' => $row->iso]) }}" class="dash-action" aria-label="Lihat absensi guru, {{ $row->label }}">
                                <img class="dash-icon" src="{{ asset('media/vector/edit-icon.png') }}" alt="" width="24" height="24">
                            </a>
                        </li>
                    @empty
                        <li class="dash-item"><div class="dash-card"><span class="dash-card__name">Belum ada riwayat absensi.</span></div></li>
                    @endforelse
                </ul>
            </div>
        </main>
    </div>

    <!-- Pop-up: Mulai Absensi (form). Placeholder teachers; the backend fills the rows. -->
    <div class="dash-modal" id="modal-absen" role="dialog" aria-modal="true" aria-labelledby="modal-absen-title">
        <form class="dash-modal__box dash-modal__box--wide" action="{{ route('piket.absen.simpan') }}" method="POST" tabindex="-1">
            @csrf
            <div class="dash-modal__head">
                <h2 class="dash-modal__title" id="modal-absen-title">Mulai Absensi</h2>
                <p style="margin: 0.25rem 0 0; color: var(--dash-muted); font-size: 0.9rem;">{{ $labelHariIni }}</p>
            </div>
            <div class="dash-modal__body dash-modal__body--table">
                <table class="dash-table">
                    <caption class="dash-sr">Daftar kehadiran guru</caption>
                    <thead>
                        <tr>
                            <th scope="col" rowspan="2">No.</th>
                            <th scope="col" rowspan="2" class="dash-table__name">Nama Guru</th>
                            <th scope="colgroup" colspan="2">Kehadiran</th>
                        </tr>
                        <tr>
                            <th scope="col">Hadir</th>
                            <th scope="col">Tidak Hadir</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($guruList as $i => $g)
                            @php $hadir = ($g->status ?? 'H') === 'H'; @endphp
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td class="dash-table__name">{{ $g->nama }}</td>
                                <td><input class="dash-check dash-check--ok" type="checkbox" name="kehadiran[{{ $g->kode_guru }}]" value="hadir" @checked($hadir) aria-label="Hadir: {{ $g->nama }}"></td>
                                <td><input class="dash-check dash-check--bad" type="checkbox" name="kehadiran[{{ $g->kode_guru }}]" value="tidak-hadir" @checked(!$hadir) aria-label="Tidak hadir: {{ $g->nama }}"></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="dash-modal__foot">
                <button type="button" class="dash-btn dash-btn--ghost" data-modal-close>Batal</button>
                <button type="submit" class="dash-btn">Simpan</button>
            </div>
        </form>
    </div>
    <script>
        function filterLog() {
            const q = document.getElementById('search-log').value.toLowerCase().trim();
            document.querySelectorAll('.log-item').forEach((li) => {
                li.style.display = (li.dataset.label || '').indexOf(q) > -1 ? '' : 'none';
            });
        }
    </script>
</body>
</html>
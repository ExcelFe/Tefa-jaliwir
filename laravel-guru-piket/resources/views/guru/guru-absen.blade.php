<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absen Siswa - Dashboard Guru - SMK TI Bali Global Badung</title>

    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/animation.css') }}">
    <script defer src="{{ asset('js/main.js') }}"></script>
    <script defer src="{{ asset('js/guru-absen-siswa.js') }}"></script>
    <script defer src="{{ asset('js/animation.js') }}"></script>
</head>
<body class="dash-body">
    <div class="dash">
        <!-- Dimmed area behind the sidebar on tablet/phone (click closes it) -->
        <div class="dash-scrim" data-sidebar-close></div>

        <!-- Sidebar: minimize + brand (top) | page menu (middle) | account + settings (bottom) -->
        <aside class="dash-sidebar" id="sidebar" aria-label="Menu guru">
            <div class="dash-sidebar__top">
                <button type="button" class="dash-icon-btn" data-sidebar-close aria-label="Tutup sidebar">
                    <img class="dash-icon" src="{{ asset('media/vector/minimize-icon.png') }}" alt="" width="24" height="24">
                </button>
                <span class="dash-brand">Globaliti Badung</span>
            </div>

            <nav class="dash-menu" aria-label="Halaman guru">
                <a class="dash-menu__item" href="{{ route('guru.jadwal') }}">
                    <img class="dash-icon" src="{{ asset('media/vector/jadwal-icon.png') }}" alt="" width="24" height="24">
                    Jadwal
                </a>
                <a class="dash-menu__item" href="{{ route('guru.absen') }}" aria-current="page">
                    <img class="dash-icon" src="{{ asset('media/vector/absensi-icon.png') }}" alt="" width="24" height="24">
                    Absen Siswa
                </a>
                <a class="dash-menu__item" href="{{ route('guru.jurnal') }}">
                    <img class="dash-icon" src="{{ asset('media/vector/jurnal-icon.png') }}" alt="" width="24" height="24">
                    Jurnal Kelas
                </a>
                <a class="dash-menu__item" href="{{ route('guru.rekap') }}">
                    <img class="dash-icon" src="{{ asset('media/vector/clipboard-icon.png') }}" alt="" width="24" height="24">
                    Rekap Absensi
                </a>
            </nav>

            <div class="dash-account">
                <div class="dash-account__info">
                    <span class="dash-avatar"><img class="dash-icon" src="{{ asset('media/vector/absensi-icon.png') }}" alt="" width="24" height="24"></span>
                    <span class="dash-account__name">{{ isset($guru) ? $guru->nama_guru : 'Nama Guru Mapel' }}</span>
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
                    <a class="dash-settings__item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form-absen').submit();">
                        <img class="dash-icon" src="{{ asset('media/vector/log-out-icon.png') }}" alt="" width="24" height="24">
                        Log Out
                    </a>
                    <form id="logout-form-absen" action="{{ route('logout') }}" method="POST" style="display:none;">
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
                        <h1 class="dash-title">Log Absensi</h1>
                    </div>
                    <div class="dash-tools">
                        <div class="dash-search" role="search">
                            <input type="search" placeholder="Search log" aria-label="Search log">
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
                <ul class="dash-list">
                    <li class="dash-item">
                        <div class="dash-card">
                            <span class="dash-card__name">XI PPLG 1</span>
                            <span class="dash-card__meta">Rabu, 14 Oktober 2026</span>
                        </div>
                        <button type="button" class="dash-action" aria-label="Edit absensi XI PPLG 1, Rabu, 14 Oktober 2026">
                            <img class="dash-icon" src="{{ asset('media/vector/edit-icon.png') }}" alt="" width="24" height="24">
                        </button>
                    </li>
                    <li class="dash-item">
                        <div class="dash-card">
                            <span class="dash-card__name">XI PPLG 2</span>
                            <span class="dash-card__meta">Rabu, 14 Oktober 2026</span>
                        </div>
                        <button type="button" class="dash-action" aria-label="Edit absensi XI PPLG 2, Rabu, 14 Oktober 2026">
                            <img class="dash-icon" src="{{ asset('media/vector/edit-icon.png') }}" alt="" width="24" height="24">
                        </button>
                    </li>
                    <li class="dash-item">
                        <div class="dash-card">
                            <span class="dash-card__name">XI DKV 1</span>
                            <span class="dash-card__meta">Selasa, 13 Oktober 2026</span>
                        </div>
                        <button type="button" class="dash-action" aria-label="Edit absensi XI DKV 1, Selasa, 13 Oktober 2026">
                            <img class="dash-icon" src="{{ asset('media/vector/edit-icon.png') }}" alt="" width="24" height="24">
                        </button>
                    </li>
                    <li class="dash-item">
                        <div class="dash-card">
                            <span class="dash-card__name">XI DKV 2</span>
                            <span class="dash-card__meta">Selasa, 13 Oktober 2026</span>
                        </div>
                        <button type="button" class="dash-action" aria-label="Edit absensi XI DKV 2, Selasa, 13 Oktober 2026">
                            <img class="dash-icon" src="{{ asset('media/vector/edit-icon.png') }}" alt="" width="24" height="24">
                        </button>
                    </li>
                    <li class="dash-item">
                        <div class="dash-card">
                            <span class="dash-card__name">XI TJKT</span>
                            <span class="dash-card__meta">Senin, 12 Oktober 2026</span>
                        </div>
                        <button type="button" class="dash-action" aria-label="Edit absensi XI TJKT, Senin, 12 Oktober 2026">
                            <img class="dash-icon" src="{{ asset('media/vector/edit-icon.png') }}" alt="" width="24" height="24">
                        </button>
                    </li>
                    <li class="dash-item">
                        <div class="dash-card">
                            <span class="dash-card__name">XI PPLG 1</span>
                            <span class="dash-card__meta">Jumat, 9 Oktober 2026</span>
                        </div>
                        <button type="button" class="dash-action" aria-label="Edit absensi XI PPLG 1, Jumat, 9 Oktober 2026">
                            <img class="dash-icon" src="{{ asset('media/vector/edit-icon.png') }}" alt="" width="24" height="24">
                        </button>
                    </li>
                    <li class="dash-item">
                        <div class="dash-card">
                            <span class="dash-card__name">XI PPLG 2</span>
                            <span class="dash-card__meta">Kamis, 8 Oktober 2026</span>
                        </div>
                        <button type="button" class="dash-action" aria-label="Edit absensi XI PPLG 2, Kamis, 8 Oktober 2026">
                            <img class="dash-icon" src="{{ asset('media/vector/edit-icon.png') }}" alt="" width="24" height="24">
                        </button>
                    </li>
                </ul>
            </div>
        </main>
    </div>

    <!-- Pop-up: Mulai Absensi (form). Placeholder students; the backend fills the rows. -->
    <div class="dash-modal" id="modal-absen" role="dialog" aria-modal="true" aria-labelledby="modal-absen-title">
        <form class="dash-modal__box dash-modal__box--wide" action="#" method="post" tabindex="-1">
            <div class="dash-modal__head">
                <h2 class="dash-modal__title" id="modal-absen-title">Mulai Absensi</h2>
            </div>
            <div class="dash-modal__body dash-modal__body--table">
                <table class="dash-table">
                    <caption class="dash-sr">Daftar kehadiran siswa</caption>
                    <thead>
                        <tr>
                            <th scope="col" rowspan="2">No.</th>
                            <th scope="col" rowspan="2" class="dash-table__name">Nama Siswa</th>
                            <th scope="colgroup" colspan="2">Kehadiran</th>
                        </tr>
                        <tr>
                            <th scope="col">Hadir</th>
                            <th scope="col">Tidak Hadir</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td class="dash-table__name">Aldo Jr. Juventus</td>
                            <td><input class="dash-check dash-check--ok" type="checkbox" name="kehadiran[1]" value="hadir" aria-label="Hadir: Aldo Jr. Juventus"></td>
                            <td><input class="dash-check dash-check--bad" type="checkbox" name="kehadiran[1]" value="tidak-hadir" aria-label="Tidak hadir: Aldo Jr. Juventus"></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td class="dash-table__name">I Made Dwi Saputra</td>
                            <td><input class="dash-check dash-check--ok" type="checkbox" name="kehadiran[2]" value="hadir" aria-label="Hadir: I Made Dwi Saputra"></td>
                            <td><input class="dash-check dash-check--bad" type="checkbox" name="kehadiran[2]" value="tidak-hadir" aria-label="Tidak hadir: I Made Dwi Saputra"></td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td class="dash-table__name">Ni Kadek Ayu Lestari</td>
                            <td><input class="dash-check dash-check--ok" type="checkbox" name="kehadiran[3]" value="hadir" aria-label="Hadir: Ni Kadek Ayu Lestari"></td>
                            <td><input class="dash-check dash-check--bad" type="checkbox" name="kehadiran[3]" value="tidak-hadir" aria-label="Tidak hadir: Ni Kadek Ayu Lestari"></td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td class="dash-table__name">Putu Rendra Wijaya</td>
                            <td><input class="dash-check dash-check--ok" type="checkbox" name="kehadiran[4]" value="hadir" aria-label="Hadir: Putu Rendra Wijaya"></td>
                            <td><input class="dash-check dash-check--bad" type="checkbox" name="kehadiran[4]" value="tidak-hadir" aria-label="Tidak hadir: Putu Rendra Wijaya"></td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td class="dash-table__name">Komang Sinta Dewi</td>
                            <td><input class="dash-check dash-check--ok" type="checkbox" name="kehadiran[5]" value="hadir" aria-label="Hadir: Komang Sinta Dewi"></td>
                            <td><input class="dash-check dash-check--bad" type="checkbox" name="kehadiran[5]" value="tidak-hadir" aria-label="Tidak hadir: Komang Sinta Dewi"></td>
                        </tr>
                        <tr>
                            <td>6</td>
                            <td class="dash-table__name">Gede Arya Pratama</td>
                            <td><input class="dash-check dash-check--ok" type="checkbox" name="kehadiran[6]" value="hadir" aria-label="Hadir: Gede Arya Pratama"></td>
                            <td><input class="dash-check dash-check--bad" type="checkbox" name="kehadiran[6]" value="tidak-hadir" aria-label="Tidak hadir: Gede Arya Pratama"></td>
                        </tr>
                        <tr>
                            <td>7</td>
                            <td class="dash-table__name">Ni Luh Maharani</td>
                            <td><input class="dash-check dash-check--ok" type="checkbox" name="kehadiran[7]" value="hadir" aria-label="Hadir: Ni Luh Maharani"></td>
                            <td><input class="dash-check dash-check--bad" type="checkbox" name="kehadiran[7]" value="tidak-hadir" aria-label="Tidak hadir: Ni Luh Maharani"></td>
                        </tr>
                        <tr>
                            <td>8</td>
                            <td class="dash-table__name">Bagus Eka Firmansyah</td>
                            <td><input class="dash-check dash-check--ok" type="checkbox" name="kehadiran[8]" value="hadir" aria-label="Hadir: Bagus Eka Firmansyah"></td>
                            <td><input class="dash-check dash-check--bad" type="checkbox" name="kehadiran[8]" value="tidak-hadir" aria-label="Tidak hadir: Bagus Eka Firmansyah"></td>
                        </tr>
                        <tr>
                            <td>9</td>
                            <td class="dash-table__name">Nadia Putri Anggraini</td>
                            <td><input class="dash-check dash-check--ok" type="checkbox" name="kehadiran[9]" value="hadir" aria-label="Hadir: Nadia Putri Anggraini"></td>
                            <td><input class="dash-check dash-check--bad" type="checkbox" name="kehadiran[9]" value="tidak-hadir" aria-label="Tidak hadir: Nadia Putri Anggraini"></td>
                        </tr>
                        <tr>
                            <td>10</td>
                            <td class="dash-table__name">Rizky Maulana Hakim</td>
                            <td><input class="dash-check dash-check--ok" type="checkbox" name="kehadiran[10]" value="hadir" aria-label="Hadir: Rizky Maulana Hakim"></td>
                            <td><input class="dash-check dash-check--bad" type="checkbox" name="kehadiran[10]" value="tidak-hadir" aria-label="Tidak hadir: Rizky Maulana Hakim"></td>
                        </tr>
                        <tr>
                            <td>11</td>
                            <td class="dash-table__name">Kadek Bayu Nugraha</td>
                            <td><input class="dash-check dash-check--ok" type="checkbox" name="kehadiran[11]" value="hadir" aria-label="Hadir: Kadek Bayu Nugraha"></td>
                            <td><input class="dash-check dash-check--bad" type="checkbox" name="kehadiran[11]" value="tidak-hadir" aria-label="Tidak hadir: Kadek Bayu Nugraha"></td>
                        </tr>
                        <tr>
                            <td>12</td>
                            <td class="dash-table__name">Ni Putu Ratna Sari</td>
                            <td><input class="dash-check dash-check--ok" type="checkbox" name="kehadiran[12]" value="hadir" aria-label="Hadir: Ni Putu Ratna Sari"></td>
                            <td><input class="dash-check dash-check--bad" type="checkbox" name="kehadiran[12]" value="tidak-hadir" aria-label="Tidak hadir: Ni Putu Ratna Sari"></td>
                        </tr>
                        <tr>
                            <td>13</td>
                            <td class="dash-table__name">Dimas Aditya Pramono</td>
                            <td><input class="dash-check dash-check--ok" type="checkbox" name="kehadiran[13]" value="hadir" aria-label="Hadir: Dimas Aditya Pramono"></td>
                            <td><input class="dash-check dash-check--bad" type="checkbox" name="kehadiran[13]" value="tidak-hadir" aria-label="Tidak hadir: Dimas Aditya Pramono"></td>
                        </tr>
                        <tr>
                            <td>14</td>
                            <td class="dash-table__name">Salsabila Nur Aini</td>
                            <td><input class="dash-check dash-check--ok" type="checkbox" name="kehadiran[14]" value="hadir" aria-label="Hadir: Salsabila Nur Aini"></td>
                            <td><input class="dash-check dash-check--bad" type="checkbox" name="kehadiran[14]" value="tidak-hadir" aria-label="Tidak hadir: Salsabila Nur Aini"></td>
                        </tr>
                        <tr>
                            <td>15</td>
                            <td class="dash-table__name">I Wayan Teguh Santosa</td>
                            <td><input class="dash-check dash-check--ok" type="checkbox" name="kehadiran[15]" value="hadir" aria-label="Hadir: I Wayan Teguh Santosa"></td>
                            <td><input class="dash-check dash-check--bad" type="checkbox" name="kehadiran[15]" value="tidak-hadir" aria-label="Tidak hadir: I Wayan Teguh Santosa"></td>
                        </tr>
                        <tr>
                            <td>16</td>
                            <td class="dash-table__name">Intan Permata Sari</td>
                            <td><input class="dash-check dash-check--ok" type="checkbox" name="kehadiran[16]" value="hadir" aria-label="Hadir: Intan Permata Sari"></td>
                            <td><input class="dash-check dash-check--bad" type="checkbox" name="kehadiran[16]" value="tidak-hadir" aria-label="Tidak hadir: Intan Permata Sari"></td>
                        </tr>
                        <tr>
                            <td>17</td>
                            <td class="dash-table__name">Fajar Ramadhan</td>
                            <td><input class="dash-check dash-check--ok" type="checkbox" name="kehadiran[17]" value="hadir" aria-label="Hadir: Fajar Ramadhan"></td>
                            <td><input class="dash-check dash-check--bad" type="checkbox" name="kehadiran[17]" value="tidak-hadir" aria-label="Tidak hadir: Fajar Ramadhan"></td>
                        </tr>
                        <tr>
                            <td>18</td>
                            <td class="dash-table__name">Ni Made Gita Kusuma</td>
                            <td><input class="dash-check dash-check--ok" type="checkbox" name="kehadiran[18]" value="hadir" aria-label="Hadir: Ni Made Gita Kusuma"></td>
                            <td><input class="dash-check dash-check--bad" type="checkbox" name="kehadiran[18]" value="tidak-hadir" aria-label="Tidak hadir: Ni Made Gita Kusuma"></td>
                        </tr>
                        <tr>
                            <td>19</td>
                            <td class="dash-table__name">Yoga Prasetya Adi</td>
                            <td><input class="dash-check dash-check--ok" type="checkbox" name="kehadiran[19]" value="hadir" aria-label="Hadir: Yoga Prasetya Adi"></td>
                            <td><input class="dash-check dash-check--bad" type="checkbox" name="kehadiran[19]" value="tidak-hadir" aria-label="Tidak hadir: Yoga Prasetya Adi"></td>
                        </tr>
                        <tr>
                            <td>20</td>
                            <td class="dash-table__name">Alya Zahra Safitri</td>
                            <td><input class="dash-check dash-check--ok" type="checkbox" name="kehadiran[20]" value="hadir" aria-label="Hadir: Alya Zahra Safitri"></td>
                            <td><input class="dash-check dash-check--bad" type="checkbox" name="kehadiran[20]" value="tidak-hadir" aria-label="Tidak hadir: Alya Zahra Safitri"></td>
                        </tr>
                        <tr>
                            <td>21</td>
                            <td class="dash-table__name">Kevin Ardiansyah</td>
                            <td><input class="dash-check dash-check--ok" type="checkbox" name="kehadiran[21]" value="hadir" aria-label="Hadir: Kevin Ardiansyah"></td>
                            <td><input class="dash-check dash-check--bad" type="checkbox" name="kehadiran[21]" value="tidak-hadir" aria-label="Tidak hadir: Kevin Ardiansyah"></td>
                        </tr>
                        <tr>
                            <td>22</td>
                            <td class="dash-table__name">Ni Komang Tri Wulandari</td>
                            <td><input class="dash-check dash-check--ok" type="checkbox" name="kehadiran[22]" value="hadir" aria-label="Hadir: Ni Komang Tri Wulandari"></td>
                            <td><input class="dash-check dash-check--bad" type="checkbox" name="kehadiran[22]" value="tidak-hadir" aria-label="Tidak hadir: Ni Komang Tri Wulandari"></td>
                        </tr>
                        <tr>
                            <td>23</td>
                            <td class="dash-table__name">Rafi Alfarizi</td>
                            <td><input class="dash-check dash-check--ok" type="checkbox" name="kehadiran[23]" value="hadir" aria-label="Hadir: Rafi Alfarizi"></td>
                            <td><input class="dash-check dash-check--bad" type="checkbox" name="kehadiran[23]" value="tidak-hadir" aria-label="Tidak hadir: Rafi Alfarizi"></td>
                        </tr>
                        <tr>
                            <td>24</td>
                            <td class="dash-table__name">Made Surya Dharma</td>
                            <td><input class="dash-check dash-check--ok" type="checkbox" name="kehadiran[24]" value="hadir" aria-label="Hadir: Made Surya Dharma"></td>
                            <td><input class="dash-check dash-check--bad" type="checkbox" name="kehadiran[24]" value="tidak-hadir" aria-label="Tidak hadir: Made Surya Dharma"></td>
                        </tr>
                        <tr>
                            <td>25</td>
                            <td class="dash-table__name">Citra Ayu Maharani</td>
                            <td><input class="dash-check dash-check--ok" type="checkbox" name="kehadiran[25]" value="hadir" aria-label="Hadir: Citra Ayu Maharani"></td>
                            <td><input class="dash-check dash-check--bad" type="checkbox" name="kehadiran[25]" value="tidak-hadir" aria-label="Tidak hadir: Citra Ayu Maharani"></td>
                        </tr>
                        <tr>
                            <td>26</td>
                            <td class="dash-table__name">Bima Satria Wibowo</td>
                            <td><input class="dash-check dash-check--ok" type="checkbox" name="kehadiran[26]" value="hadir" aria-label="Hadir: Bima Satria Wibowo"></td>
                            <td><input class="dash-check dash-check--bad" type="checkbox" name="kehadiran[26]" value="tidak-hadir" aria-label="Tidak hadir: Bima Satria Wibowo"></td>
                        </tr>
                        <tr>
                            <td>27</td>
                            <td class="dash-table__name">Putri Amelia Rahma</td>
                            <td><input class="dash-check dash-check--ok" type="checkbox" name="kehadiran[27]" value="hadir" aria-label="Hadir: Putri Amelia Rahma"></td>
                            <td><input class="dash-check dash-check--bad" type="checkbox" name="kehadiran[27]" value="tidak-hadir" aria-label="Tidak hadir: Putri Amelia Rahma"></td>
                        </tr>
                        <tr>
                            <td>28</td>
                            <td class="dash-table__name">Gusti Ngurah Aditya</td>
                            <td><input class="dash-check dash-check--ok" type="checkbox" name="kehadiran[28]" value="hadir" aria-label="Hadir: Gusti Ngurah Aditya"></td>
                            <td><input class="dash-check dash-check--bad" type="checkbox" name="kehadiran[28]" value="tidak-hadir" aria-label="Tidak hadir: Gusti Ngurah Aditya"></td>
                        </tr>
                        <tr>
                            <td>29</td>
                            <td class="dash-table__name">Dewi Kartika Sari</td>
                            <td><input class="dash-check dash-check--ok" type="checkbox" name="kehadiran[29]" value="hadir" aria-label="Hadir: Dewi Kartika Sari"></td>
                            <td><input class="dash-check dash-check--bad" type="checkbox" name="kehadiran[29]" value="tidak-hadir" aria-label="Tidak hadir: Dewi Kartika Sari"></td>
                        </tr>
                        <tr>
                            <td>30</td>
                            <td class="dash-table__name">Raka Mahendra</td>
                            <td><input class="dash-check dash-check--ok" type="checkbox" name="kehadiran[30]" value="hadir" aria-label="Hadir: Raka Mahendra"></td>
                            <td><input class="dash-check dash-check--bad" type="checkbox" name="kehadiran[30]" value="tidak-hadir" aria-label="Tidak hadir: Raka Mahendra"></td>
                        </tr>
                        <tr>
                            <td>31</td>
                            <td class="dash-table__name">Ni Luh Sekar Ayu</td>
                            <td><input class="dash-check dash-check--ok" type="checkbox" name="kehadiran[31]" value="hadir" aria-label="Hadir: Ni Luh Sekar Ayu"></td>
                            <td><input class="dash-check dash-check--bad" type="checkbox" name="kehadiran[31]" value="tidak-hadir" aria-label="Tidak hadir: Ni Luh Sekar Ayu"></td>
                        </tr>
                        <tr>
                            <td>32</td>
                            <td class="dash-table__name">Tegar Wijaksana</td>
                            <td><input class="dash-check dash-check--ok" type="checkbox" name="kehadiran[32]" value="hadir" aria-label="Hadir: Tegar Wijaksana"></td>
                            <td><input class="dash-check dash-check--bad" type="checkbox" name="kehadiran[32]" value="tidak-hadir" aria-label="Tidak hadir: Tegar Wijaksana"></td>
                        </tr>
                        <tr>
                            <td>33</td>
                            <td class="dash-table__name">Anisa Fitriani</td>
                            <td><input class="dash-check dash-check--ok" type="checkbox" name="kehadiran[33]" value="hadir" aria-label="Hadir: Anisa Fitriani"></td>
                            <td><input class="dash-check dash-check--bad" type="checkbox" name="kehadiran[33]" value="tidak-hadir" aria-label="Tidak hadir: Anisa Fitriani"></td>
                        </tr>
                        <tr>
                            <td>34</td>
                            <td class="dash-table__name">Kadek Dwi Mahardika</td>
                            <td><input class="dash-check dash-check--ok" type="checkbox" name="kehadiran[34]" value="hadir" aria-label="Hadir: Kadek Dwi Mahardika"></td>
                            <td><input class="dash-check dash-check--bad" type="checkbox" name="kehadiran[34]" value="tidak-hadir" aria-label="Tidak hadir: Kadek Dwi Mahardika"></td>
                        </tr>
                        <tr>
                            <td>35</td>
                            <td class="dash-table__name">Ayu Wulan Pertiwi</td>
                            <td><input class="dash-check dash-check--ok" type="checkbox" name="kehadiran[35]" value="hadir" aria-label="Hadir: Ayu Wulan Pertiwi"></td>
                            <td><input class="dash-check dash-check--bad" type="checkbox" name="kehadiran[35]" value="tidak-hadir" aria-label="Tidak hadir: Ayu Wulan Pertiwi"></td>
                        </tr>
                        <tr>
                            <td>36</td>
                            <td class="dash-table__name">Satria Nugraha Putra</td>
                            <td><input class="dash-check dash-check--ok" type="checkbox" name="kehadiran[36]" value="hadir" aria-label="Hadir: Satria Nugraha Putra"></td>
                            <td><input class="dash-check dash-check--bad" type="checkbox" name="kehadiran[36]" value="tidak-hadir" aria-label="Tidak hadir: Satria Nugraha Putra"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="dash-modal__foot">
                <button type="button" class="dash-btn dash-btn--ghost" data-modal-close>Batal</button>
                <button type="submit" class="dash-btn">Simpan</button>
            </div>
        </form>
    </div>
</body>
</html>
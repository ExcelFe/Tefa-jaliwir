
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Dashboard | Akademika</title>

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

:root {
    --primary: #2864f0;
    --primary-light: #eaf0ff;
    --sidebar: #111a30;
    --background: #f4f7fc;
    --text: #17233f;
    --muted: #8994ad;
    --border: #e8edf5;
    --white: #ffffff;
    --green: #10b981;
}

body {
    font-family: Arial, Helvetica, sans-serif;
    background: var(--background);
    color: var(--text);
}

button, input, select {
    font: inherit;
}

button {
    cursor: pointer;
}

.app {
    display: flex;
    min-height: 100vh;
}

/* SIDEBAR */
.sidebar {
    width: 250px;
    background: var(--sidebar);
    color: white;
    padding: 28px 16px;
    display: flex;
    flex-direction: column;
    flex-shrink: 0;
}

.brand {
    padding: 0 12px 30px;
}

.brand h2 {
    color: #6090ff;
    font-size: 23px;
    letter-spacing: -1px;
}

.brand p {
    color: #a5b1cb;
    font-size: 12px;
    margin-top: 7px;
}

.nav-label {
    color: #8999b8;
    font-size: 10px;
    font-weight: bold;
    margin: 24px 12px 10px;
    letter-spacing: 1px;
}

.nav-link {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 13px 12px;
    color: #c5cee1;
    text-decoration: none;
    font-size: 13px;
    border-radius: 9px;
    margin: 3px 0;
    transition: .2s;
}

.nav-link:hover,
.nav-link.active {
    background: var(--primary);
    color: white;
}

.nav-icon {
    width: 22px;
    text-align: center;
    font-size: 17px;
}

.sidebar-bottom {
    margin-top: auto;
    padding-top: 20px;
    border-top: 1px solid #2b3550;
}

/* MAIN */
.main {
    flex: 1;
    min-width: 0;
}

.topbar {
    background: white;
    padding: 18px 30px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 18px;
    border-bottom: 1px solid var(--border);
}

.search {
    width: min(480px, 60%);
    padding: 12px 15px;
    background: #f3f6fc;
    border: 1px solid transparent;
    border-radius: 10px;
    outline: none;
}

.search:focus {
    border-color: var(--primary);
}

.admin-profile {
    display: flex;
    align-items: center;
    gap: 12px;
    font-size: 13px;
}

.avatar {
    display: grid;
    place-items: center;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: var(--primary);
    color: white;
    font-weight: bold;
    font-size: 17px;
}

.admin-profile small {
    display: block;
    color: var(--muted);
    margin-top: 4px;
}

.content {
    padding: 30px;
    max-width: 1600px;
    margin: auto;
}

.welcome {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 15px;
    margin-bottom: 27px;
}

.welcome h1 {
    font-size: 25px;
    margin-bottom: 8px;
}

.welcome p {
    color: var(--muted);
    font-size: 13px;
}

.date {
    text-align: right;
    font-size: 13px;
    color: #65728d;
    line-height: 1.8;
}

/* STATISTICS */
.stats {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 16px;
    margin-bottom: 22px;
}

.card {
    background: white;
    border: 1px solid var(--border);
    border-radius: 13px;
    padding: 22px;
    box-shadow: 0 5px 20px rgba(30, 53, 100, .025);
    min-width: 0;
}

.stat-card {
    display: flex;
    align-items: center;
    gap: 15px;
}

.stat-icon {
    width: 49px;
    height: 49px;
    border-radius: 12px;
    display: grid;
    place-items: center;
    font-size: 23px;
    flex-shrink: 0;
}

.blue { background: #e5edff; color: #2864f0; }
.purple { background: #f0e6ff; color: #8b43ed; }
.green { background: #d9f9ec; color: #0ca678; }
.orange { background: #ffead9; color: #ed7b19; }

.stat-card p {
    color: var(--muted);
    font-size: 12px;
    margin-bottom: 8px;
}

.stat-card h2 {
    font-size: 27px;
}

.stat-card small {
    display: block;
    color: var(--green);
    font-size: 11px;
    margin-top: 6px;
}

/* SECTION LAYOUT */
.grid-main {
    display: grid;
    grid-template-columns: minmax(0, 1.65fr) minmax(280px, 1fr);
    gap: 18px;
    margin-bottom: 18px;
}

.section-title {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 10px;
    margin-bottom: 20px;
}

.section-title h3 {
    font-size: 16px;
}

.section-title a {
    font-size: 12px;
    color: var(--primary);
    text-decoration: none;
}

.pill {
    background: var(--primary-light);
    color: var(--primary);
    padding: 7px 10px;
    border-radius: 20px;
    font-size: 10px;
    white-space: nowrap;
}

/* TABLE */
.table-wrap {
    overflow-x: auto;
}

table {
    width: 100%;
    border-collapse: collapse;
    font-size: 12px;
    white-space: nowrap;
}

thead {
    background: #f5f8fd;
}

th {
    color: #697791;
    font-weight: 600;
    text-align: left;
}

th, td {
    padding: 14px 12px;
    border-bottom: 1px solid #edf1f7;
}

tbody tr:hover {
    background: #f8faff;
}

.status {
    padding: 6px 10px;
    border-radius: 20px;
    font-size: 10px;
}

.status-active {
    background: #dcfce9;
    color: #078552;
}

.status-wait {
    background: #fff1d6;
    color: #bd7100;
}

/* CHART */
.chart {
    height: 205px;
    display: flex;
    align-items: flex-end;
    justify-content: space-around;
    gap: 15px;
    border-bottom: 1px solid var(--border);
    padding: 15px 0 0;
    background: repeating-linear-gradient(
        to bottom,
        transparent 0,
        transparent 48px,
        #edf1f8 49px,
        transparent 50px
    );
}

.chart-day {
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: flex-end;
    height: 100%;
    gap: 8px;
}

.bars {
    height: 150px;
    display: flex;
    align-items: flex-end;
    gap: 5px;
}

.bar {
    width: 13px;
    border-radius: 5px 5px 0 0;
    background: #3772f5;
}

.bar.absent {
    background: #a995ff;
}

.chart-day small {
    color: var(--muted);
    font-size: 10px;
    padding-bottom: 8px;
}

.legend {
    display: flex;
    justify-content: center;
    gap: 18px;
    margin-top: 20px;
    font-size: 11px;
    color: #697791;
}

.legend span::before {
    content: "";
    display: inline-block;
    width: 9px;
    height: 9px;
    border-radius: 50%;
    background: #3772f5;
    margin-right: 6px;
}

.legend .absent-legend::before {
    background: #a995ff;
}

/* LOWER CARDS */
.grid-bottom {
    display: grid;
    grid-template-columns: minmax(0, 1.4fr) minmax(260px, 1fr);
    gap: 18px;
}

.tabs {
    display: flex;
    gap: 22px;
    border-bottom: 1px solid var(--border);
    margin-bottom: 15px;
}

.tab {
    padding: 10px 0;
    border: none;
    border-bottom: 3px solid transparent;
    color: var(--muted);
    background: none;
    font-size: 12px;
}

.tab.active {
    color: var(--primary);
    border-color: var(--primary);
}

.class-item {
    margin-bottom: 25px;
}

.class-label {
    display: flex;
    justify-content: space-between;
    font-size: 12px;
    margin-bottom: 10px;
}

.class-label span:last-child {
    color: var(--muted);
}

.progress {
    background: #edf1fa;
    height: 9px;
    border-radius: 10px;
    overflow: hidden;
}

.progress div {
    height: 100%;
    border-radius: inherit;
    background: var(--primary);
}

.activity {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    padding: 16px 0;
    border-bottom: 1px solid var(--border);
}

.activity:last-child {
    border-bottom: none;
}

.activity-icon {
    width: 37px;
    height: 37px;
    border-radius: 50%;
    display: grid;
    place-items: center;
    flex-shrink: 0;
}

.activity-text {
    flex: 1;
    font-size: 12px;
    line-height: 1.7;
}

.activity-text p {
    color: var(--muted);
}

.activity time {
    color: var(--muted);
    font-size: 10px;
    padding-top: 4px;
}

/* MOBILE */
.menu-toggle {
    display: none;
    border: none;
    background: none;
    font-size: 24px;
    color: var(--text);
}

@media (max-width: 1100px) {
    .sidebar {
        width: 220px;
    }

    .stats {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }

    .grid-main,
    .grid-bottom {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 700px) {
    .sidebar {
        position: fixed;
        z-index: 10;
        inset: 0 auto 0 0;
        width: 250px;
        transform: translateX(-100%);
        transition: transform .25s;
        overflow-y: auto;
    }

    .sidebar.open {
        transform: translateX(0);
    }

    .menu-toggle {
        display: block;
    }

    .topbar {
        padding: 14px 16px;
    }

    .search {
        width: 100%;
        font-size: 12px;
    }

    .admin-profile > div:last-child {
        display: none;
    }

    .content {
        padding: 20px 14px;
    }

    .welcome {
        align-items: flex-start;
    }

    .welcome h1 {
        font-size: 21px;
    }

    .welcome p {
        line-height: 1.6;
    }

    .date {
        display: none;
    }

    .stats {
        gap: 10px;
    }

    .stat-card {
        padding: 14px;
        gap: 10px;
    }

    .stat-icon {
        width: 37px;
        height: 37px;
        font-size: 18px;
    }

    .stat-card h2 {
        font-size: 22px;
    }

    .stat-card p {
        font-size: 11px;
    }

    .card {
        padding: 17px 13px;
    }

    .section-title h3 {
        font-size: 14px;
    }

    .grid-main,
    .grid-bottom {
        gap: 13px;
    }
}
</style>
</head>

<body>
<div class="app">

    <aside class="sidebar" id="sidebar">
        <div class="brand">
            <h2>AKADEMIKA.</h2>
            <p>Sistem Informasi Akademik</p>
        </div>

        <nav>
            <a href="#dashboard" class="nav-link active">
                <span class="nav-icon">▦</span> Dashboard
            </a>

            <div class="nav-label">DATA MASTER</div>
            <a href="#siswa" class="nav-link"><span class="nav-icon">♙</span> Data Siswa</a>
            <a href="#guru" class="nav-link"><span class="nav-icon">♟</span> Data Guru</a>
            <a href="#kelas" class="nav-link"><span class="nav-icon">⌂</span> Data Kelas</a>
            <a href="#mapel" class="nav-link"><span class="nav-icon">▤</span> Data Mapel</a>
            <a href="#jadwal" class="nav-link"><span class="nav-icon">▦</span> Data Jadwal</a>

            <div class="nav-label">AKTIVITAS</div>
            <a href="#absensi" class="nav-link"><span class="nav-icon">☑</span> Absensi</a>
            <a href="#nilai" class="nav-link"><span class="nav-icon">▧</span> Nilai</a>
            <a href="#jurnal" class="nav-link"><span class="nav-icon">▣</span> Jurnal Guru</a>

            <div class="nav-label">LAPORAN</div>
            <a href="#rekap-absensi" class="nav-link"><span class="nav-icon">▥</span> Rekap Absensi</a>
            <a href="#rekap-nilai" class="nav-link"><span class="nav-icon">▥</span> Rekap Nilai</a>
        </nav>

        <div class="sidebar-bottom">
            <a href="#pengaturan" class="nav-link"><span class="nav-icon">⚙</span> Pengaturan</a>
        </div>
    </aside>

    <main class="main" id="dashboard">
        <header class="topbar">
            <button class="menu-toggle" id="menuToggle" aria-label="Buka menu">☰</button>

            <input class="search" id="searchInput"
                type="search" placeholder="Cari siswa, guru, atau data lainnya...">

            <div class="admin-profile">
                <div class="avatar">A</div>
                <div>
                    <strong>Administrator</strong>
                    <small>Admin Akademika</small>
                </div>
            </div>
        </header>

        <div class="content">
            <section class="welcome">
                <div>
                    <h1>Selamat datang, Admin! 👋</h1>
                    <p>Berikut ringkasan data dan aktivitas akademik sekolah.</p>
                </div>
                <div class="date">
                    <div id="currentDate">Memuat tanggal...</div>
                    <strong id="currentTime">--:--:--</strong>
                </div>
            </section>

            <section class="stats">
                <div class="card stat-card">
                    <div class="stat-icon blue">♟</div>
                    <div>
                        <p>Total Siswa</p>
                        <h2>25</h2>
                        <small>↗ Data siswa terdaftar</small>
                    </div>
                </div>

                <div class="card stat-card">
                    <div class="stat-icon purple">♟</div>
                    <div>
                        <p>Total Guru</p>
                        <h2>3</h2>
                        <small>↗ Data pengajar</small>
                    </div>
                </div>

                <div class="card stat-card">
                    <div class="stat-icon green">▦</div>
                    <div>
                        <p>Total Kelas</p>
                        <h2>3</h2>
                        <small>↗ Kelas aktif</small>
                    </div>
                </div>

                <div class="card stat-card">
                    <div class="stat-icon orange">▤</div>
                    <div>
                        <p>Total Mapel</p>
                        <h2>8</h2>
                        <small>↗ Mata pelajaran</small>
                    </div>
                </div>
            </section>

            <section class="grid-main">
                <div class="card">
                    <div class="section-title">
                        <h3>▦ &nbsp; Jadwal Hari Ini</h3>
                        <span class="pill" id="scheduleDate">Hari ini</span>
                    </div>

                    <div class="table-wrap">
                        <table id="scheduleTable">
                            <thead>
                                <tr>
                                    <th>Waktu</th>
                                    <th>Mata Pelajaran</th>
                                    <th>Kelas</th>
                                    <th>Guru</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr data-search="ilmu hitam x pplg 1 asep">
                                    <td>08:00 - 08:30</td>
                                    <td>🔵 Ilmu Hitam</td>
                                    <td>X PPLG 1</td>
                                    <td>Pak Asep</td>
                                    <td><span class="status status-active">Berlangsung</span></td>
                                </tr>
                                <tr data-search="bahasa alien x pplg 1 sinta">
                                    <td>08:30 - 09:15</td>
                                    <td>🟣 Bahasa Alien</td>
                                    <td>X PPLG 1</td>
                                    <td>Bu Sinta</td>
                                    <td><span class="status status-wait">Menunggu</span></td>
                                </tr>
                                <tr data-search="bahasa anjing x pplg 1 budi">
                                    <td>09:15 - 10:00</td>
                                    <td>🔴 Bahasa Anjing</td>
                                    <td>X PPLG 1</td>
                                    <td>Pak Budi</td>
                                    <td><span class="status status-wait">Menunggu</span></td>
                                </tr>
                                <tr data-search="pemrograman web x pplg 1 budi">
                                    <td>10:00 - 10:45</td>
                                    <td>🟢 Pemrograman Web</td>
                                    <td>X PPLG 1</td>
                                    <td>Pak Budi</td>
                                    <td><span class="status status-wait">Menunggu</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <p style="margin-top:18px;font-size:12px;color:#2864f0">
                        Jadwal contoh untuk tampilan UI.
                    </p>
                </div>

                <div class="card">
                    <div class="section-title">
                        <h3>▥ &nbsp; Grafik Kehadiran</h3>
                        <select id="chartPeriod" style="border:1px solid #e8edf5;padding:7px;border-radius:8px;color:#697791;font-size:11px">
                            <option value="week">Minggu ini</option>
                            <option value="month">Bulan ini</option>
                        </select>
                    </div>

                    <div class="chart" id="attendanceChart">
                        <div class="chart-day">
                            <div class="bars"><div class="bar" style="height:85%"></div><div class="bar absent" style="height:30%"></div></div>
                            <small>Sen</small>
                        </div>
                        <div class="chart-day">
                            <div class="bars"><div class="bar" style="height:82%"></div><div class="bar absent" style="height:22%"></div></div>
                            <small>Sel</small>
                        </div>
                        <div class="chart-day">
                            <div class="bars"><div class="bar" style="height:79%"></div><div class="bar absent" style="height:27%"></div></div>
                            <small>Rab</small>
                        </div>
                        <div class="chart-day">
                            <div class="bars"><div class="bar" style="height:90%"></div><div class="bar absent" style="height:34%"></div></div>
                            <small>Kam</small>
                        </div>
                        <div class="chart-day">
                            <div class="bars"><div class="bar" style="height:88%"></div><div class="bar absent" style="height:24%"></div></div>
                            <small>Jum</small>
                        </div>
                        <div class="chart-day">
                            <div class="bars"><div class="bar" style="height:92%"></div><div class="bar absent" style="height:30%"></div></div>
                            <small>Sab</small>
                        </div>
                    </div>

                    <div class="legend">
                        <span>Hadir</span>
                        <span class="absent-legend">Tidak hadir</span>
                    </div>
                </div>
            </section>

            <section class="grid-bottom">
                <div class="card">
                    <div class="section-title">
                        <h3>♟ &nbsp; Data Terbaru</h3>
                    </div>

                    <div class="tabs">
                        <button class="tab active" data-tab="siswa">Siswa Terbaru</button>
                        <button class="tab" data-tab="guru">Guru Terbaru</button>
                        <button class="tab" data-tab="jadwal">Jadwal Terbaru</button>
                    </div>

                    <div class="table-wrap">
                        <table id="latestTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Identitas</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody id="latestBody">
                                <tr><td>1</td><td>Excel Febriano</td><td>123456</td><td>X PPLG 1</td></tr>
                                <tr><td>2</td><td>Riko Alfarizi</td><td>123457</td><td>X PPLG 1</td></tr>
                                <tr><td>3</td><td>Alya Putri</td><td>123458</td><td>X PPLG 2</td></tr>
                                <tr><td>4</td><td>Fahri Ramadhan</td><td>123459</td><td>X PPLG 2</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card">
                    <div class="section-title">
                        <h3>▥ &nbsp; Statistik Kelas</h3>
                    </div>

                    <div class="class-item">
                        <div class="class-label"><strong>X PPLG 1</strong><span>8 / 10 siswa</span></div>
                        <div class="progress"><div style="width:80%"></div></div>
                    </div>

                    <div class="class-item">
                        <div class="class-label"><strong>X PPLG 2</strong><span>9 / 10 siswa</span></div>
                        <div class="progress"><div style="width:90%;background:#8b43ed"></div></div>
                    </div>

                    <div class="class-item">
                        <div class="class-label"><strong>X PPLG 3</strong><span>8 / 10 siswa</span></div>
                        <div class="progress"><div style="width:80%;background:#0ca678"></div></div>
                    </div>
                </div>
            </section>

            <section class="card" style="margin-top:18px">
                <div class="section-title">
                    <h3>◷ &nbsp; Aktivitas Terbaru</h3>
                    <a href="#aktivitas">Lihat semua →</a>
                </div>

                <div class="activity">
                    <div class="activity-icon green">♟</div>
                    <div class="activity-text">
                        <strong>Siswa baru terdaftar</strong>
                        <p>Excel Febriano · X PPLG 1</p>
                    </div>
                    <time>08:20</time>
                </div>

                <div class="activity">
                    <div class="activity-icon purple">▤</div>
                    <div class="activity-text">
                        <strong>Guru mengisi jurnal</strong>
                        <p>Pak Budi · X PPLG 1</p>
                    </div>
                    <time>07:45</time>
                </div>

                <div class="activity">
                    <div class="activity-icon blue">☑</div>
                    <div class="activity-text">
                        <strong>Absensi siswa</strong>
                        <p>X PPLG 1 · Data contoh</p>
                    </div>
                    <time>07:30</time>
                </div>
            </section>

            <footer style="text-align:center;color:#8994ad;font-size:11px;padding:28px 0 8px">
                © 2026 Akademika · Sistem Informasi Akademik
            </footer>
        </div>
    </main>
</div>

<script>
// Tanggal dan jam aktual dari perangkat
function updateClock() {
    const now = new Date();

    document.getElementById('currentDate').textContent =
        new Intl.DateTimeFormat('id-ID', {
            weekday: 'long',
            day: 'numeric',
            month: 'long',
            year: 'numeric'
        }).format(now);

    document.getElementById('currentTime').textContent =
        now.toLocaleTimeString('id-ID', { hour12: false });

    document.getElementById('scheduleDate').textContent =
        new Intl.DateTimeFormat('id-ID', {
            day: 'numeric',
            month: 'short',
            year: 'numeric'
        }).format(now);
}

updateClock();
setInterval(updateClock, 1000);

// Sidebar mobile
document.getElementById('menuToggle').addEventListener('click', () => {
    document.getElementById('sidebar').classList.toggle('open');
});

// Navigasi aktif
document.querySelectorAll('.nav-link').forEach(link => {
    link.addEventListener('click', () => {
        document.querySelectorAll('.nav-link').forEach(item => {
            item.classList.remove('active');
        });

        link.classList.add('active');

        if (window.innerWidth <= 700) {
            document.getElementById('sidebar').classList.remove('open');
        }
    });
});

// Pencarian jadwal berdasarkan teks
document.getElementById('searchInput').addEventListener('input', event => {
    const query = event.target.value.toLowerCase();

    document.querySelectorAll('#scheduleTable tbody tr').forEach(row => {
        row.style.display = row.textContent.toLowerCase().includes(query)
            ? ''
            : 'none';
    });
});

// Tab data terbaru
const latestData = {
    siswa: [
        ['1', 'Excel Febriano', '123456', 'X PPLG 1'],
        ['2', 'Riko Alfarizi', '123457', 'X PPLG 1'],
        ['3', 'Alya Putri', '123458', 'X PPLG 2'],
        ['4', 'Fahri Ramadhan', '123459', 'X PPLG 2']
    ],
    guru: [
        ['1', 'Budi Santoso', '1987654321', 'Guru'],
        ['2', 'Sinta', '1987654322', 'Guru'],
        ['3', 'Asep', '1987654323', 'Guru']
    ],
    jadwal: [
        ['1', 'Ilmu Hitam', '08:00 - 08:30', 'X PPLG 1'],
        ['2', 'Bahasa Alien', '08:30 - 09:15', 'X PPLG 1'],
        ['3', 'Bahasa Anjing', '09:15 - 10:00', 'X PPLG 1']
    ]
};

function renderLatest(tab) {
    document.getElementById('latestBody').innerHTML =
        latestData[tab].map(row =>
            '<tr>' + row.map(cell =>
                '<td>' + escapeHTML(cell) + '</td>'
            ).join('') + '</tr>'
        ).join('');
}

function escapeHTML(value) {
    return String(value).replace(/[&<>"']/g, char => ({
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#39;'
    })[char]);
}

document.querySelectorAll('.tab').forEach(button => {
    button.addEventListener('click', () => {
        document.querySelectorAll('.tab').forEach(tab => {
            tab.classList.remove('active');
        });

        button.classList.add('active');
        renderLatest(button.dataset.tab);
    });
});

// Simulasi perubahan grafik saat periode dipilih
document.getElementById('chartPeriod').addEventListener('change', event => {
    const bars = document.querySelectorAll('.bar:not(.absent)');

    bars.forEach((bar, index) => {
        const heights = event.target.value === 'month'
            ? [75, 88, 82, 95, 86, 90]
            : [85, 82, 79, 90, 88, 92];

        bar.style.height = heights[index] + '%';
    });
});
</script>
</body>
</html>
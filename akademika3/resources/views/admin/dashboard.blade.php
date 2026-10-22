<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard Admin - SMK TI Bali Global Badung</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Anton&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <!-- Font Awesome (icon) -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
  <link rel="stylesheet" href="../../css/dashboard.css">
</head>
<body>

<!-- ================= SIDEBAR (dibuka lewat ikon profil di kiri atas) ================= -->
<div id="overlay" class="overlay" data-sidebar-close></div>
<aside id="sidebar" class="sidebar" aria-label="Menu profil">
  <div class="sb-head">
    <span class="avatar"><i class="fa-solid fa-user"></i></span>
    <div><strong data-slot="user-nama">Nama Pengguna</strong><small data-slot="user-role">Admin</small></div>
  </div>
  <nav class="sb-nav">
      <a href="#" class="is-active"><i class="fa-solid fa-house"></i>Beranda</a>
      <button type="button" data-modal-open="modal-piket"><i class="fa-solid fa-user-check"></i>Pilih Guru Piket</button>
      <button type="button" data-modal-open="modal-rekap-guru"><i class="fa-solid fa-chart-column"></i>Rekap Absensi Guru</button>
      <button type="button" data-modal-open="modal-web"><i class="fa-solid fa-globe"></i>Website Dinamis</button>
      <button type="button" data-modal-open="modal-rekap-siswa"><i class="fa-solid fa-table-list"></i>Rekap Absensi Siswa</button>
  </nav>
  <div class="sb-foot"><a href="#" id="logoutTrigger"><i class="fa-solid fa-right-from-bracket"></i>Keluar</a></div>
</aside>
<header class="topbar">
  <button type="button" class="avatar" data-sidebar-open aria-label="Buka menu profil"><i class="fa-solid fa-user"></i></button>
  <div class="topbar-brand">SMK TI<span>Bali Global Badung &middot; Admin</span></div>
</header>

  <main class="page">
    <section class="section">
      <h2 class="section-title">Fitur Khusus</h2>
      <div class="tiles">
      <button type="button" class="tile" data-modal-open="modal-piket">
        <span class="tile-icon g-blue"><i class="fa-solid fa-user-check"></i></span>Pilih Guru Piket
      </button>
      <button type="button" class="tile" data-modal-open="modal-rekap-guru">
        <span class="tile-icon g-sky"><i class="fa-solid fa-chart-column"></i></span>Rekap Absensi Guru
      </button>
      <button type="button" class="tile" data-modal-open="modal-web">
        <span class="tile-icon g-navy"><i class="fa-solid fa-globe"></i></span>Website Dinamis
      </button>
      <button type="button" class="tile" data-modal-open="modal-rekap-siswa">
        <span class="tile-icon g-teal"><i class="fa-solid fa-table-list"></i></span>Rekap Absensi Siswa
      </button>
    </div>
    </section>

    <!-- STATUS GURU: data dari DB -> data-render="guruStatus" (lihat data-mock.js), atau isi data-endpoint -->
    <section class="section section-left" id="status-guru-wrap">
      <h2 class="section-title">Status Guru</h2>
      <div class="panel">
        <div class="panel-head"><label class="search"><i class="fa-solid fa-magnifying-glass"></i><input type="search" placeholder="Cari guru..." data-filter="#status-guru"></label></div>
        <ul class="list" id="status-guru" data-render="guruStatus" data-template="tpl-guru-status" data-endpoint=""></ul>
      </div>
      <!-- href: halaman status guru lengkap (backend) -->
      <a class="more-link" href="#">Selengkapnya&hellip;</a>
    </section>
  </main>

<template id="tpl-guru-status">
  <li class="list-row"><div><strong>nama</strong><small>mapel</small></div><span class="badge statusClass">statusLabel</span></li>
</template>

<!-- ===== POPUP: Pilih Guru Piket<br>untuk hari ini ===== -->
<div class="modal" id="modal-piket" hidden role="dialog" aria-modal="true" aria-labelledby="modal-piket-title">
  <div class="modal-box">
    <button type="button" class="modal-close" data-modal-close aria-label="Tutup"><i class="fa-solid fa-xmark"></i></button>
    <h2 class="modal-title" id="modal-piket-title">Pilih Guru Piket<br>untuk hari ini</h2>
    <!-- CSRF / action: isi oleh backend -->
    <form action="#" method="post">
      <div class="field"><label for="piket-tanggal">Hari / Tanggal</label>
        <input class="input" type="date" id="piket-tanggal" name="tanggal" data-today required></div>
      <div class="field"><label for="piket-guru">Pilih Guru Piket</label>
        <!-- dropdown yang bisa diketik: opsi dari data guruList -->
        <input class="input" list="dl-guru" id="piket-guru" name="guru_piket" placeholder="Ketik atau pilih guru..." autocomplete="off" required>
        <datalist id="dl-guru" data-render="guruList" data-template="tpl-option-guru"></datalist></div>
      <button type="submit" class="btn btn-block">Berikan Akses</button>
    </form>
    <div class="or">ATAU</div>
    <div class="field"><label for="kode-unik">Buat Kode Unik</label>
      <div class="copy-field">
        <input class="input" id="kode-unik" type="text" readonly placeholder="Klik &quot;Buat kode&quot;">
        <button type="button" class="copy-btn" data-copy="kode-unik" aria-label="Salin kode"><i class="fa-regular fa-copy"></i></button>
      </div>
      <!-- tombol ini hanya placeholder: kode asli dibuat backend -->
      <button type="button" class="link-btn" data-gen-code="kode-unik"><i class="fa-solid fa-wand-magic-sparkles"></i> Buat kode</button>
    </div>
  </div>
</div>

<!-- ===== POPUP: modal-rekap-guru ===== -->
<div class="modal" id="modal-rekap-guru" hidden role="dialog" aria-modal="true" aria-labelledby="modal-rekap-guru-title">
  <div class="modal-box">
    <button type="button" class="modal-close" data-modal-close aria-label="Tutup"><i class="fa-solid fa-xmark"></i></button>
    <h2 class="modal-title" id="modal-rekap-guru-title">Rekap Absensi Guru</h2>
    <div class="center-msg">
      <i class="fa-solid fa-file-excel ico"></i>
      <p>Unduh Spreadsheets untuk melihat rekapan absensi guru</p>
      <!-- href: ganti dengan URL export dari backend. Sudah ada atribut download -->
      <a class="btn btn-light" href="#" download="rekap-absensi-guru.xlsx"><i class="fa-solid fa-download"></i> Unduh Spreadsheets</a>
    </div>
  </div>
</div>

<!-- ===== POPUP: modal-rekap-siswa ===== -->
<div class="modal" id="modal-rekap-siswa" hidden role="dialog" aria-modal="true" aria-labelledby="modal-rekap-siswa-title">
  <div class="modal-box">
    <button type="button" class="modal-close" data-modal-close aria-label="Tutup"><i class="fa-solid fa-xmark"></i></button>
    <h2 class="modal-title" id="modal-rekap-siswa-title">Rekap Absensi Siswa</h2>
    <div class="center-msg">
      <i class="fa-solid fa-file-excel ico"></i>
      <p>Unduh Spreadsheets untuk melihat rekapan absensi siswa</p>
      <!-- href: ganti dengan URL export dari backend. Sudah ada atribut download -->
      <a class="btn btn-light" href="#" download="rekap-absensi-siswa.xlsx"><i class="fa-solid fa-download"></i> Unduh Spreadsheets</a>
    </div>
  </div>
</div>

<!-- ===== POPUP: Website Dinamis ===== -->
<div class="modal" id="modal-web" hidden role="dialog" aria-modal="true" aria-labelledby="modal-web-title">
  <div class="modal-box">
    <button type="button" class="modal-close" data-modal-close aria-label="Tutup"><i class="fa-solid fa-xmark"></i></button>
    <h2 class="modal-title" id="modal-web-title">Website Dinamis</h2>
    <!-- PLACEHOLDER: belum ada wireframe untuk bagian ini -->
    <div class="center-msg">
      <i class="fa-solid fa-globe ico"></i>
      <p>Kelola konten website sekolah (profil, berita, galeri).</p>
      <a class="btn" href="#"><i class="fa-solid fa-arrow-up-right-from-square"></i> Buka Pengelola Website</a>
    </div>
  </div>
</div>

<template id="tpl-option-guru"><option value="nama"></option></template>

<!-- ========================= -->
    <!-- HTML POPUP MODAL LOGOUT   -->
    <!-- ========================= -->
    <div id="logoutModal" class="modal-overlay">
        <div class="modal-container">
            <div class="modal-content">
                <!-- SVG Ikon Peringatan -->
                <svg class="warning-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
                <p class="modal-text">Apakah anda yakin ingin Log Out?</p>
            </div>
            <div class="modal-actions">
                <button class="btn btn-yes" id="confirmLogout">Ya</button>
                <button class="btn btn-no" id="cancelLogout">Tidak</button>
            </div>
        </div>
    </div>

<!-- ================= FOOTER ================= -->
<footer class="footer">
  <div class="footer-inner">
    <p>&copy; 2026 <span class="brand-link">SMK Ti Bali Global Badung</span>. All rights reserved</p>
    <div class="footer-links"><a href="#">Kebijakan privasi</a><a href="#">Syarat &amp; Ketentuan</a></div>
  </div>
</footer>

<script src="../../js/data-mock.js"></script>
<script src="../../js/dashboard-afterlog.js"></script>
</body>
</html>

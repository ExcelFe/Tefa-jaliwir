<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard Siswa - SMK TI Bali Global Badung</title>
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
    <div><strong data-slot="user-nama">Nama Pengguna</strong><small data-slot="user-role">Siswa</small></div>
  </div>
  <nav class="sb-nav">
      <a href="#" class="is-active"><i class="fa-solid fa-house"></i>Beranda</a>
      <a href="#jadwal"><i class="fa-solid fa-calendar-days"></i>Jadwal Hari Ini</a>
      <a href="#status-guru-wrap"><i class="fa-solid fa-user-tie"></i>Status Guru</a>
  </nav>
<div class="sb-foot"><a href="#" id="logoutTrigger"><i class="fa-solid fa-right-from-bracket"></i>Keluar</a></div>
</aside>
<header class="topbar">
  <button type="button" class="avatar" data-sidebar-open aria-label="Buka menu profil"><i class="fa-solid fa-user"></i></button>
  <div class="topbar-brand">SMK TI<span>Bali Global Badung &middot; Siswa</span></div>
</header>

  <main class="page">
    <!-- JADWAL HARI INI (PER KELAS): data-render="jadwalSiswa" -->
    <section class="section" id="jadwal">
      <h2 class="section-title">Jadwal Hari Ini (Per Kelas)</h2>
      <div class="carousel" data-carousel>
        <button type="button" class="car-btn" data-dir="prev" aria-label="Sebelumnya"><i class="fa-solid fa-arrow-left"></i></button>
        <div class="car-viewport"><div class="car-track" data-render="jadwalSiswa" data-template="tpl-jadwal-siswa" data-endpoint=""></div></div>
        <button type="button" class="car-btn" data-dir="next" aria-label="Berikutnya"><i class="fa-solid fa-arrow-right"></i></button>
        <div class="car-dots"></div>
      </div>
      <!-- Jadwal lengkap: 3 pilihan. Ganti href dengan route backend -->
      <div class="dropdown">
        <button type="button" class="btn btn-outline" data-dd-toggle><i class="fa-solid fa-calendar-days"></i> Jadwal Lengkap <i class="fa-solid fa-chevron-down"></i></button>
        <div class="dd-menu" hidden>
          <a href="#" data-kelas="X">Kelas X</a><a href="#" data-kelas="XI">Kelas XI</a><a href="#" data-kelas="XII">Kelas XII</a>
        </div>
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

<template id="tpl-jadwal-siswa">
  <article class="slide" data-active="aktif">
    <div class="slide-card">
      <div>
        <p class="slide-kicker">Jadwal Hari Ini</p>
        <p class="slide-time">waktu &nbsp;-&nbsp; Jam Ke jam_ke</p>
        <h3>mapel</h3>
        <p class="slide-status"><i class="dot"></i>status</p>
      </div>
      <div class="slide-teacher">Pengajar
        <!-- foto guru: isi field foto (URL gambar) -->
        <div class="photo img-slot"><i class="fa-solid fa-user"></i><img src="foto" alt="pengajar"></div>
      </div>
    </div>
  </article>
</template>

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

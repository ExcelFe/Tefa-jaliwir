<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard Guru - SMK TI Bali Global Badung</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Anton&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <!-- Font Awesome (icon) -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
  <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>
<body>

<!-- ================= SIDEBAR (dibuka lewat ikon profil di kiri atas) ================= -->
<div id="overlay" class="overlay" data-sidebar-close></div>
<aside id="sidebar" class="sidebar" aria-label="Menu profil">
  <div class="sb-head">
    <span class="avatar"><i class="fa-solid fa-user"></i></span>
    <div>
      <strong>{{ Auth::guard('guru')->user()->nama ?? Auth::guard('guru')->user()->email }}</strong>
      <small>Guru</small>
    </div>
  </div>
  <nav class="sb-nav">
      <a href="#" class="is-active"><i class="fa-solid fa-house"></i>Beranda</a>
      <button type="button" data-modal-open="modal-absen-siswa"><i class="fa-solid fa-user-check"></i>Absen Siswa</button>
      <button type="button" data-modal-open="modal-jurnal"><i class="fa-solid fa-book-open"></i>Jurnal Kelas</button>
      <button type="button" data-modal-open="modal-rekap"><i class="fa-solid fa-chart-line"></i>Rekap Absensi</button>
  </nav>
  <div class="sb-foot"><a href="#" id="logoutTrigger"><i class="fa-solid fa-right-from-bracket"></i>Keluar</a></div>
</aside>
<header class="topbar">
  <button type="button" class="avatar" data-sidebar-open aria-label="Buka menu profil"><i class="fa-solid fa-user"></i></button>
  <div class="topbar-brand">SMK TI<span>Bali Global Badung &middot; Guru</span></div>
</header>

  <main class="page">
    <!-- JADWAL HARI INI (PER GURU): data-render="jadwalGuru" (placeholder DB ada di data-mock.js) -->
    <section class="section">
      <h2 class="section-title">Jadwal Hari Ini (Per Guru)</h2>
      <div class="carousel" data-carousel>
        <button type="button" class="car-btn" data-dir="prev" aria-label="Sebelumnya"><i class="fa-solid fa-arrow-left"></i></button>
        <div class="car-viewport"><div class="car-track" data-render="jadwalGuru" data-template="tpl-jadwal-guru" data-endpoint="{{ route('api.jadwal.guru') }}"></div></div>
        <button type="button" class="car-btn" data-dir="next" aria-label="Berikutnya"><i class="fa-solid fa-arrow-right"></i></button>
        <div class="car-dots"></div>
      </div>
    </section>
    <section class="section">
      <div class="tiles">
      <button type="button" class="tile" data-modal-open="modal-absen-siswa">
        <span class="tile-icon g-blue"><i class="fa-solid fa-user-check"></i></span>Absen Siswa
      </button>
      <button type="button" class="tile" data-modal-open="modal-jurnal">
        <span class="tile-icon g-sky"><i class="fa-solid fa-book-open"></i></span>Jurnal Kelas
      </button>
      <button type="button" class="tile tile-wide" data-modal-open="modal-rekap">
        <span class="tile-icon g-navy"><i class="fa-solid fa-chart-line"></i></span>Rekap Absensi
      </button>
    </div>
    </section>
  </main>

@verbatim
<template id="tpl-jadwal-guru">
  <article class="slide" data-active="{{aktif}}">
    <div class="slide-card">
      <div>
        <p class="slide-kicker">Jadwal Hari Ini</p>
        <p class="slide-time">{{waktu}} &nbsp;-&nbsp; Jam Ke {{jam_ke}}</p>
      </div>
      <div>
        <h3>{{kelas}}</h3>
        <p class="slide-status"><i class="dot"></i>{{status}}</p>
      </div>
    </div>
  </article>
</template>
@endverbatim

<!-- ===== POPUP: Absensi Kelas ===== -->
<div class="modal" id="modal-absen-siswa" hidden role="dialog" aria-modal="true" aria-labelledby="modal-absen-siswa-title">
  <div class="modal-box wide">
    <button type="button" class="modal-close" data-modal-close aria-label="Tutup"><i class="fa-solid fa-xmark"></i></button>
    <h2 class="modal-title" id="modal-absen-siswa-title">Absensi Kelas</h2>
    <!-- Langkah 1: pilih kelas -->
    <div class="step" data-step="pilih-kelas">
    <div class="class-picker" data-next="tabel" data-open="XI">
      <div class="tabs"></div>
      <div class="class-groups"></div>
    </div>
    </div>
    <!-- Langkah 2: tabel absensi (data siswa per kelas: data-endpoint="/api/kelas/{kelas}/siswa") -->
    <div class="step" data-step="tabel" hidden>
      <button type="button" class="back-btn" data-step-go="pilih-kelas"><i class="fa-solid fa-arrow-left"></i> Pilih kelas lain</button>
      <p class="lbl">Kelas: <strong data-slot="kelas-nama"></strong></p>
      <!-- CSRF / action: isi oleh backend -->
      <form action="#" method="post" data-belum-aktif>
        @csrf
        <input type="hidden" name="kelas" data-kelas-input>
        <div class="toolbar">
          <label class="search"><i class="fa-solid fa-magnifying-glass"></i><input type="search" placeholder="Cari nama siswa..." data-filter="#tbody-absen-siswa-box"></label>
        </div>
        <div class="table-wrap" id="tbody-absen-siswa-box">
          <table class="table">
            <thead><tr><th>No.</th><th>Nama Siswa</th><th>Kehadiran</th></tr></thead>
            <tbody id="tbody-absen-siswa" data-render="siswa" data-template="tpl-absen-siswa" data-lazy data-endpoint=""></tbody>
          </table>
        </div>
        <button type="submit" class="btn btn-block"><i class="fa-solid fa-floppy-disk"></i> Simpan Absensi</button>
      </form>
    </div>
  </div>
</div>

@verbatim
<template id="tpl-absen-siswa">
  <tr data-row>
    <td>{{no}}</td><td>{{nama}}</td>
    <td><div class="att">
      <label><input type="radio" name="hadir[{{id}}]" value="hadir" checked><span class="h">Hadir</span></label>
      <label><input type="radio" name="hadir[{{id}}]" value="tidak"><span class="t">Tidak Hadir</span></label>
    </div></td>
  </tr>
</template>
@endverbatim

<!-- ===== POPUP: Jurnal Kelas ===== -->
<div class="modal" id="modal-jurnal" hidden role="dialog" aria-modal="true" aria-labelledby="modal-jurnal-title">
  <div class="modal-box wide">
    <button type="button" class="modal-close" data-modal-close aria-label="Tutup"><i class="fa-solid fa-xmark"></i></button>
    <h2 class="modal-title" id="modal-jurnal-title">Jurnal Kelas</h2>
    <div class="step" data-step="pilih-kelas">
    <div class="class-picker" data-next="form" data-open="XI">
      <div class="tabs"></div>
      <div class="class-groups"></div>
    </div>
    </div>
    <div class="step" data-step="form" hidden>
      <button type="button" class="back-btn" data-step-go="pilih-kelas"><i class="fa-solid fa-arrow-left"></i> Pilih kelas lain</button>
      <p class="lbl">Kelas: <strong data-slot="kelas-nama"></strong></p>
      <!-- CSRF / action: isi oleh backend. enctype wajib untuk upload foto -->
      <form action="#" method="post" enctype="multipart/form-data" data-belum-aktif>
        @csrf
        <input type="hidden" name="kelas" data-kelas-input>
        <div class="grid-2">
          <div class="field"><label for="j-tanggal">Hari / Tanggal</label><input class="input" type="date" id="j-tanggal" name="tanggal" data-today required></div>
          <div class="field"><label>Jam ke-</label>
            <div class="range"><input class="input" type="number" min="1" name="jam_ke_mulai" value="1" aria-label="Jam ke awal"><span>-</span><input class="input" type="number" min="1" name="jam_ke_selesai" value="2" aria-label="Jam ke akhir"></div></div>
          <div class="field"><label for="j-mapel">Mata Pelajaran</label>
            <input class="input" list="dl-mapel" id="j-mapel" name="mapel" placeholder="Ketik atau pilih mapel..." autocomplete="off" required>
            <datalist id="dl-mapel" data-render="mapel" data-template="tpl-option-mapel"></datalist></div>
          <div class="field"><label for="j-pertemuan">Pertemuan ke-</label><input class="input" type="number" min="1" id="j-pertemuan" name="pertemuan_ke" value="1" required></div>
        </div>
        <div class="field"><label for="j-sub">Sub-Kompetensi</label><textarea class="input" id="j-sub" name="sub_kompetensi" placeholder="Tuliskan sub-kompetensi yang diajarkan..." required></textarea></div>
        <div class="field"><span class="lbl">Foto Dokumentasi</span>
          <label class="upload"><i class="fa-solid fa-image"></i><span>Klik untuk unggah foto</span><input type="file" name="foto" accept="image/*"></label></div>
        <button type="submit" class="btn btn-block"><i class="fa-solid fa-floppy-disk"></i> Simpan Jurnal</button>
      </form>
    </div>
  </div>
</div>

<!-- ===== POPUP: modal-rekap ===== -->
<div class="modal" id="modal-rekap" hidden role="dialog" aria-modal="true" aria-labelledby="modal-rekap-title">
  <div class="modal-box">
    <button type="button" class="modal-close" data-modal-close aria-label="Tutup"><i class="fa-solid fa-xmark"></i></button>
    <h2 class="modal-title" id="modal-rekap-title">Rekap Absensi Siswa</h2>
    <div class="center-msg">
      <i class="fa-solid fa-file-excel ico"></i>
      <p>Unduh Spreadsheets untuk melihat rekapan absensi siswa</p>
      <!-- href: ganti dengan URL export dari backend. Sudah ada atribut download -->
      <a class="btn btn-light" href="#" download="rekap-absensi-siswa.xlsx" data-belum-aktif><i class="fa-solid fa-download"></i> Unduh Spreadsheets</a>
    </div>
  </div>
</div>

@verbatim
<template id="tpl-option-mapel"><option value="{{nama}}"></option></template>
@endverbatim

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
                <form action="{{ route('guru.logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-yes" id="confirmLogout">Ya</button>
                </form>
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

<script src="{{ asset('js/data-mock.js') }}"></script>
<script src="{{ asset('js/dashboard-afterlog.js') }}"></script>
<script>
  /* Simpan absensi, simpan jurnal & unduh rekap belum diaktifkan (menunggu back-end) */
  document.addEventListener('submit', function (e) {
    if (e.target.hasAttribute('data-belum-aktif')) { e.preventDefault(); alert('Fitur ini belum diaktifkan.'); }
  });
  document.addEventListener('click', function (e) {
    var a = e.target.closest('a[data-belum-aktif]');
    if (a) { e.preventDefault(); alert('Fitur ini belum diaktifkan.'); }
  });
</script>
</body>
</html>
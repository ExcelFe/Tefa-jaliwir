/* =========================================================
   DATA PLACEHOLDER (pengganti database)
   ---------------------------------------------------------
   Halaman membaca data dari window.TEFA_DATA. Isinya sekarang
   data contoh. Tim backend bisa:
   (a) mengganti file ini dengan  window.TEFA_DATA = {...};  hasil query, ATAU
   (b) mengisi atribut  data-endpoint="/api/..."  pada elemen yang punya
       data-render="..." (halaman otomatis fetch JSON dan memakai
       data contoh ini kalau gagal).
   Nama field = saran nama kolom database.
   ========================================================= */
window.TEFA_DATA = {

  /* tabel users: pengguna yang sedang login (sidebar) */
  user: { nama: 'Nama Pengguna', role: 'Role' },

  /* guru + status hari ini. status: hadir | tidak | izin | sakit */
  guruStatus: [
    { nama: 'Nama Guru, Gelar', mapel: 'Pendidikan Pancasila', status: 'hadir' },
    { nama: 'Nama Guru, Gelar', mapel: 'Bahasa Indonesia',     status: 'hadir' },
    { nama: 'Nama Guru, Gelar', mapel: 'Matematika',           status: 'tidak' },
    { nama: 'Nama Guru, Gelar', mapel: 'Bahasa Inggris',       status: 'izin'  },
    { nama: 'Nama Guru, Gelar', mapel: 'Pemrograman Dasar',    status: 'hadir' },
    { nama: 'Nama Guru, Gelar', mapel: 'Desain Grafis',        status: 'hadir' },
    { nama: 'Nama Guru, Gelar', mapel: 'Jaringan Dasar',       status: 'sakit' },
    { nama: 'Nama Guru, Gelar', mapel: 'Bisnis Digital',       status: 'hadir' }
  ],

  /* tabel guru (dropdown guru piket + tabel absen guru) */
  guruList: [
    { id: 1,  nama: 'Nama Guru 1, Gelar' },  { id: 2,  nama: 'Nama Guru 2, Gelar' },
    { id: 3,  nama: 'Nama Guru 3, Gelar' },  { id: 4,  nama: 'Nama Guru 4, Gelar' },
    { id: 5,  nama: 'Nama Guru 5, Gelar' },  { id: 6,  nama: 'Nama Guru 6, Gelar' },
    { id: 7,  nama: 'Nama Guru 7, Gelar' },  { id: 8,  nama: 'Nama Guru 8, Gelar' }
  ],

  /* tabel mapel (dropdown jurnal kelas) */
  mapel: [
    { nama: 'Bahasa Indonesia' }, { nama: 'Bahasa Inggris' }, { nama: 'Matematika' },
    { nama: 'Pendidikan Pancasila' }, { nama: 'Pemrograman Dasar' }, { nama: 'Desain Grafis' }
  ],

  /* jadwal hari ini per KELAS (siswa). aktif: 1 = jadwal yang sedang berlangsung */
  jadwalSiswa: [
    { waktu: '07.30 - 09.00', jam_ke: 1, mapel: 'Bahasa Indonesia',     status: 'Sedang Berlangsung', pengajar: 'Nama Guru', foto: '', aktif: 1 },
    { waktu: '09.15 - 10.45', jam_ke: 2, mapel: 'Matematika',           status: 'Akan Datang',        pengajar: 'Nama Guru', foto: '' },
    { waktu: '11.00 - 12.30', jam_ke: 3, mapel: 'Pendidikan Pancasila', status: 'Akan Datang',        pengajar: 'Nama Guru', foto: '' }
  ],

  /* jadwal hari ini per GURU */
  jadwalGuru: [
    { waktu: '07.30 - 09.00', jam_ke: 1, kelas: 'XI PPLG 1', status: 'Sedang Berlangsung', aktif: 1 },
    { waktu: '09.15 - 10.45', jam_ke: 2, kelas: 'XI PPLG 2', status: 'Akan Datang' },
    { waktu: '11.00 - 12.30', jam_ke: 3, kelas: 'XI DKV 1',  status: 'Akan Datang' }
  ],

  /* tabel kelas, dikelompokkan per tingkat */
  kelas: {
    X:   ['X PPLG 1',  'X PPLG 2',  'X DKV 1',  'X DKV 2'],
    XI:  ['XI PPLG 1', 'XI PPLG 2', 'XI DKV 1', 'XI DKV 2'],
    XII: ['XII PPLG 1','XII PPLG 2','XII DKV 1','XII DKV 2']
  },

  /* tabel siswa. key = nama kelas; 'default' dipakai kalau kelasnya tidak ada */
  siswa: {
    default: [
      { id: 1,  nama: 'Aldo Jr. Juventus' }, { id: 2,  nama: 'Nama Siswa 2' },
      { id: 3,  nama: 'Nama Siswa 3' },      { id: 4,  nama: 'Nama Siswa 4' },
      { id: 5,  nama: 'Nama Siswa 5' },      { id: 6,  nama: 'Nama Siswa 6' },
      { id: 7,  nama: 'Nama Siswa 7' },      { id: 8,  nama: 'Nama Siswa 8' }
    ]
  }
};

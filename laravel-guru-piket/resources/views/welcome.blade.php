<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
<link rel="stylesheet" href="{{ asset('css/animation.css') }}">
<link rel="stylesheet" href="{{ asset('css/main.css') }}">

<script src="{{ asset('js/animation.js') }}"></script>
<script src="{{ asset('js/dashboard.js') }}"></script>
<script src="{{ asset('js/dashboard-afterlog.js') }}"></script>
<script src="{{ asset('js/data-mock.js') }}"></script>
<script src="{{ asset('js/login.js') }}"></script>
<script src="{{ asset('js/main.js') }}"></script>
<script src="{{ asset('js/profil-manajemen.js') }}"></script>
<script src="{{ asset('js/program-sekolah.js') }}"></script>
</head>
<body>
    <!-- NAVBAR: same block on every page (hamburger on tablet/phone, js/main.js) -->
    <header class="navbar">
        <div class="container navbar-inner">
            <a href="index.html" class="brand">
                <div class="img-slot logo-slot">
                
                
            <img src="{{ asset('images/logo.webp') }}" alt="Logo sekolah">

            
            </div>
                <span>SMK TI<br><span class="brand-sub">Bali Global Badung</span></span>
            </a>
            <button type="button" class="nav-toggle" aria-label="Buka menu" aria-expanded="false" aria-controls="nav-panel">
                <span class="nav-toggle-bar"></span>
            </button>
            <div class="nav-panel" id="nav-panel">
                <div class="nav-panel-inner">
                    <nav class="nav-links" aria-label="Navigasi utama">
                    <a href="{{ route('welcome') }}" class="active">Beranda</a>
                    <a href="{{ route('profil') }}" class="active">Profil Manajemen</a>
                    <a href="{{ route('program') }}" class="active">Program Sekolah</a>
                    
                    </nav>
                    <a href="{{ route('login') }}" class="btn-login">Login <i class="fa-solid fa-arrow-right-to-bracket" aria-hidden="true"></i></a>
                </div>
            </div>
        </div>
    </header>

    <main>
        <!-- HERO: background photo = media/landingsmkti.jpg (change --hero-img in css/main.css) -->
        <section class="hero">
            <div class="container">
                <div class="hero-tags"><span>Pendidikan Berkualitas</span><span>Karakter Kuat</span><span>Masa Depan Cerah</span></div>
                <h1>Bersama Membangun Generasi <em>Berdaya</em> dan <em>Berkarakter</em></h1>
                <p>Sekolah kami hadir untuk memberikan pendidikan berkualitas dengan perpaduan ilmu pengetahuan, teknologi, dan nilai-nilai budaya yang luhur.</p>
            </div>
        </section>

        <!-- HIGHLIGHT CARD (overlaps the hero edge) -->
        <div class="info-wrap">
            <div class="info-card">
                <div class="info-item"><strong>Kurikulum Modern</strong><span></span></div>
                <div class="info-item"><strong>Tenaga Pendidik Profesional</strong><span></span></div>
                <div class="info-item"><strong>Fasilitas Lengkap</strong><span></span></div>
                <div class="info-item"><strong>Lingkungan Positif</strong><span></span></div>
            </div>
        </div>

        <!-- KURIKULUM -->
        <section class="container section">
            <div class="kurikulum">
                <div>
                    <span class="bar"></span>
                    <h2>Kurikulum</h2>
                    <p>Kurikulum adalah seperangkat rencana dan pengaturan mengenai tujuan, isi, dan proses pembelajaran. Dalam pendidikan vokasi, kurikulum sangat penting karena menjadi pedoman untuk mencetak lulusan yang kompeten, siap kerja, dan mampu beradaptasi dengan perkembangan industri dan teknologi.</p>
                </div>
                <div class="card-soft feature-card">
                    <div class="icon-circle"><i class="fa-solid fa-graduation-cap"></i></div>
                    <div>
                        <h3>Kurikulum Yang Diterapkan</h3>
                        <p>SMK TI Bali Global Badung menerapkan kurikulum berorientasi industri dan berbasis kompetensi, yang menggabungkan fondasi akademik, proyek praktik, pengembangan karakter, serta persiapan untuk menghadapi dunia kerja digital.</p>
                    </div>
                </div>
            </div>

            <!-- PERK CARDS: change the Font Awesome icon class, title and text. Copy/remove .perk-card blocks as needed -->
            <div class="perks-grid">
                <article class="card-soft perk-card">
                    <div class="icon-circle"><i class="fa-solid fa-bullseye"></i></div>
                    <h3>Berbasis Kompetensi</h3>
                    <p>Fokus pada penguasaan kompetensi yang dibutuhkan di dunia kerja.</p>
                </article>
                <article class="card-soft perk-card">
                    <div class="icon-circle"><i class="fa-regular fa-lightbulb"></i></div>
                    <h3>Project Based Learning</h3>
                    <p>Belajar melalui proyek nyata untuk melatih kreativitas, kolaborasi, dan problem solving..</p>
                </article>
                <article class="card-soft perk-card">
                    <div class="icon-circle"><i class="fa-solid fa-handshake"></i></div>
                    <h3>Link &amp; Match industri</h3>
                    <p>Kerja sama dengan industri untuk memastikan relevansi ilmu dengan kebutuhan pasar..</p>
                </article>
                <article class="card-soft perk-card">
                    <div class="icon-circle"><i class="fa-solid fa-users"></i></div>
                    <h3>Karakter &amp; Soft Skills</h3>
                    <p>Membentuk pribadi disiplin, mandiri, komunikatif, dan bertanggung jawab..</p>
                </article>
            </div>
        </section>

        <!-- FASILITAS -->
        <section id="fasilitas" class="container section">
            <h2 class="section-title">Fasilitas sekolah</h2>
            <div class="fasilitas-box">
                <figure>
                    <div class="img-slot ratio-1610" data-label="Foto fasilitas"><img src="{{ asset('images/ruang-kelas.jpg') }}" alt="Logo sekolah"></div>
                    <figcaption>Ruangan Berfasilitas AC</figcaption>
                </figure>
                <figure>
                    <div class="img-slot ratio-1610" data-label="Foto fasilitas"><img src="{{ asset('images/lab-multimedia.jpg') }}" alt="Logo sekolah"></div>
                    <figcaption>LAB Multimedia</figcaption>
                </figure>
                <figure>
                    <div class="img-slot ratio-1610" data-label="Foto fasilitas"><img src="{{ asset('images/lab-rpl-tkj.jpg') }}" alt="Logo sekolah"></div>
                    <figcaption>LAB PPLG & TJKT</figcaption>
                </figure>
                <figure>
                    <div class="img-slot ratio-1610" data-label="Foto fasilitas"><img src="{{ asset('images/studio-foto.jpg') }}" alt="Logo sekolah"></div>
                    <figcaption>Studio Foto</figcaption>
                </figure>
            </div>
        </section>
    </main>

    <!-- FOOTER: same block on every page -->
    <footer class="footer">
        <div class="container footer-grid">
            <div>
                <div class="brand">
                    <div class="img-slot logo-slot lg"><img src="{{ asset('images/logo.webp') }}" alt="Logo sekolah"></div>
                    <span>SMK TI<br><span class="brand-sub">Bali Global Badung</span></span>
                </div>
                <p class="footer-desc">Sekolah kejuruan berbasis teknologi informasi yang mencetak lulusan kompeten, berkarakter, dan siap bersaing di era digital.</p>
                <!-- Social links: change href and the Font Awesome icon class -->
                <div class="sosmed">
                    <a href="https://www.instagram.com/globalitibadung_" target="_blank" rel="noopener noreferrer" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
                    <a href="https://www.facebook.com/globalitibadung" target="_blank" rel="noopener noreferrer" aria-label="Facebook"><i class="fa-brands fa-facebook"></i></a>
                    <a href="https://www.tiktok.com/@globalitibadung_" target="_blank" rel="noopener noreferrer" aria-label="TikTok"><i class="fa-brands fa-tiktok"></i></a>
                    <a href="https://youtube.com/@smktibaliglobalbadung" target="_blank" rel="noopener noreferrer" aria-label="YouTube"><i class="fa-brands fa-youtube"></i></a>
                </div>
            </div>
            <div>
                <h3>Navigasi</h3>
                <ul>
                    <li><a href="index.html">Beranda</a></li>
                    <li><a href="pages/before/profil-manajemen.html">Profil Manajemen</a></li>
                    <li><a href="pages/before/program-sekolah.html">Program Sekolah</a></li>
                    <li><a href="index.html#fasilitas">Fasilitas</a></li>
                </ul>
            </div>
            <div>
                <h3>Program Studi</h3>
                <ul>
                    <li><a href="pages/before/program-sekolah.html#tjkt">TJKT</a></li>
                    <li><a href="pages/before/program-sekolah.html#pplg">PPLG</a></li>
                    <li><a href="pages/before/program-sekolah.html#dkv">DKV</a></li>
                    <li><a href="pages/before/program-sekolah.html#bd">BD</a></li>
                </ul>
            </div>
            <div>
                <h3>Kontak</h3>
                <ul class="footer-contact">
                    <li><i class="fa-solid fa-location-dot"></i><span>Jl. Tibungsari No. 1, Desa Dalung, Kuta Utara, Badung, Bali</span></li>
                    <li><i class="fa-solid fa-phone"></i><span>+62 361-419097</span></li>
                    <li><i class="fa-brands fa-whatsapp"></i><span>+62 822-61-9000-70</span></li>
                    <li><i class="fa-solid fa-envelope"></i><span>info@smktibaliglobalbadung.sch.id</span></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="container">
                <p>&copy; 2026 SMK TI Bali Global Badung. All rights reserved.</p>
                <nav><a href="#">Kebijakan privasi</a><a href="#">Syarat &amp; Ketentuan</a></nav>
            </div>
        </div>
    </footer>
</body>
</html>

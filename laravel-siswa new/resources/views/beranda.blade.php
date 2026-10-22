@extends('layouts.app')

@section('title', 'Beranda - SMK TI Bali Global Badung')

@section('content')
    <!-- HERO -->
    <section class="hero">
        <div class="container">
            <div class="hero-tags">
                <span>Pendidikan Berkualitas</span>
                <span>Karakter Kuat</span>
                <span>Masa Depan Cerah</span>
            </div>
            <h1>Bersama Membangun Generasi <em>Berdaya</em> dan <em>Berkarakter</em></h1>
            <p>Sekolah kami hadir untuk memberikan pendidikan berkualitas dengan perpaduan ilmu pengetahuan, teknologi, dan nilai-nilai budaya yang luhur.</p>
        </div>
    </section>

    <!-- HIGHLIGHT CARD -->
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

        <!-- PERK CARDS -->
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
                <div class="img-slot ratio-1610" data-label="Foto fasilitas">
                    <img src="{{ asset('media/ruang-kelas.jpg') }}" alt="Fasilitas">
                </div>
                <figcaption>Ruangan Berfasilitas AC</figcaption>
            </figure>
            <figure>
                <div class="img-slot ratio-1610" data-label="Foto fasilitas">
                    <img src="{{ asset('media/lab-multimedia.jpg') }}" alt="Fasilitas">
                </div>
                <figcaption>LAB Multimedia</figcaption>
            </figure>
            <figure>
                <div class="img-slot ratio-1610" data-label="Foto fasilitas">
                    <img src="{{ asset('media/lab-rpl-tkj.jpg') }}" alt="Fasilitas">
                </div>
                <figcaption>LAB PPLG &amp; TJKT</figcaption>
            </figure>
            <figure>
                <div class="img-slot ratio-1610" data-label="Foto fasilitas">
                    <img src="{{ asset('media/studio-foto.jpg') }}" alt="Fasilitas">
                </div>
                <figcaption>Studio Foto</figcaption>
            </figure>
        </div>
    </section>
@endsection
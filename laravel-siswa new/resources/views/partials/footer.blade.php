<footer class="footer">
    <div class="container footer-grid">
        <div>
            <div class="brand">
                <div class="img-slot logo-slot lg">
                    <img src="{{ asset('media/logo.webp') }}" alt="Logo SMK TI Bali Global Badung">
                </div>
                <span>SMK TI<br><span class="brand-sub">Bali Global Badung</span></span>
            </div>
            <p class="footer-desc">Sekolah kejuruan berbasis teknologi informasi yang mencetak lulusan kompeten, berkarakter, dan siap bersaing di era digital.</p>
            
            <!-- Social links -->
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
                <li><a href="{{ url('/beranda') }}">Beranda</a></li>
                <li><a href="{{ url('/profil-manajemen') }}">Profil Manajemen</a></li>
                <li><a href="{{ url('/program-sekolah') }}">Program Sekolah</a></li>
                <li><a href="{{ url('/#fasilitas') }}">Fasilitas</a></li>
            </ul>
        </div>

        <div>
            <h3>Program Studi</h3>
            <ul>
                <li><a href="{{ url('/program-sekolah#tjkt') }}">TJKT</a></li>
                <li><a href="{{ url('/program-sekolah#pplg') }}">PPLG</a></li>
                <li><a href="{{ url('/program-sekolah#dkv') }}">DKV</a></li>
                <li><a href="{{ url('/program-sekolah#bd') }}">BD</a></li>
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
            <nav>
                <a href="#">Kebijakan privasi</a>
                <a href="#">Syarat &amp; Ketentuan</a>
            </nav>
        </div>
    </div>
</footer>
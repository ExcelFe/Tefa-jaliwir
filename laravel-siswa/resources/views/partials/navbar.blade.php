<header class="navbar">
    <div class="container navbar-inner">
        <a href="{{ url('/beranda') }}" class="brand">
            <div class="img-slot logo-slot"><img src="{{ asset('media/logo.webp') }}" alt="Logo SMK TI Bali Global Badung"></div>
            <span>SMK TI<br><span class="brand-sub">Bali Global Badung</span></span>
        </a>
        <button type="button" class="nav-toggle" aria-label="Buka menu" aria-expanded="false" aria-controls="nav-panel">
            <span class="nav-toggle-bar"></span>
        </button>
        <div class="nav-panel" id="nav-panel">
            <div class="nav-panel-inner">
                <nav class="nav-links" aria-label="Navigasi utama">
                    <a href="{{ url('/beranda') }}" class="{{ request()->is('/beranda') ? 'is-active' : '' }}">Beranda</a>
                    <a href="{{ url('/profil-manajemen') }}" class="{{ request()->is('profil-manajemen') ? 'is-active' : '' }}">Profil Manajemen</a>
                    <a href="{{ url('/program-sekolah') }}" class="{{ request()->is('program-sekolah') ? 'is-active' : '' }}">Program Sekolah</a>
                </nav>
                <a href="{{ url('/login') }}" class="btn-login">Login <i class="fa-solid fa-arrow-right-to-bracket" aria-hidden="true"></i></a>
            </div>
        </div>
    </div>
</header>
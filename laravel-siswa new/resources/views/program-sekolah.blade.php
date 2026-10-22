@extends('layouts.app')

@section('title', 'Program Sekolah - SMK TI Bali Global Badung')

@section('content')
    <!-- PAGE HERO -->
    <section class="page-hero">
        <div class="container">
            <h1>PROGRAM <em>UNGGULAN</em> SEKOLAH</h1>
        </div>
    </section>

    <div class="container program">
        <!-- PROGRAM KEAHLIAN -->
        <section class="program-block">
            <h1 class="headline">PROGRAM KEAHLIAN</h1>
            <div class="program-grid">
                <article class="program-card card-soft" id="tjkt">
                    <div class="program-card-media" aria-hidden="true"><span>TJKT</span></div>
                    <h3>Teknik Jaringan Komputer dan Telekomunikasi</h3>
                    <p>Lorem Ipsum Dolor Sit Amet</p>
                </article>
                <article class="program-card card-soft" id="pplg">
                    <div class="program-card-media" aria-hidden="true"><span>PPLG</span></div>
                    <h3>Pengembangan Perangkat Lunak dan Gim</h3>
                    <p>Lorem Ipsum Dolor Sit Amet</p>
                </article>
                <article class="program-card card-soft" id="dkv">
                    <div class="program-card-media" aria-hidden="true"><span>DKV</span></div>
                    <h3>Desain Komunikasi Visual</h3>
                    <p>Lorem Ipsum Dolor Sit Amet</p>
                </article>
                <article class="program-card card-soft" id="bd">
                    <div class="program-card-media" aria-hidden="true"><span>BD</span></div>
                    <h3>Bisnis Digital</h3>
                    <p>Lorem Ipsum Dolor Sit Amet</p>
                </article>
            </div>
        </section>

        <!-- INTRA-KULIKULER -->
        <section class="program-block">
            <h1 class="headline">INTRA-KULIKULER</h1>
            <div class="dropdown-group">
                <div class="dropdown-triggers dropdown-triggers--3">
                    <button type="button" class="dropdown-trigger" id="ik-trigger-10" aria-expanded="false" aria-controls="ik-panel-10">
                        Kelas 10
                        <span class="dropdown-icon" aria-hidden="true"></span>
                    </button>
                    <button type="button" class="dropdown-trigger" id="ik-trigger-11" aria-expanded="false" aria-controls="ik-panel-11">
                        Kelas 11
                        <span class="dropdown-icon" aria-hidden="true"></span>
                    </button>
                    <button type="button" class="dropdown-trigger" id="ik-trigger-12" aria-expanded="false" aria-controls="ik-panel-12">
                        Kelas 12
                        <span class="dropdown-icon" aria-hidden="true"></span>
                    </button>
                </div>
                <div class="dropdown-panel" id="ik-panel-10">
                    <div class="dropdown-inner">
                        <ul class="list-stack" aria-labelledby="ik-trigger-10">
                            <li class="list-item">Bahasa Indonesia</li>
                            <li class="list-item">Bahasa Bali</li>
                            <li class="list-item">Bahasa Inggris</li>
                            <li class="list-item">Bahasa Jepang</li>
                            <li class="list-item">PJOK</li>
                            <li class="list-item">Agama</li>
                            <li class="list-item">Seni Budaya</li>
                            <li class="list-item">IPAS</li>
                            <li class="list-item">KKA</li>
                            <li class="list-item">Informatika</li>
                            <li class="list-item">Sejarah</li>
                            <li class="list-item">Pendidikan Pancasila</li>
                        </ul>
                    </div>
                </div>
                <div class="dropdown-panel" id="ik-panel-11">
                    <div class="dropdown-inner">
                        <ul class="list-stack" aria-labelledby="ik-trigger-11">
                            <li class="list-item">Bahasa Indonesia</li>
                            <li class="list-item">Bahasa Bali</li>
                            <li class="list-item">Bahasa Inggris</li>
                            <li class="list-item">Bahasa Jepang</li>
                            <li class="list-item">PJOK</li>
                            <li class="list-item">Agama</li>
                            <li class="list-item">Seni Budaya</li>
                            <li class="list-item">IPAS</li>
                            <li class="list-item">KKA</li>
                            <li class="list-item">Informatika</li>
                            <li class="list-item">Sejarah</li>
                            <li class="list-item">Pendidikan Pancasila</li>
                        </ul>
                    </div>
                </div>
                <div class="dropdown-panel" id="ik-panel-12">
                    <div class="dropdown-inner">
                        <ul class="list-stack" aria-labelledby="ik-trigger-12">
                            <li class="list-item">Bahasa Indonesia</li>
                            <li class="list-item">Bahasa Bali</li>
                            <li class="list-item">Bahasa Inggris</li>
                            <li class="list-item">Bahasa Jepang</li>
                            <li class="list-item">PJOK</li>
                            <li class="list-item">Agama</li>
                            <li class="list-item">Seni Budaya</li>
                            <li class="list-item">IPAS</li>
                            <li class="list-item">KKA</li>
                            <li class="list-item">Informatika</li>
                            <li class="list-item">Sejarah</li>
                            <li class="list-item">Pendidikan Pancasila</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <!-- KO-KULIKULER -->
        <section class="program-block">
            <h1 class="headline">KO-KULIKULER</h1>
            <ul class="list-stack">
                <li class="list-item">Projek Penguatan Profil Pelajar Pancasila</li>
                <li class="list-item">Kunjungan Industri</li>
                <li class="list-item">Outing Class</li>
            </ul>
        </section>

        <!-- EKSTRA-KULIKULER -->
        <section class="program-block">
            <h1 class="headline">EKSTRA-KULIKULER</h1>
            <div class="dropdown-group">
                <div class="dropdown-triggers dropdown-triggers--4">
                    <button type="button" class="dropdown-trigger" id="ek-trigger-olahraga" aria-expanded="false" aria-controls="ek-panel-olahraga">
                        Olahraga
                        <span class="dropdown-icon" aria-hidden="true"></span>
                    </button>
                    <button type="button" class="dropdown-trigger" id="ek-trigger-kesenian" aria-expanded="false" aria-controls="ek-panel-kesenian">
                        Kesenian
                        <span class="dropdown-icon" aria-hidden="true"></span>
                    </button>
                    <button type="button" class="dropdown-trigger" id="ek-trigger-teknologi" aria-expanded="false" aria-controls="ek-panel-teknologi">
                        Teknologi
                        <span class="dropdown-icon" aria-hidden="true"></span>
                    </button>
                    <button type="button" class="dropdown-trigger" id="ek-trigger-akademik" aria-expanded="false" aria-controls="ek-panel-akademik">
                        Akademik
                        <span class="dropdown-icon" aria-hidden="true"></span>
                    </button>
                </div>
                <div class="dropdown-panel" id="ek-panel-olahraga">
                    <div class="dropdown-inner">
                        <ul class="list-stack" aria-labelledby="ek-trigger-olahraga">
                            <li class="list-item">Bulu Tangkis</li>
                            <li class="list-item">Volley</li>
                            <li class="list-item">Futsal</li>
                            <li class="list-item">Basket</li>
                            <li class="list-item">MuayThai</li>
                            <li class="list-item">GateBall</li>
                            <li class="list-item">Paskibra</li>
                            <li class="list-item">Pramuka</li>
                        </ul>
                    </div>
                </div>
                <div class="dropdown-panel" id="ek-panel-kesenian">
                    <div class="dropdown-inner">
                        <ul class="list-stack" aria-labelledby="ek-trigger-kesenian">
                            <li class="list-item">Tari</li>
                            <li class="list-item">Tabuh</li>
                            <li class="list-item">Theater</li>
                        </ul>
                    </div>
                </div>
                <div class="dropdown-panel" id="ek-panel-teknologi">
                    <div class="dropdown-inner">
                        <ul class="list-stack" aria-labelledby="ek-trigger-teknologi">
                            <li class="list-item">Jurnalistik dan Broadcasting</li>
                            <li class="list-item">Web Design</li>
                            <li class="list-item">Robotika</li>
                            <li class="list-item">Esport</li>
                        </ul>
                    </div>
                </div>
                <div class="dropdown-panel" id="ek-panel-akademik">
                    <div class="dropdown-inner">
                        <ul class="list-stack" aria-labelledby="ek-trigger-akademik">
                            <li class="list-item">Bahasa Jepang</li>
                            <li class="list-item">English Club</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script defer src="{{ asset('js/program-sekolah.js') }}"></script>
@endpush
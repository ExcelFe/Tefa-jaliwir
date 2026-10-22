@extends('layouts.app')

@section('title', 'Profil Manajemen Sekolah - SMK TI Bali Global Badung')

@section('content')
    <section class="page-hero">
        <div class="container">
            <h1>PROFIL <em>MANAJEMEN</em> SEKOLAH</h1>
        </div>
    </section>

    <div class="container profil-wrap">
        <!-- ===== MANAJEMEN SEKOLAH ===== -->
        <section id="manajemen">
            <h2 class="group-title">Manajemen Sekolah</h2>
            <div class="person-grid">
                <article class="person">
                    <div class="img-slot ratio-34" data-label="Foto">
                        <img src="{{ asset('media/profil/manajemen/imdia.jpg') }}" alt="Foto">
                    </div>
                    <div class="person-info">
                        <h3>I Made Indra Aribawa, SH</h3>
                        <p><i class="fa-solid fa-book-open"></i>Pendidikan Pancasila</p>
                        <p><i class="fa-solid fa-people-group"></i>Kepala Sekolah</p>
                    </div>
                </article>
                <article class="person">
                    <div class="img-slot ratio-34" data-label="Foto">
                        <img src="{{ asset('media/manajemen/manajemen-2.jpg') }}" alt="Foto">
                    </div>
                    <div class="person-info">
                        <h3>Gede Putu Agustyawan, S.Pd</h3>
                        <p><i class="fa-solid fa-book-open"></i>Sejarah</p>
                        <p><i class="fa-solid fa-people-group"></i>Waka Kurikulum</p>
                    </div>
                </article>
                <article class="person">
                    <div class="img-slot ratio-34" data-label="Foto">
                        <img src="{{ asset('media/manajemen/manajemen-3.jpg') }}" alt="Foto">
                    </div>
                    <div class="person-info">
                        <h3>I Made Dwi Adnyana, SH</h3>
                        <p><i class="fa-solid fa-book-open"></i>Pendidikan Pancasila</p>
                        <p><i class="fa-solid fa-people-group"></i>Waka Sarpras</p>
                    </div>
                </article>
                <article class="person">
                    <div class="img-slot ratio-34" data-label="Foto">
                        <img src="{{ asset('media/manajemen/manajemen-4.jpg') }}" alt="Foto">
                    </div>
                    <div class="person-info">
                        <h3>Ida Ayu Cempaka Putri, S.Pd</h3>
                        <p><i class="fa-solid fa-book-open"></i>Mata pelajaran yang diajar</p>
                        <p><i class="fa-solid fa-people-group"></i>Waka Kesiswaan</p>
                    </div>
                </article>
                <article class="person">
                    <div class="img-slot ratio-34" data-label="Foto">
                        <img src="{{ asset('media/manajemen/manajemen-5.jpg') }}" alt="Foto">
                    </div>
                    <div class="person-info">
                        <h3>Ida Ayu Made Ari Widyawati, S.Pd.H</h3>
                        <p><i class="fa-solid fa-book-open"></i>Agama Hindu &amp; Budi Pekerti</p>
                        <p><i class="fa-solid fa-people-group"></i>Waka Humas</p>
                    </div>
                </article>
            </div>
        </section>

        <!-- ===== KEPALA PROGRAM KEAHLIAN ===== -->
        <section id="kaprog">
            <h2 class="group-title">Kepala Program Keahlian</h2>
            <div class="person-grid">
                <article class="person">
                    <div class="img-slot ratio-34" data-label="Foto">
                        <img src="{{ asset('media/kaprog/kaprog-1.jpg') }}" alt="Foto">
                    </div>
                    <div class="person-info">
                        <h3>Putu Ade Pranata, S.Kom</h3>
                        <p><i class="fa-solid fa-book-open"></i>KK RPL</p>
                        <p><i class="fa-solid fa-people-group"></i>Kaprog PPLG</p>
                    </div>
                </article>
                <article class="person">
                    <div class="img-slot ratio-34" data-label="Foto">
                        <img src="{{ asset('media/kaprog/kaprog-2.jpg') }}" alt="Foto">
                    </div>
                    <div class="person-info">
                        <h3>Bagas Alif Rizkianto, S.Kom</h3>
                        <p><i class="fa-solid fa-book-open"></i>DPK PPLG &amp; DPK BD</p>
                        <p><i class="fa-solid fa-people-group"></i>Kaprog DKV</p>
                    </div>
                </article>
                <article class="person">
                    <div class="img-slot ratio-34" data-label="Foto">
                        <img src="{{ asset('media/kaprog/kaprog-3.jpg') }}" alt="Foto">
                    </div>
                    <div class="person-info">
                        <h3>I Gede Bagus Ardiyana Irawan, S.Kom</h3>
                        <p><i class="fa-solid fa-book-open"></i>DPK TJKT</p>
                        <p><i class="fa-solid fa-people-group"></i>Kaprog TJKT &amp; Kepala LAB</p>
                    </div>
                </article>
                <article class="person">
                    <div class="img-slot ratio-34" data-label="Foto">
                        <img src="{{ asset('media/kaprog/kaprog-4.jpg') }}" alt="Foto">
                    </div>
                    <div class="person-info">
                        <h3>A.A Ngurah Putra Agung Amurvabhumi Yoga Cara, S.M</h3>
                        <p><i class="fa-solid fa-book-open"></i>KK BD</p>
                        <p><i class="fa-solid fa-people-group"></i>Kaprog BD</p>
                    </div>
                </article>
            </div>
        </section>

        <!-- ===== GURU PENGAJAR ===== -->
        <section id="guru">
            <h2 class="group-title">Guru Pengajar</h2>
            <div class="person-grid">
                <article class="person">
                    <div class="img-slot ratio-34" data-label="Foto">
                        <img src="{{ asset('media/guru/guru-1.jpg') }}" alt="Foto">
                    </div>
                    <div class="person-info">
                        <h3>Nama, Gelar</h3>
                        <p><i class="fa-solid fa-book-open"></i>Mata pelajaran yang diajar</p>
                        <p><i class="fa-solid fa-people-group"></i>Pembimbing ekstrakurikuler</p>
                    </div>
                </article>
                <article class="person">
                    <div class="img-slot ratio-34" data-label="Foto">
                        <img src="{{ asset('media/guru/guru-2.jpg') }}" alt="Foto">
                    </div>
                    <div class="person-info">
                        <h3>Nama, Gelar</h3>
                        <p><i class="fa-solid fa-book-open"></i>Mata pelajaran yang diajar</p>
                        <p><i class="fa-solid fa-people-group"></i>Pembimbing ekstrakurikuler</p>
                    </div>
                </article>
                <article class="person">
                    <div class="img-slot ratio-34" data-label="Foto">
                        <img src="{{ asset('media/guru/guru-3.jpg') }}" alt="Foto">
                    </div>
                    <div class="person-info">
                        <h3>Nama, Gelar</h3>
                        <p><i class="fa-solid fa-book-open"></i>Mata pelajaran yang diajar</p>
                        <p><i class="fa-solid fa-people-group"></i>Pembimbing ekstrakurikuler</p>
                    </div>
                </article>
                <article class="person">
                    <div class="img-slot ratio-34" data-label="Foto">
                        <img src="{{ asset('media/guru/guru-4.jpg') }}" alt="Foto">
                    </div>
                    <div class="person-info">
                        <h3>Nama, Gelar</h3>
                        <p><i class="fa-solid fa-book-open"></i>Mata pelajaran yang diajar</p>
                        <p><i class="fa-solid fa-people-group"></i>Pembimbing ekstrakurikuler</p>
                    </div>
                </article>
            </div>

            <div id="extra-guru" class="person-grid extra" hidden>
                <article class="person">
                    <div class="img-slot ratio-34" data-label="Foto">
                        <img src="{{ asset('media/guru/guru-5.jpg') }}" alt="Foto">
                    </div>
                    <div class="person-info">
                        <h3>Nama, Gelar</h3>
                        <p><i class="fa-solid fa-book-open"></i>Mata pelajaran yang diajar</p>
                        <p><i class="fa-solid fa-people-group"></i>Pembimbing ekstrakurikuler</p>
                    </div>
                </article>
                <article class="person">
                    <div class="img-slot ratio-34" data-label="Foto">
                        <img src="{{ asset('media/guru/guru-6.jpg') }}" alt="Foto">
                    </div>
                    <div class="person-info">
                        <h3>Nama, Gelar</h3>
                        <p><i class="fa-solid fa-book-open"></i>Mata pelajaran yang diajar</p>
                        <p><i class="fa-solid fa-people-group"></i>Pembimbing ekstrakurikuler</p>
                    </div>
                </article>
                <article class="person">
                    <div class="img-slot ratio-34" data-label="Foto">
                        <img src="{{ asset('media/guru/guru-7.jpg') }}" alt="Foto">
                    </div>
                    <div class="person-info">
                        <h3>Nama, Gelar</h3>
                        <p><i class="fa-solid fa-book-open"></i>Mata pelajaran yang diajar</p>
                        <p><i class="fa-solid fa-people-group"></i>Pembimbing ekstrakurikuler</p>
                    </div>
                </article>
                <article class="person">
                    <div class="img-slot ratio-34" data-label="Foto">
                        <img src="{{ asset('media/guru/guru-8.jpg') }}" alt="Foto">
                    </div>
                    <div class="person-info">
                        <h3>Nama, Gelar</h3>
                        <p><i class="fa-solid fa-book-open"></i>Mata pelajaran yang diajar</p>
                        <p><i class="fa-solid fa-people-group"></i>Pembimbing ekstrakurikuler</p>
                    </div>
                </article>
            </div>
            <div class="more-row">
                <button type="button" class="btn-more" data-toggle="extra-guru" aria-expanded="false">
                    <span>Selengkapnya</span> <i class="fa-solid fa-chevron-down"></i>
                </button>
            </div>
        </section>

        <!-- ===== STAF PEGAWAI ===== -->
        <section id="staff">
            <h2 class="group-title">Staff Pegawai</h2>
            <div class="person-grid">
                <article class="person">
                    <div class="img-slot ratio-34" data-label="Foto">
                        <img src="{{ asset('media/staff/staff-1.jpg') }}" alt="Foto">
                    </div>
                    <div class="person-info">
                        <h3>Nama, Gelar</h3>
                        <p><i class="fa-solid fa-book-open"></i>Mata pelajaran yang diajar</p>
                        <p><i class="fa-solid fa-people-group"></i>Pembimbing ekstrakurikuler</p>
                    </div>
                </article>
                <article class="person">
                    <div class="img-slot ratio-34" data-label="Foto">
                        <img src="{{ asset('media/staff/staff-2.jpg') }}" alt="Foto">
                    </div>
                    <div class="person-info">
                        <h3>Nama, Gelar</h3>
                        <p><i class="fa-solid fa-book-open"></i>Mata pelajaran yang diajar</p>
                        <p><i class="fa-solid fa-people-group"></i>Pembimbing ekstrakurikuler</p>
                    </div>
                </article>
                <article class="person">
                    <div class="img-slot ratio-34" data-label="Foto">
                        <img src="{{ asset('media/staff/staff-3.jpg') }}" alt="Foto">
                    </div>
                    <div class="person-info">
                        <h3>Nama, Gelar</h3>
                        <p><i class="fa-solid fa-book-open"></i>Mata pelajaran yang diajar</p>
                        <p><i class="fa-solid fa-people-group"></i>Pembimbing ekstrakurikuler</p>
                    </div>
                </article>
                <article class="person">
                    <div class="img-slot ratio-34" data-label="Foto">
                        <img src="{{ asset('media/staff/staff-4.jpg') }}" alt="Foto">
                    </div>
                    <div class="person-info">
                        <h3>Nama, Gelar</h3>
                        <p><i class="fa-solid fa-book-open"></i>Mata pelajaran yang diajar</p>
                        <p><i class="fa-solid fa-people-group"></i>Pembimbing ekstrakurikuler</p>
                    </div>
                </article>
            </div>

            <div id="extra-staff" class="person-grid extra" hidden>
                <article class="person">
                    <div class="img-slot ratio-34" data-label="Foto">
                        <img src="{{ asset('media/staff/staff-5.jpg') }}" alt="Foto">
                    </div>
                    <div class="person-info">
                        <h3>Nama, Gelar</h3>
                        <p><i class="fa-solid fa-book-open"></i>Mata pelajaran yang diajar</p>
                        <p><i class="fa-solid fa-people-group"></i>Pembimbing ekstrakurikuler</p>
                    </div>
                </article>
                <article class="person">
                    <div class="img-slot ratio-34" data-label="Foto">
                        <img src="{{ asset('media/staff/staff-6.jpg') }}" alt="Foto">
                    </div>
                    <div class="person-info">
                        <h3>Nama, Gelar</h3>
                        <p><i class="fa-solid fa-book-open"></i>Mata pelajaran yang diajar</p>
                        <p><i class="fa-solid fa-people-group"></i>Pembimbing ekstrakurikuler</p>
                    </div>
                </article>
            </div>
            <div class="more-row">
                <button type="button" class="btn-more" data-toggle="extra-staff" aria-expanded="false">
                    <span>Selengkapnya</span> <i class="fa-solid fa-chevron-down"></i>
                </button>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script defer src="{{ asset('js/profil-manajemen.js') }}"></script>
@endpush
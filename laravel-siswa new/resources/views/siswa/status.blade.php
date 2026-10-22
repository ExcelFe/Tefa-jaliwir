@extends('layouts.siswa')

@section('title', 'Status Guru')

@section('content')
    <header class="dash-head">
        <div class="dash-head__title">
            <h1 class="dash-title">Status Guru</h1>
            <p class="dash-sub">{{ $tanggalLabel }}</p>
        </div>
        <div class="dash-tools">
            <div class="dash-search" role="search">
                <input type="search" id="cari-guru" placeholder="Search name" aria-label="Search name" autocomplete="off">
                <img class="dash-icon" src="{{ asset('media/vector/search-icon.png') }}" alt="" width="24" height="24">
            </div>
        </div>
    </header>

    <!-- Hijau = hadir, merah = tidak hadir -->
    <ul class="dash-list" id="daftar-guru">
        @forelse ($guru as $g)
            <li class="dash-item" data-cari data-nama="{{ $g['nama'] }}">
                <div class="dash-card">
                    <span class="dash-card__name">{{ $g['nama'] }}</span>
                </div>
                <span class="dash-status {{ $g['status'] === 'hadir' ? 'dash-status--on' : 'dash-status--off' }}" role="img" aria-label="{{ $g['statusLabel'] }}"></span>
            </li>
        @empty
            <li class="dash-item">
                <div class="dash-card">
                    <span class="dash-card__name">Belum ada data absen guru pada {{ $tanggalLabel }}.</span>
                </div>
            </li>
        @endforelse

        {{-- Muncul hanya saat pencarian tidak menemukan guru --}}
        <li class="dash-item" id="cari-kosong" style="display:none">
            <div class="dash-card">
                <span class="dash-card__name">Guru tidak ditemukan.</span>
            </div>
        </li>
    </ul>

    {{-- Script ditaruh langsung di sini (bukan @push) supaya tetap jalan
         walaupun layouts.siswa tidak punya @stack('scripts'). --}}
    <script>
    (function () {
        var q = document.getElementById('cari-guru');
        var list = document.getElementById('daftar-guru');
        var kosong = document.getElementById('cari-kosong');
        if (!q || !list) return;

        // huruf kecil, buang aksen, titik/koma/spasi ganda -> satu spasi
        function norm(s) {
            s = String(s == null ? '' : s).toLowerCase();
            if (s.normalize) s = s.normalize('NFD').replace(/[\u0300-\u036f]/g, '');
            return s.replace(/[^a-z0-9]+/g, ' ').trim();
        }

        var items = Array.prototype.slice.call(list.querySelectorAll('.dash-item[data-cari]'));
        var index = items.map(function (li) {
            return { el: li, teks: ' ' + norm(li.getAttribute('data-nama') || li.textContent) + ' ' };
        });

        function filter() {
            var kata = norm(q.value).split(' ').filter(Boolean);
            var tampil = 0;

            index.forEach(function (it) {
                // semua kata yang diketik harus ada di nama guru
                var cocok = kata.every(function (k) { return it.teks.indexOf(k) !== -1; });
                it.el.style.display = cocok ? '' : 'none';
                if (cocok) tampil++;
            });

            if (kosong) kosong.style.display = (kata.length && index.length && !tampil) ? '' : 'none';
        }

        q.addEventListener('keydown', function (e) { if (e.key === 'Enter') e.preventDefault(); });
        ['input', 'keyup', 'search', 'change'].forEach(function (ev) { q.addEventListener(ev, filter); });

        filter(); // kalau browser mengisi ulang kolom cari saat reload
    })();
    </script>
@endsection
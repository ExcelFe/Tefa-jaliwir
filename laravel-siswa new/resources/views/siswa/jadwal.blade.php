@extends('layouts.siswa')

@section('title', 'Jadwal')

@section('content')
    <header class="dash-head">
        <div class="dash-head__title">
            <h1 class="dash-title">Jadwal Pelajaran (Per Kelas)</h1>
        </div>
    </header>

    <!-- Hijau = sedang berlangsung, merah = belum / sudah selesai -->
    <section class="dash-section" aria-labelledby="jadwal-hari-ini">
        <h2 class="dash-subtitle" id="jadwal-hari-ini">
            {{ $hari === $hariIni ? 'Jadwal Hari Ini' : 'Jadwal Hari ' . $hariList[$hari] }}{{ $kelas ? ' - ' . $kelas : '' }}
        </h2>

        @if ($akhirPekan)
            <p class="dash-note">Hari ini akhir pekan (tidak ada pelajaran). Pilih hari di bawah untuk melihat jadwal.</p>
        @endif

        <!-- Tab hari: link ke ?hari=... (server-side) -->
        <nav class="dash-daytabs" aria-label="Pilih hari">
            @foreach ($hariList as $key => $label)
                <a class="dash-daytab {{ $key === $hari ? 'is-active' : '' }}"
                   href="{{ route('siswa.jadwal', ['hari' => $key]) }}"
                   @if ($key === $hari) aria-current="page" @endif>{{ $label }}</a>
            @endforeach
        </nav>

        <ul class="dash-list">
            @forelse ($jadwal as $j)
                <li>
                    <div class="dash-jadwal-card {{ $j['status'] === 'Sedang Berlangsung' ? 'dash-jadwal-card--on' : 'dash-jadwal-card--off' }}" title="{{ $j['status'] }}">
                        <div class="dash-jadwal-card__info">
                            <span class="dash-jadwal-card__subject">{{ $j['mapel'] }}</span>
                            <span class="dash-jadwal-card__teacher">{{ $j['pengajar'] }}</span>
                        </div>
                        <span class="dash-jadwal-card__time">{{ $j['waktu'] }}</span>
                    </div>
                </li>
            @empty
                <li class="dash-item">
                    <div class="dash-card">
                        <span class="dash-card__name">
                            @if (!$kelas)
                                Kelas belum terdata pada akun ini.
                            @else
                                Belum ada jadwal untuk kelas {{ $kelas }} pada hari {{ $hariList[$hari] }}.
                            @endif
                        </span>
                    </div>
                </li>
            @endforelse
        </ul>
    </section>
@endsection
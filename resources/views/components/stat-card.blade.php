@props(['judul', 'nilai', 'ikon', 'warna'])

<div class="stat-card" style="border-left: 6px solid {{ $warna }};">
    <div class="stat-icon" style="color: {{ $warna }};">
        {{ $ikon }}
    </div>

    <div>
        <h4>{{ $judul }}</h4>
        <h2>{{ $nilai }}</h2>
    </div>
</div>

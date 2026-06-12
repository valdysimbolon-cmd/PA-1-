@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid px-4 py-4">

    {{-- HEADER & PENANDA TANGGAL --}}
    <div class="row align-items-center mb-4">
        <div class="col-md-7">
            <h1 class="h3 font-weight-bold text-dark mb-1">Dashboard Admin</h1>
            <p class="text-muted small mb-0">Manajemen Informasi Teknik Bioproses IT Del</p>
        </div>
        <div class="col-md-5">
            <div class="d-flex justify-content-md-end align-items-center mt-3 mt-md-0">
                {{-- Penanda Waktu & Tanggal Hari Ini --}}
                <div class="text-right mr-3 border-right pr-3 d-none d-sm-block">
                    <small class="text-muted d-block font-weight-bold text-uppercase" style="letter-spacing: 1px; font-size: 10px;">WAKTU SERVER</small>
                    <span class="font-weight-bold h5 mb-0 text-success">{{ $serverTime }} WIB</span>
                </div>
                <div class="bg-white p-2 px-3 shadow-sm rounded-lg border-left border-success border-4">
                    <small class="text-muted d-block font-weight-bold" style="font-size: 10px;">HARI INI</small>
                    <div class="d-flex align-items-center">
                        <i class="far fa-calendar-check text-success mr-2 fa-lg"></i>
                        <span class="font-weight-bold text-dark">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- STATISTIK UTAMA (8 KARTU) --}}
    <div class="row mb-4">
        @php
            // Pastikan tidak ada koma ganda di sini
            $stats = [
                ['label' => 'Berita', 'val' => $newsCount, 'icon' => 'fa-newspaper', 'color' => '#0F9D7A'],
                ['label' => 'Prestasi', 'val' => $achievementCount, 'icon' => 'fa-trophy', 'color' => '#F59E0B'],
                ['label' => 'Dosen', 'val' => $lecturerCount, 'icon' => 'fa-user-tie', 'color' => '#3B82F6'],
                ['label' => 'Fasilitas', 'val' => $facilityCount, 'icon' => 'fa-building', 'color' => '#06B6D4'],
                ['label' => 'Laboratorium', 'val' => $labCount, 'icon' => 'fa-microscope', 'color' => '#EF4444'],
                ['label' => 'Mata Kuliah', 'val' => $courseCount, 'icon' => 'fa-book', 'color' => '#4B5563'],
                ['label' => 'Kerja Sama', 'val' => $cooperationCount, 'icon' => 'fa-handshake', 'color' => '#8B5CF6'],
            ];
        @endphp

        @foreach($stats as $s)
        <div class="col-xl-3 col-lg-3 col-md-6 col-6 mb-3">
            <div class="card border-0 shadow-sm hover-up h-100" style="border-radius: 15px;">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-muted font-weight-bold" style="font-size: 11px; text-transform: uppercase;">{{ $s['label'] }}</small>
                            <h3 class="font-weight-bold mb-0 mt-1" style="color: #1a2d1a;">{{ $s['val'] }}</h3>
                        </div>
                        <div class="stat-icon" style="background-color: {{ $s['color'] }}20; color: {{ $s['color'] }};">
                            <i class="fas {{ $s['icon'] }}"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="row">
        {{-- GRAFIK --}}
        <div class="col-lg-8 mb-4">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 15px;">
                <div class="card-header bg-white border-0 py-3">
                    <h6 class="m-0 font-weight-bold text-dark"><i class="fas fa-chart-bar text-success mr-2"></i>Grafik Publikasi Berita ({{ date('Y') }})</h6>
                </div>
                <div class="card-body">
                    <div style="height: 300px;">
                        <canvas id="newsChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        {{-- AKTIVITAS --}}
        <div class="col-lg-4 mb-4">
            <div class="card border-0 shadow-sm mb-4" style="border-radius: 15px;">
                <div class="card-header bg-white border-0 py-3">
                    <h6 class="m-0 font-weight-bold text-dark"><i class="fas fa-history text-warning mr-2"></i>Berita Terbaru</h6>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @forelse($latestNews as $news)
                        <div class="list-group-item border-0 px-4 py-3">
                            <p class="mb-0 font-weight-bold text-dark small">{{ Str::limit($news->title, 45) }}</p>
                            <small class="text-muted">{{ $news->created_at->diffForHumans() }}</small>
                        </div>
                        @empty
                        <div class="text-center py-4 text-muted small">Belum ada berita.</div>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm bg-success text-white" style="border-radius: 15px; background: linear-gradient(135deg, #0F9D7A 0%, #087F5B 100%);">
                <div class="card-body p-4">
                    <h6 class="font-weight-bold mb-2">Aksi Cepat</h6>
                    <p class="small opacity-75 mb-3">Tambahkan pengumuman atau berita terbaru sekarang.</p>
                    <a href="{{ route('news.create') }}" class="btn btn-light btn-sm btn-block font-weight-bold text-success">
                       <i class="fas fa-plus-circle mr-1"></i> Tambah Berita
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .hover-up:hover { transform: translateY(-5px); transition: 0.3s; }
    .stat-icon { width: 45px; height: 45px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 18px; }
    .card { border-radius: 15px; }
</style>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const ctx = document.getElementById('newsChart').getContext('2d');
        
        // Gunakan sintaks ini agar lebih aman dari parse error Blade
        const newsData = {!! json_encode($monthlyNews) !!};

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                datasets: [{
                    label: 'Berita',
                    data: newsData,
                    backgroundColor: '#0F9D7A',
                    borderRadius: 5
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, ticks: { stepSize: 1 } },
                    x: { grid: { display: false } }
                }
            }
        });
    });
</script>
@endpush
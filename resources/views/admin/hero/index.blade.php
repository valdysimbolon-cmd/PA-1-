@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 text-gray-800">Manajemen Banner Hero</h1>
            <p class="text-muted small">Kelola banner video yang tampil di halaman utama</p>
        </div>
        <a href="{{ route('heroes.create') }}" class="btn btn-success btn-sm shadow-sm">
            <i class="fas fa-plus me-1"></i> Banner Baru
        </a>
    </div>

    <!-- Statistik sederhana -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-muted small">Aktif</span>
                            <h4 class="mb-0">{{ $heroes->where('active', true)->count() }}</h4>
                        </div>
                        <i class="fas fa-check-circle fa-2x text-success opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-muted small">Total Banner</span>
                            <h4 class="mb-0">{{ $heroes->count() }}</h4>
                        </div>
                        <i class="fas fa-images fa-2x text-primary opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Daftar Banner dalam bentuk kartu sederhana -->
    <div class="row g-4">
        @forelse($heroes as $hero)
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm">
                <!-- Thumbnail video -->
                @php
                    $videoId = null;
                    if ($hero->video_url) {
                        parse_str(parse_url($hero->video_url, PHP_URL_QUERY), $params);
                        $videoId = $params['v'] ?? null;
                        if (!$videoId && preg_match('/youtu\.be\/([^\/\?]+)/', $hero->video_url, $matches)) {
                            $videoId = $matches[1];
                        }
                    }
                @endphp
                @if($videoId)
                    <img src="https://img.youtube.com/vi/{{ $videoId }}/hqdefault.jpg" class="card-img-top" alt="Thumbnail" style="height: 180px; object-fit: cover;">
                @else
                    <div class="bg-light text-center py-5" style="height: 180px;">
                        <i class="fas fa-video-slash fa-3x text-muted"></i>
                    </div>
                @endif

                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <h5 class="card-title mb-1">{{ Str::limit($hero->title, 50) }}</h5>
                        @if($hero->active)
                            <span class="badge bg-success">Aktif</span>
                        @else
                            <span class="badge bg-secondary">Nonaktif</span>
                        @endif
                    </div>
                    @if($hero->subtitle)
                        <p class="card-text small text-muted mt-2">{{ Str::limit($hero->subtitle, 70) }}</p>
                    @endif
                    <div class="mt-3">
                        <span class="badge bg-light text-dark">{{ $hero->button_1_text ?? 'Daftar' }}</span>
                        <small class="text-muted ms-2"><i class="fab fa-youtube"></i> YouTube</small>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0 pb-3">
                    <div class="d-flex gap-2">
                        <a href="{{ route('heroes.edit', $hero->id) }}" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('heroes.destroy', $hero->id) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus banner ini?')">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="alert alert-info text-center py-5">
                <i class="fas fa-info-circle fa-2x mb-2"></i>
                <p>Belum ada banner. Klik <a href="{{ route('heroes.create') }}">Banner Baru</a> untuk menambahkan.</p>
            </div>
        </div>
        @endforelse
    </div>
</div>
@endsection
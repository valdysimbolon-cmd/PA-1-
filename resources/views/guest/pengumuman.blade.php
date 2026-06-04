@extends('layouts.guest_layout')

@section('content')
<div class="profil-header">
    <div class="container profil-header-inner text-center">
        <span class="bp-tag">Portal Informasi</span>
        <h1>Pusat <em>Pengumuman</em></h1>
    </div>
    <div class="profil-header-cut"></div>
</div>

<div class="profil-body bg-light py-5">
    <div class="container">
        {{-- List Pengumuman --}}
        <div class="row justify-content-center">
            <div class="col-lg-10">
                @forelse($announcements as $ann)
                    <a href="{{ route('public.announcements.show', $ann->id) }}" class="text-decoration-none">
                        <div class="card border-0 shadow-sm mb-3 rounded-4 p-3 ann-card">
                            <div class="d-flex align-items-center">
                                <div class="text-center border-end pe-4 me-4" style="min-width: 80px;">
                                    <span class="d-block fw-bold fs-3 text-success">{{ $ann->created_at->format('d') }}</span>
                                    <span class="text-uppercase small fw-bold text-muted">{{ $ann->created_at->format('M Y') }}</span>
                                </div>
                                <div class="flex-grow-1">
                                    <span class="badge bg-success-subtle text-success border-success small mb-1">{{ $ann->category->name ?? 'INFO' }}</span>
                                    <h5 class="fw-bold text-dark mb-0">{{ $ann->title }}</h5>
                                </div>
                                <div class="text-muted"><i class="bi bi-chevron-right"></i></div>
                            </div>
                        </div>
                    </a>
                @empty
                    <p class="text-center py-5 text-muted">Belum ada pengumuman.</p>
                @endforelse
            </div>
        </div>
        
        <div class="d-flex justify-content-center mt-4">
            {{ $announcements->links() }}
        </div>
    </div>
</div>

<style>
    .ann-card { transition: 0.3s; border-left: 5px solid transparent !important; }
    .ann-card:hover { border-left-color: var(--forest) !important; transform: translateX(10px); background: #f8fdf9; }
</style>
@endsection
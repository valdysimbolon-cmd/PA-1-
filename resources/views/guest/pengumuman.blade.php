@extends('layouts.guest_layout')

@section('title', 'Pengumuman - Teknik Bioproses IT Del')

@section('content')

{{-- ══════ HEADER ══════ --}}
<div class="profil-header">
    <div class="container profil-header-inner text-center">
        <span class="bp-tag">Informasi Resmi</span>
        <h1>Pusat <em>Pengumuman</em></h1>
        <p class="mx-auto" style="max-width: 750px;">
            Maklumat, informasi, dan instruksi penting bagi seluruh 
            civitas akademika Program Studi Teknik Bioproses.
        </p>
    </div>
    <div class="profil-header-cut"></div>
</div>

{{-- ══════ BODY ══════ --}}
<div class="profil-body bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                
                @forelse($announcements as $ann)
                    <div class="card border-0 shadow-sm mb-4 rounded-4 overflow-hidden">
                        <div style="height: 5px; background: var(--forest);"></div>
                        
                        <div class="card-body p-4">
                            <div class="mb-3">
                                <span class="text-muted small">
                                    <i class="bi bi-calendar3 me-1"></i> 
                                </span>
                            </div>

                            <h4 class="fw-bold mb-3" style="color: var(--forest); font-family: 'Playfair Display', serif;">
                                {{ $ann->title }}
                            </h4>
                            
                            <div class="text-muted mb-4" style="line-height: 1.7; font-size: 1.05rem;">
                                {!! $ann->content !!}
                            </div>

                            @if($ann->attachment_file)
                                <div class="mt-4 p-3 rounded-3 d-flex align-items-center justify-content-between border" style="background: #f8f9fa;">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="bi bi-file-earmark-text fs-4 text-success"></i>
                                        <span class="small fw-bold">Dokumen Lampiran Tersedia</span>
                                    </div>
                                    <a href="{{ asset('storage/' . $ann->attachment_file) }}" 
                                       target="_blank" 
                                       download 
                                       class="btn btn-success btn-sm rounded-pill px-4 shadow-sm fw-bold">
                                        <i class="bi bi-download me-1"></i> DOWNLOAD
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="text-center py-5">
                        <i class="bi bi-megaphone display-1 text-muted opacity-25"></i>
                        <p class="mt-3 text-muted">Belum ada pengumuman untuk saat ini.</p>
                    </div>
                @endforelse

                {{-- PAGINATION --}}
                <div class="mt-5 d-flex justify-content-center">
                    {{ $announcements->links() }}
                </div>

            </div>
        </div>
    </div>
</div>

<style>
.card { transition: transform 0.2s; }
.card:hover { transform: translateY(-5px); }
</style>

@endsection
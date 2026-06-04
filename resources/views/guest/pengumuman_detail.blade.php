@extends('layouts.guest_layout')

@section('title', $ann->title)

@section('content')
{{-- Bar Aksen Hijau Tipis & Elegan di Atas --}}
<div style="height: 8px; background-color: var(--forest); width: 100%;"></div>

<div class="bg-white" style="min-height: 100vh;">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                
                {{-- Judul --}}
                <h1 class="fw-bold mb-2" style="font-family: 'DM Sans', sans-serif; color: #1a1a1a; font-size: 2.5rem;">
                    {{ $ann->title }}
                </h1>
                
                {{-- Meta Info (Tanpa Kata 'By') --}}
                <div class="text-muted small mb-4">
                    <span class="fw-bold text-success">{{ $ann->category->name ?? 'Informasi' }}</span>
                    <span class="mx-2">/</span>
                    <span>{{ $ann->created_at->translatedFormat('d F Y') }}</span>
                </div>

                <hr class="mb-5 opacity-25">

                {{-- Isi Pengumuman (Rata Kanan Kiri) --}}
                <div class="ann-detail-content" style="line-height: 2; font-size: 1.15rem; text-align: justify; color: #333;">
                    {!! $ann->content !!}
                </div>

                {{-- Berkas Lampiran (Opsional) --}}
                @if($ann->attachment_file)
                    <div class="mt-5 p-4 rounded-4 d-flex align-items-center justify-content-between shadow-sm border bg-light">
                        <div class="d-flex align-items-center gap-3">
                            <i class="bi bi-file-earmark-pdf-fill fs-1 text-danger"></i>
                            <div>
                                <h6 class="fw-bold mb-0">Lampiran Dokumen Resmi</h6>
                                <small class="text-muted">Silakan unduh untuk informasi lebih lengkap.</small>
                            </div>
                        </div>
                        <a href="{{ asset('storage/' . $ann->attachment_file) }}" target="_blank" download class="btn btn-success rounded-pill px-4 fw-bold">
                            <i class="bi bi-download me-2"></i> DOWNLOAD
                        </a>
                    </div>
                @endif

                {{-- Tombol Kembali --}}
                <div class="text-start mt-5 pt-4 border-top">
                    <a href="{{ route('public.announcements') }}" class="text-success fw-bold text-decoration-none small">
                        <i class="bi bi-arrow-left me-2"></i> KEMBALI KE DAFTAR PENGUMUMAN
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
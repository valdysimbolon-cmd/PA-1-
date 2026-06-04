@extends('layouts.guest_layout')

@section('title', 'Kerjasama: ' . $mitra->name)

@section('content')

<style>
/* ── Container Utama ── */
.partner-detail-wrapper {
    background-color: #ffffff;
    padding-bottom: 5rem;
    min-height: 100vh;
}

/* ── Bar Hijau Elegan di Atas ── */
.top-accent-bar {
    height: 8px;
    background-color: var(--forest);
    width: 100%;
    margin-bottom: 4rem;
}

.article-container {
    max-width: 850px;
    margin: 0 auto;
    padding: 0 20px;
}

/* ── Judul ── */
.partner-title {
    font-family: 'DM Sans', sans-serif;
    font-weight: 800;
    font-size: clamp(1.8rem, 4vw, 2.6rem);
    color: #1a1a1a;
    line-height: 1.2;
    margin-bottom: 12px;
}

.partner-meta {
    font-size: 0.85rem;
    color: #888;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 2.5rem;
}

/* ── Frame Logo ── */
.partner-logo-large-box {
    background: #f8fdf9;
    padding: 3rem;
    border-radius: 20px;
    border: 1px solid #eef7f2;
    margin-bottom: 3rem;
    display: flex;
    justify-content: center;
    align-items: center;
}

.partner-logo-large-box img {
    max-height: 120px;
    width: auto;
    object-fit: contain;
}

/* ── Konten ── */
.partner-description {
    font-size: 1.12rem;
    line-height: 2;
    color: #333;
    text-align: justify; /* Rata Kanan Kiri */
}

/* ── Tombol Kembali ── */
.btn-back-minimal {
    display: inline-flex;
    align-items: center;
    margin-top: 4rem;
    color: var(--forest);
    text-decoration: none;
    font-weight: 700;
    font-size: 0.85rem;
    border-bottom: 2px solid transparent;
    transition: 0.3s;
}
.btn-back-minimal:hover {
    border-bottom-color: var(--accent);
    gap: 15px;
}
</style>

<div class="partner-detail-wrapper">
    {{-- Garis Hijau di Paling Atas --}}
    <div class="top-accent-bar"></div>

    <div class="article-container">
        
        {{-- 1. Header --}}
        <header class="text-start">
            <span class="badge mb-2" style="background: var(--accent); color: var(--forest);">
                <i class="bi bi-briefcase-fill me-1"></i> Mitra {{ $mitra->type }}
            </span>
            <h1 class="partner-title">{{ $mitra->name }}</h1>
            <div class="partner-meta">
                Terjalin sejak: {{ $mitra->start_date ? date('d M Y', strtotime($mitra->start_date)) : '-' }}
            </div>
        </header>

        {{-- 2. Logo Mitra Besar --}}
        <div class="partner-logo-large-box shadow-sm">
            <img src="{{ asset('storage/' . $mitra->logo) }}" alt="Logo Mitra">
        </div>

        {{-- 3. Deskripsi --}}
        <div class="partner-description">
            <h5 class="fw-bold text-forest mb-3">Mengenai Kerjasama</h5>
            {!! nl2br(e($mitra->description ?? 'Belum ada deskripsi detail mengenai bentuk kerjasama ini.')) !!}
            
            @if($mitra->website_url)
                <div class="mt-4">
                    <a href="{{ $mitra->website_url }}" target="_blank" class="btn btn-outline-success rounded-pill px-4 btn-sm">
                        Kunjungi Website Mitra <i class="bi bi-box-arrow-up-right ms-2"></i>
                    </a>
                </div>
            @endif
        </div>

        {{-- 4. Tombol Kembali --}}
        <div class="border-top mt-5">
            <a href="/" class="btn-back-minimal">
                <i class="bi bi-arrow-left me-2"></i> KEMBALI KE BERANDA
            </a>
        </div>

    </div>
</div>

@endsection
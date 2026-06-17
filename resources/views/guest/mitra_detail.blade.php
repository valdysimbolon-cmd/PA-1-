@extends('layouts.guest_layout')

@section('title', 'Detail Mitra — ' . $mitra->name)

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Playfair+Display:wght@700;800;900&display=swap" rel="stylesheet">

<style>
:root {
    --forest: #1A4D2E;
    --accent: #1D9E75;
    --body-bg: #F3F6F4;
    --text-main: #1E293B;
    --text-muted: #64748B;
    --white: #ffffff;
    --radius-lg: 24px;
    --shadow-premium: 0 25px 50px -12px rgba(26, 77, 46, 0.12);
}

body { 
    background-color: var(--body-bg); 
    font-family: 'Plus Jakarta Sans', sans-serif;
    color: var(--text-main);
    overflow-x: hidden;
}

/* ══════════════════════════════════════════
   REFINED HEADER (RESPONSIVE)
══════════════════════════════════════════ */
.ph-wrap {
    position: relative;
    /* Gunakan min-height agar header membesar otomatis jika teks panjang */
    min-height: 450px; 
    padding: 100px 0 160px; /* Padding bawah extra untuk ruang overlap card */
    display: flex;
    align-items: center;
    overflow: hidden;
    background-color: #000;
}

.ph-bg {
    position: absolute; inset: 0;
    background-image: url('{{ asset("guest_assets/img/mitra-detail-bg.jpeg") }}');
    background-size: cover;
    background-position: center 40%;
    transform: scale(1.02);
}

.ph-overlay {
    position: absolute; inset: 0;
    /* Gradient yang lebih gelap di bawah untuk memastikan teks putih selalu kontras */
    background: linear-gradient(to bottom, 
        rgba(15, 46, 27, 0.85) 0%, 
        rgba(15, 46, 27, 0.6) 60%, 
        rgba(15, 46, 27, 0.3) 100%);
}

.ph-inner {
    position: relative;
    z-index: 10;
    width: 100%;
}

.ph-eyebrow {
    color: var(--accent);
    font-weight: 800;
    text-transform:none;
    letter-spacing: 2px;
    font-size: 0.75rem;
    margin-bottom: 0.75rem;
    display: flex;
    align-items: center;
    gap: 10px;
}
.ph-eyebrow::after {
    content: "";
    height: 1px;
    width: 30px;
    background: var(--accent);
}

.ph-title {
    font-family: 'Playfair Display', serif;
    /* Font size mengecil otomatis di HP */
    font-size: clamp(2rem, 8vw, 3.5rem);
    color: var(--white);
    line-height: 1.2;
    margin-bottom: 1rem;
    font-weight: 800;
}

.ph-sub {
    color: rgba(255, 255, 255, 0.85);
    font-size: clamp(0.9rem, 4vw, 1.1rem);
    max-width: 700px;
}

/* ══════════════════════════════════════════
   CARD SECTION (RESPONSIVE OVERLAP)
══════════════════════════════════════════ */
.main-content-section {
    /* Margin negatif dikurangi di mobile agar tidak menabrak judul */
    margin-top: -80px; 
    position: relative;
    z-index: 20;
    padding-bottom: 4rem;
}

.premium-card {
    background: var(--white);
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-premium);
    overflow: hidden;
    border: 1px solid rgba(255,255,255,0.7);
}

/* Card Identity */
.card-identity {
    padding: 2.5rem;
    background: linear-gradient(to bottom, #ffffff, #f9fafb);
    display: flex;
    align-items: center;
    gap: 2rem;
    border-bottom: 1px solid #f1f5f9;
}

.logo-box {
    flex-shrink: 0;
    width: 120px;
    height: 120px;
    background: white;
    border-radius: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 1rem;
    box-shadow: 0 8px 20px rgba(0,0,0,0.04);
    border: 1px solid #f1f5f9;
}
.logo-box img {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
}

.identity-text h2 {
    font-family: 'Playfair Display', serif;
    font-size: clamp(1.5rem, 5vw, 2.2rem);
    color: var(--forest);
    margin-bottom: 0.5rem;
    font-weight: 800;
}

.badge-partner {
    background: var(--accent-light);
    color: var(--forest);
    padding: 4px 14px;
    border-radius: 50px;
    font-weight: 700;
    font-size: 0.7rem;
    letter-spacing: 0.5px;
    display: inline-block;
    margin-bottom: 8px;
    text-transform:none;
}

/* Deskripsi Area */
.description-area {
    padding: 3rem;
}

.prose-text {
    font-size: 1.1rem;
    line-height: 1.8;
    color: #475569;
    text-align: justify;
}

/* Info Grid */
.info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 1.5rem;
    margin-top: 3rem;
    padding: 2rem;
    background: var(--body-bg);
    border-radius: 20px;
}

.info-item h5 {
    font-size: 0.75rem;
    color: var(--text-muted);
    text-transform:none;
    margin-bottom: 0.4rem;
    letter-spacing: 1px;
}
.info-item p {
    font-weight: 700;
    font-size: 1rem;
    color: var(--forest);
    margin: 0;
}

.btn-premium-back {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    background: var(--forest);
    color: white;
    padding: 0.9rem 2rem;
    border-radius: 14px;
    text-decoration: none;
    font-weight: 700;
    margin-top: 2.5rem;
    transition: 0.3s;
}

/* ══════════════════════════════════════════
   MEDIA QUERIES (HP FIX)
══════════════════════════════════════════ */
@media (max-width: 768px) {
    .ph-wrap {
        padding: 80px 0 120px;
        min-height: 350px;
    }
    .main-content-section {
        margin-top: -60px; /* Lebih kecil di HP agar tidak nutup teks judul */
        padding: 0 15px 3rem;
    }
    .card-identity {
        flex-direction: column;
        text-align: center;
        padding: 2rem 1.5rem;
        gap: 1.5rem;
    }
    .logo-box {
        width: 100px;
        height: 100px;
    }
    .description-area {
        padding: 2rem 1.5rem;
    }
    .info-grid {
        grid-template-columns: 1fr; /* Tumpuk ke bawah di HP */
        text-align: center;
    }
}
</style>
@endpush

@section('content')

{{-- 1. HEADER --}}
<div class="ph-wrap">
    <div class="ph-bg"></div>
    <div class="ph-overlay"></div>
    
    <div class="container ph-inner">
        <div class="row">
            <div class="col-lg-10">
                <div class="ph-eyebrow">Jejaring Strategis</div>
                <h1 class="ph-title">{{ $mitra->name }}</h1>
                <p class="ph-sub">Kolaborasi bermakna antara Program Studi Teknik Bioproses IT Del dengan mitra strategis dalam memajukan inovasi berkelanjutan.</p>
            </div>
        </div>
    </div>
</div>

{{-- 2. CONTENT CARD --}}
<div class="container main-content-section">
    <div class="row justify-content-center">
        <div class="col-lg-11 col-xl-10">
            
            <div class="premium-card">
                {{-- Identity Section --}}
                <div class="card-identity">
                    <div class="logo-box">
                        @if($mitra->logo)
                            <img src="{{ asset('storage/' . $mitra->logo) }}" alt="{{ $mitra->name }}">
                        @else
                            <i class="bi bi-buildings text-muted" style="font-size: 3rem; opacity: 0.3;"></i>
                        @endif
                    </div>
                    <div class="identity-text">
                        <span class="badge-partner">{{ $mitra->type ?? 'STRATEGIC PARTNER' }}</span>
                        <h2>{{ $mitra->name }}</h2>
                        <p class="mb-0 text-muted small"><i class="bi bi-patch-check-fill text-accent me-1"></i> Terverifikasi sebagai mitra resmi IT Del</p>
                    </div>
                </div>

                {{-- Description Section --}}
                <div class="description-area">
                    <div class="prose-text">
                        {!! nl2br(e($mitra->description ?? 'Informasi detail mengenai bentuk kerjasama ini sedang dalam tahap pembaruan dokumentasi.')) !!}
                    </div>

                    <div class="info-grid">
                        <div class="info-item">
                            <h5>Mulai Kerjasama</h5>
                            <p><i class="bi bi-calendar-event me-1 text-accent"></i> 
                                {{ $mitra->start_date ? date('d M Y', strtotime($mitra->start_date)) : 'Tersedia' }}
                            </p>
                        </div>
                        <div class="info-item">
                            <h5>Kategori</h5>
                            <p><i class="bi bi-tag me-1 text-accent"></i> {{ $mitra->type ?? 'Umum' }}</p>
                        </div>
                    </div>

                    <div class="text-center">
                        <a href="{{ route('public.mitra.index') }}" class="btn-premium-back">
                            <i class="bi bi-arrow-left"></i> Kembali ke Daftar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@extends('layouts.guest_layout')

@section('title', 'Success Story — ' . ($testi->name ?? 'Detail'))

@push('styles')
<style>
/* ============================================
   TOKENS (sama dengan halaman lain)
============================================ */
:root {
    --forest:       #1A4D2E;
    --forest-deep:  #0f2e1b;
    --forest-mid:   #2E7D52;
    --accent:       #1D9E75;
    --accent-light: #E6F5EC;
    --cream:        #F4F8F5;
    --white:        #ffffff;
    --border:       #dce8e1;
    --muted:        #6b7280;
    --shadow-xs:    0 1px 3px rgba(26,77,46,.07);
    --shadow-sm:    0 2px 8px rgba(26,77,46,.09);
    --shadow-md:    0 4px 16px rgba(26,77,46,.12);
}

/* HEADER (gambar + overlay + wave) */
.ph-wrap {
    position: relative;
    padding: 6rem 0 0;
    overflow: hidden;
    min-height: 280px;
}
.ph-bg {
    position: absolute; inset: 0;
    background-image: url('{{ asset("guest_assets/img/testimoni-detail-bg.jpg") }}');
    background-size: cover;
    background-position: center 40%;
    filter: saturate(.85) brightness(.65);
}
.ph-overlay {
    position: absolute; inset: 0;
    background:
        radial-gradient(ellipse at 20% 15%, rgba(255,255,255,0.2) 0%, rgba(255,255,255,0) 70%),
        linear-gradient(90deg,
            rgba(8,24,14,.45) 0%,
            rgba(10,28,18,.35) 45%,
            rgba(8,20,12,.15) 75%,
            rgba(8,20,12,.05) 100%),
        linear-gradient(180deg,
            rgba(0,0,0,.05) 0%,
            rgba(0,0,0,.15) 100%);
}
.ph-grid {
    position: absolute; inset: 0;
    background-image:
        linear-gradient(rgba(29,158,117,.04) 1px, transparent 1px),
        linear-gradient(90deg, rgba(29,158,117,.04) 1px, transparent 1px);
    background-size: 40px 40px;
}
.ph-vignette {
    position: absolute; bottom: 0; left: 0; right: 0;
    height: 120px;
    background: linear-gradient(to bottom, transparent 0%, rgba(6,18,10,.55) 100%);
}
.ph-inner {
    position: relative; z-index: 3;
    padding-bottom: 3rem;
}
.ph-eyebrow {
    display: inline-flex;
    align-items: center;
    gap: .45rem;
    font-size: .7rem;
    font-weight: 700;
    letter-spacing: .18em;
    color: var(--accent);
    margin-bottom: 1rem;
    text-transform: none;
}
.ph-eyebrow::before {
    content: '';
    display: block;
    width: 18px; height: 2px;
    background: var(--accent);
}
.ph-title {
    font-family: 'Playfair Display', serif;
    font-size: clamp(2rem, 4vw, 2.8rem);
    font-weight: 800;
    color: #fff;
    line-height: 1.2;
    margin: 0;
    text-shadow: 0 2px 16px rgba(0,0,0,.35);
}
.ph-sub {
    font-size: .95rem;
    color: rgba(255,255,255,.7);
    max-width: 550px;
    line-height: 1.6;
    margin-top: 0.5rem;
}
.ph-wave {
    position: relative;
    height: 60px;
    overflow: hidden;
    margin-top: -1px;
    z-index: 4;
}
.ph-wave svg {
    position: absolute;
    bottom: 0; left: 0;
    width: 100%; height: 100%;
}

/* BODY DETAIL TESTIMONI */
.testimoni-detail-body {
    background: var(--cream);
    padding: 3rem 0 5rem;
}

/* Tombol kembali (mirip halaman detail mitra) */
.btn-back {
    display: inline-flex;
    align-items: center;
    gap: 0.6rem;
    background: white;
    color: var(--forest-mid);
    font-size: 0.85rem;
    font-weight: 500;
    text-decoration: none;
    padding: 0.6rem 1.2rem;
    border-radius: 40px;
    transition: all 0.25s ease;
    border: 1px solid var(--border);
    box-shadow: var(--shadow-xs);
    margin-bottom: 1.5rem;
}
.btn-back i {
    font-size: 1rem;
    transition: transform 0.2s;
}
.btn-back:hover {
    background: var(--forest);
    color: white;
    border-color: var(--forest);
    transform: translateX(-4px);
    box-shadow: var(--shadow-sm);
}
.btn-back:hover i {
    transform: translateX(-4px);
}

/* Hero card (avatar, nama, posisi, batch) */
.detail-hero {
    background: var(--white);
    border-radius: 2rem;
    padding: 2rem 1.5rem;
    text-align: center;
    margin-bottom: 2rem;
    box-shadow: var(--shadow-md);
    border: 1px solid var(--border);
}
.testi-avatar {
    width: 110px;
    height: 110px;
    border-radius: 50%;
    object-fit: cover;
    margin: 0 auto 1.2rem;
    border: 3px solid var(--accent);
    padding: 2px;
    background: white;
    box-shadow: var(--shadow-sm);
}
.detail-name {
    font-family: 'Playfair Display', serif;
    font-size: 1.8rem;
    font-weight: 800;
    color: var(--forest);
    margin-bottom: 0.3rem;
}
.testi-position {
    font-size: 0.8rem;
    font-weight: 600;
    color: var(--forest-mid);
    margin-bottom: 0.4rem;
}
.testi-batch {
    display: inline-block;
    background: var(--accent-light);
    color: var(--forest);
    font-size: 0.7rem;
    font-weight: 700;
    padding: 0.25rem 1rem;
    border-radius: 30px;
    letter-spacing: 0.3px;
}

/* Card isi testimoni */
.detail-section {
    background: var(--white);
    border-radius: 1.5rem;
    padding: 2rem;
    box-shadow: var(--shadow-sm);
    border: 1px solid var(--border);
    position: relative;
}
.detail-section-label {
    font-size: 0.7rem;
    font-weight: 700;
    letter-spacing: 0.1em;
    color: var(--accent);
    margin-bottom: 1rem;
    text-transform: uppercase;
}
.detail-prose {
    font-size: 1rem;
    line-height: 1.85;
    color: #2c3e32;
    text-align: justify;
}
.detail-prose p {
    margin-bottom: 1rem;
}
.detail-prose strong {
    color: var(--forest);
}

/* Tanda kutip elegan pakai pseudo-elements */
.detail-section {
    position: relative;
}
.detail-section::before {
    content: '"';
    font-size: 6rem;
    font-family: serif;
    color: var(--accent);
    opacity: 0.12;
    position: absolute;
    top: -0.5rem;
    left: 1rem;
    pointer-events: none;
}
.detail-section::after {
    content: '"';
    font-size: 6rem;
    font-family: serif;
    color: var(--accent);
    opacity: 0.12;
    position: absolute;
    bottom: -2rem;
    right: 1rem;
    pointer-events: none;
}

/* Responsif */
@media (max-width: 768px) {
    .testi-avatar { width: 80px; height: 80px; }
    .detail-name { font-size: 1.4rem; }
    .detail-section { padding: 1.5rem; }
    .detail-section::before, .detail-section::after { font-size: 4rem; opacity: 0.08; }
}
</style>
@endpush

@section('content')

{{-- HEADER dengan gaya konsisten --}}
<div class="ph-wrap">
    <div class="ph-bg"></div>
    <div class="ph-overlay"></div>
    <div class="ph-grid"></div>
    <div class="ph-vignette"></div>

    <div class="container ph-inner">
        <div class="ph-eyebrow">Inspirasi Alumni</div>
        <h1 class="ph-title">Suara <em>Civitas</em></h1>
        <p class="ph-sub">{{ $testi->name }} – {{ $testi->position ?? 'Alumni' }}</p>
    </div>

    <div class="ph-wave">
        <svg viewBox="0 0 1440 70" preserveAspectRatio="none" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0,40 C360,80 1080,0 1440,40 L1440,70 L0,70 Z" fill="var(--cream)"/>
        </svg>
    </div>
</div>

{{-- BODY DETAIL --}}
<div class="testimoni-detail-body">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">

                {{-- Tombol kembali --}}
                <a href="{{ route('public.testimoni.index') }}" class="btn-back">
                    <i class="bi bi-arrow-left"></i> Kembali ke Testimoni
                </a>

                {{-- Hero card identitas alumni --}}
                <div class="detail-hero">
                    @if($testi->photo)
                        <img src="{{ asset('storage/' . $testi->photo) }}" class="testi-avatar" alt="{{ $testi->name }}">
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($testi->name) }}&background=E6F5EC&color=1A4D2E&size=110&rounded=true" class="testi-avatar">
                    @endif
                    <div class="detail-name">{{ $testi->name }}</div>
                    <div class="testi-position">{{ $testi->position }}</div>
                    @if($testi->batch)
                        <div class="testi-batch">Angkatan {{ $testi->batch }}</div>
                    @endif
                </div>

                {{-- Isi testimoni dengan tanda kutip CSS --}}
                <div class="detail-section">
                    <div class="detail-section-label">Cerita sukses</div>
                    <div class="detail-prose">
                        {!! nl2br(e($testi->content)) !!}
                    </div>
                </div>

                <div class="text-center mt-4" style="font-size: 0.75rem; color: var(--muted);">
                    Program Studi Teknik Bioproses — Institut Teknologi Del
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
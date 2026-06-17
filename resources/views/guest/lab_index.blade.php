@extends('layouts.guest_layout')

@section('title', 'Unit Laboratorium - Teknik Bioproses IT Del')

@push('styles')
<style>
/* ══════════════════════════════════════════
   TOKENS (Identik dengan Kurikulum)
══════════════════════════════════════════ */
:root {
    --forest:       #1A4D2E;
    --forest-deep:  #0f2e1b;
    --forest-mid:   #2E7D52;
    --accent:       #1D9E75;
    --accent-light: #E6F5EC;
    --cream:        #F4F8F5;
    --ink:          #111827;
    --muted:        #6b7280;
    --border:       #dce8e1;
    --white:        #ffffff;
}

/* ══════════════════════════════════════════
   HEADER (Gaya Kurikulum - Rata Kiri)
══════════════════════════════════════════ */
.ph-wrap {
    position: relative;
    padding: 6rem 0 0;
    overflow: hidden;
    min-height: 380px;
    background: #000;
}

.ph-bg {
    position: absolute; inset: 0;
    background-image: url('{{ asset("guest_assets/img/lab-del.jpeg") }}');
    background-size: cover;
    background-position: center;
    filter: saturate(.85) brightness(.6);
}

.ph-overlay {
    position: absolute; inset: 0;
    background:
        radial-gradient(ellipse at 20% 15%, rgba(255, 255, 255, 0.15) 0%, rgba(255, 255, 255, 0) 70%),
        linear-gradient(90deg, rgba(8,24,14,.5) 0%, rgba(10,28,18,.3) 45%, transparent 100%);
}

.ph-grid {
    position: absolute; inset: 0;
    background-image: linear-gradient(rgba(29,158,117,.04) 1px, transparent 1px),
                      linear-gradient(90deg, rgba(29,158,117,.04) 1px, transparent 1px);
    background-size: 40px 40px;
}

.ph-vignette {
    position: absolute; bottom: 0; left: 0; right: 0;
    height: 120px;
    background: linear-gradient(to bottom, transparent 0%, rgba(6,18,10,.6) 100%);
}

.ph-inner {
    position: relative;
    z-index: 3;
    padding-bottom: 5rem;
}

.ph-eyebrow {
    display: inline-flex;
    align-items: center;
    gap: .5rem;
    font-size: .75rem;
    font-weight: 700;
    letter-spacing: .2em;
    color: var(--accent);
    margin-bottom: 1.5rem;
    text-transform: none;   /* ← tidak semua huruf besar */
}
.ph-eyebrow::before {
    content: '';
    width: 24px;
    height: 2px;
    background: var(--accent);
}

.ph-title {
    font-family: 'Playfair Display', serif;
    font-size: clamp(2.5rem, 5vw, 4rem);
    font-weight: 900;
    color: #fff;
    line-height: 1.1;
    margin-bottom: 1.2rem;
    text-transform: none;   /* ← tidak semua huruf besar */
}
.ph-title em {
    font-style: italic;
    color: var(--accent);
}

.ph-sub {
    font-size: 1rem;
    color: rgba(255,255,255,0.7);
    max-width: 600px;
    line-height: 1.8;
    margin: 0;              /* ← tidak center, rata kiri */
}

/* Scallop Wave */
.ph-wave {
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 70px;
    margin-bottom: -1px;
    z-index: 4;
}

/* ══════════════════════════════════════════
   LAB CARDS
══════════════════════════════════════════ */
.lab-card {
    background: var(--white);
    border-radius: 20px;
    border: 1px solid var(--border);
    overflow: hidden;
    transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
    height: 100%;
}

.lab-card:hover {
    transform: translateY(-12px);
    box-shadow: 0 20px 40px rgba(26,77,46,0.12);
    border-color: var(--accent);
}

.lab-img-wrap {
    position: relative;
    height: 240px;
    overflow: hidden;
}

.lab-img {
    width: 100%; height: 100%;
    object-fit: cover;
    transition: transform 0.6s ease;
}
.lab-card:hover .lab-img { transform: scale(1.08); }

.lab-cat-badge {
    position: absolute;
    top: 1.25rem;
    right: 1.25rem;
    background: rgba(26, 77, 46, 0.85);
    backdrop-filter: blur(8px);
    color: var(--white);
    padding: 0.4rem 1rem;
    font-size: 0.65rem;
    font-weight: 700;
    letter-spacing: 1px;
    border-radius: 50px;
    text-transform: uppercase;
}

.lab-content { padding: 2rem; text-align: center; }

.lab-name {
    font-family: 'Playfair Display', serif;
    font-size: 1.35rem;
    font-weight: 800;
    color: var(--forest);
    margin-bottom: 1rem;
    line-height: 1.3;
}

.lab-divider {
    width: 40px;
    height: 3px;
    background: var(--accent);
    margin: 1rem auto 1.5rem;
    border-radius: 2px;
}

.lab-link {
    font-size: 0.8rem;
    font-weight: 700;
    color: var(--accent);
    text-decoration: none;
    letter-spacing: 1px;
    transition: letter-spacing 0.3s;
    text-transform: none;   /* ← tidak all caps */
}
.lab-card:hover .lab-link {
    letter-spacing: 2px;
    color: var(--forest-mid);
}

</style>
@endpush

@section('content')

{{-- ══════ HEADER (Rata Kiri) ══════ --}}
<div class="ph-wrap">
    <div class="ph-bg"></div>
    <div class="ph-overlay"></div>
    <div class="ph-grid"></div>
    <div class="ph-vignette"></div>

    <div class="container ph-inner">
        <div class="ph-eyebrow">Fasilitas & Inovasi</div>
        <h1 class="ph-title">Unit <em>Laboratorium</em></h1>
        <p class="ph-sub">Mendukung eksplorasi teknologi bioproses melalui fasilitas riset unggulan dan standar keamanan tinggi.</p>
    </div>

    <div class="ph-wave">
        <svg viewBox="0 0 1440 70" preserveAspectRatio="none" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0,40 C360,80 1080,0 1440,40 L1440,70 L0,70 Z" fill="#F4F8F5" stroke="none"/>
        </svg>
    </div>
</div>

{{-- ══════ BODY ══════ --}}
<div class="profil-body py-5" style="background: var(--cream);">
    <div class="container py-5">
        <div class="row g-4 justify-content-center">
            @foreach($labs as $lab)
            <div class="col-lg-4 col-md-6">
                <a href="{{ route('public.lab.show', $lab->id) }}" class="text-decoration-none">
                    <div class="lab-card">
                        <div class="lab-img-wrap">
                            @if($lab->image)
                                <img src="{{ asset('storage/'.$lab->image) }}" class="lab-img" alt="{{ $lab->name }}">
                            @else
                                <div class="w-100 h-100 bg-secondary d-flex align-items-center justify-content-center text-white">
                                    <i class="bi bi-image fs-1"></i>
                                </div>
                            @endif
                            <span class="lab-cat-badge">{{ $lab->category ?? 'Laboratorium' }}</span>
                        </div>

                        <div class="lab-content">
                            <h3 class="lab-name">{{ $lab->name }}</h3>
                            <div class="lab-divider"></div>
                            <div class="lab-link">Jelajahi Unit <i class="bi bi-arrow-right ms-1"></i></div>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</div>

@endsection
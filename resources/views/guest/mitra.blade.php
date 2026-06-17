@extends('layouts.guest_layout')

@section('title', 'Mitra Strategis - Teknik Bioproses IT Del')

@push('styles')
<style>
/* ══════════════════════════════════════════
   TOKENS (sama dengan halaman lain)
══════════════════════════════════════════ */
:root {
    --forest:       #1A4D2E;
    --forest-deep:  #0f2e1b;
    --forest-mid:   #2E7D52;
    --accent:       #1D9E75;
    --accent-light: #E6F5EC;
    --accent-xlight:#f0faf5;
    --cream:        #F4F8F5;
    --ink:          #111827;
    --muted:        #6b7280;
    --border:       #dce8e1;
    --white:        #ffffff;
    --shadow-xs:    0 1px 3px rgba(26,77,46,.07), 0 1px 2px rgba(26,77,46,.04);
    --shadow-sm:    0 2px 8px rgba(26,77,46,.09), 0 1px 3px rgba(26,77,46,.06);
    --shadow-md:    0 4px 16px rgba(26,77,46,.12), 0 2px 6px rgba(26,77,46,.07);
}

/* ══════════════════════════════════════════
   HEADER (gaya mirip halaman lain)
══════════════════════════════════════════ */
.ph-wrap {
    position: relative;
    padding: 6rem 0 0;
    overflow: hidden;
    min-height: 340px;
}

.ph-bg {
    position: absolute; inset: 0;
    background-image: var(--bg-image, url('{{ asset("guest_assets/img/mitra-bg.jpg") }}'));
    background-size: cover;
    background-position: center 40%;
    filter: saturate(.85) brightness(.65);
}

.ph-overlay {
    position: absolute; inset: 0;
    background:
        radial-gradient(ellipse at 20% 15%, rgba(255, 255, 255, 0.2) 0%, rgba(255, 255, 255, 0) 70%),
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
    padding-bottom: 4rem;
}

.ph-eyebrow {
    display: inline-flex;
    align-items: center;
    gap: .45rem;
    font-size: .7rem;
    font-weight: 700;
    letter-spacing: .18em;
    color: var(--accent);
    margin-bottom: 1.25rem;
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
    font-size: clamp(2.4rem, 5vw, 3.8rem);
    font-weight: 900;
    color: #fff;
    line-height: 1.1;
    margin: 0 0 1rem;
    text-shadow: 0 2px 16px rgba(0,0,0,.35);
}
.ph-title em {
    font-style: italic;
    color: var(--accent);
}

.ph-sub {
    font-size: .98rem;
    color: rgba(255,255,255,.6);
    max-width: 600px;
    line-height: 1.8;
    margin: 0;
    text-shadow: 0 1px 6px rgba(0,0,0,.4);
}

.ph-wave {
    position: relative;
    height: 70px;
    overflow: hidden;
    margin-top: -1px;
    z-index: 4;
}
.ph-wave svg {
    position: absolute;
    bottom: 0; left: 0;
    width: 100%; height: 100%;
}

/* ══════════════════════════════════════════
   BODY MITRA & CARD
══════════════════════════════════════════ */
.mitra-body {
    background: var(--cream);
    padding: 3rem 0 5rem;
}

.partner-card {
    background: var(--white);
    border-radius: 1rem;
    padding: 1.5rem;
    text-align: center;
    transition: all 0.3s ease;
    height: 100%;
    border: 1px solid var(--border);
    box-shadow: var(--shadow-sm);
}
.partner-card:hover {
    transform: translateY(-8px);
    box-shadow: var(--shadow-md);
    border-color: var(--accent);
}
.partner-logo {
    height: 90px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 1rem;
}
.partner-logo img {
    max-height: 70px;
    max-width: 100%;
    object-fit: contain;
    transition: transform 0.2s;
}
.partner-card:hover .partner-logo img {
    transform: scale(1.02);
}
.partner-name {
    font-weight: 700;
    color: var(--forest);
    font-size: 0.9rem;
    margin-bottom: 0.25rem;
}
.partner-type {
    display: inline-block;
    background: var(--accent-light);
    color: var(--forest-mid);
    font-size: 0.65rem;
    font-weight: 600;
    padding: 0.2rem 0.7rem;
    border-radius: 30px;
    letter-spacing: 0.3px;
}

/* Pagination styling */
.pagination-wrapper {
    margin-top: 2.5rem;
}
.pagination {
    display: flex;
    justify-content: center;
    gap: 0.25rem;
    flex-wrap: wrap;
}
.pagination .page-item .page-link {
    color: var(--forest);
    background: var(--white);
    border: 1px solid var(--border);
    padding: 0.5rem 0.9rem;
    border-radius: 0.5rem;
    font-size: 0.85rem;
    transition: all 0.2s;
}
.pagination .page-item.active .page-link {
    background: var(--forest);
    border-color: var(--forest);
    color: white;
}
.pagination .page-item.disabled .page-link {
    background: var(--cream);
    color: var(--muted);
}
.pagination .page-item:not(.disabled):not(.active) .page-link:hover {
    background: var(--accent-light);
    border-color: var(--accent);
    color: var(--forest);
}

/* Responsive */
@media (max-width: 768px) {
    .partner-logo { height: 70px; }
    .partner-logo img { max-height: 55px; }
    .partner-name { font-size: 0.8rem; }
}
</style>
@endpush

@section('content')

{{-- ══════ HEADER dengan gaya sama ══════ --}}
<div class="ph-wrap">
    <div class="ph-bg"></div>
    <div class="ph-overlay"></div>
    <div class="ph-grid"></div>
    <div class="ph-vignette"></div>

    <div class="container ph-inner">
        <div class="ph-eyebrow">Jejaring Global</div>
        <h1 class="ph-title">Mitra <em>Strategis</em></h1>
        <p class="ph-sub">Kerjasama Teknik Bioproses dengan institusi akademik, industri, dan pemerintah.</p>
    </div>

    <div class="ph-wave">
        <svg viewBox="0 0 1440 70" preserveAspectRatio="none" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0,40 C360,80 1080,0 1440,40 L1440,70 L0,70 Z" fill="var(--cream)"/>
        </svg>
    </div>
</div>

{{-- ══════ BODY mitra dengan pagination ══════ --}}
<div class="mitra-body">
    <div class="container">
        <div class="row g-4">
            @forelse($mitras as $mitra)
                <div class="col-lg-3 col-md-4 col-6">
                    <a href="{{ route('public.mitra.show', $mitra->id) }}" class="text-decoration-none">
                        <div class="partner-card">
                            <div class="partner-logo">
                                <img src="{{ asset('storage/' . $mitra->logo) }}" alt="{{ $mitra->name }}">
                            </div>
                            <div class="partner-name">{{ $mitra->name }}</div>
                            <span class="partner-type">{{ $mitra->type }}</span>
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <p class="text-muted">Belum ada data mitra.</p>
                </div>
            @endforelse
        </div>

        {{-- PAGINATION LINKS --}}
        @if($mitras->hasPages())
            <div class="pagination-wrapper">
                {{ $mitras->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
</div>
@endsection
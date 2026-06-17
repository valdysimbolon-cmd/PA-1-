@extends('layouts.guest_layout')

@section('title', 'Ruangan & Sarana - Teknik Bioproses IT Del')

@push('styles')
<style>
/* ============================================
   TOKENS (Identik dengan lab)
============================================ */
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

/* HEADER (Sama persis dengan lab) */
.ph-wrap {
    position: relative;
    padding: 6rem 0 0;
    overflow: hidden;
    min-height: 380px;
    background: #000;
}

.ph-bg {
    position: absolute; inset: 0;
    background-image: url('{{ asset("guest_assets/img/facility-bg.jpg") }}');
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
    text-transform: none;
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
    text-transform: none;
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
    margin: 0;
}

.ph-wave {
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 70px;
    margin-bottom: -1px;
    z-index: 4;
}

/* FACILITY CARDS (Mirip lab-card) */
.facility-card {
    background: var(--white);
    border-radius: 20px;
    border: 1px solid var(--border);
    overflow: hidden;
    transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
    height: 100%;
    text-decoration: none;
    color: inherit;
    display: block;
}

.facility-card:hover {
    transform: translateY(-12px);
    box-shadow: 0 20px 40px rgba(26,77,46,0.12);
    border-color: var(--accent);
}

.facility-img-wrap {
    position: relative;
    height: 240px;
    overflow: hidden;
}

.facility-img {
    width: 100%; height: 100%;
    object-fit: cover;
    transition: transform 0.6s ease;
}
.facility-card:hover .facility-img { transform: scale(1.08); }

.facility-cat-badge {
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

.facility-content { padding: 2rem; text-align: center; }

.facility-name {
    font-family: 'Playfair Display', serif;
    font-size: 1.35rem;
    font-weight: 800;
    color: var(--forest);
    margin-bottom: 1rem;
    line-height: 1.3;
}

.facility-divider {
    width: 40px;
    height: 3px;
    background: var(--accent);
    margin: 1rem auto 1.5rem;
    border-radius: 2px;
}

.facility-link {
    font-size: 0.8rem;
    font-weight: 700;
    color: var(--accent);
    text-decoration: none;
    letter-spacing: 1px;
    transition: letter-spacing 0.3s;
    text-transform: none;
}
.facility-card:hover .facility-link {
    letter-spacing: 2px;
    color: var(--forest-mid);
}

/* Responsive */
@media (max-width: 991px) {
    .facility-card .facility-img-wrap { height: 200px; }
}
@media (max-width: 576px) {
    .ph-wrap { min-height: 300px; padding-top: 4rem; }
    .facility-card .facility-img-wrap { height: 180px; }
}
</style>
@endpush

@section('content')

{{-- ══════ HEADER ══════ --}}
<div class="ph-wrap">
    <div class="ph-bg"></div>
    <div class="ph-overlay"></div>
    <div class="ph-grid"></div>
    <div class="ph-vignette"></div>

    <div class="container ph-inner">
        <div class="ph-eyebrow">Fasilitas & Prasarana</div>
        <h1 class="ph-title">Ruangan & <em>Sarana</em></h1>
        <p class="ph-sub">Dukungan infrastruktur modern untuk menciptakan lingkungan belajar dan riset yang kondusif.</p>
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
            @forelse($facilities as $f)
            <div class="col-lg-4 col-md-6">
                <a href="{{ route('public.facility.show', $f->id) }}" class="facility-card">
                    <div class="facility-img-wrap">
                        @if($f->image)
                            <img src="{{ asset('storage/'.$f->image) }}" class="facility-img" alt="{{ $f->name }}">
                        @else
                            <div class="w-100 h-100 bg-secondary d-flex align-items-center justify-content-center text-white">
                                <i class="bi bi-door-open fs-1"></i>
                            </div>
                        @endif
                        <span class="facility-cat-badge">{{ $f->type ?? 'Sarana' }}</span>
                    </div>

                    <div class="facility-content">
                        <h3 class="facility-name">{{ $f->name }}</h3>
                        <div class="facility-divider"></div>
                        <div class="facility-link">Lihat Detail <i class="bi bi-arrow-right ms-1"></i></div>
                    </div>
                </a>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <p class="text-muted">Belum ada data sarana dan prasarana.</p>
            </div>
            @endforelse
        </div>
        {{-- Pagination jika menggunakan paginate --}}
        @if(method_exists($facilities, 'hasPages') && $facilities->hasPages())
            <div class="d-flex justify-content-center mt-5">
                {{ $facilities->links() }}
            </div>
        @endif
    </div>
</div>

@endsection
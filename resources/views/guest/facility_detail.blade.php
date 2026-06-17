@extends('layouts.guest_layout')

@section('title', $facility->name)

@push('styles')
<style>
/* ============================================
   TOKENS (Identik dengan lab detail)
============================================ */
:root {
    --forest:       #1A4D2E;
    --forest-deep:  #0f2e1b;
    --forest-mid:   #2E7D52;
    --accent:       #1D9E75;
    --accent-light: #E6F5EC;
    --cream:        #F4F8F5;
    --cream-deep:   #e8e0d0;
    --ink:          #111827;
    --muted:        #6b7280;
    --border:       #dce8e1;
    --white:        #ffffff;
    --shadow-sm:    0 2px 8px rgba(26,77,46,.09);
    --shadow-md:    0 8px 24px rgba(26,77,46,.12);
}

/* ── HEADER ── */
.ph-wrap {
    position: relative;
    padding: 6rem 0 0;
    overflow: hidden;
    min-height: 340px;
    background: var(--forest-deep);
}
.ph-bg {
    position: absolute; inset: 0;
    background-size: cover;
    background-position: center 40%;
    filter: saturate(.85) brightness(.65);
}
.ph-overlay {
    position: absolute; inset: 0;
    background:
        radial-gradient(ellipse at 20% 15%, rgba(255,255,255,0.15) 0%, rgba(255,255,255,0) 70%),
        linear-gradient(90deg, rgba(8,24,14,.65) 0%, rgba(10,28,18,.45) 45%, rgba(8,20,12,.25) 100%);
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
    gap: .5rem;
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
    font-size: clamp(2.2rem, 4vw, 3.2rem);
    font-weight: 900;
    color: #fff;
    line-height: 1.15;
    margin: 0 0 .5rem;
    text-shadow: 0 2px 16px rgba(0,0,0,.35);
}
.ph-location {
    font-size: .95rem;
    color: rgba(255,255,255,.6);
    display: flex;
    align-items: center;
    gap: .5rem;
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

/* ── BODY ── */
.facility-detail-body {
    background: var(--cream);
    padding: 3rem 0 5rem;
}

/* ── LAYOUT GRID (sidebar kiri seperti lab) ── */
.facility-grid-layout {
    display: grid;
    grid-template-columns: 260px 1fr;
    gap: 2.5rem;
    align-items: start;
}

/* ── SIDEBAR ── */
.facility-sidebar {
    position: sticky;
    top: 90px;
}
.facility-sidebar-card {
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: 1.25rem;
    overflow: hidden;
    box-shadow: var(--shadow-sm);
}
.facility-sidebar-head {
    background: var(--forest);
    padding: 1rem 1.25rem;
    display: flex;
    align-items: center;
    gap: .5rem;
}
.facility-sidebar-head-dot {
    width: 6px; height: 6px;
    border-radius: 50%;
    background: var(--accent);
}
.facility-sidebar-head span {
    font-size: .65rem;
    font-weight: 700;
    letter-spacing: .15em;
    color: rgba(255,255,255,.6);
    text-transform: none;
}
.facility-nav {
    padding: .5rem 0;
}
.facility-nav-item {
    display: flex;
    align-items: center;
    gap: .6rem;
    padding: .65rem 1.25rem;
    color: var(--muted);
    text-decoration: none;
    font-size: .85rem;
    font-weight: 500;
    border-left: 3px solid transparent;
    transition: all .2s;
}
.facility-nav-item:hover {
    background: var(--accent-light);
    color: var(--forest);
    border-left-color: var(--accent);
}
.facility-nav-item.active {
    background: var(--accent-light);
    color: var(--forest);
    font-weight: 700;
    border-left-color: var(--accent);
}
.facility-nav-dot {
    width: 6px; height: 6px;
    border-radius: 50%;
    background: var(--border);
    flex-shrink: 0;
    transition: background .2s;
}
.facility-nav-item.active .facility-nav-dot,
.facility-nav-item:hover .facility-nav-dot {
    background: var(--accent);
}
.facility-nav-back {
    display: inline-flex;
    align-items: center;
    gap: .5rem;
    padding: .6rem 1.25rem;
    color: var(--forest-mid);
    font-size: .8rem;
    font-weight: 600;
    text-decoration: none;
    transition: all .2s;
}
.facility-nav-back:hover {
    color: var(--forest);
    gap: .7rem;
}

/* ── CONTENT CARD ── */
.facility-card-content {
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: 1.25rem;
    padding: 2rem;
    box-shadow: var(--shadow-sm);
}
.facility-card-title {
    font-family: 'Playfair Display', serif;
    font-size: 1.4rem;
    font-weight: 800;
    color: var(--forest);
    margin: 0 0 .25rem;
}
.facility-card-divider {
    display: block;
    width: 40px;
    height: 3px;
    background: var(--accent);
    border-radius: 2px;
    margin-top: .5rem;
    margin-bottom: 1.5rem;
}
.facility-desc {
    font-size: 1rem;
    line-height: 1.9;
    color: #374151;
    text-align: justify;
}
.facility-desc p { margin-bottom: 1.25rem; }
.facility-desc p:last-child { margin-bottom: 0; }
.facility-desc strong { color: var(--forest); }

/* ── RESPONSIVE ── */
@media (max-width: 991px) {
    .facility-grid-layout { grid-template-columns: 1fr; }
    .facility-sidebar { position: static; }
    .facility-nav {
        display: flex;
        flex-wrap: wrap;
        gap: .25rem;
        padding: .5rem;
    }
    .facility-nav-item {
        flex: 1 1 auto;
        border-left: none !important;
        border-bottom: 2px solid transparent;
        border-radius: .5rem;
        justify-content: center;
        font-size: .78rem;
        padding: .5rem .75rem;
        min-width: calc(25% - .25rem);
    }
    .facility-nav-item.active,
    .facility-nav-item:hover {
        border-left: none !important;
        border-bottom-color: var(--accent);
    }
    .facility-nav-dot { display: none; }
    .facility-nav-back { justify-content: center; }
}
@media (max-width: 576px) {
    .ph-wrap { padding: 4rem 0 0; }
    .facility-card-content { padding: 1.25rem; }
    .facility-card-title { font-size: 1.2rem; }
}
</style>
@endpush

@section('content')

{{-- ══════ HEADER ══════ --}}
<div class="ph-wrap">
    {{-- Background dinamis dari gambar fasilitas --}}
    <div class="ph-bg" style="background-image: url('{{ $facility->image ? asset('storage/'.$facility->image) : asset('guest_assets/img/facility-detail-bg.jpg') }}');"></div>
    <div class="ph-overlay"></div>
    <div class="ph-grid"></div>
    <div class="ph-vignette"></div>

    <div class="container ph-inner">
        <div class="ph-eyebrow">Fasilitas & Prasarana</div>
        <h1 class="ph-title">{{ $facility->name }}</h1>
        @if($facility->location)
        <div class="ph-location">
            <i class="bi bi-geo-alt"></i>
            {{ $facility->location }}
        </div>
        @endif
    </div>

    <div class="ph-wave">
        <svg viewBox="0 0 1440 70" preserveAspectRatio="none" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0,40 C360,80 1080,0 1440,40 L1440,70 L0,70 Z" fill="var(--cream)"/>
        </svg>
    </div>
</div>

{{-- ══════ BODY ══════ --}}
<div class="facility-detail-body">
    <div class="container">
        <div class="facility-grid-layout">

            {{-- SIDEBAR --}}
            <aside class="facility-sidebar">
                <div class="facility-sidebar-card">
                    <div class="facility-sidebar-head">
                        <div class="facility-sidebar-head-dot"></div>
                        <span>Daftar Sarana</span>
                    </div>
                    <nav class="facility-nav">
                        @php $allFacilities = \App\Models\Facility::where('active', 1)->get(); @endphp
                        @foreach($allFacilities as $item)
                            <a href="{{ route('public.facility.show', $item->id) }}"
                               class="facility-nav-item {{ $item->id == $facility->id ? 'active' : '' }}">
                                <span class="facility-nav-dot"></span> {{ $item->name }}
                            </a>
                        @endforeach
                    </nav>
                    <div class="border-top">
                        <a href="{{ route('public.facilities') }}" class="facility-nav-back">
                            <i class="bi bi-arrow-left"></i> Kembali ke daftar
                        </a>
                    </div>
                </div>
            </aside>

            {{-- CONTENT --}}
            <div class="facility-content">
                <div class="facility-card-content">
                    <h2 class="facility-card-title">Gambaran Umum</h2>
                    <span class="facility-card-divider"></span>

                    @if($facility->image)
                        <img src="{{ asset('storage/'.$facility->image) }}"
                             class="img-fluid rounded-3 shadow-sm mb-4 w-100"
                             style="max-height: 420px; object-fit: cover;"
                             alt="{{ $facility->name }}">
                    @endif

                    @if($facility->type)
                        <span class="badge bg-success-subtle text-success border border-success px-3 py-2 small fw-bold mb-3 d-inline-block">
                            {{ $facility->type }}
                        </span>
                    @endif

                    @if($facility->capacity)
                        <p class="text-muted"><i class="bi bi-people"></i> Kapasitas: {{ $facility->capacity }} Orang</p>
                    @endif

                    <div class="facility-desc">
                        {!! $facility->description !!}
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection
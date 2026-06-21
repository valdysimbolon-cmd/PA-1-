@extends('layouts.guest_layout')

@section('title', $lab->name)

@push('styles')
<style>
/* ============================================
   TOKENS
============================================ */
:root {
    --forest:       #1A4D2E;
    --forest-deep:  #0f2e1b;
    --forest-mid:   #2E7D52;
    --accent:       #1D9E75;
    --accent-light: #E6F5EC;
    --accent-xlight:#f0faf5;
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
.lab-detail-body {
    background: var(--cream);
    padding: 3rem 0 5rem;
}

/* ── LAYOUT GRID ── */
.lab-grid {
    display: grid;
    grid-template-columns: 260px 1fr;
    gap: 2.5rem;
    align-items: start;
}

/* ── SIDEBAR ── */
.lab-sidebar {
    position: sticky;
    top: 90px;
}
.lab-sidebar-card {
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: 1.25rem;
    overflow: hidden;
    box-shadow: var(--shadow-sm);
}
.lab-sidebar-head {
    background: var(--forest);
    padding: 1rem 1.25rem;
    display: flex;
    align-items: center;
    gap: .5rem;
}
.lab-sidebar-head-dot {
    width: 6px; height: 6px;
    border-radius: 50%;
    background: var(--accent);
}
.lab-sidebar-head span {
    font-size: .65rem;
    font-weight: 700;
    letter-spacing: .15em;
    color: rgba(255,255,255,.6);
    text-transform: none;
}
.lab-nav {
    padding: .5rem 0;
}
.lab-nav-item {
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
.lab-nav-item:hover {
    background: var(--accent-light);
    color: var(--forest);
    border-left-color: var(--accent);
}
.lab-nav-item.active {
    background: var(--accent-light);
    color: var(--forest);
    font-weight: 700;
    border-left-color: var(--accent);
}
.lab-nav-dot {
    width: 6px; height: 6px;
    border-radius: 50%;
    background: var(--border);
    flex-shrink: 0;
    transition: background .2s;
}
.lab-nav-item.active .lab-nav-dot,
.lab-nav-item:hover .lab-nav-dot {
    background: var(--accent);
}
.lab-nav-back {
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
.lab-nav-back:hover {
    color: var(--forest);
    gap: .7rem;
}

/* ── CONTENT CARDS ── */
.lab-card {
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: 1.25rem;
    padding: 2rem;
    box-shadow: var(--shadow-sm);
}
.lab-card-title {
    font-family: 'Playfair Display', serif;
    font-size: 1.4rem;
    font-weight: 800;
    color: var(--forest);
    margin: 0 0 .25rem;
}
.lab-card-divider {
    display: block;
    width: 40px;
    height: 3px;
    background: var(--accent);
    border-radius: 2px;
    margin-top: .5rem;
    margin-bottom: 1.5rem;
}
.lab-desc {
    font-size: 1rem;
    line-height: 1.9;
    color: #374151;
    text-align: justify;
}
.lab-desc p { margin-bottom: 1.25rem; }
.lab-desc p:last-child { margin-bottom: 0; }
.lab-desc strong { color: var(--forest); }

/* ── inventoryS (horizontal layout) ── */
.inventorys-section {
    margin-top: 2rem;
    padding-top: 2rem;
    border-top: 1px solid var(--border);
}
.inventorys-section-label {
    font-size: .95rem;
    font-weight: 700;
    color: var(--forest);
    letter-spacing: .3px;
    margin-bottom: 1.25rem;
    display: flex;
    align-items: center;
    gap: .5rem;
}
.inventorys-section-label i {
    color: var(--accent);
    font-size: 1.1rem;
}
.inventory-grid {
    display: flex;
    flex-direction: column;
    gap: 1.25rem;
}
.inventory-card {
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: 1rem;
    overflow: hidden;
    transition: all .3s ease;
    box-shadow: var(--shadow-sm);
    display: flex;
    align-items: stretch;
}
.inventory-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--shadow-md);
    border-color: var(--accent);
}
.inventory-img-wrap {
    flex: 0 0 220px;
    height: 160px;
    background: var(--cream-deep);
    overflow: hidden;
    position: relative;
}
.inventory-img-wrap img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform .4s ease;
}
.inventory-card:hover .inventory-img-wrap img {
    transform: scale(1.04);
}
.inventory-img-placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--muted);
    opacity: .3;
    font-size: 3rem;
}
.inventory-body {
    flex: 1;
    padding: 1rem 1.5rem;
    display: flex;
    flex-direction: column;
    justify-content: center;
}
.inventory-name {
    font-size: 1.05rem;
    font-weight: 700;
    color: var(--forest);
    margin-bottom: .2rem;
    line-height: 1.3;
}
.inventory-desc {
    font-size: .88rem;
    color: var(--muted);
    line-height: 1.5;
    margin: 0;
}

/* ── EMPTY STATE ── */
.empty-state {
    text-align: center;
    padding: 2rem 1rem;
}
.empty-state i {
    font-size: 2.5rem;
    color: var(--border);
    display: block;
    margin-bottom: .75rem;
}
.empty-state p {
    color: var(--muted);
    font-size: .9rem;
    margin: 0;
}

/* ── RESPONSIVE ── */
@media (max-width: 991px) {
    .lab-grid { grid-template-columns: 1fr; }
    .lab-sidebar { position: static; }
    .lab-nav {
        display: flex;
        flex-wrap: wrap;
        gap: .25rem;
        padding: .5rem;
    }
    .lab-nav-item {
        flex: 1 1 auto;
        border-left: none !important;
        border-bottom: 2px solid transparent;
        border-radius: .5rem;
        justify-content: center;
        font-size: .78rem;
        padding: .5rem .75rem;
        min-width: calc(25% - .25rem);
    }
    .lab-nav-item.active,
    .lab-nav-item:hover {
        border-left: none !important;
        border-bottom-color: var(--accent);
    }
    .lab-nav-dot { display: none; }
    .lab-nav-back { justify-content: center; }
}
@media (max-width: 768px) {
    .inventory-card {
        flex-direction: column;
    }
    .inventory-img-wrap {
        flex: 0 0 auto;
        height: 180px;
        width: 100%;
    }
    .inventory-body {
        padding: 1rem 1.1rem 1.1rem;
    }
    .inventory-name { font-size: .95rem; }
    .inventory-desc { font-size: .82rem; }
}
@media (max-width: 576px) {
    .ph-wrap { padding: 4rem 0 0; }
    .lab-card { padding: 1.25rem; }
    .lab-card-title { font-size: 1.2rem; }
    .inventory-img-wrap { height: 150px; }
}
</style>
@endpush

@section('content')

{{-- ══════ HEADER ══════ --}}
<div class="ph-wrap">
    {{-- Background otomatis dari gambar lab --}}
    <div class="ph-bg" style="background-image: url('{{ $lab->image ? asset('storage/'.$lab->image) : asset('guest_assets/img/lab-detail-bg.jpg') }}');"></div>
    <div class="ph-overlay"></div>
    <div class="ph-grid"></div>
    <div class="ph-vignette"></div>

    <div class="container ph-inner">
        <div class="ph-eyebrow">Fasilitas Riset & Pendidikan</div>
        <h1 class="ph-title">{{ $lab->name }}</h1>
        <div class="ph-location">
            <i class="bi bi-geo-alt"></i>
            {{ $lab->location ?? 'Gedung Laboratorium — Institut Teknologi Del' }}
        </div>
    </div>

    <div class="ph-wave">
        <svg viewBox="0 0 1440 70" preserveAspectRatio="none" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0,40 C360,80 1080,0 1440,40 L1440,70 L0,70 Z" fill="var(--cream)"/>
        </svg>
    </div>
</div>

{{-- ══════ BODY ══════ --}}
<div class="lab-detail-body">
    <div class="container">
        <div class="lab-grid">

            {{-- SIDEBAR --}}
            <aside class="lab-sidebar">
                <div class="lab-sidebar-card">
                    <div class="lab-sidebar-head">
                        <div class="lab-sidebar-head-dot"></div>
                        <span>Unit Laboratorium</span>
                    </div>
                    <nav class="lab-nav">
                        @php $allLabs = \App\Models\Lab::where('active', 1)->get(); @endphp
                        @foreach($allLabs as $item)
                            <a href="{{ route('public.lab.show', $item->id) }}"
                               class="lab-nav-item {{ $item->id == $lab->id ? 'active' : '' }}">
                                <span class="lab-nav-dot"></span> {{ $item->name }}
                            </a>
                        @endforeach
                    </nav>
                    <div class="border-top">
                        <a href="{{ route('public.labs') }}" class="lab-nav-back">
                            <i class="bi bi-arrow-left"></i> Kembali ke daftar
                        </a>
                    </div>
                </div>
            </aside>

            {{-- CONTENT --}}
            <div class="lab-content">

                {{-- CARD: GAMBARAN UMUM + ALAT PENDUKUNG --}}
                <div class="lab-card">
                    <h2 class="lab-card-title">Gambaran Umum</h2>
                    <span class="lab-card-divider"></span>

                    @if($lab->image)
                        <img src="{{ asset('storage/'.$lab->image) }}"
                             class="img-fluid rounded-3 shadow-sm mb-4 w-100"
                             style="max-height: 420px; object-fit: cover;"
                             alt="{{ $lab->name }}">
                    @endif

                    <div class="lab-desc">
                        {!! $lab->description !!}
                    </div>

                    {{-- ALAT PENDUKUNG --}}
                    @if($lab->inventories->count() > 0)
                        <div class="inventorys-section">
                            <div class="inventorys-section-label">
                                <i class="bi bi-inventorys"></i> Berikut beberapa alat pendukung yang terdapat pada laboratorium ini
                            </div>
                            <div class="inventory-grid">
                                @foreach($lab->inventories as $inventory)
                                    <div class="inventory-card">
                                        <div class="inventory-img-wrap">
                                            @if($inventory->image)
                                                <img src="{{ asset('storage/' . $inventory->image) }}" alt="{{ $inventory->name }}">
                                            @else
                                                <div class="inventory-img-placeholder">
                                                    <i class="fas fa-microscope"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="inventory-body">
                                            <div class="inventory-name">{{ $inventory->name }}</div>
                                            <p class="inventory-desc">{{ $inventory->description ?? 'Tersedia untuk praktikum dan riset.' }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div class="empty-state">
                            <i class="bi bi-inbox"></i>
                            <p>Belum ada data alat pendukung untuk laboratorium ini.</p>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
</div>

@endsection
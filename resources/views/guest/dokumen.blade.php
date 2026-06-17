@extends('layouts.guest_layout')

@section('title', 'Dokumen & SOP - Teknik Bioproses IT Del')

@push('styles')
<style>
/* ============================================
   TOKENS (Identik dengan halaman lain)
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
    background-image: url('{{ asset("guest_assets/img/dokumen-bg.jpg") }}');
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
.ph-title em {
    font-style: italic;
    color: var(--accent);
}
.ph-sub {
    font-size: .95rem;
    color: rgba(255,255,255,.6);
    max-width: 600px;
    line-height: 1.6;
    margin: 0;
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
.dokumen-body {
    background: var(--cream);
    padding: 3rem 0 5rem;
}

/* ── LAYOUT GRID (sama seperti lab detail) ── */
.dokumen-grid {
    display: grid;
    grid-template-columns: 260px 1fr;
    gap: 2.5rem;
    align-items: start;
}

/* ── SIDEBAR ── */
.dokumen-sidebar {
    position: sticky;
    top: 90px;
}
.dokumen-sidebar-card {
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: 1.25rem;
    overflow: hidden;
    box-shadow: var(--shadow-sm);
}
.dokumen-sidebar-head {
    background: var(--forest);
    padding: 1rem 1.25rem;
    display: flex;
    align-items: center;
    gap: .5rem;
}
.dokumen-sidebar-head-dot {
    width: 6px; height: 6px;
    border-radius: 50%;
    background: var(--accent);
}
.dokumen-sidebar-head span {
    font-size: .65rem;
    font-weight: 700;
    letter-spacing: .15em;
    color: rgba(255,255,255,.6);
    text-transform: none;
}
.dokumen-nav {
    padding: .5rem 0;
}
.dokumen-nav-item {
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
    cursor: pointer;
    background: none;
    border-right: none;
    border-top: none;
    border-bottom: none;
    width: 100%;
    text-align: left;
}
.dokumen-nav-item:hover {
    background: var(--accent-light);
    color: var(--forest);
    border-left-color: var(--accent);
}
.dokumen-nav-item.active {
    background: var(--accent-light);
    color: var(--forest);
    font-weight: 700;
    border-left-color: var(--accent);
}
.dokumen-nav-dot {
    width: 6px; height: 6px;
    border-radius: 50%;
    background: var(--border);
    flex-shrink: 0;
    transition: background .2s;
}
.dokumen-nav-item.active .dokumen-nav-dot,
.dokumen-nav-item:hover .dokumen-nav-dot {
    background: var(--accent);
}
.dokumen-nav-divider {
    height: 1px;
    background: var(--border);
    margin: .2rem .75rem;
}

/* ── CONTENT ── */
.dokumen-content {
    min-width: 0;
}
.dokumen-card {
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: 1.25rem;
    padding: 2rem;
    box-shadow: var(--shadow-sm);
}
.dokumen-card-title {
    font-family: 'Playfair Display', serif;
    font-size: 1.4rem;
    font-weight: 800;
    color: var(--forest);
    margin: 0 0 .25rem;
}
.dokumen-card-divider {
    display: block;
    width: 40px;
    height: 3px;
    background: var(--accent);
    border-radius: 2px;
    margin-top: .5rem;
    margin-bottom: 1.5rem;
}

/* ── ITEM DOKUMEN ── */
.dokumen-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem 0;
    border-bottom: 1px solid var(--border);
    gap: 1rem;
}
.dokumen-item:last-child {
    border-bottom: none;
}
.dokumen-item-left {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    flex: 1;
    min-width: 0;
}
.dokumen-icon {
    font-size: 2.2rem;
    color: #dc3545;
    flex-shrink: 0;
    line-height: 1;
}
.dokumen-info {
    flex: 1;
    min-width: 0;
}
.dokumen-title {
    font-weight: 700;
    color: var(--forest);
    font-size: 1rem;
    margin-bottom: .2rem;
}
.dokumen-meta {
    display: flex;
    flex-wrap: wrap;
    gap: .5rem;
    align-items: center;
}
.dokumen-category {
    display: inline-block;
    background: var(--accent-light);
    color: var(--forest-mid);
    font-size: .65rem;
    font-weight: 700;
    padding: .2rem .6rem;
    border-radius: 30px;
    letter-spacing: .3px;
    border: 1px solid var(--border);
}
.dokumen-year {
    font-size: .75rem;
    color: var(--muted);
}
.dokumen-btn {
    display: inline-flex;
    align-items: center;
    gap: .4rem;
    background: var(--forest);
    color: white;
    padding: .4rem 1rem;
    border-radius: 30px;
    font-size: .75rem;
    font-weight: 600;
    text-decoration: none;
    transition: all .2s;
    border: none;
    cursor: pointer;
    flex-shrink: 0;
}
.dokumen-btn:hover {
    background: var(--forest-mid);
    transform: translateY(-2px);
    box-shadow: var(--shadow-sm);
    color: white;
}
.dokumen-empty {
    text-align: center;
    padding: 3rem 1rem;
    color: var(--muted);
}
.dokumen-empty i {
    font-size: 2.5rem;
    display: block;
    margin-bottom: .5rem;
    color: var(--border);
}

/* ── RESPONSIVE ── */
@media (max-width: 991px) {
    .dokumen-grid { grid-template-columns: 1fr; }
    .dokumen-sidebar { position: static; }
    .dokumen-nav {
        display: flex;
        flex-wrap: wrap;
        gap: .25rem;
        padding: .5rem;
    }
    .dokumen-nav-item {
        flex: 1 1 auto;
        border-left: none !important;
        border-bottom: 2px solid transparent;
        border-radius: .5rem;
        justify-content: center;
        font-size: .78rem;
        padding: .5rem .75rem;
        min-width: calc(25% - .25rem);
    }
    .dokumen-nav-item.active,
    .dokumen-nav-item:hover {
        border-left: none !important;
        border-bottom-color: var(--accent);
    }
    .dokumen-nav-dot { display: none; }
    .dokumen-nav-divider { display: none; }
    .dokumen-item { flex-direction: column; align-items: stretch; }
    .dokumen-btn { align-self: flex-start; }
}
@media (max-width: 576px) {
    .ph-wrap { padding: 4rem 0 0; }
    .dokumen-card { padding: 1.25rem; }
    .dokumen-card-title { font-size: 1.2rem; }
    .dokumen-item { padding: .8rem 0; }
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
        <div class="ph-eyebrow">Administrasi & Standar</div>
        <h1 class="ph-title">Dokumen & <em>SOP</em></h1>
        <p class="ph-sub">Akses resmi untuk pedoman akademik, standar operasional prosedur (SOP), dan berbagai berkas administrasi pendukung studi di Teknik Bioproses.</p>
    </div>

    <div class="ph-wave">
        <svg viewBox="0 0 1440 70" preserveAspectRatio="none" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0,40 C360,80 1080,0 1440,40 L1440,70 L0,70 Z" fill="var(--cream)"/>
        </svg>
    </div>
</div>

{{-- ══════ BODY ══════ --}}
<div class="dokumen-body">
    <div class="container">
        <div class="dokumen-grid">

            {{-- SIDEBAR --}}
            <aside class="dokumen-sidebar">
                <div class="dokumen-sidebar-card">
                    <div class="dokumen-sidebar-head">
                        <div class="dokumen-sidebar-head-dot"></div>
                        <span>Kategori Dokumen</span>
                    </div>
                    <nav class="dokumen-nav">
                        <button class="dokumen-nav-item active" data-target="all">
                            <span class="dokumen-nav-dot"></span> Semua
                        </button>
                        @php
                            $categories = ['Pedoman', 'SOP', 'Formulir', 'Lainnya'];
                        @endphp
                        @foreach($categories as $cat)
                            <button class="dokumen-nav-item" data-target="{{ Str::slug($cat) }}">
                                <span class="dokumen-nav-dot"></span> {{ $cat }}
                            </button>
                        @endforeach
                    </nav>
                </div>
            </aside>

            {{-- CONTENT --}}
            <div class="dokumen-content">

                {{-- PANEL SEMUA --}}
                <div class="dokumen-panel active" id="panel-all">
                    <div class="dokumen-card">
                        <h2 class="dokumen-card-title">Arsip Berkas Akademik</h2>
                        <span class="dokumen-card-divider"></span>
                        @forelse($archives as $doc)
                            <div class="dokumen-item">
                                <div class="dokumen-item-left">
                                    <div class="dokumen-icon"><i class="bi bi-file-earmark-pdf"></i></div>
                                    <div class="dokumen-info">
                                        <div class="dokumen-title">{{ $doc->title }}</div>
                                        <div class="dokumen-meta">
                                            <span class="dokumen-category">{{ $doc->category }}</span>
                                            <span class="dokumen-year">Tahun: {{ $doc->year ?? '-' }}</span>
                                        </div>
                                    </div>
                                </div>
                                <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" class="dokumen-btn">
                                    <i class="bi bi-download"></i> Unduh
                                </a>
                            </div>
                        @empty
                            <div class="dokumen-empty">
                                <i class="bi bi-inbox"></i>
                                <p>Belum ada dokumen yang tersedia.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                {{-- PANEL PER KATEGORI --}}
                @foreach($categories as $cat)
                <div class="dokumen-panel" id="panel-{{ Str::slug($cat) }}">
                    <div class="dokumen-card">
                        <h2 class="dokumen-card-title">{{ $cat }}</h2>
                        <span class="dokumen-card-divider"></span>
                        @php $filtered = $archives->where('category', $cat); @endphp
                        @forelse($filtered as $doc)
                            <div class="dokumen-item">
                                <div class="dokumen-item-left">
                                    <div class="dokumen-icon"><i class="bi bi-file-earmark-pdf"></i></div>
                                    <div class="dokumen-info">
                                        <div class="dokumen-title">{{ $doc->title }}</div>
                                        <div class="dokumen-meta">
                                            <span class="dokumen-category">{{ $doc->category }}</span>
                                            <span class="dokumen-year">Tahun: {{ $doc->year ?? '-' }}</span>
                                        </div>
                                    </div>
                                </div>
                                <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" class="dokumen-btn">
                                    <i class="bi bi-download"></i> Unduh
                                </a>
                            </div>
                        @empty
                            <div class="dokumen-empty">
                                <i class="bi bi-inbox"></i>
                                <p>Tidak ada dokumen dalam kategori ini.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
                @endforeach

            </div>
        </div>
    </div>
</div>

<script>
(function () {
    const navItems = document.querySelectorAll('.dokumen-nav-item');
    const panels   = document.querySelectorAll('.dokumen-panel');

    navItems.forEach(btn => {
        btn.addEventListener('click', () => {
            const target = btn.dataset.target;
            navItems.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            panels.forEach(p => p.classList.remove('active'));
            const panel = document.getElementById('panel-' + target);
            if (panel) panel.classList.add('active');
        });
    });
})();
</script>

@endsection
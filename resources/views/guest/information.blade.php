@extends('layouts.guest_layout')

@section('title', $title ?? 'Informasi Terkini')

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
    --gold:         #c8a84b;
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
    background-image: url('{{ asset("guest_assets/img/berita-bg.jpg") }}');
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
.berita-body {
    background: var(--cream);
    padding: 3rem 0 5rem;
}

/* ── FILTER NAV ── */
.filter-nav {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: .5rem;
    margin-bottom: 2rem;
}
.filter-btn {
    padding: .5rem 1.5rem;
    border-radius: 50px;
    font-size: .8rem;
    font-weight: 600;
    text-decoration: none;
    transition: all .25s;
    border: 2px solid var(--forest);
    color: var(--forest);
    background: transparent;
}
.filter-btn:hover {
    background: var(--accent-light);
}
.filter-btn.active {
    background: var(--forest);
    color: white;
    box-shadow: 0 4px 12px rgba(26,77,46,.25);
}
.filter-btn.primary {
    border-color: var(--forest-mid);
    color: var(--forest-mid);
}
.filter-btn.primary.active {
    background: var(--forest-mid);
    color: white;
    border-color: var(--forest-mid);
}

/* ── CARD ── */
.news-card {
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: 1.25rem;
    overflow: hidden;
    transition: all .3s ease;
    height: 100%;
    box-shadow: var(--shadow-sm);
}
.news-card:hover {
    transform: translateY(-8px);
    box-shadow: var(--shadow-md);
    border-color: var(--accent);
}
.news-card-img {
    height: 200px;
    object-fit: cover;
    background: var(--cream-deep);
}
.news-card-icon {
    height: 200px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--forest-mid);
}
.news-card-icon i {
    font-size: 4rem;
    color: rgba(255,255,255,.3);
}
.news-card-body {
    padding: 1.2rem 1.2rem 1.5rem;
}
.news-card-meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: .5rem;
}
.news-card-meta .date {
    font-size: .7rem;
    color: var(--muted);
}
.news-card-meta .badge-cat {
    font-size: .6rem;
    font-weight: 700;
    padding: .2rem .8rem;
    border-radius: 30px;
    text-transform: uppercase;
    letter-spacing: .3px;
}
.news-card-title {
    font-family: 'Playfair Display', serif;
    font-size: 1.05rem;
    font-weight: 700;
    color: var(--forest);
    line-height: 1.3;
    margin-bottom: .5rem;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.news-card-excerpt {
    font-size: .85rem;
    color: var(--muted);
    line-height: 1.5;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
    margin-bottom: 1rem;
}
.news-card-link {
    display: inline-flex;
    align-items: center;
    gap: .3rem;
    font-size: .7rem;
    font-weight: 700;
    color: var(--accent);
    text-decoration: none;
    letter-spacing: .5px;
    transition: letter-spacing .2s;
}
.news-card-link:hover {
    letter-spacing: 1px;
    color: var(--forest-mid);
}

/* ── PAGINATION ── */
.pagination-wrapper {
    margin-top: 2.5rem;
}
.pagination {
    display: flex;
    justify-content: center;
    gap: .25rem;
    flex-wrap: wrap;
}
.pagination .page-item .page-link {
    color: var(--forest);
    background: var(--white);
    border: 1px solid var(--border);
    padding: .5rem .9rem;
    border-radius: .5rem;
    font-size: .85rem;
    transition: all .2s;
}
.pagination .page-item.active .page-link {
    background: var(--forest);
    border-color: var(--forest);
    color: white;
}
.pagination .page-item:not(.active):not(.disabled) .page-link:hover {
    background: var(--accent-light);
    border-color: var(--accent);
}

/* ── EMPTY ── */
.empty-state {
    text-align: center;
    padding: 4rem 1rem;
}
.empty-state i {
    font-size: 3rem;
    color: var(--border);
    display: block;
    margin-bottom: 1rem;
}
.empty-state p {
    color: var(--muted);
    font-size: .95rem;
}

/* ── RESPONSIVE ── */
@media (max-width: 768px) {
    .filter-btn { font-size: .7rem; padding: .4rem 1rem; }
    .news-card-img { height: 160px; }
    .news-card-icon { height: 160px; }
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
        <div class="ph-eyebrow">Kabar Bioproses</div>
        <h1 class="ph-title">{{ $title ?? 'Berita & Kegiatan' }}</h1>
        <p class="ph-sub">Informasi aktivitas akademik dan kemahasiswaan Teknik Bioproses IT Del.</p>
    </div>

    <div class="ph-wave">
        <svg viewBox="0 0 1440 70" preserveAspectRatio="none" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0,40 C360,80 1080,0 1440,40 L1440,70 L0,70 Z" fill="var(--cream)"/>
        </svg>
    </div>
</div>

{{-- ══════ BODY ══════ --}}
<div class="berita-body">
    <div class="container">

        {{-- Filter --}}
        <div class="filter-nav">
            <a href="{{ route('public.news') }}" class="filter-btn {{ !request('category') && $type == 'news' ? 'active' : '' }}">
                Semua Berita
            </a>
            @foreach($categories as $cat)
                <a href="{{ route('public.news', ['category' => $cat]) }}" 
                   class="filter-btn {{ request('category') == $cat ? 'active' : '' }}">
                    {{ $cat }}
                </a>
            @endforeach
            <a href="{{ route('public.announcements') }}" 
               class="filter-btn primary {{ $type == 'announcement' ? 'active' : '' }}">
                <i class="bi bi-megaphone me-1"></i> Pengumuman
            </a>
        </div>

        {{-- Grid --}}
        <div class="row g-4">
            @forelse($items as $item)
                <div class="col-md-4">
                    <div class="news-card">
                        @if($item->type == 'news')
                            <img src="{{ asset('storage/' . $item->image) }}" class="news-card-img w-100" alt="{{ $item->title }}">
                        @else
                            <div class="news-card-icon">
                                <i class="bi bi-megaphone"></i>
                            </div>
                        @endif
                        <div class="news-card-body">
                            <div class="news-card-meta">
                                <span class="date"><i class="bi bi-calendar3 me-1"></i> {{ $item->created_at->format('d M Y') }}</span>
                                <span class="badge-cat {{ $item->type == 'news' ? 'text-success border border-success bg-success-subtle' : 'text-primary border border-primary bg-primary-subtle' }}">
                                    {{ $item->category ?? ($item->type == 'news' ? 'Berita' : 'Pengumuman') }}
                                </span>
                            </div>
                            <h5 class="news-card-title">{{ Str::limit($item->title, 55) }}</h5>
                            <p class="news-card-excerpt">{{ Str::limit(strip_tags($item->content), 120) }}</p>
                            <a href="{{ route('public.information.show', $item->id) }}" class="news-card-link">
                                Baca selengkapnya <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="empty-state">
                        <i class="bi bi-inbox"></i>
                        <p>Belum ada informasi untuk kategori ini.</p>
                    </div>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if(method_exists($items, 'hasPages') && $items->hasPages())
            <div class="pagination-wrapper">
                {{ $items->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
</div>

@endsection
@extends('layouts.guest_layout')

@section('title', $info->title)

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
    background-image: url('{{ $info->image ? asset("storage/".$info->image) : asset("guest_assets/img/berita-detail-bg.jpg") }}');
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
    font-size: clamp(2rem, 3.5vw, 2.8rem);
    font-weight: 900;
    color: #fff;
    line-height: 1.15;
    margin: 0 0 .5rem;
    text-shadow: 0 2px 16px rgba(0,0,0,.35);
}
.ph-sub {
    font-size: .9rem;
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
.detail-body {
    background: var(--cream);
    padding: 3rem 0 5rem;
}
.detail-card {
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: 1.25rem;
    padding: 2rem 2.5rem;
    box-shadow: var(--shadow-sm);
}
.detail-meta {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid var(--border);
    margin-bottom: 1.5rem;
    color: var(--muted);
    font-size: .85rem;
}
.detail-meta i {
    margin-right: .3rem;
    color: var(--accent);
}
.detail-badge {
    display: inline-block;
    background: var(--accent-light);
    color: var(--forest-mid);
    font-size: .6rem;
    font-weight: 700;
    padding: .2rem .8rem;
    border-radius: 30px;
    text-transform: uppercase;
    letter-spacing: .3px;
    border: 1px solid var(--border);
}
.detail-content {
    font-size: 1rem;
    line-height: 1.9;
    color: #374151;
    text-align: justify;
}
.detail-content p {
    margin-bottom: 1.25rem;
}
.detail-content strong {
    color: var(--forest);
}
.detail-attachment {
    margin-top: 2rem;
    padding: 1.2rem 1.5rem;
    background: var(--accent-xlight);
    border: 1px solid var(--accent);
    border-radius: 1rem;
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
}
.detail-attachment h6 {
    font-weight: 700;
    color: var(--forest);
    margin: 0;
}
.detail-attachment .btn-download {
    display: inline-flex;
    align-items: center;
    gap: .5rem;
    background: var(--forest);
    color: white;
    padding: .5rem 1.2rem;
    border-radius: 40px;
    font-size: .8rem;
    font-weight: 600;
    text-decoration: none;
    transition: all .2s;
}
.detail-attachment .btn-download:hover {
    background: var(--forest-mid);
    transform: translateY(-2px);
    box-shadow: var(--shadow-sm);
}
.btn-back {
    display: inline-flex;
    align-items: center;
    gap: .5rem;
    color: var(--forest-mid);
    font-weight: 600;
    text-decoration: none;
    transition: all .2s;
    margin-top: 1.5rem;
}
.btn-back:hover {
    color: var(--forest);
    gap: .7rem;
}

/* ── RESPONSIVE ── */
@media (max-width: 768px) {
    .detail-card { padding: 1.2rem; }
    .detail-meta { font-size: .75rem; gap: .75rem; }
    .detail-attachment { flex-direction: column; text-align: center; }
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
        <div class="ph-eyebrow">{{ $info->type == 'news' ? 'Berita' : 'Pengumuman' }}</div>
        <h1 class="ph-title">{{ $info->title }}</h1>
        <p class="ph-sub">
            {{ $info->category }} · 
            {{ $info->published_at ? $info->published_at->format('d F Y') : $info->created_at->format('d F Y') }}
        </p>
    </div>

    <div class="ph-wave">
        <svg viewBox="0 0 1440 70" preserveAspectRatio="none" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0,40 C360,80 1080,0 1440,40 L1440,70 L0,70 Z" fill="var(--cream)"/>
        </svg>
    </div>
</div>

{{-- ══════ BODY ══════ --}}
<div class="detail-body">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">

                <div class="detail-card">
                    {{-- Meta --}}
                    <div class="detail-meta">
                        <span><i class="bi bi-person-circle"></i> Admin Bioproses</span>
                        <span><i class="bi bi-calendar3"></i> 
                            {{ $info->published_at ? $info->published_at->format('d F Y') : $info->created_at->format('d F Y') }}
                        </span>
                        <span class="detail-badge">{{ $info->category ?? ($info->type == 'news' ? 'Berita' : 'Pengumuman') }}</span>
                    </div>

                    {{-- Gambar detail (jika ada dan bukan pengumuman) --}}
                    @if($info->type == 'news' && $info->image)
                        <img src="{{ asset('storage/' . $info->image) }}" class="img-fluid rounded-3 shadow-sm mb-4 w-100" style="max-height: 420px; object-fit: cover;" alt="{{ $info->title }}">
                    @endif

                    {{-- Konten --}}
                    <div class="detail-content">
                        {!! $info->content !!}
                    </div>

                    {{-- Lampiran (khusus pengumuman) --}}
                    @if($info->type == 'announcement' && $info->attachment_file)
                        <div class="detail-attachment">
                            <div>
                                <h6><i class="bi bi-paperclip me-1"></i> Lampiran Dokumen</h6>
                                <p class="text-muted small mb-0">Unduh berkas resmi pengumuman ini.</p>
                            </div>
                            <a href="{{ asset('storage/' . $info->attachment_file) }}" class="btn-download" target="_blank">
                                <i class="bi bi-file-earmark-pdf"></i> Download
                            </a>
                        </div>
                    @endif

                    {{-- Tombol kembali --}}
                    <a href="javascript:history.back()" class="btn-back">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection
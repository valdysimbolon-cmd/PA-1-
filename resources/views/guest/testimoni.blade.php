@extends('layouts.guest_layout')

@section('title', 'Suara Alumni - Teknik Bioproses IT Del')

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
    --accent-xlight:#f0faf5;
    --cream:        #F4F8F5;
    --ink:          #111827;
    --muted:        #6b7280;
    --border:       #dce8e1;
    --white:        #ffffff;
    --shadow-xs:    0 1px 3px rgba(26,77,46,.07);
    --shadow-sm:    0 2px 8px rgba(26,77,46,.09);
    --shadow-md:    0 4px 16px rgba(26,77,46,.12);
}

/* HEADER (dengan gambar, glossy, wave) */
.ph-wrap {
    position: relative;
    padding: 6rem 0 0;
    overflow: hidden;
    min-height: 340px;
}
.ph-bg {
    position: absolute; inset: 0;
    background-image: url('{{ asset("guest_assets/img/testimoni-bg.jpg") }}');
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
    line-height: 1.6;
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

/* BODY & CARD TESTIMONI (bagian kata alumni lebih baik) */
.testimoni-body {
    background: var(--cream);
    padding: 3rem 0 5rem;
}

.testi-card {
    background: var(--white);
    border-radius: 1.5rem;
    padding: 1.8rem;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    height: 100%;
    display: flex;
    flex-direction: column;
    border: 1px solid var(--border);
    box-shadow: var(--shadow-sm);
}
.testi-card:hover {
    transform: translateY(-6px);
    box-shadow: var(--shadow-md);
    border-color: var(--accent);
}

/* Avatar */
.testi-avatar {
    width: 72px;
    height: 72px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid var(--accent);
    padding: 2px;
    background: white;
    box-shadow: var(--shadow-xs);
}

/* Nama alumni & angkatan – lebih sejajar */
.testi-name {
    font-family: 'Playfair Display', serif;
    font-size: 1.2rem;
    font-weight: 800;
    color: var(--forest);
    margin-bottom: 0.2rem;
    line-height: 1.3;
}
.testi-batch {
    font-size: 0.7rem;
    font-weight: 700;
    color: var(--accent);
    text-transform: uppercase;
    letter-spacing: 0.5px;
    background: var(--accent-light);
    display: inline-block;
    padding: 0.2rem 0.8rem;
    border-radius: 50px;
}

/* Kutipan alumni – lebih hidup dengan tanda petik */
.testi-quote {
    font-size: 0.95rem;
    line-height: 1.7;
    color: #2c3e32;
    text-align: justify;
    margin: 1.2rem 0;
    flex: 1;
    font-style: italic;
    position: relative;
    padding: 0 0.5rem;
}
.testi-quote::before {
    content: '"';
    font-size: 2rem;
    color: var(--accent);
    opacity: 0.3;
    position: absolute;
    left: -0.2rem;
    top: -0.5rem;
    font-family: serif;
}
.testi-quote::after {
    content: '"';
    font-size: 2rem;
    color: var(--accent);
    opacity: 0.3;
    position: absolute;
    right: -0.2rem;
    bottom: -1rem;
    font-family: serif;
}

/* Footer : posisi alumni + link detail */
.testi-footer {
    border-top: 1px solid var(--border);
    padding-top: 0.8rem;
    margin-top: 0.5rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.testi-position {
    font-size: 0.7rem;
    font-weight: 700;
    color: var(--forest-mid);
    background: var(--accent-light);
    padding: 0.25rem 0.8rem;
    border-radius: 30px;
}
.testi-detail-link {
    font-size: 0.75rem;
    font-weight: 600;
    color: var(--muted);
    transition: color 0.2s;
    letter-spacing: 0.3px;
}
.testi-card:hover .testi-detail-link {
    color: var(--accent);
    text-decoration: underline;
}

/* Pagination (opsional) */
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

/* Responsif */
@media (max-width: 768px) {
    .testi-avatar { width: 55px; height: 55px; }
    .testi-name { font-size: 1rem; }
    .testi-quote { font-size: 0.85rem; }
    .testi-card { padding: 1.2rem; }
    .testi-quote::before, .testi-quote::after { font-size: 1.5rem; opacity: 0.2; }
}
</style>
@endpush

@section('content')

{{-- HEADER dengan background (sama seperti halaman profil, beasiswa) --}}
<div class="ph-wrap">
    <div class="ph-bg"></div>
    <div class="ph-overlay"></div>
    <div class="ph-grid"></div>
    <div class="ph-vignette"></div>

    <div class="container ph-inner">
        <div class="ph-eyebrow">Inspirasi Alumni</div>
        <h1 class="ph-title">Suara <em>Civitas</em></h1>
        <p class="ph-sub">Cerita sukses dan pengalaman belajar dari para alumni serta mahasiswa Teknik Bioproses IT Del.</p>
    </div>

    <div class="ph-wave">
        <svg viewBox="0 0 1440 70" preserveAspectRatio="none" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0,40 C360,80 1080,0 1440,40 L1440,70 L0,70 Z" fill="var(--cream)"/>
        </svg>
    </div>
</div>

{{-- BODY DAFTAR TESTIMONI --}}
<div class="testimoni-body">
    <div class="container">
        <div class="row g-4">
            @forelse($testimonials as $testi)
                <div class="col-lg-4 col-md-6">
                    <a href="{{ route('public.testimoni.show', $testi->id) }}" class="text-decoration-none">
                        <div class="testi-card">
                            <div class="d-flex align-items-center gap-3 mb-3">
                                @if($testi->photo)
                                    <img src="{{ asset('storage/' . $testi->photo) }}" class="testi-avatar" alt="{{ $testi->name }}">
                                @else
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($testi->name) }}&background=E6F5EC&color=1A4D2E&size=80&rounded=true" class="testi-avatar">
                                @endif
                                <div>
                                    <div class="testi-name">{{ $testi->name }}</div>
                                    <div class="testi-batch">Angkatan {{ $testi->batch }}</div>
                                </div>
                            </div>
                            <div class="testi-quote">
                                {{ Str::limit(strip_tags($testi->content), 150) }}
                            </div>
                            <div class="testi-footer">
                                <span class="testi-detail-link">Baca selengkapnya →</span>
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <div class="alert alert-info shadow-sm border-0 rounded-4">Belum ada data testimoni yang tersedia di database.</div>
                </div>
            @endforelse
        </div>

        @if(method_exists($testimonials, 'hasPages') && $testimonials->hasPages())
            <div class="pagination-wrapper">
                {{ $testimonials->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
</div>

@endsection
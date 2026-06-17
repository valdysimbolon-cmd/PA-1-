@extends('layouts.guest_layout')

@section('title', 'Dosen & Staf - Teknik Bioproses IT Del')

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
    --shadow-xs:    0 1px 3px rgba(26,77,46,.07);
    --shadow-sm:    0 2px 8px rgba(26,77,46,.09);
    --shadow-md:    0 4px 16px rgba(26,77,46,.12);
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
    background-image: url('{{ asset("guest_assets/img/dosen-bg.jpg") }}');
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
.ds-body {
    background: var(--cream);
    padding: 3rem 0 5rem;
}

.ds-group-title {
    font-family: 'Playfair Display', serif;
    font-size: 1.8rem;
    font-weight: 700;
    color: var(--forest);
    margin: 2rem 0 1.5rem;
    padding-bottom: 0.5rem;
    border-bottom: 2px solid var(--accent);
    display: inline-block;
}
.ds-group-section {
    margin-bottom: 3rem;
}

/* ── KARTU DOSEN/STAF (5 kolom) ── */
.ds-grid {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 1.5rem;
}

.ds-card {
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: 1.25rem;
    overflow: hidden;
    text-decoration: none;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    height: 100%;
    display: flex;
    flex-direction: column;
    box-shadow: var(--shadow-xs);
}
.ds-card:hover {
    transform: translateY(-8px);
    box-shadow: var(--shadow-md);
    border-color: var(--accent);
}

.ds-img-container {
    height: 240px;
    overflow: hidden;
    background: var(--cream-deep);
}
.ds-img-container img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center top;
    transition: transform 0.5s;
}
.ds-card:hover .ds-img-container img {
    transform: scale(1.05);
}

.ds-info {
    padding: 1.2rem;
    text-align: center;
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: center;
}
.ds-name {
    font-family: 'Playfair Display', serif;
    font-size: 1.05rem;
    font-weight: 700;
    color: var(--forest);
    margin-bottom: 0.2rem;
    line-height: 1.3;
}
.ds-pos {
    font-size: 0.75rem;
    font-weight: 600;
    color: var(--accent);
    margin-bottom: 0.15rem;
}
.ds-sub {
    font-size: 0.7rem;
    color: var(--muted);
}

/* ── RESPONSIVE ── */
@media (max-width: 1199px) {
    .ds-grid { grid-template-columns: repeat(4, 1fr); }
}
@media (max-width: 991px) {
    .ds-grid { grid-template-columns: repeat(3, 1fr); }
    .ds-img-container { height: 200px; }
}
@media (max-width: 576px) {
    .ds-grid { grid-template-columns: repeat(2, 1fr); gap: 1rem; }
    .ds-img-container { height: 160px; }
    .ds-info { padding: 0.8rem; }
    .ds-name { font-size: 0.9rem; }
    .ds-group-title { font-size: 1.4rem; margin: 1.5rem 0 1rem; }
}
@media (max-width: 400px) {
    .ds-grid { grid-template-columns: 1fr; }
    .ds-img-container { height: 240px; }
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
        <div class="ph-eyebrow">Civitas Akademika</div>
        <h1 class="ph-title">Dosen & <em>Staf</em></h1>
        <p class="ph-sub">Kenali lebih dekat tenaga pendidik, asisten dosen, dan tenaga kependidikan di Program Studi Teknik Bioproses Institut Teknologi Del.</p>
    </div>

    <div class="ph-wave">
        <svg viewBox="0 0 1440 70" preserveAspectRatio="none" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0,40 C360,80 1080,0 1440,40 L1440,70 L0,70 Z" fill="var(--cream)"/>
        </svg>
    </div>
</div>

{{-- ══════ BODY ══════ --}}
<div class="ds-body">
    <div class="container">
        @if($totalCount == 0)
            <p class="text-muted text-center py-5">Belum ada data personel.</p>
        @else
            @foreach($grouped as $groupName => $members)
                @if($members->count() > 0)
                    <div class="ds-group-section">
                        <h2 class="ds-group-title">{{ $groupName }}</h2>
                        <div class="ds-grid">
                    @foreach($members as $person)
                        <a href="/staff-detail/{{ $person->id }}" class="ds-card">
                            <div class="ds-img-container">
                                <img src="{{ $person->image ? asset('storage/'.$person->image) : 'https://ui-avatars.com/api/?name='.urlencode($person->name).'&background=DFF0E7&color=1A4D2E&size=400&bold=true' }}"
                                    alt="{{ $person->name }}">
                            </div>
                            <div class="ds-info">
                                <div class="ds-name">{{ $person->name }}</div>
                                
                                @if($person->academic_position)
                                    <div class="ds-pos">{{ $person->academic_position }}</div>
                                @endif

                                {{-- NIP/NIDN ditampilkan untuk semua (Dosen, Staff, TA). Jika kosong, otomatis muncul '-' --}}
                                <div class="ds-sub">NIP/NIDN: {{ $person->nip_nidn ?? '-' }}</div>
                            </div>
                        </a>
                    @endforeach
                        </div>
                    </div>
                @endif
            @endforeach

            @if(isset($others) && $others->count() > 0)
                <div class="ds-group-section">
                    <h2 class="ds-group-title">Lainnya</h2>
                    <div class="ds-grid">
                        @foreach($others as $person)
                        <a href="/staff-detail/{{ $person->id }}" class="ds-card">
                            <div class="ds-img-container">
                                <img src="{{ $person->image ? asset('storage/'.$person->image) : 'https://ui-avatars.com/api/?name='.urlencode($person->name).'&background=DFF0E7&color=1A4D2E&size=400&bold=true' }}"
                                     alt="{{ $person->name }}">
                            </div>
                            <div class="ds-info">
                                <div class="ds-name">{{ $person->name }}</div>
                                @if($person->academic_position)
                                    <div class="ds-pos">{{ $person->academic_position }}</div>
                                @endif
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
            @endif
        @endif
    </div>
</div>

@endsection
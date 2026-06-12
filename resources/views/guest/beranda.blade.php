@extends('layouts.guest_layout')

@section('content')

{{-- ══════════ 1. HERO SECTION ══════════ --}}
<section class="hero">
    {{-- Video Background --}}
    @if($hero && $hero->hasVideo())
        @php
            // Mengambil ID video YouTube agar fitur LOOP berfungsi
            $videoId = last(explode('/', parse_url($hero->embed_url, PHP_URL_PATH)));
            $finalUrl = $hero->embed_url . (strpos($hero->embed_url, '?') !== false ? '&' : '?') . 
                       "autoplay=1&mute=1&loop=1&playlist=" . $videoId . 
                       "&controls=0&rel=0&modestbranding=1&playsinline=1&vq=hd1080";
        @endphp

        <div class="video-background">
            <iframe src="{{ $finalUrl }}" frameborder="0" allow="autoplay; encrypted-media"></iframe>
        </div>
    @endif

    {{-- Overlay gradasi gelap di kiri agar teks tajam --}}
    <div class="hero-overlay"></div>

    <div class="container-fluid">
        <div class="hero-content reveal">
            <div class="hero-eyebrow">
                <span></span> Teknik Bioproses — Institut Teknologi Del
            </div>

            <h1 class="hero-title">
                {!! nl2br(e($hero->title ?? 'Engineering The Future')) !!}
            </h1>

            <p class="hero-sub">
                {{ $hero->subtitle ?? 'Inovasi Bioproses dari Tanah Toba, Menggerakkan Industri Masa Depan.' }}
            </p>

            <div class="hero-btn-group">
                @if($hero && $hero->primary_button_url && $hero->primary_button_text)
                    <a href="{{ $hero->primary_button_url }}" class="hero-cta">
                        {{ $hero->primary_button_text }}
                    </a>
                @endif
            </div>
        </div>
    </div>

    {{-- TOMBOL PANAH KE BAWAH --}}
    <div class="scroll-down-container">
        <a href="#content-start" class="scroll-arrow">
            <i class="fas fa-chevron-down"></i>
        </a>
    </div>
</section>

{{-- ══════════ 2. WHY US SECTION (FLOATING) ══════════ --}}
<section class="why-section" id="content-start">
    <div class="container">
        {{-- Card ini akan overlap (naik) menabrak bagian Hero --}}
        <div class="why-row overlap-card reveal">
            @if($why = $profiles->get('B_WHY_US'))
                <div class="why-img-wrap">
                    @if($why->image)
                        <img src="{{ asset('storage/' . $why->image) }}" alt="{{ $why->name }}">
                    @else
                        <div class="why-img-placeholder">📸 Foto Prodi</div>
                    @endif
                    {{-- Aksen Garis Dekoratif --}}
                    <div class="floating-deco"></div>
                </div>
                
                <div class="why-text">
                    <span class="bp-tag">Keunggulan Kami</span>
                    <h2 class="bp-heading">{{ $why->name }}</h2>
                    <span class="why-divider"></span>
                    <div class="content-ck">
                        {!! $why->description !!}
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>

<section class="py-5" style="background-color: var(--cream);">
    <div class="container py-5">
        @if($acc = $profiles->get('B_ACCREDITATION'))
        <div class="accred-card reveal">
            <div class="row g-0 align-items-stretch">
                <div class="col-lg-7 accred-text-side">
                    <span class="bp-tag">Akreditasi</span>
                    <h2 class="accred-rank">{{ $acc->name }}</h2>
                    {{-- PERUBAHAN: tambah class text-justify --}}
                    <div class="content-ck text-muted">
                        {!! $acc->description !!}
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="certificate-frame reveal">
                        @if($acc->image)
                            @if(Str::endsWith($acc->image, '.pdf'))
                                <div class="pdf-container shadow-lg border">
                                    <embed src="{{ asset('storage/' . $acc->image) }}" type="application/pdf" width="100%" height="400px" />
                                    <div class="mt-2"><a href="{{ asset('storage/' . $acc->image) }}" target="_blank" class="btn btn-sm btn-outline-light">Buka PDF</a></div>
                                </div>
                            @else
                                <img src="{{ asset('storage/' . $acc->image) }}" class="certificate-img" alt="Akreditasi" data-bs-toggle="modal" data-bs-target="#modalAccred">
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</section>

{{-- MODAL ACCREDITATION --}}
<div class="modal fade" id="modalAccred" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content bg-transparent border-0 text-center">
            @if($acc = $profiles->get('B_ACCREDITATION'))
                <img src="{{ asset('storage/' . $acc->image) }}" class="img-fluid rounded shadow-lg" style="max-height: 90vh; border: 5px solid white;">
                <div class="mt-3"><button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Tutup</button></div>
            @endif
        </div>
    </div>
</div>

{{-- ══════════ 4. BERITA ══════════ --}}
<section class="news-section">
    <div class="container">
        <div class="news-top reveal">
            <div>
                <span class="bp-tag">Update Terkini</span>
                <h2 class="bp-heading" style="font-size:clamp(1.8rem,3vw,2.6rem);margin-top:.85rem">Berita & Kegiatan</h2>
            </div>
            <a href="/berita" class="btn-forest-outline">Lihat Semua →</a>
        </div>
        <div class="row g-4">
            @foreach($latestNews as $item)
            <div class="col-md-4 reveal">
                <div class="news-card">
                    <div class="news-img-wrap">
                        <img src="{{ asset('storage/' . $item->image) }}" class="news-img" alt="{{ $item->title }}">
                    </div>
                    <div class="news-body">
                        @if(isset($item->category)) <span class="news-cat">{{ $item->category->name }}</span> @endif
                        <div class="news-title-text">{{ $item->title }}</div>
                        <p class="news-excerpt">{{ Str::limit(strip_tags($item->content), 100) }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ══════════ 5. TESTIMONI ══════════ --}}
<section class="testi-section">
    <div class="container">
        <div class="testi-header reveal">
            <span class="bp-tag" style="justify-content:center">Testimoni</span>
            <h2 class="bp-heading" style="font-size:clamp(1.8rem,3vw,2.6rem);margin-top:.85rem">Suara Alumni & Mahasiswa</h2>
        </div>
        <div class="row g-4">
            @foreach($testimonials as $testi)
            <div class="col-md-4 reveal">
                <div class="testi-card">
                    <img src="{{ asset('storage/' . $testi->photo) }}" class="testi-photo-large" alt="{{ $testi->name }}">
                    <div class="testi-name-text">{{ $testi->name }}</div>
                    <div class="testi-pos">{{ $testi->position }}</div>
                    {{-- PERUBAHAN: tambah style text-align justify --}}
                    <p class="testi-text" style="text-align: justify;">"{{ $testi->content }}"</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ══════════ 6. MITRA STRATEGIS ══════════ --}}
<section class="mitra-section py-5" style="background-color: var(--cream);">
    <div class="container text-center">
        <div class="mb-5 reveal">
            <span class="mitra-label">Jejaring Industri & Akademik</span>
            <h2 class="bp-heading" style="font-size: 2.5rem;">Mitra Strategis Kami</h2>
        </div>

        <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-6 g-4 justify-content-center align-items-center">
            @foreach($mitras as $mitra)
                <div class="col">
                    {{-- GANTI MODAL MENJADI LINK PAGE --}}
                    <a href="{{ route('public.mitra.show', $mitra->id) }}" class="text-decoration-none">
                        <div class="partner-logo-wrap reveal">
                            <img src="{{ asset('storage/' . $mitra->logo) }}" 
                                 alt="{{ $mitra->name }}" 
                                 class="partner-img">
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>

<script>
const observer = new IntersectionObserver((entries) => {
    entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('visible'); observer.unobserve(e.target); } });
}, { threshold: 0.1 });
document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
</script>
@endsection
@extends('layouts.guest_layout')

@section('title', 'Beranda - Teknik Bioproses IT Del')

@section('content')

{{-- ════════════════════════════════════════ --}}
{{-- 1. HERO SECTION                         --}}
{{-- ════════════════════════════════════════ --}}
<section class="hero" id="home">

    @if($hero && $hero->hasVideo())
        @php
            $videoId  = last(explode('/', parse_url($hero->embed_url, PHP_URL_PATH)));
            $finalUrl = $hero->embed_url
                . (strpos($hero->embed_url, '?') !== false ? '&' : '?')
                . "autoplay=1&mute=1&loop=1&playlist={$videoId}&controls=0&rel=0&modestbranding=1&playsinline=1&vq=hd1080";
        @endphp
        <div class="hero-video-bg">
            <iframe src="{{ $finalUrl }}" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
        </div>
    @else
        <div class="hero-video-bg">
            <video autoplay muted loop playsinline>
                <source src="{{ asset('videos/Video Profil Institut Teknologi Del.mp4') }}" type="video/mp4">
            </video>
        </div>
    @endif

    <div class="hero-overlay"></div>

    {{-- Dekoratif grid halus --}}
    <div class="hero-grid-bg" aria-hidden="true"></div>

    <div class="container d-flex justify-content-center">
        <div class="hero-content reveal">

            <div class="hero-eyebrow">
                <i class="bi bi-geo-alt-fill" style="font-size:10px; opacity:.7;"></i>
                {{ $hero->eyebrow ?? 'Teknik Bioproses — Institut Teknologi Del' }}
            </div>

            <h1 class="hero-title">
                {!! nl2br(e($hero->title ?? "Engineering\nThe Future")) !!}
            </h1>

            <p class="hero-sub">
                {{ $hero->subtitle ?? 'Inovasi bioproses dari Tanah Toba, menggerakkan industri masa depan yang berkelanjutan.' }}
            </p>

            <div class="hero-btn-group">
                @if($hero && $hero->primary_button_url)
                    <a href="{{ $hero->primary_button_url }}" class="hero-cta-primary">
                        {{ $hero->primary_button_text ?? 'Daftar Sekarang' }}
                        <i class="bi bi-arrow-right"></i>
                    </a>
                @endif
                <a href="#content-start" class="hero-cta-ghost">
                    Pelajari lebih lanjut
                    <i class="bi bi-chevron-down" style="font-size:11px;"></i>
                </a>
            </div>

        </div>
    </div>

    <a href="#content-start" class="hero-scroll-indicator" aria-label="Gulir ke bawah">
        <div class="hero-scroll-line"></div>
        <span class="hero-scroll-label">Scroll</span>
    </a>

</section>


{{-- ════════════════════════════════════════ --}}
{{-- 2. STATS / KPI SECTION                  --}}
{{-- ════════════════════════════════════════ --}}
<section class="stats-section" id="content-start">
    <div class="container">
        <div class="stats-panel">

            @if($acc = $profiles->get('B_ACCREDITATION'))
            <div class="stat-item stat-item--clickable reveal" id="accredBtnMobile" title="Klik untuk info akreditasi" role="button" tabindex="0">
                <div class="stat-icon-wrap" style="background:var(--accent-xlight);">
                    <i class="bi bi-patch-check-fill" style="color:var(--accent); font-size:18px;"></i>
                </div>
                <div class="stat-num">{{ $acc->name }}</div>
                <div class="stat-label">Akreditasi Prodi</div>
                <div class="stat-hover-line"></div>
            </div>
            @endif

            <div class="stat-item reveal">
                <div class="stat-icon-wrap" style="background:#e8f0f5;">
                    <i class="bi bi-people-fill" style="color:#185fa5; font-size:18px;"></i>
                </div>
                <div class="stat-num">450+</div>
                <div class="stat-label">Mahasiswa Aktif</div>
                <div class="stat-hover-line"></div>
            </div>

            <a href="{{ route('public.labs') }}" class="stat-item stat-item--link reveal" aria-label="Lihat laboratorium riset">
                <div class="stat-icon-wrap" style="background:var(--accent-xlight);">
                    <i class="bi bi-flask-fill" style="color:var(--forest-mid); font-size:18px;"></i>
                </div>
                <div class="stat-num">{{ $stats['labs'] }}</div>
                <div class="stat-label">Laboratorium Riset</div>
                <div class="stat-hover-line"></div>
            </a>

            <a href="{{ route('public.mitra.index') }}" class="stat-item stat-item--link reveal" aria-label="Lihat mitra industri">
                <div class="stat-icon-wrap" style="background:#fdf3e0;">
                    <i class="bi bi-building-fill-check" style="color:#854f0b; font-size:18px;"></i>
                </div>
                <div class="stat-num">{{ $stats['mitras'] }}+</div>
                <div class="stat-label">Mitra Industri</div>
                <div class="stat-hover-line"></div>
            </a>

        </div>
    </div>
</section>


{{-- ════════════════════════════════════════ --}}
{{-- 3. AKREDITASI                           --}}
{{-- ════════════════════════════════════════ --}}
<section class="py-5" style="background: var(--cream);">
    <div class="container py-4">
        @if($acc = $profiles->get('B_ACCREDITATION'))
        <div class="accred-card reveal">
            <div class="row g-0 align-items-stretch">

                <div class="col-lg-7 accred-text-side">
                    <span class="bp-badge mb-3">BAN-PT Terakreditasi</span>
                    <div class="bp-eyebrow">Akreditasi</div>
                    <h2 class="accred-rank">{{ $acc->name }}</h2>
                    <div class="accred-divider"></div>
                    <div class="content-ck text-muted" style="font-size:.92rem; line-height:1.85;">
                        {!! $acc->description !!}
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="certificate-frame">
                        @if($acc->image)
                            @if(Str::endsWith($acc->image, '.pdf'))
                                <div class="pdf-container">
                                    <embed src="{{ asset('storage/' . $acc->image) }}" type="application/pdf" width="100%" height="400px" />
                                    <div class="mt-2">
                                        <a href="{{ asset('storage/' . $acc->image) }}" target="_blank" class="btn btn-sm btn-outline-secondary">
                                            <i class="bi bi-box-arrow-up-right me-1"></i> Buka PDF
                                        </a>
                                    </div>
                                </div>
                            @else
                                <img src="{{ asset('storage/' . $acc->image) }}"
                                     class="certificate-img"
                                     alt="Sertifikat akreditasi"
                                     data-bs-toggle="modal"
                                     data-bs-target="#accredModal">
                                <span class="cert-hint">
                                    <i class="bi bi-zoom-in me-1"></i>Klik untuk perbesar
                                </span>
                            @endif
                        @endif
                    </div>
                </div>

            </div>
        </div>
        @endif
    </div>
</section>


{{-- MODAL FOTO AKREDITASI --}}
<div class="modal fade" id="accredModal" tabindex="-1" aria-hidden="true" aria-label="Sertifikat akreditasi">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content bg-transparent border-0">
            <div class="modal-body p-0 position-relative">
                <button type="button"
                        class="modal-close-btn"
                        data-bs-dismiss="modal"
                        aria-label="Tutup">
                    <i class="bi bi-x-lg"></i>
                </button>
                <img src="" id="accredModalImg" class="accred-modal-img" alt="Sertifikat akreditasi">
            </div>
        </div>
    </div>
</div>


{{-- ════════════════════════════════════════ --}}
{{-- 4. WHY US + SEJARAH                     --}}
{{-- ════════════════════════════════════════ --}}
<section class="why-section">
    <div class="container">
        @php
            $why     = $profiles->get('B_WHY_US');
            $history = $profiles->get('B_HISTORY');
        @endphp

        {{-- Why Us --}}
        @if($why)
        <div class="why-row">
            <div class="why-img-wrap reveal">
                <img src="{{ $why->image ? asset('storage/' . $why->image) : asset('guest_assets/img/placeholder.jpg') }}"
                     alt="{{ $why->name }}">
                <div class="why-img-badge">
                    <i class="bi bi-star-fill me-1" style="color:var(--gold); font-size:11px;"></i>
                    Keunggulan Kami
                </div>
            </div>
            <div class="why-text reveal">
                <div class="bp-eyebrow">Mengapa Bioproses?</div>
                <h2 class="bp-heading-serif">{{ $why->name }}</h2>
                <span class="why-divider-line"></span>
                <p class="why-body">
                    {!! Str::limit(strip_tags($why->description), 480) !!}
                </p>
                <a href="{{ route('guest.profil_bioproses') }}" class="btn-forest-outline">
                    Selengkapnya <i class="bi bi-arrow-right" style="font-size:11px;"></i>
                </a>
            </div>
        </div>
        @endif

        {{-- Sejarah --}}
        @if($history)
        <div class="why-row why-row--reverse mt-5 pt-5 border-top">
            <div class="why-text reveal">
                <div class="bp-eyebrow">Perjalanan Panjang</div>
                <h2 class="bp-heading-serif">{{ $history->name }}</h2>
                <span class="why-divider-line"></span>
                <p class="why-body">
                    {!! Str::limit(strip_tags($history->description), 480) !!}
                </p>
                <a href="{{ route('guest.profil_bioproses') }}" class="btn-forest-outline">
                    Jelajahi sejarah <i class="bi bi-arrow-right" style="font-size:11px;"></i>
                </a>
            </div>
            <div class="why-img-wrap reveal">
                <img src="{{ $history->image ? asset('storage/' . $history->image) : asset('guest_assets/img/placeholder.jpg') }}"
                     alt="{{ $history->name }}">
                <div class="why-img-badge">
                    <i class="bi bi-clock-history me-1" style="font-size:11px;"></i>
                    Sejak 2001
                </div>
            </div>
        </div>
        @endif
    </div>
</section>


{{-- ════════════════════════════════════════ --}}
{{-- 5. PENGUMUMAN                           --}}
{{-- ════════════════════════════════════════ --}}
<section class="ann-section">
    <div class="container">
        <div class="section-header reveal">
            <div>
                <div class="bp-eyebrow">Informasi terkini</div>
                <h2 class="bp-heading-serif">Pengumuman</h2>
            </div>
            <a href="{{ route('public.archives') }}" class="btn-forest-outline">Lihat semua →</a>
        </div>

        <div class="ann-grid">
            @forelse($announcements as $ann)
            <div class="ann-card reveal">
                <div class="ann-icon-wrap">
                    <i class="bi bi-megaphone-fill"></i>
                </div>
                <div class="ann-body">
                    <h5 class="ann-title">{{ $ann->title }}</h5>
                    <p class="ann-excerpt">{{ Str::limit(strip_tags($ann->content), 150) }}</p>
                    <span class="ann-date">
                        <i class="bi bi-calendar3 me-1" style="font-size:10px;"></i>
                        {{ \Carbon\Carbon::parse($ann->created_at)->translatedFormat('d F Y') }}
                    </span>
                </div>
            </div>
            @empty
            <div class="col-12 ann-empty">
                <i class="bi bi-megaphone fs-1 d-block mb-2"></i>
                <p>Belum ada pengumuman.</p>
            </div>
            @endforelse
        </div>
    </div>
</section>


{{-- ════════════════════════════════════════ --}}
{{-- 6. BERITA & KEGIATAN                    --}}
{{-- ════════════════════════════════════════ --}}
<section class="news-section">
    <div class="container">
        <div class="section-header reveal">
            <div>
                <div class="bp-eyebrow">Update terkini</div>
                <h2 class="bp-heading-serif">Berita & Kegiatan</h2>
            </div>
            <a href="{{ route('public.news') }}" class="btn-forest-outline">Lihat semua →</a>
        </div>

        <div class="news-grid">
            @foreach($latestNews as $item)
            <a href="{{ route('public.information.show', $item->id) }}" class="news-card reveal">
                <div class="news-card-img-wrap">
                    <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}" loading="lazy">
                    <div class="news-card-overlay" aria-hidden="true"></div>
                </div>
                <div class="news-card-body">
                    <div class="news-card-title">{{ $item->title }}</div>
                    <div class="news-card-date">
                        <i class="bi bi-calendar3 me-1" style="font-size:10px;"></i>
                        {{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d F Y') }}
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>


{{-- ════════════════════════════════════════ --}}
{{-- 7. TESTIMONI                            --}}
{{-- ════════════════════════════════════════ --}}
<section class="testi-section">
    <div class="container">
        <div class="section-header reveal">
            <div>
                <div class="bp-eyebrow">Testimoni</div>
                <h2 class="bp-heading-serif">Suara Alumni & Mahasiswa</h2>
            </div>
        </div>

        <div class="testi-grid">
            @foreach($testimonials as $testi)
            <a href="{{ route('public.testimoni.show', $testi->id) }}" class="testi-card reveal">
                <div class="testi-quote-mark" aria-hidden="true">"</div>
                @if($testi->photo)
                    <img src="{{ asset('storage/' . $testi->photo) }}" class="testi-photo" alt="{{ $testi->name }}">
                @else
                    <div class="testi-avatar" aria-label="{{ $testi->name }}">
                        {{ strtoupper(substr($testi->name, 0, 2)) }}
                    </div>
                @endif
                <p class="testi-text">{{ Str::limit(strip_tags($testi->content), 120) }}</p>
                <div class="testi-meta">
                    <div class="testi-name">{{ $testi->name }}</div>
                    <div class="testi-pos">{{ $testi->position ?? 'Alumni' }}</div>
                </div>
            </a>
            @endforeach
        </div>

        <div class="section-footer-right reveal">
            <a href="{{ route('public.testimoni.index') }}" class="btn-forest-outline">Selengkapnya →</a>
        </div>
    </div>
</section>


{{-- ════════════════════════════════════════ --}}
{{-- 8. MITRA STRATEGIS                      --}}
{{-- ════════════════════════════════════════ --}}
<section class="mitra-section">
    <div class="container">
        <div class="section-header reveal">
            <div>
                <div class="bp-eyebrow">Jejaring industri & akademik</div>
                <h2 class="bp-heading-serif">Mitra Strategis Kami</h2>
            </div>
            <a href="{{ route('public.mitra.index') }}" class="btn-forest-outline">Selengkapnya →</a>
        </div>

        @php
            $chunks     = $mitras->chunk(6);
            $totalSlides = $chunks->count();
        @endphp

        @if($mitras->count() > 0)
            <div id="mitraCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3500">
                <div class="carousel-inner">
                    @foreach($chunks as $index => $chunk)
                        <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                            <div class="mitra-grid">
                                @foreach($chunk as $mitra)
                                    <a href="{{ route('public.mitra.show', $mitra->id) }}"
                                       class="mitra-logo-wrap"
                                       title="{{ $mitra->name }}"
                                       aria-label="{{ $mitra->name }}">
                                        <img src="{{ asset('storage/' . $mitra->logo) }}" alt="{{ $mitra->name }}" loading="lazy">
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>

                @if($totalSlides > 1)
                    <div class="carousel-indicators mitra-indicators">
                        @foreach($chunks as $index => $chunk)
                            <button type="button"
                                    data-bs-target="#mitraCarousel"
                                    data-bs-slide-to="{{ $index }}"
                                    class="{{ $loop->first ? 'active' : '' }}"
                                    aria-label="Slide {{ $loop->iteration }}"></button>
                        @endforeach
                    </div>
                @endif
            </div>
        @else
            <p class="text-muted text-center py-4">Belum ada mitra yang terdaftar.</p>
        @endif
    </div>
</section>


{{-- ════════════════════════════════════════ --}}
{{-- SCRIPTS                                 --}}
{{-- ════════════════════════════════════════ --}}
<script>
(function () {
    'use strict';

    /* ── Reveal on Scroll ── */
    const observer = new IntersectionObserver(function (entries) {
        entries.forEach(function (e) {
            if (e.isIntersecting) {
                e.target.classList.add('visible');
                observer.unobserve(e.target);
            }
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('.reveal').forEach(function (el) {
        observer.observe(el);
    });

    /* ── Staggered reveal untuk grid children ── */
    document.querySelectorAll('.news-grid, .testi-grid, .ann-grid').forEach(function (grid) {
        grid.querySelectorAll('.reveal').forEach(function (el, i) {
            el.style.transitionDelay = (i * 80) + 'ms';
        });
    });

    /* ── Modal foto akreditasi ── */
    var modalImg = document.getElementById('accredModalImg');
    document.querySelectorAll('.certificate-img').forEach(function (img) {
        img.addEventListener('click', function () {
            if (modalImg) modalImg.src = this.src;
        });
    });

    /* ── Inisialisasi Carousel ── */
    document.addEventListener('DOMContentLoaded', function () {
        var el = document.getElementById('mitraCarousel');
        if (el && typeof bootstrap !== 'undefined' && bootstrap.Carousel) {
            new bootstrap.Carousel(el, {
                interval: 3500,
                ride: true,
                pause: false
            });
        }
    });

    /* ── Keyboard: accred stat item ── */
    var accredBtn = document.getElementById('accredBtnMobile');
    if (accredBtn) {
        accredBtn.addEventListener('keydown', function (e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                accredBtn.click();
            }
        });
    }

})();
</script>

@endsection
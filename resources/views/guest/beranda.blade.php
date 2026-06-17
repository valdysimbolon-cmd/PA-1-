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

    <div class="container d-flex justify-content-center">
        <div class="hero-content reveal">
            <div class="hero-eyebrow">
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
                        <i class="fas fa-arrow-right" style="font-size:12px;"></i>
                    </a>
                @endif
                <a href="#content-start" class="hero-cta-ghost">Pelajari lebih lanjut</a>
            </div>
        </div>
    </div>

    <a href="#content-start" class="hero-scroll-indicator">
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
            <div class="stat-item clickable reveal" id="accredBtnMobile" title="Klik untuk info akreditasi">
                <div class="stat-icon-wrap" style="background:var(--accent-xlight);">
                    <i class="bi bi-patch-check-fill fs-5" style="color:var(--accent);"></i>
                </div>
                <div class="stat-num">{{ $acc->name }}</div>
                <div class="stat-label">Akreditasi Prodi</div>
            </div>
            @endif

            <div class="stat-item reveal">
                <div class="stat-icon-wrap" style="background:#e8f0f5;">
                    <i class="bi bi-people-fill fs-5" style="color:#185fa5;"></i>
                </div>
                <div class="stat-num">450+</div>
                <div class="stat-label">Mahasiswa Aktif</div>
            </div>

            <a href="{{ route('public.labs') }}" class="text-decoration-none text-dark">
                <div class="stat-item reveal">
                    <div class="stat-icon-wrap" style="background:var(--accent-xlight);">
                        <i class="bi bi-flask-fill fs-5" style="color:var(--forest-mid);"></i>
                    </div>
                    <div class="stat-num">{{ $labCount }}</div>
                    <div class="stat-label">Laboratorium Riset</div>
                </div>
            </a>

            <a href="{{ route('public.mitra.index') }}" class="text-decoration-none text-dark">
                <div class="stat-item reveal">
                    <div class="stat-icon-wrap" style="background:#fdf3e0;">
                        <i class="bi bi-building-fill-check fs-5" style="color:#854f0b;"></i>
                    </div>
                    <div class="stat-num">{{ $partnerCount }}+</div>
                    <div class="stat-label">Mitra Industri</div>
                </div>
            </a>

        </div>
    </div>
</section>


{{-- ════════════════════════════════════════ --}}
{{-- 3. AKREDITASI (card + modal foto)       --}}
{{-- ════════════════════════════════════════ --}}
<section class="py-5" style="background-color: var(--cream);">
    <div class="container py-5">
        @if($acc = $profiles->get('B_ACCREDITATION'))
        <div class="accred-card reveal">
            <div class="row g-0 align-items-stretch">
                <div class="col-lg-7 accred-text-side">
                    <span class="bp-eyebrow">Akreditasi</span>
                    <h2 class="accred-rank">{{ $acc->name }}</h2>
                    <div class="content-ck text-muted" style="font-size:0.95rem; line-height:1.8;">
                        {!! $acc->description !!}
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="certificate-frame">
                        @if($acc->image)
                            @if(Str::endsWith($acc->image, '.pdf'))
                                <div class="pdf-container shadow-lg border">
                                    <embed src="{{ asset('storage/' . $acc->image) }}" type="application/pdf" width="100%" height="400px" />
                                    <div class="mt-2">
                                        <a href="{{ asset('storage/' . $acc->image) }}" target="_blank" class="btn btn-sm btn-outline-light">Buka PDF</a>
                                    </div>
                                </div>
                            @else
                                <img src="{{ asset('storage/' . $acc->image) }}"
                                     class="certificate-img"
                                     alt="Sertifikat akreditasi"
                                     data-bs-toggle="modal"
                                     data-bs-target="#accredModal">
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
<div class="modal fade" id="accredModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content bg-transparent border-0">
            <div class="modal-body p-0 position-relative">
                <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Tutup" style="z-index: 10; background: rgba(0,0,0,0.6); border-radius: 50%; width: 40px; height: 40px; backdrop-filter: blur(4px);"></button>
                <img src="" id="accredModalImg" class="accred-modal-img" alt="Sertifikat akreditasi">
            </div>
        </div>
    </div>
</div>




{{-- ════════════════════════════════════════ --}}
{{-- 5. WHY US + SEJARAH                     --}}
{{-- ════════════════════════════════════════ --}}
<section class="why-section">
    <div class="container">
        @php
            $why = $profiles->get('B_WHY_US');
            $history = $profiles->get('B_HISTORY');
        @endphp

        @if($why)
        <div class="why-row">
            <div class="why-img-wrap reveal">
                <img src="{{ $why->image ? asset('storage/' . $why->image) : asset('guest_assets/img/placeholder.jpg') }}"
                     alt="{{ $why->name }}">
            </div>
            <div class="why-text reveal">
                <div class="bp-eyebrow">Keunggulan kami</div>
                <h2 class="bp-heading-serif">{{ $why->name }}</h2>
                <span class="why-divider-line"></span>
                <p class="why-body">
                    {!! Str::limit(strip_tags($why->description), 480) !!}
                </p>
                <a href="{{ route('guest.profil_bioproses') }}" class="btn-forest-outline">
                    Selengkapnya <i class="fas fa-arrow-right" style="font-size:11px;"></i>
                </a>
            </div>
        </div>
        @endif

        @if($history)
        <div class="why-row mt-5 pt-4 border-top" style="grid-template-columns: 1fr 1fr; gap: 4rem;">
            <div class="why-text reveal">
                <div class="bp-eyebrow">Perjalanan panjang</div>
                <h2 class="bp-heading-serif">{{ $history->name }}</h2>
                <span class="why-divider-line"></span>
                <p class="why-body">
                    {!! Str::limit(strip_tags($history->description), 480) !!}
                </p>
                <a href="{{ route('guest.profil_bioproses') }}" class="btn-forest-outline">
                    Jelajahi sejarah <i class="fas fa-arrow-right" style="font-size:11px;"></i>
                </a>
            </div>
            <div class="why-img-wrap reveal">
                <img src="{{ $history->image ? asset('storage/' . $history->image) : asset('guest_assets/img/placeholder.jpg') }}"
                     alt="{{ $history->name }}">
            </div>
        </div>
        @endif
    </div>
</section>

{{-- ════════════════════════════════════════ --}}
{{-- 4. PENGUMUMAN                           --}}
{{-- ════════════════════════════════════════ --}}
<section class="py-5" style="background-color: #fff;">
    <div class="container">
        {{-- Header: judul kiri, tombol kanan (sama seperti Berita & Kegiatan) --}}
        <div class="news-section-header reveal">
            <div>
                <div class="bp-eyebrow">Informasi terkini</div>
                <h2 class="bp-heading-serif">Pengumuman</h2>
            </div>
            <a href="{{ route('public.archives') }}" class="btn-forest-outline">Lihat semua →</a>
        </div>

        {{-- Konten pengumuman (grid 2 kolom) --}}
        <div class="row g-4 mt-2">
            @forelse($announcements as $ann)
            <div class="col-md-6 reveal">
                <div class="card border-0 shadow-sm h-100 rounded-4 p-4 bg-light">
                    <div class="d-flex align-items-start gap-3">
                        <i class="bi bi-megaphone-fill fs-2" style="color: var(--accent);"></i>
                        <div>
                            <h5 class="fw-bold text-forest">{{ $ann->title }}</h5>
                            <p class="text-muted small">{{ Str::limit(strip_tags($ann->content), 150) }}</p>
                            <span class="badge bg-accent-light text-forest">{{ \Carbon\Carbon::parse($ann->created_at)->translatedFormat('d F Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-4 text-muted">
                <i class="bi bi-megaphone fs-1 d-block mb-2" style="color: var(--border);"></i>
                Belum ada pengumuman.
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
        <div class="news-section-header reveal">
            <div>
                <div class="bp-eyebrow">Update terkini</div>
                <h2 class="bp-heading-serif">Berita & Kegiatan</h2>
            </div>
            <a href="{{ route('public.news') }}" class="btn-forest-outline">Lihat semua →</a>
        </div>

        <div class="news-grid">
            @foreach($latestNews as $item)
            <a href="{{ route('public.news.show', $item->id) }}" class="news-card reveal">
                <div class="news-card-img-wrap">
                    <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}">
                </div>
                <div class="news-card-body">
                    <div class="news-card-title">{{ $item->title }}</div>
                    <div class="news-card-date">
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
        <div class="testi-section-header reveal">
            <div>
                <div class="bp-eyebrow">Testimoni</div>
                <h2 class="bp-heading-serif">Suara Alumni & Mahasiswa</h2>
            </div>
        </div>

        <div class="testi-grid">
            @foreach($testimonials as $testi)
            <a href="{{ route('public.testimoni.show', $testi->id) }}" class="testi-card reveal">
                @if($testi->photo)
                    <img src="{{ asset('storage/' . $testi->photo) }}" class="testi-photo" alt="{{ $testi->name }}">
                @else
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($testi->name) }}&background=E6F5EC&color=1A4D2E&size=80&rounded=true" class="testi-photo">
                @endif
                <div class="testi-name">{{ $testi->name }}</div>
                <div class="testi-pos">{{ $testi->position ?? 'Alumni' }}</div>
                <p class="testi-text">"{{ Str::limit(strip_tags($testi->content), 120) }}"</p>
            </a>
            @endforeach
        </div>

        <div class="section-footer-right reveal">
            <a href="{{ route('public.testimoni.index') }}" class="btn-forest-outline">Selengkapnya →</a>
        </div>
    </div>
</section>


{{-- ════════════════════════════════════════ --}}
{{-- 8. MITRA STRATEGIS (carousel)           --}}
{{-- ════════════════════════════════════════ --}}
<section class="mitra-section">
    <div class="container">
        <div class="mitra-section-header reveal">
            <div>
                <div class="bp-eyebrow">Jejaring industri & akademik</div>
                <h2 class="bp-heading-serif">Mitra Strategis Kami</h2>
            </div>
            <a href="{{ route('public.mitra.index') }}" class="btn-forest-outline">Selengkapnya →</a>
        </div>

        @php
            $chunks = $mitras->chunk(6);
            $totalSlides = $chunks->count();
        @endphp

        @if($mitras->count() > 0)
            <div id="mitraCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000">
                <div class="carousel-inner">
                    @foreach($chunks as $index => $chunk)
                        <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                            <div class="mitra-grid">
                                @foreach($chunk as $mitra)
                                    <a href="{{ route('public.mitra.show', $mitra->id) }}" class="text-decoration-none">
                                        <div class="mitra-logo-wrap">
                                            <img src="{{ asset('storage/' . $mitra->logo) }}" alt="{{ $mitra->name }}">
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>

                @if($totalSlides > 1)
                    <div class="carousel-indicators">
                        @foreach($chunks as $index => $chunk)
                            <button type="button" data-bs-target="#mitraCarousel" data-bs-slide-to="{{ $index }}" class="{{ $loop->first ? 'active' : '' }}" aria-label="Slide {{ $loop->iteration }}"></button>
                        @endforeach
                    </div>
                @endif
            </div>
        @else
            <p class="text-muted text-center">Belum ada mitra yang terdaftar.</p>
        @endif
    </div>
</section>


{{-- ════════════════════════════════════════ --}}
{{-- SCRIPTS                                 --}}
{{-- ════════════════════════════════════════ --}}
<script>
(function () {
    'use strict';

    // ── Reveal on Scroll ──
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

    // ── Modal foto akreditasi: isi src saat gambar diklik ──
    var modalImg = document.getElementById('accredModalImg');
    document.querySelectorAll('.certificate-img').forEach(function (img) {
        img.addEventListener('click', function () {
            modalImg.src = this.src;
        });
    });

    // ── Inisialisasi Carousel (otomatis berganti) ──
    document.addEventListener('DOMContentLoaded', function () {
        var el = document.getElementById('mitraCarousel');
        if (el) {
            if (typeof bootstrap !== 'undefined' && bootstrap.Carousel) {
                new bootstrap.Carousel(el, {
                    interval: 3000,
                    ride: true,
                    pause: false
                });
            } else {
                console.warn('Bootstrap Carousel tidak ditemukan.');
            }
        }
    });
})();
</script>

@endsection
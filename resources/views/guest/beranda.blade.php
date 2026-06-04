@extends('layouts.guest_layout')

@section('content')

@php
    // 1. LOGIKA PENERJEMAH ID YOUTUBE
    $videoId = "";
    if(isset($hero) && !empty($hero->video_url)){
        $url = $hero->video_url;
        if (str_contains($url, 'youtu.be/')) {
            $videoId = explode('youtu.be/', $url)[1];
            $videoId = explode('?', $videoId)[0]; 
        } elseif (str_contains($url, 'v=')) {
            $videoId = explode('v=', $url)[1];
            $videoId = explode('&', $videoId)[0]; 
        }
    }
@endphp

{{-- ══════════ 1. HERO ══════════ --}}
<section class="hero">
    @if($videoId)
        <div class="video-background">
            <iframe
                src="https://www.youtube.com/embed/{{ $videoId }}?autoplay=1&mute=1&loop=1&playlist={{ $videoId }}&controls=0&showinfo=0&rel=0&modestbranding=1&vq=hd1080&enablejsapi=1"
                frameborder="0" allow="autoplay; encrypted-media">
            </iframe>
        </div>
    @endif

    <div class="hero-overlay"></div>
    <div class="hero-deco"></div>

    <div class="container-fluid">
        <div class="hero-content reveal">
            <div class="hero-eyebrow"><i></i> Teknik Bioproses — Institut Teknologi Del</div>
            <h1 class="hero-title">{{ $hero->title ?? 'Engineering The Future' }}</h1>
            <p class="hero-sub">{{ $hero->subtitle ?? 'Of life science' }}</p>
            <a href="{{ $hero->button_1_url ?? '#' }}" class="hero-cta">{{ $hero->button_1_text ?? 'Daftar Sekarang' }}</a>
        </div>
    </div>
</section>

{{-- ══════════ 2. WHY US ══════════ --}}
<section class="why-section">
    <div class="container">
        <div class="why-row">
            @if($why = $profiles->get('B_WHY_US'))
                <div class="why-img-wrap reveal">
                    @if($why->image)
                        <img src="{{ asset('storage/' . $why->image) }}" alt="{{ $why->name }}">
                    @else
                        <div class="why-img-placeholder">📸 Foto Prodi</div>
                    @endif
                </div>
                <div class="why-text reveal" style="transition-delay:.2s">
                    <span class="bp-tag">Keunggulan Kami</span>
                    <h2 class="bp-heading" style="margin-top:.85rem">{{ $why->name }}</h2>
                    <span class="why-divider"></span>
                    <div class="why-body" style="text-align: justify;">{!! $why->description !!}</div>
                </div>
            @endif
        </div>
    </div>
</section>

{{-- ══════════ 3. AKREDITASI ══════════ --}}
<section class="py-5" style="background-color: var(--cream);">
    <div class="container py-5">
        @if($acc = $profiles->get('B_ACCREDITATION'))
        <div class="accred-card reveal">
            <div class="row g-0 align-items-stretch">
                <div class="col-lg-7 accred-text-side">
                    <span class="bp-tag">Sertifikasi Mutu</span>
                    <h2 class="accred-rank">{{ $acc->name }}</h2>
                    {{-- PERUBAHAN: tambah class text-justify --}}
                    <div class="mt-4 text-muted text-justify">{!! $acc->description !!}</div>
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

{{-- ══════════ SECTION PENGUMUMAN (BARU) ══════════ --}}
<section class="py-5" style="background-color: #fff;">
    <div class="container">
        <div class="row g-5 align-items-start">
            <!-- Sisi Kiri: Judul -->
            <div class="col-lg-4 reveal">
                <span class="bp-tag">Informasi Penting</span>
                <h2 class="bp-heading" style="font-size: 2.2rem; margin-top: 0.5rem;">Pusat <em>Pengumuman</em></h2>
                <p class="text-muted mt-3">Dapatkan informasi resmi terbaru mengenai jadwal, kebijakan, dan agenda akademik Teknik Bioproses.</p>
                <a href="{{ route('public.announcements') }}" class="btn-forest-outline mt-3">Lihat Semua Pengumuman →</a>
            </div>

            <!-- Sisi Kanan: Daftar 5 Pengumuman -->
            <div class="col-lg-8">
                <div class="ann-board reveal" style="transition-delay: 0.2s;">
                    @forelse($latestAnnouncements as $ann)
                        <a href="{{ route('public.announcements') }}" class="ann-item text-decoration-none d-block">
                            <div class="d-flex align-items-center gap-4 p-3 rounded-4 mb-2 ann-hover">
                                <!-- Tanggal -->
                                <div class="ann-date text-center p-2 rounded-3 bg-light" style="min-width: 70px;">
                                    <span class="d-block fw-bold text-success fs-5">{{ $ann->created_at->format('d') }}</span>
                                    <span class="text-uppercase small text-muted" style="font-size: 0.65rem;">{{ $ann->created_at->format('M Y') }}</span>
                                </div>
                                <!-- Judul & Snippet -->
                                <div class="flex-grow-1">
                                    <h6 class="fw-bold text-dark mb-1">{{ $ann->title }}</h6>
                                    <p class="text-muted small mb-0">{{ Str::limit(strip_tags($ann->content), 80) }}</p>
                                </div>
                                <!-- Icon Panah -->
                                <div class="text-success"><i class="bi bi-chevron-right"></i></div>
                            </div>
                        </a>
                    @empty
                        <p class="text-muted italic">Belum ada pengumuman terbaru.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</section>

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
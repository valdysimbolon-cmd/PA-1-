@extends('layouts.guest_layout')

@section('content')

@php
    // LOGIKA FEYNMAN: Mengambil ID Video dari URL YouTube agar bisa diputar di Iframe
    $videoId = "";
    if(isset($hero->video_url)){
        // Regex untuk menangkap ID dari berbagai format link YouTube
        if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $hero->video_url, $match)) {
            $videoId = $match[1];
        }
    }
@endphp

<style>
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700;900&family=DM+Sans:wght@300;400;500;600&display=swap');

:root {
  --forest:    #1A4D2E;
  --forest-mid:#2E7D52;
  --accent:    #4CAF7C;
  --teal:      #1D9E75;
  --cream:     #F0F7F2;
  --cream-deep:#DFF0E7;
  --olive:     #5D8C3E;
  --white:     #FFFFFF;
  --ink:       #0D2A1A;
  --muted:     #6B8F7A;
}

* { box-sizing: border-box; margin: 0; padding: 0; }

body {
  font-family: 'DM Sans', sans-serif;
  background: var(--white);
  color: var(--ink);
  overflow-x: hidden;
}

/* ─── PERBAIKAN VIDEO BACKGROUND ──────────────── */
.hero {
  position: relative;
  min-height: 100vh;
  display: flex;
  align-items: center;
  background: var(--forest);
  overflow: hidden;
}

/* Wadah Iframe YouTube */
.video-background {
  position: absolute;
  top: 0; left: 0;
  width: 100%; height: 100%;
  pointer-events: none; /* Agar video tidak bisa diklik manual */
  z-index: 0;
}

.video-background iframe {
  width: 100vw;
  height: 56.25vw; /* Rasio 16:9 */
  min-height: 100vh;
  min-width: 177.77vh; /* Rasio 16:9 */
  position: absolute;
  top: 50%; left: 50%;
  transform: translate(-50%, -50%);
  opacity: 0.35; /* Transparansi video agar teks terbaca */
}

.hero-overlay {
  position: absolute; inset: 0;
  background: linear-gradient(135deg, rgba(26,77,46,0.92) 0%, rgba(29,158,117,0.3) 100%);
  z-index: 1;
}

/* ────────────────────────────────────────────── */

.hero::after {
  content: '';
  position: absolute;
  bottom: -2px; left: 0; right: 0;
  height: 120px;
  background: var(--white);
  clip-path: polygon(0 80%, 100% 0, 100% 100%, 0 100%);
  z-index: 2;
}

.hero-content {
  position: relative; z-index: 3;
  max-width: 900px;
  padding: 0 2rem;
}

.hero-eyebrow {
  display: inline-flex; align-items: center; gap: 10px;
  font-family: 'DM Sans', sans-serif;
  font-size: 0.75rem; font-weight: 600;
  letter-spacing: 0.18em; text-transform: uppercase;
  color: var(--accent);
  margin-bottom: 1.5rem;
  animation: fadeUp 0.8s ease both;
}

.hero-eyebrow span {
  display: block; width: 32px; height: 2px;
  background: var(--accent);
}

.hero-title {
  font-family: 'Playfair Display', serif;
  font-size: clamp(3rem, 7vw, 6rem);
  font-weight: 900;
  line-height: 1.05;
  color: #fff;
  margin-bottom: 1.5rem;
  animation: fadeUp 0.8s 0.15s ease both;
}

.hero-title em {
  font-style: italic;
  color: var(--accent);
}

.hero-sub {
  font-size: 1.125rem; font-weight: 300;
  color: rgba(255,255,255,0.72);
  max-width: 560px;
  line-height: 1.75;
  margin-bottom: 2.5rem;
  animation: fadeUp 0.8s 0.3s ease both;
}

.btn-hero {
  display: inline-block;
  padding: 1rem 2.5rem;
  background: var(--accent);
  color: var(--forest);
  font-family: 'DM Sans', sans-serif;
  font-weight: 600; font-size: 0.95rem;
  letter-spacing: 0.04em;
  border-radius: 0;
  border: 2px solid var(--accent);
  text-decoration: none;
  transition: all 0.3s ease;
  animation: fadeUp 0.8s 0.45s ease both;
  clip-path: polygon(0 0, calc(100% - 14px) 0, 100% 14px, 100% 100%, 0 100%);
}

.btn-hero:hover {
  background: transparent;
  color: var(--accent);
}

.section-tag {
  font-size: 0.7rem; font-weight: 700;
  letter-spacing: 0.22em; text-transform: uppercase;
  color: var(--teal);
  margin-bottom: 0.75rem;
}

.section-title {
  font-family: 'Playfair Display', serif;
  font-size: clamp(2rem, 4vw, 3rem);
  font-weight: 700;
  color: var(--forest);
  line-height: 1.15;
}

.why-section {
  padding: 7rem 0;
  background: var(--white);
}

.why-img-wrap {
  position: relative;
}

.why-img-wrap img {
  width: 100%;
  border-radius: 0;
  clip-path: polygon(0 0, 100% 0, 100% 90%, 92% 100%, 0 100%);
}

.why-img-wrap::before {
  content: '';
  position: absolute;
  top: -16px; right: -16px;
  width: 200px; height: 200px;
  border: 3px solid var(--accent);
  z-index: -1;
}

.why-img-wrap::after {
  content: '';
  position: absolute;
  bottom: 24px; left: -24px;
  width: 120px; height: 120px;
  background: var(--cream-deep);
  z-index: -1;
}

.why-text { padding-right: 3rem; }
.why-text .section-title { margin-bottom: 1.5rem; }
.why-text p { color: var(--muted); font-size: 1.05rem; line-height: 1.85; }

.accred-section {
  padding: 5rem 0;
  background: var(--forest);
  position: relative;
  overflow: hidden;
}

.accred-inner {
  max-width: 700px;
  margin: 0 auto;
  text-align: center;
  position: relative; z-index: 1;
}

.accred-badge {
  display: inline-block;
  padding: 0.4rem 1.2rem;
  border: 1px solid var(--accent);
  color: var(--accent);
  font-size: 0.7rem; font-weight: 700;
  letter-spacing: 0.2em; text-transform: uppercase;
  margin-bottom: 1.25rem;
}

.accred-title {
  font-family: 'Playfair Display', serif;
  font-size: clamp(2.5rem, 5vw, 4rem);
  font-weight: 900;
  color: #fff;
  line-height: 1.1;
  margin-bottom: 1rem;
}

.accred-desc { color: rgba(255,255,255,0.6); font-size: 1rem; line-height: 1.8; }
.accred-logo { margin-top: 2rem; filter: brightness(0) invert(1); opacity: 0.7; max-height: 80px; }

.news-section {
  padding: 7rem 0;
  background: var(--cream);
}

.news-header {
  display: flex;
  justify-content: space-between;
  align-items: flex-end;
  margin-bottom: 3.5rem;
}

.btn-outline-forest {
  display: inline-block;
  padding: 0.6rem 1.75rem;
  border: 1.5px solid var(--forest);
  color: var(--forest);
  font-weight: 600; font-size: 0.85rem;
  letter-spacing: 0.06em;
  text-decoration: none;
  border-radius: 0;
  transition: all 0.25s;
}

.btn-outline-forest:hover {
  background: var(--forest);
  color: #fff;
}

.news-card {
  background: var(--white);
  border: none;
  overflow: hidden;
  transition: transform 0.35s ease, box-shadow 0.35s ease;
  height: 100%;
}

.news-card:hover {
  transform: translateY(-6px);
  box-shadow: 0 20px 50px rgba(26,77,46,0.12);
}

.news-card-img {
  width: 100%; height: 220px;
  object-fit: cover;
  display: block;
  transition: transform 0.5s ease;
}

.news-card:hover .news-card-img { transform: scale(1.04); }
.news-card-body { padding: 1.5rem 1.75rem 2rem; }
.news-cat { font-size: 0.65rem; font-weight: 700; letter-spacing: 0.16em; text-transform: uppercase; color: var(--teal); margin-bottom: 0.6rem; display: block; }
.news-title { font-family: 'Playfair Display', serif; font-size: 1.1rem; font-weight: 700; color: var(--forest); line-height: 1.4; margin-bottom: 0.75rem; }
.news-excerpt { font-size: 0.88rem; color: var(--muted); line-height: 1.7; }

.testi-section {
  padding: 7rem 0;
  background: var(--white);
}

.testi-card {
    padding: 2rem;
    background: var(--cream);
    border-left: 3px solid var(--accent);
    height: auto;
    min-height: 100%; 
    display: flex;
    flex-direction: column;
    align-items: center;
    max-width: 100%;
    overflow: hidden;
}

.testi-card:hover {
  box-shadow: 8px 8px 0 var(--accent);
}

.testi-photo-large {
  width: 100px; height: 100px;
  border-radius: 50%;
  object-fit: cover;
  border: 4px solid var(--cream-light);
  margin-bottom: 1.5rem;
  box-shadow: 0 10px 20px rgba(0,0,0,0.1);
}

.testi-name { font-family: 'Playfair Display', serif; font-weight: 800; font-size: 1.2rem; color: var(--forest); margin-bottom: 0.25rem; }
.testi-status { font-size: 0.85rem; font-weight: 700; color: var(--teal); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 1rem; }
.testi-text { font-size: 0.97rem; color: var(--ink); line-height: 1.8; font-style: italic; margin-bottom: 1.5rem; word-break: normal; overflow-wrap: break-word; text-align: left; }

.partners-section {
    padding: 4rem 0;
    background: var(--cream);
    border-top: 1px solid var(--cream-deep);
}

.partners-label { font-size: 0.65rem; font-weight: 700; letter-spacing: 0.25em; text-transform: uppercase; color: var(--muted); text-align: center; margin-bottom: 2.5rem; }
.partner-logo-wrap { padding: 15px; background: white; border-radius: 15px; transition: all 0.3s ease; display: flex; align-items: center; justify-content: center; height: 130px; border: 1px solid var(--cream-deep); }
.partner-img { max-height: 85px; max-width: 90%; filter: none !important; opacity: 1 !important; object-fit: contain; }

@keyframes fadeUp { from { opacity: 0; transform: translateY(28px); } to { opacity: 1; transform: translateY(0); } }
.reveal { opacity: 0; transform: translateY(32px); transition: opacity 0.7s ease, transform 0.7s ease; }
.reveal.visible { opacity: 1; transform: translateY(0); }
</style>

<!-- 1. HERO (YOUTUBE VERSION) -->
<section class="hero">
    @if($videoId)
        <div class="video-background">
            <iframe 
                src="https://www.youtube.com/embed/{{ $videoId }}?autoplay=1&mute=1&loop=1&playlist={{ $videoId }}&controls=0&showinfo=0&rel=0&enablejsapi=1" 
                frameborder="0" 
                allow="autoplay; encrypted-media" 
                allowfullscreen>
            </iframe>
        </div>
    @endif
    <div class="hero-overlay"></div>

    <div class="container">
        <div class="hero-content">
            <div class="hero-eyebrow">
                <span></span>
                Institut Teknologi Del — Teknik Bioproses
            </div>
            <h1 class="hero-title">
                {{ $hero->title ?? 'Engineering' }}<br>
                <em>the Future.</em>
            </h1>
            <p class="hero-sub">
                {{ $hero->subtitle ?? 'Selamat Datang di Teknik Bioproses IT Del.' }}
            </p>
            <a href="{{ $hero->button_1_url ?? '#' }}" class="btn-hero">
                {{ $hero->button_1_text ?? 'Daftar Sekarang' }}
            </a>
        </div>
    </div>
</section>

<!-- 2. MENGAPA KAMI? -->
<section class="why-section py-5">
    <div class="container py-5">
        <div class="row align-items-center">
            @if($why = $profiles->get('WHY_US'))
                <div class="col-lg-5 mb-5 mb-lg-0 reveal">
                    <div class="why-img-wrap">
                        @if($why->image)
                            <img src="{{ asset('storage/' . $why->image) }}" alt="Mengapa Bioproses">
                        @endif
                    </div>
                </div>
                <div class="col-lg-6 offset-lg-1 why-text reveal">
                    <p class="section-tag">Kenapa Kami?</p>
                    <h2 class="section-title mb-4">{{ $why->name }}</h2>
                    <div>{!! $why->description !!}</div>
                </div>
            @endif
        </div>
    </div>
</section>

<!-- 3. AKREDITASI -->
<section class="accred-section">
    <div class="container">
        <div class="accred-inner reveal">
            @if($acc = $profiles->get('ACCREDITATION'))
                <div class="accred-badge">Validasi Mutu</div>
                <div class="accred-title">{{ $acc->name }}</div>
                <div class="accred-desc">{!! $acc->description !!}</div>
                @if($acc->image)
                    <img src="{{ asset('storage/' . $acc->image) }}" class="accred-logo" data-bs-toggle="modal" data-bs-target="#modalAccred" style="cursor:pointer">
                @endif
            @endif
        </div>
    </div>
</section>

<!-- 4. KABAR TERBARU -->
<section class="news-section">
    <div class="container">
        <div class="news-header reveal">
            <div><p class="section-tag">Kabar Terbaru</p><h2 class="section-title">Aktivitas & Berita</h2></div>
            <a href="/berita" class="btn-outline-forest">Lihat Semua →</a>
        </div>
        <div class="row g-4">
            @foreach($latestNews as $i => $item)
            <div class="col-md-4 reveal" style="transition-delay: {{ $i * 0.1 }}s;">
                <div class="news-card">
                    <img src="{{ asset('storage/' . $item->image) }}" class="news-card-img">
                    <div class="news-card-body">
                        <span class="news-cat">{{ $item->category->name }}</span>
                        <div class="news-title">{{ $item->title }}</div>
                        <p class="news-excerpt">{{ Str::limit(strip_tags($item->content), 100) }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- 5. TESTIMONI -->
<section class="testi-section">
    <div class="container">
        <div class="text-center mb-5 reveal"><p class="section-tag">Testimoni</p><h2 class="section-title">Suara Alumni & Mahasiswa</h2></div>
        <div class="row g-4">
            @foreach($testimonials as $i => $testi)
            <div class="col-md-4 reveal">
                <div class="testi-card">
                    <img src="{{ asset('storage/' . $testi->photo) }}" class="testi-photo-large">
                    <div class="testi-name">{{ $testi->name }}</div>
                    <div class="testi-status">{{ $testi->position }} <br><span class="small text-muted">Angkatan {{ $testi->batch }}</span></div>
                    <p class="testi-text">"{{ $testi->content }}"</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- 6. MITRA -->
<section class="partners-section py-5">
    <div class="container">
        <p class="partners-label">Mitra Strategis Kami</p>
        <div class="row row-cols-2 row-cols-md-4 row-cols-lg-5 g-4 justify-content-center align-items-center">
            @foreach($mitras as $mitra)
            <div class="col text-center">
                <div class="partner-logo-wrap reveal" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#mitraModal{{ $mitra->id }}">
                    <img src="{{ asset('storage/' . $mitra->logo) }}" alt="{{ $mitra->name }}" class="partner-img">
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<script>
const observer = new IntersectionObserver((entries) => {
    entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('visible'); observer.unobserve(e.target); } });
}, { threshold: 0.12 });
document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
</script>

@endsection
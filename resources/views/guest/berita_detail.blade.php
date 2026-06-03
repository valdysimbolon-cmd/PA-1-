@extends('layouts.guest_layout')

@section('title', $news->title)

@section('content')

<style>
:root { --forest: #1A4D2E; --accent: #4CAF7C; --cream: #F0F7F2; }

.news-header-simple { background: var(--forest); padding: 7rem 0 4rem; color: white; margin-bottom: 3rem; }
.news-title-big { font-family: 'Playfair Display', serif; font-size: clamp(1.8rem, 4vw, 2.8rem); font-weight: 800; line-height: 1.2; }
.news-detail-grid { display: grid; grid-template-columns: 1fr 1.2fr; gap: 4rem; align-items: start; margin-bottom: 5rem; }
.news-sticky-img { position: sticky; top: 100px; }
.img-frame { width: 100%; border-radius: 15px; overflow: hidden; box-shadow: 0 15px 35px rgba(0,0,0,0.1); }
.img-frame img { width: 100%; height: auto; display: block; }
.news-description { font-size: 1.1rem; line-height: 1.8; color: #333; }
.news-description p { margin-bottom: 1.5rem; text-align: justify; }
.news-footer-box { background: var(--cream); padding: 1.5rem; border-radius: 12px; display: flex; justify-content: space-between; align-items: center; margin-top: 3rem; }
.btn-back-pill { display: inline-block; padding: 10px 25px; background: var(--forest); color: #fff !important; border-radius: 50px; text-decoration: none; font-weight: 600; transition: 0.3s; margin-top: 2rem; }
.btn-back-pill:hover { background: var(--accent); }

@media (max-width: 900px) {
  .news-detail-grid { grid-template-columns: 1fr; gap: 2rem; }
  .news-sticky-img { position: relative; top: 0; }
}
</style>

<header class="news-header-simple">
    <div class="container text-center text-lg-start">
        {{-- BREADCRUMB DIBERSIHKAN DARI PENANDA KATEGORI --}}
        <div class="mb-2 small opacity-75 text-uppercase fw-bold" style="letter-spacing: 2px;">
            <a href="/berita" class="text-white text-decoration-none">Berita Terkini</a>
        </div>
        <h1 class="news-title-big mb-3">{{ $news->title }}</h1>
        <div class="small opacity-50">
            <i class="bi bi-calendar3 me-1"></i> {{ \Carbon\Carbon::parse($news->published_at)->translatedFormat('d F Y') }}
        </div>
    </div>
</header>

<div class="container">
    <div class="news-detail-grid">
        <div class="news-sticky-img">
            <div class="img-frame">
                @if($news->image)
                    <img src="{{ asset('storage/' . $news->image) }}" alt="Berita">
                @else
                    <div class="bg-light d-flex align-items-center justify-content-center" style="height: 300px;">
                        <i class="bi bi-image text-muted fs-1"></i>
                    </div>
                @endif
            </div>
        </div>

        <div class="news-description">
            <article>
                {!! $news->content !!}
            </article>

            <div class="news-footer-box shadow-sm">
                <div>
                    <small class="text-muted d-block">Topik Berita:</small>
                    <span class="fw-bold text-success">{{ $news->category->name }}</span>
                </div>
                <div class="text-end">
                    <small class="text-muted d-block mb-1">Bagikan:</small>
                    <a href="https://wa.me/?text={{ urlencode($news->title . ' ' . url()->current()) }}" target="_blank" class="text-success fs-5 me-2"><i class="bi bi-whatsapp"></i></a>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}" target="_blank" class="text-primary fs-5"><i class="bi bi-facebook"></i></a>
                </div>
            </div>

            <a href="/berita" class="btn-back-pill shadow-sm">
                <i class="bi bi-arrow-left me-2"></i> Kembali ke Berita
            </a>
        </div>
    </div>
</div>
@endsection
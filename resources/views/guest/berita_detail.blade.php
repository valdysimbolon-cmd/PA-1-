@extends('layouts.guest_layout')

@section('title', $news->title)

@section('content')

<style>
/* ── Container Utama ── */
.news-detail-wrapper {
    background-color: #ffffff;
    padding-bottom: 5rem;
    min-height: 100vh;
}

/* ── Bar Hijau Elegan di Atas ── */
.top-accent-bar {
    height: 8px;
    background-color: var(--forest); /* Hijau Tua IT Del */
    width: 100%;
    margin-bottom: 4rem;
}

.article-container {
    max-width: 850px;
    margin: 0 auto;
    padding: 0 20px;
}

/* ── Judul & Meta ── */
.article-header {
    margin-bottom: 2.5rem;
}

.article-title {
    font-family: 'DM Sans', sans-serif;
    font-weight: 800;
    font-size: clamp(1.8rem, 4vw, 2.6rem);
    color: #1a1a1a;
    line-height: 1.2;
    margin-bottom: 12px;
}

.article-meta {
    font-size: 0.85rem;
    color: #888;
    text-transform: uppercase;
    letter-spacing: 1px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.author-name {
    color: var(--forest);
    font-weight: 700;
}

.meta-divider {
    width: 4px;
    height: 4px;
    background-color: #ccc;
    border-radius: 50%;
}

/* ── Gambar ── */
.article-image-box {
    margin-bottom: 3rem;
}

.article-featured-img {
    width: 100%;
    height: auto;
    border-radius: 12px; /* Lebih rapi */
    box-shadow: 0 10px 30px rgba(0,0,0,0.08);
}

/* ── Konten Teks ── */
.article-content {
    font-size: 1.12rem;
    line-height: 1.9;
    color: #333;
    text-align: justify; /* Rata kanan kiri */
}

.article-content p {
    margin-bottom: 1.6rem;
}

/* ── Tombol Kembali ── */
.btn-back-minimal {
    display: inline-flex;
    align-items: center;
    margin-top: 4rem;
    padding: 10px 0;
    color: var(--forest);
    text-decoration: none;
    font-weight: 700;
    font-size: 0.85rem;
    border-bottom: 2px solid transparent;
    transition: 0.3s;
}

.btn-back-minimal:hover {
    border-bottom-color: var(--accent);
    gap: 15px;
}
</style>

<div class="news-detail-wrapper">
    {{-- Garis Hijau di Paling Atas --}}
    <div class="top-accent-bar"></div>

    <div class="article-container">
        
        {{-- 1. Judul & Info --}}
        <header class="article-header text-start">
            <h1 class="article-title">{{ $news->title }}</h1>
            
            <div class="article-meta">
                {{-- Kata 'By' sudah dihapus --}}
                <span class="meta-divider"></span>
                <span>{{ \Carbon\Carbon::parse($news->published_at)->format('M d, Y') }}</span>
            </div>
        </header>

        {{-- 2. Gambar Utama --}}
        <div class="article-image-box">
            @if($news->image)
                <img src="{{ asset('storage/' . $news->image) }}" class="article-featured-img" alt="Berita">
            @else
                <div class="bg-light d-flex align-items-center justify-content-center rounded-4" style="height: 350px;">
                    <i class="bi bi-image text-muted opacity-25" style="font-size: 4rem;"></i>
                </div>
            @endif
        </div>

        {{-- 3. Isi Berita --}}
        <div class="article-content">
            <article>
                {!! $news->content !!}
            </article>
        </div>

        {{-- 4. Tombol Kembali --}}
        <div class="border-top mt-5">
            <a href="/berita" class="btn-back-minimal">
                <i class="bi bi-arrow-left me-2"></i> KEMBALI KE DAFTAR BERITA
            </a>
        </div>

    </div>
</div>

@endsection
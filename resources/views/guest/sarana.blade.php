@extends('layouts.guest_layout')

@section('title', 'Ruangan & Sarana - Teknik Bioproses IT Del')

@section('content')

{{-- ══════ HEADER ══════ --}}
<div class="profil-header">
    <div class="container profil-header-inner text-center">
        <span class="bp-tag">Fasilitas & Prasarana</span>
        <h1>Ruangan & <em>Sarana</em></h1>
        <p class="mx-auto" style="max-width: 750px; opacity: 0.9; line-height: 1.6;">
            Dukungan infrastruktur modern untuk menciptakan lingkungan belajar dan riset yang kondusif bagi civitas akademika Teknik Bioproses.
        </p>
    </div>
    <div class="profil-header-cut"></div>
</div>

{{-- ══════ BODY ══════ --}}
<div class="profil-body bg-light py-5">
    <div class="container">
        <div class="row g-4">
            @forelse($facilities as $f)
                <div class="col-12">
                    <div class="facility-card card border-0 shadow-sm overflow-hidden rounded-4 bg-white">
                        <div class="row g-0 align-items-stretch">

                            {{-- Sisi Gambar --}}
                            <div class="col-lg-4 col-md-5">
                                <div class="facility-img-wrap">
                                    @if($f->image)
                                        <img
                                            src="{{ asset('storage/' . $f->image) }}"
                                            class="facility-img"
                                            alt="{{ $f->name }}"
                                        >
                                    @else
                                        <div class="facility-img-placeholder">
                                            <i class="bi bi-door-open display-4 text-muted opacity-25"></i>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            {{-- Sisi Informasi --}}
                            <div class="col-lg-8 col-md-7 d-flex align-items-center">
                                <div class="card-body p-4 p-md-5">
                                    <span class="badge bg-success-subtle text-success border border-success px-3 py-2 small fw-bold mb-3 d-inline-block">
                                        {{ strtoupper($f->type) }}
                                    </span>

                                    <h2 class="fw-bold mb-4 facility-title">{{ $f->name }}</h2>

                                    <div class="row g-3 mb-4 border-top border-bottom py-3">
                                        <div class="col-sm-6 border-end">
                                            <small class="text-muted text-uppercase d-block fw-bold facility-label">Lokasi Ruangan</small>
                                            <span class="text-dark small">
                                                <i class="bi bi-geo-alt me-1"></i>{{ $f->location }}
                                            </span>
                                        </div>
                                        <div class="col-sm-6">
                                            <small class="text-muted text-uppercase d-block fw-bold facility-label">Kapasitas</small>
                                            <span class="text-dark small">
                                                <i class="bi bi-people me-1"></i>{{ $f->capacity ?? '-' }} Orang
                                            </span>
                                        </div>
                                    </div>

                                    <div class="text-muted small facility-desc">
                                        {!! $f->description !!}
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5 text-muted fst-italic">
                    Data sarana belum tersedia saat ini.
                </div>
            @endforelse
        </div>
    </div>
</div>

<style>
    /* ── Gambar ── */
    .facility-img-wrap {
        position: relative;
        height: 260px;           /* tinggi tetap, tidak terlalu besar */
        overflow: hidden;
        border-radius: 0;
    }
    .facility-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
        display: block;
        transition: transform 0.4s ease;
    }
    .facility-card:hover .facility-img {
        transform: scale(1.04);
    }
    .facility-img-placeholder {
        width: 100%;
        height: 100%;
        background: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* ── Card ── */
    .facility-card {
        transition: box-shadow 0.3s ease, transform 0.3s ease;
    }
    .facility-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 16px 36px rgba(0, 0, 0, 0.09) !important;
    }

    /* ── Teks ── */
    .facility-title {
        color: var(--forest, #1a5c38);
        font-family: 'Playfair Display', serif;
        font-size: 1.35rem;
        line-height: 1.4;
    }
    .facility-label {
        font-size: 10px;
        letter-spacing: 0.05em;
    }
    .facility-desc {
        line-height: 1.8;
        text-align: justify;
    }

    /* ── Badge ── */
    .bg-success-subtle {
        background-color: #f0f7f2 !important;
    }

    /* ── Responsif mobile: gambar di atas, teks di bawah ── */
    @media (max-width: 767.98px) {
        .facility-img-wrap {
            height: 200px;
            border-radius: 0;
        }
        .col-md-5.border-end {
            border-right: none !important;
            border-bottom: 1px solid #dee2e6;
            padding-bottom: 0.5rem;
        }
    }
</style>

@endsection
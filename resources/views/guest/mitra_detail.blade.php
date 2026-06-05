@extends('layouts.guest_layout')

@section('title', 'Detail Mitra - ' . $mitra->name)

@section('content')
<div style="height: 8px; background-color: var(--forest); width: 100%;"></div>

<div class="bg-white" style="min-height: 100vh;">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                
                <nav class="mb-4 small text-uppercase fw-bold opacity-50">
                    <a href="{{ route('public.mitra.index') }}" class="text-dark text-decoration-none">
                        <i class="bi bi-arrow-left"></i> Kembali ke Daftar Mitra
                    </a>
                </nav>

                <div class="text-center mb-5">
                    <div class="p-4 bg-light d-inline-block rounded-4 mb-4 border">
                        <img src="{{ asset('storage/' . $mitra->logo) }}" style="max-height: 120px; object-fit: contain;">
                    </div>
                    <h1 class="fw-bold mb-2" style="font-family: 'Playfair Display', serif; color: var(--forest); font-size: 2.5rem;">
                        {{ $mitra->name }}
                    </h1>
                    <span class="badge bg-success px-3 py-2 rounded-pill">Mitra {{ $mitra->type }}</span>
                </div>

                <div class="mitra-desc text-muted" style="line-height: 2; font-size: 1.1rem; text-align: justify;">
                    <h5 class="text-dark fw-bold mb-3">Deskripsi Kerjasama</h5>
                    {!! nl2br(e($mitra->description ?? 'Informasi detail mengenai bentuk kerjasama ini belum tersedia.')) !!}
                </div>

                @if($mitra->website_url)
                    <div class="mt-4">
                        <a href="{{ $mitra->website_url }}" target="_blank" class="btn btn-outline-success rounded-pill px-4">
                            Kunjungi Website <i class="bi bi-box-arrow-up-right ms-1"></i>
                        </a>
                    </div>
                @endif

                <div class="mt-5 pt-4 border-top text-muted small">
                    Terjalin sejak: {{ $mitra->start_date ? date('d F Y', strtotime($mitra->start_date)) : '-' }}
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
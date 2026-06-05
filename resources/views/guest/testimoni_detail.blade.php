@extends('layouts.guest_layout')

@section('title', 'Success Story: ' . ($testi->name ?? 'Detail'))

@section('content')
{{-- Bar Aksen Hijau di Paling Atas --}}
<div style="height: 8px; background-color: var(--forest); width: 100%;"></div>

<div class="bg-white" style="min-height: 100vh;">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                
                {{-- Tombol Kembali --}}
                <nav class="mb-5 small text-uppercase fw-bold opacity-50">
                    <a href="{{ route('public.testimoni.index') }}" class="text-dark text-decoration-none">
                        <i class="bi bi-arrow-left"></i> Kembali ke Daftar
                    </a>
                </nav>

                {{-- Header Identitas --}}
                <div class="text-center mb-5">
                    @if($testi->photo)
                        <img src="{{ asset('storage/' . $testi->photo) }}" 
                             class="rounded-circle border border-4 border-light shadow mb-4" 
                             style="width: 140px; height: 140px; object-fit: cover;">
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($testi->name) }}" class="rounded-circle mb-4" style="width:140px;">
                    @endif
                    
                    <h1 class="fw-bold mb-2" style="font-family: 'Playfair Display', serif; color: var(--forest); font-size: 2.5rem;">
                        {{ $testi->name }}
                    </h1>
                    <div class="text-teal fw-bold text-uppercase small" style="letter-spacing: 2px;">
                        {{ $testi->position }} — Angkatan {{ $testi->batch }}
                    </div>
                </div>

                <hr class="mb-5 opacity-25">

                {{-- Isi Cerita --}}
                <div class="testi-long-content" style="line-height: 2; font-size: 1.15rem; text-align: justify; color: #333; font-style: italic;">
                    <i class="bi bi-quote fs-1 text-success opacity-25 d-block mb-2"></i>
                    {!! $testi->content !!}
                </div>

                <div class="mt-5 pt-5 border-top text-center text-muted small">
                    Program Studi Teknik Bioproses — Institut Teknologi Del
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
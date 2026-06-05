@extends('layouts.guest_layout')

@section('title', 'Mitra Strategis - Teknik Bioproses IT Del')

@section('content')
<div class="profil-header">
    <div class="container profil-header-inner text-center">
        <span class="bp-tag">Jejaring Global</span>
        <h1>Mitra <em>Strategis</em></h1>
        <p class="mx-auto" style="max-width:700px;">Kerjasama Teknik Bioproses dengan institusi akademik, industri, dan pemerintah.</p>
    </div>
    <div class="profil-header-cut"></div>
</div>

<div class="profil-body bg-light py-5">
    <div class="container">
        <div class="row g-4">
            @forelse($mitras as $mitra)
                <div class="col-lg-3 col-md-4 col-6">
                    {{-- LINK KE DETAIL --}}
                    <a href="{{ route('public.mitra.show', $mitra->id) }}" class="text-decoration-none">
                        <div class="card h-100 border-0 shadow-sm p-4 text-center partner-card">
                            <div class="d-flex align-items-center justify-content-center mb-3" style="height: 100px;">
                                <img src="{{ asset('storage/' . $mitra->logo) }}" class="img-fluid" style="max-height: 80px; object-fit: contain;">
                            </div>
                            <h6 class="fw-bold text-dark mb-1">{{ $mitra->name }}</h6>
                            <span class="badge bg-success-subtle text-success small border">{{ $mitra->type }}</span>
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-12 text-center py-5 text-muted">Belum ada data mitra.</div>
            @endforelse
        </div>
    </div>
</div>

<style>
    .partner-card { transition: 0.3s; border-radius: 20px; }
    .partner-card:hover { transform: translateY(-10px); background: #ffffff; border: 1px solid #4CAF7C !important; }
</style>
@endsection
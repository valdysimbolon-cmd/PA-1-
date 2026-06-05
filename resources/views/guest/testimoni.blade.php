@extends('layouts.guest_layout')

@section('title', 'Suara Alumni - Teknik Bioproses IT Del')

@section('content')

{{-- HEADER --}}
<div class="profil-header">
    <div class="container profil-header-inner text-center">
        <span class="bp-tag">Inspirasi Alumni</span>
        <h1>Suara <em>Civitas</em></h1>
        <p class="mx-auto" style="max-width: 750px;">
            Cerita sukses dan pengalaman belajar dari para alumni serta mahasiswa Teknik Bioproses IT Del.
        </p>
    </div>
    <div class="profil-header-cut"></div>
</div>

<div class="profil-body bg-light py-5">
    <div class="container">
        <div class="row g-4">
            @forelse($testimonials as $testi)
                <div class="col-lg-4 col-md-6">
                    {{-- LINK KE DETAIL --}}
                    <a href="{{ route('public.testimoni.show', $testi->id) }}" class="text-decoration-none">
                        <div class="card h-100 border-0 shadow-sm rounded-4 p-4 testi-card-premium">
                            <div class="d-flex align-items-center gap-3 mb-4">
                                @if($testi->photo)
                                    <img src="{{ asset('storage/' . $testi->photo) }}" 
                                         class="rounded-circle border border-2 border-success p-1 shadow-sm" 
                                         style="width: 65px; height: 65px; object-fit: cover;">
                                @else
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($testi->name) }}" class="rounded-circle" style="width:65px;">
                                @endif
                                <div>
                                    <h6 class="fw-bold mb-0 text-dark">{{ $testi->name }}</h6>
                                    <small class="text-muted text-uppercase" style="font-size: 0.65rem;">
                                        Angkatan {{ $testi->batch }}
                                    </small>
                                </div>
                            </div>
                            
                            <div class="text-muted mb-4 small" style="text-align: justify; line-height: 1.6;">
                                "{{ Str::limit(strip_tags($testi->content), 120) }}"
                            </div>

                            <div class="mt-auto pt-3 border-top d-flex justify-content-between align-items-center">
                                <span class="small fw-bold text-success">{{ $testi->position }}</span>
                                <span class="text-muted small fw-bold">DETAIL →</span>
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <div class="alert alert-info">Belum ada data testimoni yang tersedia di database.</div>
                </div>
            @endforelse
        </div>
    </div>
</div>

<style>
.testi-card-premium { transition: 0.3s; border: 1px solid transparent !important; }
.testi-card-premium:hover { transform: translateY(-10px); background: #ffffff; border-color: #4CAF7C !important; box-shadow: 0 10px 30px rgba(0,0,0,0.1) !important; }
</style>

@endsection
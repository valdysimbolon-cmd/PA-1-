@extends('layouts.guest_layout')

@section('title', 'Unit Laboratorium - Teknik Bioproses IT Del')

@section('content')
<div class="profil-header">
    <div class="container profil-header-inner d-flex flex-column justify-content-center align-items-center text-center">
        <span class="bp-tag">Fasilitas Kampus</span>
        <h1>Unit <em>Laboratorium</em></h1>
        <p>Pusat riset dan praktikum dengan standar teknologi tinggi.</p>
    </div>
    <div class="profil-header-cut"></div>
</div>

<div class="profil-body bg-light py-5">
    <div class="container">
        <div class="row g-4 justify-content-center">
            @foreach($labs as $lab)
            <div class="col-md-4">
                <a href="{{ route('public.lab.show', $lab->slug) }}" class="text-decoration-none">
                    <div class="card h-100 border-0 shadow-sm overflow-hidden" style="border-radius: 15px; transition: 0.3s;">
                        <div style="height: 200px; overflow: hidden;">
                            <img src="{{ asset('storage/'.$lab->image) }}" class="w-100 h-100" style="object-fit: cover;">
                        </div>
                        <div class="card-body p-4 text-center">
                            <span class="badge bg-success-subtle text-success mb-2 px-3">{{ $lab->category }}</span>
                            <h5 class="fw-bold text-dark mb-0">{{ $lab->name }}</h5>
                            <hr class="mx-auto" style="width: 40px; border-top: 2px solid var(--accent);">
                            <small class="text-muted italic">Lihat Detail →</small>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</div>

<style>
    .card:hover { transform: translateY(-10px); box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important; }
</style>
@endsection
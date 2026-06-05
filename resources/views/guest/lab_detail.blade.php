@extends('layouts.guest_layout')

@section('title', $lab->name)

@section('content')
{{-- HEADER --}}
<div class="profil-header">
    <div class="container profil-header-inner text-start">
        <span class="bp-tag" style="color: var(--accent);">Fasilitas Riset & Pendidikan</span>
        <h1>{{ $lab->name }}</h1>
        <p><i class="bi bi-geo-alt me-2"></i>{{ $lab->location ?? 'Gedung Laboratorium IT Del' }}</p>
    </div>
    <div class="profil-header-cut"></div>
</div>

<div class="profil-body bg-white">
    <div class="container">
        <div class="profil-grid">
            
            {{-- ── SIDEBAR: HANYA DAFTAR NAMA LAB ── --}}
            <aside class="profil-sidenav">
                <span class="profil-sidenav-label">Unit Laboratorium</span>
                
                {{-- Kita asumsikan $allLabs dikirim dari Controller --}}
                @php $allLabs = \App\Models\Lab::where('active', 1)->get(); @endphp
                
                @foreach($allLabs as $item)
                    <a href="{{ route('public.lab.show', $item->slug) }}" 
                       class="profil-nav-item {{ $item->id == $lab->id ? 'active' : '' }}" 
                       style="text-decoration: none; display: block;">
                        <span class="pni-dot"></span> {{ $item->name }}
                    </a>
                @endforeach
                
                <div class="mt-4 pt-3 border-top">
                    <a href="{{ route('public.labs') }}" class="text-success small fw-bold text-decoration-none">
                        ← KEMBALI KE DAFTAR
                    </a>
                </div>
            </aside>

            {{-- ── CONTENT AREA: SEMUA INFO DITAMPILKAN LANGSUNG ── --}}
            <div class="profil-content-area text-start">
                
                {{-- 1. PROFIL & DESKRIPSI --}}
                <div class="profil-card mb-4">
                    <h2 class="profil-card-title">Gambaran Umum</h2>
                    <span class="profil-card-divider"></span>
                    
                    @if($lab->image)
                        <img src="{{ asset('storage/'.$lab->image) }}" class="img-fluid rounded-4 shadow-sm mb-4 w-100" style="max-height: 450px; object-fit: cover;">
                    @endif


                    <div class="profil-desc text-dark" style="text-align: justify; line-height: 1.9; font-size: 1.1rem;">
                        {!! $lab->description !!}
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<style>
/* Styling agar sidebar menu rapi */
.profil-nav-item {
    transition: all 0.2s;
    border-radius: 8px;
    margin-bottom: 4px;
}
.profil-nav-item:hover {
    background-color: var(--cream);
    padding-left: 30px !important;
}
.profil-nav-item.active {
    background-color: var(--forest);
    color: white !important;
}
.bg-success-subtle { background-color: #eef7f2 !important; }
</style>

@endsection
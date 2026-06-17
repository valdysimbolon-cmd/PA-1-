@extends('layouts.guest_layout')

@section('title', 'Informasi Beasiswa - Teknik Bioproses IT Del')

@push('styles')
<style>
    :root {
        --bg-image: url('{{ asset("guest_assets/img/beasiswa-bg.jpg") }}');
    }
</style>
@endpush
@section('content')

{{-- ══════ HEADER dengan gaya sama ══════ --}}
<div class="ph-wrap">
    <div class="ph-bg"></div>
    <div class="ph-overlay"></div>
    <div class="ph-grid"></div>
    <div class="ph-vignette"></div>

    <div class="container ph-inner">
        <div class="ph-eyebrow">Dukungan Pendidikan</div>
        <h1 class="ph-title">Beasiswa & <em>Bantuan</em></h1>
        <p class="ph-sub">Informasi mengenai berbagai skema pembiayaan dan penghargaan bagi mahasiswa berprestasi dan layak bantu.</p>
    </div>

    <div class="ph-wave">
        <svg viewBox="0 0 1440 70" preserveAspectRatio="none" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0,40 C360,80 1080,0 1440,40 L1440,70 L0,70 Z" fill="var(--cream)"/>
        </svg>
    </div>
</div>

{{-- ══════ BODY beasiswa ══════ --}}
<div class="beasiswa-body">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="beasiswa-card p-4 p-md-5">
                    {{-- Judul dari Database --}}
                    <h2 class="beasiswa-card-title">{{ $data->name }}</h2>
                    <span class="beasiswa-card-divider mb-4"></span>

                    {{-- Gambar (jika ada) --}}
                    @if($data->image)
                        <div class="mb-5 text-center">
                            <img src="{{ asset('storage/' . $data->image) }}" 
                                 class="beasiswa-img img-fluid shadow-sm w-100" 
                                 alt="{{ $data->name }}">
                        </div>
                    @endif

                    {{-- Deskripsi konten --}}
                    <div class="beasiswa-desc">
                        {!! $data->description !!}
                    </div>

                    {{-- Footer info tambahan --}}
                    <div class="mt-5 pt-4 border-top">
                        <div class="info-alert d-flex gap-3 align-items-center">
                            <i class="bi bi-info-circle-fill fs-4" style="color: var(--accent);"></i>
                            <div class="small">
                                Informasi lebih lanjut mengenai pendaftaran beasiswa dapat ditanyakan langsung ke bagian <strong>Kemahasiswaan IT Del</strong>.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@extends('layouts.guest_layout')

@section('title', 'Informasi Beasiswa - Teknik Bioproses IT Del')

@section('content')

{{-- ══════ HEADER ══════ --}}
<div class="profil-header">
    <div class="container profil-header-inner text-center">
        <span class="bp-tag">Dukungan Pendidikan</span>
        <h1>Beasiswa & <em>Bantuan</em></h1>
        <p class="mx-auto" style="max-width: 750px; opacity: 0.9;">
            Informasi mengenai berbagai skema pembiayaan dan penghargaan bagi mahasiswa berprestasi dan layak bantu.
        </p>
    </div>
    <div class="profil-header-cut"></div>
</div>

{{-- ══════ BODY ══════ --}}
<div class="profil-body bg-light py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                
                <div class="profil-card shadow-sm p-4 p-md-5 bg-white rounded-4">
                    {{-- Judul dari Database --}}
                    <h2 class="profil-card-title text-forest fw-bold mb-3">{{ $data->name }}</h2>
                    <span class="profil-card-divider mb-4"></span>

                    {{-- Gambar (Jika ada) --}}
                    @if($data->image)
                        <div class="mb-5 text-center">
                            <img src="{{ asset('storage/' . $data->image) }}" class="img-fluid rounded-4 shadow-sm w-100" style="max-height: 450px; object-fit: cover;">
                        </div>
                    @endif

                    {{-- Deskripsi (Justify & Elegant) --}}
                    <div class="profil-desc text-dark" style="text-align: justify; line-height: 2; font-size: 1.1rem;">
                        {!! $data->description !!}
                    </div>

                    {{-- Footer Info --}}
                    <div class="mt-5 pt-4 border-top">
                        <div class="alert alert-success border-0 shadow-sm rounded-3">
                            <div class="d-flex gap-3 align-items-center text-success">
                                <i class="bi bi-info-circle-fill fs-4"></i>
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
</div>
@endsection
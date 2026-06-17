@extends('layouts.admin')

@section('title', 'Tambah Hero Banner')

@section('content')
<div class="container-fluid px-3 px-md-4 pb-5">
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mt-4 mb-4">
        <div>
            <h1 class="h3 text-gray-800 mb-1">Tambah Hero Banner</h1>
            <p class="text-muted small mb-0">Atur konten dan video YouTube untuk tampilan beranda.</p>
        </div>
        <a href="{{ route('heroes.index') }}" class="btn btn-light border px-3 fw-bold small text-muted shadow-sm">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-12 col-lg-10">
            <div class="card shadow-sm border-0">
                <div class="card-header py-3 bg-success text-white">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-plus-circle me-2"></i>Formulir Hero Banner Baru
                    </h6>
                </div>
                <div class="card-body p-3 p-md-4">
                    <form action="{{ route('heroes.store') }}" method="POST">
                        @csrf

                        <div class="row g-4">
                            <!-- KOLOM KIRI -->
                            <div class="col-12 col-md-8">
                                <div class="mb-4">
                                    <label class="form-label fw-bold text-dark">Slogan Utama <span class="text-danger">*</span></label>
                                    <input type="text" name="title" class="form-control shadow-sm @error('title') is-invalid @enderror"
                                           value="{{ old('title') }}" placeholder="cth. Inovasi dari Laboratorium untuk Masa Depan" required>
                                    @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-bold text-dark">Sub Slogan <span class="text-danger">*</span></label>
                                    <textarea name="subtitle" rows="3" class="form-control shadow-sm @error('subtitle') is-invalid @enderror"
                                              placeholder="Deskripsi singkat program studi..." required>{{ old('subtitle') }}</textarea>
                                    @error('subtitle') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-bold text-dark">URL Video YouTube</label>
                                    <div class="input-group shadow-sm">
                                        <span class="input-group-text bg-light text-success"><i class="fab fa-youtube"></i></span>
                                        <input type="url" name="video_url" id="videoUrl" class="form-control @error('video_url') is-invalid @enderror"
                                               value="{{ old('video_url') }}" placeholder="https://www.youtube.com/watch?v=xxxxx">
                                    </div>
                                    <div class="form-text mt-2">
                                        <i class="fas fa-info-circle me-1"></i> Video akan diputar otomatis, tanpa suara, dan berulang sebagai background beranda.
                                    </div>
                                    @error('video_url') <div class="invalid-feedback">{{ $message }}</div> @enderror

                                    <div id="videoPreview" class="mt-3 d-none">
                                        <p class="small fw-bold text-success mb-1">Preview:</p>
                                        <div class="ratio ratio-16x9 rounded overflow-hidden shadow-sm" style="max-width:400px;">
                                            <iframe id="previewFrame" src="" allowfullscreen></iframe>
                                        </div>
                                    </div>
                                </div>

                                <div class="card border shadow-sm mt-4">
                                    <div class="card-header bg-light">
                                        <h6 class="m-0 fw-bold text-dark"><i class="fas fa-mouse-pointer me-2"></i>Tombol CTA (Call to Action)</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row g-3">
                                            <div class="col-12 col-sm-6">
                                                <label class="form-label fw-bold text-dark">Teks Tombol Utama</label>
                                                <input type="text" name="primary_button_text" class="form-control shadow-sm"
                                                       value="{{ old('primary_button_text', 'Pelajari Program Kami') }}">
                                            </div>
                                            <div class="col-12 col-sm-6">
                                                <label class="form-label fw-bold text-dark">Link Tombol Utama</label>
                                                <input type="url" name="primary_button_url" class="form-control shadow-sm"
                                                       value="{{ old('primary_button_url') }}" placeholder="https://...">
                                            </div>
                                            <div class="col-12 col-sm-6">
                                                <label class="form-label fw-bold text-dark">Teks Tombol Kedua <span class="text-muted fw-normal">(opsional)</span></label>
                                                <input type="text" name="secondary_button_text" class="form-control shadow-sm"
                                                       value="{{ old('secondary_button_text', 'Lihat Laboratorium') }}">
                                            </div>
                                            <div class="col-12 col-sm-6">
                                                <label class="form-label fw-bold text-dark">Link Tombol Kedua <span class="text-muted fw-normal">(opsional)</span></label>
                                                <input type="url" name="secondary_button_url" class="form-control shadow-sm"
                                                       value="{{ old('secondary_button_url') }}" placeholder="https://...">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- KOLOM KANAN -->
                            <div class="col-12 col-md-4">
                                <div class="card shadow-sm border-0 sticky-top" style="top: 80px;">
                                    <div class="card-header bg-success py-3">
                                        <h6 class="m-0 font-weight-bold text-white"><i class="fas fa-cog me-2"></i>Pengaturan</h6>
                                    </div>
                                    <div class="card-body p-3 p-md-4">
                                <div class="mb-4">
                                    <label class="form-label fw-bold text-dark mb-3">Pengaturan Publikasi</label>
                                    <div class="p-3 rounded-3 border d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-2 mb-2">
                                        <div>
                                            <p class="mb-0 fw-bold small">Terbitkan Sekarang</p>
                                            <small class="text-muted" style="font-size: 0.7rem;">Banner langsung tampil di halaman publik</small>
                                        </div>
                                        <div class="form-check form-switch mb-0">
                                            <input class="form-check-input" type="checkbox" name="active" value="1" id="active" checked
                                                style="width: 2.5em; height: 1.25em; cursor: pointer;">
                                        </div>
                                    </div>
                                    <div class="alert alert-info border-0 mb-0 py-2 px-3 mt-2" style="font-size: 0.75rem; border-radius: 8px;">
                                        <i class="fas fa-info-circle me-1"></i> Aktifkan agar Banner ini langsung tampil di halaman publik.
                                    </div>
                                </div>
                                        <hr class="my-4">
                                        <div class="d-flex flex-column flex-sm-row gap-2">
                                            <button type="submit" class="btn btn-success px-4 py-2 shadow fw-bold w-100 w-sm-auto">
                                                <i class="fas fa-save me-2"></i> Simpan Banner
                                            </button>
                                            <a href="{{ route('heroes.index') }}" class="btn btn-outline-secondary px-4 py-2 border-2 text-center w-100 w-sm-auto">Batal</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function extractYouTubeId(url) {
        const match = url.match(/(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/)([^&\n?#]+)/);
        return match ? match[1] : null;
    }

    document.getElementById('videoUrl').addEventListener('input', function () {
        const id = extractYouTubeId(this.value.trim());
        const preview = document.getElementById('videoPreview');
        const frame   = document.getElementById('previewFrame');
        if (id) {
            frame.src = `https://www.youtube.com/embed/${id}`;
            preview.classList.remove('d-none');
        } else {
            preview.classList.add('d-none');
            frame.src = '';
        }
    });

    @if($errors->any())
        Swal.fire({
            icon: 'error',
            title: 'Gagal Menyimpan',
            html: '<ul style="text-align: left;">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>',
            confirmButtonColor: '#dc3545'
        });
    @endif
</script>
<style>
    .sticky-top { top: 80px; }
    .form-control:focus, .form-select:focus { box-shadow: none; border-color: #198754; }
    @media (max-width: 576px) {
        .sticky-top { position: relative; top: 0; }
    }
</style>
@endpush
@endsection
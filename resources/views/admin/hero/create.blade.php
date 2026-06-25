@extends('layouts.admin')

@section('title', 'Tambah Hero Banner')

@section('content')
<div class="container-fluid px-3 px-md-4 pb-5">
    <!-- Header -->
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mt-4 mb-4">
        <div>
            <h1 class="h3 text-gray-800 mb-1">Tambah Hero Banner</h1>
            <p class="text-muted small mb-0">Atur konten visual dan teks untuk daya tarik utama beranda.</p>
        </div>
        <a href="{{ route('heroes.index') }}" class="btn btn-light border px-3 fw-bold small text-muted shadow-sm">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <form action="{{ route('heroes.store') }}" method="POST">
        @csrf
        <div class="row g-4">
            <!-- KOLOM KIRI: DATA UTAMA -->
            <div class="col-12 col-lg-8">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header py-3 bg-success text-white">
                        <h6 class="m-0 font-weight-bold"><i class="fas fa-plus-circle me-2"></i>Konten Banner</h6>
                    </div>
                    <div class="card-body p-3 p-md-4">
                        <div class="mb-4">
                            <label class="form-label fw-bold text-dark">Slogan Utama (Headline) <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control form-control-custom @error('title') is-invalid @enderror"
                                   value="{{ old('title') }}" placeholder="Masukkan slogan yang inspiratif..." required>
                            @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold text-dark">Sub Slogan (Deskripsi) <span class="text-danger">*</span></label>
                            <textarea name="subtitle" rows="4" class="form-control form-control-custom @error('subtitle') is-invalid @enderror"
                                      placeholder="Berikan penjelasan singkat mengenai visi atau program studi..." required>{{ old('subtitle') }}</textarea>
                            @error('subtitle') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="settings-block bg-light border-0 shadow-none">
                            <div class="settings-block-title text-dark">
                                <i class="fas fa-mouse-pointer me-2 text-success"></i>Tombol Aksi (Call to Action)
                            </div>
                            <div class="row g-3">
                                <div class="col-12 col-md-6">
                                    <label class="field-label">Teks Tombol Utama</label>
                                    <input type="text" name="primary_button_text" class="form-control form-control-custom" value="{{ old('primary_button_text', 'Pelajari Selengkapnya') }}">
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="field-label">Link Tombol Utama</label>
                                    <input type="url" name="primary_button_url" class="form-control form-control-custom" placeholder="https://...">
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="field-label">Teks Tombol Kedua (Opsional)</label>
                                    <input type="text" name="secondary_button_text" class="form-control form-control-custom" value="{{ old('secondary_button_text') }}">
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="field-label">Link Tombol Kedua</label>
                                    <input type="url" name="secondary_button_url" class="form-control form-control-custom" placeholder="https://...">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- KOLOM KANAN -->
            <div class="col-12 col-lg-4">
                <div class="card shadow-sm border-0 sticky-top" style="top: 80px;">
                    <div class="card-header bg-success py-3">
                        <h6 class="m-0 font-weight-bold text-white"><i class="fas fa-cog me-2"></i>Media & Publikasi</h6>
                    </div>
                    <div class="card-body p-3 p-md-4">
                        <!-- Video Media -->
                        <div class="mb-4">
                            <label class="form-label fw-bold text-dark"><i class="fab fa-youtube me-1 text-danger"></i> Background Video</label>
                            <div class="input-group mb-2">
                                <span class="input-group-text bg-light border-end-0"><i class="fas fa-link small text-muted"></i></span>
                                <input type="url" name="video_url" id="videoUrl" class="form-control form-control-custom border-start-0 ps-0" 
                                       placeholder="URL Video YouTube" value="{{ old('video_url') }}">
                            </div>
                            
                            <div id="videoPreview" class="d-none">
                                <div class="ratio ratio-16x9 rounded shadow-sm overflow-hidden border">
                                    <iframe id="previewFrame" src="" allowfullscreen></iframe>
                                </div>
                                <small class="text-success fw-bold d-block mt-2" style="font-size:0.72rem;"><i class="fas fa-check-circle me-1"></i>Video terdeteksi</small>
                            </div>

                            <div id="uploadPlaceholder" class="upload-area">
                                <i class="fab fa-youtube upload-icon text-danger"></i>
                                <span class="upload-text">Tempel link YouTube</span>
                                <span class="upload-hint">Video akan diputar otomatis & tanpa suara</span>
                            </div>
                        </div>

                        <!-- Publikasi -->
                        <div class="mb-4">
                            <label class="form-label fw-bold text-dark">Publikasi</label>
                            <div class="publish-toggle">
                                <div>
                                    <p class="mb-0 fw-bold small">Terbitkan Sekarang</p>
                                    <small class="text-muted" style="font-size:0.7rem;">Tampilkan di halaman depan</small>
                                </div>
                                <div class="form-check form-switch mb-0">
                                    <input class="form-check-input" type="checkbox" name="active" value="1" id="active" checked style="width:2.5em;height:1.25em;cursor:pointer;">
                                </div>
                            </div>
                        </div>

                        <hr class="my-3">
                        <div class="d-flex flex-column gap-2">
                            <button type="submit" class="btn-submit-main">
                                <i class="fas fa-paper-plane me-2"></i> Terbitkan Banner
                            </button>
                            <a href="{{ route('heroes.index') }}" class="btn btn-outline-secondary py-2 text-center">Batal</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

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
        const frame = document.getElementById('previewFrame');
        const placeholder = document.getElementById('uploadPlaceholder');

        if (id) {
            frame.src = `https://www.youtube.com/embed/${id}`;
            preview.classList.remove('d-none');
            placeholder.classList.add('d-none');
        } else {
            preview.classList.add('d-none');
            placeholder.classList.remove('d-none');
            frame.src = '';
        }
    });

    @if($errors->any())
        Swal.fire({
            icon: 'error', title: 'Gagal Menyimpan',
            html: '<ul style="text-align:left;">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>',
            confirmButtonColor: '#dc3545'
        });
    @endif
</script>

<style>
    /* Menggunakan Style yang sama dengan Information */
    .form-control-custom {
        border: 1.5px solid #dee2e6; border-radius: 8px; font-size: 0.875rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05), inset 0 1px 2px rgba(255,255,255,0.9);
        transition: border-color 0.15s, box-shadow 0.15s;
    }
    .form-control-custom:focus { border-color: #198754; box-shadow: 0 0 0 3px rgba(25,135,84,0.12); outline: none; }
    
    .upload-area {
        display: flex; flex-direction: column; align-items: center; justify-content: center;
        gap: 4px; padding: 30px 20px; border: 2px dashed #dee2e6; border-radius: 10px;
        background: #f8f9fa; text-align: center;
    }
    .upload-icon { font-size: 2rem; margin-bottom: 5px; }
    .upload-text { font-size: 0.85rem; font-weight: 600; color: #444; }
    .upload-hint { font-size: 0.72rem; color: #888; }

    .settings-block {
        border-radius: 10px; padding: 16px;
        border: 1.5px solid #e0e0e0; background: #fff;
    }
    .settings-block-title { font-size: 0.85rem; font-weight: 700; margin-bottom: 14px; }
    .field-label { display: block; font-size: 0.78rem; font-weight: 600; color: #555; margin-bottom: 5px; }

    .publish-toggle {
        display: flex; align-items: center; justify-content: space-between;
        padding: 12px 14px; background: #f8f9fa; border: 1.5px solid #dee2e6; border-radius: 10px;
    }

    .btn-submit-main {
        width: 100%; padding: 11px; border-radius: 9px; border: none;
        background: linear-gradient(135deg, #198754, #20c997); color: #fff;
        font-size: 0.9rem; font-weight: 700; cursor: pointer;
        box-shadow: 0 3px 8px rgba(25,135,84,0.3); transition: all 0.2s;
    }
    .btn-submit-main:hover { opacity: 0.93; transform: translateY(-1px); }

    .sticky-top { top: 80px; }
    @media (max-width: 991px) { .sticky-top { position: relative; top: 0; } }
</style>
@endpush
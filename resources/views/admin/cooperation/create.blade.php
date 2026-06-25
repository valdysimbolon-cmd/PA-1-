@extends('layouts.admin')

@section('title', 'Tambah Mitra Baru')

@section('content')
<div class="container-fluid px-3 px-md-4 pb-5">
    <!-- Judul + Tombol Kembali -->
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mt-4 mb-4">
        <div>
            <h1 class="h3 text-gray-800 mb-1">Tambah Mitra Kerja Sama</h1>
            <p class="text-muted small mb-0">Tambahkan instansi/perusahaan mitra baru.</p>
        </div>
        <a href="{{ route('cooperations.index') }}" class="btn btn-light border px-3 fw-bold small text-muted shadow-sm">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-12 col-lg-10">
            <div class="card shadow-sm border-0">
                <div class="card-header py-3 bg-success text-white">
                    <h6 class="m-0 font-weight-bold"><i class="fas fa-handshake me-2"></i>Formulir Mitra Baru</h6>
                </div>
                <div class="card-body p-3 p-md-4">
                    <form action="{{ route('cooperations.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row g-4">
                            <!-- KOLOM KIRI -->
                            <div class="col-12 col-md-8">
                                <div class="mb-3">
                                    <label class="form-label fw-bold text-dark">Nama Instansi / Perusahaan <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control form-control-custom @error('name') is-invalid @enderror"
                                           value="{{ old('name') }}" placeholder="Contoh: PT. Pertamina" required>
                                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold text-dark">Tipe Kerjasama <span class="text-danger">*</span></label>
                                    <select name="type" class="form-select form-select-custom @error('type') is-invalid @enderror" required>
                                        <option value="" selected disabled>Pilih Tipe</option>
                                        <option value="Industri" {{ old('type') == 'Industri' ? 'selected' : '' }}>Industri</option>
                                        <option value="Akademik" {{ old('type') == 'Akademik' ? 'selected' : '' }}>Akademik</option>
                                        <option value="Pemerintah" {{ old('type') == 'Pemerintah' ? 'selected' : '' }}>Pemerintah</option>
                                    </select>
                                    @error('type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="row">
                                    <div class="col-12 col-sm-6 mb-3">
                                        <label class="form-label fw-bold text-dark">Tanggal Mulai</label>
                                        <input type="date" name="start_date" value="{{ old('start_date') }}" class="form-control form-control-custom @error('start_date') is-invalid @enderror">
                                        @error('start_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col-12 col-sm-6 mb-3">
                                        <label class="form-label fw-bold text-dark">Tanggal Berakhir</label>
                                        <input type="date" name="end_date" value="{{ old('end_date') }}" class="form-control form-control-custom @error('end_date') is-invalid @enderror">
                                        @error('end_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        <div class="form-text">Kosongkan jika berlaku selamanya.</div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold text-dark">Deskripsi Kerjasama</label>
                                    <textarea name="description" class="form-control form-control-custom @error('description') is-invalid @enderror" rows="3">{{ old('description') }}</textarea>
                                    @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold text-success"><i class="fas fa-image me-1"></i> Logo Mitra</label>
                                    <div id="previewContainer" class="d-none mb-2">
                                        <div class="img-preview-wrap">
                                            <img id="imagePreview" src="#" class="img-preview">
                                            <button type="button" id="removeImage" class="img-preview-remove"><i class="fas fa-times"></i></button>
                                        </div>
                                    </div>
                                    <label for="imageInput" class="upload-area" id="uploadArea">
                                        <i class="fas fa-cloud-upload-alt upload-icon"></i>
                                        <span class="upload-text">Klik untuk upload logo</span>
                                        <span class="upload-hint">JPG, PNG, WEBP · Maks 2MB</span>
                                        <input type="file" name="logo" id="imageInput" accept="image/jpeg,image/png,image/webp" class="d-none">
                                    </label>
                                    @error('logo') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
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
                                            <label class="form-label fw-bold text-dark mb-3">Publikasi</label>
                                            <div class="p-3 rounded-3 border d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-2">
                                                <div>
                                                    <p class="mb-0 fw-bold small">Terbitkan Sekarang</p>
                                                    <small class="text-muted" style="font-size: 0.7rem;">Mitra langsung tampil di halaman publik</small>
                                                </div>
                                                <div class="form-check form-switch mb-0">
                                                    <input class="form-check-input" type="checkbox" name="active" value="1" id="active" checked
                                                        style="width: 2.5em; height: 1.25em; cursor: pointer;">
                                                </div>
                                            </div>
                                            <div class="alert alert-info border-0 mb-0 py-2 px-3 mt-2" style="font-size: 0.75rem; border-radius: 8px;">
                                                <i class="fas fa-info-circle me-1"></i> Aktifkan agar langsung tampil di halaman publik.
                                            </div>
                                        </div>
                                        <hr class="my-4">
                                        <div class="d-flex flex-column flex-sm-row gap-2">
                                            <button type="submit" class="btn btn-success px-4 py-2 shadow fw-bold w-100 w-sm-auto">
                                                <i class="fas fa-save me-2"></i> Simpan Mitra
                                            </button>
                                            <a href="{{ route('cooperations.index') }}" class="btn btn-outline-secondary px-4 py-2 border-2 text-center w-100 w-sm-auto">Batal</a>
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

<style>
    .sticky-top { top: 80px; }

    /* ================================================================
       FORM CONTROL - SAMA DENGAN MODUL INFORMASI
       ================================================================ */
    .form-control-custom, .form-select-custom {
        border: 1.5px solid #dee2e6;
        border-radius: 8px;
        font-size: 0.875rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05), inset 0 1px 2px rgba(255,255,255,0.9);
        transition: border-color 0.15s, box-shadow 0.15s;
    }
    .form-control-custom:focus, .form-select-custom:focus {
        border-color: #198754;
        box-shadow: 0 0 0 3px rgba(25,135,84,0.12);
        outline: none;
    }

    /* ================================================================
       UPLOAD AREA - SAMA DENGAN MODUL INFORMASI
       ================================================================ */
    .upload-area {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 4px;
        padding: 20px;
        border: 2px dashed #c3e6cb;
        border-radius: 10px;
        background: #f8fff9;
        cursor: pointer;
        transition: all 0.2s;
        text-align: center;
    }
    .upload-area:hover { border-color: #198754; background: #f0faf4; }
    .upload-icon { font-size: 1.6rem; color: #198754; }
    .upload-text { font-size: 0.85rem; font-weight: 600; color: #198754; }
    .upload-hint { font-size: 0.72rem; color: #aaa; }

    .img-preview-wrap {
        position: relative;
        display: inline-block;
        width: 100%;
    }
    .img-preview {
        width: 100%;
        max-height: 140px;
        object-fit: cover;
        border-radius: 8px;
        border: 1.5px solid #c3e6cb;
        box-shadow: 0 2px 6px rgba(0,0,0,0.08);
    }
    .img-preview-remove {
        position: absolute;
        top: 6px; right: 6px;
        width: 24px; height: 24px;
        border-radius: 50%;
        background: rgba(220,53,69,0.85);
        border: none;
        color: #fff;
        font-size: 0.65rem;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    @media (max-width: 576px) {
        .sticky-top { position: relative; top: 0; }
    }
</style>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const imageInput = document.getElementById('imageInput');
    const imagePreview = document.getElementById('imagePreview');
    const previewContainer = document.getElementById('previewContainer');
    const uploadArea = document.getElementById('uploadArea');
    const removeImage = document.getElementById('removeImage');

    imageInput.addEventListener('change', function (e) {
        const file = e.target.files[0];
        if (!file) return;
        if (!['image/jpeg','image/png','image/webp'].includes(file.type)) {
            Swal.fire({ icon: 'error', title: 'Format Tidak Didukung', text: 'Gunakan JPG, PNG, atau WEBP.', confirmButtonColor: '#198754' });
            this.value = ''; return;
        }
        if (file.size > 2 * 1024 * 1024) {
            Swal.fire({ icon: 'error', title: 'File Terlalu Besar', text: 'Ukuran maksimal 2MB.', confirmButtonColor: '#198754' });
            this.value = ''; return;
        }
        const reader = new FileReader();
        reader.onload = ev => {
            imagePreview.src = ev.target.result;
            previewContainer.classList.remove('d-none');
            uploadArea.style.display = 'none';
        };
        reader.readAsDataURL(file);
    });

    removeImage && removeImage.addEventListener('click', function () {
        imageInput.value = '';
        imagePreview.src = '#';
        previewContainer.classList.add('d-none');
        uploadArea.style.display = '';
    });
</script>
@endpush
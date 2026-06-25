@extends('layouts.admin')

@section('title', 'Edit Testimoni')

@section('content')
<div class="container-fluid px-3 px-md-4 pb-5">
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mt-4 mb-4">
        <div>
            <h1 class="h3 text-gray-800 mb-1">Edit Testimoni</h1>
            <p class="text-muted small mb-0">Perbarui informasi testimoni dari <strong>{{ $testimonial->name }}</strong>.</p>
        </div>
        <a href="{{ route('testimonials.index') }}" class="btn btn-light border px-3 fw-bold small text-muted shadow-sm">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-12 col-lg-10">
            <div class="card shadow-sm border-0">
                <div class="card-header py-3 bg-success text-white">
                    <h6 class="m-0 font-weight-bold"><i class="fas fa-edit me-2"></i>Edit Detail Testimoni</h6>
                </div>
                <div class="card-body p-3 p-md-4">
                    <form action="{{ route('testimonials.update', $testimonial->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf @method('PUT')
                        <div class="row g-4">

                            <!-- Nama -->
                            <div class="col-12 col-md-6">
                                <label class="field-label">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" name="name"
                                    class="form-control form-control-custom"
                                    value="{{ old('name', $testimonial->name) }}" required>
                            </div>

                            <!-- Angkatan -->
                            <div class="col-6 col-md-3">
                                <label class="field-label">Angkatan <span class="text-danger">*</span></label>
                                <input type="number" name="batch"
                                    class="form-control form-control-custom"
                                    value="{{ old('batch', $testimonial->batch) }}" required>
                            </div>

                            <!-- Posisi -->
                            <div class="col-6 col-md-3">
                                <label class="field-label">Pekerjaan / Posisi</label>
                                <input type="text" name="position"
                                    class="form-control form-control-custom"
                                    value="{{ old('position', $testimonial->position) }}"
                                    placeholder="Contoh: Software Engineer">
                            </div>

                            <!-- Isi Testimoni -->
                            <div class="col-12">
                                <label class="field-label">Isi Testimoni <span class="text-danger">*</span></label>
                                <textarea name="content" rows="5"
                                    class="form-control form-control-custom" required>{{ old('content', $testimonial->content) }}</textarea>
                            </div>

                            <!-- Foto -->
                            <div class="col-12 col-md-7">
                                <label class="field-label"><i class="fas fa-image me-1 text-success"></i> Foto Profil</label>

                                @if($testimonial->photo)
                                    <div class="current-photo-wrap mb-3" id="currentPhotoWrap">
                                        <img src="{{ asset('storage/'.$testimonial->photo) }}" class="current-photo-img">
                                        <span class="current-photo-label">Foto saat ini</span>
                                    </div>
                                @endif

                                <div id="previewContainer" class="d-none mb-3">
                                    <div class="photo-preview-wrap">
                                        <img id="imagePreview" src="#" class="photo-preview-img">
                                        <button type="button" id="removeImage" class="photo-preview-remove">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                    <small class="text-success fw-bold d-block mt-1" style="font-size:0.72rem;">
                                        <i class="fas fa-check-circle me-1"></i>Foto baru dipilih
                                    </small>
                                </div>

                                <label for="imageInput" class="upload-area" id="uploadArea">
                                    <i class="fas fa-cloud-upload-alt upload-icon"></i>
                                    <span class="upload-text">{{ $testimonial->photo ? 'Ganti foto profil' : 'Upload foto profil' }}</span>
                                    <span class="upload-hint">JPG, PNG, WEBP · Maks 2MB · Kosongkan jika tidak ingin ganti</span>
                                    <input type="file" name="photo" id="imageInput" accept="image/jpeg,image/png,image/webp" class="d-none">
                                </label>
                            </div>

                            <!-- Publikasi -->
                            <div class="col-12 col-md-5">
                                <label class="field-label">Pengaturan Publikasi</label>
                                <div class="publish-toggle">
                                    <div>
                                        <p class="mb-0 fw-bold small">Terbitkan Sekarang</p>
                                        <small class="text-muted" style="font-size:0.7rem;">Langsung tampil di halaman publik</small>
                                    </div>
                                    <div class="form-check form-switch mb-0">
                                        <input class="form-check-input" type="checkbox" name="active" value="1" id="active"
                                            {{ old('active', $testimonial->active) ? 'checked' : '' }}
                                            style="width:2.5em;height:1.25em;cursor:pointer;">
                                    </div>
                                </div>
                                <div class="alert alert-info border-0 mb-0 py-2 px-3 mt-2" style="font-size:0.75rem;border-radius:8px;">
                                    <i class="fas fa-info-circle me-1"></i> Aktifkan agar testimoni langsung tampil.
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">
                        <div class="d-flex flex-column flex-sm-row gap-2">
                            <button type="submit" class="btn-submit-main">
                                <i class="fas fa-save me-2"></i> Simpan Perubahan
                            </button>
                            <a href="{{ route('testimonials.index') }}" class="btn btn-outline-secondary px-4 py-2 text-center">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card { border-radius: 10px; }

    .field-label { display: block; font-size: 0.82rem; font-weight: 700; color: #444; margin-bottom: 6px; }

    .form-control-custom {
        border: 1.5px solid #dee2e6; border-radius: 8px; font-size: 0.875rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05), inset 0 1px 2px rgba(255,255,255,0.9);
        transition: border-color 0.15s, box-shadow 0.15s;
    }
    .form-control-custom:focus {
        border-color: #198754; box-shadow: 0 0 0 3px rgba(25,135,84,0.12); outline: none;
    }

    /* Current photo */
    .current-photo-wrap { display: flex; align-items: center; gap: 12px; }
    .current-photo-img {
        width: 70px; height: 70px; object-fit: cover;
        border-radius: 50%; border: 3px solid #dee2e6;
        box-shadow: 0 1px 5px rgba(0,0,0,0.1);
    }
    .current-photo-label { font-size: 0.75rem; color: #888; font-weight: 500; }

    /* Upload area */
    .upload-area {
        display: flex; flex-direction: column; align-items: center;
        justify-content: center; gap: 5px; padding: 18px;
        border: 2px dashed #c3e6cb; border-radius: 10px;
        background: #f8fff9; cursor: pointer; transition: all 0.2s; text-align: center;
    }
    .upload-area:hover { border-color: #198754; background: #f0faf4; }
    .upload-icon { font-size: 1.6rem; color: #198754; }
    .upload-text { font-size: 0.85rem; font-weight: 600; color: #198754; }
    .upload-hint { font-size: 0.7rem; color: #aaa; }

    /* Photo preview */
    .photo-preview-wrap { position: relative; display: inline-block; }
    .photo-preview-img {
        width: 90px; height: 90px; object-fit: cover;
        border-radius: 50%; border: 3px solid #c3e6cb;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    .photo-preview-remove {
        position: absolute; top: 2px; right: 2px;
        width: 22px; height: 22px; border-radius: 50%;
        background: rgba(220,53,69,0.85); border: none;
        color: #fff; font-size: 0.6rem; cursor: pointer;
        display: flex; align-items: center; justify-content: center;
    }

    /* Publish toggle */
    .publish-toggle {
        display: flex; align-items: center; justify-content: space-between;
        padding: 12px 14px; background: #f8f9fa;
        border: 1.5px solid #dee2e6; border-radius: 10px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }

    /* Submit */
    .btn-submit-main {
        padding: 10px 28px; border-radius: 9px; border: none;
        background: linear-gradient(135deg, #198754, #20c997);
        color: #fff; font-size: 0.9rem; font-weight: 700; cursor: pointer;
        box-shadow: 0 3px 8px rgba(25,135,84,0.3); transition: opacity 0.2s, transform 0.1s;
    }
    .btn-submit-main:hover { opacity: 0.93; transform: translateY(-1px); }
    .btn-submit-main:disabled { opacity: 0.7; transform: none; cursor: not-allowed; }

    .form-control:focus, .form-select:focus { border-color: #198754; box-shadow: none; }
</style>


@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const imageInput = document.getElementById('imageInput');
    const imagePreview = document.getElementById('imagePreview');
    const previewContainer = document.getElementById('previewContainer');
    const uploadArea = document.getElementById('uploadArea');
    const removeImage = document.getElementById('removeImage');
    const currentPhotoWrap = document.getElementById('currentPhotoWrap');

    imageInput.addEventListener('change', function (e) {
        const file = e.target.files[0];
        if (!file) return;
        if (!['image/jpeg','image/png','image/webp'].includes(file.type) || file.size > 2 * 1024 * 1024) {
            Swal.fire({ icon: 'error', title: 'File Tidak Valid', text: 'Gunakan JPG/PNG/WEBP maks 2MB.', confirmButtonColor: '#198754' });
            this.value = ''; return;
        }
        const reader = new FileReader();
        reader.onload = ev => {
            imagePreview.src = ev.target.result;
            previewContainer.classList.remove('d-none');
            uploadArea.style.display = 'none';
            if (currentPhotoWrap) currentPhotoWrap.style.display = 'none';
        };
        reader.readAsDataURL(file);
    });

    removeImage && removeImage.addEventListener('click', function () {
        imageInput.value = '';
        imagePreview.src = '#';
        previewContainer.classList.add('d-none');
        uploadArea.style.display = '';
        if (currentPhotoWrap) currentPhotoWrap.style.display = '';
    });

    document.querySelector('form').addEventListener('submit', function (e) {
        const btn = this.querySelector('.btn-submit-main');
        if (btn.disabled) { e.preventDefault(); return; }
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Menyimpan...';
    });

    @if($errors->any())
        Swal.fire({
            icon: 'error', title: 'Gagal Menyimpan',
            html: '<ul style="text-align:left;">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>',
            confirmButtonColor: '#dc3545'
        });
    @endif
</script>
@endpush
@endsection
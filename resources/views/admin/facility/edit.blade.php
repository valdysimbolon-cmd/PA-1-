@extends('layouts.admin')

@section('title', 'Edit Fasilitas')

@section('content')
<div class="container-fluid px-3 px-md-4 pb-5">
    <!-- Header -->
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mt-4 mb-4">
        <div>
            <h1 class="h3 text-gray-800 mb-1">Edit Fasilitas</h1>
            <p class="text-muted small mb-0">Perbarui data fasilitas: <strong>{{ $facility->name }}</strong>.</p>
        </div>
        <a href="{{ route('facilities.index') }}" class="btn btn-light border px-3 fw-bold small text-muted shadow-sm">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-12 col-lg-10">
            <div class="card shadow-sm border-0">
                <div class="card-header py-3 bg-success text-white">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-edit me-2"></i>Edit Detail Fasilitas
                    </h6>
                </div>
                <div class="card-body p-3 p-md-4">
                    <form action="{{ route('facilities.update', $facility->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf @method('PUT')

                        <div class="row g-4">
                            <!-- Kolom Kiri: Data Utama -->
                            <div class="col-12 col-md-8">
                                <div class="mb-4">
                                    <label class="form-label fw-bold text-dark">Nama Fasilitas <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control shadow-sm"
                                           value="{{ old('name', $facility->name) }}" required>
                                </div>

                                <div class="row mb-4 g-3">
                                    <div class="col-12 col-sm-6">
                                        <label class="form-label fw-bold text-dark">Jenis / Tipe Fasilitas</label>
                                        <input type="text" name="type" class="form-control shadow-sm"
                                               value="{{ old('type', $facility->type) }}" required>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <label class="form-label fw-bold text-dark">Lokasi</label>
                                        <input type="text" name="location" class="form-control shadow-sm"
                                               value="{{ old('location', $facility->location) }}" required>
                                    </div>
                                </div>

                                <div class="row mb-4 g-3">
                                    <div class="col-12 col-sm-6">
                                        <label class="form-label fw-bold text-dark">Kapasitas (Orang)</label>
                                        <input type="number" name="capacity" class="form-control shadow-sm"
                                               value="{{ old('capacity', $facility->capacity) }}" min="1">
                                    </div>
                                </div>

                                <div class="mb-0">
                                    <label class="form-label fw-bold text-dark">Deskripsi Fasilitas</label>
                                    <textarea name="description" id="editor" class="form-control shadow-sm">{{ old('description', $facility->description) }}</textarea>
                                </div>
                            </div>

                            <!-- Kolom Kanan: Gambar & Status -->
                            <div class="col-12 col-md-4">
                                <div class="mb-4">
                                    <label class="form-label fw-bold text-success">
                                        <i class="fas fa-image me-1"></i> Foto Fasilitas
                                    </label>
                                    <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center gap-3 mb-3 p-3 bg-light rounded border shadow-sm">
                                        @if($facility->image)
                                            <div id="oldImageDiv" class="text-center">
                                                <p class="small fw-bold text-muted mb-1">Gambar Saat Ini</p>
                                                <img src="{{ asset('storage/'.$facility->image) }}" class="rounded shadow-sm border" width="100" height="100" style="object-fit: cover;">
                                            </div>
                                        @endif
                                        <div id="arrowIcon" class="text-muted d-none"><i class="fas fa-arrow-right fa-2x"></i></div>
                                        <div id="previewContainer" class="d-none text-center">
                                            <p class="small fw-bold text-success mb-1">Preview Baru</p>
                                            <img id="imagePreview" src="#" class="rounded shadow-sm border border-success" width="100" height="100" style="object-fit: cover;">
                                        </div>
                                    </div>
                                    <div class="input-group shadow-sm">
                                        <span class="input-group-text bg-light text-success"><i class="fas fa-upload"></i></span>
                                        <input type="file" name="image" id="imageInput" class="form-control" accept="image/jpeg,image/png,image/webp">
                                    </div>
                                    <div class="form-text mt-2">
                                        <i class="fas fa-info-circle me-1"></i> Format JPG, PNG, WEBP (Maks 2MB).
                                    </div>
                                    <small class="text-muted mt-2 d-block">Abaikan jika tidak ingin mengganti gambar.</small>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-bold text-dark mb-3">Pengaturan Publikasi</label>
                                    <div class="p-3 rounded-3 border d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-2 mb-2">
                                        <div>
                                            <p class="mb-0 fw-bold small">Terbitkan Sekarang</p>
                                            <small class="text-muted" style="font-size: 0.7rem;">Fasilitas langsung tampil di halaman publik</small>
                                        </div>
                                        <div class="form-check form-switch mb-0">
                                            <input class="form-check-input" type="checkbox" name="active" value="1" id="active" 
                                                {{ old('active', $facility->active) ? 'checked' : '' }}
                                                style="width: 2.5em; height: 1.25em; cursor: pointer;">
                                        </div>
                                    </div>
                                    <div class="alert alert-info border-0 mb-0 py-2 px-3 mt-2" style="font-size: 0.75rem; border-radius: 8px;">
                                        <i class="fas fa-info-circle me-1"></i> Aktifkan agar Fasilitas ini langsung tampil di halaman publik.
                                    </div>
                                </div>

                                <hr class="my-4">
                                <div class="d-flex flex-column flex-sm-row gap-2">
                                    <button type="submit" class="btn btn-success px-4 py-2 shadow fw-bold w-100 w-sm-auto">
                                        <i class="fas fa-save me-2"></i> Simpan Perubahan
                                    </button>
                                    <a href="{{ route('facilities.index') }}" class="btn btn-outline-secondary px-4 py-2 border-2 text-center w-100 w-sm-auto">Batal</a>
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
<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    CKEDITOR.replace('editor', {
        height: 300,
        toolbar: [
            { name: 'basicstyles', items: ['Bold','Italic','Underline'] },
            { name: 'paragraph', items: ['NumberedList','BulletedList','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'] },
            { name: 'links', items: ['Link','Unlink'] },
            { name: 'tools', items: ['Undo','Redo'] }
        ]
    });

    const imageInput = document.getElementById('imageInput');
    const imagePreview = document.getElementById('imagePreview');
    const previewContainer = document.getElementById('previewContainer');
    const arrowIcon = document.getElementById('arrowIcon');
    const oldImageDiv = document.getElementById('oldImageDiv');

    imageInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const allowed = ['image/jpeg', 'image/png', 'image/webp'];
            const maxSize = 2 * 1024 * 1024;
            if (!allowed.includes(file.type)) {
                Swal.fire({ icon: 'error', title: 'Format Tidak Didukung', text: 'Gunakan JPG, PNG, WEBP.', confirmButtonColor: '#198754' });
                this.value = '';
                previewContainer.classList.add('d-none');
                if(arrowIcon) arrowIcon.classList.add('d-none');
                if(oldImageDiv) oldImageDiv.classList.remove('d-none');
                return;
            }
            if (file.size > maxSize) {
                Swal.fire({ icon: 'error', title: 'File Terlalu Besar', text: 'Maksimal 2MB.', confirmButtonColor: '#198754' });
                this.value = '';
                previewContainer.classList.add('d-none');
                if(arrowIcon) arrowIcon.classList.add('d-none');
                if(oldImageDiv) oldImageDiv.classList.remove('d-none');
                return;
            }
            const reader = new FileReader();
            reader.onload = function(ev) {
                imagePreview.src = ev.target.result;
                previewContainer.classList.remove('d-none');
                if(arrowIcon) arrowIcon.classList.remove('d-none');
                if(oldImageDiv) oldImageDiv.classList.add('d-none');
            };
            reader.readAsDataURL(file);
        } else {
            previewContainer.classList.add('d-none');
            if(arrowIcon) arrowIcon.classList.add('d-none');
            if(oldImageDiv) oldImageDiv.classList.remove('d-none');
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
    .ck-editor__editable { min-height: 250px; }
    .form-control:focus, .form-select:focus { box-shadow: none; border-color: #198754; }
</style>
@endpush
@endsection
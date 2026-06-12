@extends('layouts.admin')

@section('title', 'Edit Testimoni')

@section('content')
<div class="container-fluid px-3 px-md-4 pb-5">
    <!-- Judul Halaman + Tombol Kembali -->
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
                            <div class="col-12 col-md-6">
                                <label class="form-label fw-bold text-dark">Nama Lengkap</label>
                                <input type="text" name="name" class="form-control shadow-sm" value="{{ old('name', $testimonial->name) }}" required>
                            </div>
                            <div class="col-6 col-md-3">
                                <label class="form-label fw-bold text-dark">Angkatan</label>
                                <input type="number" name="batch" class="form-control shadow-sm" value="{{ old('batch', $testimonial->batch) }}" required>
                            </div>
                            <div class="col-6 col-md-3">
                                <label class="form-label fw-bold text-dark">Pekerjaan / Posisi</label>
                                <input type="text" name="position" class="form-control shadow-sm" value="{{ old('position', $testimonial->position) }}">
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold text-dark">Isi Testimoni</label>
                                <textarea name="content" class="form-control shadow-sm" rows="5" required>{{ old('content', $testimonial->content) }}</textarea>
                            </div>

                            <!-- Bagian Foto -->
                            <div class="col-12 col-md-7">
                                <label class="form-label fw-bold text-success"><i class="fas fa-image me-1"></i> Foto Profil</label>
                                <div class="d-flex flex-column flex-sm-row align-items-center gap-3 mb-3 p-3 bg-light rounded border shadow-sm">
                                    @if($testimonial->photo)
                                        <div id="oldPhotoDiv" class="text-center">
                                            <p class="small fw-bold text-muted mb-1">Foto Saat Ini</p>
                                            <img src="{{ asset('storage/'.$testimonial->photo) }}" class="rounded shadow-sm border" width="100" height="100" style="object-fit: cover;">
                                        </div>
                                    @endif
                                    <div id="arrowIcon" class="text-muted d-none"><i class="fas fa-arrow-right fa-2x"></i></div>
                                    <div id="previewContainer" class="d-none text-center">
                                        <p class="small fw-bold text-success mb-1">Preview Baru</p>
                                        <img id="imagePreview" src="#" class="rounded shadow-sm border border-success" width="100" height="100" style="object-fit: cover;">
                                    </div>
                                </div>
                                <input type="file" name="photo" id="imageInput" class="form-control shadow-sm" accept="image/jpeg,image/png,image/webp">
                                <div class="form-text mt-2">
                                    <i class="fas fa-info-circle me-1"></i> Format JPG, JPEG, PNG, WEBP (Maks 2MB).
                                </div>
                                <small class="text-muted mt-2 d-block">Abaikan jika tidak ingin mengganti foto.</small>
                            </div>

                            <div class="col-12 col-md-5">
                                <label class="form-label fw-bold text-dark mb-3">Pengaturan Publikasi</label>
                                <div class="p-3 rounded-3 border d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-2 mb-2">
                                    <div>
                                        <p class="mb-0 fw-bold small">Terbitkan Sekarang</p>
                                        <small class="text-muted" style="font-size: 0.7rem;">Testimoni langsung tampil di halaman publik</small>
                                    </div>
                                    <div class="form-check form-switch mb-0">
                                        <input class="form-check-input" type="checkbox" name="active" value="1" id="active" 
                                            {{ old('active', $testimonial->active) ? 'checked' : '' }}
                                            style="width: 2.5em; height: 1.25em; cursor: pointer;">
                                    </div>
                                </div>
                                <div class="alert alert-info border-0 mb-0 py-2 px-3 mt-2" style="font-size: 0.75rem; border-radius: 8px;">
                                    <i class="fas fa-info-circle me-1"></i> Aktifkan agar Testimoni ini langsung tampil di halaman publik.
                                </div>
                            </div>
                        </div>

                        <hr class="my-5">
                        <div class="d-flex flex-column flex-sm-row gap-2">
                            <button type="submit" class="btn btn-success px-4 py-2 shadow fw-bold w-100 w-sm-auto">
                                <i class="fas fa-paper-plane me-2"></i> Simpan Perubahan
                            </button>
                            <a href="{{ route('testimonials.index') }}" class="btn btn-outline-secondary px-4 py-2 border-2 text-center w-100 w-sm-auto">Batal</a>
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
    const imageInput = document.getElementById('imageInput');
    const imagePreview = document.getElementById('imagePreview');
    const previewContainer = document.getElementById('previewContainer');
    const arrowIcon = document.getElementById('arrowIcon');
    const oldPhotoDiv = document.getElementById('oldPhotoDiv');

    imageInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
            if (!allowedTypes.includes(file.type) || file.size > 2 * 1024 * 1024) {
                Swal.fire({
                    icon: 'error',
                    title: 'File Tidak Valid',
                    text: 'Gunakan JPG/PNG/WEBP maks 2MB.',
                    confirmButtonColor: '#198754'
                });
                this.value = '';
                previewContainer.classList.add('d-none');
                if(arrowIcon) arrowIcon.classList.add('d-none');
                if(oldPhotoDiv) oldPhotoDiv.classList.remove('d-none');
                return;
            }

            const reader = new FileReader();
            reader.onload = function(event) {
                imagePreview.src = event.target.result;
                previewContainer.classList.remove('d-none');
                if(arrowIcon) arrowIcon.classList.remove('d-none');
                if(oldPhotoDiv) oldPhotoDiv.classList.add('d-none');
            };
            reader.readAsDataURL(file);
        } else {
            previewContainer.classList.add('d-none');
            if(arrowIcon) arrowIcon.classList.add('d-none');
            if(oldPhotoDiv) oldPhotoDiv.classList.remove('d-none');
        }
    });
</script>
@endpush
@endsection
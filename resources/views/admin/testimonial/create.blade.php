@extends('layouts.admin')

@section('title', 'Tambah Testimoni Baru')

@section('content')
<div class="container-fluid px-4 pb-5">
    <!-- Judul Halaman + Tombol Kembali -->
    <div class="d-flex justify-content-between align-items-center mt-4 mb-4">
        <div>
            <h1 class="h3 text-gray-800 mb-1">Tambah Testimoni</h1>
            <p class="text-muted small mb-0">Tambahkan cerita atau pengalaman baru dari alumni/mahasiswa.</p>
        </div>
        <a href="{{ route('testimonials.index') }}" class="btn btn-light border px-3 fw-bold small text-muted shadow-sm">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-sm border-0">
                <div class="card-header py-3 bg-success text-white">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-plus-circle me-2"></i>Formulir Testimoni Baru
                    </h6>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('testimonials.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark">Nama Lengkap</label>
                                <input type="text" name="name" class="form-control shadow-sm @error('name') is-invalid @enderror" 
                                       value="{{ old('name') }}" placeholder="Contoh: Valdy Simbolon" required>
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold text-dark">Angkatan</label>
                                <input type="number" name="batch" class="form-control shadow-sm" 
                                       value="{{ old('batch', date('Y')) }}" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold text-dark">Pekerjaan / Posisi</label>
                                <input type="text" name="position" class="form-control shadow-sm @error('position') is-invalid @enderror"
                                        value="{{ old('position') }}" placeholder="Contoh: Software Engineer">
                                @error('position') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold text-dark">Isi Testimoni</label>
                                <textarea name="content" class="form-control shadow-sm @error('content') is-invalid @enderror" 
                                          rows="5" placeholder="Tuliskan pengalaman selama kuliah..." required>{{ old('content') }}</textarea>
                                @error('content') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <!-- Foto Profil dengan Preview + Validasi Client -->
                            <div class="col-md-7">
                                <label class="form-label fw-bold text-dark text-success">
                                    <i class="fas fa-image me-1"></i> Foto Profil
                                </label>
                                <div id="previewContainer" class="d-none mb-3 p-3 bg-light rounded border text-center shadow-sm" style="max-width: 150px;">
                                    <p class="small fw-bold text-success mb-2">Preview</p>
                                    <img id="imagePreview" src="#" class="rounded shadow-sm border border-success" width="100" height="100" style="object-fit: cover;">
                                </div>
                                <div class="input-group shadow-sm">
                                    <span class="input-group-text bg-light text-success"><i class="fas fa-upload"></i></span>
                                    <input type="file" name="photo" id="imageInput" class="form-control" accept="image/jpeg,image/png,image/webp">
                                </div>
                                <div class="form-text mt-2">
                                    <i class="fas fa-info-circle me-1"></i> Format JPG, JPEG, PNG, WEBP (Maks 2MB).
                                </div>
                            </div>

                            <!-- Status Publikasi -->
                                <div class="mb-4">
                                    <label class="form-label fw-bold text-dark mb-3">Pengaturan Publikasi</label>
                                    <div class="p-3 rounded-3 border d-flex align-items-center justify-content-between mb-2">
                                        <div>
                                            <p class="mb-0 fw-bold small">Terbitkan Sekarang</p>
                                            <small class="text-muted" style="font-size: 0.7rem;">Testimoni langsung tampil di halaman publik</small>
                                        </div>
                                        <div class="form-check form-switch mb-0">
                                            <input class="form-check-input" type="checkbox" name="active" value="1" id="active" checked
                                                style="width: 2.5em; height: 1.25em; cursor: pointer;">
                                        </div>
                                    </div>
                                    <div class="alert alert-info border-0 mb-0 py-2 px-3 mt-2" style="font-size: 0.75rem; border-radius: 8px;">
                                        <i class="fas fa-info-circle me-1"></i> Aktifkan agar Testimoni ini langsung tampil di halaman publik.
                                    </div>
                                </div>
                        </div>

                        <hr class="my-5">
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success px-4 py-2 shadow fw-bold">
                                <i class="fas fa-paper-plane me-2"></i> Simpan Testimoni
                            </button>
                            <a href="{{ route('testimonials.index') }}" class="btn btn-outline-secondary px-4 py-2 border-2">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Gunakan struktur ini untuk kedua file Create/Edit --}}
@push('scripts')
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
        }
    });
</script>
@endpush
@endsection
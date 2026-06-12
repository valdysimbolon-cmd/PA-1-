@extends('layouts.admin')

@section('title', 'Edit Profil')

@section('content')
<div class="container-fluid px-3 px-md-4 pb-5">
    <!-- Judul Halaman + Tombol Kembali -->
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mt-4 mb-4">
        <div>
            <h1 class="h3 text-gray-800 mb-1">Edit Profil</h1>
            <p class="text-muted small mb-0">Perbarui konten profil: <strong>{{ $profile->name }}</strong>.</p>
        </div>
        <a href="{{ route('profiles.index') }}" class="btn btn-light border px-3 fw-bold small text-muted shadow-sm">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-12 col-lg-10">
            <div class="card shadow-sm border-0">
                <div class="card-header py-3 bg-success text-white">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-edit me-2"></i>Edit Detail Profil
                    </h6>
                </div>
                <div class="card-body p-3 p-md-4">
                    <form action="{{ route('profiles.update', $profile->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row g-4">
                            <!-- Kode Navigasi (Key) - Readonly -->
                            <div class="col-12">
                                <label class="form-label fw-bold text-dark">Kode Navigasi (Key)</label>
                                <input type="text" class="form-control shadow-sm bg-light" value="{{ $profile->key }}" readonly>
                                <div class="alert alert-secondary mt-2 mb-0 small">
                                    @if(Str::startsWith($profile->key, 'B_'))
                                        <strong>📍 Lokasi:</strong> Beranda (Homepage)
                                    @elseif(Str::startsWith($profile->key, 'P_'))
                                        <strong>📍 Lokasi:</strong> Profil Prodi
                                    @else
                                        <strong>📍 Lokasi:</strong> Tidak diketahui
                                    @endif
                                </div>
                            </div>

                            <!-- Judul Konten -->
                            <div class="col-12">
                                <label class="form-label fw-bold text-dark">Judul Konten</label>
                                <input type="text" name="name" class="form-control shadow-sm @error('name') is-invalid @enderror"
                                       value="{{ old('name', $profile->name) }}" required>
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <!-- Isi Konten (CKEditor) -->
                            <div class="col-12">
                                <label class="form-label fw-bold text-dark">Isi Konten</label>
                                <textarea name="description" id="editor" class="form-control shadow-sm"
                                          rows="10">{{ old('description', $profile->description) }}</textarea>
                            </div>

                            <!-- Bagian Gambar (Responsif) -->
                            <div class="col-12 col-md-7">
                                <label class="form-label fw-bold text-success">
                                    <i class="fas fa-image me-1"></i> Gambar
                                </label>
                                <div class="d-flex flex-column flex-sm-row align-items-center gap-3 mb-3 p-3 bg-light rounded border shadow-sm">
                                    @if($profile->image)
                                        <div id="oldImageDiv" class="text-center">
                                            <p class="small fw-bold text-muted mb-1">Gambar Saat Ini</p>
                                            <img src="{{ asset('storage/'.$profile->image) }}" class="rounded shadow-sm border" width="100" height="100" style="object-fit: cover;">
                                        </div>
                                    @endif
                                    <div id="arrowIcon" class="text-muted d-none">
                                        <i class="fas fa-arrow-right fa-2x"></i>
                                    </div>
                                    <div id="previewContainer" class="d-none text-center">
                                        <p class="small fw-bold text-success mb-1">Preview Baru</p>
                                        <img id="imagePreview" src="#" class="rounded shadow-sm border border-success" width="100" height="100" style="object-fit: cover;">
                                    </div>
                                </div>

                                <input type="file" name="image" id="imageInput" class="form-control shadow-sm" accept="image/jpeg,image/png,image/webp">
                                <div class="form-text mt-2">
                                    <i class="fas fa-info-circle me-1"></i> Format JPG, JPEG, PNG, WEBP (Maks 2MB). Ukuran ideal 800x600px.
                                </div>
                                <small class="text-muted mt-2 d-block">Abaikan jika tidak ingin mengganti gambar.</small>
                            </div>

                            <!-- Status Publikasi (Switch) -->
                            <div class="col-12 col-md-5">
                                <label class="form-label fw-bold text-dark mb-3">Pengaturan Publikasi</label>
                                <div class="p-3 rounded-3 border d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-2 mb-2">
                                    <div>
                                        <p class="mb-0 fw-bold small">Terbitkan Sekarang</p>
                                        <small class="text-muted" style="font-size: 0.7rem;">Profil langsung tampil di halaman publik</small>
                                    </div>
                                    <div class="form-check form-switch mb-0">
                                        <input class="form-check-input" type="checkbox" name="active" value="1" id="active" 
                                            {{ old('active', $profile->active) ? 'checked' : '' }}
                                            style="width: 2.5em; height: 1.25em; cursor: pointer;">
                                    </div>
                                </div>
                                <div class="alert alert-info border-0 mb-0 py-2 px-3 mt-2" style="font-size: 0.75rem; border-radius: 8px;">
                                    <i class="fas fa-info-circle me-1"></i> Aktifkan agar Profil ini langsung tampil di halaman publik.
                                </div>
                                <hr class="my-3">
                                <p class="text-muted small mb-0">
                                    <i class="fas fa-info-circle me-1"></i> Data yang aktif akan muncul di halaman depan website.
                                </p>
                            </div>
                        </div>

                        <hr class="my-5">
                        <div class="d-flex flex-column flex-sm-row gap-2">
                            <button type="submit" class="btn btn-success px-4 py-2 shadow fw-bold w-100 w-sm-auto">
                                <i class="fas fa-paper-plane me-2"></i> Simpan Perubahan
                            </button>
                            <a href="{{ route('profiles.index') }}" class="btn btn-outline-secondary px-4 py-2 border-2 text-center w-100 w-sm-auto">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.ckeditor.com/4.22.1/full/ckeditor.js"></script>
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
                if(oldImageDiv) oldImageDiv.classList.remove('d-none');
                return;
            }

            const reader = new FileReader();
            reader.onload = function(event) {
                imagePreview.src = event.target.result;
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
</script>
@endpush
@endsection
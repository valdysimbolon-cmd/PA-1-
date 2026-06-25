@extends('layouts.admin')

@section('title', 'Tambah Profil')

@section('content')
<div class="container-fluid px-3 px-md-4 pb-5">
    <!-- Judul Halaman + Tombol Kembali -->
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mt-4 mb-4">
        <div>
            <h1 class="h3 text-gray-800 mb-1">Tambah Profil</h1>
            <p class="text-muted small mb-0">Tambahkan konten baru untuk beranda atau profil prodi.</p>
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
                        <i class="fas fa-plus-circle me-2"></i>Formulir Profil Baru
                    </h6>
                </div>
                <div class="card-body p-3 p-md-4">
                    <form action="{{ route('profiles.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row g-4">
                            <!-- Kode Navigasi (Key) -->
                            <div class="col-12">
                                <label class="form-label fw-bold text-dark">Kode Navigasi (Key)</label>
                                <input type="text" name="key" class="form-control shadow-sm @error('key') is-invalid @enderror"
                                       value="{{ old('key') }}" placeholder="Contoh: B_SEJARAH, P_VISI_MISI" required>
                                @error('key') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                <div class="form-text mt-1">
                                    <i class="fas fa-info-circle me-1"></i> Gunakan huruf besar dan underscore. Key harus unik.
                                </div>

                                <!-- Panduan Penempatan -->
                                <div class="alert alert-info mt-2 mb-0 small">
                                    <strong>📌 Penempatan Konten:</strong><br><br>
                                    <span class="badge bg-warning text-dark">B_</span> → Tampil di <b>Beranda (Homepage)</b>
                                    <br><small class="text-muted">Contoh: B_SEJARAH, B_HOME_INFO</small>
                                    <hr class="my-2">
                                    <span class="badge bg-info text-dark">P_</span> → Tampil di <b>Profil Prodi</b>
                                    <br><small class="text-muted">Contoh: P_VISI_MISI, P_TUJUAN</small>
                                </div>
                            </div>

                            <!-- Judul Konten -->
                            <div class="col-12">
                                <label class="form-label fw-bold text-dark">Judul Konten</label>
                                <input type="text" name="name" class="form-control shadow-sm @error('name') is-invalid @enderror"
                                       value="{{ old('name') }}" required>
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <!-- Isi Konten (CKEditor) -->
                            <div class="col-12">
                                <label class="form-label fw-bold text-dark">
                                    Isi Konten <span class="text-danger">*</span>
                                </label>

                                <textarea
                                    name="description"
                                    id="editor"
                                    class="form-control shadow-sm @error('description') is-invalid @enderror"
                                    rows="10"
                                    required
                                >{{ old('description') }}</textarea>

                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Upload Gambar + Preview (Responsif) -->
                            <div class="col-12 col-md-7">
                                <label class="form-label fw-bold text-success">
                                    <i class="fas fa-image me-1"></i> Gambar (Opsional)
                                </label>
                                <div id="previewContainer" class="d-none mb-3 p-3 bg-light rounded border text-center shadow-sm" style="max-width: 150px;">
                                    <p class="small fw-bold text-success mb-2">Preview</p>
                                    <img id="imagePreview" src="#" class="rounded shadow-sm border border-success" width="100" height="100" style="object-fit: cover;">
                                </div>
                                <div class="input-group shadow-sm">
                                    <span class="input-group-text bg-light text-success"><i class="fas fa-upload"></i></span>
                                    <input type="file" name="image" id="imageInput" class="form-control" accept="image/jpeg,image/png,image/webp">
                                </div>
                                <div class="form-text mt-2">
                                    <i class="fas fa-info-circle me-1"></i> Format JPG, JPEG, PNG, WEBP (Maks 2MB). Ukuran ideal 800x600px.
                                </div>
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
                                        <input class="form-check-input" type="checkbox" name="active" value="1" id="active" checked
                                            style="width: 2.5em; height: 1.25em; cursor: pointer;">
                                    </div>
                                </div>
                                <div class="alert alert-info border-0 mb-0 py-2 px-3 mt-2" style="font-size: 0.75rem; border-radius: 8px;">
                                    <i class="fas fa-info-circle me-1"></i> Aktifkan agar Profil ini langsung tampil di halaman publik.
                                </div>
                            </div>
                        </div>

                        <hr class="my-5">
                        <div class="d-flex flex-column flex-sm-row gap-2">
                            <button type="submit" class="btn btn-success px-4 py-2 shadow fw-bold w-100 w-sm-auto">
                                <i class="fas fa-paper-plane me-2"></i> Simpan profil
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
                return;
            }

            const reader = new FileReader();
            reader.onload = function(event) {
                imagePreview.src = event.target.result;
                previewContainer.classList.remove('d-none');
            };
            reader.readAsDataURL(file);
        } else {
            previewContainer.classList.add('d-none');
        }
    });
</script>
@endpush
@endsection
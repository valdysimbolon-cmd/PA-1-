@extends('layouts.admin')

@section('title', 'Tambah Profil')

@section('content')
<div class="container-fluid px-3 px-md-4 pb-5">
    <!-- Header -->
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mt-4 mb-4">
        <div>
            <h1 class="h3 text-gray-800 mb-1">Tambah Profil</h1>
            <p class="text-muted small mb-0">Tambahkan konten baru untuk beranda atau profil prodi.</p>
        </div>
        <a href="{{ route('profiles.index') }}" class="btn btn-light border px-3 fw-bold small text-muted shadow-sm">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <form action="{{ route('profiles.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row g-4">
            <!-- KOLOM KIRI: DATA UTAMA -->
            <div class="col-12 col-lg-8">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header py-3 bg-success text-white">
                        <h6 class="m-0 font-weight-bold"><i class="fas fa-plus-circle me-2"></i>Konten Profil</h6>
                    </div>
                    <div class="card-body p-3 p-md-4">
                        <!-- Key -->
                        <div class="mb-4">
                            <label class="form-label fw-bold text-dark">Kode Navigasi (Key) <span class="text-danger">*</span></label>
                            <input type="text" name="key" class="form-control form-control-custom @error('key') is-invalid @enderror"
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

                        <!-- Judul -->
                        <div class="mb-4">
                            <label class="form-label fw-bold text-dark">Judul Konten <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control form-control-custom @error('name') is-invalid @enderror"
                                   value="{{ old('name') }}" placeholder="Masukkan judul profil..." required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <!-- Isi Konten (CKEditor) -->
                        <div class="mb-4">
                            <label class="form-label fw-bold text-dark">Isi Konten <span class="text-danger">*</span></label>
                            <textarea name="description" id="editor" class="form-control form-control-custom @error('description') is-invalid @enderror"
                                      rows="10" required>{{ old('description') }}</textarea>
                            @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- KOLOM KANAN: GAMBAR & PUBLIKASI -->
            <div class="col-12 col-lg-4">
                <div class="card shadow-sm border-0 sticky-top" style="top: 80px;">
                    <div class="card-header bg-success py-3">
                        <h6 class="m-0 font-weight-bold text-white"><i class="fas fa-cog me-2"></i>Gambar & Publikasi</h6>
                    </div>
                    <div class="card-body p-3 p-md-4">
                        <!-- Upload Gambar -->
                        <div class="mb-4">
                            <label class="form-label fw-bold text-dark"><i class="fas fa-image me-1 text-success"></i> Gambar (Opsional)</label>
                            <div id="previewContainer" class="d-none mb-3">
                                <div class="rounded shadow-sm overflow-hidden border" style="max-width: 150px;">
                                    <img id="imagePreview" src="#" class="img-fluid" style="object-fit: cover; width:100%; height:100px;">
                                </div>
                                <small class="text-success fw-bold d-block mt-2" style="font-size:0.72rem;"><i class="fas fa-check-circle me-1"></i> Gambar siap</small>
                            </div>

                            <div id="uploadPlaceholder" class="upload-area">
                                <i class="fas fa-cloud-upload-alt upload-icon text-success"></i>
                                <span class="upload-text">Pilih gambar</span>
                                <span class="upload-hint">JPG, JPEG, PNG, WEBP (maks 2MB)</span>
                                <input type="file" name="image" id="imageInput" class="upload-input" accept="image/jpeg,image/png,image/webp">
                            </div>
                            <div class="form-text mt-2">
                                <i class="fas fa-info-circle me-1"></i> Ukuran ideal 800x600px.
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
                                <i class="fas fa-paper-plane me-2"></i> Terbitkan Profil
                            </button>
                            <a href="{{ route('profiles.index') }}" class="btn btn-outline-secondary py-2 text-center" style="border-radius: 9px; font-size: 0.9rem; font-weight: 600;">Batal</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

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
    const uploadPlaceholder = document.getElementById('uploadPlaceholder');

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
                uploadPlaceholder.classList.remove('d-none');
                return;
            }

            const reader = new FileReader();
            reader.onload = function(event) {
                imagePreview.src = event.target.result;
                previewContainer.classList.remove('d-none');
                uploadPlaceholder.classList.add('d-none');
            };
            reader.readAsDataURL(file);
        } else {
            previewContainer.classList.add('d-none');
            uploadPlaceholder.classList.remove('d-none');
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
    /* Gaya seragam dengan Hero Banner */
    .form-control-custom {
        border: 1.5px solid #dee2e6; border-radius: 8px; font-size: 0.875rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05), inset 0 1px 2px rgba(255,255,255,0.9);
        transition: border-color 0.15s, box-shadow 0.15s;
    }
    .form-control-custom:focus { border-color: #198754; box-shadow: 0 0 0 3px rgba(25,135,84,0.12); outline: none; }

    .upload-area {
        position: relative;
        display: flex; flex-direction: column; align-items: center; justify-content: center;
        gap: 4px; padding: 30px 20px; border: 2px dashed #dee2e6; border-radius: 10px;
        background: #f8f9fa; text-align: center; cursor: pointer;
        transition: background 0.2s;
    }
    .upload-area:hover { background: #f1f3f5; }
    .upload-icon { font-size: 2rem; margin-bottom: 5px; }
    .upload-text { font-size: 0.85rem; font-weight: 600; color: #444; }
    .upload-hint { font-size: 0.72rem; color: #888; }
    .upload-input {
        position: absolute; top: 0; left: 0; width: 100%; height: 100%;
        opacity: 0; cursor: pointer;
    }

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

    /* tambahan untuk preview gambar */
    #previewContainer img {
        border: 2px solid #198754;
        border-radius: 6px;
    }
</style>
@endpush
@extends('layouts.admin')

@section('title', 'Edit Informasi')

@section('content')
<div class="container-fluid px-3 px-md-4 pb-5">
    <!-- Header -->
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mt-4 mb-4">
        <div>
            <h1 class="h3 text-gray-800 mb-1">Edit Informasi</h1>
            <p class="text-muted small mb-0">Perbarui data: <strong>{{ $information->title }}</strong></p>
        </div>
        <a href="{{ route('informations.index') }}" class="btn btn-light border px-3 fw-bold small text-muted shadow-sm">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <form action="{{ route('informations.update', $information->id) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')
        <div class="row g-4">
            <!-- KOLOM KIRI -->
            <div class="col-12 col-lg-8">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header py-3 bg-success text-white">
                        <h6 class="m-0 font-weight-bold"><i class="fas fa-edit me-2"></i>Informasi Utama</h6>
                    </div>
                    <div class="card-body p-3 p-md-4">
                        {{-- PEMILIH TIPE --}}
                        <div class="mb-4">
                            <label class="form-label small fw-bold text-uppercase text-muted mb-2">Jenis Konten</label>
                            <div class="type-selector-wrap">
                                <button type="button" class="type-btn type-btn-news {{ $information->type == 'news' ? 'active' : '' }}" data-type="news">
                                    <span class="type-icon"><i class="fas fa-newspaper"></i></span>
                                    <span class="type-label">Berita</span>
                                </button>
                                <button type="button" class="type-btn type-btn-announce {{ $information->type == 'announcement' ? 'active' : '' }}" data-type="announcement">
                                    <span class="type-icon"><i class="fas fa-bullhorn"></i></span>
                                    <span class="type-label">Pengumuman</span>
                                </button>
                            </div>
                            <input type="hidden" name="type" id="type_info" value="{{ $information->type }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark">Judul Informasi <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control form-control-custom @error('title') is-invalid @enderror"
                                   value="{{ old('title', $information->title) }}" required>
                            @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-0">
                            <label class="form-label fw-bold text-dark">Isi Konten <span class="text-danger">*</span></label>
                            <textarea name="content" id="editor" class="form-control shadow-sm">{{ old('content', $information->content) }}</textarea>
                            @error('content') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- KOLOM KANAN -->
            <div class="col-12 col-lg-4">
                <div class="card shadow-sm border-0 sticky-top" style="top: 80px;">
                    <div class="card-header bg-success py-3">
                        <h6 class="m-0 font-weight-bold text-white"><i class="fas fa-cog me-2"></i>Pengaturan & Media</h6>
                    </div>
                    <div class="card-body p-3 p-md-4">

                        <!-- Foto -->
                        <div class="mb-4">
                            <label class="form-label fw-bold text-dark"><i class="fas fa-image me-1 text-success"></i> Foto</label>

                            @if($information->image)
                                <div class="current-img-wrap mb-2">
                                    <img src="{{ asset('storage/'.$information->image) }}" class="current-img">
                                    <span class="current-img-badge">Foto saat ini</span>
                                </div>
                            @endif

                            <div id="previewContainer" class="d-none mb-2">
                                <div class="img-preview-wrap">
                                    <img id="imagePreview" src="#" class="img-preview">
                                    <button type="button" id="removeImage" class="img-preview-remove"><i class="fas fa-times"></i></button>
                                </div>
                                <small class="text-success fw-bold" style="font-size:0.72rem;"><i class="fas fa-check-circle me-1"></i>Foto baru dipilih</small>
                            </div>

                            <label for="imageInput" class="upload-area" id="uploadArea">
                                <i class="fas fa-cloud-upload-alt upload-icon"></i>
                                <span class="upload-text">{{ $information->image ? 'Ganti foto' : 'Upload foto' }}</span>
                                <span class="upload-hint">JPG, PNG, WEBP · Maks 2MB</span>
                                <input type="file" name="image" id="imageInput" accept="image/jpeg,image/png,image/webp" class="d-none">
                            </label>
                        </div>

                        <!-- Section Berita -->
                        <div id="section_news" {{ $information->type != 'news' ? 'style=display:none;' : '' }}>
                            <div class="settings-block settings-block-green mb-4">
                                <div class="settings-block-title text-success">
                                    <i class="fas fa-newspaper me-2"></i>Pengaturan Berita
                                </div>
                                <div class="mb-3">
                                    <label class="field-label">Kategori Berita</label>
                                    <select name="category" class="form-select form-select-custom" {{ $information->type != 'news' ? 'disabled' : '' }}>
                                        @foreach(['Kegiatan Mahasiswa', 'Kegiatan Dosen', 'Kegiatan Umum'] as $cat)
                                            <option value="{{ $cat }}" {{ $information->category == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-0">
                                    <label class="field-label">Tanggal Terbit</label>
                                    <input type="date" name="published_at" class="form-control form-control-custom"
                                           value="{{ $information->published_at ? $information->published_at->format('Y-m-d') : '' }}"
                                           {{ $information->type != 'news' ? 'disabled' : '' }}>
                                </div>
                            </div>
                        </div>

                        <!-- Section Pengumuman -->
                        <div id="section_announcement" {{ $information->type != 'announcement' ? 'style=display:none;' : '' }}>
                            <div class="settings-block settings-block-blue mb-4">
                                <div class="settings-block-title text-primary">
                                    <i class="fas fa-bullhorn me-2"></i>Pengaturan Pengumuman
                                </div>
                                @if($information->attachment_file)
                                    <div class="attachment-badge mb-3">
                                        <i class="fas fa-file-pdf text-danger me-1"></i>
                                        <span>Ada lampiran tersimpan</span>
                                    </div>
                                @endif
                                <div class="mb-3">
                                    <label class="field-label">{{ $information->attachment_file ? 'Ganti' : 'Upload' }} Lampiran (PDF)</label>
                                    <input type="file" name="attachment_file" class="form-control form-control-custom"
                                           {{ $information->type != 'announcement' ? 'disabled' : '' }}>
                                </div>
                                <div class="mb-3">
                                    <label class="field-label">Batas Tampil (Expired)</label>
                                    <input type="date" name="expired_at" class="form-control form-control-custom"
                                           value="{{ $information->expired_at ? $information->expired_at->format('Y-m-d') : '' }}"
                                           {{ $information->type != 'announcement' ? 'disabled' : '' }}>
                                </div>
                                <div class="toggle-important">
                                    <div>
                                        <p class="toggle-important-label">Tandai PENTING</p>
                                        <small class="text-muted" style="font-size:0.7rem;">Tampilkan badge penting</small>
                                    </div>
                                    <div class="form-check form-switch mb-0">
                                        <input class="form-check-input" type="checkbox" name="is_important" value="1" id="important"
                                               {{ $information->is_important ? 'checked' : '' }}
                                               {{ $information->type != 'announcement' ? 'disabled' : '' }}
                                               style="width:2.2em;height:1.15em;cursor:pointer;">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Publikasi -->
                        <div class="mb-4">
                            <label class="form-label fw-bold text-dark">Publikasi</label>
                            <div class="publish-toggle">
                                <div>
                                    <p class="mb-0 fw-bold small">Terbitkan Sekarang</p>
                                    <small class="text-muted" style="font-size:0.7rem;">Langsung tampil di halaman publik</small>
                                </div>
                                <div class="form-check form-switch mb-0">
                                    <input class="form-check-input" type="checkbox" name="active" value="1" id="active"
                                           {{ old('active', $information->active) ? 'checked' : '' }}
                                           style="width:2.5em;height:1.25em;cursor:pointer;">
                                </div>
                            </div>
                        </div>

                        <hr class="my-3">
                        <div class="d-flex flex-column gap-2">
                            <button type="submit" class="btn-submit-main">
                                <i class="fas fa-save me-2"></i> Simpan Perubahan
                            </button>
                            <a href="{{ route('informations.index') }}" class="btn btn-outline-secondary py-2 text-center">Batal</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    CKEDITOR.replace('editor', {
        height: 350,
        toolbar: [
            { name: 'basicstyles', items: ['Bold','Italic','Underline','Strike'] },
            { name: 'paragraph', items: ['NumberedList','BulletedList','-','JustifyLeft','JustifyCenter','JustifyRight'] },
            { name: 'links', items: ['Link','Unlink'] },
            { name: 'insert', items: ['Image','Table','HorizontalRule'] },
            { name: 'tools', items: ['Maximize','Undo','Redo'] }
        ]
    });

    function toggleFields() {
        const type = document.getElementById('type_info').value;
        if (type === 'news') {
            $('#section_news').fadeIn(200);
            $('#section_announcement').hide();
            $('#section_news').find(':input').prop('disabled', false);
            $('#section_announcement').find(':input').prop('disabled', true);
        } else {
            $('#section_news').hide();
            $('#section_announcement').fadeIn(200);
            $('#section_news').find(':input').prop('disabled', true);
            $('#section_announcement').find(':input').prop('disabled', false);
        }
    }

    document.querySelectorAll('.type-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            document.querySelectorAll('.type-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            document.getElementById('type_info').value = this.dataset.type;
            toggleFields();
        });
    });

    $(document).ready(toggleFields);

    // Image preview
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

<style>
    /* === TYPE SELECTOR === */
    .type-selector-wrap { display: flex; gap: 10px; }
    .type-btn {
        display: flex; align-items: center; gap: 8px;
        padding: 10px 20px; border-radius: 10px;
        border: 2px solid #dee2e6; background: #f8f9fa;
        color: #6c757d; font-weight: 600; font-size: 0.875rem;
        cursor: pointer; transition: all 0.2s;
        box-shadow: 0 1px 3px rgba(0,0,0,0.06);
    }
    .type-btn:hover { box-shadow: 0 3px 8px rgba(0,0,0,0.1); transform: translateY(-1px); }
    .type-btn-news.active {
        background: #e8f5e9; border-color: #198754; color: #155724;
        box-shadow: 0 2px 8px rgba(25,135,84,0.2);
    }
    .type-btn-announce.active {
        background: #e8eeff; border-color: #0d6efd; color: #084298;
        box-shadow: 0 2px 8px rgba(13,110,253,0.2);
    }
    .type-icon { font-size: 1rem; }

    /* === FORM CONTROLS === */
    .form-control-custom, .form-select-custom {
        border: 1.5px solid #dee2e6; border-radius: 8px; font-size: 0.875rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05), inset 0 1px 2px rgba(255,255,255,0.9);
        transition: border-color 0.15s, box-shadow 0.15s;
    }
    .form-control-custom:focus, .form-select-custom:focus {
        border-color: #198754; box-shadow: 0 0 0 3px rgba(25,135,84,0.12); outline: none;
    }

    /* === CURRENT IMAGE === */
    .current-img-wrap { position: relative; display: inline-block; width: 100%; }
    .current-img {
        width: 100%; max-height: 110px; object-fit: cover;
        border-radius: 8px; border: 1.5px solid #dee2e6;
        box-shadow: 0 1px 4px rgba(0,0,0,0.08);
    }
    .current-img-badge {
        display: block; font-size: 0.7rem; color: #888; text-align: center; margin-top: 4px;
    }

    /* === UPLOAD AREA === */
    .upload-area {
        display: flex; flex-direction: column; align-items: center;
        justify-content: center; gap: 4px; padding: 16px;
        border: 2px dashed #c3e6cb; border-radius: 10px;
        background: #f8fff9; cursor: pointer; transition: all 0.2s; text-align: center;
    }
    .upload-area:hover { border-color: #198754; background: #f0faf4; }
    .upload-icon { font-size: 1.4rem; color: #198754; }
    .upload-text { font-size: 0.82rem; font-weight: 600; color: #198754; }
    .upload-hint { font-size: 0.7rem; color: #aaa; }

    /* === IMAGE PREVIEW === */
    .img-preview-wrap { position: relative; display: inline-block; width: 100%; }
    .img-preview {
        width: 100%; max-height: 130px; object-fit: cover;
        border-radius: 8px; border: 1.5px solid #c3e6cb;
        box-shadow: 0 2px 6px rgba(0,0,0,0.08);
    }
    .img-preview-remove {
        position: absolute; top: 6px; right: 6px;
        width: 24px; height: 24px; border-radius: 50%;
        background: rgba(220,53,69,0.85); border: none;
        color: #fff; font-size: 0.65rem; cursor: pointer;
        display: flex; align-items: center; justify-content: center;
    }

    /* === SETTINGS BLOCK === */
    .settings-block {
        border-radius: 10px; padding: 14px 16px;
        border: 1.5px solid #e0e0e0; background: #fff;
        box-shadow: 0 1px 4px rgba(0,0,0,0.05);
    }
    .settings-block-green { border-color: #b2dfcc; background: #f8fff9; }
    .settings-block-blue  { border-color: #b3cff5; background: #f5f8ff; }
    .settings-block-title { font-size: 0.85rem; font-weight: 700; margin-bottom: 14px; }
    .field-label { display: block; font-size: 0.78rem; font-weight: 600; color: #555; margin-bottom: 5px; }

    /* === ATTACHMENT BADGE === */
    .attachment-badge {
        display: flex; align-items: center; gap: 6px;
        padding: 7px 10px; background: #fff8f8;
        border: 1px solid #f5c6cb; border-radius: 7px;
        font-size: 0.78rem; color: #555;
    }

    /* === TOGGLE IMPORTANT === */
    .toggle-important {
        display: flex; align-items: center; justify-content: space-between;
        padding: 10px 12px; background: #fff5f5;
        border: 1.5px solid #f5c6cb; border-radius: 8px;
    }
    .toggle-important-label { font-size: 0.85rem; font-weight: 700; color: #dc3545; margin: 0; }

    /* === PUBLISH TOGGLE === */
    .publish-toggle {
        display: flex; align-items: center; justify-content: space-between;
        padding: 12px 14px; background: #f8f9fa;
        border: 1.5px solid #dee2e6; border-radius: 10px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }

    /* === SUBMIT BUTTON === */
    .btn-submit-main {
        width: 100%; padding: 11px; border-radius: 9px; border: none;
        background: linear-gradient(135deg, #198754, #20c997);
        color: #fff; font-size: 0.9rem; font-weight: 700; cursor: pointer;
        box-shadow: 0 3px 8px rgba(25,135,84,0.3);
        transition: opacity 0.2s, transform 0.1s;
    }
    .btn-submit-main:hover { opacity: 0.93; transform: translateY(-1px); }
    .btn-submit-main:disabled { opacity: 0.7; transform: none; cursor: not-allowed; }

    .form-control:focus, .form-select:focus { border-color: #198754; box-shadow: none; }
    .sticky-top { top: 80px; }
    @media (max-width: 576px) { .sticky-top { position: relative; top: 0; } }
</style>
@endpush
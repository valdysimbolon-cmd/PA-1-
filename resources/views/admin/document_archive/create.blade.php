@extends('layouts.admin')

@section('title', 'Tambah Dokumen Baru')

@section('content')
<div class="container-fluid px-3 px-md-4 pb-5">
    <!-- Header -->
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mt-4 mb-4">
        <div>
            <h1 class="h3 text-gray-800 mb-1">Tambah Dokumen Baru</h1>
            <p class="text-muted small mb-0">Unggah dokumen resmi, SOP, atau borang program studi.</p>
        </div>
        <a href="{{ route('document_archives.index') }}" class="btn btn-light border px-3 fw-bold small text-muted shadow-sm">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <form action="{{ route('document_archives.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row g-4">
            <!-- KOLOM KIRI: DATA UTAMA -->
            <div class="col-12 col-lg-8">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header py-3 bg-success text-white">
                        <h6 class="m-0 font-weight-bold"><i class="fas fa-file-upload me-2"></i>Informasi Dokumen</h6>
                    </div>
                    <div class="card-body p-3 p-md-4">
                        <div class="mb-4">
                            <label class="form-label fw-bold text-dark">Judul Dokumen <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control form-control-custom @error('title') is-invalid @enderror"
                                   value="{{ old('title') }}" placeholder="Masukkan judul dokumen" required>
                            @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold text-dark">Deskripsi</label>
                            <textarea name="description" id="editor" class="form-control form-control-custom @error('description') is-invalid @enderror"
                                      rows="5">{{ old('description') }}</textarea>
                            @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- KOLOM KANAN: FILE, TAGS, PUBLIKASI -->
            <div class="col-12 col-lg-4">
                <div class="card shadow-sm border-0 sticky-top" style="top: 80px;">
                    <div class="card-header bg-success py-3">
                        <h6 class="m-0 font-weight-bold text-white"><i class="fas fa-cog me-2"></i>Pengaturan & File</h6>
                    </div>
                    <div class="card-body p-3 p-md-4">
                        <!-- Upload File -->
                        <div class="mb-4">
                            <label class="form-label fw-bold text-dark"><i class="fas fa-paperclip me-1 text-success"></i> Unggah File <span class="text-danger">*</span></label>
                            <div id="filePreviewContainer" class="d-none mb-3 text-center">
                                <div class="p-3 bg-light rounded border border-success">
                                    <i class="fas fa-file-alt text-success fa-3x d-block mb-2"></i>
                                    <small class="text-success fw-bold d-block" id="fileNameDisplay">file.pdf</small>
                                    <small class="text-muted" style="font-size:0.72rem;" id="fileSizeDisplay">0 KB</small>
                                </div>
                            </div>

                            <div id="uploadPlaceholder" class="upload-area">
                                <i class="fas fa-cloud-upload-alt upload-icon text-success"></i>
                                <span class="upload-text">Klik untuk upload file</span>
                                <span class="upload-hint">PDF, DOC, DOCX, XLS, XLSX (maks 10MB)</span>
                                <input type="file" name="file" id="fileInput" class="upload-input" accept=".pdf,.doc,.docx,.xls,.xlsx" required>
                            </div>
                            @error('file') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        <!-- Tags -->
                        <div class="mb-4">
                            <label class="form-label fw-bold text-dark">Kategori (Tags)</label>
                            <div class="border rounded p-3 bg-light" style="border-color: #dee2e6 !important;">
                                @foreach($presetTags as $tag)
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" name="tags[]" value="{{ $tag }}" id="tag_{{ $tag }}"
                                           {{ in_array($tag, old('tags', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label small" for="tag_{{ $tag }}">{{ $tag }}</label>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Tahun -->
                        <div class="mb-4">
                            <label class="form-label fw-bold text-dark">Tahun Dokumen</label>
                            <input type="number" name="year" class="form-control form-control-custom"
                                   value="{{ old('year', date('Y')) }}" min="1900" max="{{ date('Y') }}">
                        </div>

                        <!-- Publikasi -->
                        <div class="mb-4">
                            <label class="form-label fw-bold text-dark">Publikasi</label>
                            <div class="publish-toggle">
                                <div>
                                    <p class="mb-0 fw-bold small">Terbitkan Sekarang</p>
                                    <small class="text-muted" style="font-size:0.7rem;">Tampilkan di halaman publik</small>
                                </div>
                                <div class="form-check form-switch mb-0">
                                    <input class="form-check-input" type="checkbox" name="active" value="1" id="active" checked
                                           style="width:2.5em;height:1.25em;cursor:pointer;">
                                </div>
                            </div>
                            <div class="alert alert-info border-0 mt-2 py-2 px-3 small" style="border-radius: 8px; font-size:0.75rem;">
                                <i class="fas fa-info-circle me-1"></i> Aktifkan agar dokumen langsung tampil di halaman publik.
                            </div>
                        </div>

                        <hr class="my-3">
                        <div class="d-flex flex-column gap-2">
                            <button type="submit" class="btn-submit-main">
                                <i class="fas fa-save me-2"></i> Simpan Dokumen
                            </button>
                            <a href="{{ route('document_archives.index') }}" class="btn btn-outline-secondary py-2 text-center" style="border-radius: 9px; font-size: 0.9rem; font-weight: 600;">Batal</a>
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
        height: 250,
        toolbar: [
            { name: 'basicstyles', items: ['Bold','Italic','Underline'] },
            { name: 'paragraph', items: ['NumberedList','BulletedList','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'] },
            { name: 'links', items: ['Link','Unlink'] },
            { name: 'tools', items: ['Undo','Redo'] }
        ]
    });

    // Preview file
    const fileInput = document.getElementById('fileInput');
    const filePreviewContainer = document.getElementById('filePreviewContainer');
    const uploadPlaceholder = document.getElementById('uploadPlaceholder');
    const fileNameDisplay = document.getElementById('fileNameDisplay');
    const fileSizeDisplay = document.getElementById('fileSizeDisplay');

    fileInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const allowed = ['pdf', 'doc', 'docx', 'xls', 'xlsx'];
            const ext = file.name.split('.').pop().toLowerCase();
            if (!allowed.includes(ext) || file.size > 10 * 1024 * 1024) {
                Swal.fire({
                    icon: 'error',
                    title: 'File Tidak Valid',
                    text: 'Gunakan PDF, DOC, DOCX, XLS, XLSX maks 10MB.',
                    confirmButtonColor: '#198754'
                });
                this.value = '';
                filePreviewContainer.classList.add('d-none');
                uploadPlaceholder.classList.remove('d-none');
                return;
            }
            fileNameDisplay.textContent = file.name;
            fileSizeDisplay.textContent = (file.size / 1024).toFixed(1) + ' KB';
            filePreviewContainer.classList.remove('d-none');
            uploadPlaceholder.classList.add('d-none');
        } else {
            filePreviewContainer.classList.add('d-none');
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
    /* Gaya seragam dengan modul lain */
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

    .ck-editor__editable { min-height: 200px; }
    .form-check-input:checked { background-color: #198754; border-color: #198754; }
</style>
@endpush
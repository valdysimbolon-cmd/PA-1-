@extends('layouts.admin')

@section('title', 'Tambah Dokumen')

@section('content')
<div class="container-fluid px-3 px-md-4 pb-5">
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mt-4 mb-4">
        <div>
            <h1 class="h3 text-gray-800 mb-1">Tambah Dokumen Baru</h1>
            <p class="text-muted small mb-0">Unggah dokumen resmi, SOP, atau borang program studi.</p>
        </div>
        <a href="{{ route('document_archives.index') }}" class="btn btn-light border px-3 fw-bold small text-muted shadow-sm">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-12 col-lg-10">
            <div class="card shadow-sm border-0">
                <div class="card-header py-3 bg-success text-white">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-file-upload me-2"></i>Formulir Dokumen Baru
                    </h6>
                </div>
                <div class="card-body p-3 p-md-4">
                    <form action="{{ route('document_archives.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row g-4">
                            <!-- Kolom Kiri -->
                            <div class="col-12 col-md-8">
                                <div class="mb-4">
                                    <label class="form-label fw-bold text-dark">Judul Dokumen <span class="text-danger">*</span></label>
                                    <input type="text" name="title" class="form-control shadow-sm @error('title') is-invalid @enderror" 
                                           value="{{ old('title') }}" required>
                                    @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-bold text-dark">Deskripsi</label>
                                    <textarea name="description" id="editor" class="form-control shadow-sm">{{ old('description') }}</textarea>
                                </div>
                            </div>

                            <!-- Kolom Kanan -->
                            <div class="col-12 col-md-4">
                                <div class="mb-4">
                                    <label class="form-label fw-bold text-success">
                                        <i class="fas fa-paperclip me-1"></i> Unggah File
                                    </label>
                                    <div class="input-group shadow-sm">
                                        <span class="input-group-text bg-light text-success"><i class="fas fa-cloud-upload-alt"></i></span>
                                        <input type="file" name="file" class="form-control @error('file') is-invalid @enderror" accept=".pdf,.doc,.docx,.xls,.xlsx" required>
                                    </div>
                                    <div class="form-text mt-2">
                                        <i class="fas fa-info-circle me-1"></i> Format: PDF, DOC, DOCX, XLS, XLSX (Maks. 10MB)
                                    </div>
                                    @error('file') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-bold text-dark">Kategori (Tags)</label>
                                    <div class="border rounded p-3 bg-light">
                                        @foreach($presetTags as $tag)
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="tags[]" value="{{ $tag }}" id="tag_{{ $tag }}" {{ in_array($tag, old('tags', [])) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="tag_{{ $tag }}">{{ $tag }}</label>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-bold text-dark">Tahun Dokumen</label>
                                    <input type="number" name="year" class="form-control shadow-sm" value="{{ old('year', date('Y')) }}">
                                </div>

                                <!-- Status Publikasi -->
                                <div class="mb-4">
                                    <label class="form-label fw-bold text-dark mb-3">Pengaturan Publikasi</label>
                                    <div class="p-3 rounded-3 border d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-2 mb-2">
                                        <div>
                                            <p class="mb-0 fw-bold small">Terbitkan Sekarang</p>
                                            <small class="text-muted" style="font-size: 0.7rem;">Dokumen langsung tampil di halaman publik</small>
                                        </div>
                                        <div class="form-check form-switch mb-0">
                                            <input class="form-check-input" type="checkbox" name="active" value="1" id="active" checked
                                                style="width: 2.5em; height: 1.25em; cursor: pointer;">
                                        </div>
                                    </div>
                                    <div class="alert alert-info border-0 mb-0 py-2 px-3 mt-2" style="font-size: 0.75rem; border-radius: 8px;">
                                        <i class="fas fa-info-circle me-1"></i> Aktifkan agar Dokumen ini langsung tampil di halaman publik.
                                    </div>
                                </div>

                                <hr class="my-4">
                                <div class="d-flex flex-column flex-sm-row gap-2">
                                    <button type="submit" class="btn btn-success px-4 py-2 shadow fw-bold w-100 w-sm-auto">
                                        <i class="fas fa-save me-2"></i> Simpan Dokumen
                                    </button>
                                    <a href="{{ route('document_archives.index') }}" class="btn btn-outline-secondary px-4 py-2 border-2 text-center w-100 w-sm-auto">Batal</a>
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
<script src="https://cdn.ckeditor.com/4.22.1/full/ckeditor.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // 1. Inisialisasi CKEditor (Cukup Sekali)
    if (document.getElementById('editor')) {
        CKEDITOR.replace('editor', { height: 300 });
    }

    document.addEventListener('DOMContentLoaded', function () {
        // 2. Alert jika Validasi Gagal (Redireksi dari $request->validate)
        @if($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Gagal Validasi',
                html: '<div class="text-start"><ul class="small">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>',
                confirmButtonColor: '#198754'
            });
        @endif

        // 3. Alert jika terjadi Error Sistem (Session Error)
        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Kesalahan',
                text: '{{ session('error') }}',
                confirmButtonColor: '#dc3545'
            });
        @endif

        // 4. Alert Sukses
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                timer: 2500,
                showConfirmButton: false
            });
        @endif
    });

    // 5. Client-side File Validation
    const fileInput = document.querySelector('input[name="file"]');
    if (fileInput) {
        fileInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (!file) return;
            const allowed = ['pdf', 'doc', 'docx', 'xls', 'xlsx'];
            const ext = file.name.split('.').pop().toLowerCase();
            if (!allowed.includes(ext)) {
                Swal.fire({ icon: 'error', title: 'Format Salah', text: 'Gunakan PDF, DOC, DOCX, XLS, XLSX.' });
                this.value = '';
            }
        });
    }
</script>
@endpush
@endsection
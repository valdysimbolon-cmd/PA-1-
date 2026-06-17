@extends('layouts.admin')

@section('title', 'Tambah Informasi Baru')

@section('content')
<div class="container-fluid px-3 px-md-4 pb-5">
    <!-- Header -->
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mt-4 mb-4">
        <div>
            <h1 class="h3 text-gray-800 mb-1">Tambah Informasi</h1>
            <p class="text-muted small mb-0">Pilih tipe informasi untuk menyesuaikan form.</p>
        </div>
        <a href="{{ route('informations.index') }}" class="btn btn-light border px-3 fw-bold small text-muted shadow-sm">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <form action="{{ route('informations.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row g-4">
            <!-- KOLOM KIRI: DATA UTAMA -->
            <div class="col-12 col-lg-8">
                <!-- CARD 1: PILIH TIPE & JUDUL -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header py-3 bg-success text-white">
                        <h6 class="m-0 font-weight-bold"><i class="fas fa-plus-circle me-2"></i>Informasi Utama</h6>
                    </div>
                    <div class="card-body p-3 p-md-4">
                        {{-- PEMILIH TIPE UTAMA --}}
                        <div class="mb-4 p-3 bg-light rounded-4 border">
                            <label class="form-label small fw-bold text-success text-uppercase">Pilih Jenis Konten</label>
                            <div class="d-flex flex-wrap gap-2 mt-2" id="typeSelector">
                                <button type="button" class="btn btn-outline-success rounded-pill px-4 py-2 fw-bold type-btn active" data-type="news">
                                    <i class="fas fa-newspaper me-2"></i> Berita
                                </button>
                                <button type="button" class="btn btn-outline-primary rounded-pill px-4 py-2 fw-bold type-btn" data-type="announcement">
                                    <i class="fas fa-bullhorn me-2"></i> Pengumuman
                                </button>
                            </div>
                            <input type="hidden" name="type" id="type_info" value="news">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark">Judul Informasi <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control shadow-sm @error('title') is-invalid @enderror"
                                   value="{{ old('title') }}" placeholder="Masukkan judul yang menarik..." required>
                            @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-0">
                            <label class="form-label fw-bold text-dark">Isi Konten <span class="text-danger">*</span></label>
                            <textarea name="content" id="editor" class="form-control shadow-sm">{{ old('content') }}</textarea>
                            @error('content') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- KOLOM KANAN: MEDIA & SETTINGS (STICKY) -->
            <div class="col-12 col-lg-4">
                <div class="card shadow-sm border-0 sticky-top" style="top: 80px;">
                    <div class="card-header bg-success py-3">
                        <h6 class="m-0 font-weight-bold text-white"><i class="fas fa-cog me-2"></i>Pengaturan & Media</h6>
                    </div>
                    <div class="card-body p-3 p-md-4">
                        <!-- Media / Foto -->
                        <div class="mb-4">
                            <label class="form-label fw-bold text-success"><i class="fas fa-image me-1"></i> Foto</label>
                            <div id="previewContainer" class="d-none mb-3 p-2 bg-light rounded border text-center">
                                <p class="small fw-bold text-success mb-1">Preview</p>
                                <img id="imagePreview" src="#" class="img-fluid rounded shadow-sm" style="max-height: 150px; object-fit: cover;">
                            </div>
                            <div class="input-group shadow-sm">
                                <span class="input-group-text bg-light text-success"><i class="fas fa-upload"></i></span>
                                <input type="file" name="image" id="imageInput" class="form-control" accept="image/jpeg,image/png,image/webp">
                            </div>
                            <div class="form-text mt-2">
                                <i class="fas fa-info-circle me-1"></i> Format JPG, PNG, WEBP (Maks 2MB)
                            </div>
                        </div>

                        <!-- DYNAMIC: NEWS -->
                        <div id="section_news">
                            <div class="card border-0 shadow-sm mb-4 border-top border-success border-5">
                                <div class="card-body p-3">
                                    <h6 class="fw-bold text-success mb-3"><i class="fas fa-newspaper me-2"></i>Pengaturan Berita</h6>
                                    <div class="mb-3">
                                        <label class="small fw-bold text-dark">Kategori Berita</label>
                                        <select name="category" class="form-select shadow-sm">
                                            <option value="Kegiatan Mahasiswa">Kegiatan Mahasiswa</option>
                                            <option value="Kegiatan Dosen">Kegiatan Dosen</option>
                                            <option value="Kegiatan Umum">Kegiatan Umum</option>
                                        </select>
                                    </div>
                                    <div class="mb-0">
                                        <label class="small fw-bold text-dark">Tanggal Terbit</label>
                                        <input type="date" name="published_at" class="form-control shadow-sm" value="{{ date('Y-m-d') }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- DYNAMIC: ANNOUNCEMENT -->
                        <div id="section_announcement" style="display:none;">
                            <div class="card border-0 shadow-sm mb-4 border-top border-primary border-5">
                                <div class="card-body p-3">
                                    <h6 class="fw-bold text-primary mb-3"><i class="fas fa-bullhorn me-2"></i>Pengaturan Pengumuman</h6>
                                    <div class="mb-3">
                                        <label class="small fw-bold text-dark">File Lampiran (PDF)</label>
                                        <input type="file" name="attachment_file" class="form-control shadow-sm">
                                    </div>
                                    <div class="mb-3">
                                        <label class="small fw-bold text-dark">Batas Tampil (Expired)</label>
                                        <input type="date" name="expired_at" class="form-control shadow-sm">
                                    </div>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="is_important" value="1" id="important">
                                        <label class="form-check-label fw-bold text-danger" for="important">Tandai PENTING</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Status Publikasi -->
                        <div class="mb-4">
                            <label class="form-label fw-bold text-dark mb-3">Pengaturan Publikasi</label>
                            <div class="p-3 rounded-3 border d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-2 mb-2">
                                <div>
                                    <p class="mb-0 fw-bold small">Terbitkan Sekarang</p>
                                    <small class="text-muted" style="font-size: 0.7rem;">Informasi langsung tampil di halaman publik</small>
                                </div>
                                <div class="form-check form-switch mb-0">
                                    <input class="form-check-input" type="checkbox" name="active" value="1" id="active" checked
                                        style="width: 2.5em; height: 1.25em; cursor: pointer;">
                                </div>
                            </div>
                            <div class="alert alert-info border-0 mb-0 py-2 px-3 mt-2" style="font-size: 0.75rem; border-radius: 8px;">
                                <i class="fas fa-info-circle me-1"></i> Aktifkan agar Informasi ini langsung tampil di halaman publik.
                            </div>
                        </div>

                        <hr class="my-4">
                        <div class="d-flex flex-column flex-sm-row gap-2">
                            <button type="submit" class="btn btn-success px-4 py-2 shadow fw-bold w-100 w-sm-auto">
                                <i class="fas fa-paper-plane me-2"></i> Terbitkan Sekarang
                            </button>
                            <a href="{{ route('informations.index') }}" class="btn btn-outline-secondary px-4 py-2 border-2 text-center w-100 w-sm-auto">Batal</a>
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
    // CKEDITOR
    CKEDITOR.replace('editor', {
        height: 350,
        filebrowserUploadUrl: "{{ route('ckeditor.upload', ['_token' => csrf_token()]) }}",
        filebrowserUploadMethod: 'form',
        toolbar: [
            { name: 'basicstyles', items: ['Bold', 'Italic', 'Underline', 'Strike'] },
            { name: 'paragraph', items: ['NumberedList', 'BulletedList', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'] },
            { name: 'links', items: ['Link', 'Unlink'] },
            { name: 'insert', items: ['Image', 'Table', 'HorizontalRule'] },
            { name: 'tools', items: ['Maximize', 'Undo', 'Redo'] }
        ],
        extraPlugins: 'image2,uploadimage'
    });

    // Toggle News / Announcement
    function toggleFields() {
        const type = $('#type_info').val();
        if (type === 'news') {
            $('#section_news').fadeIn();
            $('#section_announcement').hide();
            
            // Aktifkan input berita, Matikan input pengumuman
            $('#section_news').find(':input').prop('disabled', false);
            $('#section_announcement').find(':input').prop('disabled', true);
        } else {
            $('#section_news').hide();
            $('#section_announcement').fadeIn();
            
            // Matikan input berita, Aktifkan input pengumuman
            $('#section_news').find(':input').prop('disabled', true);
            $('#section_announcement').find(':input').prop('disabled', false);
        }
    }
    $('#type_info').on('change', toggleFields);
    $(document).ready(toggleFields);

    // Toggle tombol pilihan
    document.querySelectorAll('.type-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.type-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            document.getElementById('type_info').value = this.dataset.type;
            // Trigger change untuk toggleFields
            $('#type_info').trigger('change');
        });
    });

    // Image Preview
    const imageInput = document.getElementById('imageInput');
    const imagePreview = document.getElementById('imagePreview');
    const previewContainer = document.getElementById('previewContainer');

    imageInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
            const maxSize = 2 * 1024 * 1024;
            if (!allowedTypes.includes(file.type)) {
                Swal.fire({ icon: 'error', title: 'Format Tidak Didukung', text: 'Gunakan JPG, JPEG, PNG, atau WEBP.', confirmButtonColor: '#198754' });
                this.value = '';
                previewContainer.classList.add('d-none');
                return;
            }
            if (file.size > maxSize) {
                Swal.fire({ icon: 'error', title: 'File Terlalu Besar', text: 'Ukuran maksimal 2MB.', confirmButtonColor: '#198754' });
                this.value = '';
                previewContainer.classList.add('d-none');
                return;
            }
            const reader = new FileReader();
            reader.onload = function(ev) {
                imagePreview.src = ev.target.result;
                previewContainer.classList.remove('d-none');
            };
            reader.readAsDataURL(file);
        } else {
            previewContainer.classList.add('d-none');
        }
    });

    // Tambahkan listener pada form untuk mencegah double submit
document.querySelector('form').addEventListener('submit', function(e) {
    const btn = this.querySelector('button[type="submit"]');
    
    // Jika tombol sudah di-disable, batalkan submit (mencegah klik berkali-kali)
    if (btn.disabled) {
        e.preventDefault();
        return;
    }

    // Disable tombol dan ganti teksnya
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Sedang Memproses...';
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
    .sticky-top { top: 80px; }
    .form-control:focus, .form-select:focus { border-color: #198754; box-shadow: none; }
    .ck-editor__editable { min-height: 250px; }
    /* Tombol jenis konten */
    .type-btn.active {
        background-color: #198754 !important;
        color: white !important;
        border-color: #198754 !important;
    }
    .type-btn.btn-outline-primary.active {
        background-color: #0d6efd !important;
        color: white !important;
        border-color: #0d6efd !important;
    }
    .type-btn {
        transition: all 0.2s ease;
    }
    .type-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }
    @media (max-width: 576px) {
        .sticky-top { position: relative; top: 0; }
    }
</style>
@endpush
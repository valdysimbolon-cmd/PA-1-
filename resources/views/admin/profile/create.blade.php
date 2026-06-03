@extends('layouts.admin')

@section('title', 'Tambah Profil Baru')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-sm border-0">
                <div class="card-header py-3" style="background-color: #200F07;">
                    <h6 class="m-0 font-weight-bold" style="color: #C5E384;">
                        <i class="fas fa-plus-circle me-2"></i>Formulir Konten Baru
                    </h6>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong><i class="fas fa-exclamation-triangle"></i> Terjadi kesalahan:</strong>
                            <ul class="mb-0 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('profiles.store') }}" method="POST" enctype="multipart/form-data" id="profileForm">
                        @csrf

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Kode Navigasi (Sistem)</label>
                                <input type="text" name="key" class="form-control" placeholder="Contoh: P_SEJARAH" value="{{ old('key') }}" required>
                                <div class="form-text">Gunakan huruf besar dan underscore, unik untuk setiap halaman.</div>
                                <div class="alert alert-info mt-2 small border-0 shadow-sm" style="background-color: #e3f2fd; color: #0d47a1;">
                                    <h6 class="fw-bold mb-1" style="font-size: 0.85rem;"><i class="fas fa-info-circle me-1"></i> Penempatan Konten:</h6>
                                    <ul class="mb-0 ps-3" style="font-size: 0.8rem;">
                                        <li>Gunakan awalan <strong>B_</strong> agar tampil di <strong>Beranda</strong>.</li>
                                        <li>Gunakan awalan <strong>P_</strong> agar tampil di <strong>Profil Prodi</strong>.</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Judul Konten</label>
                                <input type="text" name="name" class="form-control" placeholder="Contoh: Visi dan Misi Teknik Bioproses" value="{{ old('name') }}" required>
                            </div>
                        </div>

                        <div class="mt-3">
                            <label class="form-label fw-semibold">Isi Konten / Narasi</label>
                            <textarea name="description" id="editor" class="form-control" rows="10">{{ old('description') }}</textarea>
                            <div class="form-text">Gunakan toolbar untuk memformat teks (termasuk rata kiri/kanan/tengah/justify).</div>
                        </div>

                        <div class="mt-3">
                            <label class="form-label fw-semibold">Gambar Pendukung (Opsional)</label>
                            <input type="file" name="image" id="imageInput" class="form-control" accept="image/*">
                            <div id="previewContainer" class="mt-2 d-none">
                                <img id="imagePreview" src="#" class="img-thumbnail" style="max-height: 150px;">
                            </div>
                            <div class="form-text">Format JPG, PNG, JPEG. Maks 2MB.</div>
                        </div>

                        <div class="form-check form-switch mt-4">
                            <input class="form-check-input" type="checkbox" name="active" value="1" id="active" {{ old('active', true) ? 'checked' : '' }}>
                            <label class="form-check-label fw-semibold text-success" for="active">Terbitkan ke Website Publik</label>
                            <div class="form-text">Nonaktifkan jika hanya menyimpan draf.</div>
                        </div>

                        <hr class="my-4">
                        <div class="d-flex gap-2">
                            <button type="reset" id="resetBtn" class="btn btn-light border px-4">
                                <i class="fas fa-undo"></i> Bersihkan
                            </button>
                            <button type="submit" class="btn btn-success px-4">
                                <i class="fas fa-save"></i> Simpan Konten
                            </button>
                            <a href="{{ route('profiles.index') }}" class="btn btn-secondary px-4">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.ckeditor.com/4.22.1/full/ckeditor.js"></script>
<script>
    CKEDITOR.replace('editor', {
        toolbar: [
            { name: 'basicstyles', items: ['Bold','Italic','Underline','Strike'] },
            { name: 'paragraph', items: ['NumberedList','BulletedList','Blockquote','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'] },
            { name: 'links', items: ['Link','Unlink'] },
            { name: 'tools', items: ['Undo','Redo'] }
        ],
        language: 'id',
        height: 300
    });

    // Preview gambar (tetap sama seperti kode Anda)
    const imageInput = document.getElementById('imageInput');
    const imagePreview = document.getElementById('imagePreview');
    const previewContainer = document.getElementById('previewContainer');
    if (imageInput) {
        imageInput.addEventListener('change', function (e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (event) {
                    imagePreview.src = event.target.result;
                    previewContainer.classList.remove('d-none');
                };
                reader.readAsDataURL(file);
            } else {
                previewContainer.classList.add('d-none');
            }
        });
    }
</script>
@endpush
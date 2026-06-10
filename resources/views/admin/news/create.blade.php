@extends('layouts.admin')

@section('title', 'Tulis Berita Baru')

@section('content')
<div class="container-fluid px-4 pb-5">
    <!-- Judul Halaman + Tombol Kembali -->
    <div class="d-flex justify-content-between align-items-center mt-4 mb-4">
        <div>
            <h1 class="h3 text-gray-800 mb-1">Tulis Berita Baru</h1>
            <p class="text-muted small mb-0">Bagikan informasi terkini tentang kegiatan program studi.</p>
        </div>
        <a href="{{ route('news.index') }}" class="btn btn-light border px-3 fw-bold small text-muted shadow-sm">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-sm border-0">
                <div class="card-header py-3 bg-success text-white">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-edit me-2"></i>Formulir Berita Baru
                    </h6>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('news.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row g-4">
                            <!-- Kiri: Judul + Konten -->
                            <div class="col-md-8">
                                <div class="mb-4">
                                    <label class="form-label fw-bold text-dark">Judul Berita</label>
                                    <input type="text" name="title" class="form-control shadow-sm @error('title') is-invalid @enderror"
                                           value="{{ old('title') }}" placeholder="Masukkan judul menarik..." required>
                                    @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-bold text-dark">Isi Berita</label>
                                    <textarea name="content" id="editor" class="form-control shadow-sm @error('content') is-invalid @enderror"
                                              rows="10">{{ old('content') }}</textarea>
                                    @error('content') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <!-- Kanan: Pengaturan -->
                            <div class="col-md-4">
                                <!-- Kategori -->
                                <div class="mb-4">
                                    <label class="form-label fw-bold text-dark">Kategori</label>
                                    <select name="category_id" class="form-select shadow-sm @error('category_id') is-invalid @enderror" required>
                                        <option value="">-- Pilih Kategori --</option>
                                        @foreach($categories as $cat)
                                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                                {{ $cat->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <!-- Tanggal Publikasi -->
                                <div class="mb-4">
                                    <label class="form-label fw-bold text-dark">Tanggal Publikasi</label>
                                    <input type="date" name="published_at" class="form-control shadow-sm @error('published_at') is-invalid @enderror"
                                        value="{{ old('published_at', date('Y-m-d')) }}" required>
                                    @error('published_at')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Gambar Sampul -->
                                <div class="mb-4">
                                    <label class="form-label fw-bold text-dark text-success">
                                        <i class="fas fa-image me-1"></i> Gambar Sampul
                                    </label>
                                    <div id="previewContainer" class="d-none mb-3 p-3 bg-light rounded border text-center shadow-sm" style="max-width: 150px;">
                                        <p class="small fw-bold text-success mb-2">Preview</p>
                                        <img id="imagePreview" src="#" class="rounded shadow-sm border border-success" width="100" height="70" style="object-fit: cover;">
                                    </div>
                                    <div class="input-group shadow-sm">
                                        <span class="input-group-text bg-light text-success"><i class="fas fa-upload"></i></span>
                                        <input type="file" name="image" id="imageInput" class="form-control" accept="image/jpeg,image/png,image/webp">
                                    </div>
                                    <div class="form-text mt-2">
                                        <i class="fas fa-info-circle me-1"></i> Format JPG, JPEG, PNG, WEBP (Maks 2MB).
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-bold text-dark mb-3">Pengaturan Publikasi</label>
                                    <div class="p-3 rounded-3 border d-flex align-items-center justify-content-between mb-2">
                                        <div>
                                            <p class="mb-0 fw-bold small">Terbitkan Sekarang</p>
                                            <small class="text-muted" style="font-size: 0.7rem;">Berita langsung tampil di halaman publik</small>
                                        </div>
                                        <div class="form-check form-switch mb-0">
                                            <input class="form-check-input" type="checkbox" name="active" value="1" id="active" checked
                                                style="width: 2.5em; height: 1.25em; cursor: pointer;">
                                        </div>
                                    </div>
                                    <div class="alert alert-info border-0 mb-0 py-2 px-3 mt-2" style="font-size: 0.75rem; border-radius: 8px;">
                                        <i class="fas fa-info-circle me-1"></i> Aktifkan agar Berita ini langsung tampil di halaman publik.
                                    </div>
                                </div>

                                <hr class="my-4">
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-success px-4 py-2 shadow fw-bold">
                                        <i class="fas fa-paper-plane me-2"></i> Simpan berita
                                    </button>
                                    <a href="{{ route('news.index') }}" class="btn btn-outline-secondary px-4 py-2 border-2">Batal</a>
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
<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('editor', { height: 400, language: 'id' });
</script>
<script>
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
                previewContainer.classList.add('d-inline-block');
            };
            reader.readAsDataURL(file);
        } else {
            previewContainer.classList.add('d-none');
            previewContainer.classList.remove('d-inline-block');
        }
    });
</script>
@endpush
@endsection
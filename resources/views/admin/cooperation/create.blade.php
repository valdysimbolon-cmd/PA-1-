@extends('layouts.admin')

@section('title', 'Tambah Mitra Baru')

@section('content')
<div class="container-fluid px-3 px-md-4 pb-5">
    <!-- Judul + Tombol Kembali -->
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mt-4 mb-4">
        <div>
            <h1 class="h3 text-gray-800 mb-1">Tambah Mitra Kerja Sama</h1>
            <p class="text-muted small mb-0">Tambahkan instansi/perusahaan mitra baru.</p>
        </div>
        <a href="{{ route('cooperations.index') }}" class="btn btn-light border px-3 fw-bold small text-muted shadow-sm">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-12 col-lg-10">
            <div class="card shadow-sm border-0">
                <div class="card-header py-3 bg-success text-white">
                    <h6 class="m-0 font-weight-bold"><i class="fas fa-handshake me-2"></i>Formulir Mitra Baru</h6>
                </div>
                <div class="card-body p-3 p-md-4">
                    <form action="{{ route('cooperations.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row g-3">
                            <div class="col-12 col-md-8">
                                <label class="form-label fw-bold text-dark">Nama Instansi / Perusahaan</label>
                                <input type="text" name="name" class="form-control shadow-sm @error('name') is-invalid @enderror" 
                                       value="{{ old('name') }}" placeholder="Contoh: PT. Pertamina" required>
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-12 col-md-4">
                                <label class="form-label fw-bold text-dark">Tipe Kerjasama</label>
                                <select name="type" class="form-select shadow-sm @error('type') is-invalid @enderror" required>
                                    <option value="">Pilih Tipe</option>
                                    <option value="Industri" {{ old('type') == 'Industri' ? 'selected' : '' }}>Industri</option>
                                    <option value="Akademik" {{ old('type') == 'Akademik' ? 'selected' : '' }}>Akademik</option>
                                    <option value="Pemerintah" {{ old('type') == 'Pemerintah' ? 'selected' : '' }}>Pemerintah</option>
                                </select>
                                @error('type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-12 col-sm-6 col-md-6">
                                <label class="form-label fw-bold text-dark">Tanggal Mulai</label>
                                <input type="date" name="start_date" value="{{ old('start_date') }}" class="form-control shadow-sm @error('start_date') is-invalid @enderror">
                                @error('start_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-12 col-sm-6 col-md-6">
                                <label class="form-label fw-bold text-dark">Tanggal Berakhir</label>
                                <input type="date" name="end_date" value="{{ old('end_date') }}" class="form-control shadow-sm @error('end_date') is-invalid @enderror">
                                @error('end_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                <div class="form-text">Kosongkan jika berlaku selamanya.</div>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold text-dark">Deskripsi Kerjasama</label>
                                <textarea name="description" class="form-control shadow-sm @error('description') is-invalid @enderror" rows="3">{{ old('description') }}</textarea>
                                @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <!-- Logo + Preview -->
                            <div class="col-12 col-md-7">
                                <label class="form-label fw-bold text-success"><i class="fas fa-image me-1"></i> Logo Mitra</label>
                                <div id="previewContainer" class="d-none mb-3 p-3 bg-light rounded border text-center shadow-sm" style="max-width: 150px;">
                                    <p class="small fw-bold text-success mb-2">Preview</p>
                                    <img id="imagePreview" src="#" class="rounded shadow-sm border border-success" width="100" height="100" style="object-fit: cover;">
                                </div>
                                <div class="input-group shadow-sm">
                                    <span class="input-group-text bg-light text-success"><i class="fas fa-upload"></i></span>
                                    <input type="file" name="logo" id="imageInput" class="form-control" accept="image/jpeg,image/png,image/webp">
                                </div>
                                <div class="form-text mt-2">
                                    <i class="fas fa-info-circle me-1"></i> Format JPG, JPEG, PNG, WEBP (Maks 2MB). Ukuran ideal 200x200px.
                                </div>
                            </div>

                            <div class="col-12 col-md-5">
                                <label class="form-label fw-bold text-dark">Pengaturan Publikasi</label>
                                <div class="p-3 rounded-3 border d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-2 mb-2">
                                    <div>
                                        <p class="mb-0 fw-bold small">Terbitkan Sekarang</p>
                                        <small class="text-muted" style="font-size: 0.7rem;">Kerjasama langsung tampil di halaman publik</small>
                                    </div>
                                    <div class="form-check form-switch mb-0">
                                        <input class="form-check-input" type="checkbox" name="active" value="1" id="active" checked
                                            style="width: 2.5em; height: 1.25em; cursor: pointer;">
                                    </div>
                                </div>
                                <div class="alert alert-info border-0 mb-0 py-2 px-3 mt-2" style="font-size: 0.75rem; border-radius: 8px;">
                                    <i class="fas fa-info-circle me-1"></i> Aktifkan agar Kerjasama ini langsung tampil di halaman publik.
                                </div>
                            </div>
                        </div>

                        <hr class="my-5">
                        <div class="d-flex flex-column flex-sm-row gap-2">
                            <button type="submit" class="btn btn-success px-4 py-2 shadow fw-bold w-100 w-sm-auto">
                                <i class="fas fa-paper-plane me-2"></i> Simpan Mitra
                            </button>
                            <a href="{{ route('cooperations.index') }}" class="btn btn-outline-secondary px-4 py-2 border-2 text-center w-100 w-sm-auto">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                Swal.fire({
                    icon: 'error',
                    title: 'Format Tidak Didukung',
                    text: 'Gunakan JPG, JPEG, PNG, atau WEBP.',
                    confirmButtonColor: '#198754'
                });
                this.value = '';
                previewContainer.classList.add('d-none');
                return;
            }

            if (file.size > maxSize) {
                Swal.fire({
                    icon: 'error',
                    title: 'File Terlalu Besar',
                    text: 'Ukuran maksimal 2MB.',
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
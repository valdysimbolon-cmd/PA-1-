@extends('layouts.admin')

@section('title', 'Edit Mitra')

@section('content')
<div class="container-fluid px-4 pb-5">
    <!-- Judul Halaman + Tombol Kembali -->
    <div class="d-flex justify-content-between align-items-center mt-4 mb-4">
        <div>
            <h1 class="h3 text-gray-800 mb-1">Edit Mitra Kerja Sama</h1>
            <p class="text-muted small mb-0">Perbarui informasi mitra dari <strong>{{ $cooperation->name }}</strong>.</p>
        </div>
        <a href="{{ route('cooperations.index') }}" class="btn btn-light border px-3 fw-bold small text-muted shadow-sm">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-sm border-0">
                <div class="card-header py-3 bg-success text-white">
                    <h6 class="m-0 font-weight-bold"><i class="fas fa-edit me-2"></i>Edit Detail Mitra</h6>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('cooperations.update', $cooperation->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf @method('PUT')
                        <div class="row g-4">
                            <div class="col-md-8">
                                <label class="form-label fw-bold text-dark">Nama Instansi / Perusahaan</label>
                                <input type="text" name="name" class="form-control shadow-sm" value="{{ old('name', $cooperation->name) }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold text-dark">Tipe Kerjasama</label>
                                <select name="type" class="form-select shadow-sm" required>
                                    <option value="Industri" {{ old('type', $cooperation->type) == 'Industri' ? 'selected' : '' }}>Industri</option>
                                    <option value="Akademik" {{ old('type', $cooperation->type) == 'Akademik' ? 'selected' : '' }}>Akademik</option>
                                    <option value="Pemerintah" {{ old('type', $cooperation->type) == 'Pemerintah' ? 'selected' : '' }}>Pemerintah</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark">Tanggal Mulai</label>
                                <input type="date" name="start_date" class="form-control shadow-sm" value="{{ old('start_date', $cooperation->start_date) }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark">Tanggal Berakhir</label>
                                <input type="date" name="end_date" class="form-control shadow-sm" value="{{ old('end_date', $cooperation->end_date) }}">
                                <div class="form-text">Kosongkan jika berlaku selamanya.</div>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold text-dark">Deskripsi Kerjasama</label>
                                <textarea name="description" class="form-control shadow-sm" rows="3">{{ old('description', $cooperation->description) }}</textarea>
                            </div>

                            <!-- Bagian Logo -->
                            <div class="col-md-7">
                                <label class="form-label fw-bold text-dark text-success"><i class="fas fa-image me-1"></i> Logo Mitra</label>
                                <div class="d-flex align-items-center gap-4 mb-3 p-3 bg-light rounded border shadow-sm">
                                    @if($cooperation->logo)
                                        <div id="oldLogoDiv" class="text-center">
                                            <p class="small fw-bold text-muted mb-1">Logo Saat Ini</p>
                                            <img src="{{ asset('storage/'.$cooperation->logo) }}" class="rounded shadow-sm border" width="100" height="100" style="object-fit: cover;">
                                        </div>
                                    @endif
                                    <div id="arrowIcon" class="text-muted d-none"><i class="fas fa-arrow-right fa-2x"></i></div>
                                    <div id="previewContainer" class="d-none text-center">
                                        <p class="small fw-bold text-success mb-1">Preview Baru</p>
                                        <img id="imagePreview" src="#" class="rounded shadow-sm border border-success" width="100" height="100" style="object-fit: cover;">
                                    </div>
                                </div>
                                <input type="file" name="logo" id="imageInput" class="form-control shadow-sm" accept="image/jpeg,image/png,image/webp">
                                <small class="text-muted mt-2 d-block">Abaikan jika tidak ingin mengganti logo.</small>
                            </div>

                                <div class="mb-4">
                                    <label class="form-label fw-bold text-dark mb-3">Pengaturan Publikasi</label>
                                    <div class="p-3 rounded-3 border d-flex align-items-center justify-content-between mb-2">
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
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success px-4 py-2 shadow fw-bold">
                                <i class="fas fa-paper-plane me-2"></i> Simpan Mitra
                            </button>
                            <a href="{{ route('cooperations.index') }}" class="btn btn-outline-secondary px-4 py-2 border-2">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    const imageInput = document.getElementById('imageInput');
    const imagePreview = document.getElementById('imagePreview');
    const previewContainer = document.getElementById('previewContainer');
    const arrowIcon = document.getElementById('arrowIcon');
    const oldLogoDiv = document.getElementById('oldLogoDiv');

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
                if(arrowIcon) arrowIcon.classList.add('d-none');
                if(oldLogoDiv) oldLogoDiv.classList.remove('d-none');
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
                if(arrowIcon) arrowIcon.classList.add('d-none');
                if(oldLogoDiv) oldLogoDiv.classList.remove('d-none');
                return;
            }

            const reader = new FileReader();
            reader.onload = function(event) {
                imagePreview.src = event.target.result;
                previewContainer.classList.remove('d-none');
                if(arrowIcon) arrowIcon.classList.remove('d-none');
                if(oldLogoDiv) oldLogoDiv.classList.add('d-none');
            };
            reader.readAsDataURL(file);
        } else {
            previewContainer.classList.add('d-none');
            if(arrowIcon) arrowIcon.classList.add('d-none');
            if(oldLogoDiv) oldLogoDiv.classList.remove('d-none');
        }
    });
</script>
@endpush
@endsection
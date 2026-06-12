@extends('layouts.admin')

@section('title', 'Tambah Prestasi Baru')

@section('content')
<div class="container-fluid px-3 px-md-4 pb-5">
    <!-- Judul Halaman + Tombol Kembali -->
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mt-4 mb-4">
        <div>
            <h1 class="h3 text-gray-800 mb-1">Tambah Prestasi</h1>
            <p class="text-muted small mb-0">Input data prestasi mahasiswa atau dosen.</p>
        </div>
        <a href="{{ route('achievements.index') }}" class="btn btn-light border px-3 fw-bold small text-muted shadow-sm">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-12 col-lg-10">
            <div class="card shadow-sm border-0">
                <div class="card-header py-3 bg-success text-white">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-trophy me-2"></i>Formulir Prestasi Baru
                    </h6>
                </div>
                <div class="card-body p-3 p-md-4">
                    <form action="{{ route('achievements.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row g-3">
                            <!-- Baris 1: Kategori, Tingkat, Tahun | Judul -->
                            <div class="col-sm-6 col-md-2">
                                <label class="form-label fw-bold text-dark">Kategori</label>
                                <select name="category" class="form-select shadow-sm @error('category') is-invalid @enderror" required>
                                    <option value="students" {{ old('category') == 'students' ? 'selected' : '' }}>Mahasiswa</option>
                                    <option value="lecturers" {{ old('category') == 'lecturers' ? 'selected' : '' }}>Dosen</option>
                                </select>
                                @error('category') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-sm-6 col-md-2">
                                <label class="form-label fw-bold text-dark">Tingkat</label>
                                <select name="level" class="form-select shadow-sm @error('level') is-invalid @enderror" required>
                                    <option value="Regional" {{ old('level') == 'Regional' ? 'selected' : '' }}>Regional</option>
                                    <option value="Nasional" {{ old('level') == 'Nasional' ? 'selected' : '' }}>Nasional</option>
                                    <option value="Internasional" {{ old('level') == 'Internasional' ? 'selected' : '' }}>Internasional</option>
                                </select>
                                @error('level') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-sm-6 col-md-2">
                                <label class="form-label fw-bold text-dark">Tahun</label>
                                <input type="number" name="year" class="form-control shadow-sm @error('year') is-invalid @enderror"
                                       value="{{ old('year', date('Y')) }}" required>
                                @error('year') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <label class="form-label fw-bold text-dark">Judul Prestasi / Kompetisi</label>
                                <input type="text" name="title" class="form-control shadow-sm @error('title') is-invalid @enderror"
                                       value="{{ old('title') }}" placeholder="Contoh: Juara 1 Nasional LKTI" required>
                                @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <!-- Baris 2: Nama Pemenang -->
                            <div class="col-12 col-md-6">
                                <label class="form-label fw-bold text-dark">Nama Pemenang</label>
                                <input type="text" name="winner_name" class="form-control shadow-sm @error('winner_name') is-invalid @enderror"
                                       value="{{ old('winner_name') }}" placeholder="Contoh: Tim Biopros A / Nama Individu" required>
                                @error('winner_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <!-- kolom kosong tidak perlu, dihapus -->

                            <!-- Baris 3: Peringkat & Deskripsi -->
                            <div class="col-12 col-md-6">
                                <label class="form-label fw-bold text-dark">Peringkat / Rank</label>
                                <input type="text" name="rank" class="form-control shadow-sm" value="{{ old('rank') }}" placeholder="Contoh: Juara 1 / Gold Medal">
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold text-dark">Keterangan / Deskripsi</label>
                                <textarea name="description" class="form-control shadow-sm" rows="3">{{ old('description') }}</textarea>
                            </div>

                            <!-- Foto Dokumentasi & Pengaturan Publikasi -->
                            <div class="col-12 col-md-7">
                                <label class="form-label fw-bold text-success">
                                    <i class="fas fa-image me-1"></i> Foto Dokumentasi
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
                                    <small><i class="fas fa-info-circle me-1"></i>Format JPG, PNG, WEBP (Maks 2MB).</small>
                                </div>
                            </div>

                            <div class="col-12 col-md-5">
                                <label class="form-label fw-bold text-dark">Pengaturan Publikasi</label>
                                <div class="p-3 rounded-3 border d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-2 mb-2">
                                    <div>
                                        <p class="mb-0 fw-bold small">Terbitkan Sekarang</p>
                                        <small class="text-muted" style="font-size: 0.7rem;">Prestasi langsung tampil di halaman publik</small>
                                    </div>
                                    <div class="form-check form-switch mb-0">
                                        <input class="form-check-input" type="checkbox" name="active" value="1" id="active" checked
                                            style="width: 2.5em; height: 1.25em; cursor: pointer;">
                                    </div>
                                </div>
                                <div class="alert alert-info border-0 mb-0 py-2 px-3" style="font-size: 0.75rem; border-radius: 8px;">
                                    <i class="fas fa-info-circle me-1"></i> Aktifkan agar Prestasi ini langsung tampil di halaman publik.
                                </div>
                            </div>
                        </div>

                        <!-- Personel Terkait -->
                        <div class="card border shadow-sm mt-4">
                            <div class="card-header bg-light">
                                <h6 class="m-0 font-weight-bold text-dark">
                                    <i class="fas fa-users me-2"></i>Personel Terkait (Opsional)
                                </h6>
                            </div>
                            <div class="card-body">
                                <div id="member-container"></div>
                                <button type="button" class="btn btn-sm btn-success mt-2" id="add-member">
                                    <i class="fas fa-plus me-1"></i> Tambah Personel
                                </button>
                                <div class="form-text mt-2">Hubungkan dengan database mahasiswa/dosen agar prestasi muncul di profil mereka.</div>
                            </div>
                        </div>

                        <hr class="my-5">
                        <div class="d-flex flex-column flex-sm-row gap-2 justify-content-start">
                            <button type="submit" class="btn btn-success px-4 py-2 shadow fw-bold w-100 w-sm-auto">
                                <i class="fas fa-paper-plane me-2"></i> Simpan Prestasi
                            </button>
                            <a href="{{ route('achievements.index') }}" class="btn btn-outline-secondary px-4 py-2 border-2 text-center w-100 w-sm-auto">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<template id="member-row-template">
    <div class="row member-row mb-2 align-items-end">
        <div class="col-12 col-sm-4 col-md-3 mb-2 mb-sm-0">
            <select name="member_types[]" class="form-select form-select-sm bg-light border">
                <option value="Student">Mahasiswa</option>
                <option value="Lecturer">Dosen</option>
            </select>
        </div>
        <div class="col-12 col-sm-5 col-md-5 mb-2 mb-sm-0">
            <select name="member_ids[]" class="form-select form-select-sm bg-light border">
                <option value="">-- Pilih --</option>
                <optgroup label="Mahasiswa">
                    @foreach($students as $s) <option value="{{ $s->id }}">{{ $s->name }} ({{ $s->nim ?? '-' }})</option> @endforeach
                </optgroup>
                <optgroup label="Dosen">
                    @foreach($lecturers as $l) <option value="{{ $l->id }}">{{ $l->name }}</option> @endforeach
                </optgroup>
            </select>
        </div>
        <div class="col-9 col-sm-3 col-md-3">
            <input type="text" name="roles[]" class="form-control form-control-sm bg-light border" placeholder="Peran (Ketua, Anggota)">
        </div>
        <div class="col-3 col-sm-1 col-md-1 text-end">
            <button type="button" class="btn btn-sm btn-outline-danger remove-member w-100"><i class="fas fa-trash-alt"></i></button>
        </div>
    </div>
</template>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const container = document.getElementById('member-container');
    const template = document.getElementById('member-row-template');
    document.getElementById('add-member').addEventListener('click', () => {
        container.appendChild(template.content.cloneNode(true));
    });
    container.addEventListener('click', (e) => {
        if (e.target.classList.contains('remove-member') || e.target.closest('.remove-member')) {
            e.target.closest('.member-row').remove();
        }
    });

    const imageInput = document.getElementById('imageInput');
    const imagePreview = document.getElementById('imagePreview');
    const previewContainer = document.getElementById('previewContainer');
    imageInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const allowed = ['image/jpeg', 'image/png', 'image/webp'];
            const maxSize = 2 * 1024 * 1024;
            if (!allowed.includes(file.type)) {
                Swal.fire({ icon: 'error', title: 'Format Tidak Didukung', text: 'Gunakan JPG, PNG, WEBP.', confirmButtonColor: '#198754' });
                this.value = '';
                previewContainer.classList.add('d-none');
                return;
            }
            if (file.size > maxSize) {
                Swal.fire({ icon: 'error', title: 'File Terlalu Besar', text: 'Maksimal 2MB.', confirmButtonColor: '#198754' });
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
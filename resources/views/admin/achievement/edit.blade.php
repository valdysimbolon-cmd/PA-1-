@extends('layouts.admin')

@section('title', 'Edit Prestasi')

@section('content')
<div class="container-fluid px-3 px-md-4 pb-5">
    <!-- Judul + Tombol Kembali -->
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mt-4 mb-4">
        <div>
            <h1 class="h3 text-gray-800 mb-1">Edit Prestasi</h1>
            <p class="text-muted small mb-0">
                Perbarui data: <strong>{{ $achievement->title }}</strong>
            </p>
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
                        <i class="fas fa-edit me-2"></i>Edit Detail Prestasi
                    </h6>
                </div>
                <div class="card-body p-3 p-md-4">
                    <form action="{{ route('achievements.update', $achievement->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf @method('PUT')

                        <div class="row g-3">
                            <!-- Baris 1: Kategori, Tingkat, Tahun, Judul -->
                            <div class="col-sm-6 col-md-2">
                                <label class="form-label fw-bold text-dark">Kategori</label>
                                <select name="category" class="form-select shadow-sm @error('category') is-invalid @enderror">
                                    <option value="students" {{ old('category', $achievement->category) == 'students' ? 'selected' : '' }}>Mahasiswa</option>
                                    <option value="lecturers" {{ old('category', $achievement->category) == 'lecturers' ? 'selected' : '' }}>Dosen</option>
                                </select>
                                @error('category') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-sm-6 col-md-2">
                                <label class="form-label fw-bold text-dark">Tingkat</label>
                                <select name="level" class="form-select shadow-sm @error('level') is-invalid @enderror">
                                    @foreach(['Regional','Nasional','Internasional'] as $lvl)
                                        <option value="{{ $lvl }}" {{ old('level', $achievement->level) == $lvl ? 'selected' : '' }}>{{ $lvl }}</option>
                                    @endforeach
                                </select>
                                @error('level') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-sm-6 col-md-2">
                                <label class="form-label fw-bold text-dark">Tahun</label>
                                <input type="number" name="year" class="form-control shadow-sm @error('year') is-invalid @enderror"
                                       value="{{ old('year', $achievement->year) }}" required>
                                @error('year') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label fw-bold text-dark">Judul Prestasi / Kompetisi</label>
                                <input type="text" name="title" class="form-control shadow-sm @error('title') is-invalid @enderror"
                                       value="{{ old('title', $achievement->title) }}" required>
                                @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <!-- Baris 2: Nama Pemenang -->
                            <div class="col-12 col-md-6">
                                <label class="form-label fw-bold text-dark">Nama Pemenang</label>
                                <input type="text" name="winner_name" class="form-control shadow-sm @error('winner_name') is-invalid @enderror"
                                       value="{{ old('winner_name', $achievement->winner_name) }}" required>
                                @error('winner_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <!-- Baris 3: Peringkat & Deskripsi -->
                            <div class="col-12 col-md-6">
                                <label class="form-label fw-bold text-dark">Peringkat / Rank</label>
                                <input type="text" name="rank" class="form-control shadow-sm" value="{{ old('rank', $achievement->rank) }}" placeholder="Contoh: Juara 1 / Gold Medal">
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold text-dark">Keterangan / Deskripsi</label>
                                <textarea name="description" class="form-control shadow-sm" rows="3">{{ old('description', $achievement->description) }}</textarea>
                            </div>

                            <!-- Foto Dokumentasi & Pengaturan Publikasi -->
                            <div class="col-12 col-md-7">
                                <label class="form-label fw-bold text-success">
                                    <i class="fas fa-image me-1"></i> Foto Dokumentasi
                                </label>
                                <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center gap-3 mb-3 p-3 bg-light rounded border shadow-sm">
                                    @if($achievement->image)
                                        <div id="oldImageDiv" class="text-center">
                                            <p class="small fw-bold text-muted mb-1">Foto Saat Ini</p>
                                            <img src="{{ asset('storage/'.$achievement->image) }}" class="rounded shadow-sm border" width="100" height="100" style="object-fit: cover;">
                                        </div>
                                    @endif
                                    <div id="arrowIcon" class="text-muted d-none"><i class="fas fa-arrow-right fa-2x"></i></div>
                                    <div id="previewContainer" class="d-none text-center">
                                        <p class="small fw-bold text-success mb-1">Preview Baru</p>
                                        <img id="imagePreview" src="#" class="rounded shadow-sm border border-success" width="100" height="100" style="object-fit: cover;">
                                    </div>
                                </div>
                                <input type="file" name="image" id="imageInput" class="form-control shadow-sm" accept="image/jpeg,image/png,image/webp">
                                <div class="form-text mt-2">
                                    <small><i class="fas fa-info-circle me-1"></i>Format JPG, PNG, WEBP (Maks 2MB).</small>
                                </div>
                                <small class="text-muted mt-2 d-block">Abaikan jika tidak ingin mengganti foto.</small>
                            </div>

                            <div class="col-12 col-md-5">
                                <label class="form-label fw-bold text-dark">Pengaturan Publikasi</label>
                                <div class="p-3 rounded-3 border d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-2 mb-2">
                                    <div>
                                        <p class="mb-0 fw-bold small">Terbitkan Sekarang</p>
                                        <small class="text-muted" style="font-size: 0.7rem;">Prestasi langsung tampil di halaman publik</small>
                                    </div>
                                    <div class="form-check form-switch mb-0">
                                        <input class="form-check-input" type="checkbox" name="active" value="1" id="active"
                                            {{ old('active', $achievement->active) ? 'checked' : '' }}
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
                                    <i class="fas fa-users me-2"></i>Personel Terkait
                                </h6>
                            </div>
                            <div class="card-body">
                                <div id="member-container">
                                    @foreach($achievement->members as $m)
                                    <div class="row member-row mb-3 align-items-start align-items-sm-end">
                                        <div class="col-12 col-sm-4 col-md-3 mb-2 mb-sm-0">
                                            <select name="member_types[]" class="form-select form-select-sm bg-light border">
                                                <option value="Student" {{ $m->member_type == 'Student' ? 'selected' : '' }}>Mahasiswa</option>
                                                <option value="Lecturer" {{ $m->member_type == 'Lecturer' ? 'selected' : '' }}>Dosen</option>
                                            </select>
                                        </div>
                                        <div class="col-12 col-sm-5 col-md-5 mb-2 mb-sm-0">
                                            <select name="member_ids[]" class="form-select form-select-sm bg-light border">
                                                <optgroup label="Mahasiswa">
                                                    @foreach($students as $s)
                                                        <option value="{{ $s->id }}" {{ ($m->member_id == $s->id && $m->member_type == 'Student') ? 'selected' : '' }}>{{ $s->name }} ({{ $s->nim ?? '-' }})</option>
                                                    @endforeach
                                                </optgroup>
                                                <optgroup label="Dosen">
                                                    @foreach($lecturers as $l)
                                                        <option value="{{ $l->id }}" {{ ($m->member_id == $l->id && $m->member_type == 'Lecturer') ? 'selected' : '' }}>{{ $l->name }}</option>
                                                    @endforeach
                                                </optgroup>
                                            </select>
                                        </div>
                                        <div class="col-9 col-sm-3 col-md-3">
                                            <input type="text" name="roles[]" class="form-control form-control-sm bg-light border" value="{{ $m->role }}" placeholder="Peran">
                                        </div>
                                        <div class="col-3 col-sm-1 col-md-1 text-end">
                                            <button type="button" class="btn btn-sm btn-outline-danger remove-member w-100"><i class="fas fa-trash-alt"></i></button>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                <button type="button" class="btn btn-sm btn-success mt-2" id="add-member">
                                    <i class="fas fa-plus me-1"></i> Tambah Personel
                                </button>
                                <div class="form-text mt-2">Hubungkan dengan database mahasiswa/dosen agar prestasi muncul di profil mereka.</div>
                            </div>
                        </div>

                        <hr class="my-5">
                        <div class="d-flex flex-column flex-sm-row gap-2">
                            <button type="submit" class="btn btn-success px-4 py-2 shadow fw-bold w-100 w-sm-auto">
                                <i class="fas fa-paper-plane me-2"></i> Simpan Perubahan
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
    <div class="row member-row mb-3 align-items-start align-items-sm-end">
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
            <input type="text" name="roles[]" class="form-control form-control-sm bg-light border" placeholder="Peran">
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
    // (script sama seperti aslinya, tidak perlu diubah)
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
    const arrowIcon = document.getElementById('arrowIcon');
    const oldImageDiv = document.getElementById('oldImageDiv');

    imageInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const allowed = ['image/jpeg', 'image/png', 'image/webp'];
            const maxSize = 2 * 1024 * 1024;
            if (!allowed.includes(file.type)) {
                Swal.fire({ icon: 'error', title: 'Format Tidak Didukung', text: 'Gunakan JPG, PNG, WEBP.', confirmButtonColor: '#198754' });
                this.value = '';
                previewContainer.classList.add('d-none');
                if(arrowIcon) arrowIcon.classList.add('d-none');
                if(oldImageDiv) oldImageDiv.classList.remove('d-none');
                return;
            }
            if (file.size > maxSize) {
                Swal.fire({ icon: 'error', title: 'File Terlalu Besar', text: 'Maksimal 2MB.', confirmButtonColor: '#198754' });
                this.value = '';
                previewContainer.classList.add('d-none');
                if(arrowIcon) arrowIcon.classList.add('d-none');
                if(oldImageDiv) oldImageDiv.classList.remove('d-none');
                return;
            }
            const reader = new FileReader();
            reader.onload = function(ev) {
                imagePreview.src = ev.target.result;
                previewContainer.classList.remove('d-none');
                if(arrowIcon) arrowIcon.classList.remove('d-none');
                if(oldImageDiv) oldImageDiv.classList.add('d-none');
            };
            reader.readAsDataURL(file);
        } else {
            previewContainer.classList.add('d-none');
            if(arrowIcon) arrowIcon.classList.add('d-none');
            if(oldImageDiv) oldImageDiv.classList.remove('d-none');
        }
    });
</script>
@endpush
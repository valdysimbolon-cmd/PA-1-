@extends('layouts.admin')

@section('title', 'Tambah Prestasi Baru')

@section('content')
<div class="container-fluid px-3 px-md-4 pb-5">
    <!-- Header -->
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mt-4 mb-4">
        <div>
            <h1 class="h3 text-gray-800 mb-1">Tambah Prestasi</h1>
            <p class="text-muted small mb-0">Input data prestasi mahasiswa atau dosen.</p>
        </div>
        <a href="{{ route('achievements.index') }}" class="btn btn-light border px-3 fw-bold small text-muted shadow-sm">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <form action="{{ route('achievements.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row g-4">
            <!-- KOLOM KIRI: DATA UTAMA -->
            <div class="col-12 col-lg-8">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header py-3 bg-success text-white">
                        <h6 class="m-0 font-weight-bold"><i class="fas fa-trophy me-2"></i>Detail Prestasi</h6>
                    </div>
                    <div class="card-body p-3 p-md-4">
                        <div class="row g-3 mb-3">
                            <div class="col-12 col-md-3">
                                <label class="form-label fw-bold text-dark">Kategori <span class="text-danger">*</span></label>
                                <select name="category" class="form-select form-control-custom @error('category') is-invalid @enderror" required>
                                    <option value="student" {{ old('category') == 'student' ? 'selected' : '' }}>Mahasiswa</option>
                                    <option value="lecturer" {{ old('category') == 'lecturer' ? 'selected' : '' }}>Dosen</option>
                                </select>
                                @error('category') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-12 col-md-3">
                                <label class="form-label fw-bold text-dark">Tingkat <span class="text-danger">*</span></label>
                                <select name="level" class="form-select form-control-custom @error('level') is-invalid @enderror" required>
                                    <option value="Regional" {{ old('level') == 'Regional' ? 'selected' : '' }}>Regional</option>
                                    <option value="Nasional" {{ old('level') == 'Nasional' ? 'selected' : '' }}>Nasional</option>
                                    <option value="Internasional" {{ old('level') == 'Internasional' ? 'selected' : '' }}>Internasional</option>
                                </select>
                                @error('level') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-12 col-md-3">
                                <label class="form-label fw-bold text-dark">Tahun <span class="text-danger">*</span></label>
                                <input type="number" name="year" class="form-control form-control-custom @error('year') is-invalid @enderror"
                                       value="{{ old('year', date('Y')) }}" required>
                                @error('year') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-12 col-md-3">
                                <label class="form-label fw-bold text-dark">Peringkat / Rank</label>
                                <input type="text" name="rank" class="form-control form-control-custom" value="{{ old('rank') }}" placeholder="Juara 1 / Gold">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark">Judul Prestasi / Kompetisi <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control form-control-custom @error('title') is-invalid @enderror"
                                   value="{{ old('title') }}" placeholder="Contoh: Juara 1 Nasional LKTI" required>
                            @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark">Nama Pemenang <span class="text-danger">*</span></label>
                            <input type="text" name="winner_name" class="form-control form-control-custom @error('winner_name') is-invalid @enderror"
                                   value="{{ old('winner_name') }}" placeholder="Tim Biopros A / Nama Individu" required>
                            @error('winner_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark">Keterangan / Deskripsi</label>
                            <textarea name="description" class="form-control form-control-custom" rows="3">{{ old('description') }}</textarea>
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
                    </div>
                </div>
            </div>

            <!-- KOLOM KANAN: GAMBAR & PUBLIKASI -->
            <div class="col-12 col-lg-4">
                <div class="card shadow-sm border-0 sticky-top" style="top: 80px;">
                    <div class="card-header bg-success py-3">
                        <h6 class="m-0 font-weight-bold text-white"><i class="fas fa-cog me-2"></i>Gambar & Publikasi</h6>
                    </div>
                    <div class="card-body p-3 p-md-4">
                        <!-- Upload Gambar -->
                        <div class="mb-4">
                            <label class="form-label fw-bold text-dark"><i class="fas fa-image me-1 text-success"></i> Foto Dokumentasi</label>
                            <div id="previewContainer" class="d-none mb-3 text-center">
                                <img id="imagePreview" src="#" class="rounded shadow-sm border border-success" width="120" height="120" style="object-fit: cover;">
                                <small class="text-success fw-bold d-block mt-1" style="font-size:0.72rem;"><i class="fas fa-check-circle me-1"></i> Gambar siap</small>
                            </div>

                            <div id="uploadPlaceholder" class="upload-area">
                                <i class="fas fa-cloud-upload-alt upload-icon text-success"></i>
                                <span class="upload-text">Pilih foto</span>
                                <span class="upload-hint">JPG, JPEG, PNG, WEBP (maks 2MB)</span>
                                <input type="file" name="image" id="imageInput" class="upload-input" accept="image/jpeg,image/png,image/webp">
                            </div>
                            <div class="form-text mt-2">
                                <i class="fas fa-info-circle me-1"></i> Ukuran ideal: 800x600px.
                            </div>
                        </div>

                        <!-- Publikasi -->
                        <div class="mb-4">
                            <label class="form-label fw-bold text-dark">Publikasi</label>
                            <div class="publish-toggle">
                                <div>
                                    <p class="mb-0 fw-bold small">Terbitkan Sekarang</p>
                                    <small class="text-muted" style="font-size:0.7rem;">Tampilkan di halaman depan</small>
                                </div>
                                <div class="form-check form-switch mb-0">
                                    <input class="form-check-input" type="checkbox" name="active" value="1" id="active" checked style="width:2.5em;height:1.25em;cursor:pointer;">
                                </div>
                            </div>
                            <div class="alert alert-info border-0 mt-2 py-2 px-3 small" style="border-radius: 8px; font-size:0.75rem;">
                                <i class="fas fa-info-circle me-1"></i> Aktifkan agar prestasi langsung tampil di halaman publik.
                            </div>
                        </div>

                        <hr class="my-3">
                        <div class="d-flex flex-column gap-2">
                            <button type="submit" class="btn-submit-main">
                                <i class="fas fa-save me-2"></i> Simpan Prestasi
                            </button>
                            <a href="{{ route('achievements.index') }}" class="btn btn-outline-secondary py-2 text-center" style="border-radius: 9px; font-size: 0.9rem; font-weight: 600;">Batal</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Template Personel -->
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
    // Personel dinamis
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

    // Preview gambar
    const imageInput = document.getElementById('imageInput');
    const imagePreview = document.getElementById('imagePreview');
    const previewContainer = document.getElementById('previewContainer');
    const uploadPlaceholder = document.getElementById('uploadPlaceholder');

    imageInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const allowed = ['image/jpeg', 'image/png', 'image/webp'];
            if (!allowed.includes(file.type) || file.size > 2 * 1024 * 1024) {
                Swal.fire({
                    icon: 'error',
                    title: 'File Tidak Valid',
                    text: 'Gunakan JPG/PNG/WEBP maks 2MB.',
                    confirmButtonColor: '#198754'
                });
                this.value = '';
                previewContainer.classList.add('d-none');
                uploadPlaceholder.classList.remove('d-none');
                return;
            }
            const reader = new FileReader();
            reader.onload = function(ev) {
                imagePreview.src = ev.target.result;
                previewContainer.classList.remove('d-none');
                uploadPlaceholder.classList.add('d-none');
            };
            reader.readAsDataURL(file);
        } else {
            previewContainer.classList.add('d-none');
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
</style>
@endpush
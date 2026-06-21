@extends('layouts.admin')

@section('title', 'Edit Unit Laboratorium')

@section('content')
<div class="container-fluid px-3 px-md-4 pb-5">
    <!-- Header -->
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mt-4 mb-4">
        <div>
            <h1 class="h3 text-gray-800 mb-1">Edit Unit Laboratorium</h1>
            <p class="text-muted small mb-0">Perbarui data laboratorium: <strong>{{ $lab->name }}</strong></p>
        </div>
        <a href="{{ route('labs.index') }}" class="btn btn-light border px-3 fw-bold small text-muted shadow-sm">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <form action="{{ route('labs.update', $lab->id) }}" method="POST" enctype="multipart/form-data" id="labForm">
        @csrf
        @method('PUT')
        <div class="row g-4">
            <!-- KOLOM KIRI: DATA UTAMA & KATALOG ALAT -->
            <div class="col-12 col-lg-8">
                <!-- CARD 1: IDENTITAS LAB -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header py-3 bg-success text-white">
                        <h6 class="m-0 font-weight-bold"><i class="fas fa-microscope me-2"></i>Identitas Utama Laboratorium</h6>
                    </div>
                    <div class="card-body p-3 p-md-4">
                        <div class="mb-4">
                            <label class="form-label fw-bold text-dark">Nama Laboratorium <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control shadow-sm @error('name') is-invalid @enderror" 
                                   value="{{ old('name', $lab->name) }}" placeholder="Contoh: Lab Bioproses & Fermentasi" required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="row mb-4 g-3">
                            <div class="col-12 col-sm-6">
                                <label class="form-label fw-bold text-dark">Kategori</label>
                                <select name="category" class="form-select shadow-sm">
                                    <option value="Praktikum" {{ old('category', $lab->category) == 'Praktikum' ? 'selected' : '' }}>Praktikum</option>
                                    <option value="Riset" {{ old('category', $lab->category) == 'Riset' ? 'selected' : '' }}>Riset</option>
                                    <option value="Umum" {{ old('category', $lab->category) == 'Umum' ? 'selected' : '' }}>Umum</option>
                                </select>
                            </div>
                            <div class="col-12 col-sm-6">
                                <label class="form-label fw-bold text-dark">Lokasi / Ruangan</label>
                                <input type="text" name="location" class="form-control shadow-sm" 
                                       value="{{ old('location', $lab->location) }}" placeholder="Gedung 5 Lantai 2">
                            </div>
                        </div>

                        <div class="row mb-4 g-3">
                            <div class="col-12 col-sm-6">
                                <label class="form-label fw-bold text-dark">Kepala Lab (Dosen)</label>
                                <select name="head_of_lab_id" class="form-select shadow-sm">
                                    <option value="">-- Pilih Dosen --</option>
                                    @foreach($lecturers as $l)
                                        <option value="{{ $l->id }}" {{ old('head_of_lab_id', $lab->head_of_lab_id) == $l->id ? 'selected' : '' }}>{{ $l->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 col-sm-6">
                                <label class="form-label fw-bold text-dark">Staf Laboran (PIC)</label>
                                <select name="staff_id" class="form-select shadow-sm">
                                    <option value="">-- Pilih Staf --</option>
                                    @foreach($staffs as $s)
                                        <option value="{{ $s->id }}" {{ old('staff_id', $lab->staff_id) == $s->id ? 'selected' : '' }}>{{ $s->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mb-0">
                            <label class="form-label fw-bold text-dark">Profil & Deskripsi Lab</label>
                            <textarea name="description" id="editor" class="form-control shadow-sm">{{ old('description', $lab->description) }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- CARD 2: KATALOG ALAT (DYNAMIC REPEATER) -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-success py-3 d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-2">
                        <h6 class="m-0 font-weight-bold text-white"><i class="fas fa-inventorys me-2"></i>Katalog Peralatan Laboratorium</h6>
                        <button type="button" class="btn btn-sm btn-light fw-bold" id="add-inventory">
                            <i class="fas fa-plus me-1"></i> Tambah Alat
                        </button>
                    </div>
                    <div class="card-body p-3 p-md-4 bg-light">
                        <div id="inventory-container">
                            @forelse($lab->inventories as $index => $inventory)
                            <div class="inventory-item bg-white p-3 rounded border shadow-sm mb-3 position-relative">
                                <button type="button" class="btn btn-danger btn-sm rounded-circle position-absolute remove-inventory" 
                                        style="top: -10px; right: -10px; width: 25px; height: 25px; padding: 0;">
                                    <i class="fas fa-times"></i>
                                </button>
                                <div class="row g-3">
                                    <div class="col-12 col-md-4">
                                        <label class="small fw-bold text-dark">Nama Alat</label>
                                        <input type="text" name="inventory_name[]" class="form-control form-control-sm shadow-sm" 
                                               value="{{ old('inventory_name.'.$index, $inventory->name) }}" placeholder="Contoh: Mikroskop Binokuler" required>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <label class="small fw-bold text-dark">Foto Alat</label>
                                        @if($inventory->image)
                                            <div class="mb-1">
                                                <img src="{{ asset('storage/'.$inventory->image) }}" class="img-thumbnail" style="max-height: 60px;">
                                            </div>
                                        @endif
                                        <input type="file" name="inventory_image[]" class="form-control form-control-sm" accept="image/jpeg,image/png,image/webp">
                                        <input type="hidden" name="inventory_existing_image[]" value="{{ $inventory->image }}">
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <label class="small fw-bold text-dark">Deskripsi Singkat</label>
                                        <input type="text" name="inventory_description[]" class="form-control form-control-sm shadow-sm" 
                                               value="{{ old('inventory_description.'.$index, $inventory->description) }}" placeholder="Contoh: Perbesaran 1000x">
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="inventory-item bg-white p-3 rounded border shadow-sm mb-3 position-relative">
                                <button type="button" class="btn btn-danger btn-sm rounded-circle position-absolute remove-inventory" 
                                        style="top: -10px; right: -10px; width: 25px; height: 25px; padding: 0;">
                                    <i class="fas fa-times"></i>
                                </button>
                                <div class="row g-3">
                                    <div class="col-12 col-md-4">
                                        <label class="small fw-bold text-dark">Nama Alat</label>
                                        <input type="text" name="inventory_name[]" class="form-control form-control-sm shadow-sm" placeholder="Contoh: Mikroskop Binokuler" required>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <label class="small fw-bold text-dark">Foto Alat</label>
                                        <input type="file" name="inventory_image[]" class="form-control form-control-sm" accept="image/jpeg,image/png,image/webp">
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <label class="small fw-bold text-dark">Deskripsi Singkat</label>
                                        <input type="text" name="inventory_description[]" class="form-control form-control-sm shadow-sm" placeholder="Contoh: Perbesaran 1000x">
                                    </div>
                                </div>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- KOLOM KANAN: MEDIA & STATUS -->
            <div class="col-12 col-lg-4">
                <div class="card shadow-sm border-0 sticky-top" style="top: 20px;">
                    <div class="card-header bg-success py-3">
                        <h6 class="m-0 font-weight-bold text-white"><i class="fas fa-cog me-2"></i>Pengaturan & Media</h6>
                    </div>
                    <div class="card-body p-3 p-md-4">
                        <div class="mb-4">
                            <label class="form-label fw-bold text-success"><i class="fas fa-image me-1"></i> Banner Lab</label>
                            @if($lab->image)
                                <div class="mb-3 text-center">
                                    <img src="{{ asset('storage/'.$lab->image) }}" class="img-fluid rounded shadow-sm border" style="max-height: 120px;">
                                    <p class="small text-muted mt-1">Gambar saat ini</p>
                                </div>
                            @endif
                            <div id="previewContainer" class="d-none mb-3 p-2 bg-light rounded border text-center">
                                <p class="small fw-bold text-success mb-1">Preview Baru</p>
                                <img id="imagePreview" src="#" class="img-fluid rounded shadow-sm" style="max-height: 150px; object-fit: cover;">
                            </div>
                            <div class="input-group shadow-sm">
                                <span class="input-group-text bg-light text-success"><i class="fas fa-upload"></i></span>
                                <input type="file" name="image" id="imageInput" class="form-control" accept="image/jpeg,image/png,image/webp">
                            </div>
                            <div class="form-text mt-2">
                                <i class="fas fa-info-circle me-1"></i> Format JPG, PNG, WEBP (Maks 2MB). Kosongkan jika tidak ingin mengganti.
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold text-dark mb-3">Pengaturan Publikasi</label>
                            <div class="p-3 rounded-3 border d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-2 mb-2">
                                <div>
                                    <p class="mb-0 fw-bold small">Terbitkan Sekarang</p>
                                    <small class="text-muted" style="font-size: 0.7rem;">Laboratorium langsung tampil di halaman publik</small>
                                </div>
                                <div class="form-check form-switch mb-0">
                                    <input class="form-check-input" type="checkbox" name="active" value="1" id="active" 
                                           {{ old('active', $lab->active) ? 'checked' : '' }}
                                           style="width: 2.5em; height: 1.25em; cursor: pointer;">
                                </div>
                            </div>
                            <div class="alert alert-info border-0 mb-0 py-2 px-3 mt-2" style="font-size: 0.75rem; border-radius: 8px;">
                                <i class="fas fa-info-circle me-1"></i> Aktifkan agar Laboratorium ini langsung tampil di halaman publik.
                            </div>
                        </div>

                        <hr class="my-4">
                        <div class="d-flex flex-column flex-sm-row gap-2">
                            <button type="submit" class="btn btn-success px-4 py-2 shadow fw-bold w-100 w-sm-auto">
                                <i class="fas fa-save me-2"></i> Perbarui Laboratorium
                            </button>
                            <a href="{{ route('labs.index') }}" class="btn btn-outline-secondary px-4 py-2 border-2 text-center w-100 w-sm-auto">Batal</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Template untuk baris alat baru (responsive) -->
<template id="inventory-template">
    <div class="inventory-item bg-white p-3 rounded border shadow-sm mb-3 position-relative">
        <button type="button" class="btn btn-danger btn-sm rounded-circle position-absolute remove-inventory" 
                style="top: -10px; right: -10px; width: 25px; height: 25px; padding: 0;">
            <i class="fas fa-times"></i>
        </button>
        <div class="row g-3">
            <div class="col-12 col-md-4">
                <label class="small fw-bold text-dark">Nama Alat</label>
                <input type="text" name="inventory_name[]" class="form-control form-control-sm shadow-sm" placeholder="Contoh: Mikroskop Binokuler" required>
            </div>
            <div class="col-12 col-md-4">
                <label class="small fw-bold text-dark">Foto Alat</label>
                <input type="file" name="inventory_image[]" class="form-control form-control-sm" accept="image/jpeg,image/png,image/webp">
            </div>
            <div class="col-12 col-md-4">
                <label class="small fw-bold text-dark">Deskripsi Singkat</label>
                <input type="text" name="inventory_description[]" class="form-control form-control-sm shadow-sm" placeholder="Contoh: Perbesaran 1000x">
            </div>
        </div>
    </div>
</template>
@endsection

@push('scripts')
<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    CKEDITOR.replace('editor', {
        height: 350,
        inventorybar: [
            { name: 'basicstyles', items: ['Bold','Italic','Underline'] },
            { name: 'paragraph', items: ['NumberedList','BulletedList','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'] },
            { name: 'links', items: ['Link','Unlink'] },
            { name: 'inventorys', items: ['Undo','Redo'] }
        ]
    });

    const addinventoryBtn = document.getElementById('add-inventory');
    const inventoryContainer = document.getElementById('inventory-container');
    const inventoryTemplate = document.getElementById('inventory-template');

    function addNewinventory() {
        const clone = inventoryTemplate.content.cloneNode(true);
        inventoryContainer.appendChild(clone);
    }
    addinventoryBtn.addEventListener('click', addNewinventory);

inventoryContainer.addEventListener('click', function (e) {
    const removeButton = e.target.closest('.remove-inventory');

    if (!removeButton) return;

    const item = removeButton.closest('.inventory-item');

    if (item) {
        item.remove();
    }
});

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
    .inventory-item { border-left: 4px solid #198754 !important; transition: all 0.2s ease; }
    .inventory-item:hover { transform: scale(1.01); }
    .form-control:focus, .form-select:focus { border-color: #198754; box-shadow: none; }
    .ck-editor__editable { min-height: 250px; }
</style>
@endpush

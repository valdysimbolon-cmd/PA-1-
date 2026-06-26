@extends('layouts.admin')

@section('title', 'Tambah Inventaris')

@section('content')
<div class="container-fluid px-3 px-md-4 pb-5">
    <!-- Header -->
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mt-4 mb-4">
        <div>
            <h1 class="h3 text-gray-800 mb-1">Tambah Inventaris</h1>
            <p class="text-muted small mb-0">Isi data sesuai kategori barang yang akan ditambahkan.</p>
        </div>
        <a href="{{ route('inventories.index') }}" class="btn btn-light border px-3 fw-bold small text-muted shadow-sm">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

    @if($errors->any())
    <div class="alert alert-danger rounded-3 border-0 shadow-sm mb-4">
        <ul class="mb-0 small">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
    @endif

    <form action="{{ route('inventories.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row g-4">
            <!-- KOLOM KIRI: DATA UTAMA -->
            <div class="col-12 col-lg-8">
                <!-- Card: Identitas -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header py-3 bg-success text-white">
                        <h6 class="m-0 font-weight-bold"><i class="fas fa-boxes me-2"></i>Data Utama Inventaris</h6>
                    </div>
                    <div class="card-body p-3 p-md-4">
                        <!-- Kategori -->
                        <div class="mb-4">
                            <label class="form-label fw-bold text-dark mb-2">Kategori <span class="text-danger">*</span></label>
                            <div class="d-flex flex-wrap gap-2" id="categoryRadios">
                                @php
                                    $categories = [
                                        'Equipment'  => ['label' => 'Alat', 'icon' => 'fa-tools', 'bg' => '#e8f5e9', 'fg' => '#2e7d32', 'border' => '#4caf50'],
                                        'Material'   => ['label' => 'Bahan Kimia', 'icon' => 'fa-flask', 'bg' => '#e3f2fd', 'fg' => '#0d47a1', 'border' => '#2196f3'],
                                        'Instrument' => ['label' => 'Instrumen', 'icon' => 'fa-microscope', 'bg' => '#e0f2f1', 'fg' => '#004d40', 'border' => '#009688'],
                                    ];
                                @endphp
                                @foreach($categories as $val => $meta)
                                <label class="cat-card border rounded-3 px-4 py-3 d-flex align-items-center gap-2"
                                       data-value="{{ $val }}"
                                       data-bg="{{ $meta['bg'] }}" data-fg="{{ $meta['fg'] }}" data-border="{{ $meta['border'] }}"
                                       data-icon="{{ $meta['icon'] }}" data-label="{{ $meta['label'] }}"
                                       style="cursor:pointer;transition:.15s;border-color:#dee2e6 !important;background:#fff;">
                                    <input type="radio" name="category" value="{{ $val }}" class="d-none cat-radio"
                                           {{ old('category', 'Equipment') === $val ? 'checked' : '' }}>
                                    <i class="fas {{ $meta['icon'] }}" style="color:{{ $meta['fg'] }};"></i>
                                    <span class="fw-bold small">{{ $meta['label'] }}</span>
                                </label>
                                @endforeach
                            </div>
                            @error('category') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-12 col-md-6">
                                <label class="form-label fw-bold text-dark">Unit Laboratorium <span class="text-muted fw-normal">(opsional)</span></label>
                                <select name="lab_id" class="form-select form-control-custom">
                                    <option value="">— Tidak Ditentukan —</option>
                                    @foreach($labs as $lab)
                                        <option value="{{ $lab->id }}" {{ old('lab_id') == $lab->id ? 'selected' : '' }}>
                                            {{ $lab->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label fw-bold text-dark">Kode Barang <span class="text-danger">*</span></label>
                                <input type="text" name="item_code" class="form-control form-control-custom @error('item_code') is-invalid @enderror"
                                       value="{{ old('item_code') }}" placeholder="Contoh: EQP-001" required>
                                @error('item_code') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark">Nama Barang <span class="text-danger">*</span></label>
                            <input type="text" name="item_name" class="form-control form-control-custom @error('item_name') is-invalid @enderror"
                                   value="{{ old('item_name') }}" placeholder="Nama lengkap alat / bahan…" required>
                            @error('item_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="row g-3">
                            <div class="col-6 col-md-4">
                                <label class="form-label fw-bold text-dark">Jumlah Stok <span class="text-danger">*</span></label>
                                <input type="number" name="quantity" min="0" class="form-control form-control-custom @error('quantity') is-invalid @enderror"
                                       value="{{ old('quantity', 1) }}" required>
                                @error('quantity') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-6 col-md-4">
                                <label class="form-label fw-bold text-dark">Satuan <span class="text-danger">*</span></label>
                                <input type="text" name="unit" class="form-control form-control-custom @error('unit') is-invalid @enderror"
                                       value="{{ old('unit', 'Unit') }}" placeholder="Unit / Botol / ml" required>
                                @error('unit') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-12 col-md-4">
                                <label class="form-label fw-bold text-dark">Kondisi</label>
                                <select name="condition" class="form-select form-control-custom">
                                    <option value="Baik" {{ old('condition', 'Baik') == 'Baik' ? 'selected' : '' }}>Baik</option>
                                    <option value="Rusak" {{ old('condition') == 'Rusak' ? 'selected' : '' }}>Rusak</option>
                                    <option value="Perbaikan" {{ old('condition') == 'Perbaikan' ? 'selected' : '' }}>Dalam Perbaikan</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Detail Kategori (Dinamis) -->
                <!-- Alat -->
                <div id="fields_equipment" class="{{ old('category', 'Equipment') !== 'Equipment' ? 'd-none' : '' }}">
                    <div class="card shadow-sm border-0 mb-4" style="border-left: 3px solid #4caf50 !important; border-radius: 0 .75rem .75rem 0 !important;">
                        <div class="card-body p-3 p-md-4">
                            <h6 class="fw-bold mb-3 d-flex align-items-center gap-2" style="color:#2e7d32;">
                                <i class="fas fa-tools"></i> Detail Alat
                            </h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-dark">Tahun Perolehan</label>
                                    <input type="number" name="year" class="form-control form-control-custom" value="{{ old('year') }}" placeholder="{{ date('Y') }}" min="1900" max="{{ date('Y') }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-dark">Lokasi Penyimpanan</label>
                                    <input type="text" name="cupboard_location" class="form-control form-control-custom" value="{{ old('cupboard_location') }}" placeholder="Lemari A / Rak 2…">
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-bold text-dark">Spesifikasi</label>
                                    <textarea name="spesification" rows="2" class="form-control form-control-custom" placeholder="Merek, model, kapasitas…">{{ old('spesification') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bahan Kimia -->
                <div id="fields_material" class="{{ old('category') !== 'Material' ? 'd-none' : '' }}">
                    <div class="card shadow-sm border-0 mb-4" style="border-left: 3px solid #2196f3 !important; border-radius: 0 .75rem .75rem 0 !important;">
                        <div class="card-body p-3 p-md-4">
                            <h6 class="fw-bold mb-3 d-flex align-items-center gap-2" style="color:#0d47a1;">
                                <i class="fas fa-flask"></i> Detail Bahan Kimia
                            </h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-dark">Rumus Kimia</label>
                                    <input type="text" name="chemical_formula" class="form-control form-control-custom" value="{{ old('chemical_formula') }}" placeholder="H₂O, NaCl…">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-dark">Tanggal Kedaluwarsa</label>
                                    <input type="date" name="expiry_date" class="form-control form-control-custom" value="{{ old('expiry_date') }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-dark">Berat Kotor</label>
                                    <input type="text" name="gross_weight" class="form-control form-control-custom" value="{{ old('gross_weight') }}" placeholder="250 g">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-dark">Berat Bersih</label>
                                    <input type="text" name="net_weight" class="form-control form-control-custom" value="{{ old('net_weight') }}" placeholder="200 g">
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-bold text-dark">Ketentuan Penyimpanan</label>
                                    <input type="text" name="storage" class="form-control form-control-custom" value="{{ old('storage') }}" placeholder="Suhu ruang / Lemari asam…">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Instrumen -->
                <div id="fields_instrument" class="{{ old('category') !== 'Instrument' ? 'd-none' : '' }}">
                    <div class="card shadow-sm border-0 mb-4" style="border-left: 3px solid #009688 !important; border-radius: 0 .75rem .75rem 0 !important;">
                        <div class="card-body p-3 p-md-4">
                            <h6 class="fw-bold mb-3 d-flex align-items-center gap-2" style="color:#004d40;">
                                <i class="fas fa-microscope"></i> Detail Instrumen
                            </h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-dark">Tahun Perolehan</label>
                                    <input type="number" name="year" class="form-control form-control-custom" value="{{ old('year') }}" placeholder="{{ date('Y') }}" min="1900" max="{{ date('Y') }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-dark">Lokasi Penyimpanan</label>
                                    <input type="text" name="cupboard_location" class="form-control form-control-custom" value="{{ old('cupboard_location') }}" placeholder="Ruang instrumen / Meja B…">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-dark">Merek / Model</label>
                                    <input type="text" name="brand" class="form-control form-control-custom" value="{{ old('brand') }}" placeholder="Shimadzu UV-1900i…">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-dark">Nomor Seri</label>
                                    <input type="text" name="serial_number" class="form-control form-control-custom" value="{{ old('serial_number') }}" placeholder="SN-XXXXXX">
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-bold text-dark">Spesifikasi Teknis</label>
                                    <textarea name="spesification" rows="2" class="form-control form-control-custom" placeholder="Rentang panjang gelombang, akurasi, daya…">{{ old('spesification') }}</textarea>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-dark">Jadwal Kalibrasi Berikutnya</label>
                                    <input type="date" name="calibration_date" class="form-control form-control-custom" value="{{ old('calibration_date') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Deskripsi -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body p-3 p-md-4">
                        <label class="form-label fw-bold text-dark">Keterangan Tambahan</label>
                        <textarea name="description" rows="3" class="form-control form-control-custom" placeholder="Catatan khusus tentang barang ini…">{{ old('description') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- KOLOM KANAN: GAMBAR & STATUS -->
            <div class="col-12 col-lg-4">
                <div class="card shadow-sm border-0 sticky-top" style="top: 80px;">
                    <div class="card-header bg-success py-3">
                        <h6 class="m-0 font-weight-bold text-white"><i class="fas fa-cog me-2"></i>Gambar & Status</h6>
                    </div>
                    <div class="card-body p-3 p-md-4">
                        <!-- Upload Gambar -->
                        <div class="mb-4">
                            <label class="form-label fw-bold text-dark"><i class="fas fa-image me-1 text-success"></i> Foto Barang</label>
                            <div id="previewContainer" class="d-none mb-3 text-center">
                                <img id="imagePreview" src="#" class="rounded shadow-sm border border-success" style="max-width: 100%; max-height: 140px; object-fit: cover;">
                                <small class="text-success fw-bold d-block mt-1" style="font-size:0.72rem;"><i class="fas fa-check-circle me-1"></i> Gambar siap</small>
                            </div>

                            <div id="uploadPlaceholder" class="upload-area">
                                <i class="fas fa-cloud-upload-alt upload-icon text-success"></i>
                                <span class="upload-text">Klik untuk upload gambar</span>
                                <span class="upload-hint">JPG, PNG, WEBP (maks 2MB)</span>
                                <input type="file" name="image" id="imageInput" class="upload-input" accept="image/jpeg,image/png,image/webp">
                            </div>
                            <div class="form-text mt-2">
                                <i class="fas fa-info-circle me-1"></i> Format JPG, PNG, WEBP — maks. 2 MB.
                            </div>
                        </div>

                        <!-- Harga -->
                        <div class="mb-4">
                            <label class="form-label fw-bold text-dark">Harga Satuan (Rp)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0 text-muted small">Rp</span>
                                <input type="number" name="price" class="form-control form-control-custom border-start-0"
                                       value="{{ old('price') }}" min="0" step="0.01" placeholder="0">
                            </div>
                        </div>

                        <!-- Status Aktif -->
                        <div class="mb-4">
                            <label class="form-label fw-bold text-dark">Status</label>
                            <div class="publish-toggle">
                                <div>
                                    <p class="mb-0 fw-bold small">Aktifkan Item</p>
                                    <small class="text-muted" style="font-size:0.7rem;">Item aktif dapat dipinjam</small>
                                </div>
                                <div class="form-check form-switch mb-0">
                                    <input class="form-check-input" type="checkbox" name="active" value="1" id="active" checked style="width:2.5em;height:1.25em;cursor:pointer;">
                                </div>
                            </div>
                            <div class="alert alert-info border-0 mt-2 py-2 px-3 small" style="border-radius: 8px; font-size:0.75rem;">
                                <i class="fas fa-info-circle me-1"></i> Item aktif dapat dipinjam oleh pengguna.
                            </div>
                        </div>

                        <hr class="my-3">
                        <div class="d-flex flex-column gap-2">
                            <button type="submit" class="btn-submit-main">
                                <i class="fas fa-save me-2"></i> Simpan Inventaris
                            </button>
                            <a href="{{ route('inventories.index') }}" class="btn btn-outline-secondary py-2 text-center" style="border-radius: 9px; font-size: 0.9rem; font-weight: 600;">Batal</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const cards = document.querySelectorAll('.cat-card');
    const fldEq = document.getElementById('fields_equipment');
    const fldMat = document.getElementById('fields_material');
    const fldIns = document.getElementById('fields_instrument');

    function applyCategory(val, card) {
        cards.forEach(c => {
            c.style.background = '#fff';
            c.style.borderColor = '#dee2e6';
            c.style.boxShadow = 'none';
        });
        if (card) {
            card.style.background = card.dataset.bg;
            card.style.borderColor = card.dataset.border;
            card.style.boxShadow = `0 0 0 2px ${card.dataset.border}`;
        }
        fldEq.classList.toggle('d-none', val !== 'Equipment');
        fldMat.classList.toggle('d-none', val !== 'Material');
        fldIns.classList.toggle('d-none', val !== 'Instrument');
    }

    cards.forEach(card => {
        card.addEventListener('click', function () {
            this.querySelector('.cat-radio').checked = true;
            applyCategory(this.dataset.value, this);
        });
    });

    const checked = document.querySelector('.cat-radio:checked');
    if (checked) applyCategory(checked.value, checked.closest('.cat-card'));

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
});
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

    .cat-card.selected { box-shadow: 0 0 0 2px var(--cat-border-color); }
</style>
@endpush
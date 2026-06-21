@extends('layouts.admin')

@section('title', 'Edit Inventaris')

@section('content')
<div class="container-fluid px-3 px-md-4 pb-5">

    {{-- ── Header ── --}}
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mt-4 mb-4">
        <div>
            <a href="{{ route('inventories.index') }}" class="text-success fw-bold text-decoration-none small">
                <i class="fas fa-arrow-left me-1"></i> Kembali ke Daftar
            </a>
            <h1 class="h3 text-gray-800 mt-1 fw-bold mb-0">Edit Inventaris</h1>
            <p class="text-muted small mb-0">Perbarui informasi barang atau sesuaikan stok.</p>
        </div>
        {{-- Badge kategori saat ini --}}
        @php
            $catMeta = [
                'Equipment'  => ['text-success','fa-tools','Alat'],
                'Material'   => ['text-primary','fa-flask','Bahan Kimia'],
                'Instrument' => ['text-info','fa-microscope','Instrumen'],
            ][$inventory->category] ?? ['text-secondary','fa-box','—'];
        @endphp
        <span class="badge bg-light border {{ $catMeta[0] }} px-3 py-2 fw-bold">
            <i class="fas {{ $catMeta[1] }} me-1"></i>{{ $catMeta[2] }}
        </span>
    </div>

    @if($errors->any())
    <div class="alert alert-danger rounded-4 border-0 shadow-sm mb-4">
        <ul class="mb-0 small">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
    @endif

    <form action="{{ route('inventories.update', $inventory->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row g-4">

            {{-- ── Kolom Kiri ── --}}
            <div class="col-lg-8">

                {{-- Card: Data Utama --}}
                <div class="card shadow-sm border-0 rounded-4 mb-4">
                    <div class="card-header bg-success text-white py-3 rounded-top-4">
                        <h6 class="m-0 fw-bold"><i class="fas fa-pen me-2"></i>Data Utama</h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">

                            {{-- Kategori --}}
                            <div class="col-12">
                                <label class="form-label fw-bold small text-muted">KATEGORI <span class="text-danger">*</span></label>
                                <div class="d-flex gap-2 flex-wrap">
                                    @foreach(['Equipment'=>['Alat','fa-tools','success'], 'Material'=>['Bahan Kimia','fa-flask','primary'], 'Instrument'=>['Instrumen','fa-microscope','info']] as $val=>[$label,$icon,$color])
                                    <label class="cat-card border rounded-3 px-4 py-3 d-flex align-items-center gap-2"
                                           data-value="{{ $val }}" style="cursor:pointer;transition:.15s;">
                                        <input type="radio" name="category" value="{{ $val }}" class="d-none cat-radio"
                                               {{ old('category', $inventory->category) === $val ? 'checked' : '' }}>
                                        <i class="fas {{ $icon }} text-{{ $color }}"></i>
                                        <span class="fw-bold small">{{ $label }}</span>
                                    </label>
                                    @endforeach
                                </div>
                            </div>

                            {{-- Lab --}}
                            <div class="col-12 col-md-6">
                                <label class="form-label fw-bold small text-muted">UNIT LABORATORIUM <span class="text-muted fw-normal">(opsional)</span></label>
                                <select name="lab_id" class="form-select bg-light border-0 rounded-3">
                                    <option value="">— Tidak Ditentukan —</option>
                                    @foreach($labs as $lab)
                                        <option value="{{ $lab->id }}" {{ old('lab_id', $inventory->lab_id) == $lab->id ? 'selected' : '' }}>
                                            {{ $lab->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Kode --}}
                            <div class="col-12 col-md-6">
                                <label class="form-label fw-bold small text-muted">KODE BARANG <span class="text-danger">*</span></label>
                                <input type="text" name="item_code"
                                       class="form-control bg-light border-0 rounded-3 @error('item_code') is-invalid @enderror"
                                       value="{{ old('item_code', $inventory->item_code) }}" required>
                                @error('item_code')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            {{-- Nama --}}
                            <div class="col-12">
                                <label class="form-label fw-bold small text-muted">NAMA BARANG <span class="text-danger">*</span></label>
                                <input type="text" name="item_name"
                                       class="form-control form-control-lg bg-light border-0 rounded-3 @error('item_name') is-invalid @enderror"
                                       value="{{ old('item_name', $inventory->item_name) }}" required>
                                @error('item_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            {{-- Stok --}}
                            <div class="col-6 col-md-3">
                                <label class="form-label fw-bold small text-muted">TOTAL STOK <span class="text-danger">*</span></label>
                                <input type="number" name="quantity" min="0"
                                       class="form-control bg-light border-0 rounded-3 @error('quantity') is-invalid @enderror"
                                       value="{{ old('quantity', $inventory->quantity) }}" required>
                                @error('quantity')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-6 col-md-3">
                                <label class="form-label fw-bold small text-muted">TERSEDIA</label>
                                <input type="text" class="form-control bg-light border-0 rounded-3 text-success fw-bold"
                                       value="{{ $inventory->quantity_available }}" disabled>
                            </div>
                            <div class="col-6 col-md-3">
                                <label class="form-label fw-bold small text-muted">SATUAN <span class="text-danger">*</span></label>
                                <input type="text" name="unit"
                                       class="form-control bg-light border-0 rounded-3 @error('unit') is-invalid @enderror"
                                       value="{{ old('unit', $inventory->unit) }}" placeholder="Unit / Botol / ml" required>
                                @error('unit')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-6 col-md-3">
                                <label class="form-label fw-bold small text-muted">KONDISI</label>
                                <select name="condition" class="form-select bg-light border-0 rounded-3">
                                    @foreach(['Baik','Rusak','Perbaikan'] as $c)
                                    <option value="{{ $c }}" {{ old('condition', $inventory->condition) == $c ? 'selected' : '' }}>{{ $c }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Info stok --}}
                            <div class="col-12">
                                <div class="alert alert-info border-0 rounded-3 py-2 px-3 mb-0 small">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Mengubah total stok akan menyesuaikan stok tersedia secara otomatis berdasarkan selisih.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ── Field Khusus Equipment & Instrument ── --}}
                <div id="fields_equipment_instrument" class="{{ old('category', $inventory->category) === 'Material' ? 'd-none' : '' }}">
                    <div class="card shadow-sm border-0 rounded-4 mb-4" style="border-left:4px solid #198754 !important;">
                        <div class="card-body p-4">
                            <h6 class="fw-bold mb-3 text-success"><i class="fas fa-tools me-2"></i>Detail Alat / Instrumen</h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small text-muted">TAHUN PEROLEHAN</label>
                                    <input type="number" name="year" class="form-control bg-light border-0 rounded-3"
                                           value="{{ old('year', $inventory->year) }}" placeholder="{{ date('Y') }}" min="1900" max="{{ date('Y') }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small text-muted">LOKASI PENYIMPANAN</label>
                                    <input type="text" name="cupboard_location" class="form-control bg-light border-0 rounded-3"
                                           value="{{ old('cupboard_location', $inventory->cupboard_location) }}" placeholder="Lemari A / Rak 2…">
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-bold small text-muted">SPESIFIKASI</label>
                                    <textarea name="spesification" rows="2" class="form-control bg-light border-0 rounded-3"
                                              placeholder="Merek, model, kapasitas…">{{ old('spesification', $inventory->spesification) }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ── Field Khusus Material ── --}}
                <div id="fields_material" class="{{ old('category', $inventory->category) !== 'Material' ? 'd-none' : '' }}">
                    <div class="card shadow-sm border-0 rounded-4 mb-4" style="border-left:4px solid #0d6efd !important;">
                        <div class="card-body p-4">
                            <h6 class="fw-bold mb-3 text-primary"><i class="fas fa-flask me-2"></i>Detail Bahan Kimia</h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small text-muted">RUMUS KIMIA</label>
                                    <input type="text" name="chemical_formula" class="form-control bg-light border-0 rounded-3"
                                           value="{{ old('chemical_formula', $inventory->chemical_formula) }}" placeholder="H₂O, NaCl…">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small text-muted">TANGGAL KADALUARSA</label>
                                    <input type="date" name="expiry_date" class="form-control bg-light border-0 rounded-3"
                                           value="{{ old('expiry_date', $inventory->expiry_date ? $inventory->expiry_date->format('Y-m-d') : '') }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small text-muted">BERAT KOTOR</label>
                                    <input type="text" name="gross_weight" class="form-control bg-light border-0 rounded-3"
                                           value="{{ old('gross_weight', $inventory->gross_weight) }}" placeholder="250 g">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small text-muted">BERAT BERSIH</label>
                                    <input type="text" name="net_weight" class="form-control bg-light border-0 rounded-3"
                                           value="{{ old('net_weight', $inventory->net_weight) }}" placeholder="200 g">
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-bold small text-muted">KETENTUAN PENYIMPANAN</label>
                                    <input type="text" name="storage" class="form-control bg-light border-0 rounded-3"
                                           value="{{ old('storage', $inventory->storage) }}" placeholder="Suhu ruang / Lemari asam…">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Deskripsi --}}
                <div class="card shadow-sm border-0 rounded-4 mb-4">
                    <div class="card-body p-4">
                        <label class="form-label fw-bold small text-muted">KETERANGAN TAMBAHAN</label>
                        <textarea name="description" rows="3" class="form-control bg-light border-0 rounded-3"
                                  placeholder="Catatan khusus tentang barang ini…">{{ old('description', $inventory->description) }}</textarea>
                    </div>
                </div>
            </div>

            {{-- ── Kolom Kanan ── --}}
            <div class="col-lg-4">

                {{-- Gambar --}}
                <div class="card shadow-sm border-0 rounded-4 mb-4">
                    <div class="card-body p-4">
                        <label class="form-label fw-bold small text-muted d-block mb-3">FOTO BARANG</label>
                        <div id="imgPreviewWrap" class="rounded-4 border d-flex align-items-center justify-content-center mb-3 overflow-hidden" style="height:160px;background:#f8f9fa;">
                            @if($inventory->image)
                                <img id="imgPreview" src="{{ asset('storage/'.$inventory->image) }}"
                                     class="img-fluid rounded-4" style="max-height:160px;object-fit:cover;">
                            @else
                                <div id="imgPlaceholder" class="text-muted text-center">
                                    <i class="fas fa-image fa-3x mb-2 d-block opacity-25"></i>
                                    <small>Tidak ada gambar</small>
                                </div>
                                <img id="imgPreview" src="" class="d-none img-fluid rounded-4" style="max-height:160px;object-fit:cover;">
                            @endif
                        </div>
                        <input type="file" name="image" id="imageInput" accept="image/*"
                               class="form-control bg-light border-0 rounded-3">
                        <p class="text-muted mt-2 mb-0" style="font-size:10px;">JPG, PNG, WEBP — maks. 2 MB. Kosongkan jika tidak ingin mengganti.</p>
                    </div>
                </div>

                {{-- Harga --}}
                <div class="card shadow-sm border-0 rounded-4 mb-4">
                    <div class="card-body p-4">
                        <label class="form-label fw-bold small text-muted">HARGA SATUAN (Rp)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0 text-muted small">Rp</span>
                            <input type="number" name="price" class="form-control bg-light border-0 rounded-end-3"
                                   value="{{ old('price', $inventory->price) }}" min="0" step="0.01" placeholder="0">
                        </div>
                    </div>
                </div>

                {{-- Status Aktif --}}
                <div class="card shadow-sm border-0 rounded-4 mb-4">
                    <div class="card-body p-4">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="active" id="activeSwitch" value="1"
                                   {{ old('active', $inventory->active) ? 'checked' : '' }}>
                            <label class="form-check-label fw-bold small text-muted" for="activeSwitch">
                                Item aktif
                            </label>
                        </div>
                        <small class="text-muted d-block mt-1">Item aktif dapat dipinjam oleh pengguna.</small>
                    </div>
                </div>

                {{-- Submit --}}
                <button type="submit" class="btn btn-success w-100 py-3 rounded-4 shadow fw-bold">
                    <i class="fas fa-save me-2"></i> Simpan Perubahan
                </button>
                <a href="{{ route('inventories.index') }}" class="btn btn-outline-secondary w-100 py-2 rounded-4 mt-2">Batal</a>
            </div>
        </div>
    </form>
</div>

<style>
.cat-card { border-color: #dee2e6 !important; background: #fff; transition: .15s; }
.cat-card.selected { border-color: #198754 !important; background: #f0faf4 !important; box-shadow: 0 0 0 2px #198754; }
.rounded-top-4 { border-radius: .75rem .75rem 0 0 !important; }
</style>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    const cards   = document.querySelectorAll('.cat-card');
    const fldEqIn = document.getElementById('fields_equipment_instrument');
    const fldMat  = document.getElementById('fields_material');

    function applyCategory(val) {
        cards.forEach(c => c.classList.toggle('selected', c.dataset.value === val));
        fldEqIn.classList.toggle('d-none', val === 'Material');
        fldMat.classList.toggle('d-none',  val !== 'Material');
    }

    cards.forEach(card => {
        card.addEventListener('click', function () {
            this.querySelector('.cat-radio').checked = true;
            applyCategory(this.dataset.value);
        });
    });

    // Init
    const checked = document.querySelector('.cat-radio:checked');
    if (checked) applyCategory(checked.value);

    // Image preview
    document.getElementById('imageInput').addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = e => {
            const ph = document.getElementById('imgPlaceholder');
            if (ph) ph.classList.add('d-none');
            const img = document.getElementById('imgPreview');
            img.src = e.target.result;
            img.classList.remove('d-none');
        };
        reader.readAsDataURL(file);
    });
});
</script>
@endpush
@endsection
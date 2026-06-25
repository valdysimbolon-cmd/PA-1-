@extends('layouts.admin')

@section('title', 'Tambah Inventaris')

@section('content')
<div class="container-fluid px-3 px-md-4 pb-5">

    {{-- ── Header ── --}}
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mt-4 mb-4">
        <div>
            <a href="{{ route('inventories.index') }}" class="text-success fw-bold text-decoration-none small">
                <i class="fas fa-arrow-left me-1"></i> Kembali ke Daftar
            </a>
            <h1 class="h3 text-gray-800 mt-1 fw-bold mb-0">Tambah Inventaris</h1>
            <p class="text-muted small mb-0">Isi data sesuai kategori barang yang akan ditambahkan.</p>
        </div>
        {{-- Badge kategori aktif (diupdate JS) --}}
        <span id="activeCatBadge" class="badge rounded-pill px-3 py-2 fw-bold d-inline-flex align-items-center gap-2"
              style="background:#EAF3DE;color:#3B6D11;font-size:.8rem;">
            <i class="fas fa-tools" id="activeCatIcon"></i>
            <span id="activeCatLabel">Alat</span>
        </span>
    </div>

    @if($errors->any())
    <div class="alert alert-danger rounded-4 border-0 shadow-sm mb-4">
        <ul class="mb-0 small">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
    @endif

    <form action="{{ route('inventories.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row g-4">

            {{-- ── Kolom Kiri ── --}}
            <div class="col-lg-8">

                {{-- Card: Data Utama --}}
                <div class="card shadow-sm border-0 rounded-4 mb-4">
                    <div class="card-header py-3 px-4 rounded-top-4 d-flex align-items-center gap-2"
                         style="background:#1D9E75;">
                        <i class="fas fa-boxes text-white"></i>
                        <h6 class="m-0 fw-bold text-white">Data Utama</h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">

                            {{-- Kategori --}}
                            <div class="col-12">
                                <label class="form-label fw-semibold text-muted mb-2" style="font-size:.75rem;letter-spacing:.05em;text-transform:uppercase;">
                                    Kategori <span class="text-danger">*</span>
                                </label>
                                <div class="d-flex gap-2 flex-wrap" id="categoryRadios">
                                    @foreach([
                                        'Equipment'  => ['Alat',       'fa-tools',      '#EAF3DE','#3B6D11','#1D9E75'],
                                        'Material'   => ['Bahan Kimia','fa-flask',      '#E6F1FB','#0C447C','#185FA5'],
                                        'Instrument' => ['Instrumen',  'fa-microscope', '#E1F5EE','#085041','#0F6E56'],
                                    ] as $val => [$label, $icon, $bg, $fg, $border])
                                    <label class="cat-card border rounded-3 px-4 py-3 d-flex align-items-center gap-2"
                                           data-value="{{ $val }}"
                                           data-bg="{{ $bg }}" data-fg="{{ $fg }}" data-border="{{ $border }}"
                                           data-icon="{{ $icon }}" data-label="{{ $label }}"
                                           style="cursor:pointer;transition:.15s;">
                                        <input type="radio" name="category" value="{{ $val }}" class="d-none cat-radio"
                                               {{ old('category', 'Equipment') === $val ? 'checked' : '' }}>
                                        <i class="fas {{ $icon }}" style="color:{{ $fg }};"></i>
                                        <span class="fw-bold small">{{ $label }}</span>
                                    </label>
                                    @endforeach
                                </div>
                            </div>

                            {{-- Lab --}}
                            <div class="col-12 col-md-6">
                                <label class="form-label fw-semibold text-muted" style="font-size:.75rem;letter-spacing:.05em;text-transform:uppercase;">
                                    Unit Laboratorium <span class="fw-normal text-muted">(opsional)</span>
                                </label>
                                <select name="lab_id" class="form-select bg-light border-0 rounded-3">
                                    <option value="">— Tidak Ditentukan —</option>
                                    @foreach($labs as $lab)
                                        <option value="{{ $lab->id }}" {{ old('lab_id') == $lab->id ? 'selected' : '' }}>
                                            {{ $lab->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Kode --}}
                            <div class="col-12 col-md-6">
                                <label class="form-label fw-semibold text-muted" style="font-size:.75rem;letter-spacing:.05em;text-transform:uppercase;">
                                    Kode Barang <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="item_code"
                                       class="form-control bg-light border-0 rounded-3 @error('item_code') is-invalid @enderror"
                                       value="{{ old('item_code') }}" placeholder="Contoh: EQP-001" required>
                                @error('item_code')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            {{-- Nama --}}
                            <div class="col-12">
                                <label class="form-label fw-semibold text-muted" style="font-size:.75rem;letter-spacing:.05em;text-transform:uppercase;">
                                    Nama Barang <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="item_name"
                                       class="form-control form-control-lg bg-light border-0 rounded-3 @error('item_name') is-invalid @enderror"
                                       value="{{ old('item_name') }}" placeholder="Nama lengkap alat / bahan…" required>
                                @error('item_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            {{-- Stok & Satuan --}}
                            <div class="col-6 col-md-4">
                                <label class="form-label fw-semibold text-muted" style="font-size:.75rem;letter-spacing:.05em;text-transform:uppercase;">
                                    Jumlah Stok <span class="text-danger">*</span>
                                </label>
                                <input type="number" name="quantity" min="0"
                                       class="form-control bg-light border-0 rounded-3 @error('quantity') is-invalid @enderror"
                                       value="{{ old('quantity', 1) }}" required>
                                @error('quantity')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-6 col-md-4">
                                <label class="form-label fw-semibold text-muted" style="font-size:.75rem;letter-spacing:.05em;text-transform:uppercase;">
                                    Satuan <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="unit"
                                       class="form-control bg-light border-0 rounded-3 @error('unit') is-invalid @enderror"
                                       value="{{ old('unit','Unit') }}" placeholder="Unit / Botol / ml" required>
                                @error('unit')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12 col-md-4">
                                <label class="form-label fw-semibold text-muted" style="font-size:.75rem;letter-spacing:.05em;text-transform:uppercase;">
                                    Kondisi
                                </label>
                                <select name="condition" class="form-select bg-light border-0 rounded-3">
                                    <option value="Baik"      {{ old('condition','Baik')=='Baik'      ? 'selected':'' }}>Baik</option>
                                    <option value="Rusak"     {{ old('condition')=='Rusak'     ? 'selected':'' }}>Rusak</option>
                                    <option value="Perbaikan" {{ old('condition')=='Perbaikan' ? 'selected':'' }}>Dalam Perbaikan</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ── Detail: Alat ── --}}
                <div id="fields_equipment" class="{{ old('category','Equipment') !== 'Equipment' ? 'd-none' : '' }}">
                    <div class="card shadow-sm border-0 mb-4" style="border-left:3px solid #1D9E75 !important;border-radius:0 .75rem .75rem 0 !important;">
                        <div class="card-body p-4">
                            <h6 class="fw-bold mb-3 d-flex align-items-center gap-2" style="color:#1D9E75;">
                                <i class="fas fa-tools"></i> Detail Alat
                            </h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold text-muted" style="font-size:.75rem;letter-spacing:.05em;text-transform:uppercase;">Tahun Perolehan</label>
                                    <input type="number" name="year" class="form-control bg-light border-0 rounded-3"
                                           value="{{ old('year') }}" placeholder="{{ date('Y') }}" min="1900" max="{{ date('Y') }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold text-muted" style="font-size:.75rem;letter-spacing:.05em;text-transform:uppercase;">Lokasi Penyimpanan</label>
                                    <input type="text" name="cupboard_location" class="form-control bg-light border-0 rounded-3"
                                           value="{{ old('cupboard_location') }}" placeholder="Lemari A / Rak 2…">
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-semibold text-muted" style="font-size:.75rem;letter-spacing:.05em;text-transform:uppercase;">Spesifikasi</label>
                                    <textarea name="spesification" rows="2" class="form-control bg-light border-0 rounded-3"
                                              placeholder="Merek, model, kapasitas…">{{ old('spesification') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ── Detail: Bahan Kimia ── --}}
                <div id="fields_material" class="{{ old('category') !== 'Material' ? 'd-none' : '' }}">
                    <div class="card shadow-sm border-0 mb-4" style="border-left:3px solid #185FA5 !important;border-radius:0 .75rem .75rem 0 !important;">
                        <div class="card-body p-4">
                            <h6 class="fw-bold mb-3 d-flex align-items-center gap-2" style="color:#185FA5;">
                                <i class="fas fa-flask"></i> Detail Bahan Kimia
                            </h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold text-muted" style="font-size:.75rem;letter-spacing:.05em;text-transform:uppercase;">Rumus Kimia</label>
                                    <input type="text" name="chemical_formula" class="form-control bg-light border-0 rounded-3"
                                           value="{{ old('chemical_formula') }}" placeholder="H₂O, NaCl…">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold text-muted" style="font-size:.75rem;letter-spacing:.05em;text-transform:uppercase;">Tanggal Kedaluwarsa</label>
                                    <input type="date" name="expiry_date" class="form-control bg-light border-0 rounded-3"
                                           value="{{ old('expiry_date') }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold text-muted" style="font-size:.75rem;letter-spacing:.05em;text-transform:uppercase;">Berat Kotor</label>
                                    <input type="text" name="gross_weight" class="form-control bg-light border-0 rounded-3"
                                           value="{{ old('gross_weight') }}" placeholder="250 g">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold text-muted" style="font-size:.75rem;letter-spacing:.05em;text-transform:uppercase;">Berat Bersih</label>
                                    <input type="text" name="net_weight" class="form-control bg-light border-0 rounded-3"
                                           value="{{ old('net_weight') }}" placeholder="200 g">
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-semibold text-muted" style="font-size:.75rem;letter-spacing:.05em;text-transform:uppercase;">Ketentuan Penyimpanan</label>
                                    <input type="text" name="storage" class="form-control bg-light border-0 rounded-3"
                                           value="{{ old('storage') }}" placeholder="Suhu ruang / Lemari asam…">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ── Detail: Instrumen ── --}}
                <div id="fields_instrument" class="{{ old('category') !== 'Instrument' ? 'd-none' : '' }}">
                    <div class="card shadow-sm border-0 mb-4" style="border-left:3px solid #0F6E56 !important;border-radius:0 .75rem .75rem 0 !important;">
                        <div class="card-body p-4">
                            <h6 class="fw-bold mb-3 d-flex align-items-center gap-2" style="color:#0F6E56;">
                                <i class="fas fa-microscope"></i> Detail Instrumen
                            </h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold text-muted" style="font-size:.75rem;letter-spacing:.05em;text-transform:uppercase;">Tahun Perolehan</label>
                                    <input type="number" name="year" class="form-control bg-light border-0 rounded-3"
                                           value="{{ old('year') }}" placeholder="{{ date('Y') }}" min="1900" max="{{ date('Y') }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold text-muted" style="font-size:.75rem;letter-spacing:.05em;text-transform:uppercase;">Lokasi Penyimpanan</label>
                                    <input type="text" name="cupboard_location" class="form-control bg-light border-0 rounded-3"
                                           value="{{ old('cupboard_location') }}" placeholder="Ruang instrumen / Meja B…">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold text-muted" style="font-size:.75rem;letter-spacing:.05em;text-transform:uppercase;">Merek / Model</label>
                                    <input type="text" name="brand" class="form-control bg-light border-0 rounded-3"
                                           value="{{ old('brand') }}" placeholder="Shimadzu UV-1900i…">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold text-muted" style="font-size:.75rem;letter-spacing:.05em;text-transform:uppercase;">Nomor Seri</label>
                                    <input type="text" name="serial_number" class="form-control bg-light border-0 rounded-3"
                                           value="{{ old('serial_number') }}" placeholder="SN-XXXXXX">
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-semibold text-muted" style="font-size:.75rem;letter-spacing:.05em;text-transform:uppercase;">Spesifikasi Teknis</label>
                                    <textarea name="spesification" rows="2" class="form-control bg-light border-0 rounded-3"
                                              placeholder="Rentang panjang gelombang, akurasi, daya…">{{ old('spesification') }}</textarea>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold text-muted" style="font-size:.75rem;letter-spacing:.05em;text-transform:uppercase;">Jadwal Kalibrasi Berikutnya</label>
                                    <input type="date" name="calibration_date" class="form-control bg-light border-0 rounded-3"
                                           value="{{ old('calibration_date') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Deskripsi --}}
                <div class="card shadow-sm border-0 rounded-4 mb-4">
                    <div class="card-body p-4">
                        <label class="form-label fw-semibold text-muted" style="font-size:.75rem;letter-spacing:.05em;text-transform:uppercase;">
                            Keterangan Tambahan
                        </label>
                        <textarea name="description" rows="3" class="form-control bg-light border-0 rounded-3"
                                  placeholder="Catatan khusus tentang barang ini…">{{ old('description') }}</textarea>
                    </div>
                </div>
            </div>

            {{-- ── Kolom Kanan ── --}}
            <div class="col-lg-4">

                {{-- Gambar --}}
                <div class="card shadow-sm border-0 rounded-4 mb-4">
                    <div class="card-body p-4">
                        <label class="form-label fw-semibold text-muted d-block mb-3" style="font-size:.75rem;letter-spacing:.05em;text-transform:uppercase;">
                            Foto Barang
                        </label>
                        <div id="imgPreviewWrap" class="rounded-4 bg-light border d-flex align-items-center justify-content-center mb-3"
                             style="height:160px;overflow:hidden;cursor:pointer;" onclick="document.getElementById('imageInput').click()">
                            <div id="imgPlaceholder" class="text-muted text-center">
                                <i class="fas fa-cloud-upload-alt fa-2x mb-2 d-block opacity-25"></i>
                                <small>Klik untuk pilih gambar</small>
                            </div>
                            <img id="imgPreview" src="" class="d-none img-fluid rounded-4"
                                 style="max-height:160px;object-fit:cover;">
                        </div>
                        <input type="file" name="image" id="imageInput" accept="image/*"
                               class="form-control bg-light border-0 rounded-3 @error('image') is-invalid @enderror">
                        <p class="text-muted mt-2 mb-0" style="font-size:10px;">JPG, PNG, WEBP — maks. 2 MB</p>
                        @error('image')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    </div>
                </div>

                {{-- Harga --}}
                <div class="card shadow-sm border-0 rounded-4 mb-4">
                    <div class="card-body p-4">
                        <label class="form-label fw-semibold text-muted" style="font-size:.75rem;letter-spacing:.05em;text-transform:uppercase;">
                            Harga Satuan (Rp)
                        </label>
                        <div class="input-group mt-1">
                            <span class="input-group-text bg-light border-0 text-muted small">Rp</span>
                            <input type="number" name="price" class="form-control bg-light border-0 rounded-end-3"
                                   value="{{ old('price') }}" min="0" step="0.01" placeholder="0">
                        </div>
                    </div>
                </div>

                {{-- Status Aktif --}}
                <div class="card shadow-sm border-0 rounded-4 mb-4">
                    <div class="card-body p-4">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="active" id="activeSwitch" value="1"
                                   {{ old('active', '1') ? 'checked' : '' }}>
                            <label class="form-check-label fw-bold small" for="activeSwitch">Aktifkan item ini</label>
                        </div>
                        <small class="text-muted d-block mt-1">Item aktif dapat dipinjam oleh pengguna.</small>
                    </div>
                </div>

                {{-- Submit --}}
                <button type="submit" class="btn w-100 py-3 rounded-4 shadow fw-bold text-white mb-2"
                        style="background:#1D9E75;">
                    <i class="fas fa-save me-2"></i> Simpan Inventaris
                </button>
                <a href="{{ route('inventories.index') }}" class="btn btn-outline-secondary w-100 py-2 rounded-4">Batal</a>
            </div>
        </div>
    </form>
</div>

<style>
.rounded-top-4 { border-radius: .75rem .75rem 0 0 !important; }
.cat-card { border-color: #dee2e6 !important; background: #fff; transition: .15s; }
.cat-card.selected { box-shadow: 0 0 0 2px var(--cat-border-color); }
</style>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    const cards   = document.querySelectorAll('.cat-card');
    const fldEq   = document.getElementById('fields_equipment');
    const fldMat  = document.getElementById('fields_material');
    const fldIns  = document.getElementById('fields_instrument');
    const badge   = document.getElementById('activeCatBadge');
    const badgeIcon  = document.getElementById('activeCatIcon');
    const badgeLabel = document.getElementById('activeCatLabel');

    function applyCategory(val, card) {
        // Reset all cards
        cards.forEach(c => {
            c.style.background = '#fff';
            c.style.borderColor = '#dee2e6';
            c.style.boxShadow = 'none';
        });

        // Highlight selected card
        if (card) {
            const bg = card.dataset.bg;
            const fg = card.dataset.fg;
            const border = card.dataset.border;
            card.style.background = bg;
            card.style.borderColor = border;
            card.style.boxShadow = `0 0 0 2px ${border}`;

            // Update badge
            badge.style.background = bg;
            badge.style.color = fg;
            badgeIcon.className = `fas ${card.dataset.icon}`;
            badgeLabel.textContent = card.dataset.label;
        }

        // Toggle detail sections
        fldEq.classList.toggle('d-none',  val !== 'Equipment');
        fldMat.classList.toggle('d-none', val !== 'Material');
        fldIns.classList.toggle('d-none', val !== 'Instrument');
    }

    cards.forEach(card => {
        card.addEventListener('click', function () {
            const radio = this.querySelector('.cat-radio');
            radio.checked = true;
            applyCategory(this.dataset.value, this);
        });
    });

    // Init on load
    const checked = document.querySelector('.cat-radio:checked');
    if (checked) {
        const activeCard = checked.closest('.cat-card');
        applyCategory(checked.value, activeCard);
    }

    // Image preview
    document.getElementById('imageInput').addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById('imgPlaceholder').classList.add('d-none');
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
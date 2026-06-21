

@extends('layouts.guest_layout')

@section('title', 'Form Peminjaman Lab - Teknik Bioproses IT Del')

@push('styles')
<style>
:root {
    --forest:       #1A4D2E;
    --forest-deep:  #0f2e1b;
    --forest-mid:   #2E7D52;
    --accent:       #1D9E75;
    --accent-light: #E6F5EC;
    --accent-xlight:#f0faf5;
    --cream:        #F4F8F5;
    --ink:          #111827;
    --muted:        #6b7280;
    --border:       #dce8e1;
    --white:        #ffffff;
    --shadow-sm:    0 2px 8px rgba(26,77,46,.09);
    --shadow-md:    0 8px 24px rgba(26,77,46,.12);
}
.ph-wrap {
    position: relative; padding: 6rem 0 0;
    overflow: hidden; min-height: 300px; background: var(--forest-deep);
}
.ph-bg {
    position: absolute; inset: 0;
    background-image: url('{{ asset("guest_assets/img/peminjaman-bg.jpg") }}');
    background-size: cover; background-position: center 40%;
    filter: saturate(.85) brightness(.6);
}
.ph-overlay {
    position: absolute; inset: 0;
    background: linear-gradient(90deg, rgba(8,24,14,.7) 0%, rgba(10,28,18,.45) 60%, rgba(8,20,12,.25) 100%);
}
.ph-grid {
    position: absolute; inset: 0;
    background-image:
        linear-gradient(rgba(29,158,117,.04) 1px, transparent 1px),
        linear-gradient(90deg, rgba(29,158,117,.04) 1px, transparent 1px);
    background-size: 40px 40px;
}
.ph-vignette {
    position: absolute; bottom: 0; left: 0; right: 0; height: 100px;
    background: linear-gradient(to bottom, transparent, rgba(6,18,10,.5));
}
.ph-inner { position: relative; z-index: 3; padding-bottom: 3.5rem; }
.ph-eyebrow {
    display: inline-flex; align-items: center; gap: .5rem;
    font-size: .7rem; font-weight: 700; letter-spacing: .18em;
    color: var(--accent); margin-bottom: 1rem;
}
.ph-eyebrow::before { content:''; display:block; width:18px; height:2px; background:var(--accent); }
.ph-title {
    font-family: 'Playfair Display', serif;
    font-size: clamp(2rem, 4vw, 3rem);
    font-weight: 900; color: #fff; line-height: 1.15; margin: 0 0 .5rem;
    text-shadow: 0 2px 16px rgba(0,0,0,.35);
}
.ph-title em { font-style: italic; color: var(--accent); }
.ph-sub { font-size: .9rem; color: rgba(255,255,255,.6); max-width: 560px; line-height: 1.6; margin: 0; }
.ph-wave { position: relative; height: 65px; overflow: hidden; margin-top: -1px; z-index: 4; }
.ph-wave svg { position: absolute; bottom:0; left:0; width:100%; height:100%; }

.peminjaman-body { background: var(--cream); padding: 2.5rem 0 5rem; }

.peminjaman-card {
    background: var(--white); border: 1px solid var(--border);
    border-radius: 1.25rem; overflow: hidden; box-shadow: var(--shadow-sm);
}
.peminjaman-card-head {
    background: var(--forest); padding: .9rem 1.4rem;
    display: flex; align-items: center; justify-content: space-between;
}
.peminjaman-card-head h3 {
    font-family: 'Playfair Display', serif;
    font-size: 1rem; font-weight: 700; color: white; margin: 0;
}
.peminjaman-card-body { padding: 1.4rem; }

.form-label {
    font-size: .68rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: .05em; color: var(--muted); display: block; margin-bottom: .3rem;
}
.form-control {
    width: 100%; padding: .65rem .95rem;
    border: 1px solid var(--border); border-radius: .75rem;
    background: var(--cream); font-size: .88rem;
    transition: border .2s, box-shadow .2s; outline: none;
}
.form-control:focus { border-color: var(--accent); box-shadow: 0 0 0 3px rgba(29,158,117,.15); }
.form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; }
@media (max-width: 768px) { .form-grid { grid-template-columns: 1fr; } }

.filter-bar {
    background: var(--cream); border-bottom: 1px solid var(--border);
    padding: 1rem 1.4rem; display: flex; flex-wrap: wrap; gap: .75rem; align-items: center;
}
.search-wrap {
    flex: 1; min-width: 200px;
    display: flex; align-items: center; gap: .5rem;
    background: white; border: 1px solid var(--border);
    border-radius: .65rem; padding: .45rem .9rem;
}
.search-wrap input { border: none; background: transparent; outline: none; font-size: .88rem; color: var(--ink); width: 100%; }
.search-wrap i { color: var(--muted); font-size: .85rem; flex-shrink: 0; }
.search-wrap input::placeholder { color: #adb5bd; }

.cat-tabs { display: flex; flex-wrap: wrap; gap: .4rem; }
.cat-tab {
    display: inline-flex; align-items: center; gap: .35rem;
    font-size: .72rem; font-weight: 700; letter-spacing: .03em;
    padding: .4rem .9rem; border-radius: 50px;
    border: 1.5px solid var(--border); background: white; color: var(--muted);
    cursor: pointer; transition: all .15s; user-select: none;
}
.cat-tab:hover { border-color: var(--accent); color: var(--accent); background: var(--accent-xlight); }
.cat-tab.active { background: var(--forest); color: white; border-color: var(--forest); }
.cat-tab .cat-count {
    background: rgba(255,255,255,.25); color: inherit;
    font-size: .6rem; font-weight: 800;
    padding: .05rem .4rem; border-radius: 30px; min-width: 1.3rem; text-align: center;
}
.cat-tab:not(.active) .cat-count { background: var(--cream); color: var(--muted); }

.table-inventaris { width: 100%; border-collapse: collapse; font-size: .88rem; }
.table-inventaris thead th {
    background: var(--cream); padding: .75rem 1rem;
    font-size: .63rem; font-weight: 700; letter-spacing: .1em; text-transform: uppercase;
    color: var(--muted); border-bottom: 1px solid var(--border);
}
.table-inventaris tbody td {
    padding: .8rem 1rem; border-bottom: 1px solid var(--border); vertical-align: middle;
}
.table-inventaris tbody tr:last-child td { border-bottom: none; }
.table-inventaris tbody tr:hover { background: var(--accent-xlight); }
.table-inventaris tbody tr.row-hidden { display: none; }
.table-inventaris tbody tr.row-selected > td { background: #f0faf5; }

.inventaris-check { width: 1.15rem; height: 1.15rem; accent-color: var(--accent); cursor: pointer; }

.badge-cat {
    display: inline-block; font-size: .58rem; font-weight: 700;
    padding: .18rem .55rem; border-radius: 30px;
    text-transform: uppercase; letter-spacing: .3px;
}
.badge-Equipment  { background: #dbeafe; color: #1e40af; }
.badge-Material   { background: #ede9fe; color: #6d28d9; }
.badge-Instrument { background: #d1fae5; color: #065f46; }

.stok-pill {
    display: inline-block; background: var(--accent-light); color: var(--forest-mid);
    font-size: .7rem; font-weight: 700; padding: .2rem .7rem; border-radius: 30px;
}
.stok-pill.low   { background: #fef3c7; color: #92400e; }
.stok-pill.empty { background: #fee2e2; color: #991b1b; }

.qty-input {
    width: 68px; padding: .38rem .5rem;
    border: 1px solid var(--border); border-radius: .5rem;
    text-align: center; font-weight: 700; font-size: .88rem;
    outline: none; background: #f8fafc; color: #9ca3af; transition: .15s;
}
.qty-input:not(:disabled) { background: white; border-color: var(--accent); color: var(--ink); }

.empty-state { text-align: center; padding: 3rem 1rem; color: var(--muted); }
.empty-state i { font-size: 2.5rem; opacity: .2; display: block; margin-bottom: .75rem; }

.summary-bar {
    background: var(--accent-xlight); border-top: 1px solid var(--border);
    padding: .75rem 1.4rem;
    display: flex; align-items: center; justify-content: space-between;
    gap: 1rem; flex-wrap: wrap; font-size: .82rem; color: var(--forest);
}
.summary-bar strong { font-weight: 800; }

.submit-area {
    background: var(--accent-xlight); border: 1px solid var(--accent);
    border-radius: 1.25rem; padding: 1.4rem;
    display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 1rem;
}
.btn-submit {
    background: var(--forest); color: white; font-weight: 700;
    padding: .8rem 2.5rem; border-radius: 50px; border: none;
    transition: all .2s; cursor: pointer; font-size: .9rem;
}
.btn-submit:hover { background: var(--forest-mid); transform: translateY(-2px); box-shadow: var(--shadow-md); }
</style>
@endpush

@section('content')

{{-- HEADER --}}
<div class="ph-wrap">
    <div class="ph-bg"></div>
    <div class="ph-overlay"></div>
    <div class="ph-grid"></div>
    <div class="ph-vignette"></div>
    <div class="container ph-inner">
        <div class="ph-eyebrow">Layanan MyBioproses</div>
        <h1 class="ph-title">Formulir <em>Peminjaman</em></h1>
        <p class="ph-sub">Halo, <strong>{{ session('pinjam_user')['name'] ?? 'Mahasiswa' }}</strong>. Lengkapi rincian peminjaman alat laboratorium di bawah ini.</p>
    </div>
    <div class="ph-wave">
        <svg viewBox="0 0 1440 70" preserveAspectRatio="none" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0,40 C360,80 1080,0 1440,40 L1440,70 L0,70 Z" fill="var(--cream)"/>
        </svg>
    </div>
</div>

{{-- BODY --}}
<div class="peminjaman-body">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">

                @if($errors->any())
                <div class="alert alert-danger rounded-4 mb-4 border-0 shadow-sm p-3">
                    <ul class="mb-0 small">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                </div>
                @endif

                <form action="{{ route('pinjam.store') }}" method="POST" id="loanForm">
                    @csrf

                    {{-- 1. IDENTITAS --}}
                    <div class="peminjaman-card mb-4">
                        <div class="peminjaman-card-head">
                            <h3><i class="bi bi-person-badge me-2"></i>Identitas Peminjam</h3>
                        </div>
                        <div class="peminjaman-card-body form-grid">
                            <div>
                                <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" name="borrower_name" class="form-control"
                                       value="{{ old('borrower_name') }}" placeholder="Sesuai KTM" required>
                            </div>
                            <div>
                                <label class="form-label">NIM <span class="text-danger">*</span></label>
                                @php $suggestedNim = preg_replace('/[^0-9]/', '', session('pinjam_user')['username'] ?? ''); @endphp
                                <input type="text" name="nim" class="form-control font-monospace"
                                       value="{{ old('nim', $suggestedNim) }}" placeholder="42325021" required>
                                <small class="text-muted" style="font-size:.72rem;">Lengkapi NIM angka jika belum sesuai.</small>
                            </div>
                        </div>
                    </div>

                    {{-- 2. DETAIL KEGIATAN --}}
                    <div class="peminjaman-card mb-4">
                        <div class="peminjaman-card-head">
                            <h3><i class="bi bi-info-square me-2"></i>Detail Rencana Kegiatan</h3>
                        </div>
                        <div class="peminjaman-card-body">
                            <div class="form-grid">
                                <div>
                                    <label class="form-label">Laboratorium Tujuan <span class="text-danger">*</span></label>
                                    <select name="lab_id" class="form-control" required>
                                        <option value="">— Pilih Laboratorium —</option>
                                        @foreach($labs as $lab)
                                            <option value="{{ $lab->id }}" {{ old('lab_id') == $lab->id ? 'selected' : '' }}>{{ $lab->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('lab_id')<span class="text-danger" style="font-size:.78rem;">{{ $message }}</span>@enderror
                                </div>
                                <div style="display:grid;grid-template-columns:1fr 1fr;gap:.75rem;">
                                    <div>
                                        <label class="form-label">Tgl Mulai <span class="text-danger">*</span></label>
                                        <input type="date" name="planned_borrow_date" class="form-control"
                                               value="{{ old('planned_borrow_date') }}" required>
                                    </div>
                                    <div>
                                        <label class="form-label">Tgl Kembali <span class="text-danger">*</span></label>
                                        <input type="date" name="planned_return_date" class="form-control"
                                               value="{{ old('planned_return_date') }}" required>
                                    </div>
                                </div>
                                <div style="grid-column:1/-1;">
                                    <label class="form-label">Judul Penelitian / Keperluan <span class="text-danger">*</span></label>
                                    <textarea name="research_title" rows="2" class="form-control"
                                              placeholder="Contoh: Analisis Kualitas Air Sungai Sitoluama…" required>{{ old('research_title') }}</textarea>
                                    @error('research_title')<span class="text-danger" style="font-size:.78rem;">{{ $message }}</span>@enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- 3. PILIH ALAT & BAHAN --}}
                    <div class="peminjaman-card mb-4">
                        <div class="peminjaman-card-head">
                            <h3><i class="bi bi-box-seam me-2"></i>Pilih Alat & Bahan</h3>
                            <span id="selectedCount" class="badge bg-white text-success fw-bold" style="font-size:.72rem;">0 dipilih</span>
                        </div>

                        {{-- Filter Bar --}}
                        <div class="filter-bar">
                            <div class="search-wrap">
                                <i class="bi bi-search"></i>
                                <input type="text" id="searchInput" placeholder="Cari nama alat atau bahan…" autocomplete="off">
                                <button type="button" id="clearSearch" style="background:none;border:none;padding:0;color:var(--muted);cursor:pointer;display:none;">
                                    <i class="bi bi-x-lg" style="font-size:.75rem;"></i>
                                </button>
                            </div>
                            <div class="cat-tabs">
                                @php
                                    $cats = [
                                        'all'        => ['Semua',     'bi-border-all'],
                                        'Equipment'  => ['Alat',      'bi-tools'],
                                        'Material'   => ['Bahan',     'bi-flask'],
                                        'Instrument' => ['Instrumen', 'bi-activity'],
                                    ];
                                    $counts = $items->groupBy('category')->map->count();
                                @endphp
                                @foreach($cats as $val => [$label, $icon])
                                <button type="button" class="cat-tab {{ $val === 'all' ? 'active' : '' }}" data-cat="{{ $val }}">
                                    <i class="bi {{ $icon }}"></i>
                                    {{ $label }}
                                    <span class="cat-count">{{ $val === 'all' ? $items->count() : ($counts[$val] ?? 0) }}</span>
                                </button>
                                @endforeach
                            </div>
                        </div>

                        {{-- Table --}}
                        <div class="table-responsive">
                            <table class="table-inventaris" id="inventoryTable">
                                <thead>
                                    <tr>
                                        <th style="width:46px;" class="text-center">
                                            <input type="checkbox" id="checkAll" class="inventaris-check" title="Pilih semua yang terlihat">
                                        </th>
                                        <th>Item</th>
                                        <th style="width:90px;" class="text-center">Kategori</th>
                                        <th style="width:110px;" class="text-center">Tersedia</th>
                                        <th style="width:90px;" class="text-center">Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody id="inventoryBody">
                                    @forelse($items as $index => $item)
                                    <tr class="inv-row"
                                        data-category="{{ $item->category }}"
                                        data-name="{{ strtolower($item->item_name) }}">

                                        <td class="text-center">
                                            <input type="checkbox"
                                                   class="inventaris-check item-check"
                                                   id="chk-{{ $index }}">
                                        </td>

                                        <td>
                                            <label for="chk-{{ $index }}" style="cursor:pointer;">
                                                <div class="fw-bold" style="color:var(--forest);font-size:.88rem;">{{ $item->item_name }}</div>
                                                <div style="font-size:.72rem;color:var(--muted);">{{ $item->item_code ?? '—' }}</div>
                                            </label>
                                            {{-- Hidden inventory_id: name dikosongkan, diisi JS saat dicentang --}}
                                            <input type="hidden" class="hidden-inventory-id" name="" value="{{ $item->id }}">
                                        </td>

                                        <td class="text-center">
                                            <span class="badge-cat badge-{{ $item->category }}">
                                                {{ $item->category === 'Equipment' ? 'Alat' : ($item->category === 'Material' ? 'Bahan' : 'Instrumen') }}
                                            </span>
                                        </td>

                                        <td class="text-center">
                                            @php $stokClass = $item->quantity_available <= 0 ? 'empty' : ($item->quantity_available <= 3 ? 'low' : ''); @endphp
                                            <span class="stok-pill {{ $stokClass }}">
                                                {{ $item->quantity_available }} {{ $item->unit }}
                                            </span>
                                        </td>

                                        <td class="text-center">
                                            {{-- Hidden quantity: name dikosongkan, diisi JS saat dicentang --}}
                                            <input type="number"
                                                   class="qty-input hidden-quantity"
                                                   min="1" max="{{ $item->quantity_available }}"
                                                   value="1"
                                                   name=""
                                                   disabled>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5">
                                            <div class="empty-state">
                                                <i class="bi bi-box-seam"></i>
                                                Tidak ada inventaris tersedia saat ini.
                                            </div>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>

                            <div id="emptySearch" class="empty-state d-none">
                                <i class="bi bi-search"></i>
                                <div class="fw-bold mb-1">Tidak ditemukan</div>
                                <div style="font-size:.82rem;">Coba kata kunci lain atau ubah kategori.</div>
                            </div>
                        </div>

                        <div class="summary-bar">
                            <span id="summaryText">Belum ada item yang dipilih.</span>
                            <span style="font-size:.75rem;color:var(--muted);">
                                <i class="bi bi-info-circle me-1"></i>
                                Centang item lalu isi jumlah yang dibutuhkan.
                            </span>
                        </div>
                    </div>

                    {{-- 4. SUBMIT --}}
                    <div class="submit-area">
                        <div style="display:flex;align-items:center;gap:.75rem;">
                            <i class="bi bi-shield-check fs-4" style="color:var(--accent);"></i>
                            <p class="m-0" style="font-size:.78rem;color:var(--forest-deep);line-height:1.5;">
                                Dengan mengirim ini, Anda bertanggung jawab penuh atas kondisi fisik alat.<br>
                                Persetujuan akan diinfokan melalui sistem MyBioproses.
                            </p>
                        </div>
                        <button type="submit" class="btn-submit">
                            <i class="bi bi-send-check-fill me-2"></i> Ajukan Peminjaman
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const rows          = document.querySelectorAll('.inv-row');
    const checkboxes    = document.querySelectorAll('.item-check');
    const checkAll      = document.getElementById('checkAll');
    const searchInput   = document.getElementById('searchInput');
    const clearBtn      = document.getElementById('clearSearch');
    const catTabs       = document.querySelectorAll('.cat-tab');
    const emptySearch   = document.getElementById('emptySearch');
    const selectedCount = document.getElementById('selectedCount');
    const summaryText   = document.getElementById('summaryText');

    let activeCat  = 'all';
    let searchTerm = '';

    // ── Filter rows by category & search
    function filterRows() {
        let visible = 0;
        rows.forEach(row => {
            const catMatch  = activeCat === 'all' || row.dataset.category === activeCat;
            const nameMatch = row.dataset.name.includes(searchTerm);
            if (catMatch && nameMatch) {
                row.classList.remove('row-hidden');
                visible++;
            } else {
                row.classList.add('row-hidden');
            }
        });
        emptySearch.classList.toggle('d-none', visible > 0);
    }

    // ── Rebuild hidden input names berdasarkan item yang dicentang
    // Ini kunci utama agar inventory_id & quantity terkirim dengan index berurutan
    function rebuildHiddenInputs() {
        let idx = 0;
        rows.forEach(row => {
            const cb     = row.querySelector('.item-check');
            const hidInv = row.querySelector('.hidden-inventory-id');
            const hidQty = row.querySelector('.hidden-quantity');

            if (cb.checked) {
                hidInv.name    = 'items[' + idx + '][inventory_id]';
                hidQty.name    = 'items[' + idx + '][quantity]';
                hidQty.disabled = false;
                row.classList.add('row-selected');
                idx++;
            } else {
                hidInv.name    = '';
                hidQty.name    = '';
                hidQty.disabled = true;
                hidQty.value   = 1;
                row.classList.remove('row-selected');
            }
        });
    }

    // ── Update ringkasan item dipilih
    function updateSummary() {
        const checked = document.querySelectorAll('.item-check:checked');
        const n = checked.length;
        selectedCount.textContent = n + ' dipilih';
        if (n === 0) {
            summaryText.textContent = 'Belum ada item yang dipilih.';
        } else {
            const names = Array.from(checked).map(cb => {
                return cb.closest('tr').querySelector('label .fw-bold')?.textContent.trim() ?? '—';
            });
            summaryText.innerHTML = '<strong>' + n + ' item dipilih:</strong> '
                + names.slice(0, 3).join(', ')
                + (n > 3 ? ' …dan ' + (n - 3) + ' lainnya' : '');
        }
    }

    // ── Category tabs
    catTabs.forEach(tab => {
        tab.addEventListener('click', function () {
            catTabs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            activeCat = this.dataset.cat;
            filterRows();
        });
    });

    // ── Search
    searchInput.addEventListener('input', function () {
        searchTerm = this.value.toLowerCase().trim();
        clearBtn.style.display = searchTerm ? 'block' : 'none';
        filterRows();
    });
    clearBtn.addEventListener('click', function () {
        searchInput.value = '';
        searchTerm = '';
        this.style.display = 'none';
        searchInput.focus();
        filterRows();
    });

    // ── Per-item checkbox
    checkboxes.forEach(cb => {
        cb.addEventListener('change', function () {
            rebuildHiddenInputs();
            updateSummary();

            const allVisible = [...rows].filter(r => !r.classList.contains('row-hidden'));
            const allChecked = allVisible.length > 0 && allVisible.every(r => r.querySelector('.item-check').checked);
            checkAll.checked       = allChecked;
            checkAll.indeterminate = !allChecked && allVisible.some(r => r.querySelector('.item-check').checked);
        });
    });

    // ── Check All
    checkAll.addEventListener('change', function () {
        const visibleRows = [...rows].filter(r => !r.classList.contains('row-hidden'));
        visibleRows.forEach(row => {
            row.querySelector('.item-check').checked = this.checked;
        });
        rebuildHiddenInputs();
        updateSummary();
    });

    // ── Submit
    document.getElementById('loanForm').addEventListener('submit', function (e) {
        e.preventDefault();

        const checked = document.querySelectorAll('.item-check:checked');
        if (checked.length === 0) {
            alert('Silakan pilih minimal satu alat atau bahan yang ingin dipinjam.');
            return;
        }

        let overStock = false;
        checked.forEach(cb => {
            const qty = cb.closest('tr').querySelector('.hidden-quantity');
            if (parseInt(qty.value) > parseInt(qty.max) || parseInt(qty.value) < 1) {
                overStock = true;
            }
        });
        if (overStock) {
            alert('Jumlah yang diminta melebihi stok tersedia. Mohon periksa kembali.');
            return;
        }

        // Rebuild sekali lagi sebelum submit untuk memastikan nama input sudah benar
        rebuildHiddenInputs();

        const ok = confirm('Ajukan Peminjaman?\n\nPastikan data identitas, laboratorium, dan tanggal sudah benar.\n\nKlik OK untuk mengirim.');
        if (ok) this.submit();
    });

});
</script>
@endsection


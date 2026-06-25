@extends('layouts.guest_layout')

@section('title', 'Form Peminjaman Lab - Teknik Bioproses IT Del')

@push('styles')
<style>
/* TOKENS */
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
    --shadow-md:    0 4px 16px rgba(26,77,46,.12), 0 2px 6px rgba(26,77,46,.07);
}

/* HEADER STYLE (IDENTIK DENGAN PROFIL/KURIKULUM) */
.ph-wrap {
    position: relative; padding: 6rem 0 0;
    overflow: hidden; min-height: 340px;
}
.ph-bg {
    position: absolute; inset: 0;
    background-image: url('{{ asset("guest_assets/img/peminjaman-bg.jpg") }}');
    background-size: cover; background-position: center 40%;
    filter: saturate(.85) brightness(.65);
}
.ph-overlay {
    position: absolute; inset: 0;
    background: radial-gradient(ellipse at 20% 15%, rgba(255, 255, 255, 0.2) 0%, rgba(255, 255, 255, 0) 70%),
                linear-gradient(90deg, rgba(8,24,14,.45) 0%, rgba(10,28,18,.35) 45%, rgba(8,20,12,.15) 75%, rgba(8,20,12,.05) 100%),
                linear-gradient(180deg, rgba(0,0,0,.05) 0%, rgba(0,0,0,.15) 100%);
}
.ph-grid {
    position: absolute; inset: 0;
    background-image: linear-gradient(rgba(29,158,117,.04) 1px, transparent 1px),
                      linear-gradient(90deg, rgba(29,158,117,.04) 1px, transparent 1px);
    background-size: 40px 40px;
}
.ph-vignette {
    position: absolute; bottom: 0; left: 0; right: 0; height: 120px;
    background: linear-gradient(to bottom, transparent 0%, rgba(6,18,10,.55) 100%);
}
.ph-inner { position: relative; z-index: 3; padding-bottom: 4rem; }
.ph-eyebrow {
    display: inline-flex; align-items: center; gap: .45rem;
    font-size: .7rem; font-weight: 700; letter-spacing: .18em;
    color: var(--accent); margin-bottom: 1.25rem;
}
.ph-eyebrow::before { content: ''; display: block; width: 18px; height: 2px; background: var(--accent); }
.ph-title {
    font-family: 'Playfair Display', serif; font-size: clamp(2.4rem, 5vw, 3.8rem);
    font-weight: 900; color: #fff; line-height: 1.1; margin: 0 0 1rem;
    text-shadow: 0 2px 16px rgba(0,0,0,.35);
}
.ph-title em { font-style: italic; color: var(--accent); }
.ph-sub { font-size: .98rem; color: rgba(255,255,255,.6); max-width: 480px; line-height: 1.8; margin: 0; }
.ph-wave { position: relative; height: 70px; overflow: hidden; margin-top: -1px; z-index: 4; }
.ph-wave svg { position: absolute; bottom: 0; left: 0; width: 100%; height: 100%; }

/* CONTENT STYLE */
.peminjaman-body { background: var(--cream); padding: 3rem 0 6rem; }
.card-custom { background: white; border: 1px solid var(--border); border-radius: 1rem; overflow: hidden; box-shadow: var(--shadow-md); margin-bottom: 1.5rem; }
.card-head-custom { background: var(--forest); color: white; padding: 1rem 1.5rem; font-family: 'Playfair Display', serif; font-weight: 700; }
.form-label-custom { font-size: 0.72rem; font-weight: 700; color: var(--muted); text-transform: uppercase; margin-bottom: 0.4rem; display: block; }
.input-minimal { background: #f8fafc; border: 1px solid var(--border); border-radius: 0.75rem; padding: 0.7rem 1rem; font-size: 0.9rem; transition: 0.3s; }
.input-minimal:focus { background: white; border-color: var(--accent); outline: none; box-shadow: 0 0 0 4px rgba(29, 158, 117, 0.1); }

/* Filter Tabs */
.cat-tabs { display: flex; gap: 0.5rem; padding: 1rem 1.5rem; background: #f8fafc; border-bottom: 1px solid var(--border); overflow-x: auto; }
.cat-tab { padding: 0.5rem 1.2rem; border-radius: 50px; background: white; border: 1px solid var(--border); font-size: 0.75rem; font-weight: 700; color: var(--muted); cursor: pointer; white-space: nowrap; transition: 0.2s; }
.cat-tab.active { background: var(--forest); color: white; border-color: var(--forest); }

/* Table & Cart */
.table-wrap { max-height: 450px; overflow-y: auto; }
.sticky-cart { position: sticky; top: 100px; z-index: 10; }
.cart-card { border: 2px solid var(--forest); border-radius: 1.25rem; overflow: hidden; background: white; box-shadow: var(--shadow-md); }
.cart-item { background: var(--accent-xlight); border-radius: 0.75rem; padding: 0.8rem; margin: 0.6rem 1rem; display: flex; justify-content: space-between; align-items: center; border: 1px solid #d1e7dd; animation: fadeIn 0.3s ease; }
@keyframes fadeIn { from { opacity: 0; transform: translateY(5px); } to { opacity: 1; transform: translateY(0); } }

.btn-remove { color: #ef4444; border: none; background: none; cursor: pointer; font-size: 1.1rem; }
.btn-remove:hover { transform: scale(1.1); }
</style>
@endpush

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{-- BANNER HEADER --}}
<div class="ph-wrap">
    <div class="ph-bg"></div>
    <div class="ph-overlay"></div>
    <div class="ph-grid"></div>
    <div class="ph-vignette"></div>
    <div class="container">
        <div class="ph-inner">
            <div class="ph-eyebrow">Layanan MyBioproses</div>
            <h1 class="ph-title">Formulir <em>Peminjaman</em></h1>
            <p class="ph-sub">Pilih alat dan bahan laboratorium yang dibutuhkan untuk kegiatan praktikum atau penelitian Anda secara efisien.</p>
        </div>
    </div>
    <div class="ph-wave">
        <svg viewBox="0 0 1440 70" preserveAspectRatio="none" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0,40 C360,80 1080,0 1440,40 L1440,70 L0,70 Z" fill="var(--cream)"/>
        </svg>
    </div>
</div>

<div class="peminjaman-body">
    <div class="container">
        <form action="{{ route('pinjam.store') }}" method="POST" id="loanForm">
            @csrf
            <div class="row">
                <div class="col-lg-8">
                    {{-- 1. IDENTITAS --}}
                    <div class="card-custom">
                        <div class="card-head-custom">Identitas & Rencana Kegiatan</div>
                        <div class="p-4 row g-3">
                            <div class="col-md-6">
                                <label class="form-label-custom">Nama Lengkap</label>
                                <input type="text" name="borrower_name" class="form-control input-minimal" value="{{ session('pinjam_user')['name'] ?? '' }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label-custom">NIM</label>
                                <input type="text" name="nim" class="form-control input-minimal" value="{{ preg_replace('/[^0-9]/', '', session('pinjam_user')['username'] ?? '') }}" required>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label-custom">Laboratorium Tujuan</label>
                                <select name="lab_id" class="form-select input-minimal" required>
                                    <option value="">— Pilih Laboratorium —</option>
                                    @foreach($labs as $lab) <option value="{{ $lab->id }}">{{ $lab->name }}</option> @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label-custom">Tanggal Pinjam</label>
                                <input type="date" name="planned_borrow_date" id="planned_borrow_date" 
                                    class="form-control input-minimal" 
                                    min="{{ date('Y-m-d') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label-custom">Tanggal Kembali</label>
                                <input type="date" name="planned_return_date" id="planned_return_date" 
                                    class="form-control input-minimal" 
                                    min="{{ date('Y-m-d') }}" required>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label-custom">Judul Penelitian / Keperluan</label>
                                <textarea name="research_title" class="form-control input-minimal" rows="2" placeholder="Contoh: Ekstraksi Enzim Mikroba..." required></textarea>
                            </div>
                        </div>
                    </div>

                    {{-- 2. INVENTORY DENGAN FILTER --}}
                    <div class="card-custom">
                        <div class="p-3 bg-light border-bottom d-flex justify-content-between align-items-center">
                            <h6 class="m-0 fw-bold" style="color:var(--forest)">Katalog Inventaris</h6>
                            <input type="text" id="searchInput" class="form-control form-control-sm w-50" placeholder="Cari nama alat/bahan...">
                        </div>
                        
                        {{-- Tab Kategori --}}
                        <div class="cat-tabs">
                            <div class="cat-tab active" data-cat="all">Semua</div>
                            <div class="cat-tab" data-cat="Equipment">Alat</div>
                            <div class="cat-tab" data-cat="Material">Bahan</div>
                            <div class="cat-tab" data-cat="Instrument">Instrumen</div>
                        </div>

                        <div class="table-wrap">
                            <table class="table m-0">
                                <tbody id="inventoryBody">
                                    @foreach($items as $item)
                                    <tr class="inv-row" data-name="{{ strtolower($item->item_name) }}" data-cat="{{ $item->category }}">
                                        <td width="50" class="text-center">
                                            <input type="checkbox" class="form-check-input item-check" 
                                                id="chk-{{ $item->id }}"
                                                data-id="{{ $item->id }}" data-name="{{ $item->item_name }}" 
                                                data-unit="{{ $item->unit }}" data-max="{{ $item->quantity_available }}">
                                        </td>
                                        <td>
                                            <div class="fw-bold small">{{ $item->item_name }}</div>
                                            <div class="text-muted" style="font-size:0.7rem">{{ $item->category }}</div>
                                        </td>
                                        <td class="text-end">
                                            <span class="badge bg-light text-success border">Tersedia: {{ $item->quantity_available }}</span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- 3. KANAN (KERANJANG STICKY) --}}
                <div class="col-lg-4">
                    <div class="sticky-cart">
                        <div class="cart-card">
                            <div class="p-3 bg-forest text-white fw-bold d-flex justify-content-between align-items-center">
                                <span><i class="bi bi-cart3 me-2"></i>Keranjang Pinjaman</span>
                                <span id="cartCount" class="badge bg-white text-forest rounded-pill">0</span>
                            </div>
                            <div id="cartItemsList" style="min-height: 120px; max-height: 400px; overflow-y: auto;">
                                <div id="cartEmpty" class="text-center py-5 text-muted small">
                                    <i class="bi bi-box-seam fs-2 opacity-25 d-block mb-2"></i>
                                    Belum ada item dipilih
                                </div>
                            </div>
                            <div class="p-3 border-top bg-light">
                                <button type="submit" class="btn btn-success w-100 rounded-pill fw-bold" style="background:var(--forest); border:none; padding: 0.8rem;">
                                    Ajukan Peminjaman
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let selected = {};
    const cartList = document.getElementById('cartItemsList');
    const cartCount = document.getElementById('cartCount');
    const searchInput = document.getElementById('searchInput');
    const catTabs = document.querySelectorAll('.cat-tab');
    const invRows = document.querySelectorAll('.inv-row');

    // -- FUNGSI UPDATE TAMPILAN KERANJANG --
    function updateCartUI() {
        const ids = Object.keys(selected);
        cartCount.innerText = ids.length;
        
        if (ids.length === 0) {
            cartList.innerHTML = `<div id="cartEmpty" class="text-center py-5 text-muted small"><i class="bi bi-box-seam fs-2 opacity-25 d-block mb-2"></i>Belum ada item dipilih</div>`;
        } else {
            cartList.innerHTML = '';
            ids.forEach((id, idx) => {
                const item = selected[id];
                cartList.innerHTML += `
                    <div class="cart-item">
                        <div style="flex:1">
                            <div class="small fw-bold text-dark">${item.name}</div>
                            <div class="d-flex align-items-center gap-1 mt-1">
                                <input type="number" name="items[${idx}][quantity]" value="${item.qty}" min="1" max="${item.max}" 
                                    class="form-control form-control-sm text-center fw-bold" style="width:65px" 
                                    onchange="window.updQty(${id}, this.value)">
                                <span class="text-muted small">${item.unit}</span>
                                <input type="hidden" name="items[${idx}][inventory_id]" value="${id}">
                            </div>
                        </div>
                        <button type="button" class="btn-remove" onclick="window.remItem(${id})">
                            <i class="bi bi-x-circle-fill"></i>
                        </button>
                    </div>`;
            });
        }
    }

    // -- GLOBAL FUNCTIONS UNTUK ONCLICK --
    window.updQty = (id, val) => { if(selected[id]) selected[id].qty = val; };
    window.remItem = (id) => { 
        const cb = document.getElementById('chk-' + id);
        if(cb) cb.checked = false;
        delete selected[id]; 
        updateCartUI(); 
    };

    // -- EVENT CHECKBOX --
    document.querySelectorAll('.item-check').forEach(cb => {
        cb.addEventListener('change', function() {
            const id = this.dataset.id;
            if(this.checked) {
                selected[id] = { name: this.dataset.name, unit: this.dataset.unit, max: this.dataset.max, qty: 1 };
            } else {
                delete selected[id];
            }
            updateCartUI();
        });
    });

    // -- SEARCH & FILTER CATEGORY --
    function performFilter() {
        const term = searchInput.value.toLowerCase();
        const activeCat = document.querySelector('.cat-tab.active').dataset.cat;

        invRows.forEach(row => {
            const nameMatch = row.dataset.name.includes(term);
            const catMatch = activeCat === 'all' || row.dataset.cat === activeCat;
            row.style.display = (nameMatch && catMatch) ? '' : 'none';
        });
    }

    searchInput.addEventListener('input', performFilter);
    catTabs.forEach(tab => {
        tab.addEventListener('click', function() {
            catTabs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            performFilter();
        });
    });

    // -- SUBMIT VALIDATION --
    document.getElementById('loanForm').addEventListener('submit', function(e) {
        e.preventDefault();
        if(!Object.keys(selected).length) {
            return Swal.fire({ icon: 'warning', title: 'Keranjang Kosong', text: 'Silakan pilih minimal satu alat/bahan.' });
        }
        Swal.fire({
            title: 'Kirim Pengajuan?',
            text: "Permohonan akan diperiksa oleh laboran.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#1A4D2E',
            confirmButtonText: 'Ya, Kirim Sekarang'
        }).then(result => { if(result.isConfirmed) this.submit(); });
    });


    document.addEventListener('DOMContentLoaded', function() {
        const borrowDateInput = document.getElementById('planned_borrow_date');
        const returnDateInput = document.getElementById('planned_return_date');

        // Ketika tanggal pinjam diubah
        borrowDateInput.addEventListener('change', function() {
            // Set minimal tanggal kembali sama dengan tanggal pinjam
            returnDateInput.min = this.value;

            // Jika tanggal kembali yang sudah dipilih ternyata lebih kecil dari tanggal pinjam yang baru, reset nilainya
            if (returnDateInput.value && returnDateInput.value < this.value) {
                returnDateInput.value = this.value;
            }
        });
    });
});
</script>
@endsection
@extends('layouts.guest_layout')

@section('title', 'Prestasi - Teknik Bioproses IT Del')

@push('styles')
<style>
/* ... (Style tetap sama seperti yang Anda buat, sudah sangat bagus) ... */
:root {
    --forest:       #1A4D2E;
    --forest-deep:  #0f2e1b;
    --forest-mid:   #2E7D52;
    --accent:       #1D9E75;
    --accent-light: #E6F5EC;
    --accent-xlight:#f0faf5;
    --cream:        #F4F8F5;
    --cream-deep:   #e8e0d0;
    --ink:          #111827;
    --muted:        #6b7280;
    --border:       #dce8e1;
    --white:        #ffffff;
    --gold:         #c8a84b;
    --shadow-sm:    0 2px 8px rgba(26,77,46,.09);
    --shadow-md:    0 8px 24px rgba(26,77,46,.12);
}

.ph-wrap { position: relative; padding: 6rem 0 0; overflow: hidden; min-height: 340px; background: var(--forest-deep); }
.ph-bg { position: absolute; inset: 0; background-image: url('{{ asset("guest_assets/img/prestasi-bg.jpg") }}'); background-size: cover; background-position: center 40%; filter: saturate(.85) brightness(.65); }
.ph-overlay { position: absolute; inset: 0; background: radial-gradient(ellipse at 20% 15%, rgba(255,255,255,0.15) 0%, rgba(255,255,255,0) 70%), linear-gradient(90deg, rgba(8,24,14,.65) 0%, rgba(10,28,18,.45) 45%, rgba(8,20,12,.25) 100%); }
.ph-grid { position: absolute; inset: 0; background-image: linear-gradient(rgba(29,158,117,.04) 1px, transparent 1px), linear-gradient(90deg, rgba(29,158,117,.04) 1px, transparent 1px); background-size: 40px 40px; }
.ph-vignette { position: absolute; bottom: 0; left: 0; right: 0; height: 120px; background: linear-gradient(to bottom, transparent 0%, rgba(6,18,10,.55) 100%); }
.ph-inner { position: relative; z-index: 3; padding-bottom: 4rem; }
.ph-eyebrow { display: inline-flex; align-items: center; gap: .5rem; font-size: .7rem; font-weight: 700; letter-spacing: .18em; color: var(--accent); margin-bottom: 1.25rem; text-transform: none; }
.ph-eyebrow::before { content: ''; display: block; width: 18px; height: 2px; background: var(--accent); }
.ph-title { font-family: 'Playfair Display', serif; font-size: clamp(2.2rem, 4vw, 3.2rem); font-weight: 900; color: #fff; line-height: 1.15; margin: 0 0 .5rem; text-shadow: 0 2px 16px rgba(0,0,0,.35); }
.ph-title em { font-style: italic; color: var(--accent); }
.ph-sub { font-size: .95rem; color: rgba(255,255,255,.6); max-width: 600px; line-height: 1.6; margin: 0; }
.ph-wave { position: relative; height: 70px; overflow: hidden; margin-top: -1px; z-index: 4; }
.ph-wave svg { position: absolute; bottom: 0; left: 0; width: 100%; height: 100%; }

.prestasi-body { background: var(--cream); padding: 3rem 0 5rem; }
.filter-nav { display: flex; justify-content: center; gap: .75rem; margin-bottom: 2rem; flex-wrap: wrap; }
.filter-btn { padding: .6rem 1.8rem; border: 2px solid var(--forest); border-radius: 50px; font-size: .8rem; font-weight: 600; color: var(--forest); background: transparent; cursor: pointer; transition: all .25s; }
.filter-btn:hover { background: var(--accent-light); }
.filter-btn.active { background: var(--forest); color: white; box-shadow: 0 4px 12px rgba(26,77,46,.25); }

.prestasi-table-wrap { background: var(--white); border-radius: 1.25rem; overflow: hidden; border: 1px solid var(--border); box-shadow: var(--shadow-sm); }
.prestasi-table { width: 100%; border-collapse: collapse; font-size: .9rem; }
.prestasi-table thead { background: var(--cream); }
.prestasi-table thead th { padding: .9rem 1.25rem; font-size: .65rem; font-weight: 700; letter-spacing: .1em; color: var(--muted); text-transform: uppercase; border-bottom: 1px solid var(--border); }
.prestasi-table tbody tr { border-bottom: 1px solid var(--border); transition: background .15s; }
.prestasi-table tbody tr:hover { background: var(--accent-xlight); }
.prestasi-table td { padding: 1rem 1.25rem; vertical-align: middle; }
.prestasi-title { font-weight: 700; color: var(--forest); display: block; font-size: .95rem; }
.prestasi-rank { font-size: .7rem; color: var(--muted); }
.prestasi-winners { font-size: .85rem; color: #444; }
.prestasi-winners span { display: inline-block; }
.prestasi-winners span::after { content: "•"; margin: 0 6px; color: var(--accent); }
.prestasi-winners span:last-child::after { content: ""; }
.badge-level { display: inline-block; background: var(--accent-light); color: var(--forest-mid); font-size: .6rem; font-weight: 700; padding: .2rem .8rem; border-radius: 30px; text-transform: uppercase; letter-spacing: .3px; border: 1px solid var(--border); }
.btn-proof { width: 38px; height: 38px; display: inline-flex; align-items: center; justify-content: center; background: var(--forest); color: white; border: none; border-radius: 50%; transition: all .2s; cursor: pointer; }
.btn-proof:hover { background: var(--forest-mid); transform: scale(1.08); }

.pagination-wrapper { margin-top: 2rem; }
.modal-content-custom { border: none; border-radius: 1.25rem; overflow: hidden; box-shadow: var(--shadow-md); }
.modal-close-custom {
    position: absolute;
    top: 15px;
    right: 15px;
    z-index: 9999 !important; /* WAJIB: Agar berada di atas gambar */
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: white;
    border: 2px solid var(--forest); /* Beri border agar lebih jelas */
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    color: var(--forest);
    transition: all 0.2s;
    cursor: pointer;
    box-shadow: 0 4px 12px rgba(0,0,0,0.2);
}
.modal-close-custom:hover {
    background: var(--forest);
    color: white;
    transform: rotate(90deg);
}

@media (max-width: 768px) {
    .filter-btn { padding: .4rem 1.2rem; font-size: .7rem; }
    .prestasi-table thead th { font-size: .6rem; padding: .6rem .8rem; }
    .prestasi-table td { padding: .6rem .8rem; font-size: .8rem; }
}
</style>
@endpush

@section('content')

{{-- ══════ HEADER ══════ --}}
<div class="ph-wrap">
    <div class="ph-bg"></div>
    <div class="ph-overlay"></div>
    <div class="ph-grid"></div>
    <div class="ph-vignette"></div>

    <div class="container ph-inner">
        <div class="ph-eyebrow">Capaian Unggul</div>
        <h1 class="ph-title">Hall of <em>Fame</em></h1>
        <p class="ph-sub">Rekam jejak keunggulan akademik dan non-akademik civitas akademika Teknik Bioproses IT Del.</p>
    </div>

    <div class="ph-wave">
        <svg viewBox="0 0 1440 70" preserveAspectRatio="none" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0,40 C360,80 1080,0 1440,40 L1440,70 L0,70 Z" fill="var(--cream)"/>
        </svg>
    </div>
</div>

{{-- ══════ BODY ══════ --}}
<div class="prestasi-body">
    <div class="container">

        {{-- Filter: DISESUAIKAN DENGAN ENUM DATABASE (student & lecturer) --}}
        <div class="filter-nav">
            <button class="filter-btn active" data-filter="all">Semua</button>
            <button class="filter-btn" data-filter="student">Mahasiswa</button>
            <button class="filter-btn" data-filter="lecturer">Dosen</button>
        </div>

        {{-- Table --}}
        <div class="prestasi-table-wrap">
            <div class="table-responsive">
                <table class="prestasi-table">
                    <thead>
                        <tr>
                            <th style="width:90px;">Tahun</th>
                            <th>Nama Prestasi</th>
                            <th>Peraih</th>
                            <th style="width:100px;" class="text-center">Skala</th>
                            <th style="width:60px;" class="text-center">Bukti</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($achievements as $ach)
                        {{-- DATA CATEGORY DISESUAIKAN (student/lecturer) --}}
                        <tr class="ach-row" data-category="{{ $ach->category }}">
                            <td><span class="fw-bold text-success">{{ $ach->year }}</span></td>
                            <td>
                                <span class="prestasi-title">{{ $ach->title }}</span>
                                @if($ach->rank)
                                    <span class="prestasi-rank"><i class="bi bi-award-fill text-warning"></i> {{ $ach->rank }}</span>
                                @endif
                            </td>
                            <td>
                                <div class="prestasi-winners">
                                    {{-- Mengambil winner_name yang diinput di admin --}}
                                    @php 
                                        $names = explode(',', str_replace(', ', ',', $ach->winner_name)); 
                                    @endphp
                                    @foreach($names as $name)
                                        <span>{{ trim($name) }}</span>
                                    @endforeach
                                </div>
                            </td>
                            <td class="text-center">
                                <span class="badge-level">{{ $ach->level ?? 'Regional' }}</span>
                            </td>
                            <td class="text-center">
                                @if($ach->image)
                                    <button class="btn-proof" onclick="viewProof('{{ asset('storage/' . $ach->image) }}', '{{ addslashes($ach->title) }}', '{{ addslashes($ach->winner_name) }}')">
                                        <i class="bi bi-image"></i>
                                    </button>
                                @else
                                    <span class="text-muted opacity-25">—</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">Belum ada data prestasi.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination --}}
        @if(method_exists($achievements, 'hasPages') && $achievements->hasPages())
            <div class="pagination-wrapper">
                {{ $achievements->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
</div>

{{-- ══════ MODAL BUKTI ══════ --}}
<div class="modal fade" id="proofModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content modal-content-custom">
            <div class="modal-body p-0 position-relative">
                <button type="button" class="modal-close-custom" id="btnCloseModal" data-bs-dismiss="modal" data-dismiss="modal" aria-label="Tutup">
                    <i class="bi bi-x-lg"></i>
                </button>
                <img id="proofImage" src="" class="w-100" style="display: block; max-height: 80vh; object-fit: contain; background: #000;">
                <div class="p-4 text-center bg-white">
                    <h5 id="proofTitle" class="fw-bold text-forest mb-1"></h5>
                    <p id="proofWinner" class="text-muted small mb-0"></p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // ── Filter Dinamis ──
    const filterBtns = document.querySelectorAll('.filter-btn');
    const rows = document.querySelectorAll('.ach-row');

    filterBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            // Update UI Button
            filterBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');

            const filter = this.dataset.filter; // 'all', 'student', or 'lecturer'
            
            rows.forEach(row => {
                const category = row.dataset.category;
                if (filter === 'all' || category === filter) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    });

    // ── Modal Bukti ──
    window.viewProof = function(imgSrc, title, winner) {
        document.getElementById('proofImage').src = imgSrc;
        document.getElementById('proofTitle').innerText = title;
        document.getElementById('proofWinner').innerText = 'Peraih: ' + winner;
        const modal = new bootstrap.Modal(document.getElementById('proofModal'));
        modal.show();
    };
});
</script>

@endsection
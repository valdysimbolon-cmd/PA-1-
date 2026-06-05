@extends('layouts.guest_layout')

@section('title', 'Prestasi - Teknik Bioproses IT Del')

@section('content')

<style>
/* ── Reset & Speed Optimization ── */
:root { --forest: #1A4D2E; --accent: #4CAF7C; }

/* Hapus animasi berat, gunakan transisi warna saja */
.ach-table-premium tbody tr { transition: background 0.2s; }
.ach-table-premium tbody tr:hover { background-color: #f8fdf9 !important; }

.ach-title-text { font-weight: 700; color: var(--forest); font-size: 1rem; display: block; margin-bottom: 2px; }
.winner-names-wrap { font-size: 0.9rem; color: #444; max-width: 320px; }
.winner-dot-sep { display: inline-block; }
.winner-dot-sep::after { content: "•"; margin: 0 6px; color: var(--accent); }
.winner-dot-sep:last-child::after { content: ""; }

/* Tombol Bukti Ringan */
.btn-proof-circle {
    width: 38px; height: 38px; display: flex; align-items: center; justify-content: center;
    background-color: var(--forest); color: white !important; border-radius: 50%; border: none;
    transition: 0.2s; cursor: pointer;
}
.btn-proof-circle:hover { background-color: var(--teal); transform: scale(1.1); }

/* Modal Optimization */
.modal.fade .modal-dialog { transition: transform 0.2s ease-out; } /* Percepat animasi modal */
</style>

{{-- HEADER --}}
<div class="profil-header">
    <div class="container profil-header-inner text-center">
        <span class="bp-tag">Capaian Unggul</span>
        <h1>Hall of <em>Fame</em></h1>
        <p class="mt-3 mx-auto" style="max-width: 700px; opacity: 0.9;">Rekam jejak keunggulan akademik dan non-akademik civitas akademika Teknik Bioproses IT Del.</p>
    </div>
    <div class="profil-header-cut"></div>
</div>

<div class="profil-body bg-light py-5">
    <div class="container">
        
        {{-- Filter Navigasi --}}
        <div class="d-flex justify-content-center gap-2 mb-5 nav-prestasi">
            <button class="btn btn-forest rounded-pill px-4 active" onclick="filterTable('all', this)">Semua</button>
            <button class="btn btn-outline-forest rounded-pill px-4" onclick="filterTable('students', this)">Mahasiswa</button>
            <button class="btn btn-outline-forest rounded-pill px-4" onclick="filterTable('lecturers', this)">Dosen</button>
        </div>

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="table-responsive">
                <table class="table ach-table-premium align-middle mb-0">
                    <thead class="bg-light">
                        <tr class="small text-uppercase fw-bold text-muted">
                            <th class="ps-4">Tahun</th>
                            <th>Nama Prestasi</th>
                            <th>Peraih</th>
                            <th class="text-center">Skala</th>
                            <th class="text-center">Bukti</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($achievements as $ach)
                        <tr class="ach-row" data-cat="{{ $ach->category }}">
                            <td class="ps-4 fw-bold text-success">{{ $ach->year }}</td>
                            <td>
                                <span class="ach-title-text">{{ $ach->title }}</span>
                                <small class="text-muted"><i class="bi bi-award-fill text-warning"></i> {{ $ach->rank ?? 'Peserta' }}</small>
                            </td>
                            <td>
                                <div class="winner-names-wrap">
                                    @php $names = explode(',', str_replace(', ', ',', $ach->winner_name)); @endphp
                                    @foreach($names as $name) <span class="winner-dot-sep">{{ $name }}</span> @endforeach
                                </div>
                            </td>
                            <td class="text-center">
                                <span class="badge rounded-pill px-3 py-2 bg-success small" style="font-size: 10px;">{{ $ach->level }}</span>
                            </td>
                            <td class="text-center">
                                @if($ach->image)
                                    {{-- Menggunakan data-attribute untuk mengirim data ke Modal Tunggal --}}
                                    <button class="btn-proof-circle mx-auto" 
                                            onclick="viewCertificate('{{ asset('storage/' . $ach->image) }}', '{{ $ach->title }}', '{{ $ach->winner_name }}')">
                                        <i class="bi bi-camera-fill"></i>
                                    </button>
                                @else
                                    <span class="text-muted opacity-25">—</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="text-center py-5">Belum ada data prestasi.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-4 d-flex justify-content-center">
            {{ $achievements->links() }}
        </div>
    </div>
</div>

{{-- ── MODAL TUNGGAL (HANYA SATU UNTUK SEMUA) ── --}}
<div class="modal fade" id="certModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-body p-0 position-relative">
                <button type="button" class="btn-close position-absolute top-0 end-0 m-3 bg-white p-2 rounded-circle" data-bs-dismiss="modal"></button>
                <img id="certImage" src="" class="w-100" style="display: block;">
                <div class="p-4 text-center bg-white">
                    <h5 id="certTitle" class="fw-bold text-forest mb-1"></h5>
                    <p id="certWinner" class="text-muted small mb-0"></p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// 1. Logika Tampilkan Sertifikat Tanpa Lag
function viewCertificate(imgSrc, title, winner) {
    document.getElementById('certImage').src = imgSrc;
    document.getElementById('certTitle').innerText = title;
    document.getElementById('certWinner').innerText = winner;
    
    // Tampilkan modal secara manual
    var myModal = new bootstrap.Modal(document.getElementById('certModal'));
    myModal.show();
}

// 2. Filter Tabel
function filterTable(cat, btn) {
    const rows = document.querySelectorAll('.ach-row');
    const btns = document.querySelectorAll('.nav-prestasi .btn');
    
    btns.forEach(b => { b.classList.remove('btn-forest'); b.classList.add('btn-outline-forest'); });
    btn.classList.remove('btn-outline-forest'); btn.classList.add('btn-forest');

    rows.forEach(row => {
        row.style.display = (cat === 'all' || row.getAttribute('data-cat') === cat) ? '' : 'none';
    });
}
</script>

@endsection
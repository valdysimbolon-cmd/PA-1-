@extends('layouts.guest_layout')

@section('title', 'Prestasi & Penghargaan - Teknik Bioproses IT Del')

@section('content')

{{-- ══════ HEADER ══════ --}}
<div class="profil-header">
    <div class="container profil-header-inner text-center">
        <span class="bp-tag">Capaian Unggul</span>
        <h1>Hall of <em>Fame</em></h1>
        <p class="mt-3 mx-auto" style="max-width: 700px; opacity: 0.9; line-height: 1.6;">
            Rekam jejak keunggulan akademik dan non-akademik civitas akademika Teknik Bioproses. 
            Setiap pencapaian adalah bukti dedikasi kami dalam mendorong batas inovasi di bidang rekayasa hayati.
        </p>
    </div>
    <div class="profil-header-cut"></div>
</div>

{{-- ══════ STATISTIK RINGKAS ══════ --}}
<div class="bg-white py-4 shadow-sm">
    <div class="container">
        <div class="row text-center g-4">
            <div class="col-md-4 border-end">
                <h2 class="fw-bold text-success mb-0">{{ $achievements->where('level', 'Internasional')->count() }}</h2>
                <span class="text-muted small text-uppercase fw-bold">Skala Internasional</span>
            </div>
            <div class="col-md-4 border-end">
                <h2 class="fw-bold text-success mb-0">{{ $achievements->where('level', 'Nasional')->count() }}</h2>
                <span class="text-muted small text-uppercase fw-bold">Skala Nasional</span>
            </div>
            <div class="col-md-4">
                <h2 class="fw-bold text-success mb-0">{{ $achievements->count() }}</h2>
                <span class="text-muted small text-uppercase fw-bold">Total Penghargaan</span>
            </div>
        </div>
    </div>
</div>

{{-- ══════ KONTEN UTAMA ══════ --}}
<section class="py-5" style="background-color: var(--cream);">
    <div class="container">
        
        <!-- Tab Filter (Dosen / Mahasiswa) -->
        <div class="d-flex justify-content-center gap-3 mb-5 nav-prestasi">
            <button class="btn btn-forest rounded-pill px-4 active" onclick="filterAch('all')">Semua Prestasi</button>
            <button class="btn btn-outline-forest rounded-pill px-4" onclick="filterAch('students')">Mahasiswa</button>
            <button class="btn btn-outline-forest rounded-pill px-4" onclick="filterAch('lecturers')">Dosen</button>
        </div>

        <!-- GRID PRESTASI -->
        <div class="row g-4" id="achGrid">
            @forelse($achievements as $ach)
            <div class="col-lg-4 col-md-6 ach-item" data-cat="{{ $ach->category }}">
                <div class="card h-100 border-0 shadow-sm overflow-hidden ach-card">
                    {{-- Foto --}}
                    <div class="ach-img-wrap">
                        @if($ach->image)
                            <img src="{{ asset('storage/' . $ach->image) }}" class="ach-img" alt="Juara">
                        @else
                            <div class="ach-img-placeholder">
                                <i class="bi bi-trophy text-white display-4"></i>
                            </div>
                        @endif
                        <div class="ach-badge-level">{{ $ach->level }}</div>
                    </div>

                    <div class="card-body p-4 text-center">
                        <span class="text-teal fw-bold small text-uppercase">{{ $ach->rank ?? 'Pemenang' }}</span>
                        <h5 class="fw-bold my-2" style="color: var(--forest); line-height: 1.4;">{{ $ach->title }}</h5>
                        <div class="ach-winner mb-3">
                            <i class="bi bi-person-fill"></i> {{ $ach->winner_name }}
                        </div>
                        <div class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top">
                            <span class="small text-muted fw-bold"><i class="bi bi-calendar-event me-1"></i> {{ $ach->year }}</span>
                            <span class="badge {{ $ach->category == 'students' ? 'bg-primary' : 'bg-info' }} rounded-pill">
                                {{ $ach->category == 'students' ? 'Mahasiswa' : 'Dosen' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <p class="text-muted">Data prestasi belum tersedia.</p>
            </div>
            @endforelse
        </div>
    </div>
</section>

<style>
/* STYLE KHUSUS PRESTASI */
.ach-card {
    transition: all 0.3s ease;
    border-radius: 20px;
}
.ach-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.1) !important;
}
.ach-img-wrap {
    height: 250px;
    overflow: hidden;
    position: relative;
}
.ach-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.ach-img-placeholder {
    height: 100%;
    background: linear-gradient(135deg, var(--forest), var(--teal));
    display: flex;
    align-items: center;
    justify-content: center;
}
.ach-badge-level {
    position: absolute;
    bottom: 15px;
    right: 15px;
    background: rgba(255,255,255,0.9);
    padding: 5px 15px;
    border-radius: 50px;
    font-size: 0.7rem;
    font-weight: 800;
    color: var(--forest);
    text-transform: uppercase;
}
.ach-winner {
    font-size: 0.9rem;
    color: var(--muted);
    font-style: italic;
}
.btn-forest { background: var(--forest); color: white; border: 1px solid var(--forest); }
.btn-outline-forest { color: var(--forest); border: 1px solid var(--forest); }
.btn-outline-forest:hover { background: var(--forest); color: white; }
</style>

<script>
function filterAch(cat) {
    // 1. Ganti status tombol
    const btns = document.querySelectorAll('.nav-prestasi button');
    btns.forEach(btn => btn.classList.replace('btn-forest', 'btn-outline-forest'));
    event.target.classList.replace('btn-outline-forest', 'btn-forest');

    // 2. Filter item
    const items = document.querySelectorAll('.ach-item');
    items.forEach(item => {
        if(cat === 'all' || item.dataset.cat === cat) {
            item.style.display = 'block';
        } else {
            item.style.display = 'none';
        }
    });
}
</script>

@endsection
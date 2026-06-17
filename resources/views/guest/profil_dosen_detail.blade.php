@extends('layouts.guest_layout')

@section('title', $person->name . ' - Profil Lengkap')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
<style>
/* ============================================
   TOKENS & GLOBAL
============================================ */
:root {
    --forest:       #1A4D2E;
    --forest-deep:  #0f2e1b;
    --accent:       #1D9E75;
    --accent-light: #E6F5EC;
    --cream:        #F4F8F5;
    --border:       #e5e7eb;
    --white:        #ffffff;
    --shadow-lg:    0 10px 25px -5px rgba(0, 0, 0, 0.1);
    --transition:   all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

/* ── HERO SECTION ── */
.dd-hero {
    position: relative;
    padding: 5rem 0;
    background: var(--forest-deep);
    color: white;
    overflow: hidden;
}
.dd-hero-bg {
    position: absolute; inset: 0;
    background-image: url('{{ $person->image ? asset('storage/'.$person->image) : asset('guest_assets/img/dosen-default-bg.jpg') }}');
    background-size: cover;
    background-position: center 20%;
    filter: saturate(0.6) brightness(0.35);
}
.dd-hero-content {
    position: relative;
    z-index: 5;
    display: flex;
    align-items: center;
    gap: 3rem;
}
.dd-hero-photo {
    width: 180px; height: 180px;
    border-radius: 20% 5% 20% 5%; /* Unik & Elegan */
    border: 5px solid rgba(255,255,255,0.1);
    object-fit: cover;
    box-shadow: var(--shadow-lg);
}
.dd-hero-name {
    font-family: 'Playfair Display', serif;
    font-size: clamp(2rem, 4vw, 3rem);
    font-weight: 800;
    margin-bottom: 0.2rem;
}
.dd-hero-meta {
    display: flex; flex-wrap: wrap; gap: 1.5rem;
    font-size: 0.95rem; color: rgba(255,255,255,0.75);
}
.dd-hero-meta span { display: flex; align-items: center; gap: 0.5rem; }
.dd-hero-meta i { color: var(--accent); }

/* ── STICKY NAVIGATION ── */
.dd-nav-sticky {
    position: sticky;
    top: 70px;
    z-index: 100;
    background: var(--white);
    border-bottom: 1px solid var(--border);
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
}
.dd-tabs {
    display: flex;
    justify-content: center;
    gap: 2rem;
}
.dd-tab-btn {
    padding: 1.5rem 1rem;
    font-weight: 700;
    font-size: 0.9rem;
    color: var(--forest);
    text-transform: uppercase;
    letter-spacing: 1px;
    border: none; background: none;
    position: relative;
    transition: var(--transition);
    display: flex; align-items: center; gap: 0.7rem;
}
.dd-tab-btn:hover { color: var(--accent); }
.dd-tab-btn.active { color: var(--accent); }
.dd-tab-btn.active::after {
    content: '';
    position: absolute; bottom: 0; left: 0; right: 0;
    height: 4px; background: var(--accent);
    border-radius: 4px 4px 0 0;
}

/* ── CONTENT AREA ── */
.dd-main-body {
    background: var(--cream);
    padding: 4rem 0;
    min-height: 600px;
}
.content-panel { display: none; }
.content-panel.active { display: block; animation: fadeInUp 0.5s ease; }

@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

.card-luxury {
    background: white;
    border-radius: 24px;
    padding: 3rem;
    border: 1px solid var(--border);
    box-shadow: 0 4px 20px rgba(0,0,0,0.03);
}
.section-heading {
    font-family: 'Playfair Display', serif;
    font-weight: 800;
    color: var(--forest);
    margin-bottom: 2.5rem;
    display: flex; align-items: center; gap: 1rem;
}

/* ── RIWAYAT STYLES ── */
.timeline-edu { border-left: 2px solid var(--accent-light); padding-left: 2rem; }
.timeline-item { position: relative; margin-bottom: 2rem; }
.timeline-item::before {
    content: ''; position: absolute; left: calc(-2rem - 6px); top: 5px;
    width: 12px; height: 12px; border-radius: 50%; background: var(--accent);
}
.edu-title { font-weight: 800; color: var(--forest); font-size: 1.1rem; }

/* ── PORTOFOLIO STYLES ── */
.porto-link-card {
    background: var(--accent-xlight);
    border: 1px solid var(--border);
    border-radius: 20px;
    padding: 2rem;
    text-align: center;
    text-decoration: none !important;
    transition: var(--transition);
    display: block;
    height: 100%;
}
.porto-link-card:hover {
    background: white;
    border-color: var(--accent);
    transform: translateY(-8px);
    box-shadow: var(--shadow-lg);
}
.porto-logo-circle {
    width: 70px; height: 70px;
    background: white;
    border-radius: 50%;
    margin: 0 auto 1.5rem;
    display: flex; align-items: center; justify-content: center;
    box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    font-size: 1.8rem; color: var(--accent);
}

/* ── RESPONSIVE ── */
@media (max-width: 768px) {
    .dd-hero-content { flex-direction: column; text-align: center; }
    .dd-hero-meta { justify-content: center; }
    .dd-tabs { gap: 0.5rem; overflow-x: auto; justify-content: flex-start; padding: 0 1rem; }
    .dd-tab-btn { white-space: nowrap; font-size: 0.8rem; padding: 1.2rem 0.8rem; }
}
</style>
@endpush

@section('content')

{{-- 1. HERO SECTION --}}
<header class="dd-hero">
    <div class="dd-hero-bg"></div>
    <div class="container dd-hero-content">
        <img src="{{ $person->image ? asset('storage/'.$person->image) : 'https://ui-avatars.com/api/?name='.urlencode($person->name).'&background=DFF0E7&color=1A4D2E&size=400' }}"
             class="dd-hero-photo" alt="{{ $person->name }}">
        <div>
            <div class="badge px-3 py-2 mb-3" style="background: var(--accent); border-radius: 8px; font-weight: 600;">Tenaga Pendidik</div>
            <h1 class="dd-hero-name">{{ $person->name }}</h1>
            <p class="fs-5 opacity-75 mb-4">{{ $person->academic_position ?? 'Dosen Pengajar' }}</p>
            <div class="dd-hero-meta">
                <span><i class="bi bi-shield-check"></i> NIP/NIDN: {{ $person->nip_nidn }}</span>
                <span><i class="bi bi-envelope-heart"></i> {{ $person->email }}</span>
                <span><i class="bi bi-building"></i> Ruang: {{ $person->office ?? '-' }}</span>
            </div>
        </div>
    </div>
</header>

{{-- 2. NAVIGATION BAR (Tepat di bawah Hero) --}}
<nav class="dd-nav-sticky">
    <div class="container">
        <div class="dd-tabs">
            <button class="dd-tab-btn active" data-target="riwayat">
                <i class="bi bi-mortarboard"></i> Riwayat Dosen
            </button>
            <button class="dd-tab-btn" data-target="portofolio">
                <i class="bi bi-journal-bookmark"></i> Portofolio
            </button>
            <button class="dd-tab-btn" data-target="prestasi">
                <i class="bi bi-trophy"></i> Prestasi
            </button>
        </div>
    </div>
</nav>

{{-- 3. CONTENT AREA --}}
<main class="dd-main-body">
    <div class="container">

        {{-- PANEL 1: RIWAYAT DOSEN (PENDIDIKAN & PENGAJARAN) --}}
        <div class="content-panel active" id="panel-riwayat">
            <div class="row g-4">
                <div class="col-lg-5">
                    <div class="card-luxury h-100">
                        <h3 class="section-heading">Pendidikan</h3>
                        <div class="timeline-edu">
                            @forelse($person->educations as $edu)
                                <div class="timeline-item">
                                    <div class="edu-title">{{ $edu->degree }} - {{ $edu->study_program }}</div>
                                    <div class="text-muted">{{ $edu->campus }}</div>
                                    <div class="small fw-bold text-success mt-1">Lulus Tahun {{ $edu->graduation_year }}</div>
                                </div>
                            @empty
                                <p class="text-muted">Data pendidikan belum diperbarui.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="card-luxury h-100">
                        <h3 class="section-heading">Riwayat Pengajaran</h3>
                        <div class="lh-lg text-secondary prose-content">
                            @if($person->teaching_history)
                                {!! nl2br(e($person->teaching_history)) !!}
                            @else
                                <div class="text-center py-4">
                                    <i class="bi bi-journal-x fs-1 text-muted opacity-25"></i>
                                    <p class="text-muted">Belum ada riwayat pengajaran yang tersedia.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- PANEL 2: PORTOFOLIO --}}
        <div class="content-panel" id="panel-portofolio">
            <div class="card-luxury">
                <h3 class="section-heading">Portofolio Akademik</h3>
                <p class="text-muted mb-5">Dokumentasi resmi mengenai kegiatan penelitian, publikasi, dan profil akademik dosen yang terintegrasi dengan sistem kementerian:</p>
                
                <div class="row g-4 justify-content-center">
                    <div class="col-md-5">
                        <a href="{{ $person->sinta_url ?? '#' }}" target="_blank" class="porto-link-card">
                            <div class="porto-logo-circle">
                                <i class="bi bi-mortarboard-fill"></i>
                            </div>
                            <h4 class="fw-bold text-dark mb-2">Profil SINTA</h4>
                            <p class="text-muted small">Science and Technology Index Kemdikbudristek</p>
                            <span class="btn btn-sm btn-outline-success rounded-pill px-4">Buka Profil</span>
                        </a>
                    </div>
                    <div class="col-md-5">
                        <a href="{{ $person->pddikti_url ?? '#' }}" target="_blank" class="porto-link-card">
                            <div class="porto-logo-circle">
                                <i class="bi bi-bank"></i>
                            </div>
                            <h4 class="fw-bold text-dark mb-2">Profil PDDIKTI</h4>
                            <p class="text-muted small">Pangkalan Data Pendidikan Tinggi Indonesia</p>
                            <span class="btn btn-sm btn-outline-success rounded-pill px-4">Cek Status</span>
                        </a>
                    </div>
                </div>

                @if($person->sinta_url)
                <div class="mt-5 pt-4 border-top">
                    <p class="small text-muted fw-bold text-uppercase mb-3">Live Preview SINTA</p>
                    <div class="rounded-4 overflow-hidden border shadow-sm">
                        <iframe src="{{ $person->sinta_url }}" width="100%" height="600px" frameborder="0"></iframe>
                    </div>
                </div>
                @endif
            </div>
        </div>

        {{-- PANEL 3: PRESTASI --}}
        <div class="content-panel" id="panel-prestasi">
            <div class="card-luxury">
                <h3 class="section-heading">Prestasi & Penghargaan</h3>
                <div class="row g-3">
                    @forelse($person->achievements as $ach)
                        <div class="col-md-6">
                            <div class="p-4 rounded-4 border bg-light h-100 transition-hover">
                                <div class="d-flex align-items-center gap-3 mb-2">
                                    <i class="bi bi-award-fill text-warning fs-3"></i>
                                    <span class="badge bg-white text-success border border-success">{{ $ach->level }}</span>
                                </div>
                                <h5 class="fw-bold text-forest mb-1">{{ $ach->title }}</h5>
                                <p class="text-muted mb-0 small">{{ $ach->rank }} — Tahun {{ $ach->year }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5 w-100">
                            <p class="text-muted">Daftar prestasi belum diinputkan.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- TOMBOL KEMBALI --}}
        <div class="text-center mt-5">
            <a href="{{ url('/dosen-staff') }}" class="btn btn-dark px-5 py-2 rounded-pill shadow-sm">
                <i class="bi bi-arrow-left me-2"></i> Kembali ke Daftar
            </a>
        </div>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tabs = document.querySelectorAll('.dd-tab-btn');
    const panels = document.querySelectorAll('.content-panel');

    tabs.forEach(tab => {
        tab.addEventListener('click', function() {
            const target = this.dataset.target;

            // Navigasi UI
            tabs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');

            // Panel UI
            panels.forEach(p => {
                p.classList.remove('active');
                if (p.id === 'panel-' + target) {
                    p.classList.add('active');
                }
            });

            // Auto-scroll ke atas konten (sedikit di bawah sticky nav)
            const scrollPos = document.querySelector('.dd-nav-sticky').offsetTop - 20;
            window.scrollTo({ top: scrollPos, behavior: 'smooth' });
        });
    });
});
</script>

@endsection
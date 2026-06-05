@extends('layouts.guest_layout')

@section('title', $person->name . ' - Profil Lengkap')

@section('content')

<style>
/* ── Header Styling ── */
.dd-hero-section { background: var(--forest); padding: 5rem 0 8rem; color: white; position: relative; }
.dd-hero-grid { display: grid; grid-template-columns: 200px 1fr; gap: 2.5rem; align-items: center; }
.dd-hero-photo { width: 200px; height: 200px; border-radius: 50%; border: 6px solid rgba(255,255,255,0.15); object-fit: cover; }
.dd-hero-name { font-family: 'Playfair Display', serif; font-size: 2.5rem; font-weight: 800; line-height: 1.1; margin-bottom: 0.5rem; }

/* ── Menu Navigasi Atas (Dikelompokkan) ── */
.dd-nav-container { margin-top: -50px; position: relative; z-index: 100; }
.dd-nav-card { background: #fff; border-radius: 20px; padding: 1.5rem; border: 1px solid var(--border); box-shadow: 0 15px 40px rgba(0,0,0,0.08); }

.nav-group-title { font-size: 0.65rem; font-weight: 800; text-transform: uppercase; color: var(--muted); letter-spacing: 2px; margin-bottom: 0.75rem; display: block; }
.dd-nav-flex { display: flex; flex-wrap: wrap; gap: 10px; }

.dd-tab-btn {
    padding: 10px 22px; border-radius: 50px; border: 1.5px solid #eee; 
    background: #fff; font-size: 0.85rem; font-weight: 700; color: #555; 
    transition: 0.3s; cursor: pointer;
}
.dd-tab-btn:hover { border-color: var(--accent); color: var(--forest); }
.dd-tab-btn.active { background: var(--forest); color: #fff; border-color: var(--forest); box-shadow: 0 5px 15px rgba(26, 77, 46, 0.2); }

/* ── Content Area ── */
.dd-main-content { padding: 4rem 0 7rem; min-height: 400px; }
.profil-panel { display: none; }
.profil-panel.active { display: block; animation: fadeInUp 0.5s ease; }

.section-card { background: #fff; padding: 3rem; border-radius: 25px; border: 1px solid var(--border); }
.article-text { text-align: justify; line-height: 2; font-size: 1.1rem; color: #333; }

/* Portofolio Boxes */
.portfolio-box { background: var(--cream); border: 2px dashed var(--accent); border-radius: 15px; padding: 2.5rem; text-align: center; transition: 0.3s; }
.portfolio-box:hover { background: #fff; transform: translateY(-5px); box-shadow: 0 10px 30px rgba(0,0,0,0.05); }

@keyframes fadeInUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
</style>

{{-- 1. HERO SECTION (Identitas) --}}
<section class="dd-hero-section">
    <div class="container">
        <div class="dd-hero-grid">
            <img src="{{ $person->image ? asset('storage/'.$person->image) : 'https://ui-avatars.com/api/?name='.urlencode($person->name).'&background=DFF0E7&color=1A4D2E&size=500' }}" class="dd-hero-photo shadow">
            <div class="text-start">
                <span class="badge bg-accent text-forest mb-2 px-3">Tenaga Pendidik</span>
                <h1 class="dd-hero-name">{{ $person->name }}</h1>
                <p class="fs-5 opacity-75 mb-0">NIP/NIDN: {{ $person->nip_nidn }}</p>
                <div class="small mt-2 opacity-50"><i class="bi bi-envelope me-2"></i> {{ $person->email }}</div>
            </div>
        </div>
    </div>
</section>

{{-- 2. NAVIGASI ATAS (GROUPED) --}}
<div class="dd-nav-container">
    <div class="container">
        <div class="dd-nav-card">
            <div class="row g-4">
                <div class="col-lg-5 border-end">
                    <span class="nav-group-title">Riwayat Dosen</span>
                    <div class="dd-nav-flex">
                        <button class="dd-tab-btn active" data-target="pendidikan">Pendidikan</button>
                        <button class="dd-tab-btn" data-target="mengajar">Pengajaran</button>
                    </div>
                </div>
                <div class="col-lg-7 ps-lg-4">
                    <span class="nav-group-title">Portofolio & Capaian</span>
                    <div class="dd-nav-flex">
                        <button class="dd-tab-btn" data-target="portofolio">Portofolio Akademik</button>
                        <button class="dd-tab-btn" data-target="prestasi">Prestasi</button>
                        <a href="/dosen-staff" class="dd-tab-btn text-decoration-none bg-light border-0">← Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- 3. CONTENT AREA (RATA KANAN KIRI) --}}
<section class="dd-main-content">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">

                {{-- PANEL: PENDIDIKAN --}}
                <div class="profil-panel active" id="panel-pendidikan">
                    <div class="section-card">
                        <h2 class="profil-card-title">Latar Belakang Pendidikan</h2>
                        <span class="profil-card-divider"></span>
                        <div class="mt-4 article-text">
                            @forelse($person->educations as $edu)
                                <div class="mb-4 border-start border-4 border-success ps-4">
                                    <h4 class="fw-bold mb-1" style="color: var(--forest);">{{ $edu->degree }} - {{ $edu->study_program }}</h4>
                                    <p class="text-muted mb-0 fs-6">{{ $edu->campus }}</p>
                                    <small class="text-teal fw-bold">Tahun Lulus: {{ $edu->graduation_year ?? '-' }}</small>
                                </div>
                            @empty <p class="italic text-muted">Belum ada data riwayat pendidikan.</p> @endforelse
                        </div>
                    </div>
                </div>

                {{-- PANEL: MENGAJAR --}}
                <div class="profil-panel" id="panel-mengajar">
                    <div class="section-card">
                        <h2 class="profil-card-title">Riwayat Pengajaran</h2>
                        <span class="profil-card-divider"></span>
                        <div class="mt-4 article-text">
                            {!! nl2br(e($person->teaching_history)) !!}
                        </div>
                    </div>
                </div>

                {{-- PANEL: PORTOFOLIO (SINTA & PDDIKTI) --}}
                <div class="profil-panel" id="panel-portofolio">
                    <div class="section-card">
                        <h2 class="profil-card-title">Portofolio Akademik</h2>
                        <span class="profil-card-divider"></span>
                        <div class="mt-4 article-text">
                            <p>Data <strong>Penelitian, Pengabdian (PKM), Publikasi Karya, serta HKI/Paten</strong> dosen yang bersangkutan dapat diakses secara resmi melalui pangkalan data berikut:</p>
                            
                            <div class="row g-4 mt-2">
                                <div class="col-md-6">
                                    <a href="{{ $person->sinta_url ?? '#' }}" target="_blank" class="text-decoration-none">
                                        <div class="portfolio-box">
                                            <h5 class="fw-bold text-forest mb-1">PROFIL SINTA</h5>
                                            <p class="small text-muted mb-0">Publikasi, Riset & Sitasi</p>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-6">
                                    <a href="{{ $person->pddikti_url ?? '#' }}" target="_blank" class="text-decoration-none">
                                        <div class="portfolio-box">
                                            <h5 class="fw-bold text-forest mb-1">PROFIL PDDIKTI</h5>
                                            <p class="small text-muted mb-0">Pangkalan Data Pendidikan Tinggi</p>
                                        </div>
                                    </a>
                                </div>
                            </div>

                            @if($person->sinta_url)
                                <div class="mt-5 pt-4 border-top">
                                    <h6 class="fw-bold text-muted text-uppercase mb-3" style="letter-spacing: 1px;">Pratinjau Data SINTA</h6>
                                    <div class="rounded-4 overflow-hidden border shadow-sm" style="height: 600px;">
                                        <iframe src="{{ $person->sinta_url }}" width="100%" height="100%" frameborder="0"></iframe>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- PANEL: PRESTASI --}}
                <div class="profil-panel" id="panel-prestasi">
                    <div class="section-card">
                        <h2 class="profil-card-title">Prestasi & Penghargaan</h2>
                        <span class="profil-card-divider"></span>
                        <div class="row g-4 mt-2">
                            @forelse($person->achievements as $ach)
                                <div class="col-md-6">
                                    <div class="p-4 bg-light rounded-4 h-100 border-start border-5 border-success shadow-sm">
                                        <div class="text-teal small fw-bold text-uppercase mb-2">{{ $ach->level }}</div>
                                        <h5 class="fw-bold text-dark mb-2">{{ $ach->title }}</h5>
                                        <div class="small text-muted italic">{{ $ach->rank }} — {{ $ach->year }}</div>
                                    </div>
                                </div>
                            @empty <p class="italic text-muted p-3">Belum ada data prestasi terdaftar.</p> @endforelse
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const tabs = document.querySelectorAll('.dd-tab-btn');
    const panels = document.querySelectorAll('.profil-panel');

    tabs.forEach(tab => {
        tab.addEventListener('click', function() {
            const target = this.dataset.target;

            // Update Buttons
            tabs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');

            // Update Panels
            panels.forEach(p => p.classList.remove('active'));
            document.getElementById('panel-' + target).classList.add('active');

            // Scroll ke Konten
            window.scrollTo({ top: 350, behavior: 'smooth' });
        });
    });
});
</script>

@endsection
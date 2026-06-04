@extends('layouts.guest_layout')

@section('title', $person->name . ' - Profil Lengkap')

@section('content')

<style>
    /* Panel Management */
    .profil-panel { display: none; }
    .profil-panel.active { display: block; animation: fadeIn 0.4s ease; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; } }

    /* Timeline Style */
    .edu-list { list-style: none; padding-left: 20px; border-left: 2px solid var(--cream-deep); }
    .edu-item { position: relative; padding-bottom: 20px; }
    .edu-item::before { content: ''; position: absolute; left: -27px; top: 5px; width: 12px; height: 12px; border-radius: 50%; background: var(--accent); border: 3px solid #fff; }
    
    /* Document/List Style */
    .karya-item { padding: 15px 0; border-bottom: 1px solid #eee; }
    .karya-title { font-weight: 700; color: var(--forest); line-height: 1.4; margin-bottom: 5px; }
    .karya-meta { font-size: 0.8rem; color: var(--muted); }
</style>

{{-- ══════ HEADER ══════ --}}
<div class="profil-header">
    <div class="container profil-header-inner text-start">
        <span class="bp-tag" style="color: var(--accent);">Detail Tenaga Pendidik</span>
        <h1 style="font-size: clamp(2rem, 5vw, 3.5rem);">{{ $person->name }}</h1>
        <p class="opacity-75"><i class="bi bi-person-badge me-2"></i>NIP/NIDN: {{ $person->nip_nidn }}</p>
    </div>
    <div class="profil-header-cut"></div>
</div>

<div class="profil-body">
    <div class="container">
        <div class="profil-grid">

            {{-- ── SIDEBAR NAVIGASI (7 POIN) ── --}}
            <aside class="profil-sidenav">
                <div class="text-center mb-4">
                    <img src="{{ $person->image ? asset('storage/'.$person->image) : 'https://ui-avatars.com/api/?name='.urlencode($person->name).'&background=DFF0E7&color=1A4D2E&size=400&bold=true' }}" 
                         class="img-fluid rounded-4 shadow-sm border p-2 mb-3">
                    <h6 class="fw-bold text-dark">{{ $person->name }}</h6>
                    <small class="text-success fw-bold text-uppercase">{{ $person->academic_position }}</small>
                </div>

                <span class="profil-sidenav-label">Menu Profil</span>
                <button class="profil-nav-item active" data-target="pendidikan"><i class="bi bi-mortarboard me-2"></i> Pendidikan</button>
                <button class="profil-nav-item" data-target="mengajar"><i class="bi bi-book me-2"></i> Riwayat Mengajar</button>
                <button class="profil-nav-item" data-target="penelitian"><i class="bi bi-search me-2"></i> Penelitian</button>
                <button class="profil-nav-item" data-target="pkm"><i class="bi bi-people me-2"></i> Pengabdian (PKM)</button>
                <button class="profil-nav-item" data-target="publikasi"><i class="bi bi-journal-text me-2"></i> Publikasi Karya</button>
                <button class="profil-nav-item" data-target="hki"><i class="bi bi-shield-check me-2"></i> HKI & Paten</button>
                <button class="profil-nav-item" data-target="prestasi"><i class="bi bi-trophy me-2"></i> Prestasi</button>
                
                <div class="mt-4 pt-3 border-top text-center">
                    <a href="/dosen-staff" class="btn btn-sm btn-outline-forest rounded-pill px-4">← Kembali</a>
                </div>
            </aside>

            {{-- ── AREA KONTEN ── --}}
            <div class="profil-content-area text-start">
                
                {{-- 1. PENDIDIKAN --}}
                <div class="profil-panel active" id="panel-pendidikan">
                    <div class="profil-card">
                        <h2 class="profil-card-title">Riwayat Pendidikan</h2>
                        <span class="profil-card-divider"></span>
                        <div class="edu-list mt-4">
                            @forelse($person->educations as $edu)
                                <div class="edu-item">
                                    <h6 class="fw-bold mb-1">{{ $edu->degree }} - {{ $edu->study_program }}</h6>
                                    <p class="text-muted mb-0 small">{{ $edu->campus }} (Lulus Tahun {{ $edu->graduation_year }})</p>
                                </div>
                            @empty
                                <p class="text-muted italic">Data belum tersedia.</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                {{-- 2. RIWAYAT MENGAJAR --}}
                <div class="profil-panel" id="panel-mengajar">
                    <div class="profil-card">
                        <h2 class="profil-card-title">Riwayat Mengajar</h2>
                        <span class="profil-card-divider"></span>
                        <div class="mt-4 text-muted" style="line-height: 1.8; text-align: justify;">
                            {!! nl2br(e($person->teaching_history)) !!}
                        </div>
                    </div>
                </div>

                @php
                    $karya = $person->publications; // Koleksi dari tabel jembatan
                @endphp

                {{-- 3. PENELITIAN --}}
                <div class="profil-panel" id="panel-penelitian">
                    <div class="profil-card">
                        <h2 class="profil-card-title">Riwayat Penelitian</h2>
                        <span class="profil-card-divider"></span>
                        <div class="mt-3">
                            @forelse($karya->where('publication.type', 'Penelitian') as $p)
                                <div class="karya-item">
                                    <div class="karya-title">{{ $p->publication->title }}</div>
                                    <div class="karya-meta">{{ $p->publication->publisher }} | Tahun {{ $p->publication->year }}</div>
                                </div>
                            @empty <p class="text-muted italic small">Belum ada data penelitian.</p> @endforelse
                        </div>
                    </div>
                </div>

                {{-- 4. PENGABDIAN (PKM) --}}
                <div class="profil-panel" id="panel-pkm">
                    <div class="profil-card">
                        <h2 class="profil-card-title">Pengabdian Masyarakat</h2>
                        <span class="profil-card-divider"></span>
                        <div class="mt-3">
                            @forelse($karya->where('publication.type', 'Pengabdian') as $p)
                                <div class="karya-item">
                                    <div class="karya-title">{{ $p->publication->title }}</div>
                                    <div class="karya-meta">{{ $p->publication->year }}</div>
                                </div>
                            @empty <p class="text-muted italic small">Belum ada data pengabdian.</p> @endforelse
                        </div>
                    </div>
                </div>

                {{-- 5. PUBLIKASI --}}
                <div class="profil-panel" id="panel-publikasi">
                    <div class="profil-card">
                        <h2 class="profil-card-title">Publikasi Karya Ilmiah</h2>
                        <span class="profil-card-divider"></span>
                        <div class="mt-3">
                            @forelse($karya->whereIn('publication.type', ['Publikasi Jurnal', 'Buku / Monograf', 'Prosiding / Seminar']) as $p)
                                <div class="karya-item">
                                    <span class="badge bg-success-subtle text-success small mb-1">{{ $p->publication->type }}</span>
                                    <div class="karya-title">{{ $p->publication->title }}</div>
                                    <div class="karya-meta">{{ $p->publication->publisher }} | Tahun {{ $p->publication->year }}</div>
                                </div>
                            @empty <p class="text-muted italic small">Belum ada data publikasi.</p> @endforelse
                        </div>
                    </div>
                </div>

                {{-- 6. HKI & PATEN --}}
                <div class="profil-panel" id="panel-hki">
                    <div class="profil-card">
                        <h2 class="profil-card-title">HKI & Hak Paten</h2>
                        <span class="profil-card-divider"></span>
                        <div class="mt-3">
                            @forelse($karya->where('publication.type', 'Karya Cipta / Paten') as $p)
                                <div class="karya-item">
                                    <div class="karya-title">{{ $p->publication->title }}</div>
                                    <div class="karya-meta">No. Registrasi: {{ $p->publication->publisher }} | Tahun {{ $p->publication->year }}</div>
                                </div>
                            @empty <p class="text-muted italic small">Belum ada data HKI.</p> @endforelse
                        </div>
                    </div>
                </div>

                {{-- 7. PRESTASI --}}
                <div class="profil-panel" id="panel-prestasi">
                    <div class="profil-card">
                        <h2 class="profil-card-title">Prestasi & Penghargaan</h2>
                        <span class="profil-card-divider"></span>
                        <div class="row g-3 mt-3">
                            @forelse($person->achievements as $ach)
                                <div class="col-md-6">
                                    <div class="p-3 border-start border-4 border-success rounded bg-light">
                                        <div class="fw-bold text-dark small mb-1">{{ $ach->title }}</div>
                                        <div class="text-muted small">{{ $ach->level }} | {{ $ach->year }}</div>
                                    </div>
                                </div>
                            @empty <p class="text-muted italic small">Belum ada data prestasi.</p> @endforelse
                        </div>
                    </div>
                </div>

            </div>{{-- .profil-content-area --}}
        </div>
    </div>
</div>

<script>
(function () {
    const navItems = document.querySelectorAll('.profil-nav-item');
    const panels   = document.querySelectorAll('.profil-panel');

    navItems.forEach(btn => {
        btn.addEventListener('click', () => {
            const target = btn.dataset.target;
            navItems.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            panels.forEach(p => p.classList.remove('active'));
            document.getElementById('panel-' + target).classList.add('active');
            
            // Auto scroll ke atas konten saat pindah tab di mobile
            if (window.innerWidth <= 900) {
                window.scrollTo({ top: 350, behavior: 'smooth' });
            }
        });
    });
})();
</script>

@endsection
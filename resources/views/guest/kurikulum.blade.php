@extends('layouts.guest_layout')

@section('title', 'Kurikulum & Struktur Mata Kuliah - Teknik Bioproses IT Del')

@section('content')

{{-- ══════ HEADER ══════ --}}
<div class="profil-header">
    <div class="container profil-header-inner">
        <span class="bp-tag">Akademik</span>
        <h1>Struktur <em>Kurikulum</em></h1>
        <p>Peta perjalanan akademik menuju keahlian rekayasa hayati yang unggul</p>
    </div>
    <div class="profil-header-cut"></div>
</div>

{{-- ══════ BODY ══════ --}}
<div class="profil-body">
    <div class="container">
        <div class="profil-grid">

            {{-- ── Sidebar Nav (Semester 1-8) ── --}}
            <aside class="profil-sidenav">
                <span class="profil-sidenav-label">Pilih Semester</span>
                @for($i = 1; $i <= 8; $i++)
                    <button class="profil-nav-item {{ $i == 1 ? 'active' : '' }}" data-target="sem-{{ $i }}">
                        <span class="pni-dot"></span> Semester {{ $i }}
                    </button>
                    @if($i == 2 || $i == 4 || $i == 6) <div class="profil-nav-divider"></div> @endif
                @endfor
            </aside>

            {{-- ── Content Area ── --}}
            <div class="profil-content-area">
                
                @if(!$curriculum)
                    <div class="profil-card text-center py-5">
                        <i class="bi bi-journal-x display-1 text-muted opacity-25"></i>
                        <p class="mt-3 text-muted">Data kurikulum belum tersedia atau belum diaktifkan.</p>
                    </div>
                @else
                    @for($i = 1; $i <= 8; $i++)
                    <div class="profil-panel {{ $i == 1 ? 'active' : '' }}" id="panel-sem-{{ $i }}">
                        <div class="profil-card">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h2 class="profil-card-title">Daftar Mata Kuliah — Semester {{ $i }}</h2>
                                <span class="badge bg-forest px-3 py-2 rounded-pill small">
                                    {{ $subjects->where('semester', $i)->sum('sks') }} Total SKS
                                </span>
                            </div>
                            <span class="profil-card-divider"></span>
                            
                            <p class="small text-muted mb-4">Berikut adalah daftar mata kuliah wajib dan pilihan untuk semester {{ $i }} pada {{ $curriculum->name }}.</p>

                            <div class="table-responsive">
                                <table class="table table-hover align-middle border-top">
                                    <thead class="bg-light">
                                        <tr>
                                            <th class="py-3 px-4" style="width: 120px;">Kode</th>
                                            <th class="py-3">Mata Kuliah</th>
                                            <th class="py-3 text-center" style="width: 80px;">SKS</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $semSubjects = $subjects->where('semester', $i); @endphp
                                        
                                        @forelse($semSubjects as $subject)
                                        <tr>
                                            <td class="px-4 font-monospace text-success fw-bold">{{ $subject->code }}</td>
                                            <td>
                                                <div class="fw-bold text-dark">{{ $subject->name }}</div>
                                                @if($subject->description)
                                                    <small class="text-muted d-block lh-sm mt-1">{{ Str::limit($subject->description, 100) }}</small>
                                                @endif
                                            </td>
                                            <td class="text-center fw-bold">{{ $subject->sks }}</td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="3" class="text-center py-5 text-muted italic">
                                                Tidak ada mata kuliah yang terdaftar untuk semester ini.
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    @endfor
                @endif

            </div>{{-- .profil-content-area --}}
        </div>{{-- .profil-grid --}}
    </div>
</div>

<style>
/* CSS Tambahan Khusus Kurikulum */
.bg-forest { background-color: var(--forest) !important; color: white; }
.font-monospace { letter-spacing: 1px; font-size: 0.9rem; }
.table thead th { 
    font-size: 0.75rem; 
    text-transform: uppercase; 
    letter-spacing: 1px; 
    color: var(--muted);
}
.profil-card-title { font-size: 1.4rem; }
</style>

<script>
(function () {
    const navItems = document.querySelectorAll('.profil-nav-item');
    const panels   = document.querySelectorAll('.profil-panel');

    navItems.forEach(btn => {
        btn.addEventListener('click', () => {
            const target = btn.dataset.target;

            /* Nav active state */
            navItems.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');

            /* Panel switching logic */
            panels.forEach(p => p.classList.remove('active'));
            const panel = document.getElementById('panel-' + target);
            if (panel) panel.classList.add('active');

            /* Scroll to top of content on mobile */
            if (window.innerWidth <= 900 && panel) {
                panel.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });
})();
</script>

@endsection
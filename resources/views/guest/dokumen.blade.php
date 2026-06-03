@extends('layouts.guest_layout')

@section('title', 'Dokumen & SOP - Teknik Bioproses IT Del')

@section('content')

{{-- HEADER --}}
<div class="profil-header">
    <div class="container profil-header-inner text-center">
        <span class="bp-tag">Pusat Unduhan</span>
        <h1>Dokumen & <em>SOP</em></h1>
        <p>Akses berkas administrasi, pedoman akademik, dan standar operasional prosedur</p>
    </div>
    <div class="profil-header-cut"></div>
</div>

<div class="profil-body">
    <div class="container">
        <div class="profil-grid">

            {{-- Sidebar Navigasi Berdasarkan Kategori Dokumen --}}
            <aside class="profil-sidenav">
                <span class="profil-sidenav-label">Kategori Dokumen</span>
                <button class="profil-nav-item active" data-target="all">
                    <span class="pni-dot"></span> Semua Dokumen
                </button>
                <div class="profil-nav-divider"></div>
                @php
                    $categories = ['Pedoman', 'SOP', 'Formulir', 'Akreditasi', 'Lainnya'];
                @endphp
                @foreach($categories as $cat)
                    <button class="profil-nav-item" data-target="{{ Str::slug($cat) }}">
                        <span class="pni-dot"></span> {{ $cat }}
                    </button>
                @endforeach
            </aside>

            {{-- Content Area --}}
            <div class="profil-content-area">

                {{-- PANEL UTAMA --}}
                <div class="profil-panel active" id="panel-all">
                    <div class="profil-card">
                        <h2 class="profil-card-title">Daftar Berkas Akademik</h2>
                        <span class="profil-card-divider"></span>
                        
                        <div class="list-group list-group-flush mt-3">
                            @forelse($archives as $doc)
                                <div class="list-group-item px-0 py-3 border-bottom d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-start gap-3">
                                        <div class="fs-2 text-danger"><i class="bi bi-file-earmark-pdf"></i></div>
                                        <div>
                                            <h6 class="fw-bold mb-1 text-dark">{{ $doc->title }}</h6>
                                            <div class="small text-muted">
                                                <span class="badge bg-light text-dark border me-2">{{ $doc->category }}</span>
                                                Tahun: {{ $doc->year ?? '-' }}
                                            </div>
                                        </div>
                                    </div>
                                    <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" class="btn btn-forest btn-sm rounded-pill px-4 shadow-sm">
                                        <i class="bi bi-download me-1"></i> Unduh
                                    </a>
                                </div>
                            @empty
                                <p class="text-center py-5 text-muted italic">Belum ada dokumen yang tersedia.</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                {{-- PANEL FILTER PER KATEGORI --}}
                @foreach($categories as $cat)
                <div class="profil-panel" id="panel-{{ Str::slug($cat) }}">
                    <div class="profil-card">
                        <h2 class="profil-card-title">Kategori: {{ $cat }}</h2>
                        <span class="profil-card-divider"></span>
                        
                        <div class="list-group list-group-flush mt-3">
                            @php $filtered = $archives->where('category', $cat); @endphp
                            @forelse($filtered as $doc)
                                <div class="list-group-item px-0 py-3 border-bottom d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-start gap-3">
                                        <div class="fs-2 text-danger"><i class="bi bi-file-earmark-pdf"></i></div>
                                        <div>
                                            <h6 class="fw-bold mb-1">{{ $doc->title }}</h6>
                                            <small class="text-muted">Diunggah pada: {{ $doc->created_at->format('d/m/Y') }}</small>
                                        </div>
                                    </div>
                                    <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" class="btn btn-forest btn-sm rounded-pill px-4">Unduh</a>
                                </div>
                            @empty
                                <p class="text-center py-5 text-muted italic">Tidak ada dokumen dalam kategori ini.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
                @endforeach

            </div>
        </div>
    </div>
</div>

<style>
.btn-forest { background-color: var(--forest); color: white; border: none; transition: 0.3s; }
.btn-forest:hover { background-color: var(--teal); color: white; transform: translateY(-2px); }
</style>

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
        });
    });
})();
</script>

@endsection
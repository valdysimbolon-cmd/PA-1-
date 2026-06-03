@extends('layouts.guest_layout')

@section('title', 'Berita & Kegiatan - Teknik Bioproses IT Del')

@section('content')

{{-- HEADER TETAP --}}
<div class="profil-header">
    <div class="container profil-header-inner">
        <span class="bp-tag">Kabar Terkini</span>
        <h1>Berita & <em>Kegiatan</em></h1>
        <p>Informasi aktivitas akademik dan kemahasiswaan Teknik Bioproses IT Del</p>
    </div>
    <div class="profil-header-cut"></div>
</div>

{{-- BODY DENGAN GRID 3 KOLOM --}}
<div class="profil-body">
    <div class="container-fluid px-lg-5">
        <div class="profil-grid" style="grid-template-columns: 250px 1fr; gap: 30px;">

            {{-- ── Sidebar Nav ── --}}
            <aside class="profil-sidenav">
                <span class="profil-sidenav-label">Pilih Kategori</span>
                <button class="profil-nav-item active" data-target="all">
                    <span class="pni-dot"></span> Semua Kabar
                </button>
                <div class="profil-nav-divider"></div>
                @foreach($categories as $cat)
                    <button class="profil-nav-item" data-target="{{ Str::slug($cat->name) }}">
                        <span class="pni-dot"></span> {{ $cat->name }}
                    </button>
                @endforeach
            </aside>

            {{-- ── Content Area ── --}}
            <div class="profil-content-area">

                {{-- PANEL SEMUA BERITA --}}
                <div class="profil-panel active" id="panel-all">
                    <div class="profil-card border-0 bg-transparent p-0">
                        <div class="row g-4">
                            @forelse($allNews as $item)
                                <div class="col-xl-4 col-md-6">
                                    <div class="card h-100 border-0 shadow-sm overflow-hidden" style="border-radius: 15px; transition: 0.3s;">
                                        <img src="{{ asset('storage/' . $item->image) }}" class="card-img-top" style="height: 180px; object-fit: cover;" alt="Berita">
                                        
                                        <div class="card-body p-4 bg-white">
                                            <small class="text-muted d-block mb-2"><i class="bi bi-calendar3"></i> {{ \Carbon\Carbon::parse($item->published_at)->format('d M Y') }}</small>
                                            <h6 class="fw-bold lh-base mb-3" style="color: var(--forest); height: 45px; overflow: hidden;">
                                                {{ Str::limit($item->title, 55) }}
                                            </h6>
                                            <p class="text-muted small mb-4" style="height: 60px; overflow: hidden;">
                                                {{ Str::limit(strip_tags($item->content), 90) }}
                                            </p>
                                            <a href="{{ route('public.news.show', $item->id) }}" class="text-teal small fw-bold text-decoration-none">BACA SELENGKAPNYA →</a>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12 text-center py-5 text-muted italic">Belum ada berita.</div>
                            @endforelse
                        </div>
                    </div>
                </div>

                {{-- PANEL PER KATEGORI --}}
                @foreach($categories as $cat)
                <div class="profil-panel" id="panel-{{ Str::slug($cat->name) }}">
                    <div class="profil-card border-0 bg-transparent p-0">
                        <div class="row g-4">
                            @php $filteredNews = $allNews->where('category_id', $cat->id); @endphp
                            @forelse($filteredNews as $item)
                                <div class="col-xl-4 col-md-6">
                                    <div class="card h-100 border-0 shadow-sm overflow-hidden" style="border-radius: 15px;">
                                        <img src="{{ asset('storage/' . $item->image) }}" class="card-img-top" style="height: 180px; object-fit: cover;" alt="Berita">
                                        <div class="card-body p-4 bg-white">
                                            <small class="text-muted d-block mb-2">{{ \Carbon\Carbon::parse($item->published_at)->format('d M Y') }}</small>
                                            <h6 class="fw-bold lh-base mb-3" style="color: var(--forest);">{{ Str::limit($item->title, 55) }}</h6>
                                            <a href="{{ route('public.news.show', $item->id) }}" class="text-teal small fw-bold text-decoration-none">BACA SELENGKAPNYA →</a>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12 text-center py-5 text-muted italic">Belum ada berita di kategori ini.</div>
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
.card:hover { transform: translateY(-8px); box-shadow: 0 15px 30px rgba(26, 77, 46, 0.1) !important; }
.lh-base { line-height: 1.5 !important; }
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
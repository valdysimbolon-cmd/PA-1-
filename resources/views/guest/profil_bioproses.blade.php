@extends('layouts.guest_layout')

@section('title', 'Profil Program Studi - Teknik Bioproses IT Del')

@section('content')

{{-- ══════ HEADER ══════ --}}
<div class="profil-header">
    <div class="container profil-header-inner">
        <span class="bp-tag">Mengenal Lebih Dekat</span>
        <h1>Profil <em>Program Studi</em></h1>
        <p>Identitas, Visi, dan Masa Depan Teknik Bioproses IT Del</p>
    </div>
    <div class="profil-header-cut"></div>
</div>

<div class="profil-body">
    <div class="container">
        <div class="profil-grid">

            {{-- ── Sidebar Nav ── --}}
            <aside class="profil-sidenav">
                <span class="profil-sidenav-label">Navigasi</span>

                @foreach($profiles as $data) {{-- Loop otomatis dari Controller P_ --}}
                    <button class="profil-nav-item {{ $loop->first ? 'active' : '' }}" data-target="{{ Str::slug($data->key) }}">
                        <span class="pni-dot"></span> {{ $data->name }}
                    </button>
                    @if(!$loop->last)
                        <div class="profil-nav-divider"></div>
                    @endif
                @endforeach
            </aside>

            {{-- ── Content Area ── --}}
            <div class="profil-content-area">
                
                @foreach($profiles as $data)
                <div class="profil-panel {{ $loop->first ? 'active' : '' }}" id="panel-{{ Str::slug($data->key) }}">
                    <div class="profil-card">
                        <h2 class="profil-card-title">{{ $data->name }}</h2>
                        <span class="profil-card-divider"></span>
                        
                        @if($data->image)
                            <img src="{{ asset('storage/'.$data->image) }}" class="profil-content-img img-fluid mb-4" alt="{{ $data->name }}">
                        @endif
                        
                        <div class="profil-desc">
                            {!! $data->description !!}
                        </div>
                    </div>
                </div>
                @endforeach

                @if($profiles->isEmpty())
                    <div class="text-center py-5"><p class="text-muted">Konten profil belum tersedia.</p></div>
                @endif

            </div>
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
            const panel = document.getElementById('panel-' + target);
            if (panel) panel.classList.add('active');

            if (window.innerWidth <= 900 && panel) {
                panel.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });
})();
</script>
@endsection
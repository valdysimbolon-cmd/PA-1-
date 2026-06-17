@extends('layouts.guest_layout')

@section('title', 'Profil Program Studi - Teknik Bioproses IT Del')

@section('content')

{{-- ══════ HEADER (gaya mirip kurikulum) ══════ --}}
<div class="ph-wrap">

    {{-- Foto background --}}
    <div class="ph-bg"></div>

    {{-- Overlay glossy --}}
    <div class="ph-overlay"></div>

    {{-- Grid pattern --}}
    <div class="ph-grid"></div>

    {{-- Vignette bawah --}}
    <div class="ph-vignette"></div>

    <div class="container ph-inner">
        <div class="ph-eyebrow">Mengenal lebih dekat</div>
        <h1 class="ph-title">Profil <em>Program Studi</em></h1>
        <p class="ph-sub">Identitas, visi, dan masa depan Teknik Bioproses IT Del</p>
    </div>

    <div class="ph-wave">
        <svg viewBox="0 0 1440 70" preserveAspectRatio="none" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0,40 C360,80 1080,0 1440,40 L1440,70 L0,70 Z" fill="#F4F8F5" stroke="none"/>
        </svg>
    </div>
</div>

{{-- ══════ BODY (konten profil tidak berubah) ══════ --}}
<div class="profil-body">
    <div class="container">
        <div class="row g-4 align-items-start">

            {{-- Sidebar --}}
            <div class="col-lg-3 profil-sidebar">
                <div class="sidebar-card">
                    <div class="sidebar-head">
                        <div class="sidebar-head-dot"></div>
                        <span>Navigasi</span>
                    </div>
                    <nav class="sidebar-nav" role="navigation" aria-label="Navigasi profil">
                        @foreach($profiles as $data)
                            <button
                                class="pnav-item {{ $loop->first ? 'active' : '' }}"
                                data-target="{{ Str::slug($data->key) }}"
                                aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                                <span class="pnav-num">{{ $loop->iteration }}</span>
                                {{ $data->name }}
                            </button>
                            @if(!$loop->last)
                                <div class="pnav-divider"></div>
                            @endif
                        @endforeach
                    </nav>
                </div>
            </div>

            {{-- Content --}}
            <div class="col-lg-9">
                @foreach($profiles as $data)
                <div class="profil-panel {{ $loop->first ? 'active' : '' }}" id="panel-{{ Str::slug($data->key) }}">
                    <div class="content-card">
                        <div class="content-card-top">
                            <h2 class="content-card-title">{{ $data->name }}</h2>
                        </div>
                        <div class="content-card-body">
                            @if($data->image)
                                <img src="{{ asset('storage/' . $data->image) }}"
                                     class="content-card-img"
                                     alt="{{ $data->name }}">
                            @endif
                            <div class="content-prose">
                                {!! $data->description !!}
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

                @if($profiles->isEmpty())
                    <div class="content-card">
                        <div class="content-card-body text-center py-5">
                            <p class="text-muted">Konten profil belum tersedia.</p>
                        </div>
                    </div>
                @endif
            </div>

        </div>
    </div>
</div>

    <style>
        :root {
            --bg-image: url("{{ asset('guest_assets/img/lab-del.jpeg') }}");
        }
    </style>

<script>
(function () {
    const btns   = document.querySelectorAll('.pnav-item');
    const panels = document.querySelectorAll('.profil-panel');

    btns.forEach(btn => {
        btn.addEventListener('click', () => {
            const target = btn.dataset.target;

            btns.forEach(b => { b.classList.remove('active'); b.setAttribute('aria-selected','false'); });
            btn.classList.add('active');
            btn.setAttribute('aria-selected','true');

            panels.forEach(p => p.classList.remove('active'));
            const panel = document.getElementById('panel-' + target);
            if (panel) {
                panel.classList.add('active');
                if (window.innerWidth < 992) {
                    setTimeout(() => panel.scrollIntoView({ behavior: 'smooth', block: 'start' }), 50);
                }
            }
        });
    });
})();
</script>

@endsection
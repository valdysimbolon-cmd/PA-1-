@extends('layouts.guest_layout')

@section('title', 'Kurikulum & Struktur Mata Kuliah - Teknik Bioproses IT Del')

@push('styles')
<style>
        :root {
        --bg-image: url('{{ asset("guest_assets/img/saung-del.jpeg") }}');
    }
</style>
@endpush

@section('content')

{{-- ══════ HEADER ══════ --}}
<div class="ph-wrap">

    {{-- Foto background --}}
    <div class="ph-bg"></div>

    {{-- Overlay gelap tipis --}}
    <div class="ph-overlay"></div>

    {{-- Grid pattern --}}
    <div class="ph-grid"></div>

    {{-- Vignette bawah --}}
    <div class="ph-vignette"></div>

    <div class="container ph-inner">
        <div class="ph-eyebrow">Akademik</div>
        <h1 class="ph-title">Struktur <em>Kurikulum</em></h1>
        <p class="ph-sub">Peta perjalanan akademik menuju keahlian rekayasa hayati yang unggul</p>

        @if($curriculum)
        <div class="ph-stats">
            <div class="ph-stat-card">
                <span class="ph-stat-num">8</span>
                <span class="ph-stat-label">Semester</span>
            </div>
            <div class="ph-stat-card">
                <span class="ph-stat-num">{{ $subjects->sum('sks') }}</span>
                <span class="ph-stat-label">Total SKS</span>
            </div>
            <div class="ph-stat-card">
                <span class="ph-stat-num">{{ $subjects->count() }}</span>
                <span class="ph-stat-label">Mata Kuliah</span>
            </div>
        </div>
        @endif
    </div>

    <div class="ph-wave">
        <svg viewBox="0 0 1440 70" preserveAspectRatio="none" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0,40 C360,80 1080,0 1440,40 L1440,70 L0,70 Z" fill="#F4F8F5"/>
        </svg>
    </div>
</div>

{{-- ══════ BODY ══════ --}}
<div class="kuri-body">
    <div class="container">
        <div class="row g-4 align-items-start">

            {{-- Sidebar --}}
            <div class="col-lg-3 profil-sidebar">
                <div class="sidebar-card">
                    <div class="sidebar-head">
                        <div class="sidebar-head-dot"></div>
                        <span>Pilih Semester</span>
                    </div>
                    <nav class="sidebar-nav" aria-label="Navigasi semester">
                        @for($i = 1; $i <= 8; $i++)
                        <button
                            class="pnav-item {{ $i == 1 ? 'active' : '' }}"
                            data-target="sem-{{ $i }}">
                            <span class="pnav-num">{{ $i }}</span>
                            Semester {{ $i }}
                            @if($curriculum)
                            <span class="pnav-meta">{{ $subjects->where('semester', $i)->sum('sks') }} SKS</span>
                            @endif
                        </button>
                        @if($i < 8)<div class="pnav-divider"></div>@endif
                        @endfor
                    </nav>
                </div>
            </div>

            {{-- Content --}}
            <div class="col-lg-9">

                @if(!$curriculum)
                    <div class="content-card">
                        <div class="empty-state">
                            <i class="bi bi-journal-x"></i>
                            <p>Data kurikulum belum tersedia atau belum diaktifkan.</p>
                        </div>
                    </div>
                @else
                    @for($i = 1; $i <= 8; $i++)
                    @php $semSubjects = $subjects->where('semester', $i); @endphp
                    <div class="profil-panel {{ $i == 1 ? 'active' : '' }}" id="panel-sem-{{ $i }}">
                        <div class="content-card">

                            {{-- Panel Header --}}
                            <div class="content-card-top">
                                <div>
                                    <h2 class="content-card-title">Semester {{ $i }}</h2>
                                    <p class="content-card-sub">
                                        {{ $semSubjects->count() }} mata kuliah ·
                                        {{ $curriculum->name }}
                                    </p>
                                </div>
                                <div class="sks-badge">
                                    <span class="sks-badge-num">{{ $semSubjects->sum('sks') }}</span>
                                    <span class="sks-badge-label">Total SKS</span>
                                </div>
                            </div>

                            {{-- Table --}}
                            <div class="kuri-table-wrap">
                                <table class="kuri-table">
                                    <thead>
                                        <tr>
                                            <th style="width:110px">Kode</th>
                                            <th>Mata Kuliah</th>
                                            <th style="width:70px" class="text-center">SKS</th>
                                            <th style="width:44px"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($semSubjects as $subject)
                                        <tr class="subject-row" data-id="{{ $subject->id }}">
                                            <td><span class="subject-code">{{ $subject->code }}</span></td>
                                            <td>
                                                <div class="subject-name">{{ $subject->name }}</div>
                                                @if($subject->description)
                                                <div class="subject-hint">
                                                    <i class="bi bi-chevron-down"></i> Klik untuk melihat deskripsi
                                                </div>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <span class="sks-pill">{{ $subject->sks }}</span>
                                            </td>
                                            <td class="text-center">
                                                @if($subject->description)
                                                <span class="expand-icon"><i class="bi bi-plus"></i></span>
                                                @endif
                                            </td>
                                        </tr>

                                        @if($subject->description)
                                        <tr class="desc-row" id="desc-{{ $subject->id }}">
                                            <td colspan="4" class="desc-cell">
                                                <div class="desc-inner">
                                                    <div class="desc-label">Deskripsi mata kuliah</div>
                                                    <div class="desc-text">
                                                        {!! nl2br(e($subject->description)) !!}
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @endif

                                        @empty
                                        <tr>
                                            <td colspan="4">
                                                <div class="empty-state">
                                                    <i class="bi bi-inbox"></i>
                                                    <p>Belum ada mata kuliah untuk semester ini.</p>
                                                </div>
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

            </div>
        </div>
    </div>
</div>

<script>
(function () {
    /* ── Semester tab switching ── */
    const btns   = document.querySelectorAll('.pnav-item');
    const panels = document.querySelectorAll('.profil-panel');

    btns.forEach(btn => {
        btn.addEventListener('click', () => {
            const target = btn.dataset.target;
            btns.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
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

    /* ── Subject row expand/collapse ── */
    document.querySelectorAll('.subject-row').forEach(row => {
        row.addEventListener('click', () => {
            const id      = row.dataset.id;
            const descRow = document.getElementById('desc-' + id);
            if (!descRow) return;

            const isOpen = row.classList.contains('open');

            /* Close all others in same panel */
            const panel = row.closest('.profil-panel');
            panel.querySelectorAll('.subject-row.open').forEach(r => {
                r.classList.remove('open');
                const dRow = document.getElementById('desc-' + r.dataset.id);
                if (dRow) dRow.classList.remove('open');
            });

            if (!isOpen) {
                row.classList.add('open');
                descRow.classList.add('open');
            }
        });
    });
})();
</script>

@endsection
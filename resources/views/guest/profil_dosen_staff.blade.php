@extends('layouts.guest_layout')

@section('title', 'Dosen & Staf - Teknik Bioproses IT Del')

@section('content')

<div class="profil-header">
    <div class="container profil-header-inner text-start">
        <span class="bp-tag">Civitas Academica</span>
        <h1>Dosen & <em>Staf</em></h1>
        <p>Tenaga pendidik dan kependidikan Program Studi Teknik Bioproses Institut Teknologi Del</p>
    </div>
    <div class="profil-header-cut"></div>
</div>

<div class="profil-body">
    <div class="container py-2">

        {{-- Tab sederhana --}}
        <div class="ds-tabs">
            <button class="ds-tab active" data-panel="dosen">Dosen</button>
            <button class="ds-tab" data-panel="staf">Staf / Tendik</button>
        </div>

        {{-- Panel Dosen --}}
        <div class="ds-panel active" id="ds-dosen">
            <div class="ds-grid">
                @forelse($lecturers as $dsn)
                <a href="/staff-detail/{{ $dsn->id }}" class="ds-card">
                    <div class="ds-img">
                        <img src="{{ $dsn->image ? asset('storage/'.$dsn->image) : 'https://ui-avatars.com/api/?name='.urlencode($dsn->name).'&background=DFF0E7&color=1A4D2E&size=300&bold=true' }}"
                             alt="{{ $dsn->name }}">
                    </div>
                    <div class="ds-info">
                        <div class="ds-name">{{ $dsn->name }}</div>
                        @if($dsn->academic_position)
                            <div class="ds-pos">{{ $dsn->academic_position }}</div>
                        @endif
                        @if($dsn->academic_level)
                            <div class="ds-sub">{{ $dsn->academic_level }}</div>
                        @endif
                    </div>
                </a>
                @empty
                <p class="text-muted">Data dosen belum tersedia.</p>
                @endforelse
            </div>
        </div>

        {{-- Panel Staf --}}
        <div class="ds-panel" id="ds-staf">
            <div class="ds-grid">
                @forelse($staf as $stf)
                <a href="/staff-detail/{{ $stf->id }}" class="ds-card">
                    <div class="ds-img">
                        <img src="{{ $stf->image ? asset('storage/'.$stf->image) : 'https://ui-avatars.com/api/?name='.urlencode($stf->name).'&background=DFF0E7&color=1A4D2E&size=300&bold=true' }}"
                             alt="{{ $stf->name }}">
                    </div>
                    <div class="ds-info">
                        <div class="ds-name">{{ $stf->name }}</div>
                        @if($stf->structural_position)
                            <div class="ds-pos">{{ $stf->structural_position }}</div>
                        @endif
                        @if($stf->nip_nidn)
                            <div class="ds-sub">{{ $stf->nip_nidn }}</div>
                        @endif
                    </div>
                </a>
                @empty
                <p class="text-muted">Data staf belum tersedia.</p>
                @endforelse
            </div>
        </div>

    </div>
</div>

<style>
/* Tab */
.ds-tabs {
    display: flex; gap: 0;
    border-bottom: 1.5px solid var(--border, rgba(223,240,231,.8));
    margin-bottom: 2rem;
}
.ds-tab {
    padding: .65rem 1.5rem;
    font-family: 'DM Sans', sans-serif;
    font-size: .85rem; font-weight: 600;
    color: var(--muted, #6B8F7A);
    background: none; border: none;
    border-bottom: 2.5px solid transparent;
    margin-bottom: -1.5px; cursor: pointer;
    transition: color .2s, border-color .2s;
}
.ds-tab:hover { color: var(--forest, #1A4D2E); }
.ds-tab.active { color: var(--forest, #1A4D2E); border-bottom-color: var(--accent, #4CAF7C); }

/* Panel */
.ds-panel { display: none; }
.ds-panel.active { display: block; }

/* Grid */
.ds-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
    gap: 1.25rem;
}

/* Card — seluruh kartu adalah link */
.ds-card {
    text-decoration: none;
    background: #fff;
    border: 1px solid rgba(223,240,231,.9);
    overflow: hidden;
    display: flex; flex-direction: column;
    transition: transform .28s, box-shadow .28s;
}
.ds-card::before {
    content: ''; display: block; height: 2.5px;
    background: var(--cream-deep, #DFF0E7);
    transition: background .28s;
}
.ds-card:hover { transform: translateY(-4px); box-shadow: 0 10px 28px rgba(26,77,46,.09); }
.ds-card:hover::before { background: var(--accent, #4CAF7C); }

/* Foto */
.ds-img { height: 210px; overflow: hidden; background: var(--cream, #F0F7F2); }
.ds-img img {
    width: 100%; height: 100%;
    object-fit: cover; object-position: top;
    display: block; transition: transform .45s;
}
.ds-card:hover .ds-img img { transform: scale(1.05); }

/* Info */
.ds-info { padding: .9rem 1rem 1rem; }
.ds-name {
    font-family: 'Playfair Display', serif;
    font-size: .92rem; font-weight: 700;
    color: var(--forest, #1A4D2E); line-height: 1.3;
    margin-bottom: .25rem;
}
.ds-pos {
    font-size: .68rem; font-weight: 600;
    color: var(--teal, #1D9E75);
    text-transform: uppercase; letter-spacing: .07em;
    margin-bottom: .15rem;
}
.ds-sub { font-size: .68rem; color: var(--muted, #6B8F7A); }

@media (max-width: 600px) {
    .ds-grid { grid-template-columns: repeat(2, 1fr); }
}
</style>

<script>
document.querySelectorAll('.ds-tab').forEach(function(tab){
    tab.addEventListener('click', function(){
        document.querySelectorAll('.ds-tab').forEach(function(t){ t.classList.remove('active'); });
        document.querySelectorAll('.ds-panel').forEach(function(p){ p.classList.remove('active'); });
        tab.classList.add('active');
        document.getElementById('ds-' + tab.dataset.panel).classList.add('active');
    });
});
</script>

@endsection
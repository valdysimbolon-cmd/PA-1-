@extends('layouts.guest_layout')

@section('title', 'SDM - Teknik Bioproses IT Del')

@section('content')

{{-- HEADER --}}
<div class="profil-header">
    <div class="container profil-header-inner">
        <span class="bp-tag">Sumber Daya Manusia</span>
        <h1>Dosen & <em>Staff</em></h1>
        <p>Mengenal lebih dekat para pendidik dan tenaga kependidikan Teknik Bioproses</p>
    </div>
    <div class="profil-header-cut"></div>
</div>

<div class="profil-body">
    <div class="container">
        <div class="profil-grid">

            {{-- Sidebar Nav --}}
            <aside class="profil-sidenav">
                <span class="profil-sidenav-label">Kategori</span>
                <button class="profil-nav-item active" data-target="dosen"><span class="pni-dot"></span> Tenaga Pendidik (Dosen)</button>
                <div class="profil-nav-divider"></div>
                <button class="profil-nav-item" data-target="staff"><span class="pni-dot"></span> Tenaga Kependidikan (Staff)</button>
            </aside>

            {{-- Content Area --}}
            <div class="profil-content-area">
                @php
                    $listStaff = ['Staff Administrasi', 'Laboran', 'Teknisi', 'Kebersihan', 'Lainnya / Staff'];
                @endphp

                @foreach(['dosen', 'staff'] as $group)
                <div class="profil-panel {{ $group == 'dosen' ? 'active' : '' }}" id="panel-{{ $group }}">
                    <div class="profil-card">
                        <h2 class="profil-card-title">{{ $group == 'dosen' ? 'Tenaga Pendidik' : 'Tenaga Kependidikan' }}</h2>
                        <span class="profil-card-divider"></span>
                        
                        <div class="ds-grid">
                            @foreach($lecturers as $person)
                                @php
                                    $isStaff = in_array($person->academic_position, $listStaff);
                                    $currentGroup = $isStaff ? 'staff' : 'dosen';
                                @endphp

                                @if($currentGroup == $group)
                                    <div class="ds-card" onclick="openModal(this)"
                                         data-name="{{ $person->name }}" data-nip="{{ $person->nip_nidn }}"
                                         data-pos="{{ $person->academic_position }}" data-struct="{{ $person->structural_position }}"
                                         data-email="{{ $person->email }}" data-office="{{ $person->office }}"
                                         data-teaching="{{ $person->teaching_history }}"
                                         data-educations="{{ json_encode($person->educations) }}"
                                         data-publications="{{ json_encode($person->publications) }}"
                                         data-achievements="{{ json_encode($person->achievements) }}"
                                         data-image="{{ $person->image ? asset('storage/'.$person->image) : '' }}">
                                        
                                        <div class="ds-img-wrap">
                                            <img src="{{ $person->image ? asset('storage/'.$person->image) : 'https://ui-avatars.com/api/?name='.urlencode($person->name).'&size=300' }}" class="ds-img">
                                        </div>
                                        <div class="ds-card-body">
                                            <div class="ds-card-name">{{ $person->name }}</div>
                                            <div class="ds-card-pos">{{ $person->structural_position ?? $person->academic_position }}</div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

{{-- MODAL DETAIL (DENGAN SISTEM TAB) --}}
<div class="ds-backdrop" id="dsBackdrop">
    <div class="ds-modal">
        <button class="ds-modal-close" onclick="closeModal()">&times;</button>
        <div class="modal-grid">
            <div class="modal-sidebar">
                <img id="mImg" src="" class="m-photo-big">
                <h4 id="mName" class="fw-bold mb-1" style="font-family: 'Playfair Display'; color: var(--forest);"></h4>
                <p id="mNip" class="text-muted small mb-4"></p>
                <ul class="info-list text-start">
                    <li><label>Jabatan</label><span id="mPos"></span></li>
                    <li><label>Email</label><span id="mEmail"></span></li>
                    <li><label>Kantor</label><span id="mOffice"></span></li>
                </ul>
            </div>
            
            <div class="modal-main text-start">
                <ul class="nav nav-tabs mb-3" id="dosenTab" role="tablist">
                    <li class="nav-item"><button class="nav-link active fw-bold small" data-bs-toggle="tab" data-bs-target="#tab-bio">PENDIDIKAN</button></li>
                    <li class="nav-item"><button class="nav-link fw-bold small" data-bs-toggle="tab" data-bs-target="#tab-riset">PUBLIKASI</button></li>
                    <li class="nav-item"><button class="nav-link fw-bold small" data-bs-toggle="tab" data-bs-target="#tab-ach">PRESTASI</button></li>
                </ul>

                <div class="tab-content pt-2">
                    <div class="tab-pane fade show active" id="tab-bio">
                        <div class="section-title mt-0 small">Riwayat Pendidikan</div>
                        <div id="mPendidikan" class="small text-muted mb-4"></div>
                        <div class="section-title small">Riwayat Mengajar</div>
                        <div id="mTeaching" class="small text-dark"></div>
                    </div>
                    <div class="tab-pane fade" id="tab-riset">
                        <div id="mPublikasi" class="small"></div>
                    </div>
                    <div class="tab-pane fade" id="tab-ach">
                        <div id="mPrestasi" class="small"></div>
                    </div>
                </div>
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
            navItems.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            panels.forEach(p => p.classList.remove('active'));
            document.getElementById('panel-' + btn.dataset.target).classList.add('active');
        });
    });
})();

function openModal(el) {
    const d = el.dataset;
    document.getElementById('mName').innerText = d.name;
    document.getElementById('mNip').innerText = d.nip ? 'NIP/NIDN: ' + d.nip : '-';
    document.getElementById('mPos').innerText = d.struct || d.pos || '-';
    document.getElementById('mEmail').innerText = d.email || '-';
    document.getElementById('mOffice').innerText = d.office || '-';
    document.getElementById('mTeaching').innerText = d.teaching || 'Tidak ada riwayat mengajar.';
    
    // PENDIDIKAN
    const edus = JSON.parse(d.educations || '[]');
    let eduHtml = edus.length ? '<ul>' : '<em>Data belum tersedia.</em>';
    edus.forEach(e => { eduHtml += `<li><b>${e.degree}</b> - ${e.campus} (${e.study_program})</li>`; });
    document.getElementById('mPendidikan').innerHTML = edus.length ? eduHtml + '</ul>' : eduHtml;

    // PUBLIKASI
    const pubs = JSON.parse(d.publications || '[]');
    let pubHtml = pubs.length ? '<div class="list-group list-group-flush">' : '<em>Belum ada publikasi.</em>';
    pubs.forEach(p => {
        pubHtml += `<div class="list-group-item px-0 border-0 mb-2 border-bottom">
            <span class="badge bg-success mb-1" style="font-size:10px">${p.publication.type} | ${p.publication.year}</span>
            <div class="fw-bold text-dark">${p.publication.title}</div>
        </div>`;
    });
    document.getElementById('mPublikasi').innerHTML = pubs.length ? pubHtml + '</div>' : pubHtml;

    // PRESTASI
    const achs = JSON.parse(d.achievements || '[]');
    let achHtml = achs.length ? '<div class="list-group list-group-flush">' : '<em>Belum ada prestasi.</em>';
    achs.forEach(a => {
        achHtml += `<div class="list-group-item px-0 border-0 mb-2 border-bottom">
            <span class="badge bg-warning text-dark mb-1" style="font-size:10px">${a.level} | ${a.year}</span>
            <div class="fw-bold text-dark">${a.title}</div>
            <div class="text-success small">${a.rank}</div>
        </div>`;
    });
    document.getElementById('mPrestasi').innerHTML = achs.length ? achHtml + '</div>' : achHtml;

    document.getElementById('mImg').src = d.image || 'https://ui-avatars.com/api/?name=' + encodeURIComponent(d.name) + '&size=300';
    document.getElementById('dsBackdrop').classList.add('open');
    document.body.style.overflow = 'hidden';
}

function closeModal() {
    document.getElementById('dsBackdrop').classList.remove('open');
    document.body.style.overflow = '';
}
</script>
@endsection
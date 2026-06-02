@extends('layouts.guest_layout')

@section('title', 'Profil Dosen & Staff - Teknik Bioproses IT Del')

@section('content')

<div class="ds-header">
    <div class="container ds-header-inner text-center">
        <span class="bp-tag">Sumber Daya Manusia</span>
        <h1>Dosen & <em>Staff</em></h1>
        <p>Mengenal lebih dekat para pendidik Teknik Bioproses IT Del</p>
    </div>
    <div class="ds-header-cut"></div>
</div>

<div class="ds-body">
    <div class="container">
        <!-- Tab Navigasi -->
        <div class="ds-tabs">
            <button class="ds-tab-btn active" data-group="dosen">Tenaga Pendidik (Dosen)</button>
            <button class="ds-tab-btn" data-group="staff">Tenaga Kependidikan (Staff)</button>
        </div>

        <div class="ds-grid" id="dsGrid">
            @forelse($lecturers as $person)
                @php
                    // Daftar jabatan yang dianggap sebagai Staff
                    $listJabatanStaff = ['Staff Administrasi', 'Laboran', 'Teknisi', 'Kebersihan', 'Lainnya / Staff'];
                    
                    // Cek apakah jabatan orang ini ada dalam daftar staff
                    $isStaff = in_array($person->academic_position, $listJabatanStaff);
                    
                    // Tentukan group-nya untuk filter Javascript
                    $groupType = $isStaff ? 'staff' : 'dosen';
                @endphp

                <div class="ds-card" 
                    data-group="{{ $groupType }}" 
                    data-name="{{ strtolower($person->name) }}"
                    data-nip="{{ $person->nip_nidn }}"
                    data-pos="{{ $person->academic_position }}"
                    data-struct="{{ $person->structural_position }}"
                    data-email="{{ $person->email }}"
                    data-office="{{ $person->office }}"
                    data-teaching="{{ $person->teaching_history }}"
                    {{-- Ambil data pendidikan untuk modal --}}
                    data-educations="{{ json_encode($person->educations) }}"
                    data-image="{{ $person->image ? asset('storage/'.$person->image) : '' }}"
                    onclick="openModal(this)">
                    
                    <div class="ds-img-wrap">
                        @if($person->image)
                            <img src="{{ asset('storage/'.$person->image) }}" class="ds-img">
                        @else
                            <div class="h-100 d-flex align-items-center justify-content-center bg-secondary text-white">
                                <i class="bi bi-person" style="font-size: 4rem;"></i>
                            </div>
                        @endif
                    </div>
                    <div class="ds-card-body">
                        <div class="ds-card-name">{{ $person->name }}</div>
                        <div class="ds-card-pos">{{ $person->structural_position ?? $person->academic_position }}</div>
                    </div>
                </div>
            @empty
                <div class="text-center py-5 w-100">Data belum tersedia.</div>
            @endforelse
        </div>
    </div>
</div>

<!-- MODAL DETAIL -->
<div class="ds-backdrop" id="dsBackdrop">
    <div class="ds-modal">
        <button class="ds-modal-close" onclick="closeModal()" style="position: absolute; right: 20px; top: 20px; border: none; background: none; font-size: 1.5rem; z-index: 10;">&times;</button>
        
        <div class="modal-grid">
            <!-- Kiri: Foto & Identitas Utama -->
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

            <!-- Kanan: Detail Pendidikan, Publikasi, Prestasi -->
            <div class="modal-main">
                <!-- Riwayat Pendidikan (Dinamis Nanti) -->
                <div class="section-title"><i class="bi bi-mortarboard"></i> Riwayat Pendidikan</div>
                <div id="mPendidikan" class="small text-muted">
                    <em>Data riwayat pendidikan belum diperbarui.</em>
                </div>

                <!-- Riwayat Mengajar (Dari Kolom Database Sekarang) -->
                <div class="section-title"><i class="bi bi-book"></i> Mata Kuliah Diampu</div>
                <div id="mTeaching" class="small text-dark"></div>

                <!-- Publikasi & Prestasi (Placeholder) -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="section-title"><i class="bi bi-journal-text"></i> Publikasi</div>
                        <p class="small text-muted"><em>Belum ada data publikasi terdaftar.</em></p>
                    </div>
                    <div class="col-md-6">
                        <div class="section-title"><i class="bi bi-trophy"></i> Prestasi</div>
                        <p class="small text-muted"><em>Belum ada data prestasi terdaftar.</em></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function openModal(el) {
    const d = el.dataset;
    document.getElementById('mName').innerText = d.name;
    document.getElementById('mNip').innerText = d.nip ? 'NIP/NIDN: ' + d.nip : '-';
    document.getElementById('mPos').innerText = d.struct || d.pos || '-';
    document.getElementById('mEmail').innerText = d.email || '-';
    document.getElementById('mOffice').innerText = d.office || '-';
    document.getElementById('mTeaching').innerText = d.teaching || 'Tidak ada riwayat mengajar.';
    
    // MENAMPILKAN PENDIDIKAN SECARA DINAMIS
    const eduContainer = document.getElementById('mPendidikan');
    const edus = JSON.parse(d.educations || '[]');
    
    if (edus.length > 0) {
        let eduHtml = '<ul class="ps-3">';
        edus.forEach(edu => {
            eduHtml += `<li><b>${edu.degree} ${edu.study_program}</b> - ${edu.campus}</li>`;
        });
        eduHtml += '</ul>';
        eduContainer.innerHTML = eduHtml;
    } else {
        eduContainer.innerHTML = '<em>Data pendidikan belum tersedia.</em>';
    }

    const img = document.getElementById('mImg');
    img.src = d.image || 'https://ui-avatars.com/api/?name=' + encodeURIComponent(d.name) + '&size=300';

    document.getElementById('dsBackdrop').classList.add('open');
    document.body.style.overflow = 'hidden';
}

function closeModal() {
    document.getElementById('dsBackdrop').classList.remove('open');
    document.body.style.overflow = '';
}

// Tab Filter Logic
document.querySelectorAll('.ds-tab-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        document.querySelectorAll('.ds-tab-btn').forEach(b => b.classList.remove('active'));
        this.classList.add('active');
        
        const group = this.dataset.group;
        document.querySelectorAll('.ds-card').forEach(card => {
            card.style.display = (card.dataset.group === group) ? 'block' : 'none';
        });
    });
});

// Jalankan filter awal
document.querySelector('.ds-tab-btn.active').click();
</script>

@endsection
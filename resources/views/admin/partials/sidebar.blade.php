<ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.dashboard') }}">
        <div class="sidebar-brand-icon">
            <i class="fas fa-flask" style="color: #C5E384;"></i>
        </div>
        <div class="sidebar-brand-text mx-3" style="color: #C5E384;">PANEL BIOPROSES</div>
    </a>

    <hr class="sidebar-divider my-0">

    <!-- Dashboard -->
    <li class="nav-item {{ request()->is('admin/dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    @if(Auth::user()->isSuperAdmin())
    <hr class="sidebar-divider">
    <div class="sidebar-heading" style="color: rgba(197, 227, 132, 0.5)">Manajemen Konten</div>

    <!-- 1. BERANDA -->
    <li class="nav-item {{ request()->is('admin/heroes*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('heroes.index') }}">
            <i class="fas fa-fw fa-home"></i>
            <span>Beranda</span>
        </a>
    </li>

    <!-- 2. PROFIL -->
    <li class="nav-item {{ request()->is('admin/profiles*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('profiles.index') }}">
            <i class="fas fa-fw fa-id-card"></i>
            <span>Profil</span>
        </a>
    </li>

    <!-- 3. KABAR BIOPROSES -->
    <li class="nav-item {{ request()->is('admin/informations*') || request()->is('admin/testimonials*') || request()->is('admin/cooperations*') ? 'active' : '' }}">
        <a class="nav-link {{ request()->is('admin/informations*') || request()->is('admin/testimonials*') || request()->is('admin/cooperations*') ? '' : 'collapsed' }}" 
        href="#" data-toggle="collapse" data-target="#collapseKabar">
            <i class="fas fa-fw fa-newspaper"></i>
            <span>Kabar Bioproses</span>
        </a>
        <div id="collapseKabar" class="collapse {{ request()->is('admin/informations*') || request()->is('admin/testimonials*') || request()->is('admin/cooperations*') ? 'show' : '' }}" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item {{ request()->is('admin/informations*') ? 'active' : '' }}" href="{{ route('informations.index') }}">Berita & Informasi</a>
                <a class="collapse-item {{ request()->is('admin/testimonials*') ? 'active' : '' }}" href="{{ route('testimonials.index') }}">Testimoni Alumni</a>
                <a class="collapse-item {{ request()->is('admin/cooperations*') ? 'active' : '' }}" href="{{ route('cooperations.index') }}">Mitra Strategis</a>
            </div>
        </div>
    </li>

    <!-- 4. AKADEMIK -->
    <li class="nav-item {{ request()->is('admin/curriculums*') || request()->is('admin/lecturers*') || request()->is('admin/achievements*') ? 'active' : '' }}">
        <a class="nav-link {{ request()->is('admin/curriculums*') || request()->is('admin/lecturers*') || request()->is('admin/achievements*') ? '' : 'collapsed' }}" 
           href="#" data-toggle="collapse" data-target="#collapseAkademik">
            <i class="fas fa-fw fa-graduation-cap"></i>
            <span>Akademik</span>
        </a>
        <div id="collapseAkademik" class="collapse {{ request()->is('admin/curriculums*') || request()->is('admin/lecturers*') || request()->is('admin/achievements*') ? 'show' : '' }}" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item {{ request()->is('admin/curriculums*') ? 'active' : '' }}" href="{{ route('curriculums.index') }}">Kurikulum</a>
                <a class="collapse-item {{ request()->is('admin/lecturers*') ? 'active' : '' }}" href="{{ route('lecturers.index') }}">Dosen & Staff</a>
                <a class="collapse-item {{ request()->is('admin/achievements*') ? 'active' : '' }}" href="{{ route('achievements.index') }}">Prestasi</a>
            </div>
        </div>
    </li>

    <!-- 5. DOKUMEN -->
    <li class="nav-item {{ request()->is('admin/document_archives*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('document_archives.index') }}">
            <i class="fas fa-fw fa-file-archive"></i>
            <span>Dokumen</span>
        </a>
    </li>
    @endif

    <hr class="sidebar-divider">
    <div class="sidebar-heading" style="color: rgba(197, 227, 132, 0.5)">Operasional Lab</div>

    <!-- 6. MASTER LAB & FASILITAS -->
    <li class="nav-item {{ request()->is('admin/labs*') || request()->is('admin/facilities*') ? 'active' : '' }}">
        <a class="nav-link {{ request()->is('admin/labs*') || request()->is('admin/facilities*') ? '' : 'collapsed' }}" 
           href="#" data-toggle="collapse" data-target="#collapseLab"> 
            <i class="fas fa-fw fa-building"></i>
            <span>Fasilitas Lab</span>
        </a>
        <div id="collapseLab" class="collapse {{ request()->is('admin/labs*') || request()->is('admin/facilities*') ? 'show' : '' }}" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item {{ request()->is('admin/labs*') ? 'active' : '' }}" href="{{ route('labs.index') }}">Unit Laboratorium</a>
                <a class="collapse-item {{ request()->is('admin/facilities*') ? 'active' : '' }}" href="{{ route('facilities.index') }}">Ruangan & Sarana</a>
            </div>
        </div>
    </li>

    <!-- 7. MANAJEMEN INVENTARIS -->
    <li class="nav-item {{ request()->is('admin/inventories*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('inventories.index') }}">
            <i class="fas fa-fw fa-boxes"></i>
            <span>Inventaris Lab</span>
        </a>
    </li>

    <!-- 8. TRANSAKSI PEMINJAMAN (Dropdown Baru) -->
    <li class="nav-item {{ request()->is('admin/loans*') || request()->is('admin/handover*') || request()->is('admin/return*') ? 'active' : '' }}">
        <a class="nav-link {{ request()->is('admin/loans*') || request()->is('admin/handover*') || request()->is('admin/return*') ? '' : 'collapsed' }}" 
           href="#" data-toggle="collapse" data-target="#collapsePeminjaman">
            <i class="fas fa-fw fa-exchange-alt"></i>
            <span>Sirkulasi Alat</span>
        </a>
        <div id="collapsePeminjaman" class="collapse {{ request()->is('admin/loans*') || request()->is('admin/handover*') || request()->is('admin/return*') ? 'show' : '' }}" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Proses Peminjaman:</h6>
                <a class="collapse-item {{ request()->is('admin/loans*') ? 'active' : '' }}" href="{{ route('admin.loans.index') }}">Permohonan Baru</a>
                <a class="collapse-item {{ request()->is('admin/handover*') ? 'active' : '' }}" href="{{ route('admin.handover.index') }}">Barang Keluar</a>
                <a class="collapse-item {{ request()->is('admin/return*') ? 'active' : '' }}" href="{{ route('admin.return.index') }}">Barang Kembali</a>
            </div>
        </div>
    </li>

    <!-- 9. LAPORAN -->
    <li class="nav-item {{ request()->is('admin/reports*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.reports.index') }}">
            <i class="fas fa-fw fa-file-invoice"></i>
            <span>Laporan Lab</span>
        </a>
    </li>

    <hr class="sidebar-divider d-none d-md-block">
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
<ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar" style="background-color: #200F07; background-image: linear-gradient(180deg, #200F07 10%, #351a0d 100%);">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.dashboard') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-flask" style="color: #C5E384;"></i>
        </div>
        <div class="sidebar-brand-text mx-3" style="color: #C5E384;">Admin Biopro</div>
    </a>

    <hr class="sidebar-divider my-0" style="border-top: 1px solid rgba(197, 227, 132, 0.15);">

    <!-- Dashboard -->
    <li class="nav-item {{ request()->is('admin/dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt" style="{{ request()->is('admin/dashboard') ? 'color: #C5E384;' : '' }}"></i>
            <span style="{{ request()->is('admin/dashboard') ? 'color: #C5E384; font-weight: bold;' : '' }}">Dashboard</span>
        </a>
    </li>

    <!-- ===================================================
         SEKSI 1: MANAJEMEN KONTEN (Hanya Super Admin)
         =================================================== -->
    @if(Auth::user()->isSuperAdmin())
    <hr class="sidebar-divider">
    <div class="sidebar-heading" style="color: rgba(197, 227, 132, 0.5)">Manajemen Konten</div>

    <!-- 1. Beranda -->
    <li class="nav-item {{ request()->is('admin/heroes*') ? 'active' : '' }}">
        <a class="nav-link" href="#">
            <i class="fas fa-fw fa-home"></i>
            <span>Pengaturan Beranda</span>
        </a>
    </li>

    <!-- 2. Profil & Identitas -->
    <li class="nav-item {{ request()->is('admin/profiles*') || request()->is('admin/cooperations*') ? 'active' : '' }}">
        <a class="nav-link {{ request()->is('admin/profiles*') || request()->is('admin/cooperations*') ? '' : 'collapsed' }}" href="#" data-toggle="collapse" data-target="#collapseProfil">
            <i class="fas fa-fw fa-id-card"></i>
            <span>Profil & Identitas</span>
        </a>
        <div id="collapseProfil" class="collapse {{ request()->is('admin/profiles*') || request()->is('admin/cooperations*') ? 'show' : '' }}" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item {{ request()->is('admin/profiles*') ? 'active' : '' }}" href="{{ route('profiles.index') }}">Visi, Misi & Sejarah</a>
                <a class="collapse-item {{ request()->is('admin/cooperations*') ? 'active' : '' }}" href="{{ route('cooperations.index') }}">Mitra Kerja Sama</a>
            </div>
        </div>
    </li>

    <!-- 3. Kurikulum & Akademik -->
    <li class="nav-item {{ request()->is('admin/curriculums*') || request()->is('admin/subjects*') ? 'active' : '' }}">
        <a class="nav-link {{ request()->is('admin/curriculums*') || request()->is('admin/subjects*') ? '' : 'collapsed' }}" href="#" data-toggle="collapse" data-target="#collapseAkademik">
            <i class="fas fa-fw fa-book"></i>
            <span>Kurikulum & Matkul</span>
        </a>
        <div id="collapseAkademik" class="collapse {{ request()->is('admin/curriculums*') || request()->is('admin/subjects*') ? 'show' : '' }}" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item {{ request()->is('admin/curriculums*') ? 'active' : '' }}" href="{{ route('curriculums.index') }}">Daftar Kurikulum</a>
                <a class="collapse-item {{ request()->is('admin/subjects*') ? 'active' : '' }}" href="{{ route('subjects.index') }}">Mata Kuliah</a>
            </div>
        </div>
    </li>

    <!-- 4. Dosen & Staff (SDM) -->
    <li class="nav-item {{ request()->is('admin/lecturers*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('lecturers.index') }}">
            <i class="fas fa-fw fa-graduation-cap"></i>
            <span>Dosen & Staff</span>
        </a>
    </li>

    <!-- 5. Berita & Prestasi -->
    <li class="nav-item {{ request()->is('admin/news*') || request()->is('admin/news_categories*') || request()->is('admin/achievements*') || request()->is('admin/announcements*') ? 'active' : '' }}">
        <a class="nav-link {{ request()->is('admin/news*') || request()->is('admin/news_categories*') || request()->is('admin/achievements*') || request()->is('admin/announcements*') ? '' : 'collapsed' }}" 
           href="#" data-toggle="collapse" data-target="#collapseInfo">
            <i class="fas fa-fw fa-newspaper"></i>
            <span>Informasi & Berita</span>
        </a>
        <div id="collapseInfo" class="collapse {{ request()->is('admin/news*') || request()->is('admin/news_categories*') || request()->is('admin/achievements*') || request()->is('admin/announcements*') ? 'show' : '' }}" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Pengaturan Berita:</h6>
                <!-- TAMBAHKAN INI: Menu Kategori Berita -->
                <a class="collapse-item {{ request()->is('admin/news_categories*') ? 'active' : '' }}" href="{{ route('news_categories.index') }}">Kategori Berita</a>
                
                <a class="collapse-item {{ request()->is('admin/news*') ? 'active' : '' }}" href="{{ route('news.index') }}">Isi Berita Prodi</a>
                
                <hr class="sidebar-divider mx-3">
                <h6 class="collapse-header">Lainnya:</h6>
                <a class="collapse-item {{ request()->is('admin/announcements*') ? 'active' : '' }}" href="{{ route('announcements.index') }}">Pengumuman</a>
                <a class="collapse-item {{ request()->is('admin/achievements*') ? 'active' : '' }}" href="{{ route('achievements.index') }}">Prestasi</a>
            </div>
        </div>
    </li>
    @endif

    <!-- ===================================================
         SEKSI 2: OPERASIONAL LAB (Super Admin & Admin Lab)
         =================================================== -->
    <hr class="sidebar-divider">
    <div class="sidebar-heading" style="color: rgba(197, 227, 132, 0.5)">Operasional Lab</div>

    <!-- Fasilitas Fisik -->
    <li class="nav-item {{ request()->is('admin/facilities*') || request()->is('admin/labs*') ? 'active' : '' }}">
        <a class="nav-link {{ request()->is('admin/facilities*') || request()->is('admin/labs*') ? '' : 'collapsed' }}" href="#" data-toggle="collapse" data-target="#collapseFasilitas">
            <i class="fas fa-fw fa-building"></i>
            <span>Ruang & Lab</span>
        </a>
        <div id="collapseFasilitas" class="collapse {{ request()->is('admin/facilities*') || request()->is('admin/labs*') ? 'show' : '' }}" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('labs.index') }}">Unit Organisasi Lab</a>
                <a class="collapse-item" href="#">Ruangan & Fasilitas</a>
            </div>
        </div>
    </li>

    <!-- Inventaris -->
    <li class="nav-item {{ request()->is('admin/tools*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('tools.index') }}">
            <i class="fas fa-fw fa-microscope"></i>
            <span>Katalog Alat & Bahan</span>
        </a>
    </li>

    <!-- Transaksi -->
    <li class="nav-item {{ request()->is('admin/borrowings*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('borrowings.index') }}">
            <i class="fas fa-fw fa-exchange-alt"></i>
            <span>Peminjaman Alat</span>
        </a>
    </li>

    <!-- ===================================================
         SEKSI 3: SISTEM & ARSIP (Hanya Super Admin)
         =================================================== -->
    @if(Auth::user()->isSuperAdmin())
    <hr class="sidebar-divider">
    <div class="sidebar-heading" style="color: rgba(197, 227, 132, 0.5)">Sistem</div>

    <li class="nav-item {{ request()->is('admin/students*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('students.index') }}">
            <i class="fas fa-fw fa-users"></i>
            <span>Database Mahasiswa</span>
        </a>
    </li>

    <li class="nav-item {{ request()->is('admin/document-archives*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('document_archives.index') }}">
            <i class="fas fa-fw fa-file-pdf"></i>
            <span>Arsip Dokumen/SOP</span>
        </a>
    </li>
    @endif

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
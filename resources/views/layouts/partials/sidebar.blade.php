<ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar" style="background-color: #200F07; background-image: linear-gradient(180deg, #200F07 10%, #351a0d 100%);">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.dashboard') }}">
        <div class="sidebar-brand-icon rotate-n-15">
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
    <li class="nav-item {{ request()->is('admin/heroes*') || request()->is('admin/testimonials*') || request()->is('admin/cooperations*') ? 'active' : '' }}">
        <a class="nav-link {{ request()->is('admin/heroes*') || request()->is('admin/testimonials*') || request()->is('admin/cooperations*') ? '' : 'collapsed' }}" 
        href="#" data-toggle="collapse" data-target="#collapseBeranda">
            <i class="fas fa-fw fa-home"></i>
            <span>Beranda</span>
        </a>
        <div id="collapseBeranda" class="collapse {{ request()->is('admin/heroes*') || request()->is('admin/testimonials*') || request()->is('admin/cooperations*') ? 'show' : '' }}" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item {{ request()->is('admin/heroes*') ? 'active' : '' }}" href="{{ route('heroes.index') }}">Video & Banner</a>
                <a class="collapse-item {{ request()->is('admin/testimonials*') ? 'active' : '' }}" href="{{ route('testimonials.index') }}">Testimoni Alumni</a>
                <a class="collapse-item {{ request()->is('admin/cooperations*') ? 'active' : '' }}" href="{{ route('cooperations.index') }}">Kerja Sama Mitra</a>
            </div>
        </div>
    </li>

    <!-- 2. PROFIL (Hanya Profil Bioproses sesuai Navbar) -->
    <li class="nav-item {{ request()->is('admin/profiles*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('profiles.index') }}">
            <i class="fas fa-fw fa-id-card"></i>
            <span>Profil Prodi</span>
        </a>
    </li>

    <!-- 3. KABAR BIOPROSES (Berita & Pengumuman) -->
    <li class="nav-item {{ request()->is('admin/news*') || request()->is('admin/announcements*') ? 'active' : '' }}">
        <a class="nav-link {{ request()->is('admin/news*') || request()->is('admin/announcements*') ? '' : 'collapsed' }}" 
           href="#" data-toggle="collapse" data-target="#collapseKabar">
            <i class="fas fa-fw fa-newspaper"></i>
            <span>Kabar Bioproses</span>
        </a>
        <div id="collapseKabar" class="collapse {{ request()->is('admin/news*') || request()->is('admin/announcements*') ? 'show' : '' }}" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item {{ request()->is('admin/news*') ? 'active' : '' }}" href="{{ route('news.index') }}">Berita & Kegiatan</a>
                <a class="collapse-item {{ request()->is('admin/announcements*') ? 'active' : '' }}" href="{{ route('announcements.index') }}">Pengumuman</a>
            </div>
        </div>
    </li>

    <!-- 4. AKADEMIK (Kurikulum, Dosen, Publikasi, Prestasi) -->
    <li class="nav-item {{ request()->is('admin/curriculums*') || request()->is('admin/subjects*') || request()->is('admin/lecturers*') || request()->is('admin/publications*') || request()->is('admin/achievements*') ? 'active' : '' }}">
        <a class="nav-link {{ request()->is('admin/curriculums*') || request()->is('admin/subjects*') || request()->is('admin/lecturers*') || request()->is('admin/publications*') || request()->is('admin/achievements*') ? '' : 'collapsed' }}" 
           href="#" data-toggle="collapse" data-target="#collapseAkademik">
            <i class="fas fa-fw fa-graduation-cap"></i>
            <span>Akademik</span>
        </a>
        <div id="collapseAkademik" class="collapse {{ request()->is('admin/curriculums*') || request()->is('admin/subjects*') || request()->is('admin/lecturers*') || request()->is('admin/publications*') || request()->is('admin/achievements*') ? 'show' : '' }}" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Struktur:</h6>
                <a class="collapse-item {{ request()->is('admin/curriculums*') ? 'active' : '' }}" href="{{ route('curriculums.index') }}">Kurikulum</a>
                <a class="collapse-item {{ request()->is('admin/subjects*') ? 'active' : '' }}" href="{{ route('subjects.index') }}">Mata Kuliah</a>
                <div class="collapse-divider"></div>
                <h6 class="collapse-header">SDM & Capaian:</h6>
                <a class="collapse-item {{ request()->is('admin/lecturers*') ? 'active' : '' }}" href="{{ route('lecturers.index') }}">Dosen & Staff</a>
                <a class="collapse-item {{ request()->is('admin/publications*') ? 'active' : '' }}" href="{{ route('publications.index') }}">Publikasi & Riset</a>
                <a class="collapse-item {{ request()->is('admin/achievements*') ? 'active' : '' }}" href="{{ route('achievements.index') }}">Prestasi</a>
            </div>
        </div>
    </li>

    <!-- 5. DOKUMEN (Berdiri Sendiri sesuai Navbar) -->
    <li class="nav-item {{ request()->is('admin/document_archives*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('document_archives.index') }}">
            <i class="fas fa-fw fa-file-archive"></i>
            <span>Dokumen</span>
        </a>
    </li>
    @endif

    <hr class="sidebar-divider">
    <div class="sidebar-heading" style="color: rgba(197, 227, 132, 0.5)">Operasional Lab</div>

    <!-- 6. LAB & FASILITAS -->
    <li class="nav-item {{ request()->is('admin/labs*') || request()->is('admin/facilities*') || request()->is('admin/tools*') ? 'active' : '' }}">
        <a class="nav-link {{ request()->is('admin/labs*') || request()->is('admin/facilities*') || request()->is('admin/tools*') ? '' : 'collapsed' }}" 
           href="#" data-toggle="collapse" data-target="#collapseLab"> 
            <i class="fas fa-fw fa-flask"></i>
            <span>Lab & Fasilitas</span>
        </a>
        <div id="collapseLab" class="collapse {{ request()->is('admin/labs*') || request()->is('admin/facilities*') || request()->is('admin/tools*') ? 'show' : '' }}" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item {{ request()->is('admin/labs*') ? 'active' : '' }}" href="{{ route('labs.index') }}">Unit Laboratorium</a>
                <a class="collapse-item {{ request()->is('admin/facilities*') ? 'active' : '' }}" href="{{ route('facilities.index') }}">Ruangan & Sarana</a>
                <a class="collapse-item {{ request()->is('admin/tools*') ? 'active' : '' }}" href="{{ route('tools.index') }}">Katalog Alat</a>
            </div>
        </div>
    </li>

    <li class="nav-item {{ request()->is('admin/borrowings*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('borrowings.index') }}">
            <i class="fas fa-fw fa-exchange-alt"></i>
            <span>Peminjaman Alat</span>
        </a>
    </li>

    <li class="nav-item {{ request()->is('admin/students*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('students.index') }}">
            <i class="fas fa-fw fa-users"></i>
            <span>Database Mahasiswa</span>
        </a>
    </li>

    <hr class="sidebar-divider d-none d-md-block">
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
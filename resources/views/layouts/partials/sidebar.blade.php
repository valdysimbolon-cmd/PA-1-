<ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar" style="background-color: #200F07; background-image: linear-gradient(180deg, #200F07 10%, #351a0d 100%);">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.dashboard') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-flask" style="color: #C5E384;"></i>
        </div>
        <div class="sidebar-brand-text mx-3" style="color: #C5E384;">PANEL BIOPROSES</div>
    </a>

    <hr class="sidebar-divider my-0" style="border-top: 1px solid rgba(197, 227, 132, 0.15);">

    <!-- Dashboard -->
    <li class="nav-item {{ request()->is('admin/dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt" style="{{ request()->is('admin/dashboard') ? 'color: #C5E384;' : '' }}"></i>
            <span style="{{ request()->is('admin/dashboard') ? 'color: #C5E384; font-weight: bold;' : '' }}">Dashboard</span>
        </a>
    </li>

    @if(Auth::user()->isSuperAdmin())
    <!-- ===================================================
         KELOMPOK: MANAJEMEN KONTEN (Super Admin)
         =================================================== -->
    <hr class="sidebar-divider">
    <div class="sidebar-heading" style="color: rgba(197, 227, 132, 0.5)">Manajemen Konten</div>

    <!-- 1. BERANDA DROPDOWN -->
    <li class="nav-item {{ request()->is('admin/heroes*') || (request()->is('admin/profiles*') && request('type') == 'testimonial') || request()->is('admin/cooperations*') ? 'active' : '' }}">
        <a class="nav-link {{ request()->is('admin/heroes*') || request()->is('admin/cooperations*') ? '' : 'collapsed' }}" 
           href="#" data-toggle="collapse" data-target="#collapseBeranda">
            <i class="fas fa-fw fa-home"></i>
            <span>Beranda</span>
        </a>
        <div id="collapseBeranda" class="collapse {{ request()->is('admin/heroes*') || request()->is('admin/cooperations*') ? 'show' : '' }}" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item {{ request()->is('admin/heroes*') ? 'active' : '' }}" href="{{ route('heroes.index') }}">Video & Banner</a>
                <!-- Testimoni menggunakan sistem Key di Profiles -->
                <a class="collapse-item {{ request()->is('admin/profiles*') ? 'active' : '' }}" href="{{ route('profiles.index') }}">Testimoni Alumni</a>
                <a class="collapse-item {{ request()->is('admin/cooperations*') ? 'active' : '' }}" href="{{ route('cooperations.index') }}">Kerja Sama Mitra</a>
            </div>
        </div>
    </li>

    <!-- 2. PROFIL DROPDOWN -->
    <li class="nav-item {{ request()->is('admin/profiles*') || request()->is('admin/lecturers*') ? 'active' : '' }}">
        <a class="nav-link {{ request()->is('admin/profiles*') || request()->is('admin/lecturers*') ? '' : 'collapsed' }}" 
           href="#" data-toggle="collapse" data-target="#collapseProfil">
            <i class="fas fa-fw fa-id-card"></i>
            <span>Profil Prodi</span>
        </a>
        <div id="collapseProfil" class="collapse {{ request()->is('admin/profiles*') || request()->is('admin/lecturers*') ? 'show' : '' }}" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item {{ request()->is('admin/profiles*') ? 'active' : '' }}" href="{{ route('profiles.index') }}">Profil Bioproses</a>
                <a class="collapse-item {{ request()->is('admin/lecturers*') ? 'active' : '' }}" href="{{ route('lecturers.index') }}">Dosen & Staff</a>
            </div>
        </div>
    </li>

    <!-- 3. AKADEMIK DROPDOWN -->
    <li class="nav-item {{ request()->is('admin/curriculums*') || request()->is('admin/subjects*') ? 'active' : '' }}">
        <a class="nav-link {{ request()->is('admin/curriculums*') || request()->is('admin/subjects*') ? '' : 'collapsed' }}" 
           href="#" data-toggle="collapse" data-target="#collapseAkademik">
            <i class="fas fa-fw fa-graduation-cap"></i>
            <span>Akademik</span>
        </a>
        <div id="collapseAkademik" class="collapse {{ request()->is('admin/curriculums*') || request()->is('admin/subjects*') ? 'show' : '' }}" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item {{ request()->is('admin/curriculums*') ? 'active' : '' }}" href="{{ route('curriculums.index') }}">Kurikulum</a>
                <a class="collapse-item {{ request()->is('admin/subjects*') ? 'active' : '' }}" href="{{ route('subjects.index') }}">Mata Kuliah</a>
                <!-- Kalender & Profil Lulusan menggunakan sistem Key di Profiles -->
                <a class="collapse-item {{ request()->is('admin/profiles*') ? 'active' : '' }}" href="{{ route('profiles.index') }}">Kalender Akademik</a>
                <a class="collapse-item {{ request()->is('admin/profiles*') ? 'active' : '' }}" href="{{ route('profiles.index') }}">Profil Lulusan</a>
            </div>
        </div>
    </li>

    <!-- 4. KABAR DROPDOWN -->
    <li class="nav-item {{ request()->is('admin/news*') || request()->is('admin/announcements*') || request()->is('admin/achievements*') ? 'active' : '' }}">
        <a class="nav-link {{ request()->is('admin/news*') || request()->is('admin/announcements*') || request()->is('admin/achievements*') ? '' : 'collapsed' }}" 
           href="#" data-toggle="collapse" data-target="#collapseKabar">
            <i class="fas fa-fw fa-newspaper"></i>
            <span>Kabar Bioproses</span>
        </a>
        <div id="collapseKabar" class="collapse {{ request()->is('admin/news*') || request()->is('admin/announcements*') || request()->is('admin/achievements*') ? 'show' : '' }}" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item {{ request()->is('admin/news*') ? 'active' : '' }}" href="{{ route('news.index') }}">Berita & Kegiatan</a>
                <a class="collapse-item {{ request()->is('admin/announcements*') ? 'active' : '' }}" href="{{ route('announcements.index') }}">Pengumuman</a>
                <a class="collapse-item {{ request()->is('admin/achievements*') ? 'active' : '' }}" href="{{ route('achievements.index') }}">Prestasi</a>
            </div>
        </div>
    </li>
    @endif

    <!-- ===================================================
         OPERASIONAL LAB (Super Admin & Admin Lab)
         =================================================== -->
    <hr class="sidebar-divider">
    <div class="sidebar-heading" style="color: rgba(197, 227, 132, 0.5)">Operasional Lab</div>

    <li class="nav-item {{ request()->is('admin/labs*') || request()->is('admin/facility*') || request()->is('admin/tools*') || request()->is('admin/document_archives*') ? 'active' : '' }}">
        <a class="nav-link {{ request()->is('admin/labs*') || request()->is('admin/facility*') || request()->is('admin/tools*') || request()->is('admin/document_archives*') ? '' : 'collapsed' }}" 
           href="#" data-toggle="collapse" data-target="#collapseLab">
            <i class="fas fa-fw fa-flask"></i>
            <span>Lab & Fasilitas</span>
        </a>
        <div id="collapseLab" class="collapse {{ request()->is('admin/labs*') || request()->is('admin/facility*') || request()->is('admin/tools*') || request()->is('admin/document_archives*') ? 'show' : '' }}" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item {{ request()->is('admin/labs*') ? 'active' : '' }}" href="{{ route('labs.index') }}">Unit Laboratorium</a>
                <a class="collapse-item {{ request()->is('admin/facility*') ? 'active' : '' }}" href="{{ route('facility.index') }}">Ruangan & Sarana</a>
                <a class="collapse-item {{ request()->is('admin/tools*') ? 'active' : '' }}" href="{{ route('tools.index') }}">Katalog Alat</a>
                <a class="collapse-item {{ request()->is('admin/document_archives*') ? 'active' : '' }}" href="{{ route('document_archives.index') }}">Dokumen SOP</a>
            </div>
        </div>
    </li>

    <li class="nav-item {{ request()->is('admin/borrowings*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('borrowings.index') }}">
            <i class="fas fa-fw fa-exchange-alt"></i>
            <span>Peminjaman Alat</span>
        </a>
    </li>

    @if(Auth::user()->isSuperAdmin())
    <li class="nav-item {{ request()->is('admin/students*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('students.index') }}">
            <i class="fas fa-fw fa-users"></i>
            <span>Database Mahasiswa</span>
        </a>
    </li>
    @endif

    <hr class="sidebar-divider d-none d-md-block">
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
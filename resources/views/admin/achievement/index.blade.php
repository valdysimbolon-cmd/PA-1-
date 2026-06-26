@extends('layouts.admin')

@section('title', 'Manajemen Prestasi')

@section('content')
<div class="container-fluid px-3 px-md-4">
    <!-- Judul + Tombol Tambah -->
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mt-4 mb-4">
        <div>
            <h1 class="h3 text-gray-800 mb-1">Manajemen Prestasi</h1>
            <p class="text-muted small mb-0">Kelola data prestasi mahasiswa dan dosen program studi.</p>
        </div>
        <a href="{{ route('achievements.create') }}" class="btn btn-success shadow-sm px-3 d-flex align-items-center" style="height: 42px;">
            <i class="fas fa-plus me-2"></i> <span>Tambah Prestasi</span>
        </a>
    </div>

    <!-- Statistik & Filter Pencarian -->
    <div class="row g-3 mb-4">
        <!-- Statistik Total -->
        <div class="col-12 col-md-4 col-xl-3">
            <div class="card border-0 shadow-sm border-start border-success border-5">
                <div class="card-body py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Prestasi</div>
                            <div class="h3 mb-0 font-weight-bold text-gray-800">{{ $achievements->total() ?? $achievements->count() }}</div>
                        </div>
                        <div class="rounded-circle p-3" style="background-color: rgba(25, 135, 84, 0.1);">
                            <i class="fas fa-trophy fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter & Pencarian -->
        <div class="col-12 col-md-8 col-xl-9">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 12px;">
                <div class="card-body d-flex align-items-center py-3 px-3">
                    <form method="GET" action="{{ route('achievements.index') }}" class="w-100 m-0">
                        <div class="row g-2">
                            <!-- Filter Kategori -->
                            <div class="col-12 col-md-3">
                                <label class="filter-label text-success"><i class="fas fa-user-tag me-1"></i> Kategori</label>
                                <select name="category" class="filter-select filter-green" onchange="this.form.submit()">
                                    <option value="">Semua</option>
                                    <option value="student" {{ request('category') == 'student' ? 'selected' : '' }}>Mahasiswa</option>
                                    <option value="lecturer" {{ request('category') == 'lecturer' ? 'selected' : '' }}>Dosen</option>
                                </select>
                            </div>

                            <!-- Filter Tingkat -->
                            <div class="col-12 col-md-3">
                                <label class="filter-label text-primary"><i class="fas fa-layer-group me-1"></i> Tingkat</label>
                                <select name="level" class="filter-select filter-blue" onchange="this.form.submit()">
                                    <option value="">Semua</option>
                                    <option value="Regional" {{ request('level') == 'Regional' ? 'selected' : '' }}>Regional</option>
                                    <option value="Nasional" {{ request('level') == 'Nasional' ? 'selected' : '' }}>Nasional</option>
                                    <option value="Internasional" {{ request('level') == 'Internasional' ? 'selected' : '' }}>Internasional</option>
                                </select>
                            </div>

                            <!-- Filter Tahun -->
                            <div class="col-12 col-md-2">
                                <label class="filter-label" style="color:#e67e22;"><i class="fas fa-calendar-alt me-1"></i> Tahun</label>
                                <select name="year" class="filter-select filter-orange" onchange="this.form.submit()">
                                    <option value="">Semua</option>
                                    @for($y = date('Y'); $y >= 2015; $y--)
                                        <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>{{ $y }}</option>
                                    @endfor
                                </select>
                            </div>

                            <!-- Pencarian & Tombol -->
                            <div class="col-12 col-md-4">
                                <label class="filter-label text-muted"><i class="fas fa-search me-1"></i> Pencarian</label>
                                <div class="search-wrap">
                                    <input type="text" name="search"
                                        class="search-input"
                                        placeholder="Cari judul prestasi..."
                                        value="{{ request('search') }}">
                                    <div class="search-actions">
                                        @if(request('search') || request('category') || request('level') || request('year'))
                                            <a href="{{ route('achievements.index') }}" class="btn-reset" title="Reset">
                                                <i class="fas fa-times"></i>
                                            </a>
                                        @endif
                                        <button type="submit" class="btn-cari">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Prestasi -->
    <div class="card shadow-sm border-0 mb-5">
        <div class="card-header bg-success py-3 d-flex align-items-center">
            <i class="fas fa-list me-2 text-white"></i>
            <h6 class="m-0 font-weight-bold text-white">Daftar Prestasi & Penghargaan</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light text-secondary">
                        <tr>
                            <th class="ps-4" style="width: 80px">Visual</th>
                            <th>Detail Kompetisi</th>
                            <th style="width: 100px" class="text-center">Tingkat</th>
                            <th style="width: 120px" class="text-center">Kategori</th>
                            <th style="width: 80px" class="text-center">Tahun</th>
                            <th class="text-center pe-4" style="width: 120px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($achievements as $a)
                        <tr>
                            <td class="ps-4">
                                @if($a->image)
                                    <img src="{{ asset('storage/'.$a->image) }}" class="rounded shadow-sm border" width="50" height="50" style="object-fit: cover;">
                                @else
                                    <div class="bg-light border rounded d-inline-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                        <i class="fas fa-trophy text-secondary"></i>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <div class="fw-bold text-dark">{{ $a->title }}</div>
                                <small class="text-muted">{{ $a->winner_name }} ({{ $a->rank ?? 'Juara' }})</small>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-info">{{ $a->level }}</span>
                            </td>
                            <td class="text-center">
                                @if($a->category === 'student')
                                    <span class="badge rounded-pill bg-success-subtle text-success border border-success px-3">
                                        Mahasiswa
                                    </span>
                                @elseif($a->category === 'lecturer')
                                    <span class="badge rounded-pill bg-primary-subtle text-primary border border-primary px-3">
                                        Dosen
                                    </span>
                                @else
                                    <span class="badge rounded-pill bg-secondary-subtle text-secondary border px-3">
                                        Tidak diketahui
                                    </span>
                                @endif
                            </td>
                            <td class="text-center fw-bold">{{ $a->year }}</td>
                            <td class="text-center pe-4">
                                <div class="btn-group shadow-sm">
                                    <a href="{{ route('achievements.edit', $a->id) }}" class="btn btn-sm btn-outline-success">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('achievements.destroy', $a->id) }}" method="POST" class="d-inline delete-form">
                                        @csrf @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-outline-danger delete-btn">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="fas fa-trophy fa-2x mb-2 d-block"></i>
                                Belum ada data prestasi. <a href="{{ route('achievements.create') }}" class="text-success">Tambah sekarang</a>.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($achievements->hasPages())
            <div class="card-footer bg-white border-top-0 py-3 d-flex justify-content-center">
                {{ $achievements->links() }}
            </div>
        @endif
    </div>
</div>

<style>
    /* Gaya seragam dengan index Informasi dan Dosen/Staff */
    .bg-success-subtle { background-color: #e8f5e9 !important; }
    .bg-primary-subtle { background-color: #e3f2fd !important; }
    .bg-secondary-subtle { background-color: #f8f9fa !important; }
    .card { border-radius: 10px; }

    .filter-label {
        display: block;
        font-size: 0.7rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        margin-bottom: 4px;
        padding-left: 2px;
    }

    .filter-select {
        width: 100%;
        height: 38px;
        border-radius: 8px;
        font-size: 0.85rem;
        font-weight: 500;
        padding: 0 10px;
        outline: none;
        cursor: pointer;
        appearance: none;
        -webkit-appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='10' viewBox='0 0 24 24' fill='none' stroke='%23666' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 10px center;
        transition: box-shadow 0.15s, border-color 0.15s;
    }

    .filter-green {
        background-color: #f0faf4;
        border: 1.5px solid #b2dfcc;
        color: #155724;
        box-shadow: 0 1px 4px rgba(25,135,84,0.1), inset 0 1px 2px rgba(255,255,255,0.8);
    }
    .filter-green:focus {
        border-color: #198754;
        box-shadow: 0 0 0 3px rgba(25,135,84,0.15);
    }

    .filter-blue {
        background-color: #f0f6ff;
        border: 1.5px solid #b3cff5;
        color: #084298;
        box-shadow: 0 1px 4px rgba(13,110,253,0.1), inset 0 1px 2px rgba(255,255,255,0.8);
    }
    .filter-blue:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 3px rgba(13,110,253,0.15);
    }

    .filter-orange {
        background-color: #fffaf0;
        border: 1.5px solid #f5d5a0;
        color: #7d4e00;
        box-shadow: 0 1px 4px rgba(253,126,20,0.1), inset 0 1px 2px rgba(255,255,255,0.8);
    }
    .filter-orange:focus {
        border-color: #fd7e14;
        box-shadow: 0 0 0 3px rgba(253,126,20,0.15);
    }

    .search-wrap {
        display: flex;
        align-items: center;
        height: 38px;
        border-radius: 8px;
        border: 1.5px solid #c8e6c9;
        background: #fff;
        box-shadow: 0 1px 4px rgba(0,0,0,0.07), inset 0 1px 2px rgba(255,255,255,0.9);
        overflow: hidden;
        padding-left: 10px;
        transition: border-color 0.15s, box-shadow 0.15s;
    }
    .search-wrap:focus-within {
        border-color: #198754;
        box-shadow: 0 0 0 3px rgba(25,135,84,0.15);
    }
    .search-input {
        flex: 1;
        border: none;
        outline: none;
        font-size: 0.85rem;
        background: transparent;
        color: #333;
        min-width: 0;
    }
    .search-input::placeholder { color: #bbb; }
    .search-actions {
        display: flex;
        align-items: center;
        gap: 3px;
        padding-right: 5px;
    }
    .btn-reset {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 26px;
        height: 26px;
        border-radius: 50%;
        background: #fff0f0;
        border: 1px solid #f5c6cb;
        color: #dc3545;
        font-size: 0.7rem;
        text-decoration: none;
        transition: background 0.15s;
    }
    .btn-reset:hover { background: #f5c2c7; color: #dc3545; }
    .btn-cari {
        width: 30px;
        height: 30px;
        border-radius: 7px;
        border: none;
        background-color: #198754;
        color: #fff;
        font-size: 0.8rem;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 1px 4px rgba(25,135,84,0.25);
        transition: background 0.15s;
    }
    .btn-cari:hover { background-color: #157347; }

    @media (max-width: 576px) {
        .table td, .table th { white-space: nowrap; }
        .badge { font-size: 0.6rem; padding: 0.2rem 0.4rem; }
        .btn-group .btn { padding: 0.2rem 0.4rem; }
    }
</style>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 2500,
                timerProgressBar: true
            });
        @endif

        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{ session('error') }}',
                confirmButtonColor: '#dc3545'
            });
        @endif

        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function () {
                const form = this.closest('form.delete-form');
                Swal.fire({
                    title: 'Hapus Prestasi?',
                    text: "Data yang dihapus tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) form.submit();
                });
            });
        });
    });
</script>
@endpush
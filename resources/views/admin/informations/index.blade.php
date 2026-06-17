@extends('layouts.admin')

@section('title', 'Manajemen Informasi')

@section('content')
<div class="container-fluid px-3 px-md-4">
    <!-- Judul + Tombol Tambah -->
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mt-4 mb-4">
        <div>
            <h1 class="h3 text-gray-800 mb-1">Manajemen Informasi</h1>
            <p class="text-muted small mb-0">Kelola berita, kegiatan, dan pengumuman akademik.</p>
        </div>
        <a href="{{ route('informations.create') }}" class="btn btn-success shadow-sm px-3 d-flex align-items-center" style="height: 42px;">
            <i class="fas fa-plus me-2"></i> <span>Buat Informasi</span>
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
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Informasi</div>
                            <div class="h3 mb-0 font-weight-bold text-gray-800">{{ $informations->total() ?? $informations->count() }}</div>
                        </div>
                        <div class="rounded-circle p-3" style="background-color: rgba(25, 135, 84, 0.1);">
                            <i class="fas fa-info-circle fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter & Pencarian -->
        <div class="col-12 col-md-8 col-xl-9">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 12px;">
                <div class="card-body d-flex align-items-center py-2">
                    <form method="GET" action="{{ route('informations.index') }}" class="w-100 m-0">
                        <div class="row g-2">
                            <!-- Filter Tipe -->
                            <div class="col-12 col-md-3">
                                <select name="type" class="form-select border-0 bg-light fw-medium" style="height: 45px; border-radius: 8px;" onchange="this.form.submit()">
                                    <option value="">Semua Tipe</option>
                                    <option value="news" {{ request('type') == 'news' ? 'selected' : '' }}>Berita & Kegiatan</option>
                                    <option value="announcement" {{ request('type') == 'announcement' ? 'selected' : '' }}>Pengumuman</option>
                                </select>
                            </div>

                            <!-- Filter Kategori (khusus berita) -->
                            <div class="col-12 col-md-2">
                                <select name="category" class="form-select border-0 bg-light fw-medium" style="height: 45px; border-radius: 8px;" onchange="this.form.submit()">
                                    <option value="">Semua Kategori</option>
                                    @foreach(['Kegiatan Mahasiswa', 'Kegiatan Dosen', 'Kegiatan Umum'] as $cat)
                                        <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Filter Tahun -->
                            <div class="col-12 col-md-2">
                                <select name="year" class="form-select border-0 bg-light fw-medium" style="height: 45px; border-radius: 8px;" onchange="this.form.submit()">
                                    <option value="">Tahun</option>
                                    @for($y = date('Y'); $y >= 2020; $y--)
                                        <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>{{ $y }}</option>
                                    @endfor
                                </select>
                            </div>

                            <!-- Pencarian & Tombol -->
                            <div class="col-12 col-md-5">
                                <div class="input-group bg-light rounded px-2" style="height: 45px; border-radius: 8px;">
                                    <input type="text" name="search" class="form-control bg-transparent border-0 shadow-none px-2" 
                                           placeholder="Cari judul informasi..." value="{{ request('search') }}" style="font-size: 0.9rem;">
                                    <div class="d-flex align-items-center gap-1">
                                        <button class="btn btn-success rounded-circle d-flex align-items-center justify-content-center shadow-sm" 
                                                type="submit" style="width: 35px; height: 35px;">
                                            <i class="fas fa-search" style="font-size: 0.85rem;"></i>
                                        </button>
                                        @if(request('search') || request('type') || request('category') || request('year'))
                                            <a href="{{ route('informations.index') }}" 
                                               class="btn btn-white bg-white rounded-circle d-flex align-items-center justify-content-center border shadow-sm" 
                                               style="width: 35px; height: 35px;" title="Reset Filter">
                                                <i class="fas fa-sync-alt text-muted" style="font-size: 0.75rem;"></i>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Informasi -->
    <div class="card shadow-sm border-0 mb-5">
        <div class="card-header bg-success py-3 d-flex align-items-center">
            <i class="fas fa-list me-2 text-white"></i>
            <h6 class="m-0 font-weight-bold text-white">Daftar Informasi</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light text-secondary">
                        <tr>
                            <th class="ps-4" style="width: 80px">Foto</th>
                            <th>Judul</th>
                            <th style="width: 120px">Kategori</th>
                            <th class="text-center" style="width: 100px">Status</th>
                            <th class="d-none d-sm-table-cell" style="width: 150px">Waktu Informasi</th>
                            <th class="text-center pe-4" style="width: 120px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($informations as $item)
                        <tr>
                            <td class="ps-4">
                                @if($item->image)
                                    <img src="{{ asset('storage/'.$item->image) }}" class="rounded shadow-sm border" width="50" height="40" style="object-fit: cover;">
                                @else
                                    <div class="bg-light border rounded d-inline-flex align-items-center justify-content-center" style="width: 50px; height: 40px;">
                                        <i class="fas fa-image text-secondary"></i>
                                    </div>
                                @endif
                            </td>
                            {{-- KOLOM JUDUL (Tadinya tertukar) --}}
                            <td>
                                <div class="fw-bold text-dark">{{ Str::limit($item->title, 60) }}</div>
                                <small class="text-muted">
                                    @if($item->type == 'news')
                                        <span class="text-success"><i class="fas fa-newspaper me-1"></i> Berita</span>
                                    @else
                                        <span class="text-primary"><i class="fas fa-bullhorn me-1"></i> Pengumuman</span>
                                    @endif
                                    • {{ $item->created_at->format('d M Y') }}
                                </small>
                            </td>
                            {{-- KOLOM KATEGORI (Hanya tampil jika News) --}}
                            <td>
                                @if($item->type == 'news')
                                    <span class="badge bg-success-subtle text-success border px-2 py-1">
                                        {{ $item->category }}
                                    </span>
                                @else
                                    <span class="badge bg-primary-subtle text-primary border px-2 py-1">
                                        Pengumuman
                                    </span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($item->active)
                                    <span class="text-success small fw-bold"><i class="fas fa-circle me-1" style="font-size: 8px;"></i> Aktif</span>
                                @else
                                    <span class="text-muted small">Draft</span>
                                @endif
                                @if($item->is_important)
                                    <div class="badge bg-danger text-white mt-1" style="font-size: 0.6rem;">PENTING</div>
                                @endif
                            </td>
                            <td>
                                @if($item->type == 'news')
                                    {{-- Jika Berita, tampilkan tanggal publikasi --}}
                                    <div class="small text-muted mb-1">Tanggal Terbit:</div>
                                    <div class="fw-bold small text-dark">
                                        <i class="far fa-calendar-alt me-1 text-success"></i> 
                                        {{ $item->published_at ? $item->published_at->format('d M Y') : '-' }}
                                    </div>
                                @else
                                    {{-- Jika Pengumuman, tampilkan tanggal expired --}}
                                    <div class="small text-muted mb-1">Batas Tampil:</div>
                                    @if($item->expired_at)
                                        <div class="fw-bold small {{ $item->expired_at->isPast() ? 'text-danger' : 'text-primary' }}">
                                            <i class="fas fa-history me-1"></i>
                                            {{ $item->expired_at->format('d M Y') }}
                                            @if($item->expired_at->isPast())
                                                <span class="badge bg-danger ms-1" style="font-size: 0.5rem;">EXPIRED</span>
                                            @endif
                                        </div>
                                    @else
                                        <div class="small text-muted fw-bold">
                                            <i class="fas fa-infinity me-1"></i> Selamanya
                                        </div>
                                    @endif
                                @endif
                            </td>
                            <td class="text-center pe-4">
                                <div class="btn-group shadow-sm">
                                    <a href="{{ route('informations.edit', $item->id) }}" class="btn btn-sm btn-outline-success">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('informations.destroy', $item->id) }}" method="POST" class="d-inline delete-form">
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
                                <i class="fas fa-info-circle fa-2x mb-2 d-block"></i>
                                Belum ada informasi. <a href="{{ route('informations.create') }}" class="text-success">Buat sekarang</a>.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($informations->hasPages())
            <div class="card-footer bg-white border-top-0 py-3 d-flex justify-content-center">
                {{ $informations->links() }}
            </div>
        @endif
    </div>
</div>

<style>
    .bg-success-subtle { background-color: #e8f5e9 !important; }
    .bg-primary-subtle { background-color: #e3f2fd !important; }
    .input-group .btn { z-index: 0 !important; }
    .form-control:focus, .form-select:focus { box-shadow: none; border-color: #198754; }
    .card { border-radius: 10px; }
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
                    title: 'Hapus Informasi?',
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
@extends('layouts.admin')

@section('title', 'Manajemen Unit Laboratorium')

@section('content')
<div class="container-fluid px-3 px-md-4">
    <!-- Judul + Tombol Tambah -->
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mt-4 mb-4">
        <div>
            <h1 class="h3 text-gray-800 mb-1">Manajemen Unit Laboratorium</h1>
            <p class="text-muted small mb-0">Kelola data laboratorium, fasilitas, dan peralatan.</p>
        </div>
        <a href="{{ route('labs.create') }}" class="btn btn-success shadow-sm px-3 d-flex align-items-center" style="height: 42px;">
            <i class="fas fa-plus me-2"></i> <span>Tambah Lab Baru</span>
        </a>
    </div>

    <!-- Statistik & Filter Pencarian -->
    <div class="row g-3 mb-4">
        <div class="col-12 col-xl-4">
            <div class="card border-0 shadow-sm border-start border-success border-5">
                <div class="card-body py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Laboratorium</div>
                            <div class="h3 mb-0 font-weight-bold text-gray-800">{{ $labs->total() ?? $labs->count() }}</div>
                        </div>
                        <div class="rounded-circle p-3" style="background-color: rgba(25, 135, 84, 0.1);">
                            <i class="fas fa-flask fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-xl-8">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 12px;">
                <div class="card-body py-2">
                    <form method="GET" action="{{ route('labs.index') }}" class="w-100 m-0">
                        <div class="row g-2">
                            <!-- Dropdown Kategori -->
                            <div class="col-12 col-md-5">
                                <select name="category" class="form-select border-0 bg-light fw-medium" style="height: 45px; border-radius: 8px;">
                                    <option value="">Semua Kategori</option>
                                    <option value="Praktikum" {{ request('category') == 'Praktikum' ? 'selected' : '' }}>Praktikum</option>
                                    <option value="Riset" {{ request('category') == 'Riset' ? 'selected' : '' }}>Riset</option>
                                    <option value="Umum" {{ request('category') == 'Umum' ? 'selected' : '' }}>Umum</option>
                                </select>
                            </div>

                            <!-- Input Pencarian & Tombol -->
                            <div class="col-12 col-md-7">
                                <div class="input-group bg-light rounded px-2" style="height: 45px; border-radius: 8px;">
                                    <input type="text" name="search" class="form-control bg-transparent border-0 shadow-none px-2" 
                                           placeholder="Cari nama laboratorium..." value="{{ request('search') }}" style="font-size: 0.9rem;">
                                    
                                    <div class="d-flex align-items-center gap-1">
                                        <button class="btn btn-success rounded-circle d-flex align-items-center justify-content-center shadow-sm" 
                                                type="submit" style="width: 35px; height: 35px;">
                                            <i class="fas fa-search" style="font-size: 0.85rem;"></i>
                                        </button>

                                        @if(request('search') || request('category'))
                                            <a href="{{ route('labs.index') }}" 
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

    <!-- Tabel Laboratorium -->
    <div class="card shadow-sm border-0 mb-5">
        <div class="card-header bg-success py-3 d-flex align-items-center">
            <i class="fas fa-list me-2 text-white"></i>
            <h6 class="m-0 font-weight-bold text-white">Daftar Unit Laboratorium</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light text-secondary">
                        <tr>
                            <th class="ps-4" style="width: 100px">Foto</th>
                            <th>Nama Laboratorium</th>
                            <th style="width: 120px">Kategori</th>
                            <th>Kepala Lab</th>
                            <th class="text-center" style="width: 100px">Status</th>
                            <th class="text-center pe-4" style="width: 120px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($labs as $lab)
                        <tr>
                            <td class="ps-4">
                                @if($lab->image)
                                    <img src="{{ asset('storage/'.$lab->image) }}" class="rounded shadow-sm border" width="70" height="50" style="object-fit: cover;">
                                @else
                                    <div class="bg-light border rounded d-inline-flex align-items-center justify-content-center" style="width: 70px; height: 50px;">
                                        <i class="fas fa-flask text-secondary"></i>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <div class="fw-bold text-dark">{{ $lab->name }}</div>
                                @if($lab->location)
                                    <small class="text-muted"><i class="fas fa-map-marker-alt me-1"></i> {{ $lab->location }}</small>
                                @endif
                            </td>
                            <td><span class="badge bg-info">{{ $lab->category }}</span></td>
                            <td>{{ $lab->head->name ?? 'Belum Ditentukan' }}</td>
                            <td class="text-center">
                                <span class="badge rounded-pill {{ $lab->active ? 'bg-success-subtle text-success border border-success' : 'bg-secondary-subtle text-secondary border border-secondary' }} px-3">
                                    {{ $lab->active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td class="text-center pe-4">
                                <div class="btn-group shadow-sm">
                                    <a href="{{ route('labs.edit', $lab->id) }}" class="btn btn-sm btn-outline-success">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('labs.destroy', $lab->id) }}" method="POST" class="d-inline delete-form">
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
                                <i class="fas fa-flask fa-2x mb-2 d-block"></i>
                                Belum ada data laboratorium. <a href="{{ route('labs.create') }}" class="text-success">Tambah sekarang</a>.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($labs->hasPages())
            <div class="card-footer bg-white border-top-0 py-3 d-flex justify-content-center">
                {{ $labs->links() }}
            </div>
        @endif
    </div>
</div>

<style>
    .bg-success-subtle { background-color: #e8f5e9 !important; }
    .bg-secondary-subtle { background-color: #f8f9fa !important; }
    .input-group .btn { z-index: 0 !important; }
    .form-control:focus, .form-select:focus { box-shadow: none; border-color: #198754; }
    .card { border-radius: 10px; }
    @media (max-width: 576px) {
        .table td, .table th { white-space: nowrap; }
        .badge { font-size: 0.7rem; padding: 0.25rem 0.5rem; }
        .btn-group .btn { padding: 0.25rem 0.5rem; }
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
                    title: 'Hapus Laboratorium?',
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
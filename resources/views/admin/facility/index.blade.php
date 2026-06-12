@extends('layouts.admin')

@section('title', 'Manajemen Fasilitas')

@section('content')
<div class="container-fluid px-3 px-md-4">
    <!-- Judul + Tombol Tambah -->
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mt-4 mb-4">
        <div>
            <h1 class="h3 text-gray-800 mb-1">Manajemen Fasilitas</h1>
            <p class="text-muted small mb-0">Kelola data fasilitas ruangan, laboratorium, dan sarana pendukung.</p>
        </div>
        <a href="{{ route('facilities.create') }}" class="btn btn-success shadow-sm px-3 d-flex align-items-center" style="height: 42px;">
            <i class="fas fa-plus me-2"></i> <span>Tambah Fasilitas</span>
        </a>
    </div>

    <!-- Statistik & Filter -->
    <div class="row g-3 mb-4">
        <div class="col-12 col-xl-4">
            <div class="card border-0 shadow-sm border-start border-success border-5">
                <div class="card-body py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Fasilitas</div>
                            <div class="h3 mb-0 font-weight-bold text-gray-800">{{ $facilities->total() ?? $facilities->count() }}</div>
                        </div>
                        <div class="rounded-circle p-3" style="background-color: rgba(25, 135, 84, 0.1);">
                            <i class="fas fa-building fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-xl-8">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 12px;">
                <div class="card-body py-2">
                    <form method="GET" action="{{ route('facilities.index') }}" class="w-100 m-0">
                        <div class="row g-2">
                            <!-- Dropdown Tipe -->
                            <div class="col-12 col-md-4">
                                <select name="type" class="form-select border-0 bg-light fw-medium" style="height: 45px; border-radius: 8px;">
                                    <option value="">Semua Tipe</option>
                                    @foreach($types as $type)
                                        <option value="{{ $type }}" {{ request('type') == $type ? 'selected' : '' }}>{{ $type }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- Pencarian -->
                            <div class="col-12 col-md-8">
                                <div class="input-group bg-light rounded px-2" style="height: 45px; border-radius: 8px;">
                                    <input type="text" name="search" class="form-control bg-transparent border-0 shadow-none px-2" 
                                           placeholder="Cari nama atau lokasi..." value="{{ request('search') }}" style="font-size: 0.9rem;">
                                    <div class="d-flex align-items-center gap-1">
                                        <button class="btn btn-success rounded-circle d-flex align-items-center justify-content-center shadow-sm" 
                                                type="submit" style="width: 35px; height: 35px;">
                                            <i class="fas fa-search" style="font-size: 0.85rem;"></i>
                                        </button>
                                        @if(request('search') || request('type'))
                                            <a href="{{ route('facilities.index') }}" 
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

    <!-- Tabel Fasilitas -->
    <div class="card shadow-sm border-0 mb-5">
        <div class="card-header bg-success py-3 d-flex align-items-center">
            <i class="fas fa-list me-2 text-white"></i>
            <h6 class="m-0 font-weight-bold text-white">Daftar Fasilitas</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light text-secondary">
                        <tr>
                            <th class="ps-4" style="width: 100px">Foto</th>
                            <th>Nama Fasilitas</th>
                            <th style="width: 120px">Tipe</th>
                            <th style="width: 150px">Lokasi</th>
                            <th style="width: 80px" class="text-center">Kapasitas</th>
                            <th class="text-center" style="width: 100px">Status</th>
                            <th class="text-center pe-4" style="width: 120px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($facilities as $facility)
                        <tr>
                            <td class="ps-4">
                                @if($facility->image)
                                    <img src="{{ asset('storage/'.$facility->image) }}" class="rounded shadow-sm border" width="60" height="60" style="object-fit: cover;">
                                @else
                                    <div class="bg-light border rounded d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                        <i class="fas fa-building text-secondary"></i>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <div class="fw-bold text-dark">{{ $facility->name }}</div>
                                <div class="text-muted small text-truncate" style="max-width: 250px;" title="{{ strip_tags($facility->description) }}">
                                    {{ Str::limit(strip_tags($facility->description), 50) }}
                                </div>
                            </td>
                            <td><span class="badge bg-info">{{ $facility->type }}</span></td>
                            <td><i class="fas fa-map-marker-alt me-1 text-muted"></i> {{ $facility->location }}</td>
                            <td class="text-center">{{ $facility->capacity ?? '-' }} org</td>
                            <td class="text-center">
                                <span class="badge rounded-pill {{ $facility->active ? 'bg-success-subtle text-success border border-success' : 'bg-secondary-subtle text-secondary border border-secondary' }} px-3">
                                    {{ $facility->active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td class="text-center pe-4">
                                <div class="btn-group shadow-sm">
                                    <a href="{{ route('facilities.edit', $facility->id) }}" class="btn btn-sm btn-outline-success">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('facilities.destroy', $facility->id) }}" method="POST" class="d-inline delete-form">
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
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="fas fa-building fa-2x mb-2 d-block"></i>
                                Belum ada data fasilitas. <a href="{{ route('facilities.create') }}" class="text-success">Tambah sekarang</a>.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($facilities->hasPages())
            <div class="card-footer bg-white border-top-0 py-3 d-flex justify-content-center">
                {{ $facilities->links() }}
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
                    title: 'Hapus Fasilitas?',
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
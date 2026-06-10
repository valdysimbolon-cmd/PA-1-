@extends('layouts.admin')

@section('title', 'Daftar Mitra')

@section('content')
<div class="container-fluid px-4">
    <!-- Judul + Tombol Tambah -->
    <div class="d-flex justify-content-between align-items-center mt-4 mb-4">
        <div>
            <h1 class="h3 text-gray-800 mb-1">Manajemen Mitra Kerja Sama</h1>
            <p class="text-muted small mb-0">Kelola instansi/perusahaan mitra dan kerja samanya.</p>
        </div>
        <a href="{{ route('cooperations.create') }}" class="btn btn-success shadow-sm px-3 d-flex align-items-center" style="height: 42px;">
            <i class="fas fa-plus me-2"></i> <span>Mitra Baru</span>
        </a>
    </div>

    <!-- Statistik & Toolbar Filter + Search -->
    <div class="row mb-4 g-3">
        <!-- Kartu Statistik Total Mitra -->
        <div class="col-xl-4 col-md-5">
            <div class="card border-0 shadow-sm border-start border-success border-5 h-100">
                <div class="card-body py-3 d-flex align-items-center">
                    <div class="d-flex justify-content-between align-items-center w-100">
                        <div>
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Mitra</div>
                            <div class="h3 mb-0 font-weight-bold text-gray-800">{{ $cooperations->total() ?? $cooperations->count() }}</div>
                        </div>
                        <div class="rounded-circle p-3" style="background-color: rgba(25, 135, 84, 0.1);">
                            <i class="fas fa-handshake fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Toolbar Filter & Search -->
        <div class="col-xl-8 col-md-7">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center py-2">
                    <form method="GET" action="{{ route('cooperations.index') }}" class="w-100">
                        <div class="row g-2">
                            <!-- Dropdown Tipe (tanpa onchange) -->
                            <div class="col-md-5">
                                <select name="type" class="form-select border-0 bg-light" style="height: 45px;">
                                    <option value="">Semua Tipe</option>
                                    <option value="Industri" {{ request('type') == 'Industri' ? 'selected' : '' }}>Industri</option>
                                    <option value="Akademik" {{ request('type') == 'Akademik' ? 'selected' : '' }}>Akademik</option>
                                    <option value="Pemerintah" {{ request('type') == 'Pemerintah' ? 'selected' : '' }}>Pemerintah</option>
                                </select>
                            </div>
                            <!-- Input Pencarian & Tombol -->
                            <div class="col-md-7">
                                <div class="input-group bg-light rounded px-2" style="height: 45px;">
                                    <input type="text" name="search" class="form-control bg-transparent border-0 shadow-none px-2" 
                                        placeholder="Cari nama instansi..." value="{{ request('search') }}">
                                    
                                    <div class="d-flex align-items-center gap-1">
                                        <button class="btn btn-success rounded-circle d-flex align-items-center justify-content-center" 
                                                type="submit" style="width: 35px; height: 35px;">
                                            <i class="fas fa-search" style="font-size: 0.9rem;"></i>
                                        </button>
                                        @if(request('search') || request('type'))
                                            <a href="{{ route('cooperations.index') }}" class="btn btn-light rounded-circle d-flex align-items-center justify-content-center border" 
                                            style="width: 35px; height: 35px;" title="Reset Filter">
                                                <i class="fas fa-sync-alt text-muted" style="font-size: 0.8rem;"></i>
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

    <!-- Tabel Mitra -->
    <div class="card shadow-sm border-0 mb-5">
        <div class="card-header bg-success py-3 d-flex align-items-center">
            <i class="fas fa-building me-2 text-white"></i>
            <h6 class="m-0 font-weight-bold text-white">Daftar Instansi Mitra</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light text-secondary">
                        <tr>
                            <th class="ps-4" style="width: 80px">Logo</th>
                            <th>Nama Instansi</th>
                            <th style="width: 120px">Tipe</th>
                            <th>Masa Berlaku</th>
                            <th class="text-center" style="width: 100px">Status</th>
                            <th class="text-center pe-4" style="width: 120px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($cooperations as $mitra)
                        <tr>
                            <td class="ps-4">
                                @if($mitra->logo)
                                    <img src="{{ asset('storage/'.$mitra->logo) }}" class="rounded-circle border" width="45" height="45" style="object-fit: cover;">
                                @else
                                    <div class="bg-light border rounded-circle d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                                        <i class="fas fa-building text-secondary"></i>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <div class="fw-bold text-dark">{{ $mitra->name }}</div>
                                @if($mitra->description)
                                    <small class="text-muted d-block text-truncate" style="max-width: 250px;">{{ Str::limit($mitra->description, 60) }}</small>
                                @endif
                            </td>
                            <td><span class="badge bg-info">{{ $mitra->type }}</span></td>
                            <td>
                                <small>
                                    {{ $mitra->start_date ? \Carbon\Carbon::parse($mitra->start_date)->format('d M Y') : '-' }}
                                    <br>s/d<br>
                                    {{ $mitra->end_date ? \Carbon\Carbon::parse($mitra->end_date)->format('d M Y') : 'Selamanya' }}
                                </small>
                            </td>
                            <td class="text-center">
                                <span class="badge rounded-pill {{ $mitra->active ? 'bg-success-subtle text-success border-success' : 'bg-secondary-subtle text-secondary border-secondary' }} border px-3">
                                    {{ $mitra->active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td class="text-center pe-4">
                                <div class="btn-group shadow-sm">
                                    <a href="{{ route('cooperations.edit', $mitra->id) }}" class="btn btn-sm btn-outline-success">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('cooperations.destroy', $mitra->id) }}" method="POST" class="d-inline delete-form">
                                        @csrf
                                        @method('DELETE')
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
                                <i class="fas fa-handshake fa-2x mb-2 d-block"></i>
                                Belum ada data mitra. <a href="{{ route('cooperations.create') }}" class="text-success">Tambah sekarang</a>.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    @if(method_exists($cooperations, 'links'))
        <div class="d-flex justify-content-center mt-4 mb-5">
            {{ $cooperations->links() }}
        </div>
    @endif
</div>

<style>
    .bg-success-subtle { background-color: #e8f5e9 !important; }
    .bg-secondary-subtle { background-color: #f8f9fa !important; }
    .input-group .btn { z-index: 0 !important; }
    .form-control:focus, .form-select:focus { box-shadow: none; border-color: #198754; }
    .card { border-radius: 10px; }
</style>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
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

        // Konfirmasi hapus
        const deleteButtons = document.querySelectorAll('.delete-btn');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                const form = this.closest('form.delete-form');
                Swal.fire({
                    title: 'Hapus Mitra?',
                    text: "Data yang dihapus tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });
</script>
@endpush
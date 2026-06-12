@extends('layouts.admin')

@section('title', 'Manajemen Dosen & Staff')

@section('content')
<div class="container-fluid px-3 px-md-4">
    <!-- Judul + Tombol Tambah -->
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mt-4 mb-4">
        <div>
            <h1 class="h3 text-gray-800 mb-1">Manajemen Dosen & Staff</h1>
            <p class="text-muted small mb-0">Kelola data dosen, tenaga pendidik, dan staf administrasi.</p>
        </div>
        <a href="{{ route('lecturers.create') }}" class="btn btn-success shadow-sm px-3 d-flex align-items-center" style="height: 42px;">
            <i class="fas fa-plus me-2"></i> <span>Personel Baru</span>
        </a>
    </div>

    <!-- Statistik & Pencarian + Filter -->
    <div class="row g-3 mb-4">
        <!-- Kartu Statistik -->
        <div class="col-12 col-xl-4">
            <div class="card border-0 shadow-sm border-start border-success border-5 h-100">
                <div class="card-body py-3 d-flex align-items-center">
                    <div class="d-flex justify-content-between align-items-center w-100">
                        <div>
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Personel</div>
                            <div class="h3 mb-0 font-weight-bold text-gray-800">{{ $lecturers->count() }}</div>
                        </div>
                        <div class="rounded-circle p-3" style="background-color: rgba(25, 135, 84, 0.1);">
                            <i class="fas fa-users fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Toolbar Filter & Search -->
        <div class="col-12 col-xl-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body py-2">
                    <form method="GET" action="{{ route('lecturers.index') }}" class="w-100">
                        <div class="row g-2">
                            <div class="col-12 col-md-5">
                                <select name="type" class="form-select border-0 bg-light" style="height: 45px;">
                                    <option value="">Semua Personel</option>
                                    <option value="dosen" {{ request('type') == 'dosen' ? 'selected' : '' }}>Dosen</option>
                                    <option value="staff" {{ request('type') == 'staff' ? 'selected' : '' }}>Staff / Tendik</option>
                                </select>
                            </div>
                            <div class="col-12 col-md-7">
                                <div class="input-group bg-light rounded px-2" style="height: 45px;">
                                    <input type="text" name="search" class="form-control bg-transparent border-0 shadow-none px-2" 
                                           placeholder="Cari nama atau NIP..." value="{{ request('search') }}">
                                    <div class="d-flex align-items-center gap-1">
                                        <button class="btn btn-success rounded-circle d-flex align-items-center justify-content-center" 
                                                type="submit" style="width: 35px; height: 35px;">
                                            <i class="fas fa-search" style="font-size: 0.9rem;"></i>
                                        </button>
                                        @if(request('search') || request('type'))
                                            <a href="{{ route('lecturers.index') }}" class="btn btn-light rounded-circle d-flex align-items-center justify-content-center border" 
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

    <!-- Tabel Data -->
    <div class="card shadow-sm border-0 mb-5">
        <div class="card-header bg-success py-3 d-flex align-items-center">
            <i class="fas fa-list me-2 text-white"></i>
            <h6 class="m-0 font-weight-bold text-white">Database Personel Teknik Bioproses</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light text-secondary">
                        <tr>
                            <th class="ps-4">Identitas</th>
                            <th>Jabatan & Golongan</th>
                            <th>Email & Kantor</th>
                            <th style="width: 120px">Atasan</th>
                            <th class="text-center" style="width: 80px">Status</th>
                            <th class="text-center pe-4" style="width: 100px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($lecturers as $l)
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    @if($l->image)
                                        <img src="{{ asset('storage/'.$l->image) }}" class="rounded-circle me-2 border" width="45" height="45" style="object-fit: cover;">
                                    @else
                                        <div class="bg-light border rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 45px; height: 45px;">
                                            <i class="fas fa-user text-secondary"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <div class="fw-bold text-dark">{{ $l->name }}</div>
                                        <small class="text-muted">{{ $l->nip_nidn }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-info">{{ $l->academic_position }}</span>
                                @if($l->academic_level)
                                    <br><small class="text-muted">{{ $l->academic_level }}</small>
                                @endif
                            </td>
                            <td>
                                <small><i class="fas fa-envelope me-1"></i> {{ $l->email }}</small>
                                @if($l->office)
                                    <br><small><i class="fas fa-building me-1"></i> {{ $l->office }}</small>
                                @endif
                            </td>
                            <td>
                                @if($l->leader)
                                    <small class="fw-semibold">{{ $l->leader->name }}</small>
                                @else
                                    <span class="text-muted small">Pimpinan Tertinggi</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <span class="badge rounded-pill {{ $l->active ? 'bg-success-subtle text-success border-success' : 'bg-secondary-subtle text-secondary border-secondary' }} border px-3">
                                    {{ $l->active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td class="text-center pe-4">
                                <div class="btn-group shadow-sm">
                                    <a href="{{ route('lecturers.edit', $l->id) }}" class="btn btn-sm btn-outline-success">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('lecturers.destroy', $l->id) }}" method="POST" class="d-inline delete-form">
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
                                <i class="fas fa-users fa-2x mb-2 d-block"></i>
                                Belum ada data personel. <a href="{{ route('lecturers.create') }}" class="text-success">Tambah sekarang</a>.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($lecturers->hasPages())
            <div class="card-footer bg-white border-top-0 py-3 d-flex justify-content-center">
                {{ $lecturers->links() }}
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

        const deleteButtons = document.querySelectorAll('.delete-btn');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                const form = this.closest('form.delete-form');
                Swal.fire({
                    title: 'Hapus Personel?',
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
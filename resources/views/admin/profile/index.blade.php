@extends('layouts.admin')

@section('title', 'Manajemen Profil')

@section('content')
<div class="container-fluid px-3 px-md-4">
    <!-- Judul + Tombol Tambah -->
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mt-4 mb-4">
        <div>
            <h1 class="h3 text-gray-800 mb-1">Manajemen Profil</h1>
            <p class="text-muted small mb-0">Kelola konten sejarah, visi, misi, dan informasi program studi.</p>
        </div>
        <a href="{{ route('profiles.create') }}" class="btn btn-success shadow-sm px-3 d-flex align-items-center" style="height: 42px;">
            <i class="fas fa-plus me-2"></i> <span>Profil Baru</span>
        </a>
    </div>

    <!-- Statistik & Pencarian (Responsif) -->
    <div class="row g-3 mb-4">
        <div class="col-12 col-xl-4">
            <div class="card border-0 shadow-sm border-start border-success border-5">
                <div class="card-body py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Konten</div>
                            <div class="h3 mb-0 font-weight-bold text-gray-800">{{ $profiles->total() ?? $profiles->count() }}</div>
                        </div>
                        <div class="rounded-circle p-3" style="background-color: rgba(25, 135, 84, 0.1);">
                            <i class="fas fa-file-alt fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-xl-8">
            <form method="GET" action="{{ route('profiles.index') }}" class="m-0">
                <div class="input-group shadow-sm">
                    <input type="text" name="search" class="form-control border-0 px-3" 
                           placeholder="Cari judul atau kode profil..." value="{{ request('search') }}"
                           style="height: 42px;">
                    <button class="btn btn-success" type="submit" title="Cari">
                        <i class="fas fa-search"></i>
                    </button>
                    @if(request('search'))
                        <a href="{{ route('profiles.index') }}" class="btn btn-outline-secondary d-flex align-items-center" title="Reset Pencarian">
                            <i class="fas fa-times me-1"></i> Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- Tabel Profil -->
    <div class="card shadow-sm border-0 mb-5">
        <div class="card-header bg-success py-3 d-flex align-items-center">
            <i class="fas fa-list me-2 text-white"></i>
            <h6 class="m-0 font-weight-bold text-white">Daftar Konten Profil</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light text-secondary">
                        <tr>
                            <th class="ps-4" style="width: 150px">Kode</th>
                            <th>Judul</th>
                            <th class="text-center" style="width: 100px">Status</th>
                            <th class="text-center pe-4" style="width: 120px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($profiles as $profile)
                        <tr>
                            <td class="ps-4">
                                <code>{{ $profile->key }}</code>
                                <br>
                                <small class="text-muted">
                                    @if(Str::startsWith($profile->key, 'B_'))
                                        <i class="fas fa-home"></i> Beranda
                                    @elseif(Str::startsWith($profile->key, 'P_'))
                                        <i class="fas fa-university"></i> Profil Prodi
                                    @else
                                        <i class="fas fa-tag"></i> Lainnya
                                    @endif
                                </small>
                            </td>
                            <td>
                                <div class="fw-bold text-dark">{{ $profile->name }}</div>
                                <small class="text-muted text-truncate d-inline-block" style="max-width: 300px;" title="{{ strip_tags($profile->description) }}">
                                    {{ Str::limit(strip_tags($profile->description), 60) }}
                                </small>
                            </td>
                            <td class="text-center">
                                <span class="badge rounded-pill {{ $profile->active ? 'bg-success-subtle text-success border-success' : 'bg-secondary-subtle text-secondary border-secondary' }} border px-3">
                                    {{ $profile->active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td class="text-center pe-4">
                                <div class="btn-group shadow-sm">
                                    <a href="{{ route('profiles.edit', $profile->id) }}" class="btn btn-sm btn-outline-success">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('profiles.destroy', $profile->id) }}" method="POST" class="d-inline delete-form">
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
                            <td colspan="4" class="text-center py-5 text-muted">
                                <i class="fas fa-file-alt fa-2x mb-2 d-block"></i>
                                Belum ada data profil. <a href="{{ route('profiles.create') }}" class="text-success">Tambah sekarang</a>.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    @if(method_exists($profiles, 'links'))
        <div class="d-flex justify-content-center mt-4 mb-5">
            {{ $profiles->links() }}
        </div>
    @endif
</div>

<style>
    .bg-success-subtle { background-color: #e8f5e9 !important; }
    .bg-secondary-subtle { background-color: #f8f9fa !important; }
    .input-group .btn { z-index: 0 !important; }
    .form-control:focus { box-shadow: none; border-color: #198754; }
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
            button.addEventListener('click', function(e) {
                const form = this.closest('form.delete-form');
                Swal.fire({
                    title: 'Hapus konten profil?',
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
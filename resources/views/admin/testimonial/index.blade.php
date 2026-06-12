@extends('layouts.admin')

@section('title', 'Manajemen Testimoni')

@section('content')
<div class="container-fluid px-3 px-md-4">
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mt-4 mb-4">
        <div>
            <h1 class="h3 text-gray-800 mb-1">Manajemen Testimoni</h1>
            <p class="text-muted small mb-0">Kelola dan pantau testimoni dari alumni atau mahasiswa.</p>
        </div>
        <a href="{{ route('testimonials.create') }}" class="btn btn-success shadow-sm px-3 d-flex align-items-center" style="height: 42px;">
            <i class="fas fa-plus me-2"></i> <span>Testimoni Baru</span>
        </a>
    </div>

    <!-- Statistik & Pencarian -->
    <div class="row g-3 mb-4">
        <div class="col-12 col-xl-4">
            <div class="card border-0 shadow-sm border-start border-success border-5">
                <div class="card-body py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Testimoni</div>
                            <div class="h3 mb-0 font-weight-bold text-gray-800">{{ $totalTestimonials }}</div>
                        </div>
                        <div class="rounded-circle p-3" style="background-color: rgba(25, 135, 84, 0.1);">
                            <i class="fas fa-comment-dots fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-xl-8">
            <form method="GET" action="{{ route('testimonials.index') }}" class="m-0">
                <div class="input-group shadow-sm">
                    <input type="text" name="search" class="form-control border-0 px-3" 
                           placeholder="Cari nama, angkatan..." value="{{ request('search') }}"
                           style="height: 42px;">
                    <button class="btn btn-success" type="submit" title="Cari">
                        <i class="fas fa-search"></i>
                    </button>
                    @if(request('search'))
                        <a href="{{ route('testimonials.index') }}" class="btn btn-outline-secondary d-flex align-items-center" title="Reset Pencarian">
                            <i class="fas fa-times me-1"></i> Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- Tabel Testimoni -->
    <div class="card shadow-sm border-0 mb-5">
        <div class="card-header bg-success py-3 d-flex align-items-center">
            <i class="fas fa-list me-2 text-white"></i>
            <h6 class="m-0 font-weight-bold text-white">Daftar Testimoni Alumni</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light text-secondary">
                        <tr>
                            <th class="ps-4" style="width: 80px">Foto</th>
                            <th>Nama & Angkatan</th>
                            <th>Pekerjaan</th>
                            <th>Testimoni</th>
                            <th class="text-center" style="width: 100px">Status</th>
                            <th class="text-center pe-4" style="width: 120px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($testimonials as $t)
                        <tr>
                            <td class="ps-4">
                                @if($t->photo)
                                    <img src="{{ asset('storage/'.$t->photo) }}" class="rounded-circle border" width="45" height="45" style="object-fit: cover;">
                                @else
                                    <div class="bg-light border rounded-circle d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                                        <i class="fas fa-user text-secondary"></i>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <div class="fw-bold text-dark">{{ $t->name }}</div>
                                <div class="text-muted small">Angkatan {{ $t->batch }}</div>
                            </td>
                            <td>{{ $t->position ?? '-' }}</td>
                            <td>
                                <div class="text-muted small text-truncate" style="max-width: 250px;" title="{{ $t->content }}">
                                    {{ Str::limit($t->content, 80) }}
                                </div>
                            </td>
                            <td class="text-center">
                                <span class="badge rounded-pill {{ $t->active ? 'bg-success-subtle text-success border-success' : 'bg-secondary-subtle text-secondary border-secondary' }} border px-3">
                                    {{ $t->active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td class="text-center pe-4">
                                <div class="btn-group shadow-sm">
                                    <a href="{{ route('testimonials.edit', $t->id) }}" class="btn btn-sm btn-outline-success"><i class="fas fa-edit"></i></a>
                                    <form action="{{ route('testimonials.destroy', $t->id) }}" method="POST" class="d-inline delete-form">
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
                                <i class="fas fa-comment-dots fa-2x mb-2 d-block"></i>
                                Belum ada testimoni. <a href="{{ route('testimonials.create') }}" class="text-success">Tambah sekarang</a>.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    @if(method_exists($testimonials, 'links'))
        <div class="d-flex justify-content-center mt-4 mb-5">
            {{ $testimonials->links() }}
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

        const deleteButtons = document.querySelectorAll('.delete-btn');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                const form = this.closest('form.delete-form');
                Swal.fire({
                    title: 'Hapus Testimoni?',
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
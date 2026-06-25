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
        <div class="col-12 col-xl-3">
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

        <div class="col-12 col-xl-9">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 12px;">
                <div class="card-body d-flex align-items-center py-3 px-3">
                    <form method="GET" action="{{ route('testimonials.index') }}" class="w-100 m-0">
                        <div class="row g-2">
                            <div class="col-12 col-md-4">
                                <label class="filter-label text-muted"><i class="fas fa-search me-1"></i> Cari Testimoni</label>
                                <div class="search-wrap">
                                    <input type="text" name="search" class="search-input"
                                           placeholder="Nama, angkatan..."
                                           value="{{ request('search') }}">
                                    <div class="search-actions">
                                        @if(request('search'))
                                            <a href="{{ route('testimonials.index') }}" class="btn-reset" title="Reset">
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

    <!-- Tabel -->
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
                                    <img src="{{ asset('storage/'.$t->photo) }}" class="rounded-circle border shadow-sm" width="45" height="45" style="object-fit: cover;">
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
                            <td><span class="small text-muted">{{ $t->position ?? '-' }}</span></td>
                            <td>
                                <div class="text-muted small text-truncate" style="max-width: 250px;" title="{{ $t->content }}">
                                    {{ Str::limit($t->content, 80) }}
                                </div>
                            </td>
                            <td class="text-center">
                                {{-- BADGE STATUS (sama dengan Hero & Informasi) --}}
                                <span class="badge rounded-pill {{ $t->active ? 'bg-success-subtle text-success border border-success' : 'bg-secondary-subtle text-secondary border border-secondary' }} px-3">
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
        @if(method_exists($testimonials, 'links') && $testimonials->hasPages())
            <div class="card-footer bg-white border-top-0 py-3 d-flex justify-content-center">
                {{ $testimonials->links() }}
            </div>
        @endif
    </div>
</div>

<style>
    .bg-success-subtle { background-color: #e8f5e9 !important; }
    .bg-secondary-subtle { background-color: #f8f9fa !important; }
    .card { border-radius: 10px; }

    .filter-label {
        display: block; font-size: 0.7rem; font-weight: 600;
        text-transform: uppercase; letter-spacing: 0.04em;
        margin-bottom: 4px; padding-left: 2px;
    }

    .search-wrap {
        display: flex; align-items: center; height: 38px;
        border-radius: 8px; border: 1.5px solid #c8e6c9;
        background: #fff; overflow: hidden; padding-left: 10px;
        box-shadow: 0 1px 4px rgba(0,0,0,0.07), inset 0 1px 2px rgba(255,255,255,0.9);
        transition: border-color 0.15s, box-shadow 0.15s;
    }
    .search-wrap:focus-within { border-color: #198754; box-shadow: 0 0 0 3px rgba(25,135,84,0.15); }
    .search-input { flex: 1; border: none; outline: none; font-size: 0.85rem; background: transparent; color: #333; min-width: 0; }
    .search-input::placeholder { color: #bbb; }
    .search-actions { display: flex; align-items: center; gap: 3px; padding-right: 5px; }

    .btn-reset {
        display: flex; align-items: center; justify-content: center;
        width: 26px; height: 26px; border-radius: 50%;
        background: #fff0f0; border: 1px solid #f5c6cb;
        color: #dc3545; font-size: 0.7rem; text-decoration: none; transition: background 0.15s;
    }
    .btn-reset:hover { background: #f5c2c7; color: #dc3545; }

    .btn-cari {
        width: 30px; height: 30px; border-radius: 7px; border: none;
        background-color: #198754; color: #fff; font-size: 0.8rem; cursor: pointer;
        display: flex; align-items: center; justify-content: center;
        box-shadow: 0 1px 4px rgba(25,135,84,0.25); transition: background 0.15s;
    }
    .btn-cari:hover { background-color: #157347; }

    @media (max-width: 576px) {
        .table td, .table th { white-space: nowrap; }
        .btn-group .btn { padding: 0.2rem 0.4rem; }
    }
</style>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Notifikasi sukses (di tengah, bukan toast)
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

        // Notifikasi error (di tengah)
        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{ session('error') }}',
                confirmButtonColor: '#dc3545'
            });
        @endif

        // Konfirmasi hapus (sama dengan hero)
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function () {
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
                    if (result.isConfirmed) form.submit();
                });
            });
        });
    });
</script>
@endpush
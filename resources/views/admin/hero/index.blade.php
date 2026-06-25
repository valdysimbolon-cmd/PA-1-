@extends('layouts.admin')

@section('title', 'Manajemen Hero Banner')

@section('content')
<div class="container-fluid px-3 px-md-4">
    <!-- Header -->
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mt-4 mb-4">
        <div>
            <h1 class="h3 text-gray-800 mb-1">Manajemen Hero Banner</h1>
            <p class="text-muted small mb-0">Kelola tampilan visual utama pada halaman beranda publik.</p>
        </div>
        <a href="{{ route('heroes.create') }}" class="btn btn-success shadow-sm px-3 d-flex align-items-center" style="height: 42px;">
            <i class="fas fa-plus me-2"></i> <span>Tambah Banner</span>
        </a>
    </div>

    <!-- Statistik -->
    <div class="row g-3 mb-4">
        <div class="col-12 col-md-4 col-xl-3">
            <div class="card border-0 shadow-sm border-start border-success border-5">
                <div class="card-body py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Banner</div>
                            <div class="h3 mb-0 font-weight-bold text-gray-800">{{ $heroes->count() }}</div>
                        </div>
                        <div class="rounded-circle p-3" style="background-color: rgba(25, 135, 84, 0.1);">
                            <i class="fas fa-images fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Banner -->
    <div class="card shadow-sm border-0 mb-5">
        <div class="card-header bg-success py-3 d-flex align-items-center">
            <i class="fas fa-list me-2 text-white"></i>
            <h6 class="m-0 font-weight-bold text-white">Daftar Hero Banner</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light text-secondary">
                        <tr>
                            <th class="ps-4" style="width: 150px">Preview Video</th>
                            <th>Konten Slogan</th>
                            <th class="text-center" style="width: 120px">Status</th>
                            <th class="d-none d-md-table-cell" style="width: 180px">Aksi Tombol</th>
                            <th class="text-center pe-4" style="width: 120px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($heroes as $hero)
                        <tr>
                            <td class="ps-4">
                                @if($hero->hasVideo())
                                    <div class="video-thumbnail shadow-sm border">
                                        <img src="https://img.youtube.com/vi/{{ $hero->video_id }}/mqdefault.jpg" class="img-fluid">
                                        <div class="play-overlay"><i class="fab fa-youtube"></i></div>
                                    </div>
                                @else
                                    <div class="bg-light border rounded d-flex align-items-center justify-content-center" style="height: 70px;">
                                        <i class="fas fa-video-slash text-muted"></i>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <div class="fw-bold text-dark">{{ Str::limit($hero->title, 50) }}</div>
                                <div class="text-muted small mt-1">{{ Str::limit($hero->subtitle, 70) }}</div>
                            </td>
                            <td class="text-center">
                                <span class="badge rounded-pill {{ $hero->active ? 'bg-success-subtle text-success border border-success' : 'bg-secondary-subtle text-secondary border border-secondary' }} px-3">
                                    {{ $hero->active ? 'Aktif' : 'Draft' }}
                                </span>
                            </td>
                            <td class="d-none d-md-table-cell">
                                <div class="small text-muted mb-1">Primary Link:</div>
                                <div class="text-truncate" style="max-width: 150px;">
                                    <a href="{{ $hero->primary_button_url }}" target="_blank" class="text-success text-decoration-none small fw-bold">
                                        <i class="fas fa-link me-1"></i> {{ $hero->primary_button_text }}
                                    </a>
                                </div>
                            </td>
                            <td class="text-center pe-4">
                                <div class="btn-group shadow-sm">
                                    <a href="{{ route('heroes.edit', $hero->id) }}" class="btn btn-sm btn-outline-success" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('heroes.destroy', $hero->id) }}" method="POST" class="d-inline delete-form">
                                        @csrf @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-outline-danger delete-btn" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="fas fa-film fa-2x mb-2 d-block"></i>
                                Belum ada hero banner. <a href="{{ route('heroes.create') }}" class="text-success">Buat sekarang</a>.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-success-subtle { background-color: #e8f5e9 !important; }
    .bg-secondary-subtle { background-color: #f8f9fa !important; }
    
    .video-thumbnail {
        position: relative; width: 120px; height: 70px; border-radius: 6px; overflow: hidden;
    }
    .video-thumbnail img { width: 100%; height: 100%; object-fit: cover; }
    .play-overlay {
        position: absolute; top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(0,0,0,0.3); display: flex; align-items: center; justify-content: center;
        color: #fff; font-size: 1.5rem;
    }

    .table th { font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.05em; }
    .btn-group .btn { width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; }
</style>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        @if(session('success'))
            Swal.fire({ icon: 'success', title: 'Berhasil!', text: '{{ session('success') }}', timer: 2000, showConfirmButton: false });
        @endif

        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function () {
                const form = this.closest('form.delete-form');
                Swal.fire({
                    title: 'Hapus Banner?',
                    text: "Tampilan beranda akan berubah setelah dihapus.",
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
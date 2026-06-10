
@extends('layouts.admin')
@section('title', 'Manajemen Berita & Kegiatan')
@section('content')
<div class="container-fluid px-4">
    <!-- Judul + Tombol Tambah -->
    <div class="d-flex justify-content-between align-items-center mt-4 mb-4">
        <div>
            <h1 class="h3 text-gray-800 mb-1">Manajemen Berita</h1>
            <p class="text-muted small mb-0">Kelola informasi, berita terbaru, dan kegiatan program studi.</p>
        </div>
        <a href="{{ route('news.create') }}" class="btn btn-success shadow-sm px-3 d-flex align-items-center" style="height: 42px;">
            <i class="fas fa-plus me-2"></i> <span>Tulis Berita Baru</span>
        </a>
    </div>
<!-- Statistik & Pencarian + Filter -->
<div class="row mb-4 g-3">
    <!-- Kartu Statistik -->
    <div class="col-xl-4 col-md-5">
        <div class="card border-0 shadow-sm border-start border-success border-5 h-100">
            <div class="card-body py-3 d-flex align-items-center">
                <div class="d-flex justify-content-between align-items-center w-100">
                    <div>
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Berita</div>
                        <div class="h3 mb-0 font-weight-bold text-gray-800">{{ $news->total() ?? $news->count() }}</div>
                    </div>
                    <div class="rounded-circle p-3" style="background-color: rgba(25, 135, 84, 0.1);">
                        <i class="fas fa-newspaper fa-2x text-success"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Toolbar Filter & Search -->
    <div class="col-xl-8 col-md-7">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center py-2">
                <form method="GET" action="{{ route('news.index') }}" class="w-100">
                    <div class="row g-2">
                        <!-- Dropdown Kategori (tanpa onchange) -->
                        <div class="col-md-5">
                            <select name="category" class="form-select border-0 bg-light" style="height: 45px;">
                                <option value="">Semua Kategori</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <!-- Input Pencarian & Tombol -->
                        <div class="col-md-7">
                            <div class="input-group bg-light rounded px-2" style="height: 45px;">
                                <input type="text" name="search" class="form-control bg-transparent border-0 shadow-none px-2" 
                                    placeholder="Cari judul berita..." value="{{ request('search') }}">
                                
                                <div class="d-flex align-items-center gap-1">
                                    <button class="btn btn-success rounded-circle d-flex align-items-center justify-content-center" 
                                            type="submit" style="width: 35px; height: 35px;">
                                        <i class="fas fa-search" style="font-size: 0.9rem;"></i>
                                    </button>
                                    @if(request('search') || request('category'))
                                        <a href="{{ route('news.index') }}" class="btn btn-light rounded-circle d-flex align-items-center justify-content-center border" 
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

<!-- Tabel Berita (tetap) -->
<div class="card shadow-sm border-0 mb-5">
    <div class="card-header bg-success py-3 d-flex align-items-center">
        <i class="fas fa-list me-2 text-white"></i>
        <h6 class="m-0 font-weight-bold text-white">Daftar Berita & Kegiatan</h6>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light text-secondary">
                    <tr>
                        <th class="ps-4" style="width: 100px">Gambar</th>
                        <th>Judul Berita</th>
                        <th style="width: 120px">Kategori</th>
                        <th style="width: 120px">Tanggal Terbit</th>
                        <th class="text-center" style="width: 100px">Status</th>
                        <th class="text-center pe-4" style="width: 120px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($news as $item)
                    <tr>
                        <td class="ps-4">
                            @if($item->image)
                                <img src="{{ asset('storage/'.$item->image) }}" class="rounded shadow-sm border" width="70" height="45" style="object-fit: cover;">
                            @else
                                <div class="bg-light border rounded d-inline-flex align-items-center justify-content-center" style="width: 70px; height: 45px;">
                                    <i class="fas fa-image text-secondary"></i>
                                </div>
                            @endif
                        </td>
                        <td>
                            <div class="fw-bold text-dark">{{ Str::limit($item->title, 60) }}</div>
                            <small class="text-muted">Oleh: {{ $item->creator->name ?? 'Admin' }}</small>
                        </td>
                        <td><span class="badge bg-info">{{ $item->category->name ?? '-' }}</span></td>
                        <td><small>{{ \Carbon\Carbon::parse($item->published_at)->format('d M Y') }}</small></td>
                        <td class="text-center">
                            @if($item->active)
                                <span class="badge rounded-pill bg-success-subtle text-success border border-success px-3">Terbit</span>
                            @else
                                <span class="badge rounded-pill bg-secondary-subtle text-secondary border border-secondary px-3">Draf</span>
                            @endif
                        </td>
                        <td class="text-center pe-4">
                            <div class="btn-group">
                                <a href="{{ route('news.edit', $item->id) }}" class="btn btn-sm btn-outline-success">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('news.destroy', $item->id) }}" method="POST" class="d-inline delete-form">
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
                            <i class="fas fa-newspaper fa-2x mb-2 d-block"></i>
                            Belum ada berita. <a href="{{ route('news.create') }}" class="text-success">Tulis berita pertama</a>.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Pagination -->
@if(method_exists($news, 'links'))
    <div class="d-flex justify-content-center mt-4 mb-5">
        {{ $news->links() }}
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
        // Notifikasi session (opsional, tambahkan jika ingin)
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
            button.addEventListener('click', function(e) {
                const form = this.closest('form.delete-form');
                Swal.fire({
                    title: 'Hapus berita?',
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
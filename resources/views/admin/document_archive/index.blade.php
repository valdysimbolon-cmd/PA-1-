@extends('layouts.admin')

@section('title', 'Arsip Dokumen')

@section('content')
<div class="container-fluid px-3 px-md-4">
    <!-- Header -->
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mt-4 mb-4">
        <div>
            <h1 class="h3 text-gray-800 mb-1">Manajemen Arsip Dokumen</h1>
            <p class="text-muted small mb-0">Kelola dokumen resmi, SOP, dan borang program studi.</p>
        </div>
        <a href="{{ route('document_archives.create') }}" class="btn btn-success shadow-sm px-3 d-flex align-items-center" style="height: 42px;">
            <i class="fas fa-plus me-2"></i> <span>Tambah Dokumen</span>
        </a>
    </div>

    <!-- Filter & Pencarian -->
    <div class="row g-3 mb-4">
        <div class="col-12 col-xl-4">
            <div class="card border-0 shadow-sm border-start border-success border-5">
                <div class="card-body py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Dokumen</div>
                            <div class="h3 mb-0 font-weight-bold text-gray-800">{{ $documents->total() }}</div>
                        </div>
                        <div class="rounded-circle p-3" style="background-color: rgba(25, 135, 84, 0.1);">
                            <i class="fas fa-folder-open fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-xl-8">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 12px;">
                <div class="card-body py-2">
                    <form method="GET" action="{{ route('document_archives.index') }}" class="w-100 m-0">
                        <div class="row g-2">
                            <!-- Dropdown Kategori -->
                            <div class="col-12 col-md-5">
                                <select name="tag" class="form-select border-0 bg-light fw-medium" style="height: 45px; border-radius: 8px; font-size: 0.9rem;">
                                    <option value="">Semua Kategori</option>
                                    @foreach(\App\Models\DocumentArchive::PRESET_TAGS as $tag)
                                        <option value="{{ $tag }}" {{ request('tag') == $tag ? 'selected' : '' }}>{{ $tag }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Input Pencarian & Tombol -->
                            <div class="col-12 col-md-7">
                                <div class="input-group bg-light rounded px-2" style="height: 45px; border-radius: 8px !important;">
                                    <input type="text" name="search" class="form-control bg-transparent border-0 shadow-none px-2" 
                                        placeholder="Cari judul dokumen..." value="{{ request('search') }}" style="font-size: 0.9rem;">
                                    
                                    <div class="d-flex align-items-center gap-1">
                                        <button class="btn btn-success rounded-circle d-flex align-items-center justify-content-center shadow-sm" 
                                                type="submit" style="width: 35px; height: 35px;">
                                            <i class="fas fa-search" style="font-size: 0.85rem;"></i>
                                        </button>

                                        @if(request('search') || request('tag'))
                                            <a href="{{ route('document_archives.index') }}" 
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

    <!-- Tabel Dokumen -->
    <div class="card shadow-sm border-0 mb-5">
        <div class="card-header bg-success py-3 d-flex align-items-center">
            <i class="fas fa-list me-2 text-white"></i>
            <h6 class="m-0 font-weight-bold text-white">Daftar Dokumen</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light text-secondary">
                        <tr>
                            <th class="ps-4">Dokumen</th>
                            <th style="width: 180px">Kategori</th>
                            <th class="text-center" style="width: 80px">Tahun</th>
                            <th class="text-center" style="width: 80px">File</th>
                            <th class="text-center" style="width: 100px">Status</th>
                            <th class="text-center pe-4" style="width: 100px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($documents as $doc)
                        <tr>
                            <td class="ps-4">
                                <div class="fw-bold text-dark">{{ $doc->title }}</div>
                                <div class="text-muted small text-truncate" style="max-width: 300px;" title="{{ strip_tags($doc->description) }}">
                                    {{ Str::limit(strip_tags($doc->description), 60) }}
                                </div>
                            </td>
                            <td>
                                @if($doc->tags)
                                    @foreach($doc->tags as $tag)
                                        <span class="badge bg-light text-success border border-success rounded-pill">{{ $tag }}</span>
                                    @endforeach
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="text-center">{{ $doc->year ?? '-' }}</td>
                            <td class="text-center">
                                @if($doc->hasFile())
                                    @php
                                        $icon = match($doc->file_extension) {
                                            'pdf' => 'fa-file-pdf text-danger',
                                            'docx' => 'fa-file-word text-primary',
                                            'xlsx' => 'fa-file-excel text-success',
                                            default => 'fa-file-alt text-secondary'
                                        };
                                    @endphp
                                    <a href="{{ route('document_archives.download', $doc->id) }}" class="btn btn-link p-0" title="Download">
                                        <i class="fas {{ $icon }} fa-2x"></i>
                                    </a>
                                @else
                                    <i class="fas fa-exclamation-circle text-warning" title="File tidak ditemukan"></i>
                                @endif
                            </td>
                            <td class="text-center">
                                <span class="badge rounded-pill {{ $doc->active ? 'bg-success-subtle text-success border border-success' : 'bg-secondary-subtle text-secondary border border-secondary' }} px-3">
                                    {{ $doc->active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                             </td>
                            <td class="text-center pe-4">
                                <div class="btn-group shadow-sm">
                                    <a href="{{ route('document_archives.edit', $doc->id) }}" class="btn btn-sm btn-outline-success">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('document_archives.destroy', $doc->id) }}" method="POST" class="d-inline delete-form">
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
                                <i class="fas fa-folder-open fa-2x mb-2 d-block"></i>
                                Belum ada dokumen. <a href="{{ route('document_archives.create') }}" class="text-success">Tambah sekarang</a>.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($documents->hasPages())
            <div class="card-footer bg-white border-top-0 py-3 d-flex justify-content-center">
                {{ $documents->links() }}
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
                    title: 'Hapus Dokumen?',
                    text: "File dan data akan dihapus permanen!",
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
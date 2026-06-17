@extends('layouts.admin')

@section('title', 'Manajemen Kurikulum')

@section('content')
<div class="container-fluid px-3 px-md-4 pb-5">

    {{-- HEADER HALAMAN --}}
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mt-4 mb-4">
        <div>
            <h1 class="h3 text-gray-800 mb-1 fw-bold">Struktur Akademik</h1>
            <p class="text-muted small mb-0">Kelola data kurikulum dan distribusi mata kuliah per semester.</p>
        </div>
        <a href="{{ route('curriculums.create') }}" class="btn btn-success shadow-sm px-4 fw-bold">
            <i class="fas fa-plus me-2"></i> Kurikulum Baru
        </a>
    </div>

    {{-- CARD STATISTIK PER SEMESTER --}}
    <div class="row g-3 mb-4">
        @foreach($stats as $smt => $total)
        <div class="col-6 col-md-4 col-xl-3">
            <div class="card border-0 shadow-sm border-start border-success border-5 h-100" style="border-radius: 12px;">
                <div class="card-body py-3 px-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-xs text-success text-uppercase fw-bold mb-1">Semester {{ $smt }}</div>
                            <div class="h5 mb-0 fw-bold text-gray-800">{{ $total }} <span class="small fw-normal text-muted">MK</span></div>
                        </div>
                        <div class="rounded-circle bg-light p-3 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                            <i class="fas fa-book-open text-success opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- VERSI KURIKULUM (daftar kurikulum) --}}
    <div class="card shadow-sm border-0 mb-5" style="border-radius: 15px; overflow: hidden;">
        <div class="card-header bg-success py-3 px-4">
            <h6 class="m-0 fw-bold text-white d-flex align-items-center">
                <i class="fas fa-history me-2"></i> Versi Kurikulum Program Studi
            </h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <tbody>
                        @forelse($curriculums as $c)
                        <tr>
                            <td class="ps-4 py-4" style="width: 45%;">
                                <div class="fw-bold text-dark fs-5">{{ $c->name }}</div>
                                <div class="text-muted small">Total: <span class="fw-bold">{{ $c->subjects_count }}</span> Mata Kuliah</div>
                             </td>
                            <td class="text-center">
                                @if($c->active)
                                    <span class="badge rounded-pill bg-success-subtle text-success border border-success px-3 py-2">
                                        <i class="fas fa-check-circle me-1"></i> Aktif Utama
                                    </span>
                                @else
                                    <span class="badge rounded-pill bg-secondary-subtle text-secondary border border-secondary px-3 py-2">
                                        Arsip
                                    </span>
                                @endif
                             </td>
                            <td class="text-end pe-4">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('curriculums.edit', $c->id) }}" class="btn btn-sm btn-outline-success">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('curriculums.destroy', $c->id) }}" method="POST" class="d-inline delete-form">
                                        @csrf @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-outline-danger delete-btn">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                             </td>
                        </tr>
                        @empty
                        <tr><td colspan="3" class="text-center py-5 text-muted">Belum ada versi kurikulum.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- PAGINATION UNTUK KURIKULUM --}}
            @if($curriculums->hasPages())
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 px-3 py-3 border-top">
                <div class="small text-muted">
                    Menampilkan {{ $curriculums->firstItem() ?? 0 }} – {{ $curriculums->lastItem() ?? 0 }} dari {{ $curriculums->total() }} kurikulum
                </div>
                <div>
                    {{ $curriculums->appends(request()->query())->links('pagination::bootstrap-5') }}
                </div>
            </div>
            @endif
        </div>
    </div>

    {{-- FILTER & DAFTAR MATA KULIAH KURIKULUM AKTIF --}}
    <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
        <div class="card-header bg-white py-3 px-4 border-bottom">
            <form method="GET" action="{{ route('curriculums.index') }}" class="row g-2 align-items-center">
                <div class="col-12 col-md-3">
                    <h6 class="m-0 fw-bold text-dark">Daftar Isi Kurikulum Aktif</h6>
                </div>
                <div class="col-12 col-md-3">
                    <select name="semester" class="form-select form-select-sm bg-light border-0" onchange="this.form.submit()">
                        <option value="">Semua Semester</option>
                        @for($i=1; $i<=8; $i++)
                            <option value="{{ $i }}" {{ request('semester') == $i ? 'selected' : '' }}>Semester {{ $i }}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-12 col-md-4">
                    <div class="input-group input-group-sm">
                        <input type="text" name="search_subject" class="form-control bg-light border-0" placeholder="Cari Kode/Nama MK..." value="{{ request('search_subject') }}">
                        <button class="btn btn-success" type="submit"><i class="fas fa-search"></i></button>
                    </div>
                </div>
                @if(request('semester') || request('search_subject'))
                <div class="col-12 col-md-2 text-md-end">
                    <a href="{{ route('curriculums.index') }}" class="btn btn-sm btn-outline-secondary w-100 w-md-auto">Reset Filter</a>
                </div>
                @endif
            </form>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-success text-white">
                        <tr class="text-uppercase small" style="font-size: 0.75rem;">
                            <th class="ps-4 py-3" style="width: 15%">Kode</th>
                            <th class="py-3" style="width: 30%">Mata Kuliah</th>
                            <th class="text-center py-3" style="width: 8%">SKS</th>
                            <th class="text-center py-3" style="width: 12%">Semester</th>
                            <th class="pe-4 py-3">Deskripsi</th>
                          </tr>
                    </thead>
                    <tbody>
                        @forelse($subjects as $s)
                        <tr class="border-bottom">
                            <td class="ps-4"><code class="text-success fw-bold">{{ $s->code }}</code></td>
                            <td class="fw-bold text-dark">{{ $s->name }}</td>
                            <td class="text-center">{{ $s->sks }} SKS</td>
                            <td class="text-center">
                                <span class="badge rounded-pill bg-soft-success text-success border border-success px-3 py-1">
                                    Semester {{ $s->semester }}
                                </span>
                            </td>
                            <td class="pe-4 text-muted" style="max-width: 250px;">
                                {{ Str::limit($s->description ?? '-', 80) }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="fas fa-folder-open fa-2x mb-2 d-block"></i>
                                Belum ada data mata kuliah.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- PAGINATION UNTUK MATA KULIAH --}}
            @if($subjects->hasPages())
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 px-3 py-3 border-top bg-light">
                <div class="small text-muted">
                    Menampilkan {{ $subjects->firstItem() ?? 0 }} – {{ $subjects->lastItem() ?? 0 }} dari {{ $subjects->total() }} mata kuliah
                </div>
                <div>
                    {{ $subjects->appends(request()->query())->links('pagination::bootstrap-5') }}
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<style>
    .bg-success-subtle { background-color: #e8f5e9 !important; }
    .bg-secondary-subtle { background-color: #f8f9fa !important; }
    .bg-soft-success { background-color: #e8f5e9 !important; }
    .input-group .btn { z-index: 0 !important; }
    .form-control:focus, .form-select:focus { box-shadow: none; border-color: #198754; }
    .card { border-radius: 12px; }
    .btn-outline-success:hover { background-color: #198754; color: white !important; }
    @media (max-width: 768px) {
        .table td, .table th { white-space: nowrap; }
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
                    title: 'Hapus Kurikulum?',
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
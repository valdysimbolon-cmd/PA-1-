@extends('layouts.admin')

@section('title', 'Transaksi Peminjaman Lab')

@section('content')
<div class="container-fluid px-3 px-md-4 pb-5">
    <!-- Header -->
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mt-4 mb-4">
        <div>
            <h1 class="h3 text-gray-800 mb-1 fw-bold">Transaksi Peminjaman Lab</h1>
            <p class="text-muted small mb-0">Kelola seluruh transaksi peminjaman alat laboratorium.</p>
        </div>
        <!-- Tombol "Peminjaman Baru" dihapus karena pendaftaran peminjaman dilakukan oleh mahasiswa via sistem MyBioproses -->
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-4 mb-4" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-header bg-success py-3 d-flex align-items-center">
            <i class="fas fa-list me-2 text-white"></i>
            <h6 class="m-0 font-weight-bold text-white">Daftar Peminjaman</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light text-secondary">
                        <tr>
                            <th class="ps-4">No. Resi</th>
                            <th>Peminjam</th>
                            <th>Tanggal Pinjam</th>
                            <th class="text-center">Status</th>
                            <th class="text-end pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($loans as $loan)
                        <tr>
                            <td class="ps-4">
                                <code class="fw-bold text-success">{{ $loan->receipt_number }}</code>
                            </td>
                            <td>
                                <div class="fw-bold text-dark">{{ $loan->borrower_name }}</div>
                                <div class="text-muted small">{{ $loan->nim }}</div>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($loan->planned_borrow_date)->format('d/m/Y') }}</td>
                            <td class="text-center">
                                @php
                                    $statusColors = [
                                        'pending'    => 'bg-warning-subtle text-warning border-warning',
                                        'approved'   => 'bg-primary-subtle text-primary border-primary',
                                        'returned'   => 'bg-success-subtle text-success border-success',
                                        'rejected'   => 'bg-danger-subtle text-danger border-danger',
                                        'handover'   => 'bg-info-subtle text-info border-info',
                                    ];
                                @endphp
                                <span class="badge rounded-pill border {{ $statusColors[$loan->status] ?? 'bg-secondary-subtle text-secondary border-secondary' }} px-3 py-2">
                                    {{ ucfirst($loan->status) }}
                                </span>
                            </td>
                            <td class="text-end pe-4">
                                <a href="{{ route('admin.loans.show', $loan->id) }}" class="btn btn-sm btn-outline-success rounded-pill px-3">
                                    <i class="fas fa-eye me-1"></i> Detail
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="fas fa-inbox fa-2x d-block mb-2"></i>
                                Belum ada pengajuan transaksi peminjaman saat ini.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($loans->hasPages())
            <div class="card-footer bg-white border-top-0 py-3 d-flex justify-content-center">
                {{ $loans->links() }}
            </div>
        @endif
    </div>
</div>

<style>
    .bg-warning-subtle { background-color: #fff3cd !important; }
    .bg-primary-subtle { background-color: #cfe2ff !important; }
    .bg-success-subtle { background-color: #d1e7dd !important; }
    .bg-danger-subtle { background-color: #f8d7da !important; }
    .bg-info-subtle { background-color: #cff4fc !important; }
</style>
@endsection
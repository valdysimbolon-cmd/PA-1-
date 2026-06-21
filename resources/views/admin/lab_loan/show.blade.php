@extends('layouts.admin')

@section('title', 'Detail Peminjaman')

@section('content')
<div class="container-fluid px-3 px-md-4 pb-5">
    <!-- Header -->
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mt-4 mb-4">
        <div>
            <h1 class="h3 text-gray-800 mb-1 fw-bold">Detail Peminjaman</h1>
            <p class="text-muted small mb-0">Resi: <strong>{{ $labLoan->receipt_number }}</strong></p>
        </div>
        <div>
            @php
                $statusColors = [
                    'pending'    => 'bg-warning-subtle text-warning border-warning',
                    'approved'   => 'bg-primary-subtle text-primary border-primary',
                    'returned'   => 'bg-success-subtle text-success border-success',
                    'rejected'   => 'bg-danger-subtle text-danger border-danger',
                    'handover'   => 'bg-info-subtle text-info border-info',
                ];
            @endphp
            <span class="badge rounded-pill border {{ $statusColors[$labLoan->status] ?? 'bg-secondary-subtle text-secondary border-secondary' }} px-4 py-2 fs-6">
                {{ ucfirst($labLoan->status) }}
            </span>
        </div>
    </div>

    <div class="row g-4">
        <!-- Info Peminjam -->
        <div class="col-12 col-md-4">
            <div class="card shadow-sm border-0 rounded-4 h-100">
                <div class="card-header bg-success text-white py-3">
                    <h6 class="m-0 fw-bold"><i class="fas fa-user-graduate me-2"></i>Profil Mahasiswa</h6>
                </div>
                <div class="card-body p-4">
                    <div class="mb-3">
                        <label class="small text-muted text-uppercase fw-bold">Nama</label>
                        <p class="fw-bold text-dark fs-5 mb-0">{{ $labLoan->borrower_name }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="small text-muted text-uppercase fw-bold">NIM</label>
                        <p class="fw-bold text-dark mb-0">{{ $labLoan->nim }}</p>
                    </div>
                    <div class="mb-0">
                        <label class="small text-muted text-uppercase fw-bold">Kontak</label>
                        <p class="fw-bold text-dark mb-0">{{ $labLoan->phone ?? '-' }}</p>
                    </div>
                </div>
            </div>

            @if($labLoan->status == 'pending')
            <div class="card shadow-sm border-0 rounded-4 mt-4">
                <div class="card-header bg-success text-white py-3">
                    <h6 class="m-0 fw-bold"><i class="fas fa-check-circle me-2"></i>Aksi Verifikasi</h6>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.loans.approve', $labLoan->id) }}" method="POST" class="mb-3">
                        @csrf
                        <button type="submit" class="btn btn-success w-100 py-2 fw-bold rounded-pill shadow-sm">
                            <i class="fas fa-check me-2"></i> Setujui Peminjaman
                        </button>
                    </form>
                    <form action="{{ route('admin.loans.reject', $labLoan->id) }}" method="POST">
                        @csrf
                        <div class="mb-2">
                            <textarea name="admin_notes" class="form-control shadow-sm" rows="3" placeholder="Alasan penolakan..." required></textarea>
                        </div>
                        <button type="submit" class="btn btn-outline-danger w-100 py-2 fw-bold rounded-pill">
                            <i class="fas fa-times me-2"></i> Tolak
                        </button>
                    </form>
                </div>
            </div>
            @endif
        </div>

        <!-- Daftar Alat -->
        <div class="col-12 col-md-8">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-success text-white py-3">
                    <h6 class="m-0 fw-bold"><i class="fas fa-tools me-2"></i>Daftar Alat yang Dipinjam</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light text-secondary">
                                <tr>
                                    <th class="ps-4">Nama Alat / Bahan</th>
                                    <th class="text-center">Jumlah</th>
                                    <th class="text-center pe-4">Stok Tersedia</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($labLoan->details as $detail)
                                <tr>
                                    <td class="ps-4 fw-bold text-dark">
                                        {{ $detail->inventory?->item_name ?? 'Alat sudah dihapus / tidak ditemukan' }}
                                    </td>

                                    <td class="text-center">
                                        {{ $detail->quantity }}
                                    </td>

                                    <td class="text-center pe-4">
                                        @if($detail->inventory)
                                            <span class="badge bg-success-subtle text-success border border-success px-3 py-2">
                                                {{ $detail->inventory->quantity_available }}
                                            </span>
                                        @else
                                            <span class="badge bg-danger-subtle text-danger border border-danger px-3 py-2">
                                                Tidak tersedia
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
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
@extends('layouts.admin')

@section('title', 'Konfirmasi Barang Kembali')

@section('content')
<div class="container-fluid px-3 px-md-4 pb-5">
    <!-- Header -->
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mt-4 mb-4">
        <div>
            <h1 class="h3 text-gray-800 mb-1 fw-bold">Konfirmasi Barang Kembali</h1>
            <p class="text-muted small mb-0">Terima pengembalian barang dari peminjam dan perbarui stok.</p>
        </div>
        <span class="badge bg-success-subtle text-success border border-success px-3 py-2 rounded-pill">
            <i class="fas fa-undo-alt me-1"></i> {{ $loans->count() }} Menunggu
        </span>
    </div>

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-header bg-success py-3 d-flex align-items-center">
            <i class="fas fa-undo-alt me-2 text-white"></i>
            <h6 class="m-0 font-weight-bold text-white">Daftar Peminjaman Aktif</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light text-secondary">
                        <tr>
                            <th class="ps-4">No. Resi</th>
                            <th>Peminjam</th>
                            <th>Tanggal Pinjam</th>
                            <th class="text-center">Aksi</th>
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
                                <form action="{{ route('admin.return.confirm', $loan->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" onclick="return confirm('Apakah semua barang sudah kembali dalam kondisi baik? Stok akan otomatis bertambah kembali.')" 
                                            class="btn btn-success btn-sm px-4 py-2 rounded-pill fw-bold shadow-sm">
                                        <i class="fas fa-check-circle me-1"></i> Terima Pengembalian
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">
                                <i class="fas fa-box-open fa-2x mb-2 d-block text-success opacity-50"></i>
                                Tidak ada barang yang sedang dipinjam.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
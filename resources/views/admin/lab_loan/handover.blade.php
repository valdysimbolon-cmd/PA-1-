@extends('layouts.admin')

@section('title', 'Konfirmasi Barang Keluar')

@section('content')
<div class="container-fluid px-3 px-md-4 pb-5">
    <!-- Header -->
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mt-4 mb-4">
        <div>
            <h1 class="h3 text-gray-800 mb-1 fw-bold">Konfirmasi Barang Keluar</h1>
            <p class="text-muted small mb-0">Konfirmasi penyerahan barang secara fisik kepada peminjam.</p>
        </div>
        <span class="badge bg-success-subtle text-success border border-success px-3 py-2 rounded-pill">
            <i class="fas fa-clipboard-check me-1"></i> {{ $loans->count() }} Menunggu
        </span>
    </div>

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-header bg-success py-3 d-flex align-items-center">
            <i class="fas fa-handshake me-2 text-white"></i>
            <h6 class="m-0 font-weight-bold text-white">Daftar Peminjaman Siap Diserahkan</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light text-secondary">
                        <tr>
                            <th class="ps-4">No. Resi</th>
                            <th>Peminjam</th>
                            <th>Item yang Dipinjam</th>
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
                            <td>
                                <ul class="list-unstyled small mb-0">
                                    @foreach($loan->details as $d)
                                        <li>
                                            <i class="fas fa-cube text-success me-1"></i>
                                            @if($d->inventory)
                                                {{ $d->inventory->item_name }} ({{ $d->quantity }})
                                            @else
                                                <span class="text-danger fst-italic">
                                                    <i class="fas fa-exclamation-triangle me-1"></i>Item dihapus dari sistem
                                                </span> ({{ $d->quantity }})
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            </td>
                            <td class="text-center">
                                <form action="{{ route('admin.handover.confirm', $loan->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" onclick="return confirm('Apakah fisik barang benar-benar sudah diserahkan ke mahasiswa?')" 
                                            class="btn btn-success btn-sm px-4 py-2 rounded-pill fw-bold shadow-sm">
                                        <i class="fas fa-check-circle me-1"></i> Konfirmasi Penyerahan
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">
                                <i class="fas fa-check-circle fa-2x mb-2 d-block text-success opacity-50"></i>
                                Tidak ada peminjaman yang siap diserahkan.
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
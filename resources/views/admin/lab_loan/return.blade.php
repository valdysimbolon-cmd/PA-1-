@extends('layouts.admin')

@section('title', 'Konfirmasi Barang Kembali')

@section('content')
<div class="container-fluid px-3 px-md-4 pb-5">

    {{-- ── Header ── --}}
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mt-4 mb-4">
        <div>
            <h1 class="h3 text-gray-800 mb-1 fw-bold">Konfirmasi Barang Kembali</h1>
            <p class="text-muted small mb-0">Terima pengembalian barang dari peminjam dan perbarui stok secara otomatis.</p>
        </div>
        <span class="badge px-3 py-2 rounded-pill fw-semibold"
              style="background:#EAF3DE;color:#3B6D11;border:1px solid #b6d99b;font-size:.82rem;">
            <i class="fas fa-undo-alt me-1"></i> {{ $loans->count() }} Menunggu Konfirmasi
        </span>
    </div>

    {{-- ── Info Banner ── --}}
    <div class="alert border-0 rounded-4 mb-4 d-flex align-items-start gap-3 shadow-sm"
         style="background:#E8F4FD;border-left:4px solid #185FA5 !important;">
        <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0 mt-1"
             style="width:36px;height:36px;background:#CFE2FF;">
            <i class="fas fa-info-circle" style="color:#185FA5;font-size:15px;"></i>
        </div>
        <div>
            <div class="fw-bold mb-1" style="color:#185FA5;font-size:.88rem;">Panduan Konfirmasi Pengembalian</div>
            <div class="text-muted small">
                Pastikan semua barang telah dikembalikan dalam kondisi baik dan jumlahnya sesuai sebelum menekan tombol konfirmasi.
                Stok inventaris akan <strong>otomatis bertambah</strong> setelah konfirmasi dilakukan.
            </div>
        </div>
    </div>

    {{-- ── Tabel ── --}}
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-header bg-success py-3 px-4 d-flex align-items-center justify-content-between rounded-top-4">
            <div class="d-flex align-items-center gap-2">
                <i class="fas fa-undo-alt text-white"></i>
                <h6 class="m-0 fw-bold text-white">Daftar Peminjaman Aktif</h6>
            </div>
            <span class="badge rounded-pill px-3 py-2 fw-bold" style="background:#EAF3DE;color:#3B6D11;">
                {{ $loans->count() }} peminjaman
            </span>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead style="font-size:.78rem;letter-spacing:.05em;">
                        <tr class="table-light text-secondary">
                            <th class="ps-4 py-3 fw-semibold">No. Resi</th>
                            <th class="py-3 fw-semibold">Peminjam</th>
                            <th class="py-3 fw-semibold">Tanggal Pinjam</th>
                            <th class="py-3 fw-semibold">Item yang Dipinjam</th>
                            <th class="py-3 fw-semibold text-center pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($loans as $loan)
                        <tr>
                            {{-- No. Resi --}}
                            <td class="ps-4 py-3">
                                <code class="fw-bold text-success" style="font-size:0.9rem;">{{ $loan->receipt_number }}</code>
                            </td>

                            {{-- Peminjam --}}
                            <td class="py-3">
                                <div class="fw-bold text-dark">{{ $loan->borrower_name }}</div>
                                <div class="text-muted small">{{ $loan->nim ?? '—' }}</div>
                            </td>

                            {{-- Tanggal Pinjam --}}
                            <td class="py-3">
                                <div class="fw-semibold text-dark" style="font-size:.9rem;">
                                    {{ \Carbon\Carbon::parse($loan->planned_borrow_date)->translatedFormat('d F Y') }}
                                </div>
                                @php
                                    $daysDiff = (int) \Carbon\Carbon::parse($loan->planned_borrow_date)->diffInDays(now(), false);
                                @endphp
                                @if($daysDiff > 0)
                                    <div class="small" style="color:#A32D2D;">
                                        <i class="fas fa-exclamation-triangle me-1" style="font-size:.7rem;"></i>
                                        Terlambat {{ $daysDiff }} hari
                                    </div>
                                @else
                                    <div class="text-muted small">Tepat waktu</div>
                                @endif
                            </td>

                            {{-- Item yang Dipinjam --}}
                            <td class="py-3">
                                <ul class="list-unstyled small mb-0">
                                    @foreach($loan->details as $d)
                                        <li class="mb-1 d-flex align-items-center gap-1">
                                            <i class="fas fa-cube text-success" style="font-size:.75rem;"></i>
                                            @if($d->inventory)
                                                <span class="text-dark">{{ $d->inventory->item_name }}</span>
                                                <span class="badge rounded-pill ms-1 px-2"
                                                      style="background:#E8F5E9;color:#2e7d32;font-size:.7rem;">
                                                    ×{{ $d->quantity }}
                                                </span>
                                            @else
                                                <span class="text-danger fst-italic">
                                                    <i class="fas fa-exclamation-triangle me-1" style="font-size:.7rem;"></i>
                                                    Item dihapus
                                                </span>
                                                <span class="badge rounded-pill ms-1 px-2"
                                                      style="background:#FCEBEB;color:#A32D2D;font-size:.7rem;">
                                                    ×{{ $d->quantity }}
                                                </span>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            </td>

                            {{-- Aksi --}}
                            <td class="py-3 text-center pe-4">
                                {{-- Form per baris --}}
                                <form action="{{ route('admin.return.confirm', $loan->id) }}" method="POST" class="return-form" data-receipt="{{ $loan->receipt_number }}" data-borrower="{{ $loan->borrower_name }}">
                                    @csrf
                                    <button type="button"
                                            onclick="confirmReturn(this)"
                                            class="btn btn-sm fw-bold rounded-pill shadow-sm px-3 py-2"
                                            style="background:#28a745;color:#fff;border:none;font-size:.82rem;white-space:nowrap;">
                                        <i class="fas fa-check-circle me-1"></i> Terima Pengembalian
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <div class="d-flex flex-column align-items-center gap-2">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center mb-2"
                                         style="width:64px;height:64px;background:#EAF3DE;">
                                        <i class="fas fa-box-open" style="font-size:26px;color:#3B6D11;opacity:.6;"></i>
                                    </div>
                                    <div class="fw-bold text-dark mb-1">Semua barang sudah kembali</div>
                                    <small class="text-muted">Tidak ada peminjaman yang menunggu konfirmasi pengembalian saat ini.</small>
                                </div>
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
.rounded-top-4 { border-radius: .75rem .75rem 0 0 !important; }
.table tbody tr:hover td { background-color: #f8fffe; }
</style>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function confirmReturn(button) {
    const form = button.closest('form');
    const receipt = form.dataset.receipt;
    const borrower = form.dataset.borrower;

    Swal.fire({
        title: 'Konfirmasi Pengembalian?',
        html: `
            Pastikan semua barang dari peminjaman <strong>${receipt}</strong><br>
            atas nama <strong>${borrower}</strong> sudah kembali dalam kondisi baik.<br><br>
            Stok inventaris akan <strong>otomatis bertambah</strong> setelah konfirmasi dilakukan.
        `,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, terima pengembalian',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Memproses...',
                text: 'Mohon tunggu sebentar.',
                allowOutsideClick: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            form.submit();
        }
    });
}

document.addEventListener('DOMContentLoaded', function () {
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            showConfirmButton: false,
            timer: 3000,
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
});
</script>
@endpush
@endsection
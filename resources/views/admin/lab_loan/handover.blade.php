@extends('layouts.admin')

@section('title', 'Konfirmasi Barang Keluar')

@section('content')
<div class="container-fluid px-3 px-md-4 pb-5">

    {{-- Header --}}
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mt-4 mb-3 flex-wrap">
        <div>
            <h1 class="h4 fw-bold text-dark mb-1">Konfirmasi Barang Keluar</h1>
            <p class="text-muted small mb-0">Konfirmasi penyerahan barang secara fisik kepada peminjam.</p>
        </div>
        <span class="waiting-badge">
            <i class="fas fa-clipboard-check"></i>
            {{ $loans->count() }} menunggu
        </span>
    </div>

    {{-- Main Card --}}
    <div class="card-modern">
        <div class="card-top">
            <i class="fas fa-handshake"></i>
            <span>Daftar peminjaman siap diserahkan</span>
        </div>

        <div class="loan-table-header d-none d-md-grid">
            <div class="th-col">No. resi &amp; peminjam</div>
            <div class="th-col">Item yang dipinjam</div>
            <div class="th-col text-end">Aksi</div>
        </div>

        @forelse($loans as $loan)
        <div class="loan-row" id="row-{{ $loan->id }}">

            <div>
                <span class="resi-code">{{ $loan->receipt_number }}</span>
                <div class="borrower-name">{{ $loan->borrower_name }}</div>
                <div class="borrower-nim">{{ $loan->nim }}</div>
            </div>

            <div class="item-list">
                @foreach($loan->details as $d)
                    @if($d->inventory)
                        <div class="item-chip">
                            <span class="item-dot"></span>
                            {{ $d->inventory->item_name }}
                            <span class="qty-tag">×{{ $d->quantity }}</span>
                        </div>
                    @else
                        <div class="item-deleted">
                            <i class="fas fa-exclamation-triangle"></i>
                            Item dihapus dari sistem
                            <span class="qty-tag">×{{ $d->quantity }}</span>
                        </div>
                    @endif
                @endforeach
            </div>

            <div class="action-group">
                {{-- Tombol Konfirmasi --}}
                <button type="button" class="btn-confirm"
                    onclick="openConfirm(
                        '{{ $loan->receipt_number }}',
                        '{{ addslashes($loan->borrower_name) }}',
                        '{{ route('admin.handover.confirm', $loan->id) }}'
                    )">
                    <i class="fas fa-check"></i> Konfirmasi penyerahan
                </button>

                {{-- Tombol Hapus --}}
                <button type="button" class="btn-delete"
                    onclick="openDelete(
                        '{{ $loan->receipt_number }}',
                        '{{ addslashes($loan->borrower_name) }}',
                        '{{ route('admin.loans.destroy', $loan->id) }}'
                    )">
                    <i class="fas fa-trash-alt"></i> Hapus
                </button>
            </div>

        </div>
        @empty
        <div class="empty-state">
            <div class="empty-icon"><i class="fas fa-check-circle"></i></div>
            <p class="empty-text">Tidak ada peminjaman yang siap diserahkan.</p>
        </div>
        @endforelse
    </div>
</div>

{{-- Hidden forms untuk submit via JS --}}
<form id="formConfirm" method="POST" style="display:none;">@csrf</form>
<form id="formDelete" method="POST" style="display:none;">@csrf @method('DELETE')</form>

<style>
/* ── Waiting Badge ── */
.waiting-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: #E1F5EE;
    color: #085041;
    border: 1px solid #5DCAA5;
    border-radius: 50px;
    padding: 6px 14px;
    font-size: 0.75rem;
    font-weight: 600;
}

/* ── Main Card ── */
.card-modern {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 14px;
    overflow: hidden;
}
.card-top {
    background: #1D9E75;
    padding: 14px 20px;
    display: flex;
    align-items: center;
    gap: 10px;
    color: #fff;
    font-size: 0.875rem;
    font-weight: 600;
}

/* ── Table Header ── */
.loan-table-header {
    display: grid;
    grid-template-columns: 190px 1fr auto;
    gap: 16px;
    padding: 10px 20px;
    background: #f9fafb;
    border-bottom: 1px solid #e5e7eb;
}
.th-col {
    font-size: 0.68rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.07em;
    color: #6b7280;
}

/* ── Loan Row ── */
.loan-row {
    display: grid;
    grid-template-columns: 190px 1fr auto;
    gap: 16px;
    align-items: start;
    padding: 16px 20px;
    border-bottom: 1px solid #e5e7eb;
    transition: background 0.15s, opacity 0.3s;
}
.loan-row:last-child { border-bottom: none; }
.loan-row:hover { background: #f9fafb; }

/* ── Resi & Borrower ── */
.resi-code {
    font-family: monospace;
    font-size: 0.78rem;
    font-weight: 700;
    color: #0F6E56;
    background: #E1F5EE;
    border: 1px solid #9FE1CB;
    border-radius: 6px;
    padding: 2px 8px;
    display: inline-block;
    margin-bottom: 5px;
}
.borrower-name { font-size: 0.875rem; font-weight: 600; color: #111827; }
.borrower-nim  { font-size: 0.75rem;  color: #6b7280; margin-top: 2px; }

/* ── Items ── */
.item-list    { display: flex; flex-direction: column; gap: 5px; padding-top: 2px; }
.item-chip    { display: inline-flex; align-items: center; gap: 7px; font-size: 0.82rem; color: #374151; }
.item-dot     { width: 6px; height: 6px; background: #1D9E75; border-radius: 50%; flex-shrink: 0; }
.item-deleted { display: inline-flex; align-items: center; gap: 6px; font-size: 0.82rem; color: #dc2626; font-style: italic; }
.qty-tag      { font-size: 0.7rem; background: #f3f4f6; border: 1px solid #e5e7eb; border-radius: 4px; padding: 1px 6px; color: #6b7280; font-style: normal; }

/* ── Action Buttons ── */
.action-group { display: flex; flex-direction: column; gap: 6px; align-items: flex-end; }
.btn-confirm {
    display: inline-flex; align-items: center; gap: 6px;
    background: #1D9E75; color: #fff; border: none;
    border-radius: 8px; padding: 8px 14px;
    font-size: 0.78rem; font-weight: 600;
    cursor: pointer; white-space: nowrap;
    transition: background 0.15s;
}
.btn-confirm:hover { background: #0F6E56; }
.btn-delete {
    display: inline-flex; align-items: center; gap: 6px;
    background: transparent; color: #A32D2D;
    border: 1px solid #F09595; border-radius: 8px;
    padding: 7px 14px; font-size: 0.78rem; font-weight: 600;
    cursor: pointer; white-space: nowrap;
    transition: all 0.15s;
}
.btn-delete:hover { background: #FCEBEB; border-color: #E24B4A; }

/* ── Empty State ── */
.empty-state { padding: 52px 20px; text-align: center; }
.empty-icon  { font-size: 2rem; color: #9FE1CB; margin-bottom: 10px; }
.empty-text  { font-size: 0.875rem; color: #6b7280; }

/* ── Responsive ── */
@media (max-width: 767px) {
    .loan-row { grid-template-columns: 1fr; }
    .action-group { align-items: flex-start; flex-direction: row; flex-wrap: wrap; }
}
</style>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function openConfirm(resi, name, url) {
    Swal.fire({
        title: 'Konfirmasi penyerahan barang?',
        html: `Pastikan barang telah diserahkan secara fisik kepada <strong>${name}</strong> (Resi: ${resi}).`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#1D9E75',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, sudah diserahkan',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            // Submit form konfirmasi
            const form = document.getElementById('formConfirm');
            form.action = url;
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

function openDelete(resi, name, url) {
    Swal.fire({
        title: 'Hapus data peminjaman?',
        html: `Data peminjaman <strong>${name}</strong> (Resi: ${resi}) akan dihapus permanen dan tidak bisa dikembalikan.`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, hapus sekarang',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.getElementById('formDelete');
            form.action = url;
            Swal.fire({
                title: 'Menghapus...',
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

// Notifikasi success / error dari session
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
@extends('layouts.admin')

@section('title', 'Detail Transaksi Peminjaman')

@section('content')
<div class="container-fluid px-3 px-md-4 pb-5">

    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb" class="mt-4">
        <ol class="breadcrumb mb-2">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.loans.index') }}" class="text-success text-decoration-none">Transaksi</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Detail Resi {{ $labLoan->receipt_number }}</li>
        </ol>
    </nav>

    {{-- Header --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
        <div>
            <h1 class="h4 fw-bold text-dark mb-1">Detail Peminjaman</h1>
            <p class="text-muted small mb-0">
                ID Transaksi: <span class="badge-id">#{{ $labLoan->id }}</span>
            </p>
        </div>
        <div class="d-flex align-items-center gap-2 flex-wrap">
            <button onclick="window.print()" class="btn btn-sm btn-outline-secondary rounded-3 d-none d-sm-flex align-items-center gap-2 px-3">
                <i class="fas fa-print"></i> Cetak Resi
            </button>
            @php
                $statusMap = [
                    'pending'  => ['cls' => 'status-pending',  'icon' => 'fa-clock'],
                    'approved' => ['cls' => 'status-approved', 'icon' => 'fa-check-circle'],
                    'handover' => ['cls' => 'status-handover', 'icon' => 'fa-handshake'],
                    'returned' => ['cls' => 'status-returned', 'icon' => 'fa-undo-alt'],
                    'rejected' => ['cls' => 'status-rejected', 'icon' => 'fa-times-circle'],
                ];
                $curr = $statusMap[$labLoan->status] ?? ['cls' => 'status-default', 'icon' => 'fa-info-circle'];
            @endphp
            <span class="status-badge {{ $curr['cls'] }}">
                <i class="fas {{ $curr['icon'] }}"></i>
                {{ strtoupper($labLoan->status) }}
            </span>
        </div>
    </div>

    <div class="row g-4">

        {{-- ===================== KOLOM KIRI ===================== --}}
        <div class="col-12 col-lg-8">

            {{-- Card: Item Peminjaman --}}
            <div class="card-modern mb-4">
                <div class="card-modern-header">
                    <span class="card-modern-title">
                        <i class="fas fa-boxes text-success"></i> Item Peminjaman
                    </span>
                    <span class="text-muted small">{{ $labLoan->details->count() }} item terdaftar</span>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4 col-label">Informasi Alat</th>
                                <th class="text-center col-label">Jumlah</th>
                                <th class="text-center col-label">Stok Lab</th>
                                <th class="text-center pe-4 col-label">Kesiapan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($labLoan->details as $detail)
                            <tr>
                                <td class="ps-4 py-3">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="item-icon">
                                            <i class="fas fa-tools"></i>
                                        </div>
                                        <div>
                                            <div class="fw-bold text-dark mb-0" style="font-size:0.9rem;">
                                                {{ $detail->inventory?->item_name ?? 'N/A' }}
                                            </div>
                                            <div class="text-muted" style="font-size:0.75rem;">
                                                Kode: {{ $detail->inventory?->item_code ?? '-' }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center fw-bold text-dark" style="font-size:0.9rem;">
                                    {{ $detail->quantity }} Unit
                                </td>
                                <td class="text-center text-muted" style="font-size:0.85rem;">
                                    {{ $detail->inventory?->quantity_available ?? 0 }} tersedia
                                </td>
                                <td class="text-center pe-4">
                                    @if($detail->inventory && $detail->inventory->quantity_available >= $detail->quantity)
                                        <i class="fas fa-check-circle text-success fs-6" title="Stok Mencukupi"></i>
                                    @else
                                        <i class="fas fa-exclamation-triangle text-danger fs-6" title="Stok Kurang"></i>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Card: Tujuan Peminjaman --}}
            <div class="card-modern">
                <div class="card-modern-body p-4">
                    <h6 class="fw-bold text-dark mb-3 d-flex align-items-center gap-2">
                        <i class="fas fa-comment-dots text-success"></i> Tujuan Peminjaman
                    </h6>
                    <div class="purpose-box">
                        <p class="mb-0 text-secondary fst-italic" style="line-height:1.65;">
                            "{{ $labLoan->purpose ?? 'Tidak ada deskripsi tujuan peminjaman.' }}"
                        </p>
                    </div>
                </div>
            </div>

        </div>

        {{-- ===================== KOLOM KANAN ===================== --}}
        <div class="col-12 col-lg-4">

            {{-- Card: Profil Peminjam --}}
            <div class="card-modern mb-4">
                <div class="card-modern-body p-4">

                    {{-- Avatar & Identitas --}}
                    <div class="text-center mb-4">
                        <div class="borrower-avatar mx-auto mb-3">
                            {{ strtoupper(substr($labLoan->borrower_name, 0, 1)) }}
                        </div>
                        <h5 class="fw-bold text-dark mb-1" style="font-size:1rem;">
                            {{ $labLoan->borrower_name }}
                        </h5>
                        <p class="text-muted small mb-0">{{ $labLoan->nim }}</p>
                    </div>

                    {{-- Timeline Jadwal --}}
                    <span class="section-label">Jadwal Penggunaan</span>
                    <div class="timeline-box">
                        <div class="tl-item pb-3">
                            <div class="tl-line">
                                <span class="tl-dot dot-green"></span>
                                <span class="tl-connector"></span>
                            </div>
                            <div class="tl-info">
                                <small class="text-muted d-block">Tanggal Pinjam</small>
                                <span class="fw-bold small text-dark">
                                    {{ \Carbon\Carbon::parse($labLoan->planned_borrow_date)->translatedFormat('d M Y') }}
                                </span>
                            </div>
                        </div>
                        <div class="tl-item">
                            <div class="tl-line">
                                <span class="tl-dot dot-red"></span>
                            </div>
                            <div class="tl-info">
                                <small class="text-muted d-block">Estimasi Kembali</small>
                                <span class="fw-bold small text-dark">
                                    {{ $labLoan->planned_return_date
                                        ? \Carbon\Carbon::parse($labLoan->planned_return_date)->translatedFormat('d M Y')
                                        : '-' }}
                                </span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            {{-- Card: Verifikasi (hanya jika pending) --}}
            @if($labLoan->status === 'pending')
            <div class="verify-card mb-4">
                <form action="{{ route('admin.loans.approve', $labLoan->id) }}" method="POST" class="mb-2">
                    @csrf
                    <button type="submit" class="btn btn-success w-100 fw-bold py-2 rounded-3">
                        <i class="fas fa-check me-2"></i>Setujui Pengajuan
                    </button>
                </form>

                <button type="button"
                    class="btn btn-link text-danger-emphasis text-decoration-none w-100 small fw-bold mt-1"
                    data-bs-toggle="collapse"
                    data-bs-target="#collapseReject">
                    Tolak Pengajuan?
                </button>

                <div class="collapse mt-2" id="collapseReject">
                    <form action="{{ route('admin.loans.reject', $labLoan->id) }}" method="POST"
                        class="bg-white rounded-3 p-3">
                        @csrf
                        <textarea name="admin_notes"
                            class="form-control form-control-sm mb-2 text-dark"
                            rows="3"
                            placeholder="Alasan penolakan..."
                            required></textarea>
                        <button type="submit" class="btn btn-danger w-100 btn-sm fw-bold">
                            Konfirmasi Tolak
                        </button>
                    </form>
                </div>
            </div>
            @endif

            {{-- Catatan Penolakan --}}
            @if($labLoan->admin_notes)
            <div class="rejection-note">
                <span class="rejection-label">Catatan Penolakan</span>
                <p class="small mb-0 text-dark fst-italic mt-1">{{ $labLoan->admin_notes }}</p>
            </div>
            @endif

        </div>
    </div>
</div>

<style>
/* ── Badge ID ── */
.badge-id {
    background: #f3f4f6;
    border: 1px solid #e5e7eb;
    border-radius: 6px;
    padding: 2px 8px;
    font-size: 0.75rem;
    color: #374151;
}

/* ── Status Badges ── */
.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 14px;
    border-radius: 50px;
    font-size: 0.72rem;
    font-weight: 700;
    letter-spacing: 0.05em;
    border: 1px solid;
}
.status-pending  { background: #fff3e0; color: #7c4a00; border-color: #f59e0b; }
.status-approved { background: #e3f2fd; color: #0c3a6e; border-color: #3b82f6; }
.status-handover { background: #e0f7fa; color: #005f6b; border-color: #06b6d4; }
.status-returned { background: #e8f5e9; color: #1b4d2e; border-color: #22c55e; }
.status-rejected { background: #ffebee; color: #7f1d1d; border-color: #ef4444; }
.status-default  { background: #f3f4f6; color: #374151; border-color: #9ca3af; }

/* ── Card Modern ── */
.card-modern {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 14px;
    overflow: hidden;
}
.card-modern-header {
    padding: 14px 20px;
    border-bottom: 1px solid #e5e7eb;
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: #fff;
}
.card-modern-title {
    font-size: 0.875rem;
    font-weight: 700;
    color: #111;
    display: flex;
    align-items: center;
    gap: 8px;
}
.card-modern-body { background: #fff; }

/* ── Table ── */
.col-label {
    font-size: 0.68rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.07em;
    color: #6b7280;
    padding-top: 10px;
    padding-bottom: 10px;
}
.item-icon {
    width: 38px;
    height: 38px;
    background: #e8f5e9;
    border-radius: 9px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #1D9E75;
    font-size: 0.95rem;
    flex-shrink: 0;
}

/* ── Purpose Box ── */
.purpose-box {
    background: #f9fafb;
    border-left: 3px solid #1D9E75;
    border-radius: 0 8px 8px 0;
    padding: 12px 16px;
}

/* ── Borrower Avatar ── */
.borrower-avatar {
    width: 54px;
    height: 54px;
    background: #1D9E75;
    color: #fff;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.4rem;
    font-weight: 600;
}

/* ── Section Label ── */
.section-label {
    display: block;
    font-size: 0.68rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.07em;
    color: #6b7280;
    margin-bottom: 10px;
}

/* ── Timeline ── */
.timeline-box {
    background: #f9fafb;
    border: 1px solid #e5e7eb;
    border-radius: 10px;
    padding: 14px 16px;
}
.tl-item {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    position: relative;
}
.tl-line {
    display: flex;
    flex-direction: column;
    align-items: center;
}
.tl-dot {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    flex-shrink: 0;
    margin-top: 3px;
}
.dot-green { background: #1D9E75; }
.dot-red   { background: #ef4444; }
.tl-connector {
    width: 1.5px;
    background: #d1d5db;
    flex: 1;
    min-height: 18px;
    margin: 3px 0;
}
.tl-info small { font-size: 0.72rem; }
.tl-info span  { font-size: 0.82rem; }

/* ── Verify Card ── */
.verify-card {
    background: #2c2c2a;
    border-radius: 14px;
    padding: 20px;
}

/* ── Rejection Note ── */
.rejection-note {
    background: #ffebee;
    border-left: 3px solid #ef4444;
    border-radius: 0 10px 10px 0;
    padding: 12px 14px;
}
.rejection-label {
    display: block;
    font-size: 0.68rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.07em;
    color: #9b1c1c;
    margin-bottom: 4px;
}

/* ── Print ── */
@media print {
    .btn, nav, .status-badge, .verify-card { display: none !important; }
    .card-modern { border: 1px solid #ddd !important; box-shadow: none !important; }
}
</style>
@endsection
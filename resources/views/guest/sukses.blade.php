@extends('layouts.guest_layout')

@section('title', 'Pengajuan Berhasil - MyBioproses')

@push('styles')
<style>
:root {
    --forest:       #1A4D2E;
    --forest-deep:  #0a1f13;
    --forest-mid:   #2E7D52;
    --accent:       #1D9E75;
    --accent-light: #E6F5EC;
    --accent-xlight:#f0faf5;
    --cream:        #f9fbf9;
    --ink:          #111827;
    --muted:        #6b7280;
    --border:       #dce8e1;
    --white:        #ffffff;
    --shadow-md:    0 8px 24px rgba(26,77,46,.12);
}

/* === BANNER HEADER (STYLE DOSEN & STAF) === */
.ph-wrap {
    position: relative;
    padding: 7rem 0 8rem;
    background: var(--forest-deep);
    overflow: hidden;
}
.ph-inner { position: relative; z-index: 5; text-align: center; }
.ph-eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 0.75rem;
    font-size: 0.75rem;
    font-weight: 700;
    color: var(--accent);
    margin-bottom: 1.2rem;
}
.ph-eyebrow::before, .ph-eyebrow::after {
    content: '';
    width: 25px;
    height: 2px;
    background: var(--accent);
    display: block;
}
.ph-title {
    font-family: 'Playfair Display', serif;
    font-size: clamp(2rem, 5vw, 3rem);
    font-weight: 800;
    color: #fff;
    line-height: 1.1;
    margin-bottom: 1rem;
}
.ph-title em { font-style: italic; color: var(--accent); }
.ph-sub { font-size: 0.95rem; color: rgba(255, 255, 255, 0.6); margin: 0 auto; max-width: 600px; }

/* SVG Wave Organic */
.ph-wave {
    position: absolute;
    bottom: -1px;
    left: 0;
    width: 100%;
    line-height: 0;
}
.ph-wave svg {
    width: 100%;
    height: 100px;
}

/* === SUCCESS BODY === */
.success-body { background: white; padding: 0 0 6rem; min-height: 60vh; }

.success-card {
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: 2rem;
    padding: 3rem 2.5rem;
    box-shadow: var(--shadow-md);
    max-width: 720px;
    margin: -4rem auto 0; /* Mengangkat kartu ke atas banner */
    position: relative;
    z-index: 10;
}

/* Success Icon Animation */
.success-icon {
    width: 80px; height: 80px;
    background: var(--accent-xlight);
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 1.5rem;
}
.success-icon i { font-size: 3rem; color: var(--accent); }

/* Resi Box */
.resi-box {
    background: var(--accent-xlight);
    border: 2px dashed var(--accent);
    border-radius: 1.2rem;
    padding: 1.5rem;
    margin: 2rem 0;
    text-align: center;
}
.resi-label {
    font-size: 0.7rem; font-weight: 800;
    text-transform: uppercase; letter-spacing: 0.1em;
    color: var(--forest-mid); margin-bottom: 0.5rem;
}
.resi-number {
    font-family: 'Courier New', monospace;
    font-size: 2.2rem; font-weight: 900;
    color: var(--forest); letter-spacing: 0.05em;
}

/* Summary Grid */
.summary-grid {
    display: grid; grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
    padding: 1.5rem 0;
    border-top: 1px solid #f0f5f2;
}
.summary-item .label {
    font-size: 0.65rem; text-transform: uppercase;
    font-weight: 700; color: var(--muted);
    display: block; margin-bottom: 0.2rem;
}
.summary-item .value { font-weight: 700; color: var(--forest-deep); font-size: 0.95rem; }

/* Item Tags */
.item-tag {
    display: inline-flex; align-items: center; gap: 0.5rem;
    background: #f4f8f6; border: 1px solid #e2eee7;
    border-radius: 50px; padding: 0.4rem 1rem;
    font-size: 0.8rem; font-weight: 600; color: var(--forest);
    margin: 0.25rem;
}

/* Actions */
.success-actions { display: flex; gap: 1rem; justify-content: center; margin-top: 2.5rem; }
.btn-custom {
    padding: 0.8rem 2rem; border-radius: 50px;
    font-size: 0.9rem; font-weight: 700;
    text-decoration: none; transition: 0.3s;
    display: inline-flex; align-items: center; gap: 0.5rem;
}
.btn-primary-custom { background: var(--forest); color: white; border: none; }
.btn-primary-custom:hover { background: var(--accent); transform: translateY(-3px); color: white; }
.btn-outline-custom { background: white; color: var(--forest); border: 1px solid var(--forest); }
.btn-outline-custom:hover { background: var(--accent-xlight); }

@media (max-width: 768px) {
    .summary-grid { grid-template-columns: 1fr; }
    .success-card { margin-top: -2rem; padding: 2rem 1.5rem; border-radius: 1.5rem; }
    .success-actions { flex-direction: column; }
    .resi-number { font-size: 1.8rem; }
}

@media print {
    .ph-wrap, .success-actions { display: none !important; }
    .success-card { margin: 0 !important; border: 1px solid #eee !important; box-shadow: none !important; }
}
</style>
@endpush

@section('content')

{{-- === BANNER HEADER (STYLE DOSEN & STAF) === --}}
<div class="ph-wrap">
    <div class="container">
        <div class="ph-inner">
            <div class="ph-eyebrow">Layanan MyBioproses</div>
            <h1 class="ph-title">Pengajuan <em>Berhasil</em></h1>
            <p class="ph-sub">Permohonan peminjaman Anda telah berhasil tercatat. Tim laboratorium akan segera melakukan verifikasi data Anda.</p>
        </div>
    </div>
    <div class="ph-wave">
        <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0 120H1440V40C1440 40 1080 120 720 120C360 120 0 40 0 40V120Z" fill="white"/>
        </svg>
    </div>
</div>

<div class="success-body">
    <div class="container">
        <div class="success-card">
            <div class="success-icon">
                <i class="bi bi-patch-check-fill"></i>
            </div>
            
            <div class="text-center">
                <h2 class="fw-bold" style="color: var(--forest); font-family: 'Playfair Display', serif;">Data Peminjaman Diterima</h2>
                <p class="text-muted small">Silakan simpan nomor resi berikut untuk ditunjukkan kepada laboran saat pengambilan alat.</p>
            </div>

            {{-- Nomor Resi --}}
            <div class="resi-box">
                <div class="resi-label">Nomor Resi Peminjaman</div>
                <div class="resi-number text-uppercase">{{ $loan->receipt_number }}</div>
                <div class="small text-muted mt-2">
                    <i class="bi bi-info-circle me-1"></i> Gunakan nomor ini untuk cek status berkala.
                </div>
            </div>

            {{-- Ringkasan Detail --}}
            <div class="summary-grid">
                <div class="summary-item">
                    <span class="label">Nama Peminjam</span>
                    <span class="value">{{ $loan->borrower_name }}</span>
                </div>
                <div class="summary-item">
                    <span class="label">NIM Mahasiswa</span>
                    <span class="value font-monospace">{{ $loan->nim }}</span>
                </div>
                <div class="summary-item">
                    <span class="label">Laboratorium</span>
                    <span class="value">{{ $loan->lab->name ?? '—' }}</span>
                </div>
                <div class="summary-item">
                    <span class="label">Estimasi Waktu</span>
                    <span class="value">
                        {{ \Carbon\Carbon::parse($loan->planned_borrow_date)->format('d M') }} - 
                        {{ \Carbon\Carbon::parse($loan->planned_return_date)->format('d M Y') }}
                    </span>
                </div>
            </div>

            {{-- Daftar Item --}}
            <div class="mt-2">
                <div class="small fw-bold text-muted mb-3 text-uppercase" style="letter-spacing: 1px; font-size: 0.65rem;">Daftar Alat & Bahan:</div>
                <div class="d-flex flex-wrap">
                    @foreach($loan->details as $d)
                    <div class="item-tag">
                        <i class="bi bi-box-seam"></i>
                        {{ $d->inventory->item_name }} 
                        <span class="text-accent fw-bold ms-1">({{ $d->quantity }})</span>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Tombol Aksi --}}
            <div class="success-actions">
                <a href="{{ route('laboratorium.pinjam') }}" class="btn-custom btn-outline-custom">
                    <i class="bi bi-plus-circle"></i> Pinjam Lagi
                </a>
                <a href="#" onclick="window.print();return false;" class="btn-custom btn-primary-custom">
                    <i class="bi bi-printer"></i> Cetak Bukti Resi
                </a>
            </div>

        </div>
    </div>
</div>
@endsection
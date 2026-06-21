@extends('layouts.guest_layout')

@section('title', 'Pengajuan Berhasil - MyBioproses')

@push('styles')
<style>
:root {
    --forest:       #1A4D2E;
    --forest-deep:  #0f2e1b;
    --forest-mid:   #2E7D52;
    --accent:       #1D9E75;
    --accent-light: #E6F5EC;
    --accent-xlight:#f0faf5;
    --cream:        #F4F8F5;
    --ink:          #111827;
    --muted:        #6b7280;
    --border:       #dce8e1;
    --white:        #ffffff;
    --shadow-sm:    0 2px 8px rgba(26,77,46,.09);
    --shadow-md:    0 8px 24px rgba(26,77,46,.12);
}

.success-header {
    background: linear-gradient(135deg, var(--forest) 0%, var(--forest-mid) 100%);
    padding: 4rem 0 0;
    position: relative; overflow: hidden;
}
.success-header-inner {
    position: relative; z-index: 2;
    padding-bottom: 3rem; text-align: center;
}
.success-header h1 {
    font-family: 'Playfair Display', serif;
    font-size: clamp(1.8rem, 3.5vw, 2.6rem);
    font-weight: 900; color: #fff; margin: 0 0 .3rem;
}
.success-header p { font-size: .9rem; color: rgba(255,255,255,.7); margin: 0; }
.success-wave { position: relative; height: 60px; overflow: hidden; margin-top: -1px; }
.success-wave svg { position: absolute; bottom:0; left:0; width:100%; height:100%; }

.success-body { background: var(--cream); padding: 3rem 0 5rem; }

.success-card {
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: 1.5rem;
    padding: 2.5rem 2rem;
    box-shadow: var(--shadow-md);
    max-width: 680px;
    margin: 0 auto;
}

/* Icon */
.success-icon {
    width: 76px; height: 76px;
    background: var(--accent-xlight);
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 1.25rem;
}
.success-icon i { font-size: 2.6rem; color: var(--accent); }

.success-title {
    font-family: 'Playfair Display', serif;
    font-size: 1.7rem; font-weight: 800;
    color: var(--forest); margin-bottom: .4rem;
    text-align: center;
}
.success-sub { color: var(--muted); font-size: .9rem; text-align: center; margin-bottom: 1.75rem; }

/* Resi */
.resi-box {
    background: var(--cream);
    border: 2px dashed var(--border);
    border-radius: 1rem;
    padding: 1.4rem 1.5rem;
    margin-bottom: 1.75rem;
    text-align: center;
}
.resi-label {
    font-size: .63rem; font-weight: 700;
    text-transform: uppercase; letter-spacing: .1em;
    color: var(--muted); margin-bottom: .3rem;
}
.resi-number {
    font-family: 'Courier New', monospace;
    font-size: 2rem; font-weight: 800;
    color: var(--forest); letter-spacing: .06em;
}
.resi-hint { font-size: .7rem; color: var(--muted); margin-top: .35rem; }

/* Summary grid */
.summary-grid {
    display: grid; grid-template-columns: 1fr 1fr;
    gap: .6rem 2rem;
    padding: 1.2rem 0;
    border-top: 1px solid var(--border);
    border-bottom: 1px solid var(--border);
    margin-bottom: 1.5rem;
}
.summary-item { display: flex; flex-direction: column; }
.summary-item .label {
    font-size: .65rem; text-transform: uppercase;
    letter-spacing: .05em; color: var(--muted);
    font-weight: 600;
}
.summary-item .value { font-weight: 700; color: var(--ink); font-size: .9rem; }

/* Items list */
.items-list { margin-bottom: 1.75rem; }
.items-list-title {
    font-size: .65rem; font-weight: 700;
    text-transform: uppercase; letter-spacing: .06em;
    color: var(--muted); margin-bottom: .6rem;
}
.item-chip {
    display: inline-flex; align-items: center; gap: .4rem;
    background: var(--accent-xlight); border: 1px solid var(--border);
    border-radius: 50px; padding: .3rem .9rem;
    font-size: .78rem; font-weight: 600; color: var(--forest);
    margin: .25rem;
}
.item-chip i { color: var(--accent); font-size: .75rem; }

/* Buttons */
.success-actions { display: flex; flex-wrap: wrap; gap: .65rem; justify-content: center; }
.btn-action {
    display: inline-flex; align-items: center; gap: .45rem;
    padding: .65rem 1.6rem; border-radius: 50px;
    font-size: .82rem; font-weight: 700;
    text-decoration: none; transition: all .2s;
}
.btn-action-primary { background: var(--forest); color: white; border: none; }
.btn-action-primary:hover { background: var(--forest-mid); transform: translateY(-2px); box-shadow: var(--shadow-sm); color: white; }
.btn-action-secondary { background: var(--white); color: var(--ink); border: 1px solid var(--border); }
.btn-action-secondary:hover { background: var(--cream); color: var(--ink); }

@media (max-width: 576px) {
    .success-card { padding: 1.75rem 1.1rem; }
    .summary-grid { grid-template-columns: 1fr; }
    .resi-number { font-size: 1.5rem; }
    .success-actions { flex-direction: column; align-items: stretch; }
    .btn-action { justify-content: center; }
}

@media print {
    .success-header, .success-actions, .success-wave { display: none !important; }
    .success-body { padding: 0 !important; background: white !important; }
    .success-card { box-shadow: none !important; border: 1px solid #ddd !important; max-width: 100% !important; }
}
</style>
@endpush

@section('content')

<div class="success-header">
    <div class="container success-header-inner">
        <h1>Pengajuan Berhasil!</h1>
        <p>Permohonan peminjaman Anda telah tercatat di sistem MyBioproses</p>
    </div>
    <div class="success-wave">
        <svg viewBox="0 0 1440 70" preserveAspectRatio="none" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0,40 C360,80 1080,0 1440,40 L1440,70 L0,70 Z" fill="var(--cream)"/>
        </svg>
    </div>
</div>

<div class="success-body">
    <div class="container">
        <div class="success-card">

            <div class="success-icon"><i class="bi bi-check-lg"></i></div>
            <h2 class="success-title">Pengajuan Diterima</h2>
            <p class="success-sub">Permintaan sedang dalam proses validasi oleh admin laboratorium. Simpan nomor resi di bawah ini.</p>

            {{-- Nomor Resi --}}
            <div class="resi-box">
                <div class="resi-label">Nomor Resi Peminjaman</div>
                <div class="resi-number">{{ $loan->receipt_number }}</div>
                <div class="resi-hint">
                    <i class="bi bi-info-circle me-1"></i>
                    Tunjukkan nomor ini saat pengambilan alat di laboratorium
                </div>
            </div>

            {{-- Ringkasan --}}
            <div class="summary-grid">
                <div class="summary-item">
                    <span class="label">Nama Peminjam</span>
                    <span class="value">{{ $loan->borrower_name }}</span>
                </div>
                <div class="summary-item">
                    <span class="label">NIM</span>
                    <span class="value font-monospace">{{ $loan->nim }}</span>
                </div>
                <div class="summary-item">
                    <span class="label">Laboratorium</span>
                    <span class="value">{{ $loan->lab->name ?? '—' }}</span>
                </div>
                <div class="summary-item">
                    <span class="label">Tanggal Pinjam</span>
                    <span class="value">{{ \Carbon\Carbon::parse($loan->planned_borrow_date)->format('d M Y') }}</span>
                </div>
                <div class="summary-item">
                    <span class="label">Tanggal Kembali</span>
                    <span class="value">{{ \Carbon\Carbon::parse($loan->planned_return_date)->format('d M Y') }}</span>
                </div>
                <div class="summary-item">
                    <span class="label">Status</span>
                    <span class="value" style="color:var(--accent);">
                        <i class="bi bi-hourglass-split me-1"></i> Menunggu Persetujuan
                    </span>
                </div>
            </div>

            {{-- Item yang dipinjam --}}
            @if($loan->details->count())
            <div class="items-list">
                <div class="items-list-title">Item yang Dipinjam ({{ $loan->details->count() }})</div>
                @foreach($loan->details as $d)
                <span class="item-chip">
                    <i class="bi bi-check-circle-fill"></i>
                    {{ $d->inventory->item_name ?? '—' }}
                    <strong style="opacity:.7;">&times; {{ $d->quantity }}</strong>
                </span>
                @endforeach
            </div>
            @endif

            {{-- Actions --}}
            <div class="success-actions">
                <a href="{{ route('laboratorium.pinjam') }}" class="btn-action btn-action-primary">
                    <i class="bi bi-arrow-left"></i> Kembali ke Form
                </a>
                <a href="#" onclick="window.print();return false;" class="btn-action btn-action-secondary">
                    <i class="bi bi-printer"></i> Cetak Bukti
                </a>
            </div>

        </div>
    </div>
</div>
@endsection
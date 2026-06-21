@extends('layouts.guest_layout')

@section('title', 'Status Peminjaman - MyBioproses')

@push('styles')
<style>
:root {
    --forest:       #1A4D2E;
    --forest-mid:   #2E7D52;
    --accent:       #1D9E75;
    --accent-light: #E6F5EC;
    --cream:        #F4F8F5;
    --ink:          #111827;
    --muted:        #6b7280;
    --border:       #dce8e1;
    --white:        #ffffff;
}

/* HEADER */
.history-header {
    background: linear-gradient(135deg, var(--forest) 0%, var(--forest-mid) 100%);
    padding: 4.5rem 0 0;
    position: relative;
    overflow: hidden;
}
.history-header::before {
    content: '';
    position: absolute;
    top: -60px; right: -60px;
    width: 280px; height: 280px;
    border-radius: 50%;
    background: rgba(255,255,255,.04);
}
.history-header-inner {
    position: relative; z-index: 2;
    padding-bottom: 3rem;
}
.history-header h1 {
    font-family: 'Playfair Display', serif;
    font-size: clamp(1.9rem, 3.5vw, 2.6rem);
    font-weight: 900; color: #fff;
    margin: 0 0 .35rem;
}
.history-header h1 em { font-style: italic; color: #6ee7b7; }
.history-header p { font-size: .88rem; color: rgba(255,255,255,.6); margin: 0; }
.history-wave { height: 55px; overflow: hidden; margin-top: -1px; }
.history-wave svg { display: block; width: 100%; height: 100%; }

/* BODY */
.history-body { background: var(--cream); padding: 2.5rem 0 5rem; min-height: 60vh; }

/* SUMMARY BAR */
.summary-bar {
    display: flex; gap: .75rem; flex-wrap: wrap;
    margin-bottom: 1.75rem;
}
.summary-pill {
    display: inline-flex; align-items: center; gap: .45rem;
    background: var(--white); border: 1px solid var(--border);
    border-radius: 50px; padding: .4rem 1rem;
    font-size: .78rem; font-weight: 600; color: var(--ink);
}
.summary-pill .dot {
    width: 8px; height: 8px; border-radius: 50%; flex-shrink: 0;
}
.dot-pending  { background: #f59e0b; }
.dot-approved { background: #10b981; }
.dot-rejected { background: #ef4444; }
.dot-returned { background: #3b82f6; }
.summary-pill .count { font-weight: 800; }

/* STATUS BADGE */
.badge-status {
    display: inline-flex; align-items: center; gap: .3rem;
    font-size: .63rem; font-weight: 800;
    text-transform: uppercase; letter-spacing: .4px;
    padding: .32rem .8rem; border-radius: 50px; white-space: nowrap;
}
.s-pending  { background: #fffbeb; color: #92400e; border: 1px solid #fde68a; }
.s-approved { background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; }
.s-rejected { background: #fef2f2; color: #991b1b; border: 1px solid #fecaca; }
.s-returned { background: #eff6ff; color: #1e40af; border: 1px solid #bfdbfe; }
.s-cancelled { background: #f3f4f6; color: #4b5563; border: 1px solid #d1d5db; }
.s-expired   { background: #1f2937; color: #f9fafb; border: 1px solid #374151; }

/* LOAN CARD */
.loan-card {
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: 1.25rem;
    overflow: hidden;
    margin-bottom: 1.1rem;
    transition: box-shadow .2s, transform .2s;
}
.loan-card:hover {
    box-shadow: 0 8px 24px rgba(26,77,46,.11);
    transform: translateY(-2px);
}

/* Left accent strip by status */
.loan-card.status-pending  { border-left: 4px solid #f59e0b; }
.loan-card.status-approved { border-left: 4px solid #10b981; }
.loan-card.status-rejected { border-left: 4px solid #ef4444; }
.loan-card.status-returned { border-left: 4px solid #3b82f6; }
.loan-card.status-cancelled { border-left: 4px solid #9ca3af; }
.loan-card.status-expired   { border-left: 4px solid #374151; }

.loan-card-head {
    padding: 1.1rem 1.3rem .9rem;
    display: flex; flex-wrap: wrap;
    justify-content: space-between; align-items: flex-start;
    gap: .65rem;
    border-bottom: 1px solid var(--border);
}
.loan-resi {
    font-size: .62rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: .08em; color: var(--muted); margin-bottom: .2rem;
}
.loan-resi span {
    font-family: 'Courier New', monospace;
    color: var(--forest); font-size: .78rem;
}
.loan-title { font-size: .93rem; font-weight: 700; color: var(--ink); margin: 0 0 .25rem; }
.loan-meta  { font-size: .73rem; color: var(--muted); display: flex; flex-wrap: wrap; gap: .6rem; }
.loan-meta span { display: inline-flex; align-items: center; gap: .25rem; }

.loan-card-body { padding: .95rem 1.3rem 1.1rem; }

/* TIMELINE */
.tl-wrap {
    display: flex; align-items: flex-start;
    gap: 0; position: relative; margin-bottom: 1rem;
}
.tl-step {
    flex: 1; display: flex; flex-direction: column;
    align-items: center; position: relative;
}
.tl-step:not(:last-child)::after {
    content: '';
    position: absolute;
    top: 13px; left: calc(50% + 13px);
    right: calc(-50% + 13px);
    height: 2px; background: var(--border);
    z-index: 0;
}
.tl-step.done:not(:last-child)::after  { background: var(--accent); }
.tl-step.active:not(:last-child)::after { background: var(--border); }

.tl-dot {
    width: 26px; height: 26px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: .6rem; z-index: 1; position: relative;
    flex-shrink: 0; color: #fff;
    background: var(--border);
}
.tl-step.done   .tl-dot { background: var(--accent); }
.tl-step.active .tl-dot { background: var(--forest); box-shadow: 0 0 0 4px rgba(29,158,117,.2); }
.tl-step.rej    .tl-dot { background: #ef4444; }
.tl-label {
    font-size: .59rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: .04em; color: var(--muted); margin-top: .35rem; text-align: center;
}
.tl-step.done   .tl-label { color: var(--accent); }
.tl-step.active .tl-label { color: var(--forest); }
.tl-step.rej    .tl-label { color: #ef4444; }

/* ITEMS */
.item-chip {
    display: inline-flex; align-items: center; gap: .28rem;
    background: #f0faf5; border: 1px solid #c6e8d7;
    border-radius: 50px; padding: .18rem .7rem;
    font-size: .73rem; font-weight: 600; color: var(--forest);
    margin: .15rem;
}
.item-chip i { font-size: .62rem; color: var(--accent); }
.item-chip .qty { opacity: .6; font-weight: 700; }

/* ADMIN NOTE */
.admin-note {
    background: #fafafa; border-left: 3px solid var(--border);
    border-radius: 0 .5rem .5rem 0;
    padding: .5rem .75rem; margin-top: .8rem;
    font-size: .77rem; color: var(--muted);
}
.admin-note strong {
    color: var(--ink); font-size: .65rem;
    text-transform: uppercase; letter-spacing: .05em;
    display: block; margin-bottom: .2rem;
}

/* SECTION LABEL */
.sec-label {
    font-size: .61rem; font-weight: 800;
    text-transform: uppercase; letter-spacing: .08em;
    color: var(--muted); margin-bottom: .5rem;
}

/* EMPTY */
.empty-state {
    background: var(--white); border-radius: 1.25rem;
    border: 1.5px dashed var(--border);
    padding: 4rem 2rem; text-align: center;
}
.empty-icon {
    width: 72px; height: 72px; border-radius: 50%;
    background: var(--accent-light);
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 1.25rem; font-size: 2rem; color: var(--accent);
}
.empty-state h5 { font-weight: 700; color: var(--ink); margin-bottom: .4rem; }
.empty-state p  { color: var(--muted); font-size: .88rem; margin-bottom: 1.25rem; }
.btn-pinjam {
    display: inline-flex; align-items: center; gap: .4rem;
    background: var(--forest); color: white;
    padding: .65rem 1.75rem; border-radius: 50px;
    font-size: .85rem; font-weight: 700;
    text-decoration: none; transition: .2s;
}
.btn-pinjam:hover { background: var(--forest-mid); color: white; transform: translateY(-2px); }
</style>
@endpush

@section('content')

{{-- HEADER --}}
<div class="history-header">
    <div class="container history-header-inner">
        <h1>Status <em>Peminjaman</em></h1>
        <p>Pantau semua pengajuan peminjaman alat laboratorium Anda secara real-time.</p>
    </div>
    <div class="history-wave">
        <svg viewBox="0 0 1440 55" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0,35 C360,65 1080,5 1440,35 L1440,55 L0,55 Z" fill="#F4F8F5"/>
        </svg>
    </div>
</div>

{{-- BODY --}}
<div class="history-body">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-9">

                @if($loans->isNotEmpty())
                {{-- Summary Bar --}}
                @php
                    $counts = $loans->groupBy('status')->map->count();
                @endphp
                <div class="summary-bar">
                    <div class="summary-pill">
                        <i class="bi bi-collection-fill" style="color:var(--forest)"></i>
                        Total: <span class="count">{{ $loans->count() }}</span> peminjaman
                    </div>
                    @if(isset($counts['pending']))
                    <div class="summary-pill">
                        <span class="dot dot-pending"></span>
                        <span class="count">{{ $counts['pending'] }}</span> Menunggu
                    </div>
                    @endif
                    @if(isset($counts['approved']))
                    <div class="summary-pill">
                        <span class="dot dot-approved"></span>
                        <span class="count">{{ $counts['approved'] }}</span> Disetujui
                    </div>
                    @endif
                    @if(isset($counts['rejected']))
                    <div class="summary-pill">
                        <span class="dot dot-rejected"></span>
                        <span class="count">{{ $counts['rejected'] }}</span> Ditolak
                    </div>
                    @endif
                    @if(isset($counts['returned']))
                    <div class="summary-pill">
                        <span class="dot dot-returned"></span>
                        <span class="count">{{ $counts['returned'] }}</span> Dikembalikan
                    </div>
                    @endif
                    @if(isset($counts['cancelled']))
                    <div class="summary-pill">
                        <span class="dot" style="background:#9ca3af;"></span>
                        <span class="count">{{ $counts['cancelled'] }}</span> Dibatalkan
                    </div>
                    @endif
                    @if(isset($counts['expired']))
                    <div class="summary-pill">
                        <span class="dot" style="background:#374151;"></span>
                        <span class="count">{{ $counts['expired'] }}</span> Kadaluwarsa
                    </div>
                    @endif
                </div>
                @endif

                {{-- Loan Cards --}}
                @forelse($loans as $loan)
                <div class="loan-card status-{{ $loan->status }}">

                    {{-- Head --}}
                    <div class="loan-card-head">
                        <div>
                            <div class="loan-resi">No. Resi: <span>{{ $loan->receipt_number }}</span></div>
                            <div class="loan-title">{{ $loan->research_title }}</div>
                            <div class="loan-meta">
                                <span>
                                    <i class="bi bi-calendar3"></i>
                                    {{ \Carbon\Carbon::parse($loan->planned_borrow_date)->format('d M Y') }}
                                    &rarr;
                                    {{ \Carbon\Carbon::parse($loan->planned_return_date)->format('d M Y') }}
                                </span>
                                <span>
                                    <i class="bi bi-building"></i>
                                    {{ $loan->lab->name ?? 'Lab Umum' }}
                                </span>
                            </div>
                        </div>

                        <div class="d-flex align-items-center gap-2">
                            @php
                                $statusMeta = [
                                    'pending'   => ['s-pending',   'bi-hourglass-split',    'Menunggu Persetujuan'],
                                    'approved'  => ['s-approved',  'bi-check-circle-fill',  'Disetujui'],
                                    'rejected'  => ['s-rejected',  'bi-x-circle-fill',      'Ditolak'],
                                    'returned'  => ['s-returned',  'bi-arrow-return-left',  'Dikembalikan'],
                                    'cancelled' => ['s-cancelled', 'bi-x-circle',           'Dibatalkan'],
                                    'expired'   => ['s-expired',   'bi-clock',              'Kadaluwarsa'],
                                ][$loan->status] ?? ['bg-light text-muted', 'bi-question-circle', $loan->status];
                            @endphp
                            <span class="badge-status {{ $statusMeta[0] }}">
                                <i class="bi {{ $statusMeta[1] }}"></i>
                                {{ $statusMeta[2] }}
                            </span>

                            {{-- Tombol Batalkan (hanya jika status pending/approved dan belum handover) --}}
                        </div>
                    </div>

                    {{-- Body --}}
                    <div class="loan-card-body">
                        <div class="row g-3">

                            {{-- Items --}}
                            <div class="col-md-6">
                                <div class="sec-label">
                                    <i class="bi bi-box-seam me-1"></i>Item Dipinjam
                                </div>
                                @foreach($loan->details as $detail)
                                    @if($detail->inventory)
                                        <span class="item-chip">
                                            <i class="bi bi-check-circle-fill"></i>
                                            {{ $detail->inventory->item_name }}
                                            <span class="qty">&times;{{ $detail->quantity }}</span>
                                        </span>
                                    @else
                                        <span style="font-size:.72rem; color:#dc2626; font-style:italic;">
                                            <i class="bi bi-exclamation-triangle me-1"></i>Item dihapus dari sistem
                                        </span>
                                    @endif
                                @endforeach
                            </div>

                            {{-- Timeline --}}
                            <div class="col-md-6">
                                <div class="sec-label">
                                    <i class="bi bi-activity me-1"></i>Progres Peminjaman
                                </div>
                                @php
                                    $steps = [
                                        ['label' => 'Diajukan',  'done_on' => ['pending','approved','rejected','returned','cancelled','expired']],
                                        ['label' => $loan->status === 'rejected' ? 'Ditolak' : 'Disetujui', 'done_on' => ['approved','returned'], 'rej_on' => ['rejected']],
                                        ['label' => 'Dipinjam',  'done_on' => ['returned']],
                                        ['label' => 'Kembali',   'done_on' => ['returned']],
                                    ];
                                @endphp
                                <div class="tl-wrap">
                                    @foreach($steps as $si => $step)
                                        @php
                                            $isDone   = in_array($loan->status, $step['done_on']);
                                            $isRej    = isset($step['rej_on']) && in_array($loan->status, $step['rej_on']);
                                            $isActive = !$isDone && !$isRej && (
                                                ($si === 1 && $loan->status === 'pending') ||
                                                ($si === 2 && $loan->status === 'approved')
                                            );
                                            $cls = $isRej ? 'rej' : ($isDone ? 'done' : ($isActive ? 'active' : ''));
                                        @endphp
                                        <div class="tl-step {{ $cls }}">
                                            <div class="tl-dot">
                                                @if($isRej)
                                                    <i class="bi bi-x-lg"></i>
                                                @elseif($isDone)
                                                    <i class="bi bi-check-lg"></i>
                                                @elseif($isActive)
                                                    <i class="bi bi-arrow-right"></i>
                                                @else
                                                    <i class="bi bi-circle" style="color:#ccc"></i>
                                                @endif
                                            </div>
                                            <div class="tl-label">{{ $step['label'] }}</div>
                                        </div>
                                    @endforeach
                                </div>

                                {{-- Admin Note --}}
                                @if($loan->admin_notes)
                                <div class="admin-note">
                                    <strong><i class="bi bi-chat-left-text me-1"></i>Catatan Admin</strong>
                                    {{ $loan->admin_notes }}
                                </div>
                                @endif
                            </div>

                        </div>
                    </div>

                </div>
                @empty
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="bi bi-inbox"></i>
                    </div>
                    <h5>Belum Ada Peminjaman</h5>
                    <p>Anda belum pernah mengajukan peminjaman alat laboratorium.</p>
                    <a href="{{ route('laboratorium.pinjam') }}" class="btn-pinjam">
                        <i class="bi bi-plus-circle"></i> Ajukan Peminjaman
                    </a>
                </div>
                @endforelse

            </div>
        </div>
    </div>
</div>

@endsection
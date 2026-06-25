@extends('layouts.guest_layout')

@section('title', 'Status Peminjaman - MyBioproses')

@push('styles')
<style>
/* TOKENS */
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
    --shadow-md:    0 4px 16px rgba(26,77,46,.12), 0 2px 6px rgba(26,77,46,.07);
}

/* HEADER STYLE (IDENTIK DENGAN PEMINJAMAN/PROFIL) */
.ph-wrap {
    position: relative; padding: 6rem 0 0;
    overflow: hidden; min-height: 340px;
}
.ph-bg {
    position: absolute; inset: 0;
    background-image: url('{{ asset("guest_assets/img/peminjaman-bg.jpg") }}');
    background-size: cover; background-position: center 40%;
    filter: saturate(.85) brightness(.65);
}
.ph-overlay {
    position: absolute; inset: 0;
    background: radial-gradient(ellipse at 20% 15%, rgba(255, 255, 255, 0.2) 0%, rgba(255, 255, 255, 0) 70%),
                linear-gradient(90deg, rgba(8,24,14,.45) 0%, rgba(10,28,18,.35) 45%, rgba(8,20,12,.15) 75%, rgba(8,20,12,.05) 100%),
                linear-gradient(180deg, rgba(0,0,0,.05) 0%, rgba(0,0,0,.15) 100%);
}
.ph-grid {
    position: absolute; inset: 0;
    background-image: linear-gradient(rgba(29,158,117,.04) 1px, transparent 1px),
                      linear-gradient(90deg, rgba(29,158,117,.04) 1px, transparent 1px);
    background-size: 40px 40px;
}
.ph-vignette {
    position: absolute; bottom: 0; left: 0; right: 0; height: 120px;
    background: linear-gradient(to bottom, transparent 0%, rgba(6,18,10,.55) 100%);
}
.ph-inner { position: relative; z-index: 3; padding-bottom: 4rem; }
.ph-eyebrow {
    display: inline-flex; align-items: center; gap: .45rem;
    font-size: .7rem; font-weight: 700; letter-spacing: .18em;
    color: var(--accent); margin-bottom: 1.25rem;
}
.ph-eyebrow::before { content: ''; display: block; width: 18px; height: 2px; background: var(--accent); }
.ph-title {
    font-family: 'Playfair Display', serif; font-size: clamp(2.4rem, 5vw, 3.8rem);
    font-weight: 900; color: #fff; line-height: 1.1; margin: 0 0 1rem;
    text-shadow: 0 2px 16px rgba(0,0,0,.35);
}
.ph-title em { font-style: italic; color: var(--accent); }
.ph-sub { font-size: .98rem; color: rgba(255,255,255,.6); max-width: 480px; line-height: 1.8; margin: 0; }
.ph-wave { position: relative; height: 70px; overflow: hidden; margin-top: -1px; z-index: 4; }
.ph-wave svg { position: absolute; bottom: 0; left: 0; width: 100%; height: 100%; }

/* CONTENT STYLE */
.status-body { background: var(--cream); padding-bottom: 5rem; min-height: 60vh; }

/* Filter Bar */
.filter-card {
    background: white; border-radius: 1rem; padding: 1.25rem;
    box-shadow: 0 10px 30px rgba(0,0,0,0.05); border: 1px solid var(--border);
    margin-top: -2.5rem; position: relative; z-index: 20;
}
.input-minimal { background: #f8fafc; border: 1px solid var(--border); border-radius: 0.75rem; padding: 0.6rem 1rem; font-size: 0.85rem; }

/* Loan Card */
.loan-card {
    background: white; border: 1px solid var(--border); border-radius: 1.25rem;
    margin-bottom: 1.25rem; overflow: hidden; transition: 0.3s;
}
.loan-card:hover { transform: translateY(-3px); box-shadow: var(--shadow-md); }
.loan-card.pending { border-left: 5px solid #f59e0b; }
.loan-card.approved { border-left: 5px solid var(--accent); }
.loan-card.returned { border-left: 5px solid #3b82f6; }
.loan-card.rejected { border-left: 5px solid #ef4444; }

.card-top { padding: 1.25rem; display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 1rem; }
.card-bottom { padding: 1rem 1.25rem; background: #f9fbf9; border-top: 1px dashed var(--border); display: flex; justify-content: space-between; align-items: center; }

/* Badges */
.badge-status { padding: 0.4rem 0.8rem; border-radius: 50px; font-size: 0.65rem; font-weight: 800; text-transform: uppercase; }
.b-pending { background: #fff7ed; color: #c2410c; }
.b-approved { background: #f0fdf4; color: #166534; }
.b-returned { background: #eff6ff; color: #1d4ed8; }
.b-rejected { background: #fef2f2; color: #b91c1c; }

/* Pagination */
.pagination-custom { margin-top: 2rem; display: flex; justify-content: center; }
.pagination-custom .pagination { gap: 0.5rem; }
.page-link { border-radius: 10px !important; color: var(--forest); font-weight: 700; border: 1px solid var(--border); }
.page-item.active .page-link { background: var(--forest); border-color: var(--forest); }
</style>
@endpush

@section('content')

{{-- BANNER HEADER --}}
<div class="ph-wrap">
    <div class="ph-bg"></div>
    <div class="ph-overlay"></div>
    <div class="ph-grid"></div>
    <div class="ph-vignette"></div>
    <div class="container">
        <div class="ph-inner">
            <div class="ph-eyebrow">Layanan MyBioproses</div>
            <h1 class="ph-title">Status <em>Peminjaman</em></h1>
            <p class="ph-sub">Pantau aktivitas peminjaman laboratorium Anda secara transparan. Semua riwayat terekam secara otomatis.</p>
        </div>
    </div>
    <div class="ph-wave">
        <svg viewBox="0 0 1440 70" preserveAspectRatio="none" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0,40 C360,80 1080,0 1440,40 L1440,70 L0,70 Z" fill="var(--cream)"/>
        </svg>
    </div>
</div>

<div class="status-body">
    <div class="container">
        
        {{-- FILTER & SEARCH BAR --}}
        <div class="row justify-content-center">
            <div class="col-lg-11">
                <div class="filter-card">
                    <form action="" method="GET" class="row g-2 align-items-end">
                        <div class="col-md-4">
                            <label class="small fw-bold text-muted mb-1 text-uppercase">Cari Resi / Judul</label>
                            <input type="text" name="search" class="form-control input-minimal" placeholder="Ketik nomor resi..." value="{{ request('search') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="small fw-bold text-muted mb-1 text-uppercase">Status</label>
                            <select name="status" class="form-select input-minimal">
                                <option value="all">Semua Status</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu</option>
                                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Disetujui</option>
                                <option value="returned" {{ request('status') == 'returned' ? 'selected' : '' }}>Kembali</option>
                                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="small fw-bold text-muted mb-1 text-uppercase">Tanggal Pinjam</label>
                            <input type="date" name="date" class="form-control input-minimal" value="{{ request('date') }}">
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-success w-100 fw-bold rounded-pill" style="background:var(--forest); border:none; padding: 0.6rem;">Filter</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- LIST LOAN CARDS --}}
        <div class="row justify-content-center mt-5">
            <div class="col-lg-11">
                @forelse($loans as $loan)
                <div class="loan-card {{ $loan->status }}">
                    <div class="card-top">
                        <div style="flex: 1;">
                            <div class="small font-monospace text-success fw-bold">#{{ $loan->receipt_number }}</div>
                            <h5 class="fw-bold my-1" style="color:var(--forest-deep)">{{ $loan->research_title }}</h5>
                            <div class="d-flex gap-3 text-muted small mt-2">
                                <span><i class="bi bi-geo-alt me-1"></i> {{ $loan->lab->name ?? 'Laboratorium' }}</span>
                                <span><i class="bi bi-calendar3 me-1"></i> {{ \Carbon\Carbon::parse($loan->planned_borrow_date)->format('d M Y') }}</span>
                            </div>
                        </div>
                        <div class="text-end">
                            @php
                                $s = [
                                    'pending' => ['b-pending', 'Menunggu Verifikasi'],
                                    'approved' => ['b-approved', 'Disetujui'],
                                    'returned' => ['b-returned', 'Selesai'],
                                    'rejected' => ['b-rejected', 'Ditolak'],
                                ][$loan->status] ?? ['bg-light', $loan->status];
                            @endphp
                            <span class="badge-status {{ $s[0] }}">{{ $s[1] }}</span>
                        </div>
                    </div>
                    <div class="card-bottom">
                        <div class="small text-muted">
                            <strong>Item:</strong> 
                            @foreach($loan->details as $detail)
                                {{ $detail->inventory->item_name }} ({{ $detail->quantity }}),
                            @endforeach
                        </div>
                        <a href="{{ route('guest.loan.success', $loan->receipt_number) }}" class="btn btn-sm btn-outline-success rounded-pill px-3 fw-bold">Detail Resi</a>
                    </div>
                </div>
                @empty
                <div class="text-center py-5">
                    <i class="bi bi-clipboard-x fs-1 text-muted opacity-25"></i>
                    <h5 class="mt-3 text-muted">Data peminjaman tidak ditemukan.</h5>
                    <a href="{{ route('laboratorium.pinjam') }}" class="btn btn-success btn-sm rounded-pill px-4 mt-2" style="background:var(--forest); border:none;">Pinjam Alat Sekarang</a>
                </div>
                @endforelse

                {{-- PAGINATION --}}
                <div class="pagination-custom">
                    {{ $loans->appends(request()->query())->links() }}
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
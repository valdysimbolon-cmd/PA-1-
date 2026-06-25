@extends('layouts.admin')

@section('title', 'Transaksi Peminjaman Lab')

@section('content')
<div class="container-fluid px-3 px-md-4 pb-5">
    <!-- Judul + Deskripsi -->
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mt-4 mb-4">
        <div>
            <h1 class="h3 text-gray-800 mb-1 fw-bold">Transaksi Peminjaman Lab</h1>
            <p class="text-muted small mb-0">Kelola seluruh transaksi peminjaman alat laboratorium.</p>
        </div>
    </div>

    <!-- Statistik Cards (Gaya Manajemen Informasi) -->
    @php
        $loanStats = [
            ['label'=>'Total',     'key'=>'total',     'color'=>'success', 'icon'=>'fa-layer-group'],
            ['label'=>'Pending',   'key'=>'pending',   'color'=>'warning', 'icon'=>'fa-clock'],
            ['label'=>'Approved',  'key'=>'approved',  'color'=>'primary', 'icon'=>'fa-check-circle'],
            ['label'=>'Handover',  'key'=>'handover',  'color'=>'info',    'icon'=>'fa-handshake'],
            ['label'=>'Returned',  'key'=>'returned',  'color'=>'success', 'icon'=>'fa-undo-alt'],
            ['label'=>'Rejected',  'key'=>'rejected',  'color'=>'danger',  'icon'=>'fa-times-circle'],
        ];
        
        $statusCounts = [
            'total'    => $loans->total(),
            'pending'  => $loans->getCollection()->where('status','pending')->count(),
            'approved' => $loans->getCollection()->where('status','approved')->count(),
            'handover' => $loans->getCollection()->where('status','handover')->count(),
            'returned' => $loans->getCollection()->where('status','returned')->count(),
            'rejected' => $loans->getCollection()->where('status','rejected')->count(),
        ];
    @endphp

    <div class="row g-3 mb-4">
        @foreach($loanStats as $s)
        <div class="col-6 col-md-4 col-xl-2">
            <div class="card border-0 shadow-sm border-start border-{{ $s['color'] }} border-5">
                <div class="card-body py-3 px-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-xs font-weight-bold text-{{ $s['color'] }} text-uppercase mb-1" style="font-size: 0.7rem;">{{ $s['label'] }}</div>
                            <div class="h4 mb-0 font-weight-bold text-gray-800">{{ $statusCounts[$s['key']] ?? 0 }}</div>
                        </div>
                        <div class="rounded-circle p-2 d-none d-lg-block" style="background-color: rgba(0,0,0,0.03);">
                            <i class="fas {{ $s['icon'] }} text-{{ $s['color'] }}"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Filter & Pencarian (Gaya Manajemen Informasi) -->
    <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
        <div class="card-body py-3 px-3">
            <form method="GET" action="{{ route('admin.loans.index') }}" class="w-100 m-0">
                <div class="row g-2">
                    <!-- Filter Status -->
                    <div class="col-12 col-md-4 col-lg-3">
                        <label class="filter-label text-success"><i class="fas fa-filter me-1"></i> Status Transaksi</label>
                        <select name="status" class="filter-select filter-green" onchange="this.form.submit()">
                            <option value="">Semua Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                            <option value="handover" {{ request('status') == 'handover' ? 'selected' : '' }}>Handover</option>
                            <option value="returned" {{ request('status') == 'returned' ? 'selected' : '' }}>Returned</option>
                            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                    </div>

                    <!-- Pencarian -->
                    <div class="col-12 col-md-8 col-lg-9">
                        <label class="filter-label text-muted"><i class="fas fa-search me-1"></i> Pencarian</label>
                        <div class="search-wrap">
                            <input type="text" name="search"
                                class="search-input"
                                placeholder="Cari nama peminjam, NIM, atau nomor resi..."
                                value="{{ request('search') }}">
                            <div class="search-actions">
                                @if(request('search') || request('status'))
                                    <a href="{{ route('admin.loans.index') }}" class="btn-reset" title="Reset">
                                        <i class="fas fa-times"></i>
                                    </a>
                                @endif
                                <button type="submit" class="btn-cari">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabel Peminjaman (Banner Hijau) -->
    <div class="card shadow-sm border-0 mb-5">
        <div class="card-header bg-success py-3 d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <i class="fas fa-list me-2 text-white"></i>
                <h6 class="m-0 font-weight-bold text-white">Daftar Transaksi Peminjaman</h6>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light text-secondary">
                        <tr>
                            <th class="ps-4" style="width: 150px">No. Resi</th>
                            <th>Peminjam</th>
                            <th>Tanggal Pinjam</th>
                            <th class="text-center">Status</th>
                            <th class="text-center pe-4" style="width: 120px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($loans as $loan)
                        <tr>
                            <td class="ps-4">
                                <code class="fw-bold text-success px-2 py-1 bg-light border rounded" style="font-size:0.85rem;">
                                    {{ $loan->receipt_number }}
                                </code>
                            </td>
                            <td>
                                <div class="fw-bold text-dark">{{ $loan->borrower_name }}</div>
                                <small class="text-muted"><i class="fas fa-id-card me-1 small"></i>{{ $loan->nim ?? '—' }}</small>
                            </td>
                            <td>
                                <div class="fw-bold small text-dark">
                                    <i class="far fa-calendar-alt me-1 text-success"></i>
                                    {{ \Carbon\Carbon::parse($loan->planned_borrow_date)->format('d M Y') }}
                                </div>
                            </td>
                            <td class="text-center">
                                @php
                                    $statusStyle = [
                                        'pending'  => 'bg-secondary-subtle text-secondary border-secondary',
                                        'approved' => 'bg-primary-subtle text-primary border-primary',
                                        'handover' => 'bg-info-subtle text-info border-info',
                                        'returned' => 'bg-success-subtle text-success border-success',
                                        'rejected' => 'bg-danger-subtle text-danger border-danger',
                                    ];
                                    $currentStyle = $statusStyle[$loan->status] ?? 'bg-light text-dark border-dark';
                                @endphp
                                <span class="badge rounded-pill border px-3 py-2 {{ $currentStyle }}" style="font-size: 0.75rem; min-width: 90px;">
                                    {{ ucfirst($loan->status) }}
                                </span>
                            </td>
                            <td class="text-center pe-4">
                                <a href="{{ route('admin.loans.show', $loan->id) }}" class="btn btn-sm btn-outline-success shadow-sm px-3">
                                    <i class="fas fa-eye me-1"></i> Detail
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="fas fa-inbox fa-3x mb-3 d-block opacity-25"></i>
                                Belum ada data transaksi yang ditemukan.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        @if($loans->hasPages())
            <div class="card-footer bg-white border-top-0 py-3 d-flex justify-content-center">
                {{ $loans->withQueryString()->links() }}
            </div>
        @endif
    </div>
</div>

<style>
    /* Custom CSS agar mirip dengan Manajemen Informasi */
    .bg-success-subtle { background-color: #e8f5e9 !important; }
    .bg-primary-subtle { background-color: #e3f2fd !important; }
    .bg-info-subtle { background-color: #e0f7fa !important; }
    .bg-danger-subtle { background-color: #fdecea !important; }
    .bg-secondary-subtle { background-color: #f8f9fa !important; }

    .filter-label {
        display: block;
        font-size: 0.7rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        margin-bottom: 4px;
        padding-left: 2px;
    }

    .filter-select {
        width: 100%;
        height: 38px;
        border-radius: 8px;
        font-size: 0.85rem;
        font-weight: 500;
        padding: 0 10px;
        outline: none;
        cursor: pointer;
        appearance: none;
        -webkit-appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='10' viewBox='0 0 24 24' fill='none' stroke='%23666' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 10px center;
        transition: box-shadow 0.15s, border-color 0.15s;
    }

    .filter-green {
        background-color: #f0faf4;
        border: 1.5px solid #b2dfcc;
        color: #155724;
        box-shadow: 0 1px 4px rgba(25,135,84,0.1), inset 0 1px 2px rgba(255,255,255,0.8);
    }
    .filter-green:focus {
        border-color: #198754;
        box-shadow: 0 0 0 3px rgba(25,135,84,0.15);
    }

    .search-wrap {
        display: flex;
        align-items: center;
        height: 38px;
        border-radius: 8px;
        border: 1.5px solid #c8e6c9;
        background: #fff;
        box-shadow: 0 1px 4px rgba(0,0,0,0.07), inset 0 1px 2px rgba(255,255,255,0.9);
        overflow: hidden;
        padding-left: 10px;
        transition: border-color 0.15s, box-shadow 0.15s;
    }
    .search-wrap:focus-within {
        border-color: #198754;
        box-shadow: 0 0 0 3px rgba(25,135,84,0.15);
    }
    .search-input {
        flex: 1;
        border: none;
        outline: none;
        font-size: 0.85rem;
        background: transparent;
        color: #333;
        min-width: 0;
    }
    .search-actions {
        display: flex;
        align-items: center;
        gap: 3px;
        padding-right: 5px;
    }
    .btn-reset {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 26px;
        height: 26px;
        border-radius: 50%;
        background: #fff0f0;
        border: 1px solid #f5c6cb;
        color: #dc3545;
        font-size: 0.7rem;
        text-decoration: none;
    }
    .btn-cari {
        width: 30px;
        height: 30px;
        border-radius: 7px;
        border: none;
        background-color: #198754;
        color: #fff;
        font-size: 0.8rem;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .card { border-radius: 10px; }
    
    @media (max-width: 576px) {
        .table td, .table th { white-space: nowrap; }
    }
</style>
@endsection
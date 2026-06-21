@extends('layouts.admin')

@section('title', 'Laporan & Rekapitulasi Lab')

@section('content')
<div class="container-fluid px-3 px-md-4 pb-5">
    <!-- Header -->
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mt-4 mb-4">
        <div>
            <h1 class="h3 text-gray-800 mb-1 fw-bold">Laporan & Rekapitulasi</h1>
            <p class="text-muted small mb-0">Unduh laporan peminjaman alat dan data inventaris laboratorium.</p>
        </div>
        <span class="badge bg-success-subtle text-success border border-success px-3 py-2 rounded-pill">
            <i class="fas fa-file-alt me-1"></i> {{ date('d M Y') }}
        </span>
    </div>

    <div class="row g-4 justify-content-center">
        <!-- Card Laporan Peminjaman -->
        <div class="col-12 col-sm-6 col-xl-5">
            <div class="card border-0 shadow-sm h-100 text-center p-4 p-lg-5 rounded-4 hover-card transition-all">
                <div class="card-body d-flex flex-column align-items-center">
                    <div class="rounded-circle bg-primary-soft p-4 mb-4" style="background-color: rgba(13, 110, 253, 0.1);">
                        <i class="fas fa-file-pdf fa-3x text-primary"></i>
                    </div>
                    <h5 class="card-title fw-bold text-dark">Rekap Peminjaman</h5>
                    <p class="card-text text-muted small">Download data transaksi peminjaman mahasiswa dalam format PDF.</p>
                    <a href="{{ route('admin.reports.loan.pdf') }}" class="btn btn-primary mt-3 px-5 py-2 rounded-pill fw-bold shadow-sm">
                        <i class="fas fa-download me-2"></i> Export PDF
                    </a>
                </div>
            </div>
        </div>

        <!-- Card Laporan Inventaris -->
        <div class="col-12 col-sm-6 col-xl-5">
            <div class="card border-0 shadow-sm h-100 text-center p-4 p-lg-5 rounded-4 hover-card transition-all">
                <div class="card-body d-flex flex-column align-items-center">
                    <div class="rounded-circle bg-success-soft p-4 mb-4" style="background-color: rgba(25, 135, 84, 0.1);">
                        <i class="fas fa-boxes fa-3x text-success"></i>
                    </div>
                    <h5 class="card-title fw-bold text-dark">Data Inventaris</h5>
                    <p class="card-text text-muted small">Download daftar alat, bahan, dan sisa stok inventaris laboratorium.</p>
                    <a href="{{ route('admin.reports.inventory.pdf') }}" class="btn btn-success mt-3 px-5 py-2 rounded-pill fw-bold shadow-sm">
                        <i class="fas fa-download me-2"></i> Export PDF
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .hover-card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .hover-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08) !important;
    }
    .bg-primary-soft { background-color: rgba(13, 110, 253, 0.08); }
    .bg-success-soft { background-color: rgba(25, 135, 84, 0.08); }
    .btn-primary, .btn-success {
        min-width: 160px;
    }
    @media (max-width: 576px) {
        .card { padding: 1.5rem !important; }
        .btn { width: 100%; }
    }
</style>
@endsection
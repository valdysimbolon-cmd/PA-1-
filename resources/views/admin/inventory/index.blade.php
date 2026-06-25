@extends('layouts.admin')

@section('title', 'Manajemen Inventaris')

@section('content')
<div class="container-fluid px-3 px-md-4">
    <!-- Judul + Tombol Tambah -->
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mt-4 mb-4">
        <div>
            <h1 class="h3 text-gray-800 mb-1">Manajemen Inventaris</h1>
            <p class="text-muted small mb-0">Kelola data alat, bahan, dan instrumen laboratorium.</p>
        </div>
        <a href="{{ route('inventories.create') }}" class="btn btn-success shadow-sm px-3 d-flex align-items-center" style="height: 42px;">
            <i class="fas fa-plus me-2"></i> <span>Tambah Inventaris</span>
        </a>
    </div>

    <!-- Statistik Card (Alat, Bahan, Instrumen) -->
    <div class="row g-3 mb-4">
        <!-- Statistik Alat -->
        <div class="col-12 col-md-4">
            <div class="card border-0 shadow-sm border-start border-success border-5 h-100">
                <div class="card-body py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Alat (Equipment)</div>
                            <div class="h3 mb-0 font-weight-bold text-gray-800">
                                {{ $inventories->getCollection()->where('category', 'Equipment')->count() }}
                            </div>
                        </div>
                        <div class="rounded-circle p-3" style="background-color: rgba(25, 135, 84, 0.1);">
                            <i class="fas fa-tools fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistik Bahan -->
        <div class="col-12 col-md-4">
            <div class="card border-0 shadow-sm border-start border-primary border-5 h-100">
                <div class="card-body py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Bahan (Material)</div>
                            <div class="h3 mb-0 font-weight-bold text-gray-800">
                                {{ $inventories->getCollection()->where('category', 'Material')->count() }}
                            </div>
                        </div>
                        <div class="rounded-circle p-3" style="background-color: rgba(13, 110, 253, 0.1);">
                            <i class="fas fa-flask fa-2x text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistik Instrumen -->
        <div class="col-12 col-md-4">
            <div class="card border-0 shadow-sm border-start border-info border-5 h-100">
                <div class="card-body py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Instrumen</div>
                            <div class="h3 mb-0 font-weight-bold text-gray-800">
                                {{ $inventories->getCollection()->where('category', 'Instrument')->count() }}
                            </div>
                        </div>
                        <div class="rounded-circle p-3" style="background-color: rgba(13, 202, 240, 0.1);">
                            <i class="fas fa-microscope fa-2x text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Pencarian (Identik dengan Desain Informasi) -->
    <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
        <div class="card-body py-3 px-3">
            <form method="GET" action="{{ route('inventories.index') }}" class="w-100 m-0">
                <div class="row g-2">
                    <!-- Filter Kategori -->
                    <div class="col-12 col-md-3">
                        <label class="filter-label text-success"><i class="fas fa-tags me-1"></i> Kategori</label>
                        <select name="category" class="filter-select filter-green" onchange="this.form.submit()">
                            <option value="">Semua Kategori</option>
                            <option value="Equipment" {{ request('category') == 'Equipment' ? 'selected' : '' }}>Alat</option>
                            <option value="Material" {{ request('category') == 'Material' ? 'selected' : '' }}>Bahan</option>
                            <option value="Instrument" {{ request('category') == 'Instrument' ? 'selected' : '' }}>Instrumen</option>
                        </select>
                    </div>

                    <!-- Filter Lab -->
                    <div class="col-12 col-md-3">
                        <label class="filter-label text-primary"><i class="fas fa-door-open me-1"></i> Lokasi Lab</label>
                        <select name="lab_id" class="filter-select filter-blue" onchange="this.form.submit()">
                            <option value="">Semua Lab</option>
                            @foreach($labs as $lab)
                                <option value="{{ $lab->id }}" {{ request('lab_id') == $lab->id ? 'selected' : '' }}>{{ $lab->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Filter Kondisi -->
                    <div class="col-12 col-md-2">
                        <label class="filter-label" style="color:#e67e22;"><i class="fas fa-check-circle me-1"></i> Kondisi</label>
                        <select name="condition" class="filter-select filter-orange" onchange="this.form.submit()">
                            <option value="">Semua</option>
                            <option value="Good" {{ request('condition') == 'Good' ? 'selected' : '' }}>Baik</option>
                            <option value="Broken" {{ request('condition') == 'Broken' ? 'selected' : '' }}>Rusak</option>
                        </select>
                    </div>

                    <!-- Pencarian -->
                    <div class="col-12 col-md-4">
                        <label class="filter-label text-muted"><i class="fas fa-search me-1"></i> Pencarian</label>
                        <div class="search-wrap">
                            <input type="text" name="search" class="search-input" placeholder="Cari nama atau kode..." value="{{ request('search') }}">
                            <div class="search-actions">
                                @if(request('search') || request('category') || request('lab_id') || request('condition'))
                                    <a href="{{ route('inventories.index') }}" class="btn-reset" title="Reset"><i class="fas fa-times"></i></a>
                                @endif
                                <button type="submit" class="btn-cari"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabel Data -->
    <div class="card shadow-sm border-0 mb-5">
        <div class="card-header bg-success py-3 d-flex align-items-center">
            <i class="fas fa-list me-2 text-white"></i>
            <h6 class="m-0 font-weight-bold text-white">Daftar Inventaris</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light text-secondary">
                        <tr>
                            <th class="ps-4" style="width: 80px">Foto</th>
                            <th>Nama Item</th>
                            <th>Kategori</th>
                            <th>Lokasi Lab</th>
                            <th class="text-center">Tersedia</th>
                            <th class="text-center pe-4" style="width: 120px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($inventories as $item)
                        <tr>
                            <td class="ps-4">
                                @if($item->image)
                                    <img src="{{ asset('storage/'.$item->image) }}" class="rounded shadow-sm border" width="50" height="40" style="object-fit: cover;">
                                @else
                                    <div class="bg-light border rounded d-inline-flex align-items-center justify-content-center" style="width: 50px; height: 40px;">
                                        <i class="fas fa-box text-secondary"></i>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <div class="fw-bold text-dark">{{ $item->item_name }}</div>
                                <small class="text-muted">Kode: <span class="text-primary fw-bold">{{ $item->item_code ?? '-' }}</span></small>
                            </td>
                            <td>
                                @php
                                    $badge = match($item->category) {
                                        'Equipment' => ['class' => 'bg-success-subtle text-success', 'label' => 'Alat'],
                                        'Material' => ['class' => 'bg-primary-subtle text-primary', 'label' => 'Bahan'],
                                        'Instrument' => ['class' => 'bg-info-subtle text-info', 'label' => 'Instrumen'],
                                        default => ['class' => 'bg-secondary-subtle text-secondary', 'label' => $item->category]
                                    };
                                @endphp
                                <span class="badge {{ $badge['class'] }} border px-2 py-1">{{ $badge['label'] }}</span>
                            </td>
                            <td><div class="small fw-bold text-dark">{{ $item->lab->name ?? '-' }}</div></td>
                            <td class="text-center">
                                <div class="fw-bold text-success">{{ $item->quantity_available }}</div>
                                <div class="text-muted small">/ {{ $item->quantity }} {{ $item->unit }}</div>
                            </td>
                            <td class="text-center pe-4">
                                <div class="btn-group shadow-sm">
                                    <a href="{{ route('inventories.edit', $item->id) }}" class="btn btn-sm btn-outline-success"><i class="fas fa-edit"></i></a>
                                    <form action="{{ route('inventories.destroy', $item->id) }}" method="POST" class="d-inline delete-form">
                                        @csrf @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-outline-danger delete-btn"><i class="fas fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="text-center py-5 text-muted">Belum ada data inventaris.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    /* Sinkronisasi Style dengan Modul Informasi */
    .filter-label { display: block; font-size: 0.7rem; font-weight: 600; text-transform: uppercase; margin-bottom: 4px; padding-left: 2px; }
    .filter-select { 
        width: 100%; height: 38px; border-radius: 8px; font-size: 0.85rem; padding: 0 10px; outline: none; appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='10' viewBox='0 0 24 24' fill='none' stroke='%23666' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
        background-repeat: no-repeat; background-position: right 10px center;
    }
    .filter-green { background-color: #f0faf4; border: 1.5px solid #b2dfcc; color: #155724; }
    .filter-blue { background-color: #f0f6ff; border: 1.5px solid #b3cff5; color: #084298; }
    .filter-orange { background-color: #fffaf0; border: 1.5px solid #f5d5a0; color: #7d4e00; }
    
    .search-wrap { display: flex; align-items: center; height: 38px; border-radius: 8px; border: 1.5px solid #c8e6c9; background: #fff; padding-left: 10px; overflow: hidden; }
    .search-input { flex: 1; border: none; outline: none; font-size: 0.85rem; }
    .btn-cari { width: 30px; height: 30px; border-radius: 7px; border: none; background-color: #198754; color: #fff; display: flex; align-items: center; justify-content: center; }
    .btn-reset { width: 26px; height: 26px; border-radius: 50%; background: #fff0f0; border: 1px solid #f5c6cb; color: #dc3545; display: flex; align-items: center; justify-content: center; text-decoration: none; font-size: 0.7rem; margin-right: 5px;}

    .bg-success-subtle { background-color: #e8f5e9 !important; }
    .bg-primary-subtle { background-color: #e3f2fd !important; }
    .bg-info-subtle { background-color: #e0f7fa !important; }
</style>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function () {
            const form = this.closest('form.delete-form');
            Swal.fire({
                title: 'Hapus Inventaris?',
                text: "Data tidak bisa dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                confirmButtonText: 'Ya, hapus!'
            }).then((result) => { if (result.isConfirmed) form.submit(); });
        });
    });
</script>
@endpush
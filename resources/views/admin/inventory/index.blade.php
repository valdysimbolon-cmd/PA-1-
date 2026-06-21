@extends('layouts.admin')

@section('title', 'Manajemen Inventaris')

@section('content')
<div class="container-fluid px-3 px-md-4 pb-5">

    {{-- ── Header ── --}}
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mt-4 mb-4">
        <div>
            <h1 class="h3 text-gray-800 mb-1 fw-bold">Manajemen Inventaris</h1>
            <p class="text-muted small mb-0">Kelola data alat, bahan, dan instrumen laboratorium.</p>
        </div>
        <a href="{{ route('inventories.create') }}" class="btn btn-success shadow-sm px-3 d-flex align-items-center gap-2" style="height:42px;">
            <i class="fas fa-plus"></i> Tambah Inventaris
        </a>
    </div>

    {{-- ── Statistik Cards ── --}}
    <div class="row g-3 mb-4">
        @php
            $stats = [
                ['label'=>'Alat',      'key'=>'Equipment',  'color'=>'success', 'icon'=>'fa-tools'],
                ['label'=>'Bahan',     'key'=>'Material',   'color'=>'primary', 'icon'=>'fa-flask'],
                ['label'=>'Instrumen', 'key'=>'Instrument', 'color'=>'info',    'icon'=>'fa-microscope'],
                ['label'=>'Total',     'key'=>null,         'color'=>'warning', 'icon'=>'fa-boxes'],
            ];
        @endphp
        @foreach($stats as $s)
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid var(--bs-{{ $s['color'] }}) !important;">
                <div class="card-body py-3 px-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-xs fw-bold text-{{ $s['color'] }} text-uppercase mb-1">{{ $s['label'] }}</div>
                            <div class="h4 mb-0 fw-bold text-gray-800">
                                {{ $s['key'] ? $inventories->getCollection()->where('category', $s['key'])->count() : $inventories->total() }}
                            </div>
                        </div>
                        <div class="rounded-circle d-flex align-items-center justify-content-center" style="width:40px;height:40px;background:rgba(var(--stat-{{ $s['color'] }},0.1));">
                            <i class="fas {{ $s['icon'] }} text-{{ $s['color'] }}"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- ── Filter & Search Bar ── --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-3">
            <form method="GET" action="{{ route('inventories.index') }}" id="filterForm">
                <div class="row g-2 align-items-end">

                    {{-- Tab Kategori --}}
                    <div class="col-12 col-md-auto">
                        <div class="d-flex gap-1 flex-wrap" id="categoryTabs">
                            @php
                                $cats = [
                                    ''           => ['label'=>'Semua',    'icon'=>'fa-border-all'],
                                    'Equipment'  => ['label'=>'Alat',     'icon'=>'fa-tools'],
                                    'Material'   => ['label'=>'Bahan',    'icon'=>'fa-flask'],
                                    'Instrument' => ['label'=>'Instrumen','icon'=>'fa-microscope'],
                                ];
                                $activeCat = request('category', '');
                            @endphp
                            @foreach($cats as $val => $meta)
                            <a href="{{ route('inventories.index', array_merge(request()->except('category','page'), $val ? ['category'=>$val] : [])) }}"
                               class="btn btn-sm fw-bold px-3 {{ $activeCat === $val ? 'btn-success text-white' : 'btn-outline-secondary text-muted' }}">
                                <i class="fas {{ $meta['icon'] }} me-1"></i>{{ $meta['label'] }}
                            </a>
                            @endforeach
                        </div>
                    </div>

                    {{-- Search --}}
                    <div class="col-12 col-md">
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="fas fa-search text-muted"></i></span>
                            <input type="text" name="search" class="form-control bg-light border-0"
                                   placeholder="Cari nama atau kode barang…"
                                   value="{{ request('search') }}">
                            @if(request('search'))
                            <a href="{{ route('inventories.index', request()->except('search','page')) }}" class="btn btn-light border-0 text-muted">
                                <i class="fas fa-times"></i>
                            </a>
                            @endif
                        </div>
                    </div>

                    {{-- Filter Lab --}}
                    <div class="col-12 col-md-auto">
                        <select name="lab_id" class="form-select bg-light border-0" onchange="this.form.submit()">
                            <option value="">Semua Lab</option>
                            @foreach($labs as $lab)
                                <option value="{{ $lab->id }}" {{ request('lab_id') == $lab->id ? 'selected' : '' }}>
                                    {{ $lab->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Filter Status --}}
                    <div class="col-12 col-md-auto">
                        <select name="active" class="form-select bg-light border-0" onchange="this.form.submit()">
                            <option value="">Semua Status</option>
                            <option value="1" {{ request('active') === '1' ? 'selected' : '' }}>Aktif</option>
                            <option value="0" {{ request('active') === '0' ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                    </div>

                    <div class="col-12 col-md-auto d-flex gap-2">
                        <button type="submit" class="btn btn-success px-3">
                            <i class="fas fa-filter me-1"></i> Filter
                        </button>
                        @if(request()->hasAny(['search','lab_id','active']))
                        <a href="{{ route('inventories.index', request()->only('category')) }}" class="btn btn-outline-secondary px-3">
                            <i class="fas fa-undo me-1"></i> Reset
                        </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- ── Tabel ── --}}
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-header bg-success py-3 d-flex align-items-center justify-content-between rounded-top-4">
            <div class="d-flex align-items-center gap-2">
                <i class="fas fa-list text-white"></i>
                <h6 class="m-0 fw-bold text-white">
                    Daftar Inventaris
                    @if($activeCat) — {{ $cats[$activeCat]['label'] }} @endif
                </h6>
            </div>
            <span class="badge bg-white text-success fw-bold">{{ $inventories->total() }} item</span>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light text-secondary" style="font-size:.78rem;letter-spacing:.05em;">
                        <tr>
                            <th class="ps-4 py-3">Item</th>
                            <th class="py-3">Kategori</th>
                            <th class="py-3">Lab</th>
                            <th class="py-3 text-center">Stok</th>
                            <th class="py-3 text-center">Status</th>
                            <th class="py-3 text-end pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($inventories as $item)
                        <tr class="inventory-row" data-category="{{ $item->category }}">
                            {{-- Item --}}
                            <td class="ps-4 py-3">
                                <div class="d-flex align-items-center gap-3">
                                    @if($item->image)
                                        <img src="{{ asset('storage/'.$item->image) }}"
                                             class="rounded-3 object-fit-cover border"
                                             style="width:44px;height:44px;">
                                    @else
                                        <div class="rounded-3 d-flex align-items-center justify-content-center bg-light border"
                                             style="width:44px;height:44px;">
                                            <i class="fas {{ $item->category === 'Material' ? 'fa-flask' : ($item->category === 'Instrument' ? 'fa-microscope' : 'fa-tools') }} text-muted"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <div class="fw-bold text-dark" style="font-size:.9rem;">{{ $item->item_name }}</div>
                                        <div class="text-muted" style="font-size:.77rem;">{{ $item->item_code ?? '—' }}</div>
                                    </div>
                                </div>
                            </td>

                            {{-- Kategori --}}
                            <td class="py-3">
                                @php
                                    $badge = [
                                        'Equipment'  => ['cls'=>'bg-success-subtle text-success',  'label'=>'Alat'],
                                        'Material'   => ['cls'=>'bg-primary-subtle text-primary',  'label'=>'Bahan'],
                                        'Instrument' => ['cls'=>'bg-info-subtle text-info',        'label'=>'Instrumen'],
                                    ][$item->category] ?? ['cls'=>'bg-secondary-subtle text-secondary','label'=>$item->category];
                                @endphp
                                <span class="badge rounded-pill px-3 py-2 fw-semibold {{ $badge['cls'] }}">
                                    {{ $badge['label'] }}
                                </span>
                            </td>

                            {{-- Lab --}}
                            <td class="py-3">
                                <span class="text-muted small">{{ $item->lab->name ?? '—' }}</span>
                            </td>

                            {{-- Stok --}}
                            <td class="py-3 text-center">
                                @php
                                    $pct = $item->quantity > 0 ? ($item->quantity_available / $item->quantity) * 100 : 0;
                                    $barColor = $pct > 50 ? 'bg-success' : ($pct > 20 ? 'bg-warning' : 'bg-danger');
                                @endphp
                                <div class="d-flex flex-column align-items-center gap-1">
                                    <span class="fw-bold" style="font-size:.85rem;">
                                        <span class="text-success">{{ $item->quantity_available }}</span>
                                        <span class="text-muted fw-normal">/{{ $item->quantity }} {{ $item->unit }}</span>
                                    </span>
                                    <div class="progress rounded-pill" style="height:5px;width:70px;">
                                        <div class="progress-bar {{ $barColor }}" style="width:{{ $pct }}%"></div>
                                    </div>
                                </div>
                            </td>

                            {{-- Status --}}
                            <td class="py-3 text-center">
                                <form action="{{ route('inventories.toggle', $item->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit"
                                            class="badge border-0 px-3 py-2 fw-bold rounded-pill {{ $item->active ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }}"
                                            style="cursor:pointer;font-size:.78rem;">
                                        <i class="fas {{ $item->active ? 'fa-check-circle' : 'fa-times-circle' }} me-1"></i>
                                        {{ $item->active ? 'Aktif' : 'Nonaktif' }}
                                    </button>
                                </form>
                            </td>

                            {{-- Aksi --}}
                            <td class="py-3 text-end pe-4">
                                <div class="d-flex justify-content-end gap-1">
                                    <a href="{{ route('inventories.edit', $item->id) }}"
                                       class="btn btn-sm btn-outline-success rounded-3"
                                       title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('inventories.destroy', $item->id) }}" method="POST" class="d-inline delete-form">
                                        @csrf @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-outline-danger rounded-3 delete-btn" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="fas fa-box-open fa-3x mb-3 d-block opacity-25"></i>
                                <div class="fw-bold mb-1">Belum ada data inventaris</div>
                                <a href="{{ route('inventories.create') }}" class="btn btn-success btn-sm mt-2">
                                    <i class="fas fa-plus me-1"></i> Tambah Sekarang
                                </a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination --}}
        @if($inventories->hasPages())
        <div class="card-footer bg-white border-top py-3">
            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center gap-2">
                <small class="text-muted">
                    Menampilkan {{ $inventories->firstItem() }}–{{ $inventories->lastItem() }}
                    dari <strong>{{ $inventories->total() }}</strong> item
                </small>
                {{ $inventories->withQueryString()->links() }}
            </div>
        </div>
        @endif
    </div>
</div>

<style>
.bg-success-subtle { background-color: #d1e7dd !important; }
.bg-danger-subtle  { background-color: #f8d7da !important; }
.bg-primary-subtle { background-color: #cfe2ff !important; }
.bg-info-subtle    { background-color: #cff4fc !important; }
.rounded-top-4     { border-radius: .75rem .75rem 0 0 !important; }
.object-fit-cover  { object-fit: cover; }
.inventory-row:hover td { background-color: #f8fffe; }
@media (max-width: 576px) {
    .table td, .table th { white-space: nowrap; }
}
</style>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    @if(session('success'))
        Swal.fire({ icon:'success', title:'Berhasil!', text:'{{ session('success') }}',
            showConfirmButton:false, timer:2500, timerProgressBar:true });
    @endif
    @if(session('error'))
        Swal.fire({ icon:'error', title:'Oops…', text:'{{ session('error') }}',
            confirmButtonColor:'#dc3545' });
    @endif

    document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            const form = this.closest('form.delete-form');
            Swal.fire({
                title: 'Hapus item ini?',
                text: 'Data yang dihapus tidak dapat dikembalikan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then(r => { if (r.isConfirmed) form.submit(); });
        });
    });
});
</script>
@endpush
@endsection
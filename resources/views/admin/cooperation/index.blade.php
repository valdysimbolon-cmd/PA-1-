@extends('layouts.admin')

@section('title', 'Daftar Mitra')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 text-gray-800">Mitra Kerja Sama</h1>
            <p class="text-muted small">Daftar instansi/perusahaan mitra</p>
        </div>
        <a href="{{ route('cooperations.create') }}" class="btn btn-success btn-sm shadow-sm">
            <i class="fas fa-plus me-1"></i> Mitra Baru
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header py-3" style="background-color: #200F07;">
            <h6 class="m-0 font-weight-bold" style="color: #C5E384;">Daftar Instansi Terdaftar</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 80px">Logo</th>
                            <th>Nama Instansi</th>
                            <th style="width: 120px">Tipe</th>
                            <th>Masa Berlaku</th>
                            <th style="width: 80px">Status</th>
                            <th style="width: 100px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($cooperations as $mitra)
                        <tr>
                            <td>
                                @if($mitra->logo)
                                    <img src="{{ asset('storage/' . $mitra->logo) }}" width="50" height="50" class="img-thumbnail rounded" style="object-fit: cover;">
                                @else
                                    <div class="bg-light rounded d-inline-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                        <i class="fas fa-building text-secondary"></i>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <strong>{{ $mitra->name }}</strong>
                                @if($mitra->description)
                                    <br><small class="text-muted">{{ Str::limit($mitra->description, 60) }}</small>
                                @endif
                            </td>
                            <td><span class="badge bg-info">{{ $mitra->type }}</span></td>
                            <td>
                                <small>{{ $mitra->start_date ?? '-' }}<br>s/d {{ $mitra->end_date ?? 'Selamanya' }}</small>
                            </td>
                            <td>
                                @if($mitra->active)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">Nonaktif</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('cooperations.edit', $mitra->id) }}" class="btn btn-sm btn-outline-primary me-1">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('cooperations.destroy', $mitra->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus mitra ini?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="fas fa-handshake fa-2x mb-2 d-block"></i>
                                Belum ada data mitra. <a href="{{ route('cooperations.create') }}">Tambah sekarang</a>.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @if(method_exists($cooperations, 'links'))
        <div class="d-flex justify-content-center mt-4">
            {{ $cooperations->links() }}
        </div>
    @endif
</div>
@endsection
@extends('layouts.admin')

@section('title', 'Manajemen Kurikulum')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 text-gray-800">Manajemen Kurikulum</h1>
            <p class="text-muted small">Kelola versi kurikulum prodi</p>
        </div>
        <a href="{{ route('curriculums.create') }}" class="btn btn-success btn-sm shadow-sm">
            <i class="fas fa-plus me-1"></i> Kurikulum Baru
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3" style="background-color: #200F07;">
            <h6 class="m-0 font-weight-bold" style="color: #C5E384;">Daftar Kurikulum</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Nama Kurikulum</th>
                            <th style="width: 100px">Status</th>
                            <th style="width: 100px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($curriculums as $c)
                        <tr>
                            <td>
                                <strong>{{ $c->name }}</strong>
                            </td>
                            <td>
                                @if($c->active)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">Nonaktif</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('curriculums.edit', $c->id) }}" class="btn btn-sm btn-outline-primary me-1">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('curriculums.destroy', $c->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus kurikulum ini?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center py-5 text-muted">
                                <i class="fas fa-book fa-2x mb-2 d-block"></i>
                                Belum ada kurikulum. <a href="{{ route('curriculums.create') }}">Tambah sekarang</a>.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @if(method_exists($curriculums, 'links'))
        <div class="d-flex justify-content-center mt-4">
            {{ $curriculums->links() }}
        </div>
    @endif
</div>
@endsection
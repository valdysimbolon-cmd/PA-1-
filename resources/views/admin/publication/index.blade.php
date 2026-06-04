@extends('layouts.admin')

@section('title', 'Manajemen Publikasi')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 text-gray-800">Manajemen Publikasi Karya</h1>
            <p class="text-muted small">Daftar karya ilmiah, jurnal, buku, dan penelitian dosen</p>
        </div>
        <a href="{{ route('publications.create') }}" class="btn btn-success btn-sm shadow-sm">
            <i class="fas fa-plus me-1"></i> Publikasi Baru
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3" style="background-color: #200F07;">
            <h6 class="m-0 font-weight-bold" style="color: #C5E384;">Daftar Seluruh Karya Ilmiah & Penelitian</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Judul & Penerbit</th>
                            <th>Penulis (Dosen/Staff)</th>
                            <th style="width: 150px">Tipe</th>
                            <th style="width: 80px">Tahun</th>
                            <th style="width: 100px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($publications as $p)
                        <tr>
                            <td>
                                <div class="fw-bold">{{ $p->title }}</div>
                                @if($p->publisher)
                                    <small class="text-muted">{{ $p->publisher }}</small>
                                @endif
                            </td>
                            <td>
                                @foreach($p->authors as $auth)
                                    <span class="badge bg-light text-dark border mb-1 d-inline-block">
                                        {{ $auth->lecturer?->name ?? 'Dosen tidak ditemukan' }}
                                        <small>({{ $auth->position }})</small>
                                    </span><br>
                                @endforeach
                            </td>
                            <td><span class="badge bg-info">{{ $p->type }}</span></td>
                            <td class="text-center">{{ $p->year }}</td>
                            <td class="text-center">
                                <a href="{{ route('publications.edit', $p->id) }}" class="btn btn-sm btn-outline-primary me-1">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('publications.destroy', $p->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus publikasi ini?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="fas fa-book-open fa-2x mb-2 d-block"></i>
                                Belum ada publikasi. <a href="{{ route('publications.create') }}">Tambah sekarang</a>.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @if(method_exists($publications, 'links'))
        <div class="d-flex justify-content-center mt-4">
            {{ $publications->links() }}
        </div>
    @endif
</div>
@endsection
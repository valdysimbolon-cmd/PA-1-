@extends('layouts.admin')

@section('title', 'Manajemen Mata Kuliah')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 text-gray-800">Manajemen Mata Kuliah</h1>
            <p class="text-muted small">Daftar mata kuliah pada kurikulum aktif</p>
        </div>
        <a href="{{ route('subjects.create') }}" class="btn btn-success btn-sm shadow-sm">
            <i class="fas fa-plus me-1"></i> Mata Kuliah Baru
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3" style="background-color: #200F07;">
            <h6 class="m-0 font-weight-bold" style="color: #C5E384;">Daftar Mata Kuliah</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 100px">Kode</th>
                            <th>Nama Mata Kuliah</th>
                            <th style="width: 70px">SKS</th>
                            <th style="width: 90px">Semester</th>
                            <th>Kurikulum</th>
                            <th style="width: 100px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($subjects as $s)
                        <tr>
                            <td><code>{{ $s->code }}</code></td>
                            <td><strong>{{ $s->name }}</strong></td>
                            <td>{{ $s->sks }} SKS</td>
                            <td>Semester {{ $s->semester }}</td>
                            <td><span class="badge bg-light text-dark border">{{ $s->curriculum->name }}</span></td>
                            <td>
                                <a href="{{ route('subjects.edit', $s->id) }}" class="btn btn-sm btn-outline-primary me-1">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('subjects.destroy', $s->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus mata kuliah ini?')">
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
                                <i class="fas fa-book-open fa-2x mb-2 d-block"></i>
                                Belum ada mata kuliah. <a href="{{ route('subjects.create') }}">Tambah sekarang</a>.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @if(method_exists($subjects, 'links'))
        <div class="d-flex justify-content-center mt-4">
            {{ $subjects->links() }}
        </div>
    @endif
</div>
@endsection
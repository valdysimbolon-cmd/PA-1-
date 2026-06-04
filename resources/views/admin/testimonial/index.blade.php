@extends('layouts.admin')

@section('title', 'Manajemen Testimoni')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 text-gray-800">Manajemen Testimoni</h1>
            <p class="text-muted small">Daftar testimoni alumni/mahasiswa</p>
        </div>
        <a href="{{ route('testimonials.create') }}" class="btn btn-success btn-sm shadow-sm">
            <i class="fas fa-plus me-1"></i> Testimoni Baru
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3" style="background-color: #200F07;">
            <h6 class="m-0 font-weight-bold" style="color: #C5E384;">Daftar Testimoni Alumni</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 70px">Foto</th>
                            <th>Nama & Angkatan</th>
                            <th>Pekerjaan</th>
                            <th>Testimoni</th>
                            <th style="width: 80px">Status</th>
                            <th style="width: 100px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($testimonials as $t)
                        <tr>
                            <td>
                                @if($t->photo)
                                    <img src="{{ asset('storage/'.$t->photo) }}" class="rounded-circle" width="45" height="45" style="object-fit: cover;">
                                @else
                                    <div class="bg-secondary rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                                        <i class="fas fa-user fa-sm text-white"></i>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <strong>{{ $t->name }}</strong><br>
                                <small class="text-muted">Angkatan {{ $t->batch }}</small>
                            </td>
                            <td>{{ $t->position ?? '-' }}</td>
                            <td>
                                <span class="text-muted">{{ Str::limit($t->content, 80) }}</span>
                            </td>
                            <td>
                                @if($t->active)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">Nonaktif</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('testimonials.edit', $t->id) }}" class="btn btn-sm btn-outline-primary me-1">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('testimonials.destroy', $t->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus testimoni ini?')">
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
                                <i class="fas fa-comment-slash fa-2x mb-2 d-block"></i>
                                Belum ada testimoni. <a href="{{ route('testimonials.create') }}">Tambah sekarang</a>.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @if(method_exists($testimonials, 'links'))
        <div class="d-flex justify-content-center mt-4">
            {{ $testimonials->links() }}
        </div>
    @endif
</div>
@endsection
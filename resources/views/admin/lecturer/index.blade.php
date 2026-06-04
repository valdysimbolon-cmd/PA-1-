@extends('layouts.admin')

@section('title', 'Daftar Dosen & Staff')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 text-gray-800">Manajemen Dosen & Staff</h1>
            <p class="text-muted small">Kelola data dosen, tenaga pendidik, dan staf administrasi</p>
        </div>
        <a href="{{ route('lecturers.create') }}" class="btn btn-success btn-sm shadow-sm">
            <i class="fas fa-plus me-1"></i> Personel Baru
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3" style="background-color: #200F07;">
            <h6 class="m-0 font-weight-bold" style="color: #C5E384;">Database Personel Teknik Bioproses</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Identitas</th>
                            <th>Jabatan & Golongan</th>
                            <th>Email & Kantor</th>
                            <th>Atasan</th>
                            <th style="width: 80px">Status</th>
                            <th style="width: 100px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($lecturers as $l)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    @if($l->image)
                                        <img src="{{ asset('storage/' . $l->image) }}" class="rounded-circle me-2" width="45" height="45" style="object-fit: cover;">
                                    @else
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($l->name) }}&background=C5E384&color=200F07" class="rounded-circle me-2" width="45">
                                    @endif
                                    <div>
                                        <div class="fw-bold">{{ $l->name }}</div>
                                        <small class="text-muted">{{ $l->nip_nidn }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-primary">{{ $l->academic_position }}</span>
                                @if($l->structural_position)
                                    <br><small class="text-muted">{{ $l->structural_position }}</small>
                                @endif
                            </td>
                            <td>
                                <small><i class="fas fa-envelope me-1"></i> {{ $l->email }}</small>
                                @if($l->office)
                                    <br><small><i class="fas fa-building me-1"></i> {{ $l->office }}</small>
                                @endif
                            </td>
                            <td>
                                @if($l->leader)
                                    <span class="small fw-semibold">{{ $l->leader->name }}</span>
                                @else
                                    <span class="text-muted small"><i>Pimpinan Tertinggi</i></span>
                                @endif
                            </td>
                            <td>
                                @if($l->active)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">Nonaktif</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('lecturers.edit', $l->id) }}" class="btn btn-sm btn-outline-primary me-1">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('lecturers.destroy', $l->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data personel ini?')">
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
                                <i class="fas fa-users fa-2x mb-2 d-block"></i>
                                Belum ada data personel. <a href="{{ route('lecturers.create') }}">Tambah sekarang</a>.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @if(method_exists($lecturers, 'links'))
        <div class="d-flex justify-content-center mt-4">
            {{ $lecturers->links() }}
        </div>
    @endif
</div>
@endsection
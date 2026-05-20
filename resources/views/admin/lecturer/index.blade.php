@extends('layouts.admin')

@section('title', 'Daftar Dosen & Staff')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Manajemen Dosen & Staff</h1>
    <a href="{{ route('lecturers.create') }}" class="btn btn-sm shadow-sm" style="background-color: #C5E384; color: #200F07; font-weight: bold;">
        <i class="fas fa-plus fa-sm"></i> Tambah Personel Baru
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3" style="background-color: #200F07;">
        <h6 class="m-0 font-weight-bold" style="color: #C5E384;">Database Personel Teknik Bioproses</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover" width="100%" cellspacing="0">
                <thead class="thead-light">
                    <tr>
                        <th>Foto</th>
                        <th>NIP/NIDN</th>
                        <th>Nama Lengkap</th>
                        <th>Jabatan Struktur</th>
                        <th>Status</th>
                        <th>Aksi</th>
                        <th>Atasan / Leader</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($lecturers as $lecturer)
                    <tr>
                        <td>
                            @if($lecturer->image)
                                <img src="{{ asset('storage/' . $lecturer->image) }}" class="rounded-circle" width="40" height="40" style="object-fit: cover;">
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($lecturer->name) }}&background=C5E384&color=200F07" class="rounded-circle" width="40">
                            @endif
                        </td>
                        <td><small class="font-weight-bold">{{ $lecturer->nip_nidn }}</small></td>
                        <td>{{ $lecturer->name }}</td>
                        <td><span class="badge badge-info">{{ $lecturer->structural_position ?? 'Dosen Pengajar' }}</span></td>
                        <td>
                            @if($lecturer->active)
                                <span class="badge badge-success">Aktif</span>
                            @else
                                <span class="badge badge-secondary">Non-Aktif</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('lecturers.edit', $lecturer->id) }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('lecturers.destroy', $lecturer->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>

                        <td>
                            @if($lecturer->leader)
                                <span class="badge badge-light border text-dark">
                                    <i class="fas fa-user-tie mr-1"></i>{{ $lecturer->leader->name }}
                                </span>
                            @else
                                <span class="text-muted small"><i>Pimpinan Tertinggi</i></span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">Belum ada data dosen atau staff.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
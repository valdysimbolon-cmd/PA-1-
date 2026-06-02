@extends('layouts.admin')

@section('title', 'Daftar Dosen & Staff')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manajemen Dosen & Staff</h1>
        <a href="{{ route('lecturers.create') }}" class="btn btn-sm shadow-sm" style="background-color: #C5E384; color: #200F07; font-weight: bold;">
            <i class="fas fa-plus fa-sm"></i> Tambah Personel Baru
        </a>
    </div>

    <!-- Tabel Database -->
    <div class="card shadow mb-4">
        <div class="card-header py-3" style="background-color: #200F07;">
            <h6 class="m-0 font-weight-bold" style="color: #C5E384;">Database Personel Teknik Bioproses</h6>
        </div>
        <div class="card-body text-dark">
            <div class="table-responsive">
                <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th>Identitas</th>
                            <th>Jabatan & Golongan</th>
                            <th>Email & Kantor</th>
                            <th>Atasan</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($lecturers as $l)
                        <tr>
                            <td class="d-flex align-items-center">
                                @if($l->image)
                                    <img src="{{ asset('storage/' . $l->image) }}" class="rounded-circle mr-2" width="45" height="45" style="object-fit: cover;">
                                @else
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($l->name) }}&background=C5E384&color=200F07" class="rounded-circle mr-2" width="45">
                                @endif
                                <div>
                                    <div class="font-weight-bold">{{ $l->name }}</div>
                                    <small class="text-muted">{{ $l->nip_nidn }}</small>
                                </div>
                            </td>
                            <td>
                                <span class="badge badge-primary">{{ $l->academic_position }}</span><br>
                                <small class="text-muted">{{ $l->structural_position ?? '-' }}</small>
                            </td>
                            <td>
                                <small><i class="fas fa-envelope mr-1"></i> {{ $l->email }}</small><br>
                                <small><i class="fas fa-building mr-1"></i> {{ $l->office ?? '-' }}</small>
                            </td>
                            <td>
                                @if($l->leader)
                                    <span class="small font-weight-bold text-dark">{{ $l->leader->name }}</span>
                                @else
                                    <span class="text-muted small"><i>Pimpinan Tertinggi</i></span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($l->active)
                                    <span class="badge badge-success">Aktif</span>
                                @else
                                    <span class="badge badge-secondary">Sembunyi</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('lecturers.edit', $l->id) }}" class="btn btn-sm btn-info shadow-sm"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('lecturers.destroy', $l->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus data ini?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger shadow-sm"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">Belum ada data personel.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
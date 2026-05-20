@extends('layouts.admin')

@section('title', 'Daftar Mata Kuliah')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manajemen Mata Kuliah</h1>
        <a href="{{ route('subjects.create') }}" class="btn btn-sm shadow-sm" style="background-color: #C5E384; color: #200F07; font-weight: bold;">
            <i class="fas fa-plus fa-sm"></i> Tambah Matkul Baru
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3" style="background-color: #200F07;">
            <h6 class="m-0 font-weight-bold" style="color: #C5E384;">Daftar Semua Mata Kuliah Prodi</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Nama Mata Kuliah</th>
                            <th>SKS</th>
                            <th>Semester</th>
                            <th>Kurikulum</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($subjects as $subject)
                        <tr>
                            <td><code>{{ $subject->code }}</code></td>
                            <td>{{ $subject->name }}</td>
                            <td>{{ $subject->sks }}</td>
                            <td>{{ $subject->semester }}</td>
                            <td><span class="badge badge-light border">{{ $subject->curriculum->name }}</span></td>
                            <td>
                                <span class="badge {{ $subject->active ? 'badge-success' : 'badge-secondary' }}">
                                    {{ $subject->active ? 'Aktif' : 'Non-Aktif' }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('subjects.edit', $subject->id) }}" class="btn btn-sm btn-info btn-circle"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('subjects.destroy', $subject->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus matkul ini?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger btn-circle"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">Belum ada data mata kuliah.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
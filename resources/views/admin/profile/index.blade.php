@extends('layouts.admin')

@section('title', 'Manajemen Profil')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Profil & Sejarah Prodi</h1>
    <a href="{{ route('profiles.create') }}" class="btn btn-sm shadow-sm" style="background-color: #C5E384; color: #200F07;">
        <i class="fas fa-plus fa-sm"></i> Tambah Profil Baru
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3" style="background-color: #200F07;">
        <h6 class="m-0 font-weight-bold" style="color: #C5E384;">Daftar Konten Profil</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Key (ID Sistem)</th>
                        <th>Judul (Nama)</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($profiles as $profile)
                    <tr>
                        <td><code>{{ $profile->key }}</code></td>
                        <td>{{ $profile->name }}</td>
                        <td>
                            <span class="badge {{ $profile->active ? 'badge-success' : 'badge-secondary' }}">
                                {{ $profile->active ? 'Aktif' : 'Disembunyikan' }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('profiles.edit', $profile->id) }}" class="btn btn-info btn-circle btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('profiles.destroy', $profile->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-circle btn-sm">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
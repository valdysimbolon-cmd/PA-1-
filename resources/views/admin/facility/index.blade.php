@extends('layouts.admin')

@section('title', 'Ruangan & Sarana')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manajemen Ruangan & Sarana</h1>
        <a href="{{ route('facilities.create') }}" class="btn btn-sm shadow-sm" style="background-color: #C5E384; color: #200F07; font-weight:bold;">
            <i class="fas fa-plus fa-sm"></i> Tambah Ruangan
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3" style="background-color: #200F07;">
            <h6 class="m-0 font-weight-bold" style="color: #C5E384;">Daftar Prasarana Prodi</h6>
        </div>
        <div class="card-body text-dark small">
            <div class="table-responsive">
                <table class="table table-hover" id="dataTable" width="100%">
                    <thead class="thead-light">
                        <tr>
                            <th>Foto</th>
                            <th>Nama Ruangan</th>
                            <th>Tipe</th>
                            <th>Kapasitas</th>
                            <th>Lokasi</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($facilities as $f)
                        <tr>
                            <td>
                                <img src="{{ $f->image ? asset('storage/'.$f->image) : 'https://placehold.co/100x60?text=No+Img' }}" 
                                     width="80" class="rounded shadow-sm">
                            </td>
                            <td><strong>{{ $f->name }}</strong></td>
                            <td><span class="badge badge-info">{{ $f->type }}</span></td>
                            <td>{{ $f->capacity ?? '-' }} Org</td>
                            <td>{{ $f->location }}</td>
                            <td class="text-center">
                                {!! $f->active ? '<span class="badge badge-success">Aktif</span>' : '<span class="badge badge-secondary">Draf</span>' !!}
                            </td>
                            <td class="text-center">
                                <a href="{{ route('facilities.edit', $f->id) }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('facilities.destroy', $f->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus data?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
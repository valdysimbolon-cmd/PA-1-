@extends('layouts.admin')

@section('title', 'Manajemen Unit Lab')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manajemen Unit Laboratorium</h1>
        <a href="{{ route('labs.create') }}" class="btn btn-sm shadow-sm" style="background-color: #C5E384; color: #200F07; font-weight: bold;">
            <i class="fas fa-plus fa-sm"></i> Tambah Lab Baru
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3" style="background-color: #200F07;">
            <h6 class="m-0 font-weight-bold" style="color: #C5E384;">Daftar Unit Laboratorium</h6>
        </div>
        <div class="card-body text-dark small">
            <div class="table-responsive">
                <table class="table table-hover" id="dataTable" width="100%">
                    <thead class="thead-light">
                        <tr>
                            <th>Foto</th>
                            <th>Nama Laboratorium</th>
                            <th>Kategori</th>
                            <th>Kepala Lab</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($labs as $lab)
                        <tr>
                            <td>
                                @if($lab->image)
                                    <img src="{{ asset('storage/' . $lab->image) }}" class="rounded shadow-sm" width="80" height="50" style="object-fit: cover;">
                                @else
                                    <div class="bg-light rounded text-center pt-2" style="width:80px; height:50px;">No Pic</div>
                                @endif
                            </td>
                            <td>
                                <div class="font-weight-bold">{{ $lab->name }}</div>
                                <div class="text-muted small">Status: {{ $lab->active ? 'Aktif' : 'Draft' }}</div>
                            </td>
                            <td><span class="badge badge-info">{{ $lab->category }}</span></td>
                            <td>{{ $lab->head->name ?? 'Belum Ditentukan' }}</td>
                            <td class="text-center">
                                <a href="{{ route('labs.edit', $lab->id) }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('labs.destroy', $lab->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus unit lab ini?')">
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
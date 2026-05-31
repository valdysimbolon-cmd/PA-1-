@extends('layouts.admin')
@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Ruangan & Sarana</h1>
        <a href="{{ route('facilities.create') }}" class="btn btn-sm shadow-sm" style="background-color: #C5E384; color: #200F07; font-weight:bold;">+ Tambah Ruangan</a>
    </div>
    <div class="card shadow">
        <div class="card-body">
            <table class="table table-hover">
                <thead><tr><th>Foto</th><th>Nama Ruangan</th><th>Tipe</th><th>Lokasi</th><th>Aksi</th></tr></thead>
                <tbody>
                    @foreach($facilities as $f)
                    <tr>
                        <td><img src="{{ asset('storage/'.$f->image) }}" width="60" class="rounded"></td>
                        <td>{{ $f->name }}</td>
                        <td><span class="badge badge-primary">{{ $f->type }}</span></td>
                        <td>{{ $f->location }}</td>
                        <td><a href="{{ route('facilities.edit', $f->id) }}" class="btn btn-sm btn-info"><i class="fas fa-edit"></i></a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
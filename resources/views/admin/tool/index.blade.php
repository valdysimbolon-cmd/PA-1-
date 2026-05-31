@extends('layouts.admin')
@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Katalog Alat & Bahan</h1>
        <a href="{{ route('tools.create') }}" class="btn btn-sm shadow-sm" style="background-color: #C5E384; color: #200F07; font-weight: bold;">+ Tambah Alat</a>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3" style="background-color: #200F07;"><h6 class="m-0 font-weight-bold" style="color: #C5E384;">Daftar Inventaris</h6></div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead><tr><th>Foto</th><th>Kode</th><th>Nama</th><th>Lab</th><th>Stok</th><th>Aksi</th></tr></thead>
                    <tbody>
                        @foreach($tools as $tool)
                        <tr>
                            <td><img src="{{ asset('storage/'.$tool->image) }}" width="50" class="rounded"></td>
                            <td><code>{{ $tool->code }}</code></td>
                            <td>{{ $tool->name }}</td>
                            <td>{{ $tool->lab->name }}</td>
                            <td>{{ $tool->stock_total }} {{ $tool->unit }}</td>
                            <td>
                                <a href="{{ route('tools.edit', $tool->id) }}" class="btn btn-sm btn-info btn-circle"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('tools.destroy', $tool->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger btn-circle" onclick="return confirm('Hapus?')"><i class="fas fa-trash"></i></button>
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
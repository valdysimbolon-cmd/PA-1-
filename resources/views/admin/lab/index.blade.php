@extends('layouts.admin')
@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Unit Laboratorium</h1>
        <a href="{{ route('labs.create') }}" class="btn btn-sm shadow-sm" style="background-color: #C5E384; color: #200F07; font-weight:bold;">+ Tambah Lab</a>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3" style="background-color: #200F07;"><h6 class="m-0 font-weight-bold" style="color: #C5E384;">Daftar Unit</h6></div>
        <div class="card-body">
            <table class="table table-hover">
                <thead><tr><th>Nama Lab</th><th>Kepala Lab</th><th>Staf PIC</th><th>Kategori</th><th>Aksi</th></tr></thead>
                <tbody>
                    @foreach($labs as $lab)
                    <tr>
                        <td><strong>{{ $lab->name }}</strong></td>
                        <td>{{ $lab->head->name ?? '-' }}</td>
                        <td><span class="badge badge-light border">{{ $lab->staff->name ?? '-' }}</span></td>
                        <td>{{ $lab->category }}</td>
                        <td>
                            <a href="{{ route('labs.edit', $lab->id) }}" class="btn btn-sm btn-info btn-circle"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('labs.destroy', $lab->id) }}" method="POST" class="d-inline">@csrf @method('DELETE')<button class="btn btn-sm btn-danger btn-circle"><i class="fas fa-trash"></i></button></form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
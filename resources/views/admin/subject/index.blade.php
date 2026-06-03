@extends('layouts.admin')
@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manajemen Mata Kuliah</h1>
        <a href="{{ route('subjects.create') }}" class="btn btn-sm shadow-sm" style="background-color: #C5E384; color: #200F07; font-weight: bold;">+ Tambah Mata Kuliah</a>
    </div>
    <div class="card shadow">
        <div class="card-body text-dark small">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable">
                    <thead class="thead-light">
                        <tr>
                            <th>Kode</th><th>Nama Mata Kuliah</th><th>SKS</th><th>SMT</th><th>Kurikulum</th><th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($subjects as $s)
                        <tr>
                            <td><code>{{ $s->code }}</code></td>
                            <td>{{ $s->name }}</td>
                            <td>{{ $s->sks }}</td>
                            <td>Semester {{ $s->semester }}</td>
                            <td><span class="badge badge-light border">{{ $s->curriculum->name }}</span></td>
                            <td>
                                <a href="{{ route('subjects.edit', $s->id) }}" class="btn btn-sm btn-info"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('subjects.destroy', $s->id) }}" method="POST" class="d-inline">@csrf @method('DELETE')<button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button></form>
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
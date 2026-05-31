@extends('layouts.admin')
@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manajemen Testimoni</h1>
        <a href="{{ route('testimonials.create') }}" class="btn btn-sm shadow-sm" style="background-color: #C5E384; color: #200F07; font-weight: bold;">Tambah Baru</a>
    </div>
    <div class="card shadow">
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Foto</th>
                        <th>Nama (Angkatan)</th>
                        <th>Testimoni</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($testimonials as $t)
                    <tr>
                        <td><img src="{{ asset('storage/'.$t->photo) }}" width="50" class="rounded-circle"></td>
                        <td>{{ $t->name }} ({{ $t->batch }})</td>
                        <td>{{ \Illuminate\Support\Str::limit($t->content, 50) }}</td>
                        <td>
                            <a href="{{ route('testimonials.edit', $t->id) }}" class="btn btn-sm btn-info btn-circle"><i class="fas fa-edit"></i></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Daftar Prestasi</h1>
        <a href="{{ route('achievements.create') }}" class="btn btn-sm shadow-sm" style="background-color: #C5E384; color: #200F07; font-weight: bold;">+ Tambah</a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th>Visual</th>
                            <th>Info Prestasi</th>
                            <th>Tingkat</th>
                            <th>Kategori</th>
                            <th>Tahun</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($achievements as $a)
                        <tr>
                            <td><img src="{{ $a->image ? asset('storage/'.$a->image) : 'https://placehold.co/100x60?text=Piala' }}" width="60" class="rounded shadow-sm"></td>
                            <td>
                                <strong>{{ $a->title }}</strong><br>
                                <small class="text-success fw-bold">{{ $a->winner_name }} ({{ $a->rank }})</small>
                            </td>
                            <td><span class="badge badge-light border">{{ $a->level }}</span></td>
                            <td>
                                <span class="badge {{ $a->category == 'students' ? 'badge-primary' : 'badge-info' }}">
                                    {{ strtoupper($a->category) }}
                                </span>
                            </td>
                            <td>{{ $a->year }}</td>
                            <td class="text-center">
                                <a href="{{ route('achievements.edit', $a->id) }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('achievements.destroy', $a->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus?')"><i class="fas fa-trash"></i></button>
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
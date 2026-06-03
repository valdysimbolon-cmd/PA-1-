@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manajemen Publikasi Karya</h1>
        <a href="{{ route('publications.create') }}" class="btn btn-sm shadow-sm" style="background-color: #C5E384; color: #200F07; font-weight: bold;">
            <i class="fas fa-plus fa-sm"></i> Tambah Publikasi
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3" style="background-color: #200F07;">
            <h6 class="m-0 font-weight-bold" style="color: #C5E384;">Daftar Seluruh Karya Ilmiah & Penelitian</h6>
        </div>
        <div class="card-body text-dark small">
            <div class="table-responsive">
                <table class="table table-hover" id="dataTable" width="100%">
                    <thead class="thead-light">
                        <tr>
                            <th>Judul & Penerbit</th>
                            <th>Penulis (Dosen/Staff)</th>
                            <th>Tipe</th>
                            <th class="text-center">Tahun</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($publications as $p)
                        <tr>
                            <td>
                                <div class="font-weight-bold text-primary">{{ $p->title }}</div>
                                <div class="text-muted italic">{{ $p->publisher ?? '-' }}</div>
                            </td>
                            <td>
                                @foreach($p->authors as $auth)
                                    <span class="badge badge-light border text-dark mb-1">
                                        {{ $auth->lecturer?->name ?? 'Dosen tidak ditemukan' }}
<small>({{ $auth->position }})</small>
                                    </span><br>
                                @endforeach
                            </td>
                            <td><span class="badge badge-info">{{ $p->type }}</span></td>
                            <td class="text-center">{{ $p->year }}</td>
                            <td class="text-center">
                                <a href="{{ route('publications.edit', $p->id) }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('publications.destroy', $p->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus karya ini?')">
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
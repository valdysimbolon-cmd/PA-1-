@extends('layouts.admin')
@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manajemen Dokumen & SOP</h1>
        <a href="{{ route('document_archives.create') }}" class="btn btn-sm shadow-sm" style="background-color: #C5E384; color: #200F07; font-weight: bold;">+ Tambah Dokumen</a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3" style="background-color: #200F07;">
            <h6 class="m-0 font-weight-bold" style="color: #C5E384;">Daftar Arsip Digital</h6>
        </div>
        <div class="card-body text-dark small">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Judul Dokumen</th>
                            <th>Kategori</th>
                            <th>Tahun</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($documents as $doc)
                        <tr>
                            <td><strong>{{ $doc->title }}</strong></td>
                            <td><span class="badge badge-info">{{ $doc->category }}</span></td>
                            <td>{{ $doc->year ?? '-' }}</td>
                            <td>
                                <a href="{{ asset('storage/'.$doc->file_path) }}" target="_blank" class="btn btn-sm btn-light border">Lihat</a>
                                <a href="{{ route('document_archives.edit', $doc->id) }}" class="btn btn-sm btn-info">Edit</a>
                                <form action="{{ route('document_archives.destroy', $doc->id) }}" method="POST" class="d-inline">@csrf @method('DELETE')<button class="btn btn-sm btn-danger">Hapus</button></form>
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
@extends('layouts.admin')
@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Arsip Dokumen & SOP</h1>
        <a href="{{ route('document_archives.create') }}" class="btn btn-sm shadow-sm" style="background-color: #C5E384; color: #200F07; font-weight: bold;">+ Upload Dokumen</a>
    </div>
    <div class="card shadow mb-4">
        <div class="card-body text-dark small">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th>Judul Dokumen</th>
                            <th>Kategori</th>
                            <th>Tahun</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($documents as $doc)
                        <tr>
                            <td>
                                <i class="fas fa-file-pdf text-danger mr-2"></i><strong>{{ $doc->title }}</strong>
                            </td>
                            <td><span class="badge badge-info">{{ $doc->category }}</span></td>
                            <td>{{ $doc->year ?? '-' }}</td>
                            <td>{!! $doc->active ? '<span class="badge badge-success">Publik</span>' : '<span class="badge badge-secondary">Draft</span>' !!}</td>
                            <td class="text-center">
                                <a href="{{ asset('storage/'.$doc->file_path) }}" target="_blank" class="btn btn-sm btn-light border"><i class="fas fa-download"></i></a>
                                <a href="{{ route('document_archives.edit', $doc->id) }}" class="btn btn-sm btn-info"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('document_archives.destroy', $doc->id) }}" method="POST" class="d-inline">@csrf @method('DELETE')<button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button></form>
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
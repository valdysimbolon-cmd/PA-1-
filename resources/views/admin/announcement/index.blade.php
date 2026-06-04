@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manajemen Pengumuman</h1>
        <a href="{{ route('announcements.create') }}" class="btn btn-sm shadow-sm" style="background-color: #C5E384; color: #200F07; font-weight: bold;">
            <i class="fas fa-plus fa-sm"></i> Pengumuman Baru
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body text-dark small">
            <div class="table-responsive">
                <table class="table table-hover" id="dataTable" width="100%">
                    <thead class="thead-light">
                        <tr>
                            <th>Status</th>
                            <th>Judul Pengumuman</th>
                            <th>Kategori</th>
                            <th>Lampiran</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($announcements as $ann)
                        <tr>
                            <td>
                                @if($ann->is_urgent)
                                    <span class="badge badge-danger">URGENT</span>
                                @else
                                    <span class="badge badge-info">INFO</span>
                                @endif
                            </td>
                            <td>
                                <strong>{{ $ann->title }}</strong><br>
                                <small class="text-muted">Exp: {{ $ann->expired_at ? $ann->expired_at->format('d/m/Y') : 'Selamanya' }}</small>
                            </td>
                            <td>{{ $ann->category->name ?? 'Tanpa Kategori' }}</td>
                            <td class="text-center">
                                @if($ann->attachment_file)
                                    <i class="fas fa-file-alt text-success"></i>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('announcements.edit', $ann->id) }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('announcements.destroy', $ann->id) }}" method="POST" class="d-inline">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button></form>
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
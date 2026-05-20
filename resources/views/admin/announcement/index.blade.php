@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Mading Pengumuman</h1>
        <a href="{{ route('announcements.create') }}" class="btn btn-sm shadow-sm" style="background-color: #C5E384; color: #200F07; font-weight: bold;">
            <i class="fas fa-bullhorn fa-sm"></i> Buat Pengumuman Baru
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3" style="background-color: #200F07;">
            <h6 class="m-0 font-weight-bold" style="color: #C5E384;">Daftar Pengumuman Aktif</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Status</th>
                            <th>Judul Pengumuman</th>
                            <th>Lampiran</th>
                            <th>Berlaku Sampai</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($announcements as $info)
                        <tr class="{{ $info->is_urgent ? 'table-warning' : '' }}">
                            <td>
                                @if($info->is_urgent)
                                    <span class="badge badge-danger"><i class="fas fa-exclamation-circle"></i> URGENT</span>
                                @else
                                    <span class="badge badge-primary">Biasa</span>
                                @endif
                            </td>
                            <td>
                                <strong>{{ $info->title }}</strong><br>
                                <small class="text-muted">Post: {{ $info->created_at->format('d/m/Y') }}</small>
                            </td>
                            <td>
                                @if($info->attachment_file)
                                    <a href="{{ asset('storage/' . $info->attachment_file) }}" target="_blank" class="btn btn-sm btn-light border">
                                        <i class="fas fa-file-download text-danger"></i> Lihat File
                                    </a>
                                @else
                                    <span class="text-muted small">Tidak ada lampiran</span>
                                @endif
                            </td>
                            <td>{{ $info->expired_at ? $info->expired_at->format('d M Y') : 'Selamanya' }}</td>
                            <td>
                                <a href="{{ route('announcements.edit', $info->id) }}" class="btn btn-sm btn-info"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('announcements.destroy', $info->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
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
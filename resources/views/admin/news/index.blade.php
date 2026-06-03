@extends('layouts.admin')

@section('title', 'Daftar Berita & Kegiatan')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manajemen Berita</h1>
        <a href="{{ route('news.create') }}" class="btn btn-sm shadow-sm" style="background-color: #C5E384; color: #200F07; font-weight: bold;">
            <i class="fas fa-plus fa-sm"></i> Tulis Berita Baru
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3" style="background-color: #200F07;">
            <h6 class="m-0 font-weight-bold" style="color: #C5E384;">Daftar Seluruh Berita & Kegiatan</h6>
        </div>
        <div class="card-body text-dark">
            <div class="table-responsive">
                <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th>Gambar</th>
                            <th>Judul Berita</th>
                            <th>Kategori</th>
                            <th>Tanggal Terbit</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($news as $item)
                        <tr>
                            <td>
                                @if($item->image)
                                    <img src="{{ asset('storage/' . $item->image) }}" class="rounded shadow-sm" width="70" height="45" style="object-fit: cover;">
                                @else
                                    <div class="bg-light rounded text-center pt-2 small" style="width:70px; height:45px;">No Pic</div>
                                @endif
                            </td>
                            <td>
                                <div class="font-weight-bold">{{ Str::limit($item->title, 60) }}</div>
                                <small class="text-muted">Ditulis oleh: {{ $item->creator->name ?? 'Admin' }}</small>
                            </td>
                            <td><span class="badge badge-info">{{ $item->category->name }}</span></td>
                            <td>{{ date('d M Y', strtotime($item->published_at)) }}</td>
                            <td class="text-center">
                                @if($item->active)
                                    <span class="badge badge-success">Terbit</span>
                                @else
                                    <span class="badge badge-secondary">Draf</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('news.edit', $item->id) }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('news.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus berita ini?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">Belum ada berita.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@extends('layouts.admin')

@section('title', 'Kategori Berita')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Kategori Berita</h1>
    </div>

    <div class="row">
        <!-- FORM TAMBAH (Kiri) -->
        <div class="col-md-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3" style="background-color: #200F07;">
                    <h6 class="m-0 font-weight-bold" style="color: #C5E384;">Tambah Kategori</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('news_categories.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label class="font-weight-bold">Nama Kategori</label>
                            <input type="text" name="name" class="form-control" placeholder="Contoh: Pengumuman" required>
                        </div>
                        <button type="submit" class="btn btn-block shadow-sm" style="background-color: #C5E384; color: #200F07; font-weight: bold;">
                            <i class="fas fa-plus mr-1"></i> Simpan Kategori
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- TABEL DAFTAR (Kanan) -->
        <div class="col-md-8">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Nama Kategori</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($categories as $cat)
                                <tr>
                                    <td><strong>{{ $cat->name }}</strong></td>
                                    <td>
                                        <span class="badge {{ $cat->active ? 'badge-success' : 'badge-secondary' }}">
                                            {{ $cat->active ? 'Aktif' : 'Non-Aktif' }}
                                        </span>
                                    </td>
                                    <td>
                                        <form action="{{ route('news_categories.destroy', $cat->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus kategori ini?')">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-danger btn-circle"><i class="fas fa-trash"></i></button>
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
    </div>
</div>
@endsection
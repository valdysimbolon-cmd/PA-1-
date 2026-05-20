@extends('layouts.admin')

@section('title', 'Edit Mitra: ' . $cooperation->name)

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3" style="background-color: #200F07;">
            <h6 class="m-0 font-weight-bold" style="color: #C5E384;">Edit Data Mitra: {{ $cooperation->name }}</h6>
        </div>
        <div class="card-body">
            <!-- 1. Form Action mengarah ke UPDATE dengan ID -->
            <form action="{{ route('cooperations.update', $cooperation->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <!-- 2. WAJIB TAMBAHKAN @method('PUT') -->
                @method('PUT')

                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label class="font-weight-bold">Nama Instansi/Perusahaan</label>
                            <!-- 3. Tambahkan VALUE dari data lama -->
                            <input type="text" name="name" class="form-control" value="{{ old('name', $cooperation->name) }}" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="font-weight-bold">Tipe Kerjasama</label>
                            <select name="type" class="form-control" required>
                                <option value="Industri" {{ $cooperation->type == 'Industri' ? 'selected' : '' }}>Industri</option>
                                <option value="Akademik" {{ $cooperation->type == 'Akademik' ? 'selected' : '' }}>Akademik</option>
                                <option value="Pemerintah" {{ $cooperation->type == 'Pemerintah' ? 'selected' : '' }}>Pemerintah</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold">Tanggal Mulai</label>
                            <input type="date" name="start_date" class="form-control" value="{{ $cooperation->start_date }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold">Tanggal Berakhir</label>
                            <input type="date" name="end_date" class="form-control" value="{{ $cooperation->end_date }}">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="font-weight-bold">Website Resmi (URL)</label>
                    <input type="url" name="website_url" class="form-control" value="{{ $cooperation->website_url }}">
                </div>

                <div class="form-group">
                    <label class="font-weight-bold">Logo Saat Ini</label><br>
                    @if($cooperation->logo)
                        <img src="{{ asset('storage/' . $cooperation->logo) }}" width="100" class="img-thumbnail mb-2">
                    @else
                        <span class="text-muted">Tidak ada logo</span>
                    @endif
                    <input type="file" name="logo" class="form-control-file border p-1 rounded w-100" id="imageInput">
                    <img id="preview" src="#" class="mt-2 d-none img-thumbnail" width="120">
                </div>

                <div class="custom-control custom-switch p-3 border rounded mb-4 bg-light">
                    <input type="checkbox" class="custom-control-input" id="active" name="active" value="1" {{ $cooperation->active ? 'checked' : '' }}>
                    <label class="custom-control-label font-weight-bold text-success" for="active" style="cursor:pointer;">Tampilkan di Website</label>
                </div>

                <button type="submit" class="btn shadow-sm" style="background-color: #C5E384; color: #200F07; font-weight: bold;">
                    <i class="fas fa-save mr-1"></i> Simpan Perubahan
                </button>
                <a href="{{ route('cooperations.index') }}" class="btn btn-secondary border">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection
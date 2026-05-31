@extends('layouts.admin')

@section('title', 'Tambah Unit Lab')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Unit Laboratorium</h1>
        <a href="{{ route('labs.index') }}" class="btn btn-secondary btn-sm shadow-sm">
            <i class="fas fa-arrow-left fa-sm"></i> Kembali
        </a>
    </div>

    <div class="card shadow mb-4 border-bottom-success">
        <div class="card-header py-3" style="background-color: #200F07;">
            <h6 class="m-0 font-weight-bold" style="color: #C5E384;">Formulir Unit Lab Baru</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('labs.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label class="font-weight-bold text-dark">Nama Laboratorium</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                   placeholder="Contoh: Lab Mikrobiologi & Genetika" value="{{ old('name') }}" required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="font-weight-bold text-dark">Kategori Lab</label>
                            <select name="category" class="form-control" required>
                                <option value="Praktikum">Pendidikan / Praktikum</option>
                                <option value="Riset">Riset / Penelitian</option>
                                <option value="Umum">Fasilitas Umum</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <!-- Relasi ke Dosen (Kepala Lab) -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold text-primary"><i class="fas fa-user-tie mr-2"></i>Kepala Laboratorium (Dosen)</label>
                            <select name="head_of_lab_id" class="form-control">
                                <option value="">-- Pilih Dosen --</option>
                                @foreach($lecturers as $l)
                                    <option value="{{ $l->id }}">{{ $l->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <!-- Relasi ke User (Staf PIC) -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold text-success"><i class="fas fa-key mr-2"></i>Staf PIC / Admin Lab</label>
                            <select name="staff_id" class="form-control" required>
                                <option value="">-- Pilih Staf Pengelola --</option>
                                @foreach($staffs as $s)
                                    <option value="{{ $s->id }}">{{ $s->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group mt-3">
                    <label class="font-weight-bold text-dark">Lokasi Ruangan</label>
                    <input type="text" name="location" class="form-control" placeholder="Contoh: Gedung 5, Lantai 2" value="{{ old('location') }}">
                </div>

                <div class="form-group">
                    <label class="font-weight-bold text-dark">Foto Ruangan Lab</label>
                    <input type="file" name="image" id="imageInput" class="form-control-file border p-1 rounded w-100">
                    <div id="previewContainer" class="mt-3 d-none">
                        <img id="imagePreview" src="#" class="img-thumbnail" style="max-height: 200px; border: 2px solid #C5E384;">
                    </div>
                </div>

                <div class="custom-control custom-switch p-3 border rounded shadow-sm bg-light mt-4">
                    <input type="checkbox" class="custom-control-input" id="active" name="active" value="1" checked>
                    <label class="custom-control-label font-weight-bold text-success" for="active" style="cursor:pointer;">Unit Lab Aktif (Tampilkan di Web)</label>
                </div>

                <hr class="mt-4">
                <div class="text-right">
                    <button type="submit" class="btn shadow-sm px-5" style="background-color: #C5E384; color: #200F07; font-weight: bold; border: 1px solid #200F07;">
                        <i class="fas fa-save mr-2"></i>Simpan Unit Lab
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
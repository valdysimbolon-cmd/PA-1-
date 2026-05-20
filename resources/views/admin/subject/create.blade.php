@extends('layouts.admin')

@section('title', 'Tambah Mata Kuliah')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Input Mata Kuliah Baru</h1>
        <a href="{{ route('subjects.index') }}" class="btn btn-secondary btn-sm shadow-sm">
            <i class="fas fa-arrow-left fa-sm"></i> Batal & Kembali
        </a>
    </div>

    <!-- Alert Error Validasi -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow mb-4 border-bottom-success">
        <div class="card-header py-3" style="background-color: #200F07;">
            <h6 class="m-0 font-weight-bold" style="color: #C5E384;">Formulir Data Akademik</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('subjects.store') }}" method="POST">
                @csrf
                
                <div class="row">
                    <!-- Pilih Kurikulum -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold text-dark">Versi Kurikulum Induk</label>
                            <select name="curriculum_id" class="form-control @error('curriculum_id') is-invalid @enderror" required>
                                <option value="" disabled selected>-- Pilih Kurikulum --</option>
                                @foreach($curriculums as $curr)
                                    <option value="{{ $curr->id }}" {{ old('curriculum_id', request('curriculum_id')) == $curr->id ? 'selected' : '' }}>
                                        {{ $curr->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('curriculum_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <!-- Kode Matkul -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold text-dark">Kode Mata Kuliah</label>
                            <input type="text" name="code" class="form-control @error('code') is-invalid @enderror" 
                                   placeholder="Contoh: 32S1213" value="{{ old('code') }}" required>
                            @error('code') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>

                <div class="row mt-2">
                    <!-- Nama Matkul -->
                    <div class="col-md-8">
                        <div class="form-group">
                            <label class="font-weight-bold text-dark">Nama Mata Kuliah</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                   value="{{ old('name') }}" required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <!-- SKS -->
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="font-weight-bold text-dark">SKS</label>
                            <input type="number" name="sks" class="form-control @error('sks') is-invalid @enderror" 
                                   min="1" max="6" value="{{ old('sks') }}" required>
                        </div>
                    </div>

                    <!-- Semester -->
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="font-weight-bold text-dark">Semester</label>
                            <select name="semester" class="form-control">
                                <!-- PERBAIKAN TYPO $smt DI SINI -->
                                @foreach(range(1, 8) as $smt)
                                    <option value="{{ $smt }}" {{ old('semester') == $smt ? 'selected' : '' }}>
                                        {{ $smt }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Deskripsi -->
                <div class="form-group mt-3">
                    <label class="font-weight-bold text-dark">Deskripsi / Silabus Singkat (Opsional)</label>
                    <textarea name="description" class="form-control" rows="4">{{ old('description') }}</textarea>
                </div>

                <!-- Switch Active -->
                <div class="custom-control custom-switch p-3 border rounded shadow-sm bg-light mt-4">
                    <input type="checkbox" class="custom-control-input" id="active" name="active" value="1" {{ old('active', true) ? 'checked' : '' }}>
                    <label class="custom-control-label font-weight-bold text-success" for="active" style="cursor:pointer;">
                        Mata Kuliah Aktif (Tampilkan di Daftar)
                    </label>
                </div>

                <hr class="mt-4">

                <div class="text-right">
                    <button type="submit" class="btn shadow-sm px-5" style="background-color: #C5E384; color: #200F07; font-weight: bold; border: 1px solid #200F07;">
                        <i class="fas fa-save mr-2"></i>Simpan Mata Kuliah
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
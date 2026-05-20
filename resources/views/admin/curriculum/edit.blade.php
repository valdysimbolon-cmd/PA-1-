@extends('layouts.admin')

@section('title', 'Edit Kurikulum')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Versi Kurikulum</h1>
        <a href="{{ route('curriculums.index') }}" class="btn btn-secondary btn-sm shadow-sm">
            <i class="fas fa-arrow-left fa-sm"></i> Batal & Kembali
        </a>
    </div>

    <div class="card shadow mb-4 border-bottom-primary">
        <div class="card-header py-3" style="background-color: #200F07;">
            <h6 class="m-0 font-weight-bold" style="color: #C5E384;">Formulir Perubahan Kurikulum</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('curriculums.update', $curriculum->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label class="font-weight-bold text-dark">Nama Kurikulum</label>
                    <input type="text" name="name" 
                           class="form-control @error('name') is-invalid @enderror" 
                           value="{{ old('name', $curriculum->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="custom-control custom-switch p-3 border rounded shadow-sm bg-light">
                            <input type="checkbox" class="custom-control-input" id="active" name="active" value="1" {{ old('active', $curriculum->active) ? 'checked' : '' }}>
                            <label class="custom-control-label font-weight-bold text-primary" for="active" style="cursor:pointer;">
                                <i class="fas fa-check-circle mr-1"></i> Status: Kurikulum Aktif
                            </label>
                            <p class="small text-muted mb-0 ml-4">Gunakan saklar ini untuk mengarsipkan kurikulum lama.</p>
                        </div>
                    </div>
                </div>

                <hr class="mt-4">

                <div class="text-right">
                    <button type="submit" class="btn shadow-sm px-5" style="background-color: #C5E384; color: #200F07; font-weight: bold; border: 1px solid #200F07;">
                        <i class="fas fa-save mr-2"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
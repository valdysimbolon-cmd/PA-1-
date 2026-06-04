@extends('layouts.admin')

@section('title', 'Tambah Kurikulum')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header py-3" style="background-color: #200F07;">
                    <h6 class="m-0 font-weight-bold" style="color: #C5E384;">
                        <i class="fas fa-plus-circle me-2"></i>Tambah Kurikulum Baru
                    </h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('curriculums.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nama Kurikulum</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                   placeholder="Contoh: Kurikulum 2024 (OBE)" value="{{ old('name') }}" required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-check form-switch mb-4">
                            <input class="form-check-input" type="checkbox" name="active" value="1" id="active" checked>
                            <label class="form-check-label fw-semibold text-success" for="active">Setel sebagai Kurikulum Aktif</label>
                            <div class="form-text">Jika aktif, kurikulum ini akan ditampilkan di website publik.</div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success px-4">
                                <i class="fas fa-save"></i> Simpan Kurikulum
                            </button>
                            <a href="{{ route('curriculums.index') }}" class="btn btn-secondary px-4">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
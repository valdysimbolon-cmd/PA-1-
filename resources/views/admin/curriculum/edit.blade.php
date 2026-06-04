@extends('layouts.admin')

@section('title', 'Edit Kurikulum')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header py-3" style="background-color: #200F07;">
                    <h6 class="m-0 font-weight-bold" style="color: #C5E384;">
                        <i class="fas fa-edit me-2"></i>Edit Kurikulum: {{ $curriculum->name }}
                    </h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('curriculums.update', $curriculum->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nama Kurikulum</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                   value="{{ old('name', $curriculum->name) }}" required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-check form-switch mb-4">
                            <input class="form-check-input" type="checkbox" name="active" value="1" id="active" {{ old('active', $curriculum->active) ? 'checked' : '' }}>
                            <label class="form-check-label fw-semibold text-success" for="active">Setel sebagai Kurikulum Aktif</label>
                            @if($curriculum->active)
                                <div class="form-text">Kurikulum ini sedang aktif di website.</div>
                            @else
                                <div class="form-text">Aktifkan untuk menampilkan di website publik.</div>
                            @endif
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success px-4">
                                <i class="fas fa-save"></i> Perbarui Kurikulum
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
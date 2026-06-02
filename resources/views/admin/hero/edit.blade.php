@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header py-3" style="background-color: #200F07;">
                    <h6 class="m-0 font-weight-bold" style="color: #C5E384;">
                        <i class="fas fa-edit me-2"></i>Edit Banner
                    </h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('heroes.update', $hero->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Slogan Utama</label>
                            <input type="text" name="title" class="form-control" value="{{ old('title', $hero->title) }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Sub-Slogan</label>
                            <textarea name="subtitle" class="form-control" rows="2">{{ old('subtitle', $hero->subtitle) }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Link Video YouTube</label>
                            <input type="url" name="video_url" class="form-control" value="{{ old('video_url', $hero->video_url) }}" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Teks Tombol</label>
                                <input type="text" name="button_1_text" class="form-control" value="{{ old('button_1_text', $hero->button_1_text) }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Link Tombol</label>
                                <input type="url" name="button_1_url" class="form-control" value="{{ old('button_1_url', $hero->button_1_url) }}">
                            </div>
                        </div>

                        <div class="form-check form-switch mb-4">
                            <input class="form-check-input" type="checkbox" name="active" value="1" id="active" {{ $hero->active ? 'checked' : '' }}>
                            <label class="form-check-label fw-semibold" for="active">Aktifkan banner</label>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success px-4">
                                <i class="fas fa-save"></i> Perbarui
                            </button>
                            <a href="{{ route('heroes.index') }}" class="btn btn-secondary px-4">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3" style="background-color: #200F07;">
            <h6 class="m-0 font-weight-bold" style="color: #C5E384;">Edit Banner Beranda</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('heroes.update', $hero->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="form-group">
                    <label class="font-weight-bold">Slogan Utama</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title', $hero->title) }}" required>
                </div>

                <div class="form-group">
                    <label class="font-weight-bold">Sub-Slogan</label>
                    <textarea name="subtitle" class="form-control" rows="2">{{ old('subtitle', $hero->subtitle) }}</textarea>
                </div>

                <div class="form-group">
                    <label class="font-weight-bold text-primary">Link Video YouTube</label>
                    <input type="text" name="video_url" class="form-control" value="{{ old('video_url', $hero->video_url) }}" required>
                </div>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold">Teks Tombol</label>
                            <input type="text" name="button_1_text" class="form-control" value="{{ old('button_1_text', $hero->button_1_text) }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold">Link Tombol</label>
                            <input type="text" name="button_1_url" class="form-control" value="{{ old('button_1_url', $hero->button_1_url) }}">
                        </div>
                    </div>
                </div>

                <div class="custom-control custom-switch p-3 border rounded bg-light mt-3">
                    <input type="checkbox" class="custom-control-input" id="active" name="active" value="1" {{ $hero->active ? 'checked' : '' }}>
                    <label class="custom-control-label font-weight-bold text-success" for="active">Banner Aktif</label>
                </div>

                <hr>
                <button type="submit" class="btn shadow-sm px-5" style="background-color: #C5E384; color: #200F07; font-weight: bold;">
                    <i class="fas fa-check-circle mr-2"></i> Simpan Perubahan
                </button>
                <a href="{{ route('heroes.index') }}" class="btn btn-secondary border">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection
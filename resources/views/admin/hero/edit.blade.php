@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <div class="card shadow-sm border-0">
                <div class="card-header py-3" style="background-color:#200F07;">
                    <h6 class="m-0 fw-bold" style="color:#C5E384;">
                        <i class="fas fa-edit me-2"></i>
                        Edit Hero Banner
                    </h6>
                </div>

                <div class="card-body">

                    <form action="{{ route('heroes.update', $hero->id) }}"
                          method="POST"
                          enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Slogan Utama</label>
                            <input type="text"
                                   name="title"
                                   value="{{ old('title', $hero->title) }}"
                                   class="form-control"
                                   required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Sub Slogan</label>
                            <textarea name="subtitle"
                                      rows="3"
                                      class="form-control"
                                      required>{{ old('subtitle', $hero->subtitle) }}</textarea>
                        </div>

                        @if($hero->poster_image)
                            <div class="mb-3">
                                <img src="{{ asset('storage/'.$hero->poster_image) }}"
                                     class="img-thumbnail"
                                     style="max-height:220px;">
                            </div>
                        @endif

                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                Ganti Poster Image
                            </label>

                            <input type="file"
                                   name="poster_image"
                                   class="form-control"
                                   accept=".jpg,.jpeg,.png,.webp">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                Video YouTube (Opsional)
                            </label>

                            <input type="url"
                                   name="video_url"
                                   value="{{ old('video_url', $hero->video_url) }}"
                                   class="form-control">
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">
                                    Teks Tombol
                                </label>

                                <input type="text"
                                       name="button_text"
                                       value="{{ old('button_text', $hero->button_text) }}"
                                       class="form-control">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">
                                    Link Tombol
                                </label>

                                <input type="url"
                                       name="button_url"
                                       value="{{ old('button_url', $hero->button_url) }}"
                                       class="form-control">
                            </div>
                        </div>

                        <div class="form-check form-switch mb-4">
                            <input class="form-check-input"
                                   type="checkbox"
                                   name="active"
                                   value="1"
                                   {{ $hero->active ? 'checked' : '' }}>

                            <label class="form-check-label fw-semibold text-success">
                                Aktifkan Banner
                            </label>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save"></i>
                                Perbarui
                            </button>

                            <a href="{{ route('heroes.index') }}"
                               class="btn btn-secondary">
                                Batal
                            </a>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
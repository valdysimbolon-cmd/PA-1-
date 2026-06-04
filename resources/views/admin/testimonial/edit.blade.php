@extends('layouts.admin')

@section('title', 'Edit Testimoni')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header py-3" style="background-color: #200F07;">
                    <h6 class="m-0 font-weight-bold" style="color: #C5E384;">
                        <i class="fas fa-edit me-2"></i>Edit Testimoni: {{ $testimonial->name }}
                    </h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('testimonials.update', $testimonial->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Nama Lengkap</label>
                                <input type="text" name="name" class="form-control" value="{{ old('name', $testimonial->name) }}" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Angkatan</label>
                                <input type="number" name="batch" class="form-control" value="{{ old('batch', $testimonial->batch) }}" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Pekerjaan / Posisi</label>
                                <input type="text" name="position" class="form-control" value="{{ old('position', $testimonial->position) }}">
                            </div>
                        </div>

                        <div class="mt-3">
                            <label class="form-label fw-semibold">Isi Testimoni</label>
                            <textarea name="content" class="form-control" rows="4" required>{{ old('content', $testimonial->content) }}</textarea>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Foto Wajah</label>
                                @if($testimonial->photo)
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/'.$testimonial->photo) }}" class="img-thumbnail" width="80">
                                        <div class="form-text">Foto saat ini</div>
                                    </div>
                                @endif
                                <input type="file" name="photo" id="imageInput" class="form-control" accept="image/*">
                                <div id="previewContainer" class="mt-2 d-none">
                                    <img id="imagePreview" src="#" class="img-thumbnail" style="max-height: 150px;">
                                </div>
                                <div class="form-text">Kosongkan jika tidak ingin mengganti foto.</div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-switch mt-4 pt-2">
                                    <input class="form-check-input" type="checkbox" name="active" value="1" id="active" {{ $testimonial->active ? 'checked' : '' }}>
                                    <label class="form-check-label fw-semibold text-success" for="active">Tampilkan di Website Publik</label>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success px-4">
                                <i class="fas fa-save"></i> Perbarui Testimoni
                            </button>
                            <a href="{{ route('testimonials.index') }}" class="btn btn-secondary px-4">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    const imageInput = document.getElementById('imageInput');
    const imagePreview = document.getElementById('imagePreview');
    const previewContainer = document.getElementById('previewContainer');

    imageInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                imagePreview.src = event.target.result;
                previewContainer.classList.remove('d-none');
            }
            reader.readAsDataURL(file);
        } else {
            previewContainer.classList.add('d-none');
        }
    });
</script>
@endpush
@endsection
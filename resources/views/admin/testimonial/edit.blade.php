@extends('layouts.admin')

@section('title', 'Edit Testimoni')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Testimoni: {{ $testimonial->name }}</h1>
        <a href="{{ route('testimonials.index') }}" class="btn btn-secondary btn-sm">Batal</a>
    </div>

    <div class="card shadow mb-4 border-bottom-primary">
        <div class="card-header py-3" style="background-color: #200F07;">
            <h6 class="m-0 font-weight-bold" style="color: #C5E384;">Perbarui Data Testimoni</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('testimonials.update', $testimonial->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold">Nama Lengkap</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $testimonial->name) }}" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="font-weight-bold">Angkatan</label>
                            <input type="number" name="batch" class="form-control" value="{{ old('batch', $testimonial->batch) }}" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="font-weight-bold">Posisi</label>
                            <input type="text" name="position" class="form-control" value="{{ old('position', $testimonial->position) }}">
                        </div>
                    </div>
                </div>

                <div class="form-group mt-3">
                    <label class="font-weight-bold">Isi Testimoni</label>
                    <textarea name="content" class="form-control" rows="4" required>{{ old('content', $testimonial->content) }}</textarea>
                </div>

                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold">Foto Personel</label>
                            <div class="d-flex align-items-start">
                                <div class="mr-3">
                                    <small class="text-muted d-block mb-1">Foto Saat Ini:</small>
                                    @if($testimonial->photo)
                                        <img src="{{ asset('storage/' . $testimonial->photo) }}" class="img-thumbnail" width="100">
                                    @else
                                        <span class="badge badge-light border">No Photo</span>
                                    @endif
                                </div>
                                <div class="flex-grow-1">
                                    <small class="text-muted d-block mb-1">Ganti Foto Baru:</small>
                                    <input type="file" name="photo" id="imageInput" class="form-control-file border p-1 rounded">
                                    <div id="previewContainer" class="mt-2 d-none">
                                        <img id="imagePreview" src="#" class="img-thumbnail" style="max-height: 120px; border: 2px solid #C5E384;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="custom-control custom-switch p-3 border rounded shadow-sm bg-white mt-4">
                            <input type="checkbox" class="custom-control-input" id="active" name="active" value="1" {{ $testimonial->active ? 'checked' : '' }}>
                            <label class="custom-control-label font-weight-bold text-success" for="active">Tampilkan di Website</label>
                        </div>
                    </div>
                </div>

                <hr class="mt-4">
                <div class="text-right">
                    <button type="submit" class="btn shadow-sm px-5" style="background-color: #C5E384; color: #200F07; font-weight: bold; border: 1px solid #200F07;">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Script preview yang sama dengan create
    imageInput.onchange = evt => {
        const [file] = imageInput.files
        if (file) {
            imagePreview.src = URL.createObjectURL(file)
            previewContainer.classList.remove('d-none')
        }
    }
</script>
@endpush
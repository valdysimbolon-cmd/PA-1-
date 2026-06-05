@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-dark">
            <h6 class="m-0 font-weight-bold text-white">Edit Fasilitas: {{ $facility->name }}</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('facilities.update', $facility->id) }}" method="POST" enctype="multipart/form-data">
                @csrf 
                @method('PUT')
                <div class="row text-dark">
                    <div class="col-md-8 border-right">
                        <div class="form-group">
                            <label class="font-weight-bold">Nama Fasilitas</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $facility->name) }}" required>
                        </div>
                        <div class="form-group mt-3">
                            <label class="font-weight-bold">Deskripsi</label>
                            <textarea name="description" id="editor_edit" class="form-control">{{ old('description', $facility->description) }}</textarea>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 bg-light border rounded">
                            <label class="font-weight-bold small text-muted text-uppercase">Foto Saat Ini</label><br>
                            @if($facility->image) 
                                <img src="{{ asset('storage/'.$facility->image) }}" class="img-thumbnail mb-3 w-100" style="max-height: 200px; object-fit: cover;"> 
                            @endif
                            <input type="file" name="image" id="imageInput" class="form-control-file border p-1 rounded bg-white w-100">
                            <div id="previewContainer" class="mt-2 d-none text-center">
                                <img id="imagePreview" src="#" class="img-thumbnail" style="max-height: 150px;">
                            </div>
                            
                            <div class="form-group mt-3">
                                <label class="fw-bold small text-muted text-uppercase">Kategori / Tipe</label>
                                {{-- DIUBAH MENJADI INPUT TEKS AGAR BEBAS ISI --}}
                                <input type="text" name="type" class="form-control" value="{{ old('type', $facility->type) }}" required>
                            </div>

                            <div class="form-group mt-3">
                                <label class="fw-bold small text-muted text-uppercase">Kapasitas</label>
                                <input type="number" name="capacity" class="form-control" value="{{ old('capacity', $facility->capacity) }}">
                            </div>

                            <div class="form-group mt-3">
                                <label class="fw-bold small text-muted text-uppercase">Lokasi</label>
                                <input type="text" name="location" class="form-control" value="{{ old('location', $facility->location) }}" required>
                            </div>
                        </div>

                        <div class="form-check form-switch mt-4">
                            <input class="form-check-input" type="checkbox" name="active" value="1" id="active" {{ $facility->active ? 'checked' : '' }}>
                            <label class="form-check-label fw-bold text-success" for="active">Tampilkan di Web</label>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block py-3 mt-4 shadow fw-bold">UPDATE DATA</button>
                        <a href="{{ route('facilities.index') }}" class="btn btn-secondary btn-block mt-2">Batal</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('editor_edit', { height: 350, extraPlugins: 'justify', allowedContent: true });
    document.getElementById('imageInput').onchange = evt => {
        const [file] = evt.target.files;
        if (file) { 
            document.getElementById('imagePreview').src = URL.createObjectURL(file); 
            document.getElementById('previewContainer').classList.remove('d-none'); 
        }
    }
</script>
@endpush
@endsection
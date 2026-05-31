@extends('layouts.admin')

@section('title', 'Edit Fasilitas')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3" style="background-color: #200F07;">
            <h6 class="m-0 font-weight-bold" style="color: #C5E384;"><i class="fas fa-edit mr-2"></i>Edit Fasilitas: {{ $facility->name }}</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('facilities.update', $facility->id) }}" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label class="font-weight-bold">Nama Fasilitas</label>
                            <input type="text" name="name" class="form-control" value="{{ $facility->name }}" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="font-weight-bold">Tipe</label>
                            <select name="type" class="form-control">
                                <option value="Classroom" {{ $facility->type == 'Classroom' ? 'selected' : '' }}>Ruang Kelas</option>
                                <option value="Meeting Room" {{ $facility->type == 'Meeting Room' ? 'selected' : '' }}>Ruang Rapat</option>
                                <option value="Library" {{ $facility->type == 'Library' ? 'selected' : '' }}>Perpustakaan</option>
                                <option value="Other" {{ $facility->type == 'Other' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="font-weight-bold">Kapasitas</label>
                            <input type="number" name="capacity" class="form-control" value="{{ $facility->capacity }}">
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <label class="font-weight-bold">Lokasi</label>
                            <input type="text" name="location" class="form-control" value="{{ $facility->location }}" required>
                        </div>
                    </div>
                </div>

                <div class="form-group mt-3">
                    <label class="font-weight-bold">Deskripsi</label>
                    <textarea name="description" id="editor" class="form-control">{{ $facility->description }}</textarea>
                </div>

                <div class="form-group">
                    <label class="font-weight-bold">Foto Saat Ini</label><br>
                    @if($facility->image)
                        <img src="{{ asset('storage/' . $facility->image) }}" class="img-thumbnail mb-2" width="150">
                    @endif
                    <input type="file" name="image" id="imageInput" class="form-control-file border p-1 rounded w-100">
                    <div id="previewContainer" class="mt-2 d-none">
                        <img id="imagePreview" src="#" class="img-thumbnail" width="150">
                    </div>
                </div>

                <div class="custom-control custom-switch p-3 border rounded bg-white mt-4">
                    <input type="checkbox" class="custom-control-input" id="active" name="active" value="1" {{ $facility->active ? 'checked' : '' }}>
                    <label class="custom-control-label font-weight-bold text-success" for="active">Fasilitas Aktif</label>
                </div>

                <hr>
                <button type="submit" class="btn shadow-sm px-5" style="background-color: #C5E384; color: #200F07; font-weight: bold;">Simpan Perubahan</button>
                <a href="{{ route('facilities.index') }}" class="btn btn-secondary border">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    imageInput.onchange = evt => {
        const [file] = imageInput.files
        if (file) {
            imagePreview.src = URL.createObjectURL(file)
            previewContainer.classList.remove('d-none')
        }
    }
</script>
@endpush
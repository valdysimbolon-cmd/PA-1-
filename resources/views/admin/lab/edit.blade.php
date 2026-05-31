@extends('layouts.admin')

@section('title', 'Edit Unit Lab')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Unit: {{ $lab->name }}</h1>
        <a href="{{ route('labs.index') }}" class="btn btn-secondary btn-sm">Batal</a>
    </div>

    <div class="card shadow mb-4 border-bottom-primary">
        <div class="card-header py-3" style="background-color: #200F07;">
            <h6 class="m-0 font-weight-bold" style="color: #C5E384;">Perbarui Data Unit Lab</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('labs.update', $lab->id) }}" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label class="font-weight-bold">Nama Laboratorium</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $lab->name) }}" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="font-weight-bold">Kategori</label>
                            <select name="category" class="form-control">
                                <option value="Praktikum" {{ $lab->category == 'Praktikum' ? 'selected' : '' }}>Praktikum</option>
                                <option value="Riset" {{ $lab->category == 'Riset' ? 'selected' : '' }}>Riset</option>
                                <option value="Umum" {{ $lab->category == 'Umum' ? 'selected' : '' }}>Umum</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold text-primary">Kepala Lab (Dosen)</label>
                            <select name="head_of_lab_id" class="form-control">
                                <option value="">-- Pilih Dosen --</option>
                                @foreach($lecturers as $l)
                                    <option value="{{ $l->id }}" {{ $lab->head_of_lab_id == $l->id ? 'selected' : '' }}>{{ $l->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold text-success">Staf PIC (Admin Lab)</label>
                            <select name="staff_id" class="form-control" required>
                                @foreach($staffs as $s)
                                    <option value="{{ $s->id }}" {{ $lab->staff_id == $s->id ? 'selected' : '' }}>{{ $s->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group mt-3">
                    <label class="font-weight-bold">Foto Saat Ini</label><br>
                    @if($lab->image)
                        <img src="{{ asset('storage/' . $lab->image) }}" class="img-thumbnail mb-2" width="150">
                    @endif
                    <input type="file" name="image" id="imageInput" class="form-control-file border p-1 rounded w-100">
                    <div id="previewContainer" class="mt-2 d-none">
                        <img id="imagePreview" src="#" class="img-thumbnail" width="150">
                    </div>
                </div>

                <div class="custom-control custom-switch p-3 border rounded bg-white mt-4">
                    <input type="checkbox" class="custom-control-input" id="active" name="active" value="1" {{ $lab->active ? 'checked' : '' }}>
                    <label class="custom-control-label font-weight-bold text-success" for="active">Unit Lab Aktif</label>
                </div>

                <hr class="mt-4">
                <button type="submit" class="btn shadow-sm px-5" style="background-color: #C5E384; color: #200F07; font-weight: bold;">Simpan Perubahan</button>
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
@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        
        {{-- Header --}}
        <div class="card-header py-3" style="background-color: #200F07;">
            <h6 class="m-0 font-weight-bold" style="color: #C5E384;">
                Edit Unit Laboratorium
            </h6>
        </div>

        <div class="card-body">
            <form action="{{ route('labs.update', $lab->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row text-dark">
                    <div class="col-md-8">
                        <label class="font-weight-bold">Nama Laboratorium</label>
                        <input type="text"
                               name="name"
                               class="form-control"
                               value="{{ old('name', $lab->name) }}"
                               required>
                    </div>

                    <div class="col-md-4">
                        <label class="font-weight-bold">Kategori Lab</label>
                        <select name="category" class="form-control" required>
                            <option value="Praktikum"
                                {{ old('category', $lab->category) == 'Praktikum' ? 'selected' : '' }}>
                                Praktikum
                            </option>

                            <option value="Riset"
                                {{ old('category', $lab->category) == 'Riset' ? 'selected' : '' }}>
                                Riset
                            </option>

                            <option value="Umum"
                                {{ old('category', $lab->category) == 'Umum' ? 'selected' : '' }}>
                                Umum
                            </option>
                        </select>
                    </div>
                </div>

                <div class="row mt-3 text-dark">
                    <div class="col-md-6">
                        <label class="font-weight-bold">Kepala Lab (Dosen)</label>

                        <select name="head_of_lab_id" class="form-control">
                            <option value="">-- Pilih Dosen --</option>

                            @foreach($lecturers as $l)
                                <option value="{{ $l->id }}"
                                    {{ old('head_of_lab_id', $lab->head_of_lab_id) == $l->id ? 'selected' : '' }}>
                                    {{ $l->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="font-weight-bold">Lokasi / Ruangan</label>
                        <input type="text"
                               name="location"
                               class="form-control"
                               value="{{ old('location', $lab->location) }}"
                               placeholder="Gedung 5 Lt. 2">
                    </div>
                </div>

                <div class="form-group mt-3 text-dark">
                    <label class="font-weight-bold">
                        Profil & Penjelasan Detail Lab
                    </label>

                    <textarea name="description"
                              id="editor"
                              class="form-control">{{ old('description', $lab->description) }}</textarea>
                </div>

                <div class="form-group text-dark">
                    <label class="font-weight-bold">
                        Foto Banner Lab
                    </label>

                    @if($lab->image)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $lab->image) }}"
                                 alt="{{ $lab->name }}"
                                 class="img-fluid rounded border"
                                 style="max-height: 200px;">
                        </div>
                    @endif

                    <input type="file"
                           name="image"
                           class="form-control-file border p-1 rounded w-100">

                    <small class="text-muted">
                        Kosongkan jika tidak ingin mengganti gambar.
                    </small>
                </div>

                <div class="custom-control custom-switch p-3 border rounded bg-light">
                    <input type="checkbox"
                           class="custom-control-input"
                           id="active"
                           name="active"
                           value="1"
                           {{ old('active', $lab->active) ? 'checked' : '' }}>

                    <label class="custom-control-label text-success font-weight-bold"
                           for="active"
                           style="cursor:pointer;">
                        Aktifkan Unit Lab
                    </label>
                </div>

                <div class="mt-4">
                    <button type="submit"
                            class="btn shadow-sm"
                            style="background-color: #C5E384; color: #200F07; font-weight:bold;">
                        Update Unit Lab
                    </button>

                    <a href="{{ route('labs.index') }}"
                       class="btn btn-secondary">
                        Kembali
                    </a>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>

<script>
    CKEDITOR.replace('editor', {
        height: 400,
        extraPlugins: 'justify',
        allowedContent: true
    });
</script>
@endpush
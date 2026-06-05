@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        {{-- Header warna Midnight Espresso --}}
        <div class="card-header py-3" style="background-color: #200F07;">
            <h6 class="m-0 font-weight-bold" style="color: #C5E384;">Tambah Unit Laboratorium Baru</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('labs.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row text-dark">
                    <div class="col-md-8">
                        <label class="font-weight-bold">Nama Laboratorium</label>
                        <input type="text" name="name" class="form-control" placeholder="Contoh: Lab Kimia Organik" required>
                    </div>
                    <div class="col-md-4">
                        <label class="font-weight-bold">Kategori Lab</label>
                        <select name="category" class="form-control" required>
                            <option value="Praktikum">Praktikum</option>
                            <option value="Riset">Riset</option>
                            <option value="Umum">Umum</option>
                        </select>
                    </div>
                </div>

                <div class="row mt-3 text-dark">
                    <div class="col-md-6">
                        <label class="font-weight-bold">Kepala Lab (Dosen)</label>
                        <select name="head_of_lab_id" class="form-control">
                            <option value="">-- Pilih Dosen --</option>
                            @foreach($lecturers as $l)
                                <option value="{{ $l->id }}">{{ $l->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="font-weight-bold">Lokasi / Ruangan</label>
                        <input type="text" name="location" class="form-control" placeholder="Gedung 5 Lt. 2">
                    </div>
                </div>

                {{-- Bagian Deskripsi denga ID "editor" (Menyamakan denga Tools) --}}
                <div class="form-group mt-3 text-dark">
                    <label class="font-weight-bold">Profil & Penjelasan Detail Lab</label>
                    <textarea name="description" id="editor" class="form-control">{{ old('description') }}</textarea>
                </div>

                <div class="form-group text-dark">
                    <label class="font-weight-bold">Foto Banner Lab</label>
                    <input type="file" name="image" class="form-control-file border p-1 rounded w-100">
                </div>

                <div class="custom-control custom-switch p-3 border rounded bg-light">
                    <input type="checkbox" class="custom-control-input" id="active" name="active" value="1" checked>
                    <label class="custom-control-label text-success font-weight-bold" for="active" style="cursor:pointer;">Aktifkan Unit Lab</label>
                </div>

                <button type="submit" class="btn mt-4 shadow-sm" style="background-color: #C5E384; color: #200F07; font-weight: bold;">
                    Simpan Unit Lab
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
{{-- Panggil script yang sama denga yang membuat Tools berhasil --}}
<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('editor', {
        height: 400,
        extraPlugins: 'justify',
        allowedContent: true
    });
</script>
@endpush
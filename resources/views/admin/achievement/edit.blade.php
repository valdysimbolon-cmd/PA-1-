@extends('layouts.admin')

@section('title', 'Edit Prestasi')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Perbarui Data Prestasi</h1>
        <a href="{{ route('achievements.index') }}" class="btn btn-secondary btn-sm shadow-sm">Batal</a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3" style="background-color: #200F07;">
            <h6 class="m-0 font-weight-bold" style="color: #C5E384;">Edit: {{ $achievement->title }}</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('achievements.update', $achievement->id) }}" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label class="font-weight-bold">Judul Prestasi / Nama Lomba</label>
                            <input type="text" name="title" class="form-control" value="{{ old('title', $achievement->title) }}" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="font-weight-bold">Pemenang Utama (Label)</label>
                            <input type="text" name="winner_name" class="form-control" value="{{ old('winner_name', $achievement->winner_name) }}" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="font-weight-bold">Kategori</label>
                            <select name="category" class="form-control">
                                <option value="Students" {{ $achievement->category == 'Students' ? 'selected' : '' }}>Mahasiswa</option>
                                <option value="Lecturers" {{ $achievement->category == 'Lecturers' ? 'selected' : '' }}>Dosen</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="font-weight-bold">Tingkat</label>
                            <select name="level" class="form-control">
                                <option value="Regional" {{ $achievement->level == 'Regional' ? 'selected' : '' }}>Regional</option>
                                <option value="Nasional" {{ $achievement->level == 'Nasional' ? 'selected' : '' }}>Nasional</option>
                                <option value="Internasional" {{ $achievement->level == 'Internasional' ? 'selected' : '' }}>Internasional</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="font-weight-bold">Tahun</label>
                            <input type="number" name="year" class="form-control" value="{{ old('year', $achievement->year) }}">
                        </div>
                    </div>
                </div>

                <!-- RELASI ANGGOTA (DIPULIHKAN DARI DATABASE) -->
                <div class="p-3 border rounded shadow-sm bg-light mt-4 mb-4">
                    <label class="font-weight-bold text-primary"><i class="fas fa-users mr-2"></i>Daftar Personel Terhubung</label>
                    <div id="member-container">
                        @foreach($achievement->members as $member)
                        <div class="row member-row mb-3">
                            <div class="col-md-3">
                                <select name="member_types[]" class="form-control form-control-sm">
                                    <option value="Student" {{ $member->member_type == 'Student' ? 'selected' : '' }}>Mahasiswa</option>
                                    <option value="Lecturer" {{ $member->member_type == 'Lecturer' ? 'selected' : '' }}>Dosen</option>
                                </select>
                            </div>
                            <div class="col-md-5">
                                <select name="member_ids[]" class="form-control form-control-sm">
                                    <optgroup label="Mahasiswa">
                                        @foreach($students as $s) <option value="{{ $s->id }}" {{ $member->member_id == $s->id && $member->member_type == 'Student' ? 'selected' : '' }}>{{ $s->name }}</option> @endforeach
                                    </optgroup>
                                    <optgroup label="Dosen">
                                        @foreach($lecturers as $l) <option value="{{ $l->id }}" {{ $member->member_id == $l->id && $member->member_type == 'Lecturer' ? 'selected' : '' }}>{{ $l->name }}</option> @endforeach
                                    </optgroup>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select name="roles[]" class="form-control form-control-sm">
                                    <option value="Ketua" {{ $member->role == 'Ketua' ? 'selected' : '' }}>Ketua</option>
                                    <option value="Anggota" {{ $member->role == 'Anggota' ? 'selected' : '' }}>Anggota</option>
                                    <option value="Pembimbing" {{ $member->role == 'Pembimbing' ? 'selected' : '' }}>Pembimbing</option>
                                </select>
                            </div>
                            <div class="col-md-1">
                                <button type="button" class="btn btn-danger btn-sm remove-member"><i class="fas fa-times"></i></button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-primary mt-2" id="add-member"><i class="fas fa-plus"></i> Tambah Orang</button>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <label class="font-weight-bold">Ganti Foto Bukti</label>
                        <input type="file" name="image" id="imageInput" class="form-control-file border p-1 rounded mb-2">
                        <img id="preview" src="{{ asset('storage/'.$achievement->image) }}" class="img-thumbnail" width="150">
                    </div>
                </div>

                <hr>
                <button type="submit" class="btn shadow-sm px-5" style="background-color: #C5E384; color: #200F07; font-weight: bold;">Update Prestasi</button>
            </form>
        </div>
    </div>
</div>

<!-- Template yang sama dengan create -->
<template id="member-row-template">
    <div class="row member-row mb-3">
        <div class="col-md-3">
            <select name="member_types[]" class="form-control form-control-sm"><option value="Student">Mahasiswa</option><option value="Lecturer">Dosen</option></select>
        </div>
        <div class="col-md-5">
            <select name="member_ids[]" class="form-control form-control-sm">
                <option value="">-- Pilih --</option>
                <optgroup label="Mahasiswa">@foreach($students as $s) <option value="{{ $s->id }}">{{ $s->name }}</option> @endforeach</optgroup>
                <optgroup label="Dosen">@foreach($lecturers as $l) <option value="{{ $l->id }}">{{ $l->name }}</option> @endforeach</optgroup>
            </select>
        </div>
        <div class="col-md-3">
            <select name="roles[]" class="form-control form-control-sm"><option value="Ketua">Ketua</option><option value="Anggota">Anggota</option><option value="Pembimbing">Pembimbing</option></select>
        </div>
        <div class="col-md-1"><button type="button" class="btn btn-danger btn-sm remove-member">X</button></div>
    </div>
</template>
@endsection

@push('scripts')
<script>
    const container = document.getElementById('member-container');
    const template = document.getElementById('member-row-template').content;

    document.getElementById('add-member').addEventListener('click', () => {
        const clone = template.cloneNode(true);
        container.appendChild(clone);
    });

    container.addEventListener('click', (e) => {
        if (e.target.closest('.remove-member')) {
            e.target.closest('.member-row').remove();
        }
    });

    // Preview Gambar
    imageInput.onchange = evt => {
        const [file] = imageInput.files
        if (file) { preview.src = URL.createObjectURL(file); preview.classList.remove('d-none'); }
    }
</script>
@endpush
@extends('layouts.admin')

@section('title', 'Edit Prestasi')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-dark">
            <h6 class="m-0 font-weight-bold text-white">Edit: {{ $achievement->title }}</h6>
        </div>
        <div class="card-body text-dark">
            <form action="{{ route('achievements.update', $achievement->id) }}" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Kategori Pemenang</label>
                            <select name="category" class="form-select">
                                <option value="students" {{ $achievement->category == 'students' ? 'selected' : '' }}>Mahasiswa</option>
                                <option value="lecturers" {{ $achievement->category == 'lecturers' ? 'selected' : '' }}>Dosen</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Judul Prestasi</label>
                            <input type="text" name="title" class="form-control" value="{{ old('title', $achievement->title) }}" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Peringkat</label>
                        <input type="text" name="rank" class="form-control" value="{{ old('rank', $achievement->rank) }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Tingkat</label>
                        <select name="level" class="form-select">
                            <option value="Regional" {{ $achievement->level == 'Regional' ? 'selected' : '' }}>Regional</option>
                            <option value="Nasional" {{ $achievement->level == 'Nasional' ? 'selected' : '' }}>Nasional</option>
                            <option value="Internasional" {{ $achievement->level == 'Internasional' ? 'selected' : '' }}>Internasional</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Tahun</label>
                        <input type="number" name="year" class="form-control" value="{{ old('year', $achievement->year) }}">
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-md-4 text-center border-end">
                        <label class="form-label fw-bold d-block">Foto Saat Ini</label>
                        @if($achievement->image)
                            <img src="{{ asset('storage/'.$achievement->image) }}" class="img-thumbnail mb-2" style="max-height: 150px;">
                        @endif
                        <input type="file" name="image" class="form-control form-control-sm">
                    </div>
                    <div class="col-md-8 ps-4">
                        <h6 class="fw-bold text-primary">Daftar Personel Terhubung</h6>
                        <div id="member-container">
                            @foreach($achievement->members as $m)
                            <div class="row member-row mb-2">
                                <div class="col-md-3">
                                    <select name="member_types[]" class="form-select form-select-sm">
                                        <option value="Student" {{ $m->member_type == 'Student' ? 'selected' : '' }}>Mahasiswa</option>
                                        <option value="Lecturer" {{ $m->member_type == 'Lecturer' ? 'selected' : '' }}>Dosen</option>
                                    </select>
                                </div>
                                <div class="col-md-5">
                                    <select name="member_ids[]" class="form-select form-select-sm">
                                        <optgroup label="Mahasiswa">
                                            @foreach($students as $s) <option value="{{ $s->id }}" {{ ($m->member_id == $s->id && $m->member_type == 'Student') ? 'selected' : '' }}>{{ $s->name }}</option> @endforeach
                                        </optgroup>
                                        <optgroup label="Dosen">
                                            @foreach($lecturers as $l) <option value="{{ $l->id }}" {{ ($m->member_id == $l->id && $m->member_type == 'Lecturer') ? 'selected' : '' }}>{{ $l->name }}</option> @endforeach
                                        </optgroup>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <input type="text" name="roles[]" class="form-control form-control-sm" value="{{ $m->role }}">
                                </div>
                                <div class="col-md-1"><button type="button" class="btn btn-danger btn-sm remove-member">×</button></div>
                            </div>
                            @endforeach
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-primary mt-2" id="add-member">+ Tambah Orang</button>
                    </div>
                </div>

                <hr class="my-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="active" value="1" {{ $achievement->active ? 'checked' : '' }}>
                        <label class="form-check-label fw-bold text-success">Aktif / Tampilkan</label>
                    </div>
                    <button type="submit" class="btn btn-primary px-5">PERBARUI PRESTASI</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Template yang sama denga Create diletakkan di bawah --}}
<template id="member-row-template">
    <div class="row member-row mb-2">
        <div class="col-md-3">
            <select name="member_types[]" class="form-select form-select-sm"><option value="Student">Mahasiswa</option><option value="Lecturer">Dosen</option></select>
        </div>
        <div class="col-md-5">
            <select name="member_ids[]" class="form-select form-select-sm">
                <option value="">-- Pilih --</option>
                <optgroup label="Mahasiswa">@foreach($students as $s) <option value="{{ $s->id }}">{{ $s->name }}</option> @endforeach</optgroup>
                <optgroup label="Dosen">@foreach($lecturers as $l) <option value="{{ $l->id }}">{{ $l->name }}</option> @endforeach</optgroup>
            </select>
        </div>
        <div class="col-md-3"><input type="text" name="roles[]" class="form-control form-control-sm"></div>
        <div class="col-md-1"><button type="button" class="btn btn-danger btn-sm remove-member">×</button></div>
    </div>
</template>
@endsection

@push('scripts')
<script>
    // JS Logic sama denga Create
    document.addEventListener('DOMContentLoaded', function () {
        const container = document.getElementById('member-container');
        const template = document.getElementById('member-row-template');
        document.getElementById('add-member').addEventListener('click', () => { container.appendChild(template.content.cloneNode(true)); });
        container.addEventListener('click', (e) => { if (e.target.classList.contains('remove-member')) e.target.closest('.member-row').remove(); });
    });
</script>
@endpush
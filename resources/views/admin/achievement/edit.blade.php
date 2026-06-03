@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-dark">
            <h6 class="m-0 font-weight-bold text-white">Edit Prestasi: {{ $achievement->title }}</h6>
        </div>
        <div class="card-body text-dark">
            <form action="{{ route('achievements.update', $achievement->id) }}" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group"><label>Judul Lomba</label><input type="text" name="title" class="form-control" value="{{ $achievement->title }}"></div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group"><label>Pemenang (Label)</label><input type="text" name="winner_name" class="form-control" value="{{ $achievement->winner_name }}"></div>
                    </div>
                </div>

                <div class="p-4 border rounded bg-light my-4">
                    <label class="font-weight-bold">Personel Terhubung</label>
                    <div id="member-container">
                        @foreach($achievement->members as $member)
                        <div class="row member-row mb-2">
                            <div class="col-md-3">
                                <select name="member_types[]" class="form-control form-control-sm">
                                    <option value="Student" {{ $member->member_type == 'Student' ? 'selected' : '' }}>Mahasiswa</option>
                                    <option value="Lecturer" {{ $member->member_type == 'Lecturer' ? 'selected' : '' }}>Dosen</option>
                                </select>
                            </div>
                            <div class="col-md-5">
                                <select name="member_ids[]" class="form-control form-control-sm">
                                    <optgroup label="Mahasiswa">
                                        @foreach($students as $s)
                                            <option value="{{ $s->id }}" {{ ($member->member_id == $s->id && $member->member_type == 'Student') ? 'selected' : '' }}>{{ $s->name }}</option>
                                        @endforeach
                                    </optgroup>
                                    <optgroup label="Dosen">
                                        @foreach($lecturers as $l)
                                            <option value="{{ $l->id }}" {{ ($member->member_id == $l->id && $member->member_type == 'Lecturer') ? 'selected' : '' }}>{{ $l->name }}</option>
                                        @endforeach
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
                            <div class="col-md-1"><button type="button" class="btn btn-danger btn-sm remove-member">×</button></div>
                        </div>
                        @endforeach
                    </div>
                    <button type="button" class="btn btn-sm btn-dark mt-2" id="add-member">+ Tambah Orang</button>
                </div>

                <div class="text-right mt-4">
                    <button type="submit" class="btn btn-primary px-5 shadow">PERBARUI DATA</button>
                </div>
            </form>
        </div>
    </div>
</div>

<template id="member-row-template">
    <div class="row member-row mb-2">
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
        <div class="col-md-1"><button type="button" class="btn btn-danger btn-sm remove-member">×</button></div>
    </div>
</template>
@endsection
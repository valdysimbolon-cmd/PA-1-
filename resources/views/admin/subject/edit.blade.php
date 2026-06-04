@extends('layouts.admin')

@section('title', 'Edit Mata Kuliah')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header py-3" style="background-color: #200F07;">
                    <h6 class="m-0 font-weight-bold" style="color: #C5E384;">
                        <i class="fas fa-edit me-2"></i>Edit Mata Kuliah: {{ $subject->name }}
                    </h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('subjects.update', $subject->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Kode MK</label>
                                <input type="text" name="code" class="form-control" value="{{ old('code', $subject->code) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Nama Mata Kuliah</label>
                                <input type="text" name="name" class="form-control" value="{{ old('name', $subject->name) }}" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">SKS</label>
                                <input type="number" name="sks" class="form-control" value="{{ old('sks', $subject->sks) }}" required>
                            </div>
                        </div>

                        <div class="row g-3 mt-2">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Kurikulum</label>
                                <select name="curriculum_id" class="form-select" required>
                                    @foreach($curriculums as $c)
                                        <option value="{{ $c->id }}" {{ $subject->curriculum_id == $c->id ? 'selected' : '' }}>
                                            {{ $c->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Semester</label>
                                <select name="semester" class="form-select">
                                    @for($i = 1; $i <= 8; $i++)
                                        <option value="{{ $i }}" {{ $subject->semester == $i ? 'selected' : '' }}>
                                            Semester {{ $i }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                        </div>

                        <div class="mt-3">
                            <label class="form-label fw-semibold">Deskripsi Mata Kuliah (Opsional)</label>
                            <textarea name="description" class="form-control" rows="3">{{ old('description', $subject->description) }}</textarea>
                        </div>

                        <hr class="my-4">
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success px-4">
                                <i class="fas fa-save"></i> Perbarui Mata Kuliah
                            </button>
                            <a href="{{ route('subjects.index') }}" class="btn btn-secondary px-4">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
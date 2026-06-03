@extends('layouts.admin')
@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4 border-bottom-primary">
        <div class="card-header py-3 bg-dark text-white"><h6 class="m-0 font-weight-bold">Edit Mata Kuliah: {{ $subject->name }}</h6></div>
        <div class="card-body text-dark">
            <form action="{{ route('subjects.update', $subject->id) }}" method="POST">
                @csrf @method('PUT')
                <div class="row">
                    <div class="col-md-3"><label>Kode MK</label><input type="text" name="code" class="form-control" value="{{ $subject->code }}"></div>
                    <div class="col-md-9"><label>Nama MK</label><input type="text" name="name" class="form-control" value="{{ $subject->name }}"></div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-4">
                        <label>Semester</label>
                        <select name="semester" class="form-control">
                            @for($i=1; $i<=8; $i++) <option value="{{ $i }}" {{ $subject->semester == $i ? 'selected' : '' }}>Semester {{ $i }}</option> @endfor
                        </select>
                    </div>
                    <div class="col-md-4"><label>SKS</label><input type="number" name="sks" class="form-control" value="{{ $subject->sks }}"></div>
                    <div class="col-md-4">
                        <label>Kurikulum</label>
                        <select name="curriculum_id" class="form-control">
                            @foreach($curriculums as $c) <option value="{{ $c->id }}" {{ $subject->curriculum_id == $c->id ? 'selected' : '' }}>{{ $c->name }}</option> @endforeach
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mt-4 px-5">PERBARUI DATA</button>
            </form>
        </div>
    </div>
</div>
@endsection
@extends('layouts.admin')
@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3" style="background-color: #200F07;"><h6 class="m-0 font-weight-bold" style="color: #C5E384;">Input Mata Kuliah Baru</h6></div>
        <div class="card-body text-dark">
            <form action="{{ route('subjects.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-3"><label class="font-weight-bold">Kode MK</label><input type="text" name="code" class="form-control" required></div>
                    <div class="col-md-6"><label class="font-weight-bold">Nama Mata Kuliah</label><input type="text" name="name" class="form-control" required></div>
                    <div class="col-md-3"><label class="font-weight-bold">SKS</label><input type="number" name="sks" class="form-control" value="3"></div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <label class="font-weight-bold">Pilih Kurikulum</label>
                        <select name="curriculum_id" class="form-control" required>
                            @foreach($curriculums as $c) <option value="{{ $c->id }}">{{ $c->name }}</option> @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="font-weight-bold">Semester</label>
                        <select name="semester" class="form-control">
                            @for($i=1; $i<=8; $i++) <option value="{{ $i }}">Semester {{ $i }}</option> @endfor
                        </select>
                    </div>
                </div>
                <div class="form-group mt-3"><label class="font-weight-bold">Deskripsi MK</label><textarea name="description" class="form-control" rows="3"></textarea></div>
                <button type="submit" class="btn btn-success mt-3" style="background-color: #C5E384; color: #200F07; border: none; font-weight: bold;">SIMPAN</button>
            </form>
        </div>
    </div>
</div>
@endsection
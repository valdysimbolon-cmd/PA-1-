@extends('layouts.admin')
@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3" style="background-color: #200F07;">
        <h6 class="m-0 font-weight-bold" style="color: #C5E384;">Buat Versi Kurikulum Baru</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('curriculums.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label class="font-weight-bold">Nama Kurikulum</label>
                <input type="text" name="name" class="form-control" placeholder="Contoh: Kurikulum 2024 (MBKM)" required>
            </div>
            <button type="submit" class="btn px-4" style="background-color: #C5E384; color: #200F07; font-weight: bold;">Simpan</button>
        </form>
    </div>
</div>
@endsection
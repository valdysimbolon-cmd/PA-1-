@extends('layouts.admin')
@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4 col-lg-6">
        <div class="card-header py-3" style="background-color: #200F07;"><h6 class="m-0 font-weight-bold" style="color: #C5E384;">Tambah Kurikulum Baru</h6></div>
        <div class="card-body text-dark">
            <form action="{{ route('curriculums.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="font-weight-bold">Nama Kurikulum</label>
                    <input type="text" name="name" class="form-control" placeholder="Contoh: Kurikulum 2024 (OBE)" required>
                </div>
                <div class="custom-control custom-switch mb-3">
                    <input type="checkbox" class="custom-control-input" id="active" name="active" value="1" checked>
                    <label class="custom-control-label" for="active">Setel sebagai Kurikulum Aktif</label>
                </div>
                <button type="submit" class="btn btn-primary px-4">Simpan</button>
            </form>
        </div>
    </div>
</div>
@endsection
@extends('layouts.admin')
@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3" style="background-color: #200F07;"><h6 class="m-0 font-weight-bold" style="color: #C5E384;">Tambah Alat Baru</h6></div>
        <div class="card-body">
            <form action="{{ route('tools.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6"><label>Nama Alat</label><input type="text" name="name" class="form-control" required></div>
                    <div class="col-md-6"><label>Kode Inventaris</label><input type="text" name="code" class="form-control" required></div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <label>Pilih Lab</label>
                        <select name="lab_id" class="form-control">
                            @foreach($labs as $lab) <option value="{{ $lab->id }}">{{ $lab->name }}</option> @endforeach
                        </select>
                    </div>
                    <div class="col-md-3"><label>Stok Total</label><input type="number" name="stock_total" class="form-control" required></div>
                    <div class="col-md-3"><label>Satuan</label><input type="text" name="unit" class="form-control" placeholder="Pcs/Unit" required></div>
                </div>
                <div class="form-group mt-3"><label>Spesifikasi</label><textarea name="specification" id="editor" class="form-control"></textarea></div>
                <div class="form-group"><label>Foto Alat</label><input type="file" name="image" class="form-control-file border p-1 rounded w-100"></div>
                <div class="custom-control custom-switch p-3 border rounded bg-light">
                    <input type="checkbox" class="custom-control-input" id="active" name="active" value="1" checked>
                    <label class="custom-control-label" for="active">Aktifkan di Katalog</label>
                </div>
                <button type="submit" class="btn mt-4 shadow-sm" style="background-color: #C5E384; color: #200F07; font-weight: bold;">Simpan Alat</button>
            </form>
        </div>
    </div>
</div>
@endsection
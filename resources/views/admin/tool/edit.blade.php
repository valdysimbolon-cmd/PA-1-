@extends('layouts.admin')
@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3" style="background-color: #200F07;"><h6 class="m-0 font-weight-bold" style="color: #C5E384;">Edit Alat: {{ $tool->name }}</h6></div>
        <div class="card-body">
            <form action="{{ route('tools.update', $tool->id) }}" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                <div class="row">
                    <div class="col-md-6"><label>Nama Alat</label><input type="text" name="name" class="form-control" value="{{ $tool->name }}" required></div>
                    <div class="col-md-6"><label>Kode Inventaris</label><input type="text" name="code" class="form-control" value="{{ $tool->code }}" required></div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <label>Pilih Lab</label>
                        <select name="lab_id" class="form-control">
                            @foreach($labs as $lab) <option value="{{ $lab->id }}" {{ $tool->lab_id == $lab->id ? 'selected' : '' }}>{{ $lab->name }}</option> @endforeach
                        </select>
                    </div>
                    <div class="col-md-3"><label>Stok Total</label><input type="number" name="stock_total" class="form-control" value="{{ $tool->stock_total }}" required></div>
                    <div class="col-md-3"><label>Satuan</label><input type="text" name="unit" class="form-control" value="{{ $tool->unit }}" required></div>
                </div>
                <div class="form-group mt-3"><label>Spesifikasi</label><textarea name="specification" id="editor" class="form-control">{{ $tool->specification }}</textarea></div>
                <div class="form-group">
                    <label>Foto Saat Ini</label><br><img src="{{ asset('storage/'.$tool->image) }}" width="100" class="mb-2"><br>
                    <input type="file" name="image" class="form-control-file border p-1 rounded w-100">
                </div>
                <button type="submit" class="btn mt-4 shadow-sm" style="background-color: #C5E384; color: #200F07; font-weight: bold;">Update Alat</button>
            </form>
        </div>
    </div>
</div>
@endsection
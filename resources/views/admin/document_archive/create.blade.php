@extends('layouts.admin')
@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3" style="background-color: #200F07;"><h6 class="m-0 font-weight-bold" style="color: #C5E384;">Upload Dokumen Baru</h6></div>
        <div class="card-body text-dark">
            <form action="{{ route('document_archives.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label class="font-weight-bold">Judul Dokumen</label>
                    <input type="text" name="title" class="form-control" required>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label class="font-weight-bold">Kategori</label>
                        <select name="category" class="form-control">
                            <option value="Pedoman">Pedoman</option>
                            <option value="SOP">SOP</option>
                            <option value="Formulir">Formulir</option>
                            <option value="Akreditasi">Akreditasi</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="font-weight-bold">Tahun Terbit</label>
                        <input type="number" name="year" class="form-control" value="{{ date('Y') }}">
                    </div>
                </div>
                <div class="form-group mt-3">
                    <label class="font-weight-bold">Pilih File (PDF/DOCX/XLSX)</label>
                    <input type="file" name="file" class="form-control-file border p-1 rounded w-100" required>
                </div>
                <div class="form-group">
                    <label class="font-weight-bold">Deskripsi Singkat</label>
                    <textarea name="description" class="form-control" rows="3"></textarea>
                </div>
                <hr>
                <button type="submit" class="btn px-5" style="background-color: #C5E384; color: #200F07; font-weight: bold;">UPLOAD SEKARANG</button>
            </form>
        </div>
    </div>
</div>
@endsection
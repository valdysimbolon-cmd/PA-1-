@extends('layouts.admin')
@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3" style="background-color: #200F07;"><h6 class="m-0 font-weight-bold" style="color: #C5E384;">Buat Pengumuman Baru</h6></div>
        <div class="card-body text-dark">
            <form action="{{ route('announcements.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label class="font-weight-bold">Judul Pengumuman</label>
                    <input type="text" name="title" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="font-weight-bold">Isi Pengumuman</label>
                    <textarea name="content" class="form-control" rows="6" required></textarea>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label class="font-weight-bold">File Lampiran (Opsional)</label>
                        <input type="file" name="file" class="form-control-file border p-1 rounded w-100">
                    </div>
                    <div class="col-md-6">
                        <label class="font-weight-bold">Berlaku Sampai</label>
                        <input type="date" name="expired_at" class="form-control">
                    </div>
                </div>
                <div class="custom-control custom-switch mt-4">
                    <input type="checkbox" class="custom-control-input" id="active" name="active" value="1" checked>
                    <label class="custom-control-label text-success font-weight-bold" for="active">Aktifkan Pengumuman</label>
                </div>
                <hr>
                <button type="submit" class="btn px-5 shadow-sm" style="background-color: #C5E384; color: #200F07; font-weight: bold;">TERBITKAN</button>
            </form>
        </div>
    </div>
</div>
@endsection
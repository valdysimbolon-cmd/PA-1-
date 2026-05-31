@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3" style="background-color: #200F07;">
            <h6 class="m-0 font-weight-bold" style="color: #C5E384;">Tambah Banner Video Baru</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('heroes.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="font-weight-bold">Slogan Utama (Title)</label>
                    <input type="text" name="title" class="form-control" placeholder="Contoh: Engineering the Future" required>
                </div>

                <div class="form-group">
                    <label class="font-weight-bold">Sub-Slogan (Subtitle)</label>
                    <textarea name="subtitle" class="form-control" rows="2" placeholder="Teks kecil di bawah judul..."></textarea>
                </div>

                <div class="form-group">
                    <label class="font-weight-bold text-primary">Link Video YouTube</label>
                    <input type="text" name="video_url" class="form-control" placeholder="https://www.youtube.com/watch?v=..." required>
                    <small class="text-muted">Buka video YouTube, lalu copy alamat URL-nya ke sini.</small>
                </div>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold">Teks Tombol</label>
                            <input type="text" name="button_1_text" class="form-control" value="Daftar Sekarang">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold">Link Tombol (URL)</label>
                            <input type="text" name="button_1_url" class="form-control" placeholder="https://...">
                        </div>
                    </div>
                </div>

                <div class="custom-control custom-switch p-3 border rounded bg-light mt-3">
                    <input type="checkbox" class="custom-control-input" id="active" name="active" value="1" checked>
                    <label class="custom-control-label font-weight-bold text-success" for="active">Aktifkan Banner ini</label>
                </div>

                <hr>
                <button type="submit" class="btn shadow-sm px-5" style="background-color: #C5E384; color: #200F07; font-weight: bold;">
                    <i class="fas fa-save mr-2"></i> Simpan Banner
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
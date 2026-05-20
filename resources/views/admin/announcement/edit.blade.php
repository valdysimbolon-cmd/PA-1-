@extends('layouts.admin')

@section('title', 'Edit Pengumuman')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Pengumuman</h1>
        <a href="{{ route('announcements.index') }}" class="btn btn-secondary btn-sm shadow-sm">
            <i class="fas fa-arrow-left fa-sm"></i> Batal
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3" style="background-color: #200F07;">
            <h6 class="m-0 font-weight-bold" style="color: #C5E384;">
                <i class="fas fa-edit mr-2"></i>Perbarui Data Pengumuman
            </h6>
        </div>
        <div class="card-body">
            <form action="{{ route('announcements.update', $announcement->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="form-group">
                    <label class="font-weight-bold text-dark">Judul Pengumuman</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title', $announcement->title) }}" required>
                </div>

                <div class="form-group mt-3">
                    <label class="font-weight-bold text-dark">Detail Informasi</label>
                    <textarea name="content" id="editor" class="form-control">{{ old('content', $announcement->content) }}</textarea>
                </div>

                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold text-dark">Berlaku Sampai</label>
                            <input type="date" name="expired_at" class="form-control" 
                                   value="{{ old('expired_at', $announcement->expired_at ? $announcement->expired_at->format('Y-m-d') : '') }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold text-dark">Lampiran Dokumen</label>
                            @if($announcement->attachment_file)
                                <div class="mb-2">
                                    <span class="badge badge-light border"><i class="fas fa-paperclip mr-1"></i> File saat ini: {{ basename($announcement->attachment_file) }}</span>
                                </div>
                            @endif
                            <div class="custom-file">
                                <input type="file" name="attachment_file" class="custom-file-input" id="fileInput">
                                <label class="custom-file-label" for="fileInput">Ganti file lampiran...</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="custom-control custom-switch p-3 border rounded shadow-sm bg-light">
                            <input type="checkbox" class="custom-control-input" id="is_urgent" name="is_urgent" value="1" {{ old('is_urgent', $announcement->is_urgent) ? 'checked' : '' }}>
                            <label class="custom-control-label font-weight-bold text-danger" for="is_urgent">Tandai sebagai PENTING</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="custom-control custom-switch p-3 border rounded shadow-sm bg-white">
                            <input type="checkbox" class="custom-control-input" id="active" name="active" value="1" {{ old('active', $announcement->active) ? 'checked' : '' }}>
                            <label class="custom-control-label font-weight-bold text-success" for="active">Tampilkan di Website</label>
                        </div>
                    </div>
                </div>

                <hr class="mt-4">
                <div class="text-right">
                    <button type="submit" class="btn shadow-sm px-5" style="background-color: #C5E384; color: #200F07; font-weight: bold; border: 1px solid #200F07;">
                        <i class="fas fa-check-circle mr-2"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    $('.custom-file-input').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
    });
</script>
@endpush

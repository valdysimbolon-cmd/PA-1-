@extends('layouts.admin')

@section('title', 'Buat Pengumuman Baru')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Buat Pengumuman</h1>
        <a href="{{ route('announcements.index') }}" class="btn btn-secondary btn-sm shadow-sm">
            <i class="fas fa-arrow-left fa-sm"></i> Kembali
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3" style="background-color: #200F07;">
            <h6 class="m-0 font-weight-bold" style="color: #C5E384;">
                <i class="fas fa-bullhorn mr-2"></i>Formulir Pengumuman Baru
            </h6>
        </div>
        <div class="card-body">
            <form action="{{ route('announcements.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <!-- Judul Pengumuman -->
                <div class="form-group">
                    <label class="font-weight-bold text-dark">Judul Pengumuman</label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" 
                           placeholder="Contoh: Jadwal Ujian Tengah Semester Genap" value="{{ old('title') }}" required>
                    @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- Isi Konten -->
                <div class="form-group mt-3">
                    <label class="font-weight-bold text-dark">Detail Informasi</label>
                    <textarea name="content" id="editor" class="form-control">{{ old('content') }}</textarea>
                </div>

                <div class="row mt-4">
                    <!-- Tanggal Kadaluwarsa -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold text-dark">Berlaku Sampai (Expired)</label>
                            <input type="date" name="expired_at" class="form-control" value="{{ old('expired_at') }}">
                            <small class="text-muted">Kosongkan jika pengumuman berlaku selamanya.</small>
                        </div>
                    </div>
                    <!-- Lampiran File -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold text-dark">Lampiran Dokumen (Opsional)</label>
                            <div class="custom-file">
                                <input type="file" name="attachment_file" class="custom-file-input" id="fileInput">
                                <label class="custom-file-label" for="fileInput">Pilih PDF/Gambar/Docx...</label>
                            </div>
                            <small class="text-muted">Maksimal: 5MB</small>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <!-- Switch Urgent -->
                    <div class="col-md-6">
                        <div class="custom-control custom-switch p-3 border rounded shadow-sm bg-light mb-2">
                            <input type="checkbox" class="custom-control-input" id="is_urgent" name="is_urgent" value="1" {{ old('is_urgent') ? 'checked' : '' }}>
                            <label class="custom-control-label font-weight-bold text-danger" for="is_urgent" style="cursor:pointer;">
                                <i class="fas fa-exclamation-triangle mr-1"></i> Tandai sebagai PENTING (Urgent)
                            </label>
                        </div>
                    </div>
                    <!-- Switch Active -->
                    <div class="col-md-6">
                        <div class="custom-control custom-switch p-3 border rounded shadow-sm bg-white mb-2">
                            <input type="checkbox" class="custom-control-input" id="active" name="active" value="1" checked>
                            <label class="custom-control-label font-weight-bold text-success" for="active" style="cursor:pointer;">
                                Tampilkan di Website
                            </label>
                        </div>
                    </div>
                </div>

                <hr class="mt-4">
                <div class="text-right">
                    <button type="submit" class="btn shadow-sm px-5" style="background-color: #C5E384; color: #200F07; font-weight: bold; border: 1px solid #200F07;">
                        <i class="fas fa-save mr-2"></i> Posting Pengumuman
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
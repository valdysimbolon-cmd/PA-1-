@extends('layouts.admin')

@section('title', 'Edit Pengumuman')

@section('content')
<div class="container-fluid">
    {{-- Pesan Error Validasi --}}
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3" style="background-color: #200F07;">
            <h6 class="m-0 font-weight-bold" style="color: #C5E384;">Edit Pengumuman: {{ $announcement->title }}</h6>
        </div>
        <div class="card-body">
            {{-- Form Update dengan Method PUT --}}
            <form action="{{ route('announcements.update', $announcement->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row text-dark">
                    <!-- Kiri: Judul dan Konten -->
                    <div class="col-md-8 border-right">
                        <div class="form-group">
                            <label class="font-weight-bold">Judul Pengumuman</label>
                            <input type="text" name="title" class="form-control" value="{{ old('title', $announcement->title) }}" required>
                        </div>
                        <div class="form-group mt-3">
                            <label class="font-weight-bold">Isi Informasi Pengumuman</label>
                            {{-- ID "editor" disamakan dengan Berita --}}
                            <textarea name="content" id="editor" class="form-control">{{ old('content', $announcement->content) }}</textarea>
                        </div>
                    </div>

                    <!-- Kanan: Pengaturan -->
                    <div class="col-md-4">
                        <div class="form-group p-3 bg-light border rounded shadow-sm">
                            <label class="font-weight-bold">Kategori</label>
                            <select name="category_id" class="form-control" required>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ $announcement->category_id == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>

                            <label class="font-weight-bold mt-3">Lampiran Berkas (Opsional)</label>
                            @if($announcement->attachment_file)
                                <div class="mb-2">
                                    <a href="{{ asset('storage/' . $announcement->attachment_file) }}" target="_blank" class="badge badge-primary p-2">
                                        <i class="fas fa-file-pdf"></i> Lihat File Saat Ini
                                    </a>
                                </div>
                            @endif
                            <input type="file" name="attachment_file" class="form-control-file border p-2 rounded w-100 bg-white">
                            <small class="text-muted italic">Kosongkan jika tidak ingin ganti berkas.</small>

                            <label class="font-weight-bold mt-3">Berlaku Sampai</label>
                            <input type="date" name="expired_at" class="form-control" value="{{ old('expired_at', $announcement->expired_at ? $announcement->expired_at->format('Y-m-d') : '') }}">
                        </div>

                        <div class="custom-control custom-switch mt-4 p-3 border rounded shadow-sm bg-white">
                            <input type="checkbox" class="custom-control-input" id="is_urgent" name="is_urgent" value="1" {{ $announcement->is_urgent ? 'checked' : '' }}>
                            <label class="custom-control-label text-danger font-weight-bold" for="is_urgent" style="cursor:pointer;">Tandai sebagai PENTING</label>
                        </div>

                        <div class="custom-control custom-switch mt-3 p-3 border rounded shadow-sm bg-white">
                            <input type="checkbox" class="custom-control-input" id="active" name="active" value="1" {{ $announcement->active ? 'checked' : '' }}>
                            <label class="custom-control-label text-success font-weight-bold" for="active" style="cursor:pointer;">Aktifkan (Tampil di Web)</label>
                        </div>

                        <hr class="mt-4">
                        <button type="submit" class="btn btn-block py-3 shadow" style="background-color: #C5E384; color: #200F07; font-weight: bold; border: 1px solid #200F07;">
                            <i class="fas fa-check-circle mr-2"></i>SIMPAN PERUBAHAN
                        </button>
                        <a href="{{ route('announcements.index') }}" class="btn btn-secondary btn-block mt-2">Batal</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
{{-- Memanggil Library CKEditor dari CDN (Identik denga Berita) --}}
<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('editor', {
        height: 500,
        removeButtons: 'PasteFromWord'
    });
</script>
@endpush
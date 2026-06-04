@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4 border-bottom-dark">
        <div class="card-header py-3" style="background-color: #200F07;">
            <h6 class="m-0 font-weight-bold" style="color: #C5E384;"><i class="fas fa-bullhorn mr-2"></i>Buat Pengumuman Baru</h6>
        </div>
        <div class="card-body text-dark">
            <form action="{{ route('announcements.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label class="font-weight-bold">Judul Pengumuman</label>
                            <input type="text" name="title" class="form-control" placeholder="Contoh: Jadwal Pengisian KRS" required>
                        </div>
                        <div class="form-group mt-3">
                            <label class="font-weight-bold">Isi Pengumuman</label>
                            {{-- ID editor digunakan untuk inisialisasi CKEditor --}}
                            <textarea name="content" id="editor" class="form-control" rows="10"></textarea>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group p-3 bg-light border rounded">
                            <label class="font-weight-bold">Kategori</label>
                            <select name="category_id" class="form-control" required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>

                            <label class="font-weight-bold mt-3">File Lampiran (Opsional)</label>
                            <input type="file" name="attachment_file" class="form-control-file border p-1 rounded bg-white w-100">
                            <small class="text-muted italic">PDF/JPG/PNG/DOCX. Maks 5MB.</small>

                            <label class="font-weight-bold mt-3">Berlaku Sampai</label>
                            <input type="date" name="expired_at" class="form-control">
                        </div>

                        <div class="custom-control custom-switch mt-4">
                            <input type="checkbox" class="custom-control-input" id="is_urgent" name="is_urgent" value="1">
                            <label class="custom-control-label text-danger font-weight-bold" for="is_urgent" style="cursor:pointer;">Tandai PENTING</label>
                        </div>

                        <div class="custom-control custom-switch mt-3">
                            <input type="checkbox" class="custom-control-input" id="active" name="active" value="1" checked>
                            <label class="custom-control-label text-success font-weight-bold" for="active" style="cursor:pointer;">Aktifkan</label>
                        </div>

                        <hr>
                        <button type="submit" class="btn btn-block py-2 shadow" style="background-color: #C5E384; color: #200F07; font-weight: bold; border: 1px solid #200F07;">
                            <i class="fas fa-save mr-1"></i> SIMPAN & POSTING
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
{{-- Memanggil Library CKEditor dari CDN --}}
<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
<script>
    // Inisialisasi CKEditor pada element denga id="editor"
    CKEDITOR.replace('editor');
</script>
@endpush
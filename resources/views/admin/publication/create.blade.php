@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3" style="background-color: #200F07;">
            <h6 class="m-0 font-weight-bold" style="color: #C5E384;">Input Publikasi Karya Baru</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('publications.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="font-weight-bold">Judul Lengkap Karya / Penelitian</label>
                    <textarea name="title" class="form-control" rows="2" required></textarea>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <label class="font-weight-bold">Tipe Publikasi</label>
                        <select name="type" class="form-control">
                            <option value="Publikasi Jurnal">Publikasi Jurnal</option>
                            <option value="Buku / Monograf">Buku / Monograf</option>
                            <option value="Prosiding / Seminar">Prosiding / Seminar</option>
                            <option value="Penelitian">Penelitian / Riset</option>
                            <option value="Pengabdian">Pengabdian Masyarakat</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="font-weight-bold">Penerbit / Publisher</label>
                        <input type="text" name="publisher" class="form-control" placeholder="Contoh: IEEE / Elsevier">
                    </div>
                    <div class="col-md-2">
                        <label class="font-weight-bold">Tahun</label>
                        <input type="number" name="year" class="form-control" value="{{ date('Y') }}">
                    </div>
                    <div class="col-md-2">
                        <label class="font-weight-bold">Tampilkan?</label>
                        <select name="active" class="form-control">
                            <option value="1">Aktif</option>
                            <option value="0">Draft</option>
                        </select>
                    </div>
                </div>

                <div class="card bg-light p-3 mt-4 border-left-success">
                    <label class="font-weight-bold text-success">Daftar Penulis (Dosen/Staff)</label>
                    <div id="authorContainer">
                        <div class="d-flex mb-2 author-row">
                            <select name="member_ids[]" class="form-control" required>
                                <option value="">-- Pilih Penulis --</option>
                                @foreach($lecturers as $l)
                                    <option value="{{ $l->id }}">{{ $l->name }}</option>
                                @endforeach
                            </select>
                            <input type="text" name="positions[]" class="form-control ml-2" placeholder="Urutan (1 / Utama)">
                            <button type="button" class="btn btn-success ml-2" onclick="addAuthor()">+</button>
                        </div>
                    </div>
                </div>

                <div class="form-group mt-3">
                    <label class="font-weight-bold">Link URL (DOI/Scholar)</label>
                    <input type="url" name="link" class="form-control" placeholder="https://...">
                </div>

                <hr>
                <button type="submit" class="btn btn-primary px-5 shadow" style="background-color: #200F07; color: #C5E384; font-weight: bold; border: 1px solid #C5E384;">SIMPAN KARYA</button>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function addAuthor() {
        let html = `
        <div class="d-flex mb-2 author-row">
            <select name="member_ids[]" class="form-control" required>
                <option value="">-- Pilih Penulis --</option>
                @foreach($lecturers as $l)
                    <option value="{{ $l->id }}">{{ $l->name }}</option>
                @endforeach
            </select>
            <input type="text" name="positions[]" class="form-control ml-2" placeholder="Posisi">
            <button type="button" class="btn btn-danger ml-2" onclick="this.parentElement.remove()">-</button>
        </div>`;
        $('#authorContainer').append(html);
    }
</script>
@endpush
@endsection
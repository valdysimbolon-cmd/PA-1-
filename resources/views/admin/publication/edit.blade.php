@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-dark text-white">
            <h6 class="m-0 font-weight-bold">Edit Publikasi: {{ Str::limit($publication->title, 50) }}</h6>
        </div>
        <div class="card-body text-dark">
            <form action="{{ route('publications.update', $publication->id) }}" method="POST">
                @csrf @method('PUT')
                
                <div class="form-group">
                    <label class="font-weight-bold">Judul Lengkap</label>
                    <textarea name="title" class="form-control" rows="2" required>{{ $publication->title }}</textarea>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <label class="font-weight-bold">Tipe</label>
                        <select name="type" class="form-control">
                            @foreach(['Publikasi Jurnal','Buku / Monograf','Prosiding / Seminar','Penelitian','Pengabdian'] as $t)
                                <option value="{{ $t }}" {{ $publication->type == $t ? 'selected' : '' }}>{{ $t }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="font-weight-bold">Penerbit</label>
                        <input type="text" name="publisher" class="form-control" value="{{ $publication->publisher }}">
                    </div>
                    <div class="col-md-2">
                        <label class="font-weight-bold">Tahun</label>
                        <input type="number" name="year" class="form-control" value="{{ $publication->year }}">
                    </div>
                    <div class="col-md-2">
                        <label class="font-weight-bold">Status</label>
                        <select name="active" class="form-control">
                            <option value="1" {{ $publication->active ? 'selected' : '' }}>Aktif</option>
                            <option value="0" {{ !$publication->active ? 'selected' : '' }}>Draft</option>
                        </select>
                    </div>
                </div>

                <div class="card bg-light p-3 mt-4 border-left-primary">
                    <label class="font-weight-bold">Daftar Penulis</label>
                    <div id="authorContainer">
                        @foreach($publication->authors as $index => $author)
                        <div class="d-flex mb-2 author-row">
                            <select name="member_ids[]" class="form-control" required>
                                @foreach($lecturers as $l)
                                    <option value="{{ $l->id }}" {{ $author->author_id == $l->id ? 'selected' : '' }}>{{ $l->name }}</option>
                                @endforeach
                            </select>
                            <input type="text" name="positions[]" class="form-control ml-2" value="{{ $author->position }}">
                            @if($loop->first)
                                <button type="button" class="btn btn-success ml-2" onclick="addAuthor()">+</button>
                            @else
                                <button type="button" class="btn btn-danger ml-2" onclick="this.parentElement.remove()">-</button>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>

                <hr>
                <button type="submit" class="btn btn-primary shadow px-5">UPDATE KARYA</button>
                <a href="{{ route('publications.index') }}" class="btn btn-secondary">Batal</a>
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
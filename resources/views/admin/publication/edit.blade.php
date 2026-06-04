@extends('layouts.admin')

@section('title', 'Edit Publikasi')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-sm border-0">
                <div class="card-header py-3" style="background-color: #200F07;">
                    <h6 class="m-0 font-weight-bold" style="color: #C5E384;">
                        <i class="fas fa-edit me-2"></i>Edit Publikasi: {{ Str::limit($publication->title, 50) }}
                    </h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('publications.update', $publication->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Judul Lengkap Karya / Penelitian</label>
                            <textarea name="title" class="form-control @error('title') is-invalid @enderror" rows="2" required>{{ old('title', $publication->title) }}</textarea>
                            @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Tipe Publikasi</label>
                                <select name="type" class="form-select">
                                    <option value="Publikasi Jurnal" {{ $publication->type == 'Publikasi Jurnal' ? 'selected' : '' }}>Publikasi Jurnal</option>
                                    <option value="Buku / Monograf" {{ $publication->type == 'Buku / Monograf' ? 'selected' : '' }}>Buku / Monograf</option>
                                    <option value="Prosiding / Seminar" {{ $publication->type == 'Prosiding / Seminar' ? 'selected' : '' }}>Prosiding / Seminar</option>
                                    <option value="Penelitian" {{ $publication->type == 'Penelitian' ? 'selected' : '' }}>Penelitian / Riset</option>
                                    <option value="Pengabdian" {{ $publication->type == 'Pengabdian' ? 'selected' : '' }}>Pengabdian Masyarakat</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Penerbit / Publisher</label>
                                <input type="text" name="publisher" class="form-control" value="{{ old('publisher', $publication->publisher) }}" placeholder="Contoh: IEEE / Elsevier">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label fw-semibold">Tahun</label>
                                <input type="number" name="year" class="form-control" value="{{ old('year', $publication->year) }}">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label fw-semibold">Status</label>
                                <select name="active" class="form-select">
                                    <option value="1" {{ $publication->active ? 'selected' : '' }}>Aktif</option>
                                    <option value="0" {{ !$publication->active ? 'selected' : '' }}>Draft</option>
                                </select>
                            </div>
                        </div>

                        <!-- Daftar Penulis (dinamis) -->
                        <div class="card border mt-4 mb-3">
                            <div class="card-header bg-light d-flex justify-content-between align-items-center py-2">
                                <span class="fw-semibold small">Daftar Penulis (Dosen/Staff)</span>
                                <button type="button" class="btn btn-sm btn-success" onclick="addAuthor()">+ Tambah Penulis</button>
                            </div>
                            <div class="card-body p-0">
                                <div id="authorContainer" class="p-3">
                                    @foreach($publication->authors as $index => $author)
                                    <div class="d-flex gap-2 mb-2 author-row">
                                        <select name="member_ids[]" class="form-select" required style="flex: 2;">
                                            @foreach($lecturers as $l)
                                                <option value="{{ $l->id }}" {{ $author->author_id == $l->id ? 'selected' : '' }}>{{ $l->name }}</option>
                                            @endforeach
                                        </select>
                                        <input type="text" name="positions[]" class="form-control" value="{{ $author->position }}" placeholder="Posisi / Urutan" style="flex: 1;">
                                        @if($loop->first)
                                            <button type="button" class="btn btn-sm btn-success" onclick="addAuthor()">+</button>
                                        @else
                                            <button type="button" class="btn btn-sm btn-danger" onclick="this.closest('.author-row').remove()">-</button>
                                        @endif
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Link URL (DOI / Google Scholar)</label>
                            <input type="url" name="link" class="form-control" value="{{ old('link', $publication->link) }}" placeholder="https://...">
                        </div>

                        <hr class="my-4">
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success px-4">
                                <i class="fas fa-save"></i> Perbarui Publikasi
                            </button>
                            <a href="{{ route('publications.index') }}" class="btn btn-secondary px-4">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function addAuthor() {
        const container = document.getElementById('authorContainer');
        const newRow = document.createElement('div');
        newRow.className = 'd-flex gap-2 mb-2 author-row';
        newRow.innerHTML = `
            <select name="member_ids[]" class="form-select" required style="flex: 2;">
                <option value="">-- Pilih Penulis --</option>
                @foreach($lecturers as $l)
                    <option value="{{ $l->id }}">{{ $l->name }}</option>
                @endforeach
            </select>
            <input type="text" name="positions[]" class="form-control" placeholder="Posisi / Urutan" style="flex: 1;">
            <button type="button" class="btn btn-sm btn-danger" onclick="this.closest('.author-row').remove()">-</button>
        `;
        container.appendChild(newRow);
    }
</script>
@endpush
@endsection
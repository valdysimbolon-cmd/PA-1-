@extends('layouts.admin')

@section('title', 'Tambah Publikasi')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-sm border-0">
                <div class="card-header py-3" style="background-color: #200F07;">
                    <h6 class="m-0 font-weight-bold" style="color: #C5E384;">
                        <i class="fas fa-plus-circle me-2"></i>Input Publikasi Karya Baru
                    </h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('publications.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Judul Lengkap Karya / Penelitian</label>
                            <textarea name="title" class="form-control @error('title') is-invalid @enderror" rows="2" required>{{ old('title') }}</textarea>
                            @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Tipe Publikasi</label>
                                <select name="type" class="form-select @error('type') is-invalid @enderror">
                                    <option value="Publikasi Jurnal" {{ old('type') == 'Publikasi Jurnal' ? 'selected' : '' }}>Publikasi Jurnal</option>
                                    <option value="Buku / Monograf" {{ old('type') == 'Buku / Monograf' ? 'selected' : '' }}>Buku / Monograf</option>
                                    <option value="Prosiding / Seminar" {{ old('type') == 'Prosiding / Seminar' ? 'selected' : '' }}>Prosiding / Seminar</option>
                                    <option value="Penelitian" {{ old('type') == 'Penelitian' ? 'selected' : '' }}>Penelitian / Riset</option>
                                    <option value="Pengabdian" {{ old('type') == 'Pengabdian' ? 'selected' : '' }}>Pengabdian Masyarakat</option>
                                </select>
                                @error('type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Penerbit / Publisher</label>
                                <input type="text" name="publisher" class="form-control @error('publisher') is-invalid @enderror" value="{{ old('publisher') }}" placeholder="Contoh: IEEE / Elsevier">
                                @error('publisher') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-2">
                                <label class="form-label fw-semibold">Tahun</label>
                                <input type="number" name="year" class="form-control @error('year') is-invalid @enderror" value="{{ old('year', date('Y')) }}">
                                @error('year') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-2">
                                <label class="form-label fw-semibold">Status</label>
                                <select name="active" class="form-select">
                                    <option value="1" {{ old('active', 1) == 1 ? 'selected' : '' }}>Aktif</option>
                                    <option value="0" {{ old('active') === 0 ? 'selected' : '' }}>Draft</option>
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
                                    <div class="d-flex gap-2 mb-2 author-row">
                                        <select name="member_ids[]" class="form-select" required style="flex: 2;">
                                            <option value="">-- Pilih Penulis --</option>
                                            @foreach($lecturers as $l)
                                                <option value="{{ $l->id }}">{{ $l->name }}</option>
                                            @endforeach
                                        </select>
                                        <input type="text" name="positions[]" class="form-control" placeholder="Posisi / Urutan" style="flex: 1;">
                                        <button type="button" class="btn btn-sm btn-success" onclick="addAuthor()">+</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Link URL (DOI / Google Scholar)</label>
                            <input type="url" name="link" class="form-control @error('link') is-invalid @enderror" value="{{ old('link') }}" placeholder="https://...">
                            @error('link') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <hr class="my-4">
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success px-4">
                                <i class="fas fa-save"></i> Simpan Publikasi
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
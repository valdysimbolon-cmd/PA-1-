@extends('layouts.admin')
@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Artikel & Berita</h1>
    <a href="{{ route('news.create') }}" class="btn btn-sm shadow-sm" style="background-color: #C5E384; color: #200F07; font-weight: bold;">
        <i class="fas fa-edit"></i> Tulis Berita
    </a>
</div>

<div class="card shadow">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Gambar</th>
                        <th>Judul</th>
                        <th>Kategori</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($news as $n)
                    <tr>
                        <td>
                            @if($n->image)
                                <img src="{{ asset('storage/'.$n->image) }}" width="70" class="rounded border shadow-sm">
                            @else
                                <div class="bg-light rounded text-center small py-2" style="width:70px">No Pic</div>
                            @endif
                        </td>
                        <td><strong>{{ \Illuminate\Support\Str::limit($n->title, 50) }}</strong></td>
                        <td><span class="badge badge-light border">{{ $n->category->name }}</span></td>
                        <td>{{ date('d M Y', strtotime($n->published_at)) }}</td>
                        <td>
                            <span class="badge {{ $n->active ? 'badge-success' : 'badge-warning' }}">
                                {{ $n->active ? 'Published' : 'Draft' }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('news.edit', $n->id) }}" class="btn btn-sm btn-info btn-circle"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('news.destroy', $n->id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger btn-circle"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
@extends('backend.layouts.app')

@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="mdi mdi-folder"></i>
            </span> Kategori Produk
        </h3>
        <nav aria-label="breadcrumb">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Kategori</li>
            </ul>
        </nav>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="card-title mb-0">Daftar Kategori</h4>
                        <a href="{{ route('categories.create') }}" class="btn btn-gradient-primary">
                            <i class="mdi mdi-plus"></i> Tambah Kategori
                        </a>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Gambar</th>
                                    <th>Nama</th>
                                    <th>Slug</th>
                                    <th>Icon</th>
                                    <th>Urutan</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($categories as $index => $category)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        @if($category->image)
                                            <img src="{{ strpos($category->image, 'http') === 0 ? $category->image : asset($category->image) }}" alt="{{ $category->name }}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>{{ $category->name }}</td>
                                    <td><code>{{ $category->slug }}</code></td>
                                    <td>{{ $category->icon ?? '-' }}</td>
                                    <td>{{ $category->sort_order }}</td>
                                    <td>
                                        @if($category->is_active)
                                            <label class="badge badge-gradient-success">Aktif</label>
                                        @else
                                            <label class="badge badge-gradient-danger">Nonaktif</label>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-sm btn-gradient-info">
                                            <i class="mdi mdi-pencil"></i> Edit
                                        </a>
                                        <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-gradient-danger">
                                                <i class="mdi mdi-delete"></i> Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center">Belum ada kategori. <a href="{{ route('categories.create') }}">Tambah kategori pertama</a></td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


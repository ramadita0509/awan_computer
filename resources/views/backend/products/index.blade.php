@extends('backend.layouts.app')

@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="mdi mdi-package"></i>
            </span> Daftar Produk
        </h3>
        <nav aria-label="breadcrumb">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Produk</li>
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
                        <h4 class="card-title mb-0">Daftar Produk</h4>
                        <a href="{{ route('products.create') }}" class="btn btn-gradient-primary">
                            <i class="mdi mdi-plus"></i> Tambah Produk
                        </a>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Gambar</th>
                                    <th>Nama</th>
                                    <th>Kategori</th>
                                    <th>Harga</th>
                                    <th>Stok</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($products as $index => $product)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        @if($product->image)
                                            <img src="{{ strpos($product->image, 'http') === 0 ? $product->image : asset($product->image) }}" alt="{{ $product->name }}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->category->name ?? '-' }}</td>
                                    <td>Rp {{ number_format($product->price, 0, ',', '.') }}
                                        @if($product->original_price && $product->original_price > $product->price)
                                            <br><small style="text-decoration: line-through; color: #999;">Rp {{ number_format($product->original_price, 0, ',', '.') }}</small>
                                        @endif
                                    </td>
                                    <td>{{ $product->stock }}</td>
                                    <td>
                                        @if($product->is_active)
                                            <label class="badge badge-gradient-success">Aktif</label>
                                        @else
                                            <label class="badge badge-gradient-danger">Nonaktif</label>
                                        @endif
                                        @if($product->is_featured)
                                            <label class="badge badge-gradient-info">Unggulan</label>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('products.show', $product->id) }}" class="btn btn-sm btn-gradient-primary" title="Lihat Detail">
                                            <i class="mdi mdi-eye"></i>
                                        </a>
                                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-gradient-info" title="Edit">
                                            <i class="mdi mdi-pencil"></i>
                                        </a>
                                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-gradient-danger" title="Hapus">
                                                <i class="mdi mdi-delete"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center">Belum ada produk. <a href="{{ route('products.create') }}">Tambah produk pertama</a></td>
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


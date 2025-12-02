@extends('backend.layouts.app')

@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="mdi mdi-eye"></i>
            </span> Detail Produk
        </h3>
        <nav aria-label="breadcrumb">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Produk</a></li>
                <li class="breadcrumb-item active" aria-current="page">Detail</li>
            </ul>
        </nav>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-12 text-center">
                            @if($product->image)
                                <img src="{{ strpos($product->image, 'http') === 0 ? $product->image : asset($product->image) }}" alt="{{ $product->name }}" style="max-width: 100%; max-height: 400px; border-radius: 8px;">
                            @else
                                <div class="bg-light" style="height: 400px; display: flex; align-items: center; justify-content: center; border-radius: 8px;">
                                    <span class="text-muted">Tidak ada gambar</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <h4 class="mb-3">{{ $product->name }}</h4>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Kategori:</strong>
                            <p>{{ $product->category->name ?? '-' }}</p>
                        </div>
                        <div class="col-md-6">
                            <strong>Slug:</strong>
                            <p><code>{{ $product->slug }}</code></p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Harga:</strong>
                            <p class="h5 text-primary">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                        </div>
                        <div class="col-md-6">
                            <strong>Harga Asli:</strong>
                            @if($product->original_price && $product->original_price > $product->price)
                                <p class="h6" style="text-decoration: line-through; color: #999;">Rp {{ number_format($product->original_price, 0, ',', '.') }}</p>
                                @php
                                    $discount = (($product->original_price - $product->price) / $product->original_price) * 100;
                                @endphp
                                <p class="text-success">Diskon: {{ number_format($discount, 0) }}%</p>
                            @else
                                <p>-</p>
                            @endif
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Stok:</strong>
                            <p>{{ $product->stock }}</p>
                        </div>
                        <div class="col-md-6">
                            <strong>Status:</strong>
                            <p>
                                @if($product->is_active)
                                    <label class="badge badge-gradient-success">Aktif</label>
                                @else
                                    <label class="badge badge-gradient-danger">Nonaktif</label>
                                @endif
                                @if($product->is_featured)
                                    <label class="badge badge-gradient-info">Unggulan</label>
                                @endif
                            </p>
                        </div>
                    </div>

                    @if($product->description)
                    <div class="mb-3">
                        <strong>Deskripsi:</strong>
                        <p>{{ $product->description }}</p>
                    </div>
                    @endif

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Dibuat:</strong>
                            <p>{{ $product->created_at->format('d M Y H:i') }}</p>
                        </div>
                        <div class="col-md-6">
                            <strong>Diperbarui:</strong>
                            <p>{{ $product->updated_at->format('d M Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Aksi</h5>
                    <div class="d-grid gap-2">
                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-gradient-info">
                            <i class="mdi mdi-pencil"></i> Edit Produk
                        </a>
                        <a href="{{ route('products.index') }}" class="btn btn-light">
                            <i class="mdi mdi-arrow-left"></i> Kembali ke Daftar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


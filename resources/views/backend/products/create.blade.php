@extends('backend.layouts.app')

@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="mdi mdi-plus"></i>
            </span> Tambah Produk
        </h3>
        <nav aria-label="breadcrumb">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Produk</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tambah</li>
            </ul>
        </nav>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="category_id">Kategori <span class="text-danger">*</span></label>
                            <select class="form-control @error('category_id') is-invalid @enderror" id="category_id" name="category_id" required>
                                <option value="">Pilih Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="name">Nama Produk <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="slug">Slug</label>
                            <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug" value="{{ old('slug') }}" placeholder="Akan di-generate otomatis jika kosong">
                            @error('slug')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="description">Deskripsi</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="image">Gambar Produk</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" accept="image/*" onchange="previewImage(this)">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Format: JPG, PNG, GIF. Maksimal 2MB</small>
                            <div id="imagePreview" class="mt-3" style="display: none;">
                                <img id="previewImg" src="" alt="Preview" style="max-width: 300px; max-height: 300px; border: 1px solid #ddd; padding: 5px; border-radius: 5px;">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="image_url">Atau URL Gambar (opsional)</label>
                            <input type="text" class="form-control @error('image_url') is-invalid @enderror" id="image_url" name="image_url" value="{{ old('image_url') }}" placeholder="https://...">
                            @error('image_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Jika upload file, URL akan diabaikan</small>
                        </div>

                        <div class="form-group">
                            <label for="images">Gambar Tambahan (Multiple Images)</label>
                            <input type="file" class="form-control @error('images.*') is-invalid @enderror" id="images" name="images[]" accept="image/*" multiple onchange="previewMultipleImages(this)">
                            @error('images.*')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Format: JPG, PNG, GIF. Maksimal 2MB per gambar. Bisa upload beberapa gambar sekaligus.</small>
                            <div id="multipleImagePreview" class="mt-3" style="display: none;">
                                <div class="row" id="previewContainer"></div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="original_price">Harga <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('original_price') is-invalid @enderror" id="original_price" name="original_price" value="{{ old('original_price') }}" placeholder="1.000.000" required oninput="formatNumber(this); calculatePrice();">
                                    @error('original_price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Masukkan harga tanpa titik (contoh: 1000000)</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="discount">Diskon (%)</label>
                                    <input type="number" class="form-control @error('discount') is-invalid @enderror" id="discount" name="discount" value="{{ old('discount', 0) }}" min="0" max="100" step="0.01" oninput="calculatePrice();">
                                    @error('discount')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Harga Akhir</label>
                                    <input type="text" class="form-control" id="price_display" readonly style="background-color: #f5f5f5; font-weight: bold; font-size: 18px;">
                                    <input type="hidden" id="price" name="price">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="stock">Stok</label>
                                    <input type="number" class="form-control @error('stock') is-invalid @enderror" id="stock" name="stock" value="{{ old('stock', 0) }}" min="0">
                                    @error('stock')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="sort_order">Urutan</label>
                                    <input type="number" class="form-control @error('sort_order') is-invalid @enderror" id="sort_order" name="sort_order" value="{{ old('sort_order', 0) }}" min="0">
                                    @error('sort_order')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    Aktif
                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" value="1" {{ old('is_featured', false) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_featured">
                                    Produk Unggulan
                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-gradient-primary">Simpan</button>
                            <a href="{{ route('products.index') }}" class="btn btn-light">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('name').addEventListener('input', function() {
    if (!document.getElementById('slug').value) {
        const slug = this.value.toLowerCase()
            .replace(/[^a-z0-9]+/g, '-')
            .replace(/(^-|-$)/g, '');
        document.getElementById('slug').value = slug;
    }
});

function formatNumber(input) {
    // Remove all non-digit characters
    let value = input.value.replace(/[^\d]/g, '');
    // Format with dots as thousand separators
    if (value) {
        value = parseInt(value).toLocaleString('id-ID');
    }
    input.value = value;
}

function calculatePrice() {
    const originalPriceInput = document.getElementById('original_price');
    const discountInput = document.getElementById('discount');
    const priceInput = document.getElementById('price');
    const priceDisplay = document.getElementById('price_display');

    // Get numeric value (remove dots)
    const originalPrice = parseFloat(originalPriceInput.value.replace(/[^\d]/g, '')) || 0;
    const discount = parseFloat(discountInput.value) || 0;

    // Calculate final price
    const finalPrice = originalPrice - (originalPrice * discount / 100);

    // Update hidden input with numeric value
    priceInput.value = finalPrice;

    // Update display with formatted value
    if (finalPrice > 0) {
        priceDisplay.value = 'Rp ' + finalPrice.toLocaleString('id-ID');
    } else {
        priceDisplay.value = '';
    }
}

function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('previewImg').src = e.target.result;
            document.getElementById('imagePreview').style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    } else {
        document.getElementById('imagePreview').style.display = 'none';
    }
}

function previewMultipleImages(input) {
    const previewContainer = document.getElementById('previewContainer');
    previewContainer.innerHTML = '';

    if (input.files && input.files.length > 0) {
        document.getElementById('multipleImagePreview').style.display = 'block';

        Array.from(input.files).forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const col = document.createElement('div');
                col.className = 'col-md-3 mb-3';
                col.innerHTML = `
                    <div style="position: relative;">
                        <img src="${e.target.result}" alt="Preview ${index + 1}" style="width: 100%; height: 150px; object-fit: cover; border: 1px solid #ddd; border-radius: 5px; padding: 5px;">
                    </div>
                `;
                previewContainer.appendChild(col);
            };
            reader.readAsDataURL(file);
        });
    } else {
        document.getElementById('multipleImagePreview').style.display = 'none';
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    calculatePrice();
});
</script>
@endsection


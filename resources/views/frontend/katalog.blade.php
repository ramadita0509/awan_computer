@extends('frontend.layouts.app')

@section('title', 'Katalog Produk - AWAN KOMPUTER')
@section('description', 'Katalog lengkap produk komputer dan elektronik di AWAN KOMPUTER')

@push('styles')
<style>
	.katalog-wrapper {
		padding: 40px 0;
	}
	.filter-sidebar {
		background: #fff;
		border-radius: 8px;
		box-shadow: 0 2px 10px rgba(0,0,0,0.1);
		padding: 25px;
		margin-bottom: 30px;
		position: sticky;
		top: 20px;
	}
	.filter-section {
		margin-bottom: 30px;
		padding-bottom: 25px;
		border-bottom: 1px solid #eee;
	}
	.filter-section:last-child {
		border-bottom: none;
		margin-bottom: 0;
		padding-bottom: 0;
	}
	.filter-title {
		font-size: 16px;
		font-weight: bold;
		color: #333;
		margin-bottom: 15px;
		display: flex;
		align-items: center;
		gap: 8px;
	}
	.filter-title i {
		color: #4A90E2;
	}
	.filter-search {
		position: relative;
		margin-bottom: 15px;
	}
	.filter-search input {
		width: 100%;
		padding: 10px 15px;
		padding-right: 40px;
		border: 1px solid #ddd;
		border-radius: 5px;
		font-size: 14px;
	}
	.filter-search button {
		position: absolute;
		right: 5px;
		top: 50%;
		transform: translateY(-50%);
		background: #4A90E2;
		color: #fff;
		border: none;
		padding: 8px 12px;
		border-radius: 4px;
		cursor: pointer;
	}
	.filter-search button:hover {
		background: #357ABD;
	}
	.category-list {
		list-style: none;
		padding: 0;
		margin: 0;
	}
	.category-list li {
		margin-bottom: 10px;
	}
	.category-list li a {
		display: flex;
		align-items: center;
		padding: 8px 12px;
		border-radius: 5px;
		color: #666;
		text-decoration: none;
		transition: all 0.3s ease;
	}
	.category-list li a:hover,
	.category-list li a.active {
		background: #f0f7ff;
		color: #4A90E2;
		font-weight: 600;
	}
	.category-list li a i {
		margin-right: 8px;
		font-size: 14px;
	}
	.brand-list {
		list-style: none;
		padding: 0;
		margin: 0;
		max-height: 200px;
		overflow-y: auto;
	}
	.brand-list li {
		margin-bottom: 8px;
	}
	.brand-list li label {
		display: flex;
		align-items: center;
		cursor: pointer;
		padding: 6px 10px;
		border-radius: 4px;
		transition: all 0.2s ease;
	}
	.brand-list li label:hover {
		background: #f5f5f5;
	}
	.brand-list li input[type="checkbox"] {
		margin-right: 10px;
		width: 18px;
		height: 18px;
		cursor: pointer;
	}
	.price-range {
		display: flex;
		gap: 10px;
		margin-bottom: 15px;
	}
	.price-range input {
		flex: 1;
		padding: 10px;
		border: 1px solid #ddd;
		border-radius: 5px;
		font-size: 14px;
	}
	.price-range input::placeholder {
		color: #999;
	}
	.price-slider {
		margin: 20px 0;
	}
	.filter-checkbox {
		display: flex;
		align-items: center;
		margin-bottom: 12px;
		cursor: pointer;
	}
	.filter-checkbox input[type="checkbox"] {
		width: 18px;
		height: 18px;
		margin-right: 10px;
		cursor: pointer;
	}
	.filter-checkbox label {
		cursor: pointer;
		margin: 0;
		color: #666;
		font-size: 14px;
	}
	.filter-actions {
		margin-top: 20px;
	}
	.btn-filter {
		width: 100%;
		padding: 12px;
		background: #4A90E2;
		color: #fff;
		border: none;
		border-radius: 5px;
		font-weight: 600;
		cursor: pointer;
		transition: all 0.3s ease;
	}
	.btn-filter:hover {
		background: #357ABD;
	}
	.btn-reset {
		width: 100%;
		padding: 12px;
		background: #4A90E2;
		color: #fff;
		border: none;
		border-radius: 5px;
		margin-top: 10px;
		cursor: pointer;
		transition: all 0.3s ease;
		font-weight: 600;
		text-decoration: none;
		display: block;
		text-align: center;
	}
	.btn-reset:hover {
		background: #357ABD;
		color: #fff;
		text-decoration: none;
	}
	.products-header {
		display: flex;
		justify-content: space-between;
		align-items: center;
		margin-bottom: 25px;
		padding: 15px;
		background: #fff;
		border-radius: 8px;
		box-shadow: 0 2px 5px rgba(0,0,0,0.05);
	}
	.products-count {
		font-size: 14px;
		color: #666;
	}
	.sort-select {
		padding: 8px 15px;
		border: 1px solid #ddd;
		border-radius: 5px;
		font-size: 14px;
		cursor: pointer;
	}
	.products-grid {
		display: grid;
		grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
		gap: 25px;
		margin-bottom: 40px;
	}
	.product-item {
		background: #fff;
		border-radius: 8px;
		overflow: hidden;
		box-shadow: 0 2px 8px rgba(0,0,0,0.1);
		transition: all 0.3s ease;
	}
	.product-item:hover {
		transform: translateY(-5px);
		box-shadow: 0 5px 20px rgba(0,0,0,0.15);
	}
	.product-thumb {
		position: relative;
		height: 220px;
		overflow: hidden;
	}
	.product-thumb img {
		width: 100%;
		height: 100%;
		object-fit: cover;
		transition: transform 0.3s ease;
	}
	.product-item:hover .product-thumb img {
		transform: scale(1.05);
	}
	.product-content {
		padding: 15px;
	}
	.product-content h4 {
		font-size: 15px;
		font-weight: 600;
		margin: 0 0 10px 0;
		line-height: 1.4;
	}
	.product-content h4 a {
		color: #333;
		text-decoration: none;
	}
	.product-content h4 a:hover {
		color: #4A90E2;
	}
	.product-price {
		font-size: 16px;
		font-weight: bold;
		color: #e74c3c;
		margin: 0;
	}
	.product-price small {
		font-size: 13px;
		color: #999;
		text-decoration: line-through;
		margin-left: 8px;
	}
	.bage {
		position: absolute;
		top: 10px;
		left: 10px;
		padding: 5px 10px;
		border-radius: 4px;
		font-size: 11px;
		font-weight: 600;
		z-index: 10;
		text-transform: uppercase;
	}
	.bage-sale {
		background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
		color: #fff;
	}
	.preview-meta {
		position: absolute;
		bottom: 0;
		left: 0;
		right: 0;
		background: rgba(255,255,255,0.95);
		padding: 10px 0;
		transform: translateY(100%);
		transition: all 0.3s ease;
		opacity: 0;
		visibility: hidden;
		z-index: 2;
	}
	.product-item:hover .preview-meta {
		transform: translateY(0);
		opacity: 1;
		visibility: visible;
	}
	.preview-meta ul {
		display: flex;
		justify-content: center;
		list-style: none;
		padding: 0;
		margin: 0;
	}
	.preview-meta ul li {
		margin: 0 8px;
	}
	.preview-meta ul li a {
		display: block;
		width: 36px;
		height: 36px;
		line-height: 36px;
		text-align: center;
		border-radius: 50%;
		background: #eee;
		color: #333;
		font-size: 16px;
		transition: all 0.2s ease;
	}
	.preview-meta ul li a:hover {
		background: #333;
		color: #fff;
	}
	@media (max-width: 768px) {
		.filter-sidebar {
			position: relative;
			top: 0;
		}
		.products-grid {
			grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
			gap: 15px;
		}
		.products-header {
			flex-direction: column;
			gap: 15px;
			align-items: flex-start;
		}
	}
</style>
@endpush

@section('content')

<!-- Page Header -->
<section class="page-header">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="content">
					<h1 class="page-name">Katalog Produk</h1>
					<ol class="breadcrumb">
						<li><a href="/">Home</a></li>
						<li class="active">Katalog</li>
					</ol>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- Katalog Section -->
<section class="katalog-wrapper">
	<div class="container">
		<div class="row">
			<!-- Filter Sidebar -->
			<div class="col-md-3 col-sm-12">
				<div class="filter-sidebar">
					<form id="filterForm" method="GET" action="{{ route('katalog.index') }}">
						<!-- Search Filter -->
						<div class="filter-section">
							<h3 class="filter-title">
								<i class="tf-ion-ios-search-strong"></i>
								Cari Produk
							</h3>
							<div class="filter-search">
								<input type="text" name="search" placeholder="Cari produk..." value="{{ request('search') }}">
								<button type="submit">
									<i class="tf-ion-ios-search-strong"></i>
								</button>
							</div>
						</div>

						<!-- Category Filter -->
						<div class="filter-section">
							<h3 class="filter-title">
								<i class="tf-ion-grid"></i>
								Kategori
							</h3>
							<ul class="category-list">
								<li>
									<a href="{{ route('katalog.index', array_merge(request()->except('category'), ['category' => 'all'])) }}"
										class="{{ request('category') == 'all' || !request('category') ? 'active' : '' }}">
										<i class="tf-ion-ios-circle-outline"></i>
										Semua Kategori
									</a>
								</li>
								@foreach($categories as $category)
								<li>
									<a href="{{ route('katalog.index', array_merge(request()->except('category'), ['category' => $category->slug])) }}"
										class="{{ request('category') == $category->slug ? 'active' : '' }}">
										<i class="tf-ion-ios-circle-outline"></i>
										{{ $category->name }}
									</a>
								</li>
								@endforeach
							</ul>
						</div>

						<!-- Brand Filter -->
						@if(count($brands) > 0)
						<div class="filter-section">
							<h3 class="filter-title">
								<i class="tf-ion-ios-star"></i>
								Brand
							</h3>
							<ul class="brand-list">
								@foreach($brands as $brand)
								<li>
									<label>
										<input type="checkbox" name="brand[]" value="{{ $brand }}"
											{{ is_array(request('brand')) && in_array($brand, request('brand')) ? 'checked' : '' }}
											onchange="document.getElementById('filterForm').submit();">
										<span>{{ $brand }}</span>
									</label>
								</li>
								@endforeach
							</ul>
						</div>
						@endif

						<!-- Price Range Filter -->
						<div class="filter-section">
							<h3 class="filter-title">
								<i class="tf-ion-cash"></i>
								Harga
							</h3>
							<div class="price-range">
								<input type="text" name="min_price" placeholder="Min"
									value="{{ request('min_price') }}"
									onkeyup="this.value = this.value.replace(/[^0-9]/g, '');">
								<input type="text" name="max_price" placeholder="Max"
									value="{{ request('max_price') }}"
									onkeyup="this.value = this.value.replace(/[^0-9]/g, '');">
							</div>
							<small style="color: #999; font-size: 12px;">
								Range: Rp {{ number_format($minPrice, 0, ',', '.') }} - Rp {{ number_format($maxPrice, 0, ',', '.') }}
							</small>
						</div>

						<!-- Additional Filters -->
						<div class="filter-section">
							<h3 class="filter-title">
								<i class="tf-ion-ios-list"></i>
								Filter Lainnya
							</h3>
							<div class="filter-checkbox">
								<input type="checkbox" name="discount" value="yes" id="filter_discount"
									{{ request('discount') == 'yes' ? 'checked' : '' }}
									onchange="document.getElementById('filterForm').submit();">
								<label for="filter_discount">Ada Diskon</label>
							</div>
							<div class="filter-checkbox">
								<input type="checkbox" name="featured" value="yes" id="filter_featured"
									{{ request('featured') == 'yes' ? 'checked' : '' }}
									onchange="document.getElementById('filterForm').submit();">
								<label for="filter_featured">Produk Unggulan</label>
							</div>
							<div class="filter-checkbox">
								<input type="checkbox" name="stock" value="in_stock" id="filter_stock"
									{{ request('stock') == 'in_stock' ? 'checked' : '' }}
									onchange="document.getElementById('filterForm').submit();">
								<label for="filter_stock">Tersedia Stok</label>
							</div>
						</div>

						<!-- Filter Actions -->
						<div class="filter-actions">
							<button type="submit" class="btn-filter">
								<i class="tf-ion-ios-search-strong"></i> Terapkan Filter
							</button><br><br>
							<a href="{{ route('katalog.index') }}" class="btn-reset">
								<i class="tf-ion-ios-refresh-empty"></i> Reset Filter
							</a>
						</div>
					</form>
				</div>
			</div>

			<!-- Products Grid -->
			<div class="col-md-9 col-sm-12">
				<!-- Products Header -->
				<div class="products-header">
					<div class="products-count">
						Menampilkan <strong>{{ $products->firstItem() ?? 0 }}-{{ $products->lastItem() ?? 0 }}</strong>
						dari <strong>{{ $products->total() }}</strong> produk
					</div>
					<div>
						<select class="sort-select" name="sort" onchange="updateSort(this.value)">
							<option value="newest" {{ request('sort') == 'newest' || !request('sort') ? 'selected' : '' }}>Terbaru</option>
							<option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Harga: Rendah ke Tinggi</option>
							<option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Harga: Tinggi ke Rendah</option>
							<option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Nama: A-Z</option>
						</select>
					</div>
				</div>

				<!-- Products Grid -->
				@if($products->count() > 0)
				<div class="products-grid">
					@foreach($products as $product)
					<div class="product-item">
						<div class="product-thumb">
							@if($product->original_price && $product->original_price > $product->price)
							<span class="bage bage-sale">Sale</span>
							@endif
							<a href="{{ route('frontend.products.show', $product->slug) }}" style="display: block; position: relative;">
								<img class="img-responsive" src="{{ $product->image ? (strpos($product->image, 'http') === 0 ? $product->image : asset($product->image)) : 'https://images.unsplash.com/photo-1525547719571-a2d4ac8945e2?w=600&h=600&fit=crop' }}" alt="{{ $product->name }}" />
							</a>
							<div class="preview-meta">
								<ul>
									<li>
										<a href="{{ route('frontend.products.show', $product->slug) }}" onclick="event.stopPropagation();">
											<i class="tf-ion-ios-search-strong"></i>
										</a>
									</li>
									<li>
										<a href="{{ route('favorites.index') }}" onclick="event.stopPropagation(); addToFavorites(event, {{ $product->id }});">
											<i class="tf-ion-ios-heart"></i>
										</a>
									</li>
											<li>
												<a href="#" onclick="event.stopPropagation(); addToCart(event, {{ $product->id }});"><i class="tf-ion-android-cart"></i></a>
											</li>
								</ul>
							</div>
						</div>
						<div class="product-content">
							<h4><a href="{{ route('frontend.products.show', $product->slug) }}">{{ \Illuminate\Support\Str::limit($product->name, 50) }}</a></h4>
							<p class="product-price">
								Rp {{ number_format($product->price, 0, ',', '.') }}
								@if($product->original_price && $product->original_price > $product->price)
									<small>Rp {{ number_format($product->original_price, 0, ',', '.') }}</small>
								@endif
							</p>
						</div>
					</div>
					@endforeach
				</div>

				<!-- Pagination -->
				@if($products->hasPages())
				<div class="row">
					<div class="col-md-12">
						<nav aria-label="Page navigation">
							<ul class="pagination post-pagination text-center">
								@if($products->onFirstPage())
									<li class="disabled"><span>Prev</span></li>
								@else
									<li><a href="{{ $products->previousPageUrl() }}">Prev</a></li>
								@endif

								@foreach($products->getUrlRange(1, $products->lastPage()) as $page => $url)
									@if($page == $products->currentPage())
										<li class="active"><span>{{ $page }}</span></li>
									@else
										<li><a href="{{ $url }}">{{ $page }}</a></li>
									@endif
								@endforeach

								@if($products->hasMorePages())
									<li><a href="{{ $products->nextPageUrl() }}">Next</a></li>
								@else
									<li class="disabled"><span>Next</span></li>
								@endif
							</ul>
						</nav>
					</div>
				</div>
				@endif
				@else
				<div class="col-md-12 text-center" style="padding: 60px 0;">
					<i class="tf-ion-ios-search-strong" style="font-size: 64px; color: #ddd; margin-bottom: 20px;"></i>
					<h3 style="color: #999; margin-bottom: 10px;">Produk tidak ditemukan</h3>
					<p style="color: #999;">Coba ubah filter atau kata kunci pencarian Anda</p>
					<a href="{{ route('katalog.index') }}" class="btn btn-main" style="margin-top: 20px;">Reset Filter</a>
				</div>
				@endif
			</div>
		</div>
	</div>
</section>

@endsection

@push('scripts')
<script>
	function updateSort(sortValue) {
		const url = new URL(window.location.href);
		url.searchParams.set('sort', sortValue);
		window.location.href = url.toString();
	}

	function addToFavorites(event, productId) {
		event.preventDefault();
		event.stopPropagation();

		$.ajax({
			url: '/favorite/toggle/' + productId,
			method: 'POST',
			data: {
				_token: '{{ csrf_token() }}'
			},
			success: function(data) {
				$.get('/favorite/count', function(countData) {
					$('#favoriteCount').text(countData.count || 0);
				});
				window.location.href = '{{ route("favorites.index") }}';
			},
			error: function() {
				alert('Terjadi kesalahan. Silakan coba lagi.');
			}
		});
	}

	// Format price input with dots
	$(document).ready(function() {
		$('input[name="min_price"], input[name="max_price"]').on('blur', function() {
			let value = $(this).val().replace(/\./g, '');
			if (value) {
				$(this).val(value.replace(/\B(?=(\d{3})+(?!\d))/g, '.'));
			}
		});
	});
</script>
@endpush

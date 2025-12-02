@extends('frontend.layouts.app')

@section('title', $categoryModel->name . ' - AWAN KOMPUTER')
@section('description', 'AWAN KOMPUTER - ' . $categoryModel->name)

@push('styles')
<style>
	.product-item {
		transition: transform 0.3s ease, box-shadow 0.3s ease;
	}
	a:hover .product-item {
		transform: translateY(-5px);
		box-shadow: 0 5px 20px rgba(0,0,0,0.1);
	}
	a .product-item {
		text-decoration: none;
		color: inherit;
	}
	.favorite-toggle.active i {
		color: #e74c3c !important;
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
					<h1 class="page-name">{{ $categoryModel->name }}</h1>
					<ol class="breadcrumb">
						<li><a href="/">Home</a></li>
						<li class="active">{{ $categoryModel->name }}</li>
					</ol>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- Products Section -->
<section class="products section">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="product-shorting">
					<span>Sort By:</span>
					<select class="form-control" style="display: inline-block; width: auto; margin-left: 10px;">
						<option>Default</option>
						<option>Price: Low to High</option>
						<option>Price: High to Low</option>
						<option>Newest</option>
						<option>Most Popular</option>
					</select>
					<span style="margin-left: 20px;">Menampilkan {{ $products->count() }} produk</span>
				</div>
			</div>
		</div>
		<div class="row">
			@forelse($products as $product)
			<div class="col-md-4">
				<div class="product-item">
					<div class="product-thumb">
						@if($product->original_price && $product->original_price > $product->price)
						<span class="bage">Sale</span>
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
						<h4><a href="{{ route('frontend.products.show', $product->slug) }}">{{ $product->name }}</a></h4>
						<p class="price">
							Rp {{ number_format($product->price, 0, ',', '.') }}
							@if($product->original_price && $product->original_price > $product->price)
								<small style="text-decoration: line-through; color: #999; margin-left: 10px;">Rp {{ number_format($product->original_price, 0, ',', '.') }}</small>
							@endif
						</p>
					</div>
				</div>
			</div>
			@empty
			<div class="col-md-12 text-center">
				<p>Belum ada produk dalam kategori ini.</p>
			</div>
			@endforelse
		</div>

		<!-- Product Modals -->
		@foreach($products as $product)
		<div class="modal product-modal fade" id="product-modal-{{ $product->id }}">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<i class="tf-ion-close"></i>
			</button>
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-body">
						<div class="row">
							<div class="col-md-8 col-sm-6 col-xs-12">
								<div class="modal-image">
									<img class="img-responsive" src="{{ $product->image ? (strpos($product->image, 'http') === 0 ? $product->image : asset($product->image)) : 'https://images.unsplash.com/photo-1525547719571-a2d4ac8945e2?w=800&h=800&fit=crop' }}" alt="{{ $product->name }}" />
								</div>
							</div>
							<div class="col-md-4 col-sm-6 col-xs-12">
								<div class="product-short-details">
									<h2 class="product-title">{{ $product->name }}</h2>
									<p class="product-price">
										Rp {{ number_format($product->price, 0, ',', '.') }}
										@if($product->original_price && $product->original_price > $product->price)
											<small style="text-decoration: line-through; color: #999;">Rp {{ number_format($product->original_price, 0, ',', '.') }}</small>
										@endif
									</p>
									<p class="product-short-description">
										{{ $product->description ?? 'Produk berkualitas tinggi dengan garansi resmi.' }}
									</p>
									<a href="{{ route('checkout') }}" class="btn btn-main">Tambah ke Keranjang</a>
									<a href="{{ route('frontend.products.show', $product->slug) }}" class="btn btn-transparent">Lihat Detail Produk</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		@endforeach
	</div>
</section>

@push('scripts')
<script>
	function addToFavorites(event, productId) {
		event.preventDefault();

		// Add to favorites first
		$.ajax({
			url: '/favorite/toggle/' + productId,
			method: 'POST',
			data: {
				_token: '{{ csrf_token() }}'
			},
			success: function(data) {
				// Update favorite count
				$.get('/favorite/count', function(countData) {
					$('#favoriteCount').text(countData.count || 0);
				});

				// Redirect to favorites page
				window.location.href = '{{ route("favorites.index") }}';
			},
			error: function() {
				alert('Terjadi kesalahan. Silakan coba lagi.');
			}
		});
	}
</script>
@endpush

@endsection


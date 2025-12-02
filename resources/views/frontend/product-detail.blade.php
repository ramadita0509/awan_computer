@extends('frontend.layouts.app')

@section('title', $product->name . ' - AWAN KOMPUTER')
@section('description', $product->description ?? $product->name)

@push('styles')
<style>
	.product-detail-section {
		padding: 60px 0;
	}
	.product-gallery {
		position: relative;
	}
	.product-image-slider {
		margin-bottom: 15px;
	}
	.product-image-slider .slick-slide {
		position: relative;
	}
	.product-main-image {
		width: 100%;
		height: 500px;
		object-fit: cover;
		border-radius: 8px;
		cursor: pointer;
	}
	.product-thumbnails {
		display: flex;
		gap: 10px;
		flex-wrap: wrap;
		margin-top: 15px;
	}
	.thumbnail {
		width: 80px;
		height: 80px;
		object-fit: cover;
		border-radius: 4px;
		cursor: pointer;
		border: 2px solid transparent;
		transition: all 0.3s ease;
	}
	.thumbnail:hover,
	.thumbnail.active {
		border-color: #333;
	}
	.product-image-slider .slick-prev,
	.product-image-slider .slick-next {
		z-index: 10;
		width: 40px;
		height: 40px;
		background: rgba(0, 0, 0, 0.5);
		border-radius: 50%;
	}
	.product-image-slider .slick-prev:before,
	.product-image-slider .slick-next:before {
		font-size: 20px;
		color: #fff;
	}
	.product-image-slider .slick-prev {
		left: 10px;
	}
	.product-image-slider .slick-next {
		right: 10px;
	}
	.product-image-slider .slick-dots {
		bottom: 20px;
	}
	.product-image-slider .slick-dots li button:before {
		color: #fff;
		font-size: 12px;
	}
	.favorite-btn {
		background: transparent;
		border: none;
		font-size: 24px;
		cursor: pointer;
		color: #999;
		transition: all 0.3s ease;
	}
	.favorite-btn:hover {
		color: #e74c3c;
	}
	.favorite-btn.active {
		color: #e74c3c;
	}
	.product-info h1 {
		font-size: 32px;
		margin-bottom: 20px;
		color: #333;
	}
	.product-price {
		font-size: 28px;
		font-weight: bold;
		color: #e74c3c;
		margin-bottom: 20px;
	}
	.product-price .original-price {
		font-size: 20px;
		color: #999;
		text-decoration: line-through;
		margin-left: 15px;
	}
	.product-description {
		margin-top: 30px;
		line-height: 1.8;
		color: #666;
	}
	.product-actions {
		margin-top: 30px;
	}
	.product-actions .btn {
		margin-right: 10px;
		margin-bottom: 10px;
	}
	.related-products {
		margin-top: 60px;
		padding-top: 60px;
		border-top: 1px solid #eee;
	}
	.related-product-item {
		text-align: center;
		margin-bottom: 30px;
	}
	.related-product-item img {
		width: 100%;
		height: 200px;
		object-fit: cover;
		border-radius: 8px;
		margin-bottom: 15px;
	}
	.related-product-item h4 {
		font-size: 16px;
		margin-bottom: 10px;
	}
	.related-product-item .price {
		color: #e74c3c;
		font-weight: bold;
	}
	.breadcrumb {
		background: transparent;
		padding: 0;
		margin-bottom: 20px;
	}
	.breadcrumb a {
		color: #666;
		text-decoration: none;
	}
	.breadcrumb a:hover {
		color: #333;
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
					<ol class="breadcrumb">
						<li><a href="/">Home</a></li>
						<li><a href="{{ route('category', $product->category->slug) }}">{{ $product->category->name }}</a></li>
						<li class="active">{{ $product->name }}</li>
					</ol>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- Product Detail Section -->
<section class="product-detail-section">
	<div class="container">
		<div class="row">
			<!-- Product Gallery -->
			<div class="col-md-6">
				<div class="product-gallery">
					@php
						$allImages = collect();
						if ($product->image) {
							$allImages->push($product->image);
						}
						if ($product->images && $product->images->count() > 0) {
							$allImages = $allImages->merge($product->images->pluck('image_path'));
						}
					@endphp

					@if($allImages->count() > 0)
					<div class="product-image-slider">
						@foreach($allImages as $index => $image)
						<div>
							<img src="{{ strpos($image, 'http') === 0 ? $image : asset($image) }}" alt="{{ $product->name }} - Image {{ $index + 1 }}" class="product-main-image">
						</div>
						@endforeach
					</div>
					@else
					<div class="product-image-slider">
						<div>
							<img src="https://images.unsplash.com/photo-1525547719571-a2d4ac8945e2?w=800&h=800&fit=crop" alt="{{ $product->name }}" class="product-main-image">
						</div>
					</div>
					@endif
				</div>
			</div>

			<!-- Product Info -->
			<div class="col-md-6">
				<div class="product-info">
					<h1>{{ $product->name }}</h1>

					<div class="product-price">
						Rp {{ number_format($product->price, 0, ',', '.') }}
						@if($product->original_price && $product->original_price > $product->price)
							<span class="original-price">Rp {{ number_format($product->original_price, 0, ',', '.') }}</span>
							@php
								$discount = (($product->original_price - $product->price) / $product->original_price) * 100;
							@endphp
							<span class="badge" style="background: #e74c3c; color: white; padding: 5px 10px; border-radius: 4px; margin-left: 10px;">
								Diskon {{ number_format($discount, 0) }}%
							</span>
						@endif
					</div>

					<div class="product-meta">
						<p><strong>Kategori:</strong> <a href="{{ route('category', $product->category->slug) }}">{{ $product->category->name }}</a></p>
						<p><strong>Stok:</strong>
							@if($product->stock > 0)
								<span style="color: green;">Tersedia ({{ $product->stock }} unit)</span>
							@else
								<span style="color: red;">Habis</span>
							@endif
						</p>
						@if($product->is_featured)
						<p><span class="badge" style="background: #f093fb; color: white; padding: 5px 10px; border-radius: 4px;">Produk Unggulan</span></p>
						@endif
					</div>

					<div class="product-actions">
						<a href="#" class="btn btn-main" onclick="addToCart(event, {{ $product->id }}, parseInt($('#quantity').val() || 1)); return false;">
							<i class="tf-ion-android-cart"></i> Tambah ke Keranjang
						</a>
						<button class="btn btn-transparent favorite-btn" id="favoriteBtn" data-product-id="{{ $product->id }}">
							<i class="tf-ion-ios-heart"></i> Favorit
						</button>
						<button class="btn btn-transparent" onclick="window.print()">
							<i class="tf-ion-ios-printer"></i> Print
						</button>
					</div>

					@if($product->description)
					<div class="product-description">
						<h3>Deskripsi Produk</h3>
						<p>{{ $product->description }}</p>
					</div>
					@endif
				</div>
			</div>
		</div>

		<!-- Related Products -->
		@if($relatedProducts->count() > 0)
		<div class="related-products">
			<div class="row">
				<div class="col-md-12">
					<h2 class="text-center" style="margin-bottom: 40px;">Produk Terkait</h2>
				</div>
			</div>
			<div class="row">
				@foreach($relatedProducts as $relatedProduct)
				<div class="col-md-3">
					<div class="related-product-item">
						<a href="{{ route('frontend.products.show', $relatedProduct->slug) }}">
							<img src="{{ $relatedProduct->image ? (strpos($relatedProduct->image, 'http') === 0 ? $relatedProduct->image : asset($relatedProduct->image)) : 'https://images.unsplash.com/photo-1525547719571-a2d4ac8945e2?w=400&h=400&fit=crop' }}" alt="{{ $relatedProduct->name }}">
							<h4>{{ $relatedProduct->name }}</h4>
							<p class="price">Rp {{ number_format($relatedProduct->price, 0, ',', '.') }}</p>
						</a>
					</div>
				</div>
				@endforeach
			</div>
		</div>
		@endif
	</div>
</section>

@endsection

@push('scripts')
<script>
	(function($) {
		'use strict';

		// Initialize product image slider
		$(document).ready(function() {
			if ($('.product-image-slider').length && typeof $.fn.slick !== 'undefined') {
				$('.product-image-slider').slick({
					autoplay: true,
					infinite: true,
					arrows: true,
					dots: true,
					autoplaySpeed: 3000,
					speed: 500,
					fade: false,
					cssEase: 'ease-in-out',
					pauseOnHover: true,
					pauseOnFocus: true,
				});
			}

			// Check favorite status
			const productId = $('#favoriteBtn').data('product-id');
			if (productId) {
				$.get('/favorite/check/' + productId, function(data) {
					if (data.is_favorited) {
						$('#favoriteBtn').addClass('active');
					}
				});
			}

			// Toggle favorite
			$('#favoriteBtn').on('click', function(e) {
				e.preventDefault();
				const productId = $(this).data('product-id');
				const btn = $(this);

				$.ajax({
					url: '/favorite/toggle/' + productId,
					method: 'POST',
					data: {
						_token: '{{ csrf_token() }}'
					},
					success: function(data) {
						if (data.status === 'added') {
							btn.addClass('active');
						} else {
							btn.removeClass('active');
						}
						// Update favorite count in navbar
						updateFavoriteCount();
					},
					error: function() {
						alert('Terjadi kesalahan. Silakan coba lagi.');
					}
				});
			});

			function updateFavoriteCount() {
				$.get('/favorit', function(html) {
					// This will be handled by the navbar update
				});
			}
		});
	})(jQuery);
</script>
@endpush


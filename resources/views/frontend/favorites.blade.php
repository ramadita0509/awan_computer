@extends('frontend.layouts.app')

@section('title', 'Favorit Saya - AWAN KOMPUTER')
@section('description', 'AWAN KOMPUTER - Favorit Saya')

@section('content')

<!-- Page Header -->
<section class="page-header">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="content">
					<h1 class="page-name">Favorit Saya</h1>
					<ol class="breadcrumb">
						<li><a href="/">Home</a></li>
						<li class="active">Favorit</li>
					</ol>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- Favorites Section -->
<section class="products section">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				@if($favorites->count() > 0)
				<div class="row">
					@foreach($favorites as $favorite)
					@php
						$product = $favorite->product;
					@endphp
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
											<a href="{{ route('favorites.index') }}" onclick="event.stopPropagation(); removeFromFavorites(event, {{ $product->id }});">
												<i class="tf-ion-ios-heart" style="color: #e74c3c;"></i>
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
					@endforeach
				</div>
				@else
				<div class="col-md-12 text-center">
					<p style="font-size: 18px; color: #999; padding: 60px 0;">Belum ada produk favorit. <a href="{{ route('homepage') }}">Mulai berbelanja sekarang!</a></p>
				</div>
				@endif
			</div>
		</div>
	</div>
</section>

@endsection

@push('styles')
<style>
	.favorite-toggle.active i {
		color: #e74c3c;
	}
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
</style>
@endpush

@push('scripts')
<script>
	function removeFromFavorites(event, productId) {
		event.preventDefault();

		// Remove from favorites
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

				// Reload page to remove item from list
				location.reload();
			},
			error: function() {
				alert('Terjadi kesalahan. Silakan coba lagi.');
			}
		});
	}
</script>
@endpush


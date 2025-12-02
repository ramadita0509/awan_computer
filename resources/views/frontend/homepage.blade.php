@extends('frontend.layouts.app')

@section('title', 'AWAN KOMPUTER - Toko Komputer & Elektronik Terpercaya')
@section('description', 'AWAN KOMPUTER - Toko Komputer & Elektronik Terpercaya')

@push('styles')
<style>
  /* Ensure slider arrows are visible */
  .heroSliderArrow {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    height: 50px;
    width: 50px;
    border-radius: 50%;
    border: 0;
    background-color: rgba(255, 255, 255, 0.9);
    font-size: 20px;
    transition: 0.3s;
    z-index: 999;
    cursor: pointer;
    box-shadow: 0 2px 10px rgba(0,0,0,0.2);
  }
  .heroSliderArrow:hover {
    background-color: #000;
    color: #fff;
  }
  .heroSliderArrow.prevArrow {
    left: 30px;
  }
  .heroSliderArrow.nextArrow {
    right: 30px;
  }
  @media (max-width: 768px) {
    .heroSliderArrow {
      display: none !important;
    }
  }

  /* Ensure slider is properly initialized */
  .hero-slider {
    position: relative;
    width: 100%;
    overflow: hidden;
  }
  .hero-slider .slick-list {
    position: relative;
    display: block;
    overflow: hidden;
    margin: 0;
    padding: 0;
  }
  .hero-slider .slick-track {
    position: relative;
    top: 0;
    left: 0;
    display: block;
  }
  .hero-slider .slider-item {
    display: block;
    height: auto;
    min-height: 500px;
  }
  .hero-slider .slick-dots {
    bottom: 30px;
    z-index: 10;
  }
  .hero-slider .slick-dots li button:before {
    font-size: 12px;
    color: rgba(255, 255, 255, 0.5);
  }
  .hero-slider .slick-dots li.slick-active button:before {
    color: #fff;
  }
</style>
@endpush

@section('content')

<!-- Hero Slider -->
<div class="hero-slider">
	<div class="slider-item th-fullpage hero-area" style="background-image: url(https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=1920&h=1080&fit=crop);">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 text-center">
					<p data-duration-in=".3" data-animation-in="fadeInUp" data-delay-in=".1">PRODUK TERLARIS</p>
					<h1 data-duration-in=".3" data-animation-in="fadeInUp" data-delay-in=".5">
						Koleksi Laptop & PC Gaming<br>Terbaru dengan Harga Terpercaya
					</h1>
					<a data-duration-in=".3" data-animation-in="fadeInUp" data-delay-in=".8" class="btn btn-main" href="{{route('category', 'pc') }}">
						Belanja Sekarang
					</a>
				</div>
			</div>
		</div>
	</div>
	<div class="slider-item th-fullpage hero-area" style="background-image: url(https://images.unsplash.com/photo-1527864550417-7fd91fc51a46?w=1920&h=1080&fit=crop);">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 text-left">
					<p data-duration-in=".3" data-animation-in="fadeInUp" data-delay-in=".1">PROMO SPESIAL</p>
					<h1 data-duration-in=".3" data-animation-in="fadeInUp" data-delay-in=".5">
						Diskon Hingga 50%<br>Untuk Semua Produk Komputer
					</h1>
					<a data-duration-in=".3" data-animation-in="fadeInUp" data-delay-in=".8" class="btn btn-main" href="{{route('category.multiple', ['categories' => 'pc,keyboard'])}}">
						Lihat Promo
					</a>
				</div>
			</div>
		</div>
	</div>
	<div class="slider-item th-fullpage hero-area" style="background-image: url(https://images.unsplash.com/photo-1587825140708-dfaf72ae4b04?w=1920&h=1080&fit=crop);">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 text-right">
					<p data-duration-in=".3" data-animation-in="fadeInUp" data-delay-in=".1">NEW ARRIVAL</p>
					<h1 data-duration-in=".3" data-animation-in="fadeInUp" data-delay-in=".5">
						PC Gaming & Aksesoris<br>Kualitas Premium
					</h1>
					<a data-duration-in=".3" data-animation-in="fadeInUp" data-delay-in=".8" class="btn btn-main" href="{{ route('category.multiple', ['categories' => 'game,pc']) }}">
						Jelajahi Koleksi
					</a>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Product Category Section -->
<section class="product-category section">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="title text-center">
					<h2>Kategori Produk</h2>
					<p>Temukan produk komputer yang Anda butuhkan</p>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				@if($categories->count() > 0)
				<div class="category-slider">
					@foreach($categories as $cat)
					<div class="category-slide-item">
						<a href="{{ route('category', $cat->slug) }}" class="category-card">
							<div class="category-image-wrapper">
								<img src="{{ $cat->image ? (strpos($cat->image, 'http') === 0 ? $cat->image : asset($cat->image)) : 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=300&h=300&fit=crop' }}" alt="{{ $cat->name }}" />
								<div class="category-overlay"></div>
							</div>
							<div class="category-content">
								@if($cat->icon)
								<span class="category-icon">{{ $cat->icon }}</span>
								@endif
								<h4>{{ $cat->name }}</h4>
								@if($cat->description)
								<p>{{ \Illuminate\Support\Str::limit($cat->description, 50) }}</p>
								@endif
							</div>
						</a>
					</div>
					@endforeach
				</div>
				@else
				<div class="col-md-12 text-center">
					<p>Belum ada kategori yang tersedia.</p>
				</div>
				@endif
			</div>
		</div>
	</div>
</section>

<!-- Products Section -->
<section class="products section bg-gray">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="title text-center">
					<h2 style="font-weight: bold; color: #060606;">Produk Terlaris</h2>
					<p>Pilihan terbaik dari pelanggan kami</p>
				</div>
			</div>
		</div>
		<div class="row">
			@if($products->count() > 0)
			<!-- Banner Kiri -->
			<div class="col-md-2 col-sm-12">
				<div class="product-banner-left bestseller-banner">
					<div class="banner-content">
						<h3>PRODUK TERLARIS</h3>
						<div class="banner-icon">
							<i class="tf-ion-ios-star" style="font-size: 48px; color: #ffd700;"></i>
						</div>
					</div>
				</div>
			</div>
			<!-- Product Cards -->
			<div class="col-md-8 col-sm-12">
				<div class="product-slider-compact">
					@foreach($products->take(5) as $product)
					<div class="product-slide-item-compact">
						<div class="product-item-compact">
							<div class="product-thumb-compact">
								<span class="bage bage-bestseller-compact">Terlaris</span>
								@if($product->original_price && $product->original_price > $product->price)
								@endif
								<a href="{{ route('frontend.products.show', $product->slug) }}" style="display: block; position: relative;">
									<img class="img-responsive" src="{{ $product->image ? (strpos($product->image, 'http') === 0 ? $product->image : asset($product->image)) : 'https://images.unsplash.com/photo-1525547719571-a2d4ac8945e2?w=600&h=600&fit=crop' }}" alt="{{ $product->name }}" />
								</a>
								<div class="preview-meta-compact">
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
							<div class="product-content-compact">
								<h5><a href="{{ route('frontend.products.show', $product->slug) }}">{{ \Illuminate\Support\Str::limit($product->name, 30) }}</a></h5>
								<p class="price-compact">
									Rp {{ number_format($product->price, 0, ',', '.') }}
									@if($product->original_price && $product->original_price > $product->price)
										<small style="text-decoration: line-through; color: #999; font-size: 11px; display: block;">Rp {{ number_format($product->original_price, 0, ',', '.') }}</small>
									@endif
								</p>
							</div>
						</div>
					</div>
					@endforeach
				</div>
			</div>
			<!-- Banner Kanan -->
			<div class="col-md-2 col-sm-12">
				<div class="product-banner-right">
					<div class="banner-content">
						<a href="{{ route('frontend.products.index') }}" class="banner-link">
							<h3>LIHAT SEMUA PRODUK</h3>
							<div class="banner-icon">
								<i class="tf-ion-ios-arrow-forward" style="font-size: 32px;"></i>
							</div>
						</a>
					</div>
				</div>
			</div>
			@else
			<div class="col-md-12 text-center">
				<p>Belum ada produk yang tersedia.</p>
			</div>
			@endif
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
									<a href="#" class="btn btn-main" onclick="addToCart(event, {{ $product->id }}); return false;">Tambah ke Keranjang</a>
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

<!-- Promo Products Section -->
<section class="products section">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="title text-center">
					<h2 style="font-weight: bold;">Promo Minggu Ini</h2>
					<p>Penawaran spesial yang tidak boleh Anda lewatkan</p>
				</div>
			</div>
		</div>
		<div class="row">
			@if(isset($promoProducts) && $promoProducts->count() > 0)
			<!-- Banner Kiri -->
			<div class="col-md-2 col-sm-12">
				<div class="product-banner-left promo-banner">
					<div class="banner-content">
						<h3>PROMO HANYA MINGGU INI</h3>
						<div class="banner-icon">
							<i class="tf-ion-ios-pricetag" style="font-size: 48px; color: #fff;"></i>
						</div>
					</div>
				</div>
			</div>
			<!-- Product Cards -->
			<div class="col-md-8 col-sm-12">
				<div class="product-slider-compact promo-slider-compact">
					@foreach($promoProducts->take(5) as $product)
					<div class="product-slide-item-compact">
						<div class="product-item-compact">
							<div class="product-thumb-compact">
								<span class="bage bage-promo-compact">PROMO</span>
								@if($product->original_price && $product->original_price > $product->price)
								@endif
								<a href="{{ route('frontend.products.show', $product->slug) }}" style="display: block; position: relative;">
									<img class="img-responsive" src="{{ $product->image ? (strpos($product->image, 'http') === 0 ? $product->image : asset($product->image)) : 'https://images.unsplash.com/photo-1525547719571-a2d4ac8945e2?w=600&h=600&fit=crop' }}" alt="{{ $product->name }}" />
								</a>
								<div class="preview-meta-compact">
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
							<div class="product-content-compact">
								<h5><a href="{{ route('frontend.products.show', $product->slug) }}">{{ \Illuminate\Support\Str::limit($product->name, 30) }}</a></h5>
								<p class="price-compact">
									Rp {{ number_format($product->price, 0, ',', '.') }}
									@if($product->original_price && $product->original_price > $product->price)
										<small style="text-decoration: line-through; color: #999; font-size: 11px; display: block;">Rp {{ number_format($product->original_price, 0, ',', '.') }}</small>
									@endif
								</p>
							</div>
						</div>
					</div>
					@endforeach
				</div>
			</div>
			<!-- Banner Kanan -->
			<div class="col-md-2 col-sm-12">
				<div class="product-banner-right">
					<div class="banner-content">
						<a href="{{ route('frontend.products.index') }}" class="banner-link">
							<h3>LIHAT SEMUA PRODUK</h3>
							<div class="banner-icon">
								<i class="tf-ion-ios-arrow-forward" style="font-size: 32px;"></i>
							</div>
						</a>
					</div>
				</div>
			</div>
			@else
			<div class="col-md-12 text-center">
				<p>Belum ada promo yang tersedia.</p>
			</div>
			@endif
		</div>

		<!-- Promo Product Modals -->
		@if(isset($promoProducts))
		@foreach($promoProducts as $product)
		<div class="modal product-modal fade" id="promo-modal-{{ $product->id }}">
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
									<a href="#" class="btn btn-main" onclick="addToCart(event, {{ $product->id }}); return false;">Tambah ke Keranjang</a>
									<a href="{{ route('frontend.products.show', $product->slug) }}" class="btn btn-transparent">Lihat Detail Produk</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		@endforeach
		@endif
	</div>
</section>

@endsection

@push('styles')
<style>
	.category-slider {
		margin: 30px 0;
	}
	.category-slide-item {
		padding: 0 10px;
	}
	.category-card {
		display: block;
		background: #fff;
		border-radius: 10px;
		overflow: hidden;
		box-shadow: 0 2px 10px rgba(0,0,0,0.1);
		transition: all 0.3s ease;
		text-decoration: none;
		color: inherit;
		height: 100%;
	}
	.category-card:hover {
		transform: translateY(-5px);
		box-shadow: 0 5px 20px rgba(0,0,0,0.15);
		text-decoration: none;
		color: inherit;
	}
	.category-image-wrapper {
		position: relative;
		width: 100%;
		height: 180px;
		overflow: hidden;
	}
	.category-image-wrapper img {
		width: 100%;
		height: 100%;
		object-fit: cover;
		transition: transform 0.3s ease;
	}
	.category-card:hover .category-image-wrapper img {
		transform: scale(1.1);
	}
	.category-overlay {
		position: absolute;
		top: 0;
		left: 0;
		right: 0;
		bottom: 0;
		background: linear-gradient(to bottom, transparent 0%, rgba(0,0,0,0.3) 100%);
	}
	.category-content {
		padding: 15px;
		text-align: center;
	}
	.category-content .category-icon {
		font-size: 32px;
		display: block;
		margin-bottom: 8px;
	}
	.category-content h4 {
		font-size: 16px;
		font-weight: 600;
		margin: 0 0 5px 0;
		color: #333;
	}
	.category-content p {
		font-size: 13px;
		color: #666;
		margin: 0;
	}
	.category-slider .slick-prev,
	.category-slider .slick-next {
		z-index: 10;
		width: 40px;
		height: 40px;
		background: rgba(0,0,0,0.5);
		border-radius: 50%;
	}
	.category-slider .slick-prev:before,
	.category-slider .slick-next:before {
		font-size: 20px;
		color: #fff;
	}
	.category-slider .slick-prev {
		left: -20px;
	}
	.category-slider .slick-next {
		right: -20px;
	}
	.category-slider .slick-dots {
		bottom: -40px;
	}
	@media (max-width: 768px) {
		.category-slider .slick-prev,
		.category-slider .slick-next {
			display: none !important;
		}
		.category-image-wrapper {
			height: 150px;
		}
	}

	/* Product Slider Styles */
	.product-slider {
		margin: 30px 0;
	}
	.product-slide-item {
		padding: 0 10px;
	}
	.product-slider .slick-prev,
	.product-slider .slick-next {
		z-index: 10;
		width: 40px;
		height: 40px;
		background: rgba(255, 255, 255, 0.9);
		border-radius: 50%;
	}
	.product-slider .slick-prev:before,
	.product-slider .slick-next:before {
		font-size: 20px;
		color: #333;
	}
	.product-slider .slick-prev {
		left: -20px;
	}
	.product-slider .slick-next {
		right: -20px;
	}
	.product-slider .slick-dots {
		bottom: -40px;
	}
	.product-slider .slick-dots li button:before {
		color: #fff;
	}
	.product-slider .slick-dots li.slick-active button:before {
		color: #fff;
	}
	@media (max-width: 768px) {
		.product-slider .slick-prev,
		.product-slider .slick-next {
			display: none !important;
		}
	}

	/* Compact Product Slider Styles */
	.product-slider-compact {
		margin: 0;
	}
	.product-slide-item-compact {
		padding: 0 8px;
	}
	.product-item-compact {
		background: #fff;
		border-radius: 8px;
		overflow: hidden;
		box-shadow: 0 2px 8px rgba(0,0,0,0.1);
		transition: all 0.3s ease;
		height: 100%;
	}
	.product-item-compact:hover {
		transform: translateY(-3px);
		box-shadow: 0 4px 15px rgba(0,0,0,0.15);
	}
	.product-thumb-compact {
		position: relative;
		height: 180px;
		overflow: hidden;
	}
	.product-thumb-compact img {
		width: 100%;
		height: 100%;
		object-fit: cover;
		transition: transform 0.3s ease;
	}
	.product-item-compact:hover .product-thumb-compact img {
		transform: scale(1.05);
	}
	.product-content-compact {
		padding: 12px;
	}
	.product-content-compact h5 {
		font-size: 13px;
		font-weight: 600;
		margin: 0 0 8px 0;
		line-height: 1.4;
	}
	.product-content-compact h5 a {
		color: #333;
		text-decoration: none;
	}
	.product-content-compact h5 a:hover {
		color: #4A90E2;
	}
	.price-compact {
		font-size: 14px;
		font-weight: bold;
		color: #e74c3c;
		margin: 0;
	}
	.bage-compact {
		position: absolute;
		top: 8px;
		left: 8px;
		padding: 4px 8px;
		border-radius: 3px;
		font-size: 10px;
		font-weight: 600;
		z-index: 10;
		text-transform: uppercase;
	}
	.bage-bestseller-compact {
		background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
		color: #fff;
	}
	.bage-promo-compact {
		background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
		color: #fff;
	}
	.bage-sale-compact {
		background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
		color: #fff;
		top: 35px;
	}
	.preview-meta-compact {
		position: absolute;
		bottom: 0;
		left: 0;
		right: 0;
		background: rgba(255,255,255,0.95);
		padding: 8px 0;
		transform: translateY(100%);
		transition: all 0.3s ease;
		opacity: 0;
		visibility: hidden;
		z-index: 2;
	}
	.product-item-compact:hover .preview-meta-compact {
		transform: translateY(0);
		opacity: 1;
		visibility: visible;
	}
	.preview-meta-compact ul {
		display: flex;
		justify-content: center;
		list-style: none;
		padding: 0;
		margin: 0;
	}
	.preview-meta-compact ul li {
		margin: 0 6px;
	}
	.preview-meta-compact ul li a {
		display: block;
		width: 30px;
		height: 30px;
		line-height: 30px;
		text-align: center;
		border-radius: 50%;
		background: #eee;
		color: #333;
		font-size: 14px;
		transition: all 0.2s ease;
	}
	.preview-meta-compact ul li a:hover {
		background: #333;
		color: #fff;
	}
	.product-slider-compact .slick-prev,
	.product-slider-compact .slick-next {
		z-index: 10;
		width: 35px;
		height: 35px;
		background: rgba(255, 255, 255, 0.9);
		border-radius: 50%;
		box-shadow: 0 2px 8px rgba(0,0,0,0.15);
	}
	.product-slider-compact .slick-prev:before,
	.product-slider-compact .slick-next:before {
		font-size: 18px;
		color: #333;
	}
	.product-slider-compact .slick-prev {
		left: -15px;
	}
	.product-slider-compact .slick-next {
		right: -15px;
	}
	.product-slider-compact .slick-dots {
		bottom: -35px;
	}
	@media (max-width: 768px) {
		.product-slider-compact .slick-prev,
		.product-slider-compact .slick-next {
			display: none !important;
		}
		.product-thumb-compact {
			height: 150px;
		}
	}

	/* Product Banner Styles */
	.product-banner-left,
	.product-banner-right {
		height: 100%;
		min-height: 350px;
		display: flex;
		align-items: center;
		justify-content: center;
		border-radius: 8px;
		box-shadow: 0 2px 8px rgba(0,0,0,0.1);
		margin-bottom: 20px;
	}
	.bestseller-banner {
		background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
	}
	.promo-banner {
		background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
	}
	.product-banner-right {
		background: linear-gradient(135deg, #4A90E2 0%, #357ABD 100%);
	}
	.banner-content {
		text-align: center;
		padding: 20px;
		color: #fff;
	}
	.banner-content h3 {
		font-size: 16px;
		font-weight: bold;
		margin: 0 0 15px 0;
		line-height: 1.4;
		text-transform: uppercase;
		letter-spacing: 1px;
	}
	.banner-icon {
		margin-top: 15px;
	}
	.banner-link {
		color: #fff;
		text-decoration: none;
		display: block;
		transition: transform 0.3s ease;
	}
	.banner-link:hover {
		color: #fff;
		text-decoration: none;
		transform: scale(1.05);
	}
	@media (max-width: 768px) {
		.product-banner-left,
		.product-banner-right {
			min-height: 150px;
			margin-bottom: 20px;
		}
		.banner-content h3 {
			font-size: 14px;
		}
		.banner-icon i {
			font-size: 32px !important;
		}
	}

	/* Product Badge Styles */
	.bage {
		position: absolute;
		top: 10px;
		left: 10px;
		padding: 5px 12px;
		border-radius: 4px;
		font-size: 12px;
		font-weight: 600;
		z-index: 10;
		text-transform: uppercase;
	}
	.bage-bestseller {
		background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
		color: #fff;
		top: 10px;
		left: 10px;
	}
	.bage-promo {
		background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
		color: #fff;
		top: 10px;
		left: 10px;
	}
	.bage-sale {
		background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
		color: #fff;
		top: 45px;
		left: 10px;
	}
	.product-thumb {
		position: relative;
	}
	.favorite-toggle.active i,
	.favorite-toggle.active {
		color: #e74c3c !important;
	}
	.favorite-toggle i {
		transition: color 0.3s ease;
	}
	.product-item {
		transition: transform 0.3s ease, box-shadow 0.3s ease;
	}
	.product-item:hover {
		transform: translateY(-5px);
		box-shadow: 0 5px 20px rgba(0,0,0,0.1);
	}
	.product-thumb > a {
		text-decoration: none;
		display: block;
		cursor: pointer;
		position: relative;
		z-index: 1;
	}
	.product-thumb > a img {
		width: 100%;
		height: auto;
		display: block;
	}
	.product-thumb .preview-meta {
		position: absolute;
		bottom: 0;
		left: 0;
		right: 0;
		background: rgba(255,255,255,0.9);
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
	.product-content a {
		text-decoration: none;
		color: inherit;
	}
	.product-content a:hover {
		color: #4A90E2;
	}
</style>
@endpush

@push('scripts')
<script>
  (function($) {
    'use strict';

    // Function to initialize category slider
    function initCategorySlider() {
      if ($('.category-slider').length && typeof $.fn.slick !== 'undefined') {
        $('.category-slider').slick({
          autoplay: true,
          infinite: true,
          arrows: true,
          dots: true,
          autoplaySpeed: 3000,
          speed: 500,
          slidesToShow: 4,
          slidesToScroll: 1,
          responsive: [
            {
              breakpoint: 1024,
              settings: {
                slidesToShow: 3,
                slidesToScroll: 1
              }
            },
            {
              breakpoint: 768,
              settings: {
                slidesToShow: 2,
                slidesToScroll: 1,
                arrows: false
              }
            },
            {
              breakpoint: 480,
              settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
                arrows: false
              }
            }
          ]
        });
      }
    }

    // Function to initialize product slider
    function initProductSlider() {
      if ($('.product-slider').length && typeof $.fn.slick !== 'undefined') {
        $('.product-slider').each(function() {
          if (!$(this).hasClass('slick-initialized')) {
            $(this).slick({
              autoplay: true,
              infinite: true,
              arrows: true,
              dots: true,
              autoplaySpeed: 3000,
              speed: 500,
              slidesToShow: 3,
              slidesToScroll: 1,
              responsive: [
                {
                  breakpoint: 1024,
                  settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1
                  }
                },
                {
                  breakpoint: 768,
                  settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1,
                    arrows: false
                  }
                },
                {
                  breakpoint: 480,
                  settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    arrows: false
                  }
                }
              ]
            });
          }
        });
      }
    }

    // Function to initialize compact product slider
    function initCompactProductSlider() {
      if ($('.product-slider-compact').length && typeof $.fn.slick !== 'undefined') {
        $('.product-slider-compact').each(function() {
          if (!$(this).hasClass('slick-initialized')) {
            $(this).slick({
              autoplay: true,
              infinite: true,
              arrows: true,
              dots: true,
              autoplaySpeed: 3000,
              speed: 500,
              slidesToShow: 5,
              slidesToScroll: 1,
              responsive: [
                {
                  breakpoint: 1200,
                  settings: {
                    slidesToShow: 4,
                    slidesToScroll: 1
                  }
                },
                {
                  breakpoint: 992,
                  settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1
                  }
                },
                {
                  breakpoint: 768,
                  settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1,
                    arrows: false
                  }
                },
                {
                  breakpoint: 480,
                  settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    arrows: false
                  }
                }
              ]
            });
          }
        });
      }
    }

    // Function to initialize compact product slider
    function initCompactProductSlider() {
      if ($('.product-slider-compact').length && typeof $.fn.slick !== 'undefined') {
        $('.product-slider-compact').each(function() {
          if (!$(this).hasClass('slick-initialized')) {
            $(this).slick({
              autoplay: true,
              infinite: true,
              arrows: true,
              dots: true,
              autoplaySpeed: 3000,
              speed: 500,
              slidesToShow: 5,
              slidesToScroll: 1,
              responsive: [
                {
                  breakpoint: 1200,
                  settings: {
                    slidesToShow: 4,
                    slidesToScroll: 1
                  }
                },
                {
                  breakpoint: 992,
                  settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1
                  }
                },
                {
                  breakpoint: 768,
                  settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1,
                    arrows: false
                  }
                },
                {
                  breakpoint: 480,
                  settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    arrows: false
                  }
                }
              ]
            });
          }
        });
      }
    }

    // Function to initialize or update slider
    function initHeroSlider() {
      if ($('.hero-slider').length && typeof $.fn.slick !== 'undefined') {
        // If already initialized, unslick first
        if ($('.hero-slider').hasClass('slick-initialized')) {
          $('.hero-slider').slick('unslick');
        }

        // Initialize with full options including swipe
        $('.hero-slider').slick({
          autoplay: true,
          infinite: true,
          arrows: true,
          prevArrow: '<button type="button" class="heroSliderArrow prevArrow tf-ion-chevron-left"></button>',
          nextArrow: '<button type="button" class="heroSliderArrow nextArrow tf-ion-chevron-right"></button>',
          dots: true,
          autoplaySpeed: 5000,
          speed: 800,
          fade: false,
          cssEase: 'ease-in-out',
          pauseOnFocus: false,
          pauseOnHover: true,
          pauseOnDotsHover: true,
          swipe: true,
          touchMove: true,
          draggable: true,
          touchThreshold: 5,
          swipeToSlide: true,
          accessibility: true,
          adaptiveHeight: false,
          responsive: [
            {
              breakpoint: 768,
              settings: {
                arrows: false,
                dots: true,
                swipe: true,
                touchMove: true,
                draggable: true
              }
            }
          ]
        });

        // Initialize slick animation if available
        if (typeof $.fn.slickAnimation !== 'undefined') {
          $('.hero-slider').slickAnimation();
        }
      }
    }

    // Wait for DOM and all scripts to be ready
    $(document).ready(function() {
      // Wait a bit for script.js to load
      setTimeout(function() {
        initHeroSlider();
        initCategorySlider();
        initProductSlider();
        initCompactProductSlider();
      }, 100);
    });

    // Also try on window load as fallback
    $(window).on('load', function() {
      setTimeout(function() {
        if (!$('.hero-slider').hasClass('slick-initialized')) {
          initHeroSlider();
        } else {
          // Update existing slider settings
          $('.hero-slider').slick('slickSetOption', 'swipe', true, true);
          $('.hero-slider').slick('slickSetOption', 'touchMove', true, true);
          $('.hero-slider').slick('slickSetOption', 'draggable', true, true);
          $('.hero-slider').slick('slickSetOption', 'autoplay', true, true);
        }

        // Initialize category slider if not already initialized
        if (!$('.category-slider').hasClass('slick-initialized')) {
          initCategorySlider();
        }

        // Initialize product slider if not already initialized
        if (!$('.product-slider').hasClass('slick-initialized')) {
          initProductSlider();
        }

        // Initialize compact product slider if not already initialized
        if (!$('.product-slider-compact').hasClass('slick-initialized')) {
          initCompactProductSlider();
        }
      }, 200);
    });

    // Function to add to favorites and redirect
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
  })(jQuery);
</script>
@endpush


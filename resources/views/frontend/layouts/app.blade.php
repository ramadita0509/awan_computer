<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <!-- Basic Page Needs -->
  <meta charset="utf-8">
  <title>@yield('title', 'AWAN KOMPUTER - Toko Komputer & Elektronik Terpercaya')</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- Mobile Specific Metas -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="description" content="@yield('description', 'AWAN KOMPUTER - Toko Komputer & Elektronik Terpercaya')">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
  <meta name="author" content="AWAN KOMPUTER">

  <!-- Favicon -->
  <link rel="shortcut icon" type="image/x-icon" href="{{ asset('frontend/theme/images/favicon.png') }}" />

  <!-- Themefisher Icon font -->
  <link rel="stylesheet" href="{{ asset('frontend/theme/plugins/themefisher-font/style.css') }}">
  <!-- bootstrap.min css -->
  <link rel="stylesheet" href="{{ asset('frontend/theme/plugins/bootstrap/css/bootstrap.min.css') }}">

  <!-- Animate css -->
  <link rel="stylesheet" href="{{ asset('frontend/theme/plugins/animate/animate.css') }}">
  <!-- Slick Carousel -->
  <link rel="stylesheet" href="{{ asset('frontend/theme/plugins/slick/slick.css') }}">
  <link rel="stylesheet" href="{{ asset('frontend/theme/plugins/slick/slick-theme.css') }}">

  <!-- Main Stylesheet -->
  <link rel="stylesheet" href="{{ asset('frontend/theme/css/style.css') }}">

  @stack('styles')

  <style>
    /* Footer Styles */
    footer a:hover {
      color: #4A90E2 !important;
      text-decoration: none;
    }
    footer .social-media a:hover {
      transform: translateY(-3px);
      transition: all 0.3s ease;
    }
    @media (max-width: 768px) {
      footer .col-md-6.text-right {
        text-align: left !important;
        margin-top: 20px;
      }
    }

    /* Floating Action Buttons */
    .floating-buttons {
      position: fixed;
      bottom: 30px;
      right: 30px;
      z-index: 9999;
      display: flex;
      flex-direction: column;
      gap: 15px;
    }

    .floating-btn {
      width: 60px;
      height: 60px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #fff;
      font-size: 28px;
      text-decoration: none;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
      transition: all 0.3s ease;
      position: relative;
      cursor: pointer;
    }

    .floating-btn:hover {
      transform: translateY(-5px);
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.4);
      text-decoration: none;
      color: #fff;
    }

    .floating-btn:active {
      transform: translateY(-2px);
    }

    .floating-btn-whatsapp {
      background: linear-gradient(135deg, #25D366 0%, #128C7E 100%);
    }

    .floating-btn-whatsapp:hover {
      background: linear-gradient(135deg, #128C7E 0%, #25D366 100%);
    }

    .floating-btn-cart {
      background: linear-gradient(135deg, #4A90E2 0%, #357ABD 100%);
    }

    .floating-btn-cart:hover {
      background: linear-gradient(135deg, #357ABD 0%, #4A90E2 100%);
    }

    .floating-btn-badge {
      position: absolute;
      top: -5px;
      right: -5px;
      background: #e74c3c;
      color: #fff;
      border-radius: 50%;
      min-width: 24px;
      height: 24px;
      line-height: 24px;
      text-align: center;
      font-size: 12px;
      font-weight: bold;
      border: 2px solid #fff;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    }

    .floating-btn-tooltip {
      position: absolute;
      right: 75px;
      background: #333;
      color: #fff;
      padding: 8px 12px;
      border-radius: 5px;
      font-size: 13px;
      white-space: nowrap;
      opacity: 0;
      visibility: hidden;
      transition: all 0.3s ease;
      pointer-events: none;
    }

    .floating-btn-tooltip::after {
      content: '';
      position: absolute;
      right: -5px;
      top: 50%;
      transform: translateY(-50%);
      border: 5px solid transparent;
      border-left-color: #333;
    }

    .floating-btn:hover .floating-btn-tooltip {
      opacity: 1;
      visibility: visible;
      right: 70px;
    }

    /* Responsive */
    @media (max-width: 768px) {
      .floating-buttons {
        bottom: 20px;
        right: 20px;
        gap: 12px;
      }

      .floating-btn {
        width: 55px;
        height: 55px;
        font-size: 24px;
      }

      .floating-btn-tooltip {
        display: none;
      }
    }

    @media (max-width: 480px) {
      .floating-buttons {
        bottom: 15px;
        right: 15px;
      }

      .floating-btn {
        width: 50px;
        height: 50px;
        font-size: 22px;
      }

      .floating-btn-badge {
        min-width: 20px;
        height: 20px;
        line-height: 20px;
        font-size: 11px;
      }
    }
  </style>
</head>

<body id="body">

<!-- Start Top Header Bar -->
<section class="top-header">
	<div class="container">
		<div class="row">
			<div class="col-md-4 col-xs-12 col-sm-4">
				<div class="contact-number">
					<i class="tf-ion-ios-telephone"></i>
					<span>0812-3456-7890</span>
				</div>
			</div>
			<div class="col-md-4 col-xs-12 col-sm-4">
				<!-- Site Logo -->
				<div class="logo text-center">
					<a href="/">
						<h2 style="margin: 0; font-weight: bold; color: #333;">
							<span style="color: #4A90E2;">AWAN</span> KOMPUTER
						</h2>
					</a>
				</div>
			</div>
			<div class="col-md-4 col-xs-12 col-sm-4">
				<!-- Cart & Favorites -->
				<ul class="top-menu text-right list-inline" style="margin: 0; padding: 0; display: flex; align-items: center; justify-content: flex-end; flex-wrap: wrap;">
					<li class="cart-nav" style="margin-right: 15px;">
						<a href="{{ route('favorites.index') }}" id="favoritesNav" style="position: relative; display: inline-block; font-size: 20px; color: #333;">
							<i class="tf-ion-ios-heart"></i>
							<span class="badge" id="favoriteCount" style="position: absolute; top: -8px; right: -8px; background: #e74c3c; color: #fff; border-radius: 50%; min-width: 18px; height: 18px; line-height: 18px; padding: 0 4px; font-size: 11px; text-align: center;">0</span>
						</a>
					</li>
					<li class="cart-nav" style="margin-right: 15px;">
						<a href="{{ route('cart.index') }}" style="position: relative; display: inline-block; font-size: 20px; color: #333;">
							<i class="tf-ion-android-cart"></i>
							<span class="badge" id="cartCount" style="position: absolute; top: -8px; right: -8px; background: #4A90E2; color: #fff; border-radius: 50%; min-width: 18px; height: 18px; line-height: 18px; padding: 0 4px; font-size: 11px; text-align: center;">0</span>
						</a>
					</li>
					<!-- Search -->
					<li class="dropdown search dropdown-slide" style="margin-right: 15px;">
						<a href="#!" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" style="display: inline-flex; align-items: center; gap: 5px;">
							<i class="tf-ion-ios-search-strong"></i>
							<span>Search</span>
						</a>
						<ul class="dropdown-menu search-dropdown">
							<li>
								<form action="#">
									<input type="search" class="form-control" placeholder="Cari produk komputer...">
								</form>
							</li>
						</ul>
					</li>
					<!-- User Account -->
					@auth
						@if(auth()->user()->canAccessBackend())
							<li style="margin-right: 0;">
								<a href="{{ route('dashboard') }}" style="display: inline-flex; align-items: center; gap: 5px;">
									<i class="tf-ion-person"></i>
									<span>Dashboard</span>
								</a>
							</li>
						@else
							<!-- Customer Menu -->
							<li class="dropdown" style="margin-right: 0;">
								<a href="#!" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" style="display: inline-flex; align-items: center; gap: 5px;">
									<i class="tf-ion-person"></i>
									<span>{{ auth()->user()->name }}</span>
									<span class="tf-ion-ios-arrow-down"></span>
								</a>
								<ul class="dropdown-menu">
									<li>
										<a href="{{ route('profile.edit') }}">
											<i class="tf-ion-person"></i> Profile
										</a>
									</li>
									<li>
										<a href="{{ route('orders.index') }}">
											<i class="tf-ion-document-text"></i> Pesanan Saya
										</a>
									</li>
									<li class="divider"></li>
									<li>
										<form method="POST" action="{{ route('logout') }}" style="display: inline;">
											@csrf
											<button type="submit" style="background: none; border: none; width: 100%; text-align: left; padding: 10px 20px; color: #333; cursor: pointer;">
												<i class="tf-ion-log-out"></i> Logout
											</button>
										</form>
									</li>
								</ul>
							</li>
						@endif
					@else
						<li style="margin-right: 0;">
							<a href="{{ route('login') }}" style="display: inline-flex; align-items: center; gap: 5px;">
								<i class="tf-ion-person"></i>
								<span>Masuk</span>
							</a>
						</li>
					@endauth
				</ul>
			</div>
		</div>
	</div>
</section>

<!-- Main Menu Section -->
<section class="menu">
	<nav class="navbar navigation">
		<div class="container">
			<div class="navbar-header">
				<h2 class="menu-title">Main Menu</h2>
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
					aria-expanded="false" aria-controls="navbar">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
			</div>

			<div id="navbar" class="navbar-collapse collapse text-center">
				<ul class="nav navbar-nav">
					<li class="dropdown">
						<a href="/">Home</a>
					</li>

					<!-- Shop -->
					@php
						$categories = \App\Models\Category::where('is_active', true)->orderBy('sort_order')->orderBy('name')->get();
						$categoriesChunked = $categories->chunk(ceil($categories->count() / 2));
					@endphp
					@if($categories->count() > 0)
					<li class="dropdown dropdown-slide">
						<a href="#!" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="350"
							role="button" aria-haspopup="true" aria-expanded="false">
							Kategori <span class="tf-ion-ios-arrow-down"></span>
						</a>
						<div class="dropdown-menu">
							<div class="row">
								<div class="col-lg-12 col-md-12 mb-2" style="padding: 10px 15px; border-bottom: 1px solid #eee;">
									<a href="{{ route('frontend.products.index') }}" style="font-weight: bold; color: #333;">
										<i class="tf-ion-grid"></i> Semua Kategori
									</a>
								</div>
								@foreach($categoriesChunked as $chunk)
								<div class="col-lg-6 col-md-6 mb-sm-3">
									<ul>
										@foreach($chunk as $cat)
										<li><a href="{{ route('category', $cat->slug) }}">{{ $cat->icon ?? '' }} {{ $cat->name }}</a></li>
										@endforeach
									</ul>
								</div>
								@endforeach
							</div>
						</div>
					</li>
					@endif

					<!-- Katalog -->
					<li>
						<a href="{{ route('katalog.index') }}">Katalog</a>
					</li>

                    <!-- Lokasi -->
					<li>
						<a href="#">Lokasi</a>
					</li>

					<!-- Pesanan Saya -->
					@auth
					<li>
						<a href="{{ route('orders.index') }}">Pesanan Saya</a>
					</li>
					@endauth

					<!-- Pages -->
					<li class="dropdown dropdown-slide">
						<a href="#!" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="350"
							role="button" aria-haspopup="true" aria-expanded="false">
							Halaman <span class="tf-ion-ios-arrow-down"></span>
						</a>
						<ul class="dropdown-menu">
							<li><a href="{{ route('frontend.products.index') }}">Semua Produk</a></li>
							<li><a href="#">Tentang Kami</a></li>
							<li><a href="#">Kontak</a></li>
							@auth
								@if(auth()->user()->canAccessBackend())
									<li><a href="{{ route('dashboard') }}">Dashboard</a></li>
								@endif
								<li><a href="{{ route('profile.edit') }}">Profile</a></li>
								@if(auth()->user()->isCustomer())
									<li><a href="{{ route('orders.index') }}">Pesanan Saya</a></li>
								@endif
							@else
								<li><a href="{{ route('login') }}">Login</a></li>
								<li><a href="{{ route('register') }}">Daftar</a></li>
							@endauth
						</ul>
					</li>
				</ul>
			</div>
		</div>
	</nav>
</section>

@yield('content')

<!-- Floating Action Buttons -->
<div class="floating-buttons">
	<!-- WhatsApp Button -->
	<a href="https://wa.me/6281297009800?text=Halo%20Awan%20Komputer,%20saya%20ingin%20bertanya%20tentang%20produk"
		target="_blank"
		class="floating-btn floating-btn-whatsapp"
		title="Chat WhatsApp">
		<i class="tf-ion-social-whatsapp"></i>
		<span class="floating-btn-tooltip">Chat WhatsApp</span>
	</a>

	<!-- Cart Button -->
	<a href="{{ route('cart.index') }}"
		class="floating-btn floating-btn-cart"
		title="Keranjang Belanja">
		<i class="tf-ion-android-cart"></i>
		<span class="floating-btn-badge" id="floatingCartCount">0</span>
		<span class="floating-btn-tooltip">Keranjang</span>
	</a>
</div>

<!-- Footer -->
<footer class="footer section" style="background: #1a1a1a; color: #fff; padding: 60px 0 20px;">
	<div class="container">
		<div class="row">
			<!-- Awan Komputer - Sales Section -->
			<div class="col-md-4 col-sm-6 col-xs-12 mb-4">
				<h4 style="color: #4A90E2; font-weight: bold; margin-bottom: 20px; font-size: 20px;">
					<span style="color: #4A90E2;">AWAN</span> KOMPUTER
				</h4>
				<p style="color: #999; margin-bottom: 15px; font-size: 14px; font-weight: 600;">Sales</p>

				<!-- Alamat -->
				<div style="margin-bottom: 20px;">
					<div style="display: flex; align-items: flex-start; margin-bottom: 10px;">
						<i class="tf-ion-location" style="color: #4A90E2; font-size: 18px; margin-right: 10px; margin-top: 3px;"></i>
						<div style="color: #ccc; font-size: 14px; line-height: 1.6;">
							<strong style="color: #fff; display: block; margin-bottom: 5px;">Awan Komputer Jakarta</strong>
							Jl. Gunung Sahari Raya 1<br>
							Ruko Mangga Dua Square Blok A No. 8<br>
							Pademangan, Jakarta Utara 14420
						</div>
					</div>
				</div>

				<!-- Operasional -->
				<div style="margin-bottom: 20px;">
					<p style="color: #999; margin-bottom: 10px; font-size: 14px; font-weight: 600;">Operasional:</p>
					<div style="color: #ccc; font-size: 13px; line-height: 1.8;">
						<div><strong style="color: #fff;">Senin - Sabtu</strong><br>09:00 - 18:30 WIB</div>
						<div style="margin-top: 8px;"><strong style="color: #fff;">Minggu</strong><br>09:00 - 16:30 WIB</div>
					</div>
				</div>

				<!-- Kontak -->
				<div>
					<div style="margin-bottom: 8px;">
						<i class="tf-ion-ios-telephone" style="color: #4A90E2; margin-right: 8px;"></i>
						<a href="tel:081297009800" style="color: #ccc; text-decoration: none; font-size: 14px;">0812-9700-9800</a>
					</div>
					<div>
						<i class="tf-ion-email" style="color: #4A90E2; margin-right: 8px;"></i>
						<a href="mailto:sales@awankomputer.com" style="color: #ccc; text-decoration: none; font-size: 14px;">sales@awankomputer.com</a>
					</div>
				</div>
			</div>

			<!-- Akun dan Kontak -->
			<div class="col-md-2 col-sm-6 col-xs-12 mb-4">
				<h5 style="color: #fff; font-weight: 600; margin-bottom: 20px; font-size: 16px; text-transform: uppercase;">Akun dan Kontak</h5>
				<ul style="list-style: none; padding: 0; margin: 0;">
					@auth
						@if(auth()->user()->canAccessBackend())
							<li style="margin-bottom: 10px;">
								<a href="{{ route('dashboard') }}" style="color: #ccc; text-decoration: none; font-size: 14px; transition: color 0.3s;">
									<i class="tf-ion-person" style="margin-right: 8px; color: #4A90E2;"></i>Dashboard
								</a>
							</li>
						@else
							<li style="margin-bottom: 10px;">
								<a href="{{ route('profile.edit') }}" style="color: #ccc; text-decoration: none; font-size: 14px; transition: color 0.3s;">
									<i class="tf-ion-person" style="margin-right: 8px; color: #4A90E2;"></i>Profile
								</a>
							</li>
							<li style="margin-bottom: 10px;">
								<a href="{{ route('orders.index') }}" style="color: #ccc; text-decoration: none; font-size: 14px; transition: color 0.3s;">
									<i class="tf-ion-document-text" style="margin-right: 8px; color: #4A90E2;"></i>Pesanan Saya
								</a>
							</li>
						@endif
					@else
						<li style="margin-bottom: 10px;">
							<a href="{{ route('login') }}" style="color: #ccc; text-decoration: none; font-size: 14px; transition: color 0.3s;">
								<i class="tf-ion-locked" style="margin-right: 8px; color: #4A90E2;"></i>Masuk
							</a>
						</li>
						<li style="margin-bottom: 10px;">
							<a href="{{ route('register') }}" style="color: #ccc; text-decoration: none; font-size: 14px; transition: color 0.3s;">
								<i class="tf-ion-person-add" style="margin-right: 8px; color: #4A90E2;"></i>Daftar
							</a>
						</li>
					@endauth
					<li style="margin-bottom: 10px;">
						<a href="#" style="color: #ccc; text-decoration: none; font-size: 14px; transition: color 0.3s;">
							<i class="tf-ion-location" style="margin-right: 8px; color: #4A90E2;"></i>Lokasi Toko
						</a>
					</li>
					<li style="margin-bottom: 10px;">
						<a href="#" style="color: #ccc; text-decoration: none; font-size: 14px; transition: color 0.3s;">
							<i class="tf-ion-email" style="margin-right: 8px; color: #4A90E2;"></i>Kontak Kami
						</a>
					</li>
				</ul>
			</div>

			<!-- Layanan AgresCare -->
			<div class="col-md-3 col-sm-6 col-xs-12 mb-4">
				<h5 style="color: #fff; font-weight: 600; margin-bottom: 20px; font-size: 16px; text-transform: uppercase;">Layanan AwanCare</h5>
				<ul style="list-style: none; padding: 0; margin: 0;">
					<li style="margin-bottom: 10px;">
						<a href="#" style="color: #ccc; text-decoration: none; font-size: 14px; transition: color 0.3s;">
							<i class="tf-ion-document-text" style="margin-right: 8px; color: #4A90E2;"></i>Register Service
						</a>
					</li>
					<li style="margin-bottom: 10px;">
						<a href="#" style="color: #ccc; text-decoration: none; font-size: 14px; transition: color 0.3s;">
							<i class="tf-ion-checkmark-circled" style="margin-right: 8px; color: #4A90E2;"></i>Warranty Ext
						</a>
					</li>
					<li style="margin-bottom: 10px;">
						<a href="#" style="color: #ccc; text-decoration: none; font-size: 14px; transition: color 0.3s;">
							<i class="tf-ion-calendar" style="margin-right: 8px; color: #4A90E2;"></i>Reservasi Perbaikan
						</a>
					</li>
					<li style="margin-bottom: 10px;">
						<a href="#" style="color: #ccc; text-decoration: none; font-size: 14px; transition: color 0.3s;">
							<i class="tf-ion-ios-box" style="margin-right: 8px; color: #4A90E2;"></i>Reservasi Pengambilan Service
						</a>
					</li>
				</ul>
			</div>

			<!-- Tautan Cepat -->
			<div class="col-md-3 col-sm-6 col-xs-12 mb-4">
				<h5 style="color: #fff; font-weight: 600; margin-bottom: 20px; font-size: 16px; text-transform: uppercase;">Tautan Cepat</h5>
				<ul style="list-style: none; padding: 0; margin: 0;">
					<li style="margin-bottom: 10px;">
						<a href="#" style="color: #ccc; text-decoration: none; font-size: 14px; transition: color 0.3s;">
							<i class="tf-ion-arrow-return-left" style="margin-right: 8px; color: #4A90E2;"></i>Kebijakan Pengembalian Barang
						</a>
					</li>
					<li style="margin-bottom: 10px;">
						<a href="#" style="color: #ccc; text-decoration: none; font-size: 14px; transition: color 0.3s;">
							<i class="tf-ion-cash" style="margin-right: 8px; color: #4A90E2;"></i>Kebijakan Pengembalian Dana
						</a>
					</li>
					<li style="margin-bottom: 10px;">
						<a href="#" style="color: #ccc; text-decoration: none; font-size: 14px; transition: color 0.3s;">
							<i class="tf-ion-close-circled" style="margin-right: 8px; color: #4A90E2;"></i>Kebijakan Pembatalan Pesanan
						</a>
					</li>
					<li style="margin-bottom: 10px;">
						<a href="#" style="color: #ccc; text-decoration: none; font-size: 14px; transition: color 0.3s;">
							<i class="tf-ion-help-circled" style="margin-right: 8px; color: #4A90E2;"></i>FAQ's
						</a>
					</li>
				</ul>
			</div>
		</div>

		<!-- Social Media & Copyright -->
		<div class="row" style="margin-top: 40px; padding-top: 30px; border-top: 1px solid #333;">
			<div class="col-md-6 col-xs-12">
				<ul class="social-media" style="list-style: none; padding: 0; margin: 0; display: flex; gap: 15px;">
					<li>
						<a href="#" style="color: #ccc; font-size: 20px; transition: color 0.3s;">
							<i class="tf-ion-social-facebook"></i>
						</a>
					</li>
					<li>
						<a href="#" style="color: #ccc; font-size: 20px; transition: color 0.3s;">
							<i class="tf-ion-social-instagram"></i>
						</a>
					</li>
					<li>
						<a href="#" style="color: #ccc; font-size: 20px; transition: color 0.3s;">
							<i class="tf-ion-social-twitter"></i>
						</a>
					</li>
					<li>
						<a href="#" style="color: #ccc; font-size: 20px; transition: color 0.3s;">
							<i class="tf-ion-social-pinterest"></i>
						</a>
					</li>
				</ul>
			</div>
			<div class="col-md-6 col-xs-12 text-right" style="text-align: right;">
				<p style="color: #999; margin: 0; font-size: 13px;">
					Copyright &copy; {{ date('Y') }} <strong style="color: #4A90E2;">AWAN KOMPUTER</strong>. All rights reserved.
				</p>
			</div>
		</div>
	</div>
</footer>

<!-- Essential Scripts -->
<!-- Main jQuery -->
<script src="{{ asset('frontend/theme/plugins/jquery/dist/jquery.min.js') }}"></script>
<!-- Bootstrap 3.1 -->
<script src="{{ asset('frontend/theme/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
<!-- Bootstrap Touchpin -->
<script src="{{ asset('frontend/theme/plugins/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js') }}"></script>
<!-- Video Lightbox Plugin -->
<script src="{{ asset('frontend/theme/plugins/ekko-lightbox/dist/ekko-lightbox.min.js') }}"></script>

<!-- slick Carousel -->
<script src="{{ asset('frontend/theme/plugins/slick/slick.min.js') }}"></script>
<script src="{{ asset('frontend/theme/plugins/slick/slick-animation.min.js') }}"></script>

<!-- Main Js File -->
<script src="{{ asset('frontend/theme/js/script.js') }}"></script>

@stack('scripts')

<script>
	(function($) {
		'use strict';

		// Update favorite count on page load
		$(document).ready(function() {
			$.get('/favorite/count', function(data) {
				$('#favoriteCount').text(data.count || 0);
			});

		// Update cart count on page load
		$.get('/cart/count', function(data) {
			var count = data.count || 0;
			$('#cartCount').text(count);
			$('#floatingCartCount').text(count);
		});
		});

		// Function to add to favorites and redirect to favorites page
		window.addToFavorites = function(event, productId) {
			event.preventDefault();
			event.stopPropagation();

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
		};

		// Function to add product to cart
		window.addToCart = function(event, productId, quantity) {
			event.preventDefault();
			event.stopPropagation();

			quantity = quantity || 1;

			$.ajax({
				url: '/cart/add/' + productId,
				method: 'POST',
				data: {
					_token: '{{ csrf_token() }}',
					quantity: quantity
				},
				success: function(data) {
					// Update cart count
					$.get('/cart/count', function(countData) {
						var count = countData.count || 0;
						$('#cartCount').text(count);
						$('#floatingCartCount').text(count);
					});

					// Show success message
					alert('Produk ditambahkan ke keranjang!');
				},
				error: function() {
					alert('Terjadi kesalahan. Silakan coba lagi.');
				}
			});
		};
	})(jQuery);
</script>

</body>
</html>


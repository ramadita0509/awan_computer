@extends('frontend.layouts.app')

@section('title', 'Keranjang - AWAN KOMPUTER')
@section('description', 'Keranjang belanja Anda di AWAN KOMPUTER')

@push('styles')
<style>
	.cart-table {
		width: 100%;
		margin-bottom: 30px;
	}
	.cart-table thead {
		background: #f8f9fa;
	}
	.cart-table thead th {
		padding: 15px;
		text-align: left;
		font-weight: 600;
		border-bottom: 2px solid #dee2e6;
	}
	.cart-table tbody td {
		padding: 20px 15px;
		vertical-align: middle;
		border-bottom: 1px solid #dee2e6;
	}
	.product-info {
		display: flex;
		align-items: center;
		gap: 15px;
	}
	.product-info img {
		width: 80px;
		height: 80px;
		object-fit: cover;
		border-radius: 5px;
	}
	.product-info a {
		color: #333;
		text-decoration: none;
		font-weight: 600;
		font-size: 16px;
	}
	.product-info a:hover {
		color: #4A90E2;
	}
	.quantity-input {
		display: inline-flex;
		align-items: center;
		gap: 10px;
	}
	.quantity-input input {
		width: 60px;
		padding: 8px;
		text-align: center;
		border: 1px solid #ddd;
		border-radius: 5px;
	}
	.quantity-input button {
		padding: 8px 12px;
		border: 1px solid #ddd;
		background: #fff;
		border-radius: 5px;
		cursor: pointer;
		transition: all 0.3s ease;
	}
	.quantity-input button:hover {
		background: #4A90E2;
		color: #fff;
		border-color: #4A90E2;
	}
	.product-remove {
		color: #e74c3c;
		text-decoration: none;
		font-size: 14px;
		transition: color 0.3s ease;
	}
	.product-remove:hover {
		color: #c0392b;
		text-decoration: none;
	}
	.cart-summary {
		background: #f8f9fa;
		padding: 25px;
		border-radius: 8px;
		margin-top: 30px;
	}
	.cart-summary h4 {
		margin-bottom: 20px;
		font-weight: 600;
	}
	.summary-row {
		display: flex;
		justify-content: space-between;
		margin-bottom: 15px;
		padding-bottom: 15px;
		border-bottom: 1px solid #dee2e6;
	}
	.summary-row:last-child {
		border-bottom: none;
		margin-bottom: 0;
		padding-bottom: 0;
		font-size: 18px;
		font-weight: bold;
	}
	.empty-cart {
		text-align: center;
		padding: 60px 20px;
	}
	.empty-cart i {
		font-size: 64px;
		color: #ddd;
		margin-bottom: 20px;
	}
	.empty-cart h3 {
		color: #999;
		margin-bottom: 15px;
	}
	.btn-continue-shopping {
		display: inline-flex;
		align-items: center;
		justify-content: center;
		gap: 8px;
		padding: 10px 20px;
		background: #fff;
		color: #4A90E2;
		border: 2px solid #4A90E2;
		border-radius: 6px;
		text-decoration: none;
		font-size: 14px;
		font-weight: 600;
		transition: all 0.3s ease;
		box-shadow: 0 2px 4px rgba(74, 144, 226, 0.1);
		line-height: 1.2;
	}
	.btn-continue-shopping:hover {
		background: #4A90E2;
		color: #fff;
		border-color: #4A90E2;
		transform: translateY(-2px);
		box-shadow: 0 4px 8px rgba(74, 144, 226, 0.2);
		text-decoration: none;
	}
	.btn-continue-shopping i {
		font-size: 14px;
		line-height: 1;
		display: inline-flex;
		align-items: center;
		justify-content: center;
		transition: transform 0.3s ease;
		width: 16px;
		height: 16px;
	}
	.btn-continue-shopping:hover i {
		transform: translateX(-3px);
	}
	.btn-continue-shopping span {
		letter-spacing: 0.3px;
		line-height: 1.2;
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
					<h1 class="page-name">Keranjang</h1>
					<ol class="breadcrumb">
						<li><a href="/">Home</a></li>
						<li class="active">Keranjang</li>
					</ol>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- Cart Section -->
<section class="products section">
	<div class="container">
		@if(count($cartItems) > 0)
		<div class="row">
			<div class="col-md-12">
				<div class="block">
					<div class="product-list">
						<table class="table cart-table">
							<thead>
								<tr>
									<th>Produk</th>
									<th>Harga</th>
									<th>Jumlah</th>
									<th>Subtotal</th>
									<th>Aksi</th>
								</tr>
							</thead>
							<tbody>
								@foreach($cartItems as $item)
								<tr data-product-id="{{ $item['product']->id }}">
									<td>
										<div class="product-info">
											<a href="{{ route('frontend.products.show', $item['product']->slug) }}">
												<img src="{{ $item['product']->image ? (strpos($item['product']->image, 'http') === 0 ? $item['product']->image : asset($item['product']->image)) : 'https://images.unsplash.com/photo-1525547719571-a2d4ac8945e2?w=100&h=100&fit=crop' }}" alt="{{ $item['product']->name }}" />
											</a>
											<div>
												<a href="{{ route('frontend.products.show', $item['product']->slug) }}">{{ $item['product']->name }}</a>
											</div>
										</div>
									</td>
									<td>
										<strong>Rp {{ number_format($item['product']->price, 0, ',', '.') }}</strong>
									</td>
									<td>
										<div class="quantity-input">
											<button type="button" onclick="updateQuantity({{ $item['product']->id }}, {{ $item['quantity'] - 1 }})">-</button>
											<input type="number" id="qty-{{ $item['product']->id }}" value="{{ $item['quantity'] }}" min="1" onchange="updateQuantity({{ $item['product']->id }}, this.value)">
											<button type="button" onclick="updateQuantity({{ $item['product']->id }}, {{ $item['quantity'] + 1 }})">+</button>
										</div>
									</td>
									<td>
										<strong class="subtotal-{{ $item['product']->id }}">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</strong>
									</td>
									<td>
										<a href="#" class="product-remove" onclick="removeFromCart({{ $item['product']->id }}); return false;">
											<i class="tf-ion-close"></i> Hapus
										</a>
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>

						<div class="row">
							<div class="col-md-6">
								<a href="{{ route('homepage') }}" class="btn-continue-shopping">
									<i class="tf-ion-arrow-left-a"></i>
									<span>Lanjut Belanja</span>
								</a>
							</div>
							<div class="col-md-6">
								<div class="cart-summary">
									<h4>Ringkasan Keranjang</h4>
									<div class="summary-row">
										<span>Total Item:</span>
										<span><strong>{{ $totalItems }} item</strong></span>
									</div>
									<div class="summary-row">
										<span>Subtotal:</span>
										<span>Rp {{ number_format($total, 0, ',', '.') }}</span>
									</div>
									<div class="summary-row">
										<span>Total:</span>
										<span class="text-primary">Rp {{ number_format($total, 0, ',', '.') }}</span>
									</div>
									<a href="{{ route('checkout') }}" class="btn btn-main btn-block" style="margin-top: 20px;">
										<i class="tf-ion-android-cart"></i> Checkout
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		@else
		<div class="row">
			<div class="col-md-12">
				<div class="empty-cart">
					<i class="tf-ion-ios-cart-outline"></i>
					<h3>Keranjang Anda Kosong</h3>
					<p>Mulai berbelanja dan tambahkan produk ke keranjang Anda</p>
					<a href="{{ route('homepage') }}" class="btn-continue-shopping" style="margin-top: 20px;">
						<i class="tf-ion-arrow-left-a"></i>
						<span>Mulai Belanja</span>
					</a>
				</div>
			</div>
		</div>
		@endif
	</div>
</section>

@endsection

@push('scripts')
<script>
	function updateQuantity(productId, quantity) {
		if (quantity < 1) {
			removeFromCart(productId);
			return;
		}

		$.ajax({
			url: '/cart/update/' + productId,
			method: 'POST',
			data: {
				_token: '{{ csrf_token() }}',
				quantity: quantity
			},
			success: function(response) {
				// Reload page to update totals
				location.reload();
			},
			error: function() {
				alert('Terjadi kesalahan. Silakan coba lagi.');
			}
		});
	}

	function removeFromCart(productId) {
		if (!confirm('Apakah Anda yakin ingin menghapus produk ini dari keranjang?')) {
			return;
		}

		$.ajax({
			url: '/cart/remove/' + productId,
			method: 'DELETE',
			data: {
				_token: '{{ csrf_token() }}'
			},
			success: function(response) {
				// Remove row from table
				$('tr[data-product-id="' + productId + '"]').fadeOut(300, function() {
					$(this).remove();
					// Update cart count in navbar
					updateCartCount();
					// Reload if cart is empty
					if ($('.cart-table tbody tr').length === 0) {
						location.reload();
					} else {
						location.reload();
					}
				});
			},
			error: function() {
				alert('Terjadi kesalahan. Silakan coba lagi.');
			}
		});
	}

	function updateCartCount() {
		$.get('/cart/count', function(data) {
			$('#cartCount').text(data.count || 0);
		});
	}

	$(document).ready(function() {
		updateCartCount();
	});
</script>
@endpush


@extends('frontend.layouts.app')

@section('title', 'Checkout - AWAN KOMPUTER')
@section('description', 'Checkout - AWAN KOMPUTER')

@push('styles')
<style>
	.checkout-section {
		padding: 40px 0;
	}
	.checkout-card {
		background: #fff;
		border-radius: 8px;
		box-shadow: 0 2px 10px rgba(0,0,0,0.1);
		padding: 25px;
		margin-bottom: 25px;
	}
	.checkout-card h4 {
		font-size: 18px;
		font-weight: 600;
		margin-bottom: 20px;
		color: #333;
		border-bottom: 2px solid #f0f0f0;
		padding-bottom: 15px;
	}
	.form-group {
		margin-bottom: 20px;
	}
	.form-group label {
		display: block;
		margin-bottom: 8px;
		font-weight: 600;
		color: #333;
		font-size: 14px;
	}
	.form-group label .text-danger {
		color: #e74c3c;
	}
	.form-control {
		width: 100%;
		padding: 12px 15px;
		border: 1px solid #ddd;
		border-radius: 6px;
		font-size: 14px;
		transition: all 0.3s ease;
	}
	.form-control:focus {
		outline: none;
		border-color: #4A90E2;
		box-shadow: 0 0 0 3px rgba(74, 144, 226, 0.1);
	}
	.payment-method {
		display: flex;
		align-items: center;
		padding: 15px;
		margin-bottom: 15px;
		border: 2px solid #e0e0e0;
		border-radius: 8px;
		cursor: pointer;
		transition: all 0.3s ease;
	}
	.payment-method:hover {
		border-color: #4A90E2;
		background: #f8f9ff;
	}
	.payment-method input[type="radio"] {
		margin-right: 15px;
		width: 20px;
		height: 20px;
		cursor: pointer;
	}
	.payment-method input[type="radio"]:checked + label {
		color: #4A90E2;
		font-weight: 600;
	}
	.payment-method label {
		margin: 0;
		cursor: pointer;
		font-size: 15px;
		flex: 1;
	}
	.payment-icon {
		font-size: 24px;
		margin-right: 10px;
		color: #4A90E2;
	}
	.order-summary {
		background: #f8f9fa;
		border-radius: 8px;
		padding: 20px;
	}
	.order-item {
		display: flex;
		align-items: center;
		margin-bottom: 15px;
		padding-bottom: 15px;
		border-bottom: 1px solid #e0e0e0;
	}
	.order-item:last-child {
		border-bottom: none;
		margin-bottom: 0;
		padding-bottom: 0;
	}
	.order-item img {
		width: 60px;
		height: 60px;
		object-fit: cover;
		border-radius: 6px;
		margin-right: 15px;
	}
	.order-item-info {
		flex: 1;
	}
	.order-item-info h5 {
		font-size: 14px;
		font-weight: 600;
		margin: 0 0 5px 0;
		color: #333;
	}
	.order-item-info h5 a {
		color: #333;
		text-decoration: none;
	}
	.order-item-info h5 a:hover {
		color: #4A90E2;
	}
	.order-item-price {
		font-size: 13px;
		color: #666;
	}
	.summary-row {
		display: flex;
		justify-content: space-between;
		margin-bottom: 12px;
		padding-bottom: 12px;
		border-bottom: 1px solid #e0e0e0;
		font-size: 14px;
	}
	.summary-row:last-child {
		border-bottom: none;
		margin-bottom: 0;
		padding-bottom: 0;
		font-size: 18px;
		font-weight: bold;
	}
	.summary-row.total {
		margin-top: 15px;
		padding-top: 15px;
		border-top: 2px solid #4A90E2;
	}
	.btn-checkout {
		width: 100%;
		padding: 14px;
		background: #4A90E2;
		color: #fff;
		border: none;
		border-radius: 6px;
		font-size: 16px;
		font-weight: 600;
		cursor: pointer;
		transition: all 0.3s ease;
		margin-top: 20px;
	}
	.btn-checkout:hover {
		background: #357ABD;
		transform: translateY(-2px);
		box-shadow: 0 4px 12px rgba(74, 144, 226, 0.3);
	}
	.btn-checkout:disabled {
		background: #ccc;
		cursor: not-allowed;
		transform: none;
	}
	.alert {
		padding: 15px;
		border-radius: 6px;
		margin-bottom: 20px;
	}
	.alert-info {
		background: #e3f2fd;
		border-left: 4px solid #2196F3;
		color: #1976D2;
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
		width: 100%;
		margin-top: 15px;
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
					<h1 class="page-name">Checkout</h1>
					<ol class="breadcrumb">
						<li><a href="/">Home</a></li>
						<li><a href="{{ route('cart.index') }}">Keranjang</a></li>
						<li class="active">Checkout</li>
					</ol>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- Checkout Section -->
<section class="checkout-section">
	<div class="container">
		<form id="checkoutForm" action="{{ route('checkout.process') }}" method="POST" enctype="multipart/form-data">
			@csrf
			<div class="row">
				<div class="col-md-8">
					<!-- Informasi Pengiriman -->
					<div class="checkout-card">
						<h4><i class="tf-ion-ios-location"></i> Informasi Pengiriman</h4>
						@guest
						<div class="alert alert-info">
							<p style="margin: 0;">Silakan <a href="{{ route('login') }}" style="color: #1976D2; font-weight: 600;">Login</a> untuk checkout lebih cepat, atau isi form di bawah ini.</p>
						</div>
						@endauth

						<div class="form-group">
							<label>Nama Lengkap <span class="text-danger">*</span></label>
							<input type="text" name="name" class="form-control" value="{{ Auth::check() ? Auth::user()->name : old('name') }}" required>
						</div>

						<div class="form-group">
							<label>Email <span class="text-danger">*</span></label>
							<input type="email" name="email" class="form-control" value="{{ Auth::check() ? Auth::user()->email : old('email') }}" required>
						</div>

						<div class="form-group">
							<label>No. Telepon <span class="text-danger">*</span></label>
							<input type="tel" name="phone" class="form-control" placeholder="0812-3456-7890" value="{{ old('phone') }}" required>
						</div>

						<div class="form-group">
							<label>Alamat Lengkap <span class="text-danger">*</span></label>
							<textarea name="address" class="form-control" rows="3" placeholder="Jl. Contoh No. 123, RT/RW, Kelurahan, Kecamatan" required>{{ old('address') }}</textarea>
						</div>

						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label>Kota <span class="text-danger">*</span></label>
									<input type="text" name="city" class="form-control" placeholder="Jakarta" value="{{ old('city') }}" required>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Kode Pos <span class="text-danger">*</span></label>
									<input type="text" name="postal_code" class="form-control" placeholder="12345" value="{{ old('postal_code') }}" required>
								</div>
							</div>
						</div>
					</div>

					<!-- Metode Pembayaran -->
					<div class="checkout-card">
						<h4><i class="tf-ion-card"></i> Metode Pembayaran</h4>

						<div class="payment-method">
							<input type="radio" name="payment_method" id="bank" value="bank" {{ old('payment_method', 'bank') == 'bank' ? 'checked' : '' }} required>
							<i class="tf-ion-ios-unlocked payment-icon"></i>
							<label for="bank">Transfer Bank (BCA, Mandiri, BNI)</label>
						</div>

						<!-- Bukti Transfer Upload (for Bank Transfer) -->
						<div id="proof-upload" style="margin-top: 10px; margin-left: 50px; padding: 15px; background: #f8f9fa; border-radius: 6px; border: 1px solid #e0e0e0; {{ old('payment_method', 'bank') == 'bank' ? '' : 'display: none;' }}">
							<div class="form-group" style="margin-bottom: 10px;">
								<label style="margin-bottom: 5px; font-size: 13px;">Upload Bukti Transfer <span class="text-danger">*</span></label>
								<input type="file" name="proof_of_payment" id="proof_of_payment" class="form-control" accept="image/jpeg,image/jpg,image/png" style="padding: 8px 12px; font-size: 13px;" {{ old('payment_method', 'bank') == 'bank' ? 'required' : '' }}>
								<small class="text-muted" style="font-size: 11px; display: block; margin-top: 5px;">Format: JPG, PNG (Maks. 2MB)</small>
							</div>
							<div id="proof-preview" style="margin-top: 8px;"></div>
						</div>

						<div class="payment-method">
							<input type="radio" name="payment_method" id="cod" value="cod" {{ old('payment_method') == 'cod' ? 'checked' : '' }}>
							<i class="tf-ion-cash payment-icon"></i>
							<label for="cod">Cash on Delivery (COD)</label>
						</div>

						<div class="payment-method">
							<input type="radio" name="payment_method" id="ewallet" value="ewallet" {{ old('payment_method') == 'ewallet' ? 'checked' : '' }}>
							<i class="tf-ion-iphone payment-icon"></i>
							<label for="ewallet">E-Wallet (OVO, GoPay, Dana, ShopeePay)</label>
						</div>
					</div>
				</div>

				<!-- Ringkasan Pesanan -->
				<div class="col-md-4">
					<div class="checkout-card">
						<h4><i class="tf-ion-ios-cart"></i> Ringkasan Pesanan</h4>

						<div class="order-summary">
							@foreach($cartItems as $item)
							<div class="order-item">
								<a href="{{ route('frontend.products.show', $item['product']->slug) }}">
									<img src="{{ $item['product']->image ? (strpos($item['product']->image, 'http') === 0 ? $item['product']->image : asset($item['product']->image)) : 'https://images.unsplash.com/photo-1525547719571-a2d4ac8945e2?w=100&h=100&fit=crop' }}" alt="{{ $item['product']->name }}" />
								</a>
								<div class="order-item-info">
									<h5><a href="{{ route('frontend.products.show', $item['product']->slug) }}">{{ $item['product']->name }}</a></h5>
									<div class="order-item-price">
										{{ $item['quantity'] }} x Rp {{ number_format($item['product']->price, 0, ',', '.') }}
									</div>
								</div>
								<div style="font-weight: 600; color: #4A90E2;">
									Rp {{ number_format($item['subtotal'], 0, ',', '.') }}
								</div>
							</div>
							@endforeach

							<hr style="margin: 20px 0;">

							<div class="summary-row">
								<span>Subtotal ({{ $totalItems }} item)</span>
								<span>Rp {{ number_format($total, 0, ',', '.') }}</span>
							</div>
							<div class="summary-row">
								<span>Ongkir (Kurir Toko)</span>
								<span>Rp {{ number_format($shipping, 0, ',', '.') }}</span>
							</div>
							<div class="summary-row total">
								<span>Total</span>
								<span style="color: #4A90E2; font-size: 20px;">Rp {{ number_format($grandTotal, 0, ',', '.') }}</span>
							</div>
						</div>

						<button type="submit" class="btn-checkout" id="submitBtn">
							<i class="tf-ion-checkmark-round"></i> Proses Pembayaran
						</button>

						<a href="{{ route('homepage') }}" class="btn-continue-shopping">
							<i class="tf-ion-arrow-left-a"></i>
							<span>Lanjut Belanja</span>
						</a>
					</div>
				</div>
			</div>
		</form>
	</div>
</section>

@endsection

@push('scripts')
<script>
	$(document).ready(function() {
		// Payment method selection
		$('input[name="payment_method"]').on('change', function() {
			if ($(this).val() === 'bank') {
				$('#proof-upload').slideDown();
				$('#proof_of_payment').prop('required', true);
			} else {
				$('#proof-upload').slideUp();
				$('#proof_of_payment').prop('required', false);
				$('#proof_of_payment').val('');
				$('#proof-preview').html('');
			}
		});

		// Proof of payment preview
		$('#proof_of_payment').on('change', function(e) {
			const file = e.target.files[0];
			if (file) {
				// Validate file size (2MB max)
				if (file.size > 2 * 1024 * 1024) {
					alert('Ukuran file maksimal 2MB');
					$(this).val('');
					$('#proof-preview').html('');
					return;
				}

				const reader = new FileReader();
				reader.onload = function(e) {
					$('#proof-preview').html(
						'<img src="' + e.target.result + '" style="max-width: 200px; max-height: 200px; border-radius: 6px; border: 1px solid #ddd; margin-top: 10px;">'
					);
				};
				reader.readAsDataURL(file);
			} else {
				$('#proof-preview').html('');
			}
		});

		// Form submission
		$('#checkoutForm').on('submit', function(e) {
			// Validate proof of payment for bank transfer
			if ($('input[name="payment_method"]:checked').val() === 'bank') {
				if (!$('#proof_of_payment').val()) {
					e.preventDefault();
					alert('Silakan upload bukti transfer terlebih dahulu');
					return false;
				}
			}

			const submitBtn = $('#submitBtn');
			submitBtn.prop('disabled', true);
			submitBtn.html('<i class="tf-ion-load-c"></i> Memproses...');
		});

		// Payment method selection styling
		$('.payment-method input[type="radio"]').on('change', function() {
			$('.payment-method').removeClass('selected');
			$(this).closest('.payment-method').addClass('selected');
		});

		// Initialize selected payment method
		$('.payment-method input[type="radio"]:checked').closest('.payment-method').addClass('selected');
	});
</script>
@endpush

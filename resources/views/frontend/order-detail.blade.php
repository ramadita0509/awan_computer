@extends('frontend.layouts.app')

@section('title', 'Detail Pesanan - AWAN KOMPUTER')
@section('description', 'Detail pesanan Anda di AWAN KOMPUTER')

@push('styles')
<style>
	.order-detail-section {
		padding: 40px 0;
	}
	.order-detail-card {
		background: #fff;
		border-radius: 8px;
		box-shadow: 0 2px 10px rgba(0,0,0,0.1);
		padding: 25px;
		margin-bottom: 25px;
	}
	.order-detail-card h4 {
		font-size: 18px;
		font-weight: 600;
		margin-bottom: 20px;
		padding-bottom: 15px;
		border-bottom: 2px solid #f0f0f0;
	}
	.info-row {
		display: flex;
		margin-bottom: 15px;
		padding-bottom: 15px;
		border-bottom: 1px solid #f0f0f0;
	}
	.info-row:last-child {
		border-bottom: none;
		margin-bottom: 0;
		padding-bottom: 0;
	}
	.info-label {
		width: 200px;
		font-weight: 600;
		color: #666;
		font-size: 14px;
	}
	.info-value {
		flex: 1;
		color: #333;
		font-size: 14px;
	}
	.status-badge {
		display: inline-block;
		padding: 6px 12px;
		border-radius: 20px;
		font-size: 12px;
		font-weight: 600;
		text-transform: uppercase;
	}
	.status-pending {
		background: #fff3cd;
		color: #856404;
	}
	.status-processing {
		background: #cfe2ff;
		color: #084298;
	}
	.status-shipped {
		background: #d1e7dd;
		color: #0f5132;
	}
	.status-delivered {
		background: #d4edda;
		color: #155724;
	}
	.status-cancelled {
		background: #f8d7da;
		color: #721c24;
	}
	.payment-badge {
		display: inline-block;
		padding: 4px 10px;
		border-radius: 15px;
		font-size: 11px;
		font-weight: 600;
		margin-left: 10px;
	}
	.payment-pending {
		background: #fff3cd;
		color: #856404;
	}
	.payment-paid {
		background: #d1e7dd;
		color: #0f5132;
	}
	.payment-failed {
		background: #f8d7da;
		color: #721c24;
	}
	.order-item {
		display: flex;
		align-items: center;
		padding: 15px;
		border: 1px solid #f0f0f0;
		border-radius: 6px;
		margin-bottom: 10px;
	}
	.order-item img {
		width: 60px;
		height: 60px;
		object-fit: cover;
		border-radius: 4px;
		margin-right: 15px;
	}
	.order-item-info {
		flex: 1;
	}
	.order-item-info h5 {
		font-size: 15px;
		font-weight: 600;
		margin: 0 0 5px 0;
	}
	.order-item-info h5 a {
		color: #333;
		text-decoration: none;
	}
	.order-item-info h5 a:hover {
		color: #4A90E2;
	}
	.order-item-info p {
		font-size: 13px;
		color: #666;
		margin: 0;
	}
	.order-item-price {
		font-size: 16px;
		font-weight: 600;
		color: #4A90E2;
	}
	.summary-box {
		background: #f8f9fa;
		border-radius: 8px;
		padding: 20px;
	}
	.summary-row {
		display: flex;
		justify-content: space-between;
		margin-bottom: 12px;
		font-size: 14px;
	}
	.summary-row.total {
		margin-top: 15px;
		padding-top: 15px;
		border-top: 2px solid #4A90E2;
		font-size: 18px;
		font-weight: bold;
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
					<h1 class="page-name">Detail Pesanan</h1>
					<ol class="breadcrumb">
						<li><a href="/">Home</a></li>
						<li><a href="{{ route('orders.index') }}">Pesanan Saya</a></li>
						<li class="active">Detail</li>
					</ol>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- Order Detail Section -->
<section class="order-detail-section">
	<div class="container">
		<div class="row">
			<div class="col-md-8">
				<!-- Informasi Pesanan -->
				<div class="order-detail-card">
					<h4><i class="tf-ion-information"></i> Informasi Pesanan</h4>
					<div class="info-row">
						<div class="info-label">Nomor Pesanan:</div>
						<div class="info-value"><strong style="color: #4A90E2; font-size: 16px;">#{{ $order->order_number }}</strong></div>
					</div>
					<div class="info-row">
						<div class="info-label">Tanggal Pesanan:</div>
						<div class="info-value">{{ $order->created_at->format('d F Y') }}<br><small style="color: #999;">{{ $order->created_at->format('H:i') }} WIB</small></div>
					</div>
					<div class="info-row">
						<div class="info-label">Status Pesanan:</div>
						<div class="info-value">
							<span class="status-badge status-{{ $order->status }}">{{ ucfirst($order->status) }}</span>
							<span class="payment-badge payment-{{ $order->payment_status }}">{{ $order->payment_status == 'paid' ? 'Lunas' : ($order->payment_status == 'pending' ? 'Menunggu' : 'Gagal') }}</span>
						</div>
					</div>
					@if($order->tracking_number)
					<div class="info-row" style="background: #e3f2fd; padding: 15px; border-radius: 6px; margin-top: 15px; border-left: 4px solid #2196F3;">
						<div class="info-label" style="min-width: auto; color: #1976D2;">
							<i class="tf-ion-ios-cart"></i>
							<strong>Informasi Pengiriman:</strong>
						</div>
						<div class="info-value" style="color: #0d47a1;">
							<div style="margin-bottom: 5px;">
								<strong>No. Resi:</strong> {{ $order->tracking_number }}
							</div>
							<div style="margin-bottom: 5px;">
								<strong>Jasa Pengiriman:</strong> {{ $order->courier_name }}
							</div>
							@if($order->shipped_date)
							<div>
								<strong>Tanggal Kirim:</strong> {{ \Carbon\Carbon::parse($order->shipped_date)->format('d F Y') }}
							</div>
							@endif
						</div>
					</div>
					@endif
				</div>

				<!-- Informasi Pengiriman -->
				<div class="order-detail-card">
					<h4><i class="tf-ion-ios-location"></i> Informasi Pengiriman</h4>
					<div class="info-row">
						<div class="info-label">Nama:</div>
						<div class="info-value">{{ $order->name }}</div>
					</div>
					<div class="info-row">
						<div class="info-label">Email:</div>
						<div class="info-value">{{ $order->email }}</div>
					</div>
					<div class="info-row">
						<div class="info-label">Telepon:</div>
						<div class="info-value">{{ $order->phone }}</div>
					</div>
					<div class="info-row">
						<div class="info-label">Alamat:</div>
						<div class="info-value">{{ $order->address }}, {{ $order->city }}, {{ $order->postal_code }}</div>
					</div>
				</div>

				<!-- Item Pesanan -->
				<div class="order-detail-card">
					<h4><i class="tf-ion-ios-cart"></i> Item Pesanan</h4>
					@foreach($order->items as $item)
					<div class="order-item">
						<a href="{{ route('frontend.products.show', $item->product->slug ?? '#') }}">
							<img src="{{ $item->product->image ?? 'https://images.unsplash.com/photo-1525547719571-a2d4ac8945e2?w=100&h=100&fit=crop' }}" alt="{{ $item->product_name }}" />
						</a>
						<div class="order-item-info">
							<h5><a href="{{ route('frontend.products.show', $item->product->slug ?? '#') }}">{{ $item->product_name }}</a></h5>
							<p>{{ $item->quantity }} x Rp {{ number_format($item->product_price, 0, ',', '.') }}</p>
						</div>
						<div class="order-item-price">
							Rp {{ number_format($item->subtotal, 0, ',', '.') }}
						</div>
					</div>
					@endforeach
				</div>
			</div>

			<div class="col-md-4">
				<!-- Ringkasan -->
				<div class="order-detail-card">
					<h4><i class="tf-ion-cash"></i> Ringkasan</h4>
					<div class="summary-box">
						<div class="summary-row">
							<span>Subtotal:</span>
							<span>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
						</div>
						<div class="summary-row">
							<span>Ongkir:</span>
							<span>Rp {{ number_format($order->shipping, 0, ',', '.') }}</span>
						</div>
						<div class="summary-row total">
							<span>Total:</span>
							<span style="color: #4A90E2;">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
						</div>
					</div>
					<div style="margin-top: 20px;">
						<div class="info-row">
							<div class="info-label">Metode Pembayaran:</div>
							<div class="info-value">{{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</div>
						</div>
					</div>
				</div>

				<a href="{{ route('orders.index') }}" class="btn-continue-shopping" style="width: 100%; text-align: center;">
					<i class="tf-ion-arrow-left-a"></i>
					<span>Kembali ke Pesanan Saya</span>
				</a>
			</div>
		</div>
	</div>
</section>

@endsection


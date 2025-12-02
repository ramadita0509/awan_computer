@extends('frontend.layouts.app')

@section('title', 'Pesanan Saya - AWAN KOMPUTER')
@section('description', 'Daftar pesanan Anda di AWAN KOMPUTER')

@push('styles')
<style>
	.orders-section {
		padding: 40px 0;
	}
	.order-card {
		background: #fff;
		border-radius: 8px;
		box-shadow: 0 2px 10px rgba(0,0,0,0.1);
		padding: 25px;
		margin-bottom: 20px;
		transition: all 0.3s ease;
	}
	.order-card:hover {
		box-shadow: 0 4px 15px rgba(0,0,0,0.15);
		transform: translateY(-2px);
	}
	.order-header {
		display: flex;
		justify-content: space-between;
		align-items: center;
		margin-bottom: 20px;
		padding-bottom: 15px;
		border-bottom: 2px solid #f0f0f0;
	}
	.order-number {
		font-size: 16px;
		font-weight: 600;
		color: #4A90E2;
	}
	.order-date {
		font-size: 14px;
		color: #666;
	}
	.order-status {
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
	.payment-status {
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
	.order-items {
		margin-bottom: 20px;
	}
	.order-item {
		display: flex;
		align-items: center;
		padding: 15px 0;
		border-bottom: 1px solid #f0f0f0;
	}
	.order-item:last-child {
		border-bottom: none;
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
	.order-item-info p {
		font-size: 13px;
		color: #666;
		margin: 0;
	}
	.order-summary {
		display: flex;
		justify-content: space-between;
		align-items: center;
		padding-top: 15px;
		border-top: 2px solid #f0f0f0;
	}
	.order-total {
		font-size: 18px;
		font-weight: bold;
		color: #4A90E2;
	}
	.order-actions {
		display: flex;
		gap: 10px;
	}
	.btn-view {
		padding: 8px 20px;
		background: #4A90E2;
		color: #fff;
		border: none;
		border-radius: 6px;
		text-decoration: none;
		font-size: 14px;
		font-weight: 600;
		transition: all 0.3s ease;
	}
	.btn-view:hover {
		background: #357ABD;
		color: #fff;
		text-decoration: none;
		transform: translateY(-2px);
	}
	.empty-orders {
		text-align: center;
		padding: 60px 20px;
	}
	.empty-orders i {
		font-size: 64px;
		color: #ddd;
		margin-bottom: 20px;
	}
	.empty-orders h3 {
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
		font-size: 12px;
		line-height: 1;
		display: inline-flex;
		align-items: center;
		justify-content: center;
		transition: transform 0.3s ease;
		width: 14px;
		height: 14px;
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
					<h1 class="page-name">Pesanan Saya</h1>
					<ol class="breadcrumb">
						<li><a href="/">Home</a></li>
						<li class="active">Pesanan Saya</li>
					</ol>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- Orders Section -->
<section class="orders-section">
	<div class="container">
		@if($orders->count() > 0)
		<div class="row">
			<div class="col-md-12">
				@foreach($orders as $order)
				<div class="order-card">
					<div class="order-header">
						<div>
							<div class="order-number">#{{ $order->order_number }}</div>
							<div class="order-date">{{ $order->created_at->format('d M Y, H:i') }}</div>
						</div>
						<div>
							<span class="order-status status-{{ $order->status }}">{{ ucfirst($order->status) }}</span>
							<span class="payment-status payment-{{ $order->payment_status }}">{{ $order->payment_status == 'paid' ? 'Lunas' : ($order->payment_status == 'pending' ? 'Menunggu' : 'Gagal') }}</span>
						</div>
					</div>

					<div class="order-items">
						@foreach($order->items as $item)
						<div class="order-item">
							<a href="{{ route('frontend.products.show', $item->product->slug ?? '#') }}">
								<img src="{{ $item->product->image ?? 'https://images.unsplash.com/photo-1525547719571-a2d4ac8945e2?w=100&h=100&fit=crop' }}" alt="{{ $item->product_name }}" />
							</a>
							<div class="order-item-info">
								<h5><a href="{{ route('frontend.products.show', $item->product->slug ?? '#') }}">{{ $item->product_name }}</a></h5>
								<p>{{ $item->quantity }} x Rp {{ number_format($item->product_price, 0, ',', '.') }}</p>
							</div>
							<div style="font-weight: 600; color: #4A90E2;">
								Rp {{ number_format($item->subtotal, 0, ',', '.') }}
							</div>
						</div>
						@endforeach
					</div>

					<div class="order-summary">
						<div>
							<strong>Total: <span class="order-total">Rp {{ number_format($order->total, 0, ',', '.') }}</span></strong>
							<br>
							<small style="color: #666;">Metode Pembayaran: {{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</small>
						</div>
						<div class="order-actions">
							<a href="{{ route('orders.show', $order->id) }}" class="btn-view">
								<i class="tf-ion-ios-eye"></i> Detail Pesanan
							</a>
						</div>
					</div>
				</div>
				@endforeach

				<!-- Pagination -->
				@if($orders->hasPages())
				<div class="row">
					<div class="col-md-12">
						<nav aria-label="Page navigation">
							<ul class="pagination post-pagination text-center">
								@if($orders->onFirstPage())
									<li class="disabled"><span>Prev</span></li>
								@else
									<li><a href="{{ $orders->previousPageUrl() }}">Prev</a></li>
								@endif

								@foreach($orders->getUrlRange(1, $orders->lastPage()) as $page => $url)
									@if($page == $orders->currentPage())
										<li class="active"><span>{{ $page }}</span></li>
									@else
										<li><a href="{{ $url }}">{{ $page }}</a></li>
									@endif
								@endforeach

								@if($orders->hasMorePages())
									<li><a href="{{ $orders->nextPageUrl() }}">Next</a></li>
								@else
									<li class="disabled"><span>Next</span></li>
								@endif
							</ul>
						</nav>
					</div>
				</div>
				@endif
			</div>
		</div>
		@else
		<div class="row">
			<div class="col-md-12">
				<div class="empty-orders">
					<i class="tf-ion-ios-cart-outline"></i>
					<h3>Belum Ada Pesanan</h3>
					<p>Anda belum memiliki pesanan. Mulai berbelanja sekarang!</p>
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


@extends('backend.layouts.app')

@section('title', 'Pesanan Masuk')

@push('styles')
<style>
	.stats-card {
		background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
		border-radius: 12px;
		padding: 20px;
		color: #fff;
		margin-bottom: 25px;
		box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
	}
	.stats-card.success {
		background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
		box-shadow: 0 4px 15px rgba(17, 153, 142, 0.3);
	}
	.stats-card.warning {
		background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
		box-shadow: 0 4px 15px rgba(245, 87, 108, 0.3);
	}
	.stats-card.info {
		background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
		box-shadow: 0 4px 15px rgba(79, 172, 254, 0.3);
	}
	.stats-card h3 {
		font-size: 32px;
		font-weight: bold;
		margin: 0 0 5px 0;
	}
	.stats-card p {
		margin: 0;
		font-size: 14px;
		opacity: 0.9;
	}
	.stats-card i {
		font-size: 40px;
		opacity: 0.8;
		float: right;
		margin-top: -20px;
	}
	.order-table img {
		width: 40px;
		height: 40px;
		object-fit: cover;
		border-radius: 4px;
		border: 1px solid #e0e0e0;
	}
	.order-items-preview {
		display: flex;
		gap: 5px;
		flex-wrap: wrap;
	}
	.order-items-preview img {
		width: 35px;
		height: 35px;
		object-fit: cover;
		border-radius: 3px;
		border: 1px solid #e0e0e0;
	}
	.order-number-link {
		color: #4A90E2;
		font-weight: 600;
		text-decoration: none;
	}
	.order-number-link:hover {
		color: #357ABD;
		text-decoration: underline;
	}
	.customer-info {
		font-size: 13px;
	}
	.customer-name {
		font-weight: 600;
		color: #2c3e50;
		margin-bottom: 3px;
	}
	.customer-detail {
		color: #6c757d;
		font-size: 12px;
	}
	.status-badge {
		display: inline-block;
		padding: 6px 12px;
		border-radius: 20px;
		font-size: 11px;
		font-weight: 600;
		text-transform: uppercase;
		letter-spacing: 0.5px;
	}
	.status-pending {
		background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%);
		color: #fff;
	}
	.status-processing {
		background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);
		color: #fff;
	}
	.status-shipped {
		background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
		color: #fff;
	}
	.status-delivered {
		background: linear-gradient(135deg, #20c997 0%, #17a2b8 100%);
		color: #fff;
	}
	.status-cancelled {
		background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
		color: #fff;
	}
	.payment-badge {
		display: inline-block;
		padding: 4px 10px;
		border-radius: 15px;
		font-size: 10px;
		font-weight: 600;
		margin-top: 4px;
	}
	.payment-pending {
		background: #fff3cd;
		color: #856404;
		border: 1px solid #ffc107;
	}
	.payment-paid {
		background: #d1e7dd;
		color: #0f5132;
		border: 1px solid #28a745;
	}
	.payment-failed {
		background: #f8d7da;
		color: #721c24;
		border: 1px solid #dc3545;
	}
	.table tbody tr {
		transition: all 0.2s ease;
	}
	.table tbody tr:hover {
		background-color: #f8f9fa;
		transform: scale(1.01);
	}
</style>
@endpush

@section('content')
<div class="content-wrapper">
	<div class="page-header">
		<h3 class="page-title">
			<span class="page-title-icon bg-gradient-primary text-white me-2">
				<i class="mdi mdi-cart"></i>
			</span> Pesanan Masuk
		</h3>
		<nav aria-label="breadcrumb">
			<ul class="breadcrumb">
				<li class="breadcrumb-item active" aria-current="page">
					<span></span>Semua Pesanan <i class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>
				</li>
			</ul>
		</nav>
	</div>

	@php
		$totalOrders = \App\Models\Order::count();
		$pendingOrders = \App\Models\Order::where('status', 'pending')->count();
		$paidOrders = \App\Models\Order::where('payment_status', 'paid')->count();
		$totalRevenue = \App\Models\Order::where('payment_status', 'paid')->sum('total');
	@endphp

	<!-- Statistics Cards -->
	<div class="row">
		<div class="col-md-3 grid-margin stretch-card">
			<div class="stats-card">
				<h3>{{ $totalOrders }}</h3>
				<p><i class="mdi mdi-cart"></i> Total Pesanan</p>
			</div>
		</div>
		<div class="col-md-3 grid-margin stretch-card">
			<div class="stats-card warning">
				<h3>{{ $pendingOrders }}</h3>
				<p><i class="mdi mdi-clock-outline"></i> Menunggu Proses</p>
			</div>
		</div>
		<div class="col-md-3 grid-margin stretch-card">
			<div class="stats-card success">
				<h3>{{ $paidOrders }}</h3>
				<p><i class="mdi mdi-check-circle"></i> Pesanan Lunas</p>
			</div>
		</div>
		<div class="col-md-3 grid-margin stretch-card">
			<div class="stats-card info">
				<h3>Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
				<p><i class="mdi mdi-currency-usd"></i> Total Pendapatan</p>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-12 grid-margin">
			<div class="card">
				<div class="card-body">
					<h4 class="card-title mb-4">Daftar Pesanan</h4>

					@if($orders->count() > 0)
					<div class="table-responsive">
						<table class="table table-striped order-table">
							<thead>
								<tr>
									<th>No</th>
									<th>Nomor Pesanan</th>
									<th>Customer</th>
									<th>Produk</th>
									<th>Total</th>
									<th>Status Pesanan</th>
									<th>Status Pembayaran</th>
									<th>Tanggal</th>
									<th>Aksi</th>
								</tr>
							</thead>
							<tbody>
								@foreach($orders as $index => $order)
								<tr>
									<td>{{ $orders->firstItem() + $index }}</td>
									<td>
										<a href="{{ route('backend.orders.show', $order->id) }}" class="order-number-link">
											#{{ $order->order_number }}
										</a>
									</td>
									<td>
										<div class="customer-info">
											<div class="customer-name">{{ $order->name }}</div>
											<div class="customer-detail">{{ $order->email }}</div>
											<div class="customer-detail">{{ $order->phone }}</div>
										</div>
									</td>
									<td>
										<div class="order-items-preview">
											@foreach($order->items->take(3) as $item)
											<img src="{{ $item->product->image ?? 'https://images.unsplash.com/photo-1525547719571-a2d4ac8945e2?w=100&h=100&fit=crop' }}"
												alt="{{ $item->product_name }}"
												title="{{ $item->product_name }} ({{ $item->quantity }}x)" />
											@endforeach
											@if($order->items->count() > 3)
											<span style="line-height: 35px; color: #6c757d; font-size: 11px;">+{{ $order->items->count() - 3 }}</span>
											@endif
										</div>
										<small style="color: #6c757d; font-size: 11px; display: block; margin-top: 5px;">
											{{ $order->items->count() }} item
										</small>
									</td>
									<td>
										<strong style="color: #4A90E2; font-size: 15px;">
											Rp {{ number_format($order->total, 0, ',', '.') }}
										</strong>
										<br>
										<small style="color: #6c757d; font-size: 11px;">
											{{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}
										</small>
									</td>
									<td>
										<span class="status-badge status-{{ $order->status }}">{{ ucfirst($order->status) }}</span>
									</td>
									<td>
										<span class="payment-badge payment-{{ $order->payment_status }}">
											{{ $order->payment_status == 'paid' ? 'Lunas' : ($order->payment_status == 'pending' ? 'Menunggu' : 'Gagal') }}
										</span>
									</td>
									<td>
										<div style="font-size: 12px; color: #6c757d;">
											{{ $order->created_at->format('d M Y') }}<br>
											<small>{{ $order->created_at->format('H:i') }}</small>
										</div>
									</td>
									<td>
										<a href="{{ route('backend.orders.show', $order->id) }}" class="btn btn-sm btn-gradient-primary">
											<i class="mdi mdi-eye"></i> Detail & Update
										</a>
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>

					<!-- Pagination -->
					@if($orders->hasPages())
					<div class="d-flex justify-content-center mt-4">
						{{ $orders->links() }}
					</div>
					@endif
					@else
					<div class="text-center py-5">
						<i class="mdi mdi-cart-off" style="font-size: 64px; color: #ddd;"></i>
						<h4 class="mt-3" style="color: #999;">Belum Ada Pesanan</h4>
						<p style="color: #999;">Belum ada pesanan masuk dari customer.</p>
					</div>
					@endif
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@extends('backend.layouts.app')

@section('title', 'Detail Pesanan')

@push('styles')
<style>
	.order-item-row {
		display: flex;
		align-items: center;
		padding: 15px;
		border: 1px solid #e0e0e0;
		border-radius: 8px;
		margin-bottom: 15px;
		background: #f8f9fa;
	}
	.order-item-row img {
		width: 80px;
		height: 80px;
		object-fit: cover;
		border-radius: 6px;
		margin-right: 15px;
	}
	.order-item-info {
		flex: 1;
	}
	.order-item-info h6 {
		font-size: 16px;
		font-weight: 600;
		margin: 0 0 5px 0;
	}
	.order-item-info p {
		font-size: 14px;
		color: #666;
		margin: 0;
	}
	.order-item-price {
		font-size: 18px;
		font-weight: 600;
		color: #4A90E2;
	}
	.proof-payment img {
		max-width: 200px;
		max-height: 200px;
		border-radius: 8px;
		border: 2px solid #ddd;
		cursor: pointer;
		transition: all 0.3s ease;
	}
	.proof-payment img:hover {
		transform: scale(1.05);
		box-shadow: 0 4px 12px rgba(0,0,0,0.2);
	}
	#shipping-fields {
		display: none;
		margin-top: 15px;
		padding: 15px;
		background: #fff3cd;
		border-radius: 6px;
		border-left: 4px solid #ffc107;
	}
</style>
@endpush

@section('content')
<div class="content-wrapper">
	<div class="page-header">
		<h3 class="page-title">
			<span class="page-title-icon bg-gradient-primary text-white me-2">
				<i class="mdi mdi-cart"></i>
			</span> Detail Pesanan
		</h3>
		<nav aria-label="breadcrumb">
			<ul class="breadcrumb">
				<li class="breadcrumb-item"><a href="{{ route('backend.orders.index') }}">Pesanan Masuk</a></li>
				<li class="breadcrumb-item active" aria-current="page">Detail</li>
			</ul>
		</nav>
	</div>

	@if(session('success'))
	<div class="alert alert-success alert-dismissible fade show" role="alert">
		{{ session('success') }}
		<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
	</div>
	@endif

	<div class="row">
		<div class="col-md-8">
			<!-- Informasi Pesanan -->
			<div class="card">
				<div class="card-body">
					<h4 class="mb-4">Informasi Pesanan</h4>

					<div class="row mb-3">
						<div class="col-md-6">
							<strong>Nomor Pesanan:</strong>
							<p class="h5 text-primary">#{{ $order->order_number }}</p>
						</div>
						<div class="col-md-6">
							<strong>Tanggal Pesanan:</strong>
							<p>{{ $order->created_at->format('d M Y') }}<br>
							<small class="text-muted">{{ $order->created_at->format('H:i') }} WIB</small></p>
						</div>
					</div>

					<div class="row mb-3">
						<div class="col-md-6">
							<strong>Status Pesanan:</strong>
							<p>
								@if($order->status == 'pending')
									<label class="badge badge-gradient-warning">Pending</label>
								@elseif($order->status == 'processing')
									<label class="badge badge-gradient-info">Processing</label>
								@elseif($order->status == 'shipped')
									<label class="badge badge-gradient-success">Shipped</label>
								@elseif($order->status == 'delivered')
									<label class="badge badge-gradient-success">Delivered</label>
								@else
									<label class="badge badge-gradient-danger">Cancelled</label>
								@endif
							</p>
						</div>
						<div class="col-md-6">
							<strong>Status Pembayaran:</strong>
							<p>
								@if($order->payment_status == 'paid')
									<label class="badge badge-gradient-success">Lunas</label>
								@elseif($order->payment_status == 'pending')
									<label class="badge badge-gradient-warning">Menunggu Pembayaran</label>
								@else
									<label class="badge badge-gradient-danger">Gagal</label>
								@endif
							</p>
						</div>
					</div>

					@if($order->tracking_number)
					<div class="row mb-3">
						<div class="col-md-12">
							<strong>Informasi Pengiriman:</strong>
							<div class="alert alert-info mt-2">
								<p class="mb-1"><strong>No. Resi:</strong> {{ $order->tracking_number }}</p>
								<p class="mb-1"><strong>Jasa Pengiriman:</strong> {{ $order->courier_name }}</p>
								@if($order->shipped_date)
								<p class="mb-0"><strong>Tanggal Kirim:</strong> {{ \Carbon\Carbon::parse($order->shipped_date)->format('d M Y') }}</p>
								@endif
							</div>
						</div>
					</div>
					@endif
				</div>
			</div>

			<!-- Informasi Customer -->
			<div class="card">
				<div class="card-body">
					<h4 class="mb-4">Informasi Customer</h4>

					<div class="row mb-3">
						<div class="col-md-6">
							<strong>Nama:</strong>
							<p>{{ $order->name }}</p>
						</div>
						<div class="col-md-6">
							<strong>Email:</strong>
							<p><a href="mailto:{{ $order->email }}">{{ $order->email }}</a></p>
						</div>
					</div>

					<div class="row mb-3">
						<div class="col-md-6">
							<strong>Telepon:</strong>
							<p><a href="tel:{{ $order->phone }}">{{ $order->phone }}</a></p>
						</div>
						<div class="col-md-6">
							<strong>Kota:</strong>
							<p>{{ $order->city }}, {{ $order->postal_code }}</p>
						</div>
					</div>

					<div class="row mb-3">
						<div class="col-md-12">
							<strong>Alamat Lengkap:</strong>
							<p>{{ $order->address }}</p>
						</div>
					</div>

					@if($order->proof_of_payment)
					<div class="row mb-3">
						<div class="col-md-12">
							<strong>Bukti Transfer:</strong>
							<div class="proof-payment mt-2">
								<a href="{{ asset('storage/' . $order->proof_of_payment) }}" target="_blank">
									<img src="{{ asset('storage/' . $order->proof_of_payment) }}" alt="Bukti Transfer" />
								</a>
							</div>
						</div>
					</div>
					@endif
				</div>
			</div>

			<!-- Item Pesanan -->
			<div class="card">
				<div class="card-body">
					<h4 class="mb-4">Item Pesanan ({{ $order->items->count() }} item)</h4>

					@foreach($order->items as $item)
					<div class="order-item-row">
						<img src="{{ $item->product->image ?? 'https://images.unsplash.com/photo-1525547719571-a2d4ac8945e2?w=100&h=100&fit=crop' }}" alt="{{ $item->product_name }}" />
						<div class="order-item-info">
							<h6>{{ $item->product_name }}</h6>
							<p>{{ $item->quantity }} x Rp {{ number_format($item->product_price, 0, ',', '.') }}</p>
						</div>
						<div class="order-item-price">
							Rp {{ number_format($item->subtotal, 0, ',', '.') }}
						</div>
					</div>
					@endforeach
				</div>
			</div>
		</div>

		<div class="col-md-4">
			<!-- Update Status -->
			<div class="card">
				<div class="card-body">
					<h5 class="card-title mb-4">Update Status</h5>
					<form action="{{ route('backend.orders.update-status', $order->id) }}" method="POST" id="statusForm">
						@csrf
						<div class="form-group mb-3">
							<label>Status Pesanan <span class="text-danger">*</span></label>
							<select name="status" id="order_status" class="form-control" required>
								<option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
								<option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
								<option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
								<option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
								<option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
							</select>
						</div>

						<!-- Shipping Fields (Required when status = shipped) -->
						<div id="shipping-fields">
							<div class="form-group mb-3">
								<label>No. Resi <span class="text-danger">*</span></label>
								<input type="text" name="tracking_number" id="tracking_number" class="form-control" placeholder="Masukkan nomor resi" value="{{ $order->tracking_number }}">
								<small class="text-muted">Nomor resi dari jasa pengiriman</small>
							</div>
							<div class="form-group mb-3">
								<label>Nama Jasa Pengiriman <span class="text-danger">*</span></label>
								<input type="text" name="courier_name" id="courier_name" class="form-control" placeholder="Contoh: JNE, J&T, Pos Indonesia" value="{{ $order->courier_name }}">
								<small class="text-muted">Nama jasa pengiriman yang digunakan</small>
							</div>
							<div class="form-group mb-3">
								<label>Tanggal Pengiriman</label>
								<input type="date" name="shipped_date" id="shipped_date" class="form-control" value="{{ $order->shipped_date ? \Carbon\Carbon::parse($order->shipped_date)->format('Y-m-d') : date('Y-m-d') }}">
							</div>
						</div>

						<div class="form-group mb-3">
							<label>Status Pembayaran <span class="text-danger">*</span></label>
							<select name="payment_status" class="form-control" required>
								<option value="pending" {{ $order->payment_status == 'pending' ? 'selected' : '' }}>Pending</option>
								<option value="paid" {{ $order->payment_status == 'paid' ? 'selected' : '' }}>Paid</option>
								<option value="failed" {{ $order->payment_status == 'failed' ? 'selected' : '' }}>Failed</option>
							</select>
						</div>
						<button type="submit" class="btn btn-gradient-primary btn-block">
							<i class="mdi mdi-check"></i> Update Status
						</button>
					</form>
				</div>
			</div>

			<!-- Ringkasan -->
			<div class="card">
				<div class="card-body">
					<h5 class="card-title mb-4">Ringkasan Pembayaran</h5>

					<div class="row mb-2">
						<div class="col-6">
							<strong>Subtotal:</strong>
						</div>
						<div class="col-6 text-right">
							Rp {{ number_format($order->subtotal, 0, ',', '.') }}
						</div>
					</div>

					<div class="row mb-2">
						<div class="col-6">
							<strong>Ongkir:</strong>
						</div>
						<div class="col-6 text-right">
							Rp {{ number_format($order->shipping, 0, ',', '.') }}
						</div>
					</div>

					<hr>

					<div class="row mb-3">
						<div class="col-6">
							<strong class="h5">Total:</strong>
						</div>
						<div class="col-6 text-right">
							<strong class="h5 text-primary">Rp {{ number_format($order->total, 0, ',', '.') }}</strong>
						</div>
					</div>

					<div class="row">
						<div class="col-12">
							<strong>Metode Pembayaran:</strong>
							<p>{{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</p>
						</div>
					</div>
				</div>
			</div>

			<div class="card">
				<div class="card-body">
					<div class="d-grid gap-2">
						<a href="{{ route('backend.orders.index') }}" class="btn btn-light">
							<i class="mdi mdi-arrow-left"></i> Kembali ke Daftar
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@push('scripts')
<script>
	$(document).ready(function() {
		// Show/hide shipping fields based on status
		function toggleShippingFields() {
			if ($('#order_status').val() === 'shipped') {
				$('#shipping-fields').slideDown();
				$('#tracking_number').prop('required', true);
				$('#courier_name').prop('required', true);
			} else {
				$('#shipping-fields').slideUp();
				$('#tracking_number').prop('required', false);
				$('#courier_name').prop('required', false);
			}
		}

		// Initialize on page load
		toggleShippingFields();

		// Toggle on status change
		$('#order_status').on('change', function() {
			toggleShippingFields();
		});

		// Form validation
		$('#statusForm').on('submit', function(e) {
			if ($('#order_status').val() === 'shipped') {
				if (!$('#tracking_number').val() || !$('#courier_name').val()) {
					e.preventDefault();
					alert('Silakan isi No. Resi dan Nama Jasa Pengiriman terlebih dahulu');
					return false;
				}
			}
		});
	});
</script>
@endpush

@endsection

@extends('frontend.layouts.app')

@section('title', 'Pesanan Berhasil - AWAN KOMPUTER')
@section('description', 'Pesanan Anda berhasil diproses')

@push('styles')
<style>
	.success-section {
		padding: 60px 0;
		text-align: center;
	}
	.success-icon {
		font-size: 80px;
		color: #4CAF50;
		margin-bottom: 30px;
		animation: scaleIn 0.5s ease;
	}
	@keyframes scaleIn {
		from {
			transform: scale(0);
		}
		to {
			transform: scale(1);
		}
	}
	.success-message h2 {
		color: #333;
		font-size: 28px;
		margin-bottom: 15px;
		font-weight: 600;
	}
	.success-message p {
		color: #666;
		font-size: 16px;
		margin-bottom: 30px;
	}
	.success-actions {
		margin-top: 40px;
	}
	.btn-success {
		display: inline-flex;
		align-items: center;
		gap: 8px;
		padding: 12px 30px;
		background: #4A90E2;
		color: #fff;
		border: none;
		border-radius: 6px;
		text-decoration: none;
		font-size: 16px;
		font-weight: 600;
		transition: all 0.3s ease;
		margin: 0 10px;
	}
	.btn-success:hover {
		background: #357ABD;
		transform: translateY(-2px);
		box-shadow: 0 4px 12px rgba(74, 144, 226, 0.3);
		color: #fff;
		text-decoration: none;
	}
	.btn-outline {
		display: inline-flex;
		align-items: center;
		gap: 8px;
		padding: 12px 30px;
		background: #fff;
		color: #4A90E2;
		border: 2px solid #4A90E2;
		border-radius: 6px;
		text-decoration: none;
		font-size: 16px;
		font-weight: 600;
		transition: all 0.3s ease;
		margin: 0 10px;
	}
	.btn-outline:hover {
		background: #4A90E2;
		color: #fff;
		text-decoration: none;
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
					<h1 class="page-name">Pesanan Berhasil</h1>
					<ol class="breadcrumb">
						<li><a href="/">Home</a></li>
						<li class="active">Pesanan Berhasil</li>
					</ol>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- Success Section -->
<section class="success-section">
	<div class="container">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="success-icon">
					<i class="tf-ion-checkmark-circled"></i>
				</div>
				<div class="success-message">
					<h2>Pesanan Anda Berhasil Diproses!</h2>
					<p>Terima kasih telah berbelanja di AWAN KOMPUTER. Kami akan segera memproses pesanan Anda dan mengirimkan konfirmasi melalui email.</p>
					<p style="font-size: 14px; color: #999;">Nomor pesanan Anda akan dikirim melalui email yang telah Anda daftarkan.</p>
				</div>
				<div class="success-actions">
					<a href="{{ route('homepage') }}" class="btn-success">
						<i class="tf-ion-ios-home"></i> Kembali ke Beranda
					</a>
					<a href="{{ route('frontend.products.index') }}" class="btn-outline">
						<i class="tf-ion-ios-cart"></i> Lanjut Belanja
					</a>
				</div>
			</div>
		</div>
	</div>
</section>

@endsection


@extends('backend.layouts.app')

@section('title', 'Dashboard')

@push('scripts')
<script>
  var categoryData = @json(\App\Models\Category::where('is_active', true)->orderBy('sort_order')->get(['name', 'sort_order']));

  // Data for visit and sales chart (last 8 months)
  @php
    $months = [];
    $visits = [];
    $sales = [];
    $revenue = [];

    for ($i = 7; $i >= 0; $i--) {
      $date = now()->subMonths($i);
      $monthName = $date->format('M');
      $months[] = strtoupper($monthName);

      // Calculate visits (using orders as proxy for now - can be enhanced with actual visit tracking)
      $monthVisits = \App\Models\Order::whereYear('created_at', $date->year)
          ->whereMonth('created_at', $date->month)
          ->count();
      $visits[] = $monthVisits * 3; // Multiply by 3 as proxy (not all visits result in orders)

      // Calculate sales (orders)
      $monthSales = \App\Models\Order::whereYear('created_at', $date->year)
          ->whereMonth('created_at', $date->month)
          ->count();
      $sales[] = $monthSales;

      // Calculate revenue
      $monthRevenue = \App\Models\Order::whereYear('created_at', $date->year)
          ->whereMonth('created_at', $date->month)
          ->where('payment_status', 'paid')
          ->sum('total');
      $revenue[] = round($monthRevenue / 1000000, 1); // Convert to millions for better display
    }
  @endphp

  var visitSalesData = {
    labels: @json($months),
    visits: @json($visits),
    sales: @json($sales),
    revenue: @json($revenue)
  };

  // Data for top selling products
  @php
    $topProducts = \App\Models\OrderItem::select('product_name', \DB::raw('SUM(quantity) as total_quantity'), \DB::raw('SUM(subtotal) as total_revenue'))
        ->groupBy('product_name')
        ->orderBy('total_quantity', 'desc')
        ->limit(5)
        ->get();

    // Use full product names
    $productLabels = $topProducts->pluck('product_name')->toArray();
    $productQuantities = $topProducts->pluck('total_quantity')->toArray();
    $productRevenues = $topProducts->pluck('total_revenue')->toArray();

    // Calculate percentages for display
    $totalQuantity = array_sum($productQuantities);
    $productPercentages = array_map(function($qty) use ($totalQuantity) {
      return $totalQuantity > 0 ? round(($qty / $totalQuantity) * 100, 1) : 0;
    }, $productQuantities);
  @endphp

  var topProductsData = {
    labels: @json($productLabels),
    quantities: @json($productQuantities),
    revenues: @json($productRevenues),
    percentages: @json($productPercentages)
  };
</script>
@endpush

@section('content')
<div class="content-wrapper">
  <div class="page-header">
    <h3 class="page-title">
      <span class="page-title-icon bg-gradient-primary text-white me-2">
        <i class="mdi mdi-home"></i>
      </span> Dashboard
    </h3>
    <nav aria-label="breadcrumb">
      <ul class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page">
          <span></span>Overview <i class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>
        </li>
      </ul>
    </nav>
  </div>
  @php
    $categories = \App\Models\Category::where('is_active', true)->count();
    $totalCategories = \App\Models\Category::count();

    // Calculate orders for current month
    $currentMonth = now()->month;
    $currentYear = now()->year;
    $totalOrdersThisMonth = \App\Models\Order::whereYear('created_at', $currentYear)
        ->whereMonth('created_at', $currentMonth)
        ->count();

    // Calculate revenue for current month (only paid orders)
    $totalRevenueThisMonth = \App\Models\Order::whereYear('created_at', $currentYear)
        ->whereMonth('created_at', $currentMonth)
        ->where('payment_status', 'paid')
        ->sum('total');
  @endphp
  <div class="row">
    <div class="col-md-4 stretch-card grid-margin">
      <div class="card bg-gradient-danger card-img-holder text-white">
        <div class="card-body">
          <img src="{{ asset('backend/assets/images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle-image" />
          <h4 class="font-weight-normal mb-3">Total Kategori <i class="mdi mdi-folder mdi-24px float-end"></i>
          </h4>
          <h2 class="mb-5">{{ $totalCategories }}</h2>
          <h6 class="card-text">Kategori Aktif: {{ $categories }}</h6>
        </div>
      </div>
    </div>
    <div class="col-md-4 stretch-card grid-margin">
      <div class="card bg-gradient-info card-img-holder text-white">
        <div class="card-body">
          <img src="{{ asset('backend/assets/images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle-image" />
          <h4 class="font-weight-normal mb-3">Total Pesanan <i class="mdi mdi-cart mdi-24px float-end"></i>
          </h4>
          <h2 class="mb-5">{{ $totalOrdersThisMonth }}</h2>
          <h6 class="card-text">Pesanan bulan ini</h6>
        </div>
      </div>
    </div>
    <div class="col-md-4 stretch-card grid-margin">
      <div class="card bg-gradient-success card-img-holder text-white">
        <div class="card-body">
          <img src="{{ asset('backend/assets/images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle-image" />
          <h4 class="font-weight-normal mb-3">Total Pendapatan <i class="mdi mdi-currency-usd mdi-24px float-end"></i>
          </h4>
          <h2 class="mb-5">Rp {{ number_format($totalRevenueThisMonth, 0, ',', '.') }}</h2>
          <h6 class="card-text">Pendapatan bulan ini</h6>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-7 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <div class="clearfix">
            <h4 class="card-title float-start">Statistik Kunjungan dan Penjualan</h4>
            <div id="visit-sale-chart-legend" class="rounded-legend legend-horizontal legend-top-right float-end"></div>
          </div>
          <canvas id="visit-sale-chart" class="mt-4"></canvas>
        </div>
      </div>
    </div>
    <div class="col-md-5 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Produk Terlaris</h4>
          <div class="doughnutjs-wrapper d-flex justify-content-center">
            <canvas id="traffic-chart"></canvas>
          </div>
          <div id="traffic-chart-legend" class="rounded-legend legend-vertical legend-bottom-left pt-4"></div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-12 grid-margin">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Daftar Kategori</h4>
          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th> No </th>
                  <th> Nama Kategori </th>
                  <th> Slug </th>
                  <th> Status </th>
                  <th> Urutan </th>
                  <th> Aksi </th>
                </tr>
              </thead>
              <tbody>
                @php
                  $categoriesList = \App\Models\Category::orderBy('sort_order')->orderBy('name')->limit(5)->get();
                @endphp
                @forelse($categoriesList as $index => $cat)
                <tr>
                  <td>{{ $index + 1 }}</td>
                  <td>{{ $cat->name }}</td>
                  <td><code>{{ $cat->slug }}</code></td>
                  <td>
                    @if($cat->is_active)
                      <label class="badge badge-gradient-success">Aktif</label>
                    @else
                      <label class="badge badge-gradient-danger">Nonaktif</label>
                    @endif
                  </td>
                  <td>{{ $cat->sort_order }}</td>
                  <td>
                    <a href="{{ route('categories.edit', $cat->id) }}" class="btn btn-sm btn-gradient-info">
                      <i class="mdi mdi-pencil"></i>
                    </a>
                  </td>
                </tr>
                @empty
                <tr>
                  <td colspan="6" class="text-center">Belum ada kategori. <a href="{{ route('categories.create') }}">Tambah kategori</a></td>
                </tr>
                @endforelse
              </tbody>
            </table>
            <div class="text-center mt-3">
              <a href="{{ route('categories.index') }}" class="btn btn-gradient-primary">Lihat Semua Kategori</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@push('scripts')
<script>
(function ($) {
  'use strict';

  // Wait for Chart.js and page to be fully loaded
  function initCharts() {
    // Check if Chart.js is loaded
    if (typeof Chart === 'undefined') {
      setTimeout(initCharts, 100);
      return;
    }

    // Destroy any existing charts on these canvases
    var visitChartCanvas = document.getElementById('visit-sale-chart');
    var trafficChartCanvas = document.getElementById('traffic-chart');

    if (visitChartCanvas) {
      var visitChart = Chart.getChart(visitChartCanvas);
      if (visitChart) {
        visitChart.destroy();
      }
    }

    if (trafficChartCanvas) {
      var trafficChart = Chart.getChart(trafficChartCanvas);
      if (trafficChart) {
        trafficChart.destroy();
      }
    }


    // Create visit-sale chart with real data
    if (visitChartCanvas && typeof visitSalesData !== 'undefined') {
      const ctx = visitChartCanvas;

    var graphGradient1 = ctx.getContext("2d");
    var graphGradient2 = ctx.getContext("2d");
    var graphGradient3 = ctx.getContext("2d");

    var gradientStrokeViolet = graphGradient1.createLinearGradient(0, 0, 0, 181);
    gradientStrokeViolet.addColorStop(0, 'rgba(218, 140, 255, 1)');
    gradientStrokeViolet.addColorStop(1, 'rgba(154, 85, 255, 1)');
    var gradientLegendViolet = 'linear-gradient(to right, rgba(218, 140, 255, 1), rgba(154, 85, 255, 1))';

    var gradientStrokeBlue = graphGradient2.createLinearGradient(0, 0, 0, 360);
    gradientStrokeBlue.addColorStop(0, 'rgba(54, 215, 232, 1)');
    gradientStrokeBlue.addColorStop(1, 'rgba(177, 148, 250, 1)');
    var gradientLegendBlue = 'linear-gradient(to right, rgba(54, 215, 232, 1), rgba(177, 148, 250, 1))';

    var gradientStrokeRed = graphGradient3.createLinearGradient(0, 0, 0, 300);
    gradientStrokeRed.addColorStop(0, 'rgba(255, 191, 150, 1)');
    gradientStrokeRed.addColorStop(1, 'rgba(254, 112, 150, 1)');
    var gradientLegendRed = 'linear-gradient(to right, rgba(255, 191, 150, 1), rgba(254, 112, 150, 1))';
    const bgColor1 = ["rgba(218, 140, 255, 1)"];
    const bgColor2 = ["rgba(54, 215, 232, 1)"];
    const bgColor3 = ["rgba(255, 191, 150, 1)"];

    window.visitSaleChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: visitSalesData.labels,
        datasets: [{
          label: "Kunjungan Website",
          borderColor: gradientStrokeViolet,
          backgroundColor: gradientStrokeViolet,
          fillColor: bgColor1,
          hoverBackgroundColor: gradientStrokeViolet,
          pointRadius: 0,
          fill: false,
          borderWidth: 1,
          fill: 'origin',
          data: visitSalesData.visits,
          barPercentage: 0.5,
          categoryPercentage: 0.5,
        },
        {
          label: "Total Pesanan",
          borderColor: gradientStrokeRed,
          backgroundColor: gradientStrokeRed,
          hoverBackgroundColor: gradientStrokeRed,
          fillColor: bgColor2,
          pointRadius: 0,
          fill: false,
          borderWidth: 1,
          fill: 'origin',
          data: visitSalesData.sales,
          barPercentage: 0.5,
          categoryPercentage: 0.5,
        },
        {
          label: "Pendapatan (Juta Rp)",
          borderColor: gradientStrokeBlue,
          backgroundColor: gradientStrokeBlue,
          hoverBackgroundColor: gradientStrokeBlue,
          fillColor: bgColor3,
          pointRadius: 0,
          fill: false,
          borderWidth: 1,
          fill: 'origin',
          data: visitSalesData.revenue,
          barPercentage: 0.5,
          categoryPercentage: 0.5,
        }
        ]
      },
      options: {
        responsive: true,
        maintainAspectRatio: true,
        elements: {
          line: {
            tension: 0.4,
          },
        },
        scales: {
          y: {
            display: true,
            beginAtZero: true,
            grid: {
              display: true,
              drawOnChartArea: true,
              drawTicks: false,
            },
          },
          x: {
            display: true,
            grid: {
              display: false,
            },
          }
        },
        plugins: {
          legend: {
            display: false,
          }
        }
      },
      plugins: [{
        afterDatasetUpdate: function (chart, args, options) {
          const chartId = chart.canvas.id;
          var i;
          const legendId = `${chartId}-legend`;
          const legendElement = document.getElementById(legendId);
          if (legendElement) {
            legendElement.innerHTML = '';
            const ul = document.createElement('ul');
            for (i = 0; i < chart.data.datasets.length; i++) {
              ul.innerHTML += `
                <li>
                  <span style="background-color: ${chart.data.datasets[i].fillColor}"></span>
                  ${chart.data.datasets[i].label}
                </li>
              `;
            }
            legendElement.appendChild(ul);
          }
        }
      }]
    });
    }

    // Create traffic chart with top products data
    if (trafficChartCanvas && typeof topProductsData !== 'undefined' && topProductsData.labels.length > 0) {
      const ctx = trafficChartCanvas;

    var graphGradient1 = ctx.getContext('2d');
    var graphGradient2 = ctx.getContext('2d');
    var graphGradient3 = ctx.getContext('2d');
    var graphGradient4 = ctx.getContext('2d');
    var graphGradient5 = ctx.getContext('2d');

    var gradientStrokeBlue = graphGradient1.createLinearGradient(0, 0, 0, 181);
    gradientStrokeBlue.addColorStop(0, 'rgba(54, 215, 232, 1)');
    gradientStrokeBlue.addColorStop(1, 'rgba(177, 148, 250, 1)');
    var gradientLegendBlue = 'rgba(54, 215, 232, 1)';

    var gradientStrokeRed = graphGradient2.createLinearGradient(0, 0, 0, 50);
    gradientStrokeRed.addColorStop(0, 'rgba(255, 191, 150, 1)');
    gradientStrokeRed.addColorStop(1, 'rgba(254, 112, 150, 1)');
    var gradientLegendRed = 'rgba(254, 112, 150, 1)';

    var gradientStrokeGreen = graphGradient3.createLinearGradient(0, 0, 0, 300);
    gradientStrokeGreen.addColorStop(0, 'rgba(6, 185, 157, 1)');
    gradientStrokeGreen.addColorStop(1, 'rgba(132, 217, 210, 1)');
    var gradientLegendGreen = 'rgba(6, 185, 157, 1)';

    var gradientStrokeYellow = graphGradient4.createLinearGradient(0, 0, 0, 300);
    gradientStrokeYellow.addColorStop(0, 'rgba(255, 193, 7, 1)');
    gradientStrokeYellow.addColorStop(1, 'rgba(255, 235, 59, 1)');
    var gradientLegendYellow = 'rgba(255, 193, 7, 1)';

    var gradientStrokePurple = graphGradient5.createLinearGradient(0, 0, 0, 300);
    gradientStrokePurple.addColorStop(0, 'rgba(156, 39, 176, 1)');
    gradientStrokePurple.addColorStop(1, 'rgba(186, 104, 200, 1)');
    var gradientLegendPurple = 'rgba(156, 39, 176, 1)';

    var colors = [gradientStrokeBlue, gradientStrokeGreen, gradientStrokeRed, gradientStrokeYellow, gradientStrokePurple];
    var legendColors = [gradientLegendBlue, gradientLegendGreen, gradientLegendRed, gradientLegendYellow, gradientLegendPurple];

    // Create labels with product name and percentage
    var labels = topProductsData.labels.map((label, index) => {
      var percentage = topProductsData.percentages[index] || 0;
      // Truncate long product names for chart display
      var displayName = label.length > 25 ? label.substring(0, 25) + '...' : label;
      return displayName + ' ' + percentage + '%';
    });

    window.trafficChart = new Chart(ctx, {
      type: 'doughnut',
      data: {
        labels: labels,
        datasets: [{
          data: topProductsData.quantities,
          backgroundColor: colors.slice(0, topProductsData.labels.length),
          hoverBackgroundColor: colors.slice(0, topProductsData.labels.length),
          borderColor: colors.slice(0, topProductsData.labels.length),
          legendColor: legendColors.slice(0, topProductsData.labels.length)
        }]
      },
      options: {
        cutout: 50,
        animationEasing: "easeOutBounce",
        animateRotate: true,
        animateScale: false,
        responsive: true,
        maintainAspectRatio: true,
        showScale: true,
        legend: false,
        plugins: {
          legend: {
            display: false,
          },
          tooltip: {
            callbacks: {
              label: function(context) {
                var index = context.dataIndex;
                var productName = topProductsData.labels[index] || '';
                var qty = topProductsData.quantities[index] || 0;
                var revenue = topProductsData.revenues[index] || 0;
                var percentage = topProductsData.percentages[index] || 0;
                return productName + ': ' + qty + ' unit (' + percentage + '%) - Rp ' + revenue.toLocaleString('id-ID');
              }
            }
          }
        }
      },
      plugins: [{
        afterDatasetUpdate: function (chart, args, options) {
          const chartId = chart.canvas.id;
          var i;
          const legendId = `${chartId}-legend`;
          const legendElement = document.getElementById(legendId);
          if (legendElement) {
            legendElement.innerHTML = '';
            const ul = document.createElement('ul');
            for (i = 0; i < chart.data.datasets[0].data.length; i++) {
              var productName = topProductsData.labels[i] || '';
              var qty = topProductsData.quantities[i] || 0;
              var revenue = topProductsData.revenues[i] || 0;
              var percentage = topProductsData.percentages[i] || 0;
              ul.innerHTML += `
                  <li>
                    <span style="background-color: ${chart.data.datasets[0].legendColor[i]}"></span>
                    ${productName} - ${qty} unit (${percentage}%) - Rp ${revenue.toLocaleString('id-ID')}
                  </li>
                `;
            }
            legendElement.appendChild(ul);
          }
        }
      }]
    });
    } else if ($("#traffic-chart").length) {
      // Show message if no products data
      const ctx = document.getElementById('traffic-chart');
      const context = ctx.getContext('2d');
      context.clearRect(0, 0, ctx.width, ctx.height);
      context.font = '16px Arial';
      context.fillStyle = '#666';
      context.textAlign = 'center';
      context.fillText('Belum ada data penjualan produk', ctx.width / 2, ctx.height / 2);
    }
  }

  // Initialize charts when document is ready
  $(document).ready(function() {
    // Wait a bit for Chart.js to be fully loaded
    setTimeout(function() {
      initCharts();
    }, 100);
  });

  // Also try after window load to ensure everything is ready
  $(window).on('load', function() {
    setTimeout(function() {
      if (typeof Chart !== 'undefined') {
        initCharts();
      }
    }, 200);
  });
})(jQuery);
</script>
@endpush
@endsection

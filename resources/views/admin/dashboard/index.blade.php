@extends('layouts.admin')

@section('title', 'Dashboard - Panel Admin')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-sm-8">
                                <h4 class="card-title text-white mb-2">Selamat Datang, Admin! 👋</h4>
                                <p class="card-text text-white opacity-75 mb-0">
                                    Monitor dan kelola seluruh UMKM yang terdaftar dalam sistem. Pantau perkembangan dan statistik global platform.
                                </p>
                            </div>
                            <div class="col-sm-4 text-center">
                                <div class="avatar avatar-xl">
                                    <span class="avatar-initial rounded-circle bg-white text-primary fs-2">🏛️</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Statistics Cards -->
        <div class="row g-4 mb-4">
            <!-- Total UMKM -->
            <div class="col-md-6 col-xl-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                            <div class="avatar">
                                <div class="avatar-initial bg-label-primary rounded-3">
                                    <i class="ri-store-3-line ri-24px"></i>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <p class="mb-0 text-success me-1">{{ $growthStats['umkm'] >= 0 ? '+' : '' }}{{ $growthStats['umkm'] }}%</p>
                                <i class="ri-arrow-{{ $growthStats['umkm'] >= 0 ? 'up' : 'down' }}-s-line text-{{ $growthStats['umkm'] >= 0 ? 'success' : 'danger' }}"></i>
                            </div>
                        </div>
                        <div class="card-info mt-4">
                            <h4 class="mb-1">{{ $totalUmkm }}</h4>
                            <p class="mb-2">Total UMKM</p>
                            <div class="badge bg-label-primary rounded-pill">
                                @if($totalUmkm > 100)
                                    Ekosistem Besar
                                @elseif($totalUmkm > 50)
                                    Berkembang Pesat
                                @elseif($totalUmkm > 20)
                                    Tumbuh Stabil
                                @elseif($totalUmkm > 0)
                                    Tahap Awal
                                @else
                                    Belum Ada
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Products -->
            <div class="col-md-6 col-xl-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                            <div class="avatar">
                                <div class="avatar-initial bg-label-success rounded-3">
                                    <i class="ri-shopping-bag-3-line ri-24px"></i>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <p class="mb-0 text-success me-1">{{ $growthStats['products'] >= 0 ? '+' : '' }}{{ $growthStats['products'] }}%</p>
                                <i class="ri-arrow-{{ $growthStats['products'] >= 0 ? 'up' : 'down' }}-s-line text-{{ $growthStats['products'] >= 0 ? 'success' : 'danger' }}"></i>
                            </div>
                        </div>
                        <div class="card-info mt-4">
                            <h4 class="mb-1">{{ number_format($totalProducts) }}</h4>
                            <p class="mb-2">Total Produk</p>
                            <div class="badge bg-label-success rounded-pill">
                                Bulan Ini: {{ $thisMonthProducts }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Gallery -->
            <div class="col-md-6 col-xl-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                            <div class="avatar">
                                <div class="avatar-initial bg-label-info rounded-3">
                                    <i class="ri-image-2-line ri-24px"></i>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <p class="mb-0 text-success me-1">{{ $growthStats['galleries'] >= 0 ? '+' : '' }}{{ $growthStats['galleries'] }}%</p>
                                <i class="ri-arrow-{{ $growthStats['galleries'] >= 0 ? 'up' : 'down' }}-s-line text-{{ $growthStats['galleries'] >= 0 ? 'success' : 'danger' }}"></i>
                            </div>
                        </div>
                        <div class="card-info mt-4">
                            <h4 class="mb-1">{{ number_format($totalGalleries) }}</h4>
                            <p class="mb-2">Total Foto</p>
                            <div class="badge bg-label-info rounded-pill">
                                Bulan Ini: {{ $thisMonthGalleries }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Secondary Statistics -->
        <div class="row g-4 mb-4">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-1">📊 Kesehatan Platform</h5>
                        <p class="card-subtitle mb-0 text-muted">Indikator performa dan engagement platform</p>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6 col-lg-4">
                                <div class="alert alert-{{ $avgProductsPerUmkm >= 5 ? 'success' : ($avgProductsPerUmkm >= 3 ? 'warning' : 'danger') }} d-flex align-items-start">
                                    <i class="ri-shopping-bag-line ri-22px me-2 mt-1"></i>
                                    <div>
                                        <h6 class="mb-1">Rata-rata Produk per UMKM</h6>
                                        <small>{{ number_format($avgProductsPerUmkm, 1) }} produk</small>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-4">
                                <div class="alert alert-{{ $avgGalleriesPerUmkm >= 10 ? 'success' : ($avgGalleriesPerUmkm >= 5 ? 'warning' : 'info') }} d-flex align-items-start">
                                    <i class="ri-image-line ri-22px me-2 mt-1"></i>
                                    <div>
                                        <h6 class="mb-1">Rata-rata Foto per UMKM</h6>
                                        <small>{{ number_format($avgGalleriesPerUmkm, 1) }} foto</small>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-4">
                                <div class="alert alert-{{ $umkmWithCompleteProfile >= 70 ? 'success' : ($umkmWithCompleteProfile >= 50 ? 'warning' : 'danger') }} d-flex align-items-start">
                                    <i class="ri-user-settings-line ri-22px me-2 mt-1"></i>
                                    <div>
                                        <h6 class="mb-1">UMKM Profil Lengkap</h6>
                                        <small>{{ $umkmWithCompleteProfile }}% dari total</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Top Performing UMKM -->
            <div class="col-md-4">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="mb-1">UMKM Teratas</h5>
                        <p class="card-subtitle mb-0 text-muted">Berdasarkan jumlah produk</p>
                    </div>
                    <div class="card-body">
                        @if($topUmkm->count() > 0)
                            @foreach($topUmkm->take(5) as $index => $umkm)
                                <div class="d-flex align-items-center mb-3">
                                    <div class="badge bg-label-primary rounded-pill me-3" style="width: 30px; height: 30px; display: flex; align-items: center; justify-content: center;">
                                        {{ $index + 1 }}
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-0">{{ Str::limit($umkm->name, 20) }}</h6>
                                        <small class="text-muted">{{ $umkm->products_count }} produk</small>
                                    </div>
                                    @if($umkm->logo_path)
                                        <img src="{{ asset('storage/' . $umkm->logo_path) }}" alt="Logo" class="rounded-circle" style="width: 32px; height: 32px; object-fit: cover;">
                                    @else
                                        <div class="avatar avatar-sm">
                                            <span class="avatar-initial rounded-circle bg-label-secondary">🏪</span>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        @else
                            <div class="text-center text-muted py-4">
                                <i class="ri-store-line ri-24px mb-2"></i>
                                <p class="mb-0">Belum ada UMKM</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <!-- Chart.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Data from Laravel
            const data = {
                umkm: {{ $totalUmkm }},
                products: {{ $totalProducts }},
                galleries: {{ $totalGalleries }},
                users: {{ $totalUsers }},
                monthlyStats: @json($monthlyStats),
                topUmkm: @json($topUmkm)
            };

            // Monthly Trends Chart
            const trendsCtx = document.getElementById('monthlyTrendsChart');
            if (trendsCtx) {
                new Chart(trendsCtx, {
                    type: 'line',
                    data: {
                        labels: data.monthlyStats.months,
                        datasets: [{
                            label: 'UMKM Baru',
                            data: data.monthlyStats.umkm,
                            borderColor: 'rgb(105, 108, 255)',
                            backgroundColor: 'rgba(105, 108, 255, 0.1)',
                            tension: 0.4
                        }, {
                            label: 'Produk Ditambahkan',
                            data: data.monthlyStats.products,
                            borderColor: 'rgb(113, 221, 55)',
                            backgroundColor: 'rgba(113, 221, 55, 0.1)',
                            tension: 0.4
                        }, {
                            label: 'Foto Diupload',
                            data: data.monthlyStats.galleries,
                            borderColor: 'rgb(3, 195, 236)',
                            backgroundColor: 'rgba(3, 195, 236, 0.1)',
                            tension: 0.4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'top',
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            }

            // Content Distribution Doughnut Chart
            const distributionCtx = document.getElementById('contentDistributionChart');
            if (distributionCtx) {
                new Chart(distributionCtx, {
                    type: 'doughnut',
                    data: {
                        labels: ['UMKM', 'Produk', 'Foto Galeri'],
                        datasets: [{
                            data: [data.umkm * 10, data.products, data.galleries], // Scale UMKM for better visualization
                            backgroundColor: [
                                'rgba(105, 108, 255, 0.8)',
                                'rgba(113, 221, 55, 0.8)',
                                'rgba(3, 195, 236, 0.8)'
                            ],
                            borderWidth: 2,
                            borderColor: '#fff'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                            }
                        },
                        cutout: '60%'
                    }
                });
            }
        });
    </script>
@endpush

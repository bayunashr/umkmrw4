@extends('layouts.umkm')

@section('title', 'Dashboard - Panel UMKM')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-sm-8">
                                <h4 class="card-title text-white mb-2">Selamat Datang, {{ $profile->name ?? 'UMKM' }}! 👋</h4>
                                <p class="card-text text-white opacity-75 mb-0">
                                    Kelola bisnis Anda dengan mudah melalui dashboard ini. Monitor perkembangan dan tingkatkan performa bisnis Anda.
                                </p>
                            </div>
                            <div class="col-sm-4 text-center">
                                @if($profile->logo_path ?? false)
                                    <img src="{{ asset('storage/' . $profile->logo_path) }}" alt="Logo" class="rounded-circle" style="width: 80px; height: 80px; object-fit: cover; border: 3px solid rgba(255,255,255,0.3);">
                                @else
                                    <div class="avatar avatar-xl">
                                        <span class="avatar-initial rounded-circle bg-white text-primary fs-2">🏪</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Statistics Cards -->
        <div class="row g-4 mb-4">
            <!-- Total Products -->
            <div class="col-md-6 col-xl-3">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                            <div class="avatar">
                                <div class="avatar-initial bg-label-primary rounded-3">
                                    <i class="ri-shopping-bag-3-line ri-24px"></i>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                @php
                                    $productGrowth = $productsCount > 0 ? '+' . min(100, ($productsCount * 10)) . '%' : '0%';
                                @endphp
                                <p class="mb-0 text-success me-1">{{ $productGrowth }}</p>
                                <i class="ri-arrow-up-s-line text-success"></i>
                            </div>
                        </div>
                        <div class="card-info mt-4">
                            <h4 class="mb-1">{{ $productsCount ?? 0 }}</h4>
                            <p class="mb-2">Total Produk</p>
                            <div class="badge bg-label-primary rounded-pill">
                                @if($productsCount > 10)
                                    Katalog Lengkap
                                @elseif($productsCount > 5)
                                    Berkembang
                                @elseif($productsCount > 0)
                                    Mulai Baik
                                @else
                                    Belum Ada
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Gallery Images -->
            <div class="col-md-6 col-xl-3">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                            <div class="avatar">
                                <div class="avatar-initial bg-label-success rounded-3">
                                    <i class="ri-image-2-line ri-24px"></i>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                @php
                                    $galleryGrowth = $galleriesCount > 0 ? '+' . min(100, ($galleriesCount * 5)) . '%' : '0%';
                                @endphp
                                <p class="mb-0 text-success me-1">{{ $galleryGrowth }}</p>
                                <i class="ri-arrow-up-s-line text-success"></i>
                            </div>
                        </div>
                        <div class="card-info mt-4">
                            <h4 class="mb-1">{{ $galleriesCount ?? 0 }}</h4>
                            <p class="mb-2">Foto Galeri</p>
                            <div class="badge bg-label-success rounded-pill">
                                @if($galleriesCount > 20)
                                    Portofolio Kaya
                                @elseif($galleriesCount > 10)
                                    Dokumentasi Baik
                                @elseif($galleriesCount > 0)
                                    Mulai Terdokumentasi
                                @else
                                    Belum Ada
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Social Media -->
            <div class="col-md-6 col-xl-3">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                            <div class="avatar">
                                <div class="avatar-initial bg-label-info rounded-3">
                                    <i class="ri-links-line ri-24px"></i>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                @php
                                    $socialGrowth = $socialMediaCount > 0 ? '+' . ($socialMediaCount * 25) . '%' : '0%';
                                @endphp
                                <p class="mb-0 text-success me-1">{{ $socialGrowth }}</p>
                                <i class="ri-arrow-up-s-line text-success"></i>
                            </div>
                        </div>
                        <div class="card-info mt-4">
                            <h4 class="mb-1">{{ $socialMediaCount ?? 0 }}</h4>
                            <p class="mb-2">Media Sosial</p>
                            <div class="badge bg-label-info rounded-pill">
                                @if($socialMediaCount >= 4)
                                    Jangkauan Luas
                                @elseif($socialMediaCount >= 2)
                                    Terhubung Baik
                                @elseif($socialMediaCount > 0)
                                    Mulai Terhubung
                                @else
                                    Belum Terhubung
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Profile Completeness -->
            <div class="col-md-6 col-xl-3">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                            <div class="avatar">
                                <div class="avatar-initial bg-label-warning rounded-3">
                                    <i class="ri-user-star-line ri-24px"></i>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <p class="mb-0 text-success me-1">{{ $profileCompleteness }}%</p>
                                <i class="ri-arrow-up-s-line text-success"></i>
                            </div>
                        </div>
                        <div class="card-info mt-4">
                            <h4 class="mb-1">{{ $profileCompleteness }}%</h4>
                            <p class="mb-2">Kelengkapan Profil</p>
                            <div class="badge bg-label-warning rounded-pill">
                                @if($profileCompleteness >= 90)
                                    Sangat Lengkap
                                @elseif($profileCompleteness >= 70)
                                    Cukup Lengkap
                                @elseif($profileCompleteness >= 50)
                                    Perlu Dilengkapi
                                @else
                                    Belum Lengkap
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Secondary Statistics -->
        <div class="row g-4 mb-4">

            <!-- Quick Actions -->
            <div class="col-md-12">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="mb-1">Aksi Cepat</h5>
                        <p class="card-subtitle mb-0 text-muted">Kelola bisnis Anda</p>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-3">
                            <a href="{{ route('umkm.product.create') }}" class="btn btn-primary d-flex align-items-center">
                                <i class="ri-add-line me-2"></i>
                                Tambah Produk
                            </a>
                            <a href="{{ route('umkm.gallery.create') }}" class="btn btn-success d-flex align-items-center">
                                <i class="ri-camera-line me-2"></i>
                                Upload Foto
                            </a>
                        </div>
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
                products: {{ $productsCount ?? 0 }},
                galleries: {{ $galleriesCount ?? 0 }},
                socialMedia: {{ $socialMediaCount ?? 0 }},
                completeness: {{ $profileCompleteness ?? 0 }}
            };

            // Business Analytics Chart
            const analyticsCtx = document.getElementById('businessAnalyticsChart');
            if (analyticsCtx) {
                new Chart(analyticsCtx, {
                    type: 'line',
                    data: {
                        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                        datasets: [{
                            label: 'Produk',
                            data: [data.products * 0.6, data.products * 0.7, data.products * 0.8, data.products * 0.9, data.products * 0.95, data.products],
                            borderColor: 'rgb(105, 108, 255)',
                            backgroundColor: 'rgba(105, 108, 255, 0.1)',
                            tension: 0.4
                        }, {
                            label: 'Galeri',
                            data: [data.galleries * 0.4, data.galleries * 0.6, data.galleries * 0.7, data.galleries * 0.85, data.galleries * 0.9, data.galleries],
                            borderColor: 'rgb(113, 221, 55)',
                            backgroundColor: 'rgba(113, 221, 55, 0.1)',
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

            // Content Overview Doughnut Chart
            const contentCtx = document.getElementById('contentOverviewChart');
            if (contentCtx) {
                new Chart(contentCtx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Produk', 'Galeri', 'Media Sosial'],
                        datasets: [{
                            data: [data.products, data.galleries, data.socialMedia * 5], // Scale social media for better visualization
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

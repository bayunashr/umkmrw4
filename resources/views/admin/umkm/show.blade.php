@extends('layouts.admin')

@section('title', $umkm->name . ' - Banjarsugihan UMKM Digital Map')

@section('content')
    <div class="row">
        <!-- User Sidebar -->
        <div class="col-xl-4 col-lg-5 col-md-5 order-1 order-md-0">
            <!-- User Card -->
            <div class="card mb-6">
                <div class="card-body pt-12">
                    <div class="user-avatar-section">
                        <div class="d-flex align-items-center flex-column">
                            @if ($umkm->logo_path && file_exists(public_path('storage/' . $umkm->logo_path)))
                                <img
                                    class="img-fluid rounded mb-4"
                                    src="{{ asset('storage/' . $umkm->logo_path) }}"
                                    height="120"
                                    width="120"
                                    alt="User avatar" />
                            @else
                                @php
                                    $initials = collect(explode(' ', $umkm->name))
                                        ->filter()
                                        ->map(fn($word) => strtoupper(substr($word, 0, 1)))
                                        ->join('');

                                    $colors = ['primary', 'secondary', 'success', 'danger', 'warning', 'info'];
                                    $color = $colors[crc32($umkm->name) % count($colors)];
                                @endphp
                                <div class="d-flex align-items-center justify-content-center mb-4 bg-label-{{ $color }}"
                                     style="width: 120px; height: 120px; font-size: 36px; border-radius: 0.5rem; font-weight: bold;">
                                    {{ $initials }}
                                </div>
                            @endif

                            <div class="user-info text-center">
                                <h5 class="mb-1">{{ $umkm->name }}</h5>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-around flex-wrap my-6 gap-0 gap-md-3 gap-lg-4">
                        <div class="d-flex align-items-center me-5 gap-4">
                            <div class="avatar">
                                <div class="avatar-initial bg-label-primary rounded-3">
                                    <i class="ri-cake-3-line ri-24px"></i>
                                </div>
                            </div>
                            <div>
                                <h5 class="mb-0">{{ $productCount }}</h5>
                                <span>Produk</span>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-4">
                            <div class="avatar">
                                <div class="avatar-initial bg-label-primary rounded-3">
                                    <i class="ri-gallery-line ri-24px"></i>
                                </div>
                            </div>
                            <div>
                                <h5 class="mb-0">{{ $galleryCount }}</h5>
                                <span>Gambar</span>
                            </div>
                        </div>
                    </div>
                    <h5 class="pb-4 border-bottom mb-4">Detail UMKM</h5>
                    <div class="info-container">
                        <ul class="list-unstyled mb-6">
                            <li class="mb-2">
                                <span class="fw-medium text-heading me-2">Username:</span>
                                <span>{{ $umkm->user->username }}</span>
                            </li>
                            <li class="mb-2">
                                <span class="fw-medium text-heading me-2">Pemilik:</span>
                                <span>{{ $umkm->user->name }}</span>
                            </li>
                            <li class="mb-2">
                                <span class="fw-medium text-heading me-2">Telepon:</span>
                                <span>{{ $umkm->phone }}</span>
                            </li>
                            <li class="mb-2">
                                <span class="fw-medium text-heading me-2">Deskripsi:</span>
                                <span>{{ $umkm->description }}</span>
                            </li>
                            <li class="mb-2">
                                <span class="fw-medium text-heading me-2">Alamat:</span>
                                <span>{{ $umkm->address }}</span>
                            </li>
                            <li class="mb-2">
                                <span class="fw-medium text-heading me-2">RT/RW:</span>
                                <span>{{ $umkm->rt }}/{{ $umkm->rw }}</span>
                            </li>
                        </ul>
                        <div class="d-flex justify-content-center">
                            <a href="{{ route('admin.umkm.edit', $umkm->slug) }}" class="btn btn-primary suspend-user me-3">Edit Informasi Umum</a>
                            <a href="javascript:;" class="btn btn-outline-danger suspend-user">Hapus UMKM</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /User Card -->
        </div>
        <!--/ User Sidebar -->

        <!-- User Content -->
        <div class="col-xl-8 col-lg-7 col-md-7 order-0 order-md-1">

            <div class="card mb-6">
                <h5 class="card-header">Lokasi UMKM</h5>
                <div class="card-body">
                    <div id="map" style="height: 400px; border-radius: 0.5rem;"></div>
                </div>
            </div>
            <div class="card card-action mb-6">
                <div class="card-header align-items-center">
                    <h5 class="card-action-title mb-0">Sosial Media</h5>
                </div>
                <div class="card-body">
                    <div class="added-cards">
                        @if ($umkm->socialMedia->count() == 0)
                            <span>Belum Ada Sosial Media</span>
                        @endif
                        @foreach ($umkm->socialMedia as $social)
                            <div class="cardMaster border p-4 rounded-4 mb-4">
                                <div class="d-flex justify-content-between flex-sm-row flex-column">
                                    <div class="card-information">
                                        <div class="d-flex align-items-center mb-2">
                                            <h6 class="mb-0 me-2 text-capitalize">{{ $social->platform }}</h6>
                                        </div>
                                        <a href="{{ $social->url }}" target="_blank" class="text-muted text-wrap">
                                            {{ $social->url }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <!--/ User Content -->
    </div>
@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('') }}assets/vendor/libs/leaflet/leaflet.css" />
@endpush

@push('js')
    <script src="{{ asset('') }}assets/vendor/libs/leaflet/leaflet.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Ganti lat dan lng sesuai kebutuhan
            const lat = {{ $umkm->latitude }};   // Contoh latitude
            const lng = {{ $umkm->longitude }};  // Contoh longitude

            const map = L.map('map').setView([lat, lng], 18);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors',
                maxZoom: 19,
            }).addTo(map);

            const marker = L.marker([lat, lng], { draggable: false })
                .addTo(map)
                .bindPopup('Lokasi UMKM')
                .openPopup();
        });
    </script>
@endpush

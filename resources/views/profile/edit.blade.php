@extends('layouts.umkm')

@section('title', 'Edit Profil UMKM - Banjarsugihan UMKM Digital Map')

@section('content')
    @if ($errors->has('error'))
        <div class="alert alert-danger d-flex align-items-center" role="alert">
            <i class="ri-error-warning-line me-2"></i>
            <div>{{ $errors->first('error') }}</div>
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success d-flex align-items-center" role="alert">
            <i class="ri-check-line me-2"></i>
            <div>{{ session('success') }}</div>
        </div>
    @endif

    <div class="card mb-6">
        <div class="card-header d-flex flex-wrap align-items-center justify-content-between mb-lg-4">
            <div class="flex-grow-0 me-md-3">
                <a href="{{ route('umkm.profile') }}" class="btn btn-outline-secondary btn-sm">
                    <span class="ri-arrow-go-back-fill me-1"></span> Kembali
                </a>
            </div>
            <div class="flex-grow-1 text-center text-md-start mt-2 mt-md-0">
                <h5 class="mb-0">Edit Profil UMKM</h5>
                <small class="text-muted">Perbarui informasi profil UMKM Anda</small>
            </div>
        </div>
        <form class="card-body" method="POST" action="{{ route('umkm.profile.update', $umkm->slug) }}">
            @csrf
            @method('PUT')
            <div class="row g-6">
                <div class="col-md-6">
                    <div class="input-group input-group-merge">
                        <span class="input-group-text"><i class="ri-user-line"></i></span>
                        <div class="form-floating form-floating-outline">
                            <input name="owner" type="text" class="form-control @error('owner') is-invalid @enderror" value="{{ old('owner', $umkm->user->name) }}" />
                            <label>Nama Lengkap Pemilik</label>
                        </div>
                    </div>
                    @error('owner')
                    <div class="invalid-feedback d-block">
                        <i class="ri-error-warning-line me-1"></i>{{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <div class="input-group input-group-merge">
                        <span class="input-group-text"><i class="ri-building-4-line"></i></span>
                        <div class="form-floating form-floating-outline">
                            <input name="name" type="text" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $umkm->name) }}" />
                            <label>Nama UMKM</label>
                        </div>
                    </div>
                    @error('name')
                    <div class="invalid-feedback d-block">
                        <i class="ri-error-warning-line me-1"></i>{{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <div class="input-group input-group-merge">
                        <span class="input-group-text"><i class="ri-id-card-line"></i></span>
                        <div class="form-floating form-floating-outline">
                            <input name="username" type="text" class="form-control @error('username') is-invalid @enderror" value="{{ old('username', $umkm->user->username ?? '') }}" />
                            <label>Username</label>
                        </div>
                    </div>
                    @error('username')
                    <div class="invalid-feedback d-block">
                        <i class="ri-error-warning-line me-1"></i>{{ $message }}
                    </div>
                    @enderror
                    <small class="text-muted">Username hanya boleh mengandung huruf, angka, dash (-) dan underscore (_)</small>
                </div>

                <div class="col-md-6">
                    <div class="input-group input-group-merge">
                        <span class="input-group-text"><i class="ri-phone-line"></i></span>
                        <div class="form-floating form-floating-outline">
                            <input name="phone" type="text" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $umkm->phone) }}" placeholder="08xxxxxxxxxx" />
                            <label>Nomor Telepon</label>
                        </div>
                    </div>
                    @error('phone')
                    <div class="invalid-feedback d-block">
                        <i class="ri-error-warning-line me-1"></i>{{ $message }}
                    </div>
                    @enderror
                    <small class="text-muted">Contoh: 081234567890 (hanya angka, maksimal 20 karakter)</small>
                </div>

                <div class="col-md-6">
                    <div class="input-group input-group-merge">
                        <span class="input-group-text"><i class="ri-book-open-line"></i></span>
                        <div class="form-floating form-floating-outline">
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" style="min-height:75px" placeholder="Deskripsikan UMKM Anda...">{{ old('description', $umkm->description) }}</textarea>
                            <label>Deskripsi UMKM</label>
                        </div>
                    </div>
                    @error('description')
                    <div class="invalid-feedback d-block">
                        <i class="ri-error-warning-line me-1"></i>{{ $message }}
                    </div>
                    @enderror
                    <small class="text-muted">Maksimal 1000 karakter</small>
                </div>

                <div class="col-md-6">
                    <div class="input-group input-group-merge">
                        <span class="input-group-text"><i class="ri-pin-distance-line"></i></span>
                        <div class="form-floating form-floating-outline">
                            <textarea name="address" class="form-control @error('address') is-invalid @enderror" style="min-height:75px" placeholder="Alamat lengkap UMKM...">{{ old('address', $umkm->address) }}</textarea>
                            <label>Alamat UMKM</label>
                        </div>
                    </div>
                    @error('address')
                    <div class="invalid-feedback d-block">
                        <i class="ri-error-warning-line me-1"></i>{{ $message }}
                    </div>
                    @enderror
                    <small class="text-muted">Maksimal 500 karakter</small>
                </div>

                <div class="col-md-3 col-6">
                    <div class="input-group input-group-merge">
                        <span class="input-group-text"><i class="ri-map-pin-2-line"></i></span>
                        <div class="form-floating form-floating-outline">
                            <input name="rt" type="number" class="form-control @error('rt') is-invalid @enderror" value="{{ old('rt', $umkm->rt) }}" min="1" max="999" />
                            <label>RT</label>
                        </div>
                    </div>
                    @error('rt')
                    <div class="invalid-feedback d-block">
                        <i class="ri-error-warning-line me-1"></i>{{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="col-md-3 col-6">
                    <div class="input-group input-group-merge">
                        <span class="input-group-text"><i class="ri-map-pin-line"></i></span>
                        <div class="form-floating form-floating-outline">
                            <input name="rw" type="number" class="form-control @error('rw') is-invalid @enderror" value="{{ old('rw', $umkm->rw) }}" min="1" max="999" />
                            <label>RW</label>
                        </div>
                    </div>
                    @error('rw')
                    <div class="invalid-feedback d-block">
                        <i class="ri-error-warning-line me-1"></i>{{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="col-md-3 col-6">
                    <div class="input-group input-group-merge">
                        <span class="input-group-text"><i class="ri-map-pin-line"></i></span>
                        <div class="form-floating form-floating-outline">
                            <input step="any" name="latitude" type="number" class="form-control @error('latitude') is-invalid @enderror" value="{{ old('latitude', $umkm->latitude) }}" />
                            <label>Latitude</label>
                        </div>
                    </div>
                    @error('latitude')
                    <div class="invalid-feedback d-block">
                        <i class="ri-error-warning-line me-1"></i>{{ $message }}
                    </div>
                    @enderror
                    <small class="text-muted">Klik peta untuk set koordinat</small>
                </div>

                <div class="col-md-3 col-6">
                    <div class="input-group input-group-merge">
                        <span class="input-group-text"><i class="ri-map-pin-line"></i></span>
                        <div class="form-floating form-floating-outline">
                            <input step="any" name="longitude" type="number" class="form-control @error('longitude') is-invalid @enderror" value="{{ old('longitude', $umkm->longitude) }}" />
                            <label>Longitude</label>
                        </div>
                    </div>
                    @error('longitude')
                    <div class="invalid-feedback d-block">
                        <i class="ri-error-warning-line me-1"></i>{{ $message }}
                    </div>
                    @enderror
                    <small class="text-muted">Klik peta untuk set koordinat</small>
                </div>

                <!-- Social Media Section -->
                <div class="col-12">
                    <div class="card shadow-none border">
                        <div class="card-header">
                            <h6 class="mb-0">
                                <i class="ri-share-line me-2"></i>
                                Sosial Media
                            </h6>
                            <small class="text-muted">Tambahkan atau hapus link sosial media UMKM anda</small>
                        </div>
                        <div class="card-body">
                            <!-- Social Media Global Error -->
                            @if($errors->has('social_media*'))
                                <div class="alert alert-danger alert-dismissible d-flex align-items-center mb-3" role="alert">
                                    <i class="ri-error-warning-line me-2"></i>
                                    <div>
                                        <strong>Error pada Sosial Media:</strong>
                                        <ul class="mb-0 mt-1">
                                            @foreach($errors->all() as $error)
                                                @if(str_contains($error, 'social_media') || str_contains($error, 'platform') || str_contains($error, 'url'))
                                                    <li>{{ $error }}</li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </div>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            @php
                                $oldSocials = old('social_media', $umkm->socialMedia->map(fn($item) => ['platform' => $item->platform, 'url' => $item->url])->toArray());
                            @endphp

                            <div class="form-repeater">
                                <div data-repeater-list="social_media">
                                    @if(count($oldSocials) > 0)
                                        @foreach ($oldSocials as $index => $social)
                                            <div data-repeater-item class="row gx-3 gy-2 align-items-end mb-3 p-3 border rounded">
                                                <div class="col-md-5">
                                                    <label class="form-label">Platform</label>
                                                    <select name="platform" class="form-select @error('social_media.'.$index.'.platform') is-invalid @enderror" required>
                                                        <option value="" disabled>Pilih Platform</option>
                                                        @foreach (['facebook','instagram','twitter','tiktok','whatsapp','youtube','linkedin'] as $platform)
                                                            <option value="{{ $platform }}" {{ $social['platform'] === $platform ? 'selected' : '' }}>
                                                                {{ ucfirst($platform) }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('social_media.'.$index.'.platform')
                                                    <div class="invalid-feedback d-block">
                                                        <i class="ri-error-warning-line me-1"></i>{{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-5">
                                                    <label class="form-label">URL</label>
                                                    <input type="url" name="url" class="form-control @error('social_media.'.$index.'.url') is-invalid @enderror" value="{{ $social['url'] }}" placeholder="https://...">
                                                    @error('social_media.'.$index.'.url')
                                                    <div class="invalid-feedback d-block">
                                                        <i class="ri-error-warning-line me-1"></i>{{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-2">
                                                    <button type="button" class="btn btn-outline-danger w-100" data-repeater-delete>
                                                        <i class="ri-close-line me-1"></i> Hapus
                                                    </button>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div data-repeater-item class="row gx-3 gy-2 align-items-end mb-3 p-3 border rounded">
                                            <div class="col-md-5">
                                                <label class="form-label">Platform</label>
                                                <select name="platform" class="form-select" required>
                                                    <option value="" disabled selected>Pilih Platform</option>
                                                    @foreach (['facebook','instagram','twitter','tiktok','whatsapp','youtube','linkedin'] as $platform)
                                                        <option value="{{ $platform }}">{{ ucfirst($platform) }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-5">
                                                <label class="form-label">URL</label>
                                                <input type="url" name="url" class="form-control" placeholder="https://...">
                                            </div>
                                            <div class="col-md-2">
                                                <button type="button" class="btn btn-outline-danger w-100" data-repeater-delete>
                                                    <i class="ri-close-line me-1"></i> Hapus
                                                </button>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <button type="button" class="btn btn-outline-primary w-100" data-repeater-create>
                                            <i class="ri-add-line me-1"></i> Tambah Sosial Media
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Social Media Helper Text -->
                            <div class="mt-3">
                                <small class="text-muted">
                                    <i class="ri-information-line me-1"></i>
                                    <strong>Tips:</strong> Platform dan URL harus diisi bersamaan. URL harus dalam format yang valid (dimulai dengan http:// atau https://).
                                </small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Map Section -->
                <div class="col-12">
                    <div class="card shadow-none border">
                        <div class="card-header">
                            <h6 class="mb-0">
                                <i class="ri-map-pin-line me-2"></i>
                                Lokasi UMKM
                            </h6>
                            <small class="text-muted">Klik pada peta atau drag marker untuk mengubah lokasi UMKM</small>
                        </div>
                        <div class="card-body">
                            <!-- Map Error Display -->
                            @if($errors->has('latitude') || $errors->has('longitude'))
                                <div class="alert alert-warning d-flex align-items-center mb-3" role="alert">
                                    <i class="ri-map-pin-line me-2"></i>
                                    <div>
                                        <strong>Perhatian:</strong> Koordinat lokasi diperlukan. Silakan klik pada peta untuk menentukan lokasi UMKM Anda.
                                    </div>
                                </div>
                            @endif

                            <div id="map" style="height: 350px; border: 1px solid #ced4da; border-radius: .375rem;"></div>

                            <div class="mt-3">
                                <small class="text-muted">
                                    <i class="ri-information-line me-1"></i>
                                    <strong>Cara menggunakan:</strong> Klik pada peta atau drag marker biru untuk menentukan lokasi UMKM Anda. Koordinat akan terisi otomatis.
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="pt-6">
                <div class="row">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <a href="{{ route('umkm.profile') }}" class="btn btn-outline-secondary w-100">
                            <i class="ri-arrow-go-back-line me-1"></i> Batal
                        </a>
                    </div>
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="ri-save-line me-1"></i> Simpan Perubahan
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/leaflet/leaflet.css') }}" />
    <style>
        .form-repeater [data-repeater-item] {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 0.375rem;
            padding: 1rem;
            margin-bottom: 1rem;
        }
        .form-repeater [data-repeater-item]:last-child {
            margin-bottom: 0;
        }
        .leaflet-popup-content-wrapper {
            border-radius: 0.375rem;
        }

        /* Enhanced error styling */
        .is-invalid {
            border-color: #dc3545;
        }

        .invalid-feedback {
            color: #dc3545;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        .invalid-feedback i {
            font-size: 0.875rem;
        }

        /* Alert enhancement */
        .alert ul {
            padding-left: 1rem;
        }

        .alert ul li {
            margin-bottom: 0.25rem;
        }
    </style>
@endpush

@push('js')
    <script src="{{ asset('assets/vendor/libs/leaflet/leaflet.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/jquery-repeater/jquery-repeater.js') }}"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Initialize map
            let defaultLat = parseFloat(document.querySelector('[name=latitude]').value) || -7.2756;
            let defaultLon = parseFloat(document.querySelector('[name=longitude]').value) || 112.6426;
            let map = L.map('map').setView([defaultLat, defaultLon], 18);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            let marker = L.marker([defaultLat, defaultLon], { draggable: true }).addTo(map)
                .bindPopup("<b>Lokasi UMKM Anda</b><br>Drag marker untuk mengubah lokasi").openPopup();

            // Update coordinates when map is clicked
            map.on('click', function (e) {
                let lat = e.latlng.lat.toFixed(6);
                let lon = e.latlng.lng.toFixed(6);
                marker.setLatLng(e.latlng).update();

                // Update input fields
                const latInput = document.querySelector('[name=latitude]');
                const lonInput = document.querySelector('[name=longitude]');
                latInput.value = lat;
                lonInput.value = lon;

                // Remove error styling if coordinates are set
                latInput.classList.remove('is-invalid');
                lonInput.classList.remove('is-invalid');

                marker.bindPopup("<b>Lokasi UMKM Anda</b><br>Lat: " + lat + "<br>Lng: " + lon).openPopup();
            });

            // Update coordinates when marker is dragged
            marker.on('dragend', function (e) {
                let latlng = e.target.getLatLng();
                let lat = latlng.lat.toFixed(6);
                let lon = latlng.lng.toFixed(6);

                // Update input fields
                const latInput = document.querySelector('[name=latitude]');
                const lonInput = document.querySelector('[name=longitude]');
                latInput.value = lat;
                lonInput.value = lon;

                // Remove error styling if coordinates are set
                latInput.classList.remove('is-invalid');
                lonInput.classList.remove('is-invalid');

                marker.bindPopup("<b>Lokasi UMKM Anda</b><br>Lat: " + lat + "<br>Lng: " + lon).openPopup();
            });
        });

        // Initialize repeater
        $(document).ready(function () {
            $('.form-repeater').repeater({
                initEmpty: false,
                show: function () {
                    $(this).slideDown();
                },
                hide: function (deleteElement) {
                    if (confirm('Yakin ingin menghapus sosial media ini?')) {
                        $(this).slideUp(deleteElement);
                    }
                }
            });

            // Real-time validation for social media inputs
            $(document).on('change', '.form-repeater select[name="platform"]', function() {
                $(this).removeClass('is-invalid');
                $(this).siblings('.invalid-feedback').hide();
            });

            $(document).on('input', '.form-repeater input[name="url"]', function() {
                $(this).removeClass('is-invalid');
                $(this).siblings('.invalid-feedback').hide();
            });

            // Real-time validation for coordinate inputs
            $('[name="latitude"], [name="longitude"]').on('input', function() {
                $(this).removeClass('is-invalid');
                $(this).siblings('.invalid-feedback').hide();
            });
        });
    </script>
@endpush

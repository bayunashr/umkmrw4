@extends('layouts.admin')

@section('title', 'Daftar UMKM Baru - Banjarsugihan UMKM Digital Map')

@section('content')
    <div class="card mb-6">
        <div class="card-header d-flex flex-wrap align-items-center justify-content-between">
            <div class="flex-grow-0 me-md-3">
                <a href="{{ route('admin.umkm.index') }}" class="btn btn-danger btn-sm">
                    <span class="ri-arrow-go-back-fill"></span>
                </a>
            </div>
            <div class="flex-grow-1 text-center text-md-start mt-2 mt-md-0">
                <h5 class="mb-0">Tambah UMKM</h5>
            </div>
        </div>
        <form class="card-body" method="POST" action="{{ route('admin.umkm.store') }}">
            @csrf
            <div class="row g-6">
                <div class="col-md-6">
                    <div class="input-group input-group-merge">
                          <span id="form-daftar-pemilik-ikon" class="input-group-text"
                          ><i class="ri-user-line"></i
                              ></span>
                        <div class="form-floating form-floating-outline">
                            <input
                                value="{{ old('owner') }}"
                                name="owner"
                                type="text"
                                class="form-control"
                                id="form-daftar-pemilik"
                                placeholder="Muhammad Ari Widodo"
                                aria-label="Muhammad Ari Widodo"
                                aria-describedby="form-daftar-pemilik-ikon" />
                            <label for="form-daftar-pemilik">Nama Lengkap Pemilik</label>
                        </div>
                    </div>
                    @error('owner')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <div class="input-group input-group-merge">
                          <span id="form-daftar-nama-ikon" class="input-group-text"
                          ><i class="ri-building-4-line"></i
                              ></span>
                        <div class="form-floating form-floating-outline">
                            <input
                                value="{{ old('name') }}"
                                name="name"
                                type="text"
                                class="form-control"
                                id="form-daftar-nama"
                                placeholder="Bengkel Motor Barokah"
                                aria-label="Bengkel Motor Barokah"
                                aria-describedby="form-daftar-nama-ikon" />
                            <label for="form-daftar-nama">Nama UMKM</label>
                        </div>
                    </div>
                    @error('name')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <div class="input-group input-group-merge">
                          <span id="form-daftar-username-ikon" class="input-group-text"
                          ><i class="ri-id-card-line"></i
                              ></span>
                        <div class="form-floating form-floating-outline">
                            <input
                                value="{{ old('username') }}"
                                name="username"
                                type="text"
                                class="form-control"
                                id="form-daftar-username"
                                placeholder="bengkelbarokah"
                                aria-label="bengkelbarokah"
                                aria-describedby="form-daftar-username-ikon" />
                            <label for="form-daftar-username">Username</label>
                        </div>
                    </div>
                    @error('username')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <div class="input-group input-group-merge">
                          <span id="form-daftar-telepon-ikon" class="input-group-text"
                          ><i class="ri-phone-line"></i
                              ></span>
                        <div class="form-floating form-floating-outline">
                            <input
                                value="{{ old('phone') }}"
                                name="phone"
                                type="number"
                                class="form-control"
                                id="form-daftar-telepon"
                                placeholder="082134400911"
                                aria-label="082134400911"
                                aria-describedby="form-daftar-telepon-ikon" />
                            <label for="form-daftar-telepon">Nomor Telepon</label>
                        </div>
                    </div>
                    @error('phone')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <div class="input-group input-group-merge">
                          <span id="form-daftar-deskripsi-ikon" class="input-group-text"
                          ><i class="ri-book-open-line"></i
                              ></span>
                        <div class="form-floating form-floating-outline">
                            <textarea
                                name="description"
                                type="text"
                                class="form-control"
                                id="form-daftar-deskripsi"
                                placeholder="Melayani servis motor harian, ganti oli, dan perawatan ringan lainnya. Buka setiap hari pukul 08.00–17.00."
                                aria-label="Melayani servis motor harian, ganti oli, dan perawatan ringan lainnya. Buka setiap hari pukul 08.00–17.00."
                                aria-describedby="form-daftar-deskripsi-ikon"
                                style="min-height: 75px;">{{ old('description') }}</textarea>
                            <label for="form-daftar-deskripsi">Deskripsi UMKM</label>
                        </div>
                    </div>
                    @error('description')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <div class="input-group input-group-merge">
                          <span id="form-daftar-alamat-ikon" class="input-group-text"
                          ><i class="ri-pin-distance-line"></i
                              ></span>
                        <div class="form-floating form-floating-outline">
                            <textarea
                                name="address"
                                type="text"
                                class="form-control"
                                id="form-daftar-alamat"
                                placeholder="Jl. Banjarsugihan Baru, Kel. Banjarsugihan, Kec. Tandes."
                                aria-label="Jl. Banjarsugihan Baru, Kel. Banjarsugihan, Kec. Tandes."
                                aria-describedby="form-daftar-alamat-ikon"
                                style="min-height: 75px;">{{ old('address') }}</textarea>
                            <label for="form-daftar-alamat">Alamat UMKM</label>
                        </div>
                    </div>
                    @error('address')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-12">
                    <div id="map" style="height: 300px; border: 1px solid #ced4da; border-radius: .375rem;"></div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="input-group input-group-merge">
                          <span id="form-daftar-rt-ikon" class="input-group-text"
                          ><i class="ri-map-pin-2-line"></i
                              ></span>
                        <div class="form-floating form-floating-outline">
                            <input
                                value="{{ old('rt') }}"
                                name="rt"
                                type="number"
                                class="form-control"
                                id="form-daftar-rt"
                                placeholder="2"
                                aria-label="2"
                                aria-describedby="form-daftar-rt-ikon" />
                            <label for="form-daftar-rt">RT</label>
                        </div>
                    </div>
                    @error('rt')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3 col-6">
                    <div class="input-group input-group-merge">
                          <span id="form-daftar-rw-ikon" class="input-group-text"
                          ><i class="ri-map-pin-line"></i
                              ></span>
                        <div class="form-floating form-floating-outline">
                            <input
                                value="{{ old('rw') }}"
                                name="rw"
                                type="number"
                                class="form-control"
                                id="form-daftar-rw"
                                placeholder="4"
                                aria-label="4"
                                aria-describedby="form-daftar-rw-ikon" />
                            <label for="form-daftar-rw">RW</label>
                        </div>
                    </div>
                    @error('rw')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3 col-6">
                    <div class="input-group input-group-merge">
                          <span id="form-daftar-lat-ikon" class="input-group-text"
                          ><i class="ri-compass-line"></i
                              ></span>
                        <div class="form-floating form-floating-outline">
                            <input readonly
                                step="any"
                                name="latitude"
                                type="number"
                                class="form-control"
                                id="form-daftar-lat"
                                value="{{ old('latitude', '-7.2756') }}"
                                aria-describedby="form-daftar-lat-ikon" />
                            <label for="form-daftar-lat">Latitude</label>
                        </div>
                    </div>
                    @error('latitude')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3 col-6">
                    <div class="input-group input-group-merge">
                          <span id="form-daftar-lon-ikon" class="input-group-text"
                          ><i class="ri-compass-3-line"></i
                              ></span>
                        <div class="form-floating form-floating-outline">
                            <input readonly
                                step="any"
                                name="longitude"
                                type="number"
                                class="form-control"
                                id="form-daftar-lon"
                                value="{{ old('longitude', '112.6426') }}"
                                aria-describedby="form-daftar-lon-ikon" />
                            <label for="form-daftar-lon">Longitude</label>
                        </div>
                    </div>
                    @error('longitude')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
                @php
                    $oldSocials = old('social_media', []);
                @endphp

                <div class="form-repeater">
                    <div data-repeater-list="social_media">
                        {{-- Jika ada old data, render secara manual --}}
                        @forelse ($oldSocials as $index => $social)
                            <div data-repeater-item class="row gx-3 gy-2 align-items-end mb-3">
                                <div class="col-md-5">
                                    <div class="form-floating form-floating-outline">
                                        <select name="platform" class="form-select @error("social_media.$index.platform") is-invalid @enderror" required>
                                            <option value="" disabled {{ empty($social['platform']) ? 'selected' : '' }}>Pilih Platform</option>
                                            @foreach (['facebook', 'instagram', 'twitter', 'tiktok', 'whatsapp', 'youtube', 'linkedin'] as $platform)
                                                <option value="{{ $platform }}" {{ ($social['platform'] ?? '') === $platform ? 'selected' : '' }}>
                                                    {{ ucfirst($platform) }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <label>Platform</label>
                                        @error("social_media.$index.platform")
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-5">
                                    <div class="form-floating form-floating-outline">
                                        <input type="url" name="url" class="form-control @error("social_media.$index.url") is-invalid @enderror"
                                               value="{{ $social['url'] ?? '' }}" placeholder="https://..." required>
                                        <label>URL Akun Sosial Media</label>
                                        @error("social_media.$index.url")
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <button type="button" class="btn btn-outline-danger w-100 h-100 py-3" data-repeater-delete>
                                        <i class="ri-close-line me-1"></i> Hapus
                                    </button>
                                </div>
                            </div>
                        @empty
                            {{-- Kalau tidak ada data lama, tampilkan 1 kosong --}}
                            <div data-repeater-item class="row gx-3 gy-2 align-items-end mb-3">
                                <div class="col-md-5">
                                    <div class="form-floating form-floating-outline">
                                        <select name="platform" class="form-select" required>
                                            <option value="" disabled selected>Pilih Platform</option>
                                            @foreach (['facebook', 'instagram', 'twitter', 'tiktok', 'whatsapp', 'youtube', 'linkedin'] as $platform)
                                                <option value="{{ $platform }}">{{ ucfirst($platform) }}</option>
                                            @endforeach
                                        </select>
                                        <label>Platform</label>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-floating form-floating-outline">
                                        <input type="url" name="url" class="form-control" placeholder="https://..." required>
                                        <label>URL Akun Sosial Media</label>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <button type="button" class="btn btn-outline-danger w-100 h-100 py-3" data-repeater-delete>
                                        <i class="ri-close-line me-1"></i> Hapus
                                    </button>
                                </div>
                            </div>
                        @endforelse
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <button type="button" class="btn btn-info w-100" data-repeater-create>
                                <i class="ri-add-line me-1"></i> Tambah Sosial Media
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-password-toggle">
                        <div class="input-group input-group-merge">
                            <span id="basic-icon-default-company2" class="input-group-text"
                            ><i class="ri-lock-password-line"></i
                                ></span>
                            <div class="form-floating form-floating-outline">
                                <input
                                    name="password"
                                    type="password"
                                    id="multicol-password"
                                    class="form-control"
                                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                    aria-describedby="multicol-password2" />
                                <label for="multicol-password">Password</label>
                            </div>
                            <span class="input-group-text cursor-pointer" id="multicol-password2"
                            ><i class="ri-eye-off-line"></i
                                ></span>
                        </div>
                    </div>
                    @error('password')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <div class="form-password-toggle">
                        <div class="input-group input-group-merge">
                            <span id="basic-icon-default-company2" class="input-group-text"
                            ><i class="ri-key-line"></i
                                ></span>
                            <div class="form-floating form-floating-outline">
                                <input
                                    name="password_confirmation"
                                    type="password"
                                    id="multicol-confirm-password"
                                    class="form-control"
                                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                    aria-describedby="multicol-confirm-password2" />
                                <label for="multicol-confirm-password">Konfirmasi Password</label>
                            </div>
                            <span class="input-group-text cursor-pointer" id="multicol-confirm-password2"
                            ><i class="ri-eye-off-line"></i
                                ></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pt-6">
                <button type="submit" class="btn btn-primary w-100">Submit</button>
            </div>
        </form>
    </div>
@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('') }}assets/vendor/libs/leaflet/leaflet.css" />
@endpush

@push('js')
    <script src="{{ asset('') }}assets/vendor/libs/leaflet/leaflet.js"></script>
    <script src="{{ asset('') }}assets/vendor/libs/jquery-repeater/jquery-repeater.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Ambil nilai awal dari input hidden
            let defaultLat = parseFloat(document.getElementById('form-daftar-lat').value) || -7.2756;
            let defaultLon = parseFloat(document.getElementById('form-daftar-lon').value) || 112.6426;

            // Inisialisasi peta
            let map = L.map('map').setView([defaultLat, defaultLon], 16);

            // Tambahkan tile layer
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap'
            }).addTo(map);

            // Tambahkan marker awal
            let marker = L.marker([defaultLat, defaultLon], { draggable: true }).addTo(map)
                .bindPopup("Klik pada peta untuk menandai lokasi").openPopup();

            // Saat peta diklik, update marker dan input lat/lon
            map.on('click', function (e) {
                let lat = e.latlng.lat.toFixed(6);
                let lon = e.latlng.lng.toFixed(6);

                marker.setLatLng(e.latlng).update();
                document.getElementById('form-daftar-lat').value = lat;
                document.getElementById('form-daftar-lon').value = lon;
            });

            // Saat marker digeser (drag), update input juga
            marker.on('dragend', function (e) {
                let latlng = e.target.getLatLng();
                document.getElementById('form-daftar-lat').value = latlng.lat.toFixed(6);
                document.getElementById('form-daftar-lon').value = latlng.lng.toFixed(6);
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            $('.form-repeater').repeater({
                initEmpty: false,
                show: function () {
                    $(this).slideDown();
                },
                hide: function (deleteElement) {
                    if (confirm('Hapus sosial media ini?')) {
                        $(this).slideUp(deleteElement);
                    }
                }
            });
        });
    </script>
@endpush

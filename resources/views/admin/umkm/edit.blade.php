@extends('layouts.admin')

@section('title', 'Edit UMKM - Banjarsugihan UMKM Digital Map')

@section('content')
    @if ($errors->has('error'))
        <div class="alert alert-danger d-flex align-items-center" role="alert">
            <i class="ri-error-warning-line me-2"></i>
            <div>{{ $errors->first('error') }}</div>
        </div>
    @endif
    <div class="card mb-6">
        <div class="card-header d-flex flex-wrap align-items-center justify-content-between">
            <div class="flex-grow-0 me-md-3">
                <a href="{{ route('admin.umkm.index') }}" class="btn btn-danger btn-sm">
                    <span class="ri-arrow-go-back-fill"></span>
                </a>
            </div>
            <div class="flex-grow-1 text-center text-md-start mt-2 mt-md-0">
                <h5 class="mb-0">Edit UMKM</h5>
            </div>
        </div>
        <form class="card-body" method="POST" action="{{ route('admin.umkm.update', $umkm->slug) }}">
            @csrf
            @method('PUT')
            <div class="row g-6">
                <div class="col-md-6">
                    <div class="input-group input-group-merge">
                        <span class="input-group-text"><i class="ri-user-line"></i></span>
                        <div class="form-floating form-floating-outline">
                            <input name="owner" type="text" class="form-control" value="{{ old('owner', $umkm->user->name) }}" />
                            <label>Nama Lengkap Pemilik</label>
                        </div>
                    </div>
                    @error('owner')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <div class="input-group input-group-merge">
                        <span class="input-group-text"><i class="ri-building-4-line"></i></span>
                        <div class="form-floating form-floating-outline">
                            <input name="name" type="text" class="form-control" value="{{ old('name', $umkm->name) }}" />
                            <label>Nama UMKM</label>
                        </div>
                    </div>
                    @error('name')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <div class="input-group input-group-merge">
                        <span class="input-group-text"><i class="ri-id-card-line"></i></span>
                        <div class="form-floating form-floating-outline">
                            <input name="username" type="text" class="form-control" value="{{ old('username', $umkm->user->username ?? '') }}" />
                            <label>Username</label>
                        </div>
                    </div>
                    @error('username')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <div class="input-group input-group-merge">
                        <span class="input-group-text"><i class="ri-phone-line"></i></span>
                        <div class="form-floating form-floating-outline">
                            <input name="phone" type="text" class="form-control" value="{{ old('phone', $umkm->phone) }}" />
                            <label>Nomor Telepon</label>
                        </div>
                    </div>
                    @error('phone')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <div class="input-group input-group-merge">
                        <span class="input-group-text"><i class="ri-book-open-line"></i></span>
                        <div class="form-floating form-floating-outline">
                            <textarea name="description" class="form-control" style="min-height:75px">{{ old('description', $umkm->description) }}</textarea>
                            <label>Deskripsi UMKM</label>
                        </div>
                    </div>
                    @error('description')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <div class="input-group input-group-merge">
                        <span class="input-group-text"><i class="ri-pin-distance-line"></i></span>
                        <div class="form-floating form-floating-outline">
                            <textarea name="address" class="form-control" style="min-height:75px">{{ old('address', $umkm->address) }}</textarea>
                            <label>Alamat UMKM</label>
                        </div>
                    </div>
                    @error('address')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-3 col-6">
                    <div class="input-group input-group-merge">
                        <span class="input-group-text"><i class="ri-map-pin-2-line"></i></span>
                        <div class="form-floating form-floating-outline">
                            <input name="rt" type="number" class="form-control" value="{{ old('rt', $umkm->rt) }}" />
                            <label>RT</label>
                        </div>
                    </div>
                    @error('rt')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-3 col-6">
                    <div class="input-group input-group-merge">
                        <span class="input-group-text"><i class="ri-map-pin-line"></i></span>
                        <div class="form-floating form-floating-outline">
                            <input name="rw" type="number" class="form-control" value="{{ old('rw', $umkm->rw) }}" />
                            <label>RW</label>
                        </div>
                    </div>
                    @error('rw')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-3 col-6">
                    <div class="input-group input-group-merge">
                        <span class="input-group-text"><i class="ri-map-pin-line"></i></span>
                        <div class="form-floating form-floating-outline">
                            <input step="any" name="latitude" type="number" class="form-control" value="{{ old('latitude', $umkm->latitude) }}" />
                            <label>Latitude</label>
                        </div>
                    </div>
                    @error('latitude')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-3 col-6">
                    <div class="input-group input-group-merge">
                        <span class="input-group-text"><i class="ri-map-pin-line"></i></span>
                        <div class="form-floating form-floating-outline">
                            <input step="any" name="longitude" type="number" class="form-control" value="{{ old('longitude', $umkm->longitude) }}" />
                            <label>Longitude</label>
                        </div>
                    </div>
                    @error('longitude')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>

                @php
                    $oldSocials = old('social_media', $umkm->socialMedia->map(fn($item) => ['platform' => $item->platform, 'url' => $item->url])->toArray());
                @endphp

                <div class="form-repeater">
                    <div data-repeater-list="social_media">
                        @foreach ($oldSocials as $index => $social)
                            <div data-repeater-item class="row gx-3 gy-2 align-items-end mb-3">
                                <div class="col-md-5">
                                    <select name="platform" class="form-select" required>
                                        <option value="" disabled>Pilih Platform</option>
                                        @foreach (['facebook','instagram','twitter','tiktok','whatsapp','youtube','linkedin'] as $platform)
                                            <option value="{{ $platform }}" {{ $social['platform'] === $platform ? 'selected' : '' }}>{{ ucfirst($platform) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-5">
                                    <input type="url" name="url" class="form-control" value="{{ $social['url'] }}" placeholder="https://...">
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-outline-danger w-100 h-100" data-repeater-delete><i class="ri-close-line me-1"></i> Hapus</button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <button type="button" class="btn btn-info w-100" data-repeater-create><i class="ri-add-line me-1"></i> Tambah Sosial Media</button>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div id="map" style="height: 300px; border: 1px solid #ced4da; border-radius: .375rem;"></div>
                </div>
            </div>

            <div class="pt-6">
                <button type="submit" class="btn btn-primary w-100">Update</button>
            </div>
        </form>
    </div>
@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/leaflet/leaflet.css') }}" />
@endpush

@push('js')
    <script src="{{ asset('assets/vendor/libs/leaflet/leaflet.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/jquery-repeater/jquery-repeater.js') }}"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let defaultLat = parseFloat(document.querySelector('[name=latitude]').value) || -7.2756;
            let defaultLon = parseFloat(document.querySelector('[name=longitude]').value) || 112.6426;
            let map = L.map('map').setView([defaultLat, defaultLon], 18);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap'
            }).addTo(map);
            let marker = L.marker([defaultLat, defaultLon], { draggable: true }).addTo(map)
                .bindPopup("Klik pada peta untuk mengubah lokasi").openPopup();
            map.on('click', function (e) {
                let lat = e.latlng.lat.toFixed(6);
                let lon = e.latlng.lng.toFixed(6);
                marker.setLatLng(e.latlng).update();
                document.querySelector('[name=latitude]').value = lat;
                document.querySelector('[name=longitude]').value = lon;
            });
            marker.on('dragend', function (e) {
                let latlng = e.target.getLatLng();
                document.querySelector('[name=latitude]').value = latlng.lat.toFixed(6);
                document.querySelector('[name=longitude]').value = latlng.lng.toFixed(6);
            });
        });

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

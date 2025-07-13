<!doctype html>

<html
    lang="en"
    class="light-style layout-wide customizer-hide"
    dir="ltr"
    data-theme="theme-default"
    data-assets-path="{{ asset('') }}assets/"
    data-template="vertical-menu-template-no-customizer"
    data-style="light">
<head>
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Daftar - Banjarsugihan UMKM Digital Map</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('') }}assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&ampdisplay=swap"
        rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('') }}assets/vendor/fonts/remixicon/remixicon.css" />
    <link rel="stylesheet" href="{{ asset('') }}assets/vendor/fonts/flag-icons.css" />

    <!-- Menu waves for no-customizer fix -->
    <link rel="stylesheet" href="{{ asset('') }}assets/vendor/libs/node-waves/node-waves.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('') }}assets/vendor/css/rtl/core.css" />
    <link rel="stylesheet" href="{{ asset('') }}assets/vendor/css/rtl/theme-default.css" />
    <link rel="stylesheet" href="{{ asset('') }}assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('') }}assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="{{ asset('') }}assets/vendor/libs/typeahead-js/typeahead.css" />
    <!-- Vendor -->
    <link rel="stylesheet" href="{{ asset('') }}assets/vendor/libs/@form-validation/form-validation.css" />

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="{{ asset('') }}assets/vendor/css/pages/page-auth.css" />

    <link rel="stylesheet" href="{{ asset('') }}assets/vendor/libs/leaflet/leaflet.css" />

    <!-- Helpers -->
    <script src="{{ asset('') }}assets/vendor/js/helpers.js"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ asset('') }}assets/js/config.js"></script>
</head>

<body>
<!-- Content -->

<div class="position-relative">
    <div class="authentication-wrapper authentication-basic container-p-y p-4 p-sm-0">
        <div class="authentication-inner py-6">
            <!-- Register Card -->
            <div class="card p-md-7 p-1">
                <div class="card-body mt-1">
                    <h4 class="mb-1">Cihuuuyyy! 🚀</h4>
                    <p class="mb-5">Masukkan informasi tentang UMKM anda untuk mendaftar!</p>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form id="formAuthentication" class="mb-5" action="{{ route('register.submit') }}" method="POST">
                        @csrf
                        <div class="form-floating form-floating-outline mb-5">
                            <input
                                type="text"
                                class="form-control"
                                id="username"
                                name="username"
                                placeholder="Masukkan username anda"
                                autofocus />
                            <label for="username">Username</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-5">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Masukkan nama UMKM anda" />
                            <label for="name">Nama UMKM</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-5">
                            <input type="text" class="form-control" id="owner" name="owner" placeholder="Masukkan nama lengkap anda" />
                            <label for="owner">Nama Pemilik</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-5">
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="fis fi fi-id rounded-circle"></i>&nbsp;(+62)</span>
                                <div class="form-floating form-floating-outline">
                                    <input
                                        type="text"
                                        id="phone-number-mask"
                                        name="phone"
                                        class="form-control phone-number-mask"
                                        placeholder="821 5107 0990" />
                                    <label for="phone-number-mask">Nomor Telepon</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-floating form-floating-outline mb-5">
                            <button
                                type="button"
                                id="locationModalButton"
                                class="btn btn-danger d-grid w-100"
                                data-bs-toggle="modal"
                                data-bs-target="#addNewAddress">
                                Klik disini untuk menandai lokasi UMKM
                            </button>
                        </div>
                        <div class="modal fade" id="addNewAddress" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-simple modal-add-new-address">
                                <div class="modal-content">
                                    <div class="modal-body p-0">
                                        <div class="text-center mb-4">
                                            <h4 class="address-title mb-2">Pilih lokasi UMKM anda</h4>
                                            <p class="address-subtitle">Klik pada map untuk menandai lokasi UMKM anda</p>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div id="map" style="height: 400px; border-radius: 8px;"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="btn btn-danger d-grid w-100 mt-5" data-bs-dismiss="modal">Tutup</div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 mt-1">
                                <div class="form-floating form-floating-outline mb-5">
                                    <input step="any" type="text" class="form-control" id="lat" name="lat" readonly/>
                                    <label for="lat">Latitude</label>
                                </div>
                            </div>
                            <div class="col-6 mt-1">
                                <div class="form-floating form-floating-outline mb-5">
                                    <input step="any" type="text" class="form-control" id="lon" name="lon" readonly/>
                                    <label for="lon">Longitude</label>
                                </div>
                            </div>
                        </div>
                        <div class="mb-5 form-password-toggle">
                            <div class="input-group input-group-merge">
                                <div class="form-floating form-floating-outline">
                                    <input
                                        type="password"
                                        id="password"
                                        class="form-control"
                                        name="password"
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                        aria-describedby="password" />
                                    <label for="password">Password</label>
                                </div>
                                <span class="input-group-text cursor-pointer"><i class="ri-eye-off-line"></i></span>
                            </div>
                        </div>
                        <div class="mb-5 form-password-toggle">
                            <div class="input-group input-group-merge">
                                <div class="form-floating form-floating-outline">
                                    <input
                                        type="password"
                                        id="confirm-password"
                                        class="form-control"
                                        name="password_confirmation"
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                        aria-describedby="password-confirmation" />
                                    <label for="confirm-password">Konfirmasi Password</label>
                                </div>
                                <span class="input-group-text cursor-pointer"><i class="ri-eye-off-line"></i></span>
                            </div>
                        </div>
                        <button class="btn btn-primary d-grid w-100">Daftar</button>
                    </form>

                    <p class="text-center mt-3">
                        <span>Sudah pernah mendaftar?</span>
                        <a href="{{ route('login') }}">
                            <span>Klik disini untuk masuk!</span>
                        </a>
                    </p>
                </div>
            </div>
            <!-- Register Card -->
            <img
                alt="mask"
                src="{{ asset('') }}assets/img/illustrations/auth-basic-register-mask-light.png"
                class="authentication-image d-none d-lg-block"
                data-app-light-img="illustrations/auth-basic-register-mask-light.png"
                data-app-dark-img="illustrations/auth-basic-register-mask-dark.png" />
        </div>
    </div>
</div>

<!-- / Content -->

<script>
    let map;
    let marker;

    const modal = document.getElementById('addNewAddress');
    modal.addEventListener('shown.bs.modal', function () {
        if (!map) {
            map = L.map('map').setView([-7.2795, 112.6638], 16);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; OpenStreetMap',
            }).addTo(map);

            map.on('click', function (e) {
                const lat = e.latlng.lat.toFixed(8);
                const lon = e.latlng.lng.toFixed(8);

                document.getElementById('lat').value = lat;
                document.getElementById('lon').value = lon;
                document.getElementById('locationModalButton').innerHTML = 'Lokasi sudah di-set, klik untuk ubah';

                if (marker) {
                    marker.setLatLng(e.latlng);
                } else {
                    marker = L.marker(e.latlng).addTo(map);
                }
            });
        } else {
            map.invalidateSize();
        }
    });
</script>

<!-- Core JS -->
<!-- build:js assets/vendor/js/core.js -->
<script src="{{ asset('') }}assets/vendor/libs/jquery/jquery.js"></script>
<script src="{{ asset('') }}assets/vendor/libs/popper/popper.js"></script>
<script src="{{ asset('') }}assets/vendor/js/bootstrap.js"></script>
<script src="{{ asset('') }}assets/vendor/libs/node-waves/node-waves.js"></script>
<script src="{{ asset('') }}assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
<script src="{{ asset('') }}assets/vendor/libs/hammer/hammer.js"></script>
<script src="{{ asset('') }}assets/vendor/libs/i18n/i18n.js"></script>
<script src="{{ asset('') }}assets/vendor/libs/typeahead-js/typeahead.js"></script>
<script src="{{ asset('') }}assets/vendor/js/menu.js"></script>

<!-- endbuild -->

<!-- Vendors JS -->
<script src="{{ asset('') }}assets/vendor/libs/@form-validation/popular.js"></script>
<script src="{{ asset('') }}assets/vendor/libs/@form-validation/bootstrap5.js"></script>
<script src="{{ asset('') }}assets/vendor/libs/@form-validation/auto-focus.js"></script>
<script src="{{ asset('') }}assets/vendor/libs/cleavejs/cleave.js"></script>
<script src="{{ asset('') }}assets/vendor/libs/cleavejs/cleave-phone.js"></script>
<script src="{{ asset('') }}assets/vendor/libs/leaflet/leaflet.js"></script>

<!-- Main JS -->
<script src="{{ asset('') }}assets/js/main.js"></script>

<!-- Page JS -->
<script src="{{ asset('') }}assets/js/pages-auth.js"></script>
<script src="{{ asset('') }}assets/js/forms-extras.js"></script>
</body>
</html>

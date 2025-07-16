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

    <title>Masuk - Banjarsugihan UMKM Digital Map</title>

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
            <!-- Login -->
            <div class="card p-md-7 p-1">

                <div class="card-body mt-1">
                    <h4 class="mb-1">Selamat Datang! 👋</h4>
                    <p class="mb-5">Masukkan kredensial akun untuk mulai kelola UMKM anda!</p>

                    <form id="formAuthentication" class="mb-5" action="{{ route('login.submit') }}" method="POST">
                        @csrf
                        <div class="form-floating form-floating-outline mb-5">
                            <input
                                type="text"
                                class="form-control"
                                id="username"
                                name="username"
                                placeholder="Masukkan username anda"
                                value="{{ old('username') }}"
                                autofocus />
                            <label for="email">Username</label>
                        </div>
                        <div class="mb-5">
                            <div class="form-password-toggle">
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
                        </div>
                        <div class="mb-5 d-flex justify-content-between mt-5">
                            <a href="{{ route('password.forgot') }}" class="float-end mb-1 mt-2">
                                <span>Lupa Password?</span>
                            </a>
                        </div>
                        <div class="mb-5">
                            <button class="btn btn-primary d-grid w-100" type="submit">Masuk</button>
                        </div>
                    </form>

                    <p class="text-center">
                        <span>UMKM belum terdaftar?</span>
                        <a href="{{ route('register') }}">
                            <span>Daftarkan UMKM!</span>
                        </a>
                    </p>
                    <hr>
                    <p class="text-center">
                        <a href="{{ route('home.index') }}">
                            <span>Kembali Ke Halaman Awal!</span>
                        </a>
                    </p>
                </div>
            </div>
            <!-- /Login -->
            <img
                alt="mask"
                src="{{ asset('') }}assets/img/illustrations/auth-basic-login-mask-light.png"
                class="authentication-image d-none d-lg-block"
                data-app-light-img="illustrations/auth-basic-login-mask-light.png"
                data-app-dark-img="illustrations/auth-basic-login-mask-dark.png" />
        </div>
    </div>
</div>

<!-- / Content -->

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

<!-- Main JS -->
<script src="{{ asset('') }}assets/js/main.js"></script>

<!-- Page JS -->
<script src="{{ asset('') }}assets/js/pages-auth.js"></script>
</body>
</html>

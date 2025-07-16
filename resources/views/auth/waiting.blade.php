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

    <title>Menunggu Persetujuan - Peta Digital UMKM Banjarsugihan</title>

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
            <div class="card p-md-7 p-1">
                <!-- Logo -->
                <div class="app-brand justify-content-center mt-5">
                    <a href="index.html" class="app-brand-link gap-2">
                <span class="app-brand-logo demo">
                    <img style="width: 30px;" src="{{ asset('assets/img/icons/pdlogo.png') }}" alt="Logo Peta Digital">
                </span>
                        <span class="app-brand-text demo text-heading fw-semibold">Peta Digital</span>
                    </a>
                </div>
                <!-- /Logo -->

                <!-- Verify Email -->
                <div class="card-body mt-1">
                    <h4 class="mb-1">Menunggu Disetujui Admin</h4>
                    <p class="text-start mb-0">
                        Akun UMKM anda akan aktif setelah disetujui oleh admin, silahkan login untuk cek secara berkala.
                    </p>
                    <form action="{{ route('logout') }}" method="POST"class="mb-n3">
                        @csrf
                        <button type="submit" class="btn btn-primary w-100 my-5">
                            <small class="align-middle">Logout</small>
                            <i class="ri-logout-box-r-line ms-2 ri-16px"></i>
                        </button>
                    </form>
                </div>
            </div>
            <img
                alt="mask"
                src="{{ asset('') }}assets/img/illustrations/auth-basic-login-mask-light.png"
                class="authentication-image d-none d-lg-block"
                data-app-light-img="illustrations/auth-basic-login-mask-light.png"
                data-app-dark-img="illustrations/auth-basic-login-mask-dark.png" />
            <!-- /Verify Email -->
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

<!-- Main JS -->
<script src="{{ asset('') }}assets/js/main.js"></script>

<!-- Page JS -->
</body>
</html>

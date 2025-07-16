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

    <style>
        .login-features {
            background: linear-gradient(135deg, #696cff 0%, #5a67f2 100%);
            border-radius: 12px;
            color: white;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }
        .feature-item {
            display: flex;
            align-items: center;
            margin-bottom: 0.75rem;
        }
        .feature-item:last-child {
            margin-bottom: 0;
        }
        .feature-icon {
            width: 32px;
            height: 32px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
            flex-shrink: 0;
        }
        .form-helper-text {
            font-size: 0.875rem;
            color: #8A8D93;
            margin-top: 0.5rem;
        }
        .quick-access {
            background: #f8f9fa;
            border: 1px solid #e7e7e7;
            border-radius: 8px;
            padding: 1rem;
            margin-top: 1rem;
        }
        .demo-credentials {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1.5rem;
        }
        .credentials-btn {
            font-size: 0.875rem;
            padding: 0.25rem 0.5rem;
        }
        .loading-spinner {
            display: none;
            width: 1rem;
            height: 1rem;
            border: 2px solid transparent;
            border-top: 2px solid currentColor;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .btn-login.loading .loading-spinner {
            display: inline-block;
            margin-right: 0.5rem;
        }
        .btn-login.loading .btn-text {
            display: none;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .login-features {
                padding: 1rem;
                margin-bottom: 1rem;
            }
            .feature-item {
                margin-bottom: 0.5rem;
            }
            .feature-icon {
                width: 28px;
                height: 28px;
                margin-right: 10px;
            }
        }
    </style>
</head>

<body>
<!-- Content -->

<div class="position-relative">
    <div class="authentication-wrapper authentication-basic container-p-y p-4 p-sm-0">
        <div class="authentication-inner py-6">
            <!-- Login -->
            <div class="card p-md-7 p-1">
                <div class="card-body mt-1">
                    <div class="text-center mb-4">
                        <h4 class="mb-2">Selamat Datang Kembali! 👋</h4>
                        <p class="mb-0">Masuk ke akun UMKM Anda untuk mengelola bisnis digital</p>
                    </div>

                    <!-- Login Benefits/Features -->
                    <div class="login-features">
                        <h6 class="mb-3 text-white">Dengan masuk, Anda dapat:</h6>
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="ri-store-2-line"></i>
                            </div>
                            <span>Kelola profil UMKM Anda</span>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="ri-map-pin-line"></i>
                            </div>
                            <span>Update lokasi dan informasi bisnis</span>
                        </div>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form id="formAuthentication" class="mb-4" action="{{ route('login.submit') }}" method="POST">
                        @csrf
                        <div class="form-floating form-floating-outline mb-4">
                            <input
                                type="text"
                                class="form-control @error('username') is-invalid @enderror"
                                id="username"
                                name="username"
                                placeholder="Masukkan username anda"
                                value="{{ old('username') }}"
                                autofocus
                                required />
                            <label for="username">Username</label>
                            @error('username')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @endif
                            <div class="form-helper-text">Masukkan username yang telah didaftarkan</div>
                        </div>

                        <div class="mb-4">
                            <div class="form-password-toggle">
                                <div class="input-group input-group-merge">
                                    <div class="form-floating form-floating-outline">
                                        <input
                                            type="password"
                                            id="password"
                                            class="form-control @error('password') is-invalid @enderror"
                                            name="password"
                                            placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                            required />
                                        <label for="password">Password</label>
                                    </div>
                                    <span class="input-group-text cursor-pointer" id="togglePassword">
                                        <i class="ri-eye-off-line" id="toggleIcon"></i>
                                    </span>
                                </div>
                                @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @endif
                                <div class="form-helper-text">Password minimal 6 karakter</div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <a href="{{ route('password.forgot') }}" class="text-primary">
                                <small>Lupa Password?</small>
                            </a>
                        </div>

                        <button class="btn btn-primary d-grid w-100 btn-login" type="submit">
                            <div class="loading-spinner"></div>
                            <span class="btn-text">
                                <i class="ri-login-box-line me-2"></i>Masuk ke Akun UMKM
                            </span>
                        </button>
                    </form>

                    <p class="text-center mt-4 mb-0">
                        <span class="text-muted">Belum memiliki akun UMKM?</span>
                        <a href="{{ route('register') }}">
                            Daftarkan UMKM Anda Sekarang!
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

<script>
    // Password toggle functionality
    document.getElementById('togglePassword').addEventListener('click', function () {
        const password = document.getElementById('password');
        const toggleIcon = document.getElementById('toggleIcon');

        if (password.type === 'password') {
            password.type = 'text';
            toggleIcon.className = 'ri-eye-line';
        } else {
            password.type = 'password';
            toggleIcon.className = 'ri-eye-off-line';
        }
    });

    // Form submission with loading state
    document.getElementById('formAuthentication').addEventListener('submit', function(e) {
        const submitBtn = document.querySelector('.btn-login');

        // Add loading state
        submitBtn.classList.add('loading');
        submitBtn.disabled = true;

        // Remove loading state if form validation fails
        setTimeout(() => {
            if (submitBtn.classList.contains('loading')) {
                submitBtn.classList.remove('loading');
                submitBtn.disabled = false;
            }
        }, 3000);
    });

    // Enhanced keyboard navigation
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Enter') {
            const activeElement = document.activeElement;
            if (activeElement.id === 'username') {
                document.getElementById('password').focus();
                e.preventDefault();
            }
        }
    });

    // Auto-focus improvement
    document.addEventListener('DOMContentLoaded', function() {
        const usernameInput = document.getElementById('username');
        if (usernameInput && !usernameInput.value) {
            usernameInput.focus();
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

<!-- Main JS -->
<script src="{{ asset('') }}assets/js/main.js"></script>
</body>
</html>

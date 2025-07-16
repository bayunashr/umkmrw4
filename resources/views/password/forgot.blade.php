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

    <title>Lupa Password - Peta Digital UMKM Banjarsugihan</title>

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

<div class="content-wrapper">
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <!-- Back Button -->
                <div class="mb-4">
                    <a href="{{ route('home.index') }}" class="btn btn-outline-secondary">
                        <i class="ri-arrow-left-line me-2"></i>
                        Kembali
                    </a>
                </div>

                <!-- Forgot Password Card -->
                <div class="card">
                    <div class="card-body text-center py-5">
                        <!-- Icon -->
                        <div class="mb-4">
                            <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-warning-subtle"
                                 style="width: 80px; height: 80px;">
                                <i class="ri-lock-password-line display-4 text-warning"></i>
                            </div>
                        </div>

                        <!-- Title -->
                        <h4 class="mb-3">Lupa Password?</h4>

                        <!-- Description -->
                        <p class="text-muted mb-4">
                            Jangan khawatir, kami siap membantu Anda untuk reset password akun UMKM.
                        </p>

                        <!-- Instructions -->
                        <div class="alert alert-info text-start mb-4">
                            <div class="d-flex align-items-start">
                                <i class="ri-information-line me-2 mt-1"></i>
                                <div>
                                    <h6 class="mb-2">Cara Reset Password:</h6>
                                    <ol class="mb-0 ps-3">
                                        <li>Hubungi Admin melalui kontak yang tersedia</li>
                                        <li>Berikan informasi UMKM dan username Anda</li>
                                        <li>Admin akan memverifikasi identitas Anda</li>
                                        <li>Password baru akan dikirim atau dibuat ulang</li>
                                    </ol>
                                </div>
                            </div>
                        </div>

                        <!-- Contact Information -->
                        <div class="row g-3 mb-4">
                            <div class="col-sm-6">
                                <div class="card border bg-light h-100">
                                    <div class="card-body text-center p-3">
                                        <i class="ri-phone-line text-primary mb-2" style="font-size: 1.5rem;"></i>
                                        <h6 class="mb-1">WhatsApp</h6>
                                        <a href="https://wa.me/6281234567890"
                                           target="_blank"
                                           class="btn btn-outline-primary btn-sm">
                                            <i class="ri-whatsapp-line me-1"></i>
                                            Hubungi
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="card border bg-light h-100">
                                    <div class="card-body text-center p-3">
                                        <i class="ri-mail-line text-success mb-2" style="font-size: 1.5rem;"></i>
                                        <h6 class="mb-1">Email</h6>
                                        <a href="mailto:admin@banjarsugihan.com"
                                           class="btn btn-outline-success btn-sm">
                                            <i class="ri-mail-line me-1"></i>
                                            Email
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Security Notice -->
                        <div class="alert alert-warning text-start">
                            <div class="d-flex align-items-start">
                                <i class="ri-shield-check-line me-2 mt-1"></i>
                                <div>
                                    <h6 class="mb-2">Keamanan Akun</h6>
                                    <small class="text-muted">
                                        Untuk keamanan, admin akan memverifikasi identitas Anda sebelum melakukan reset password.
                                        Pastikan Anda menghubungi admin melalui kontak resmi yang tertera di atas.
                                    </small>
                                </div>
                            </div>
                        </div>

                        <!-- Back to Login -->
                        <div class="mt-4 pt-3 border-top">
                            <p class="text-muted mb-0">
                                Sudah ingat password?
                                <a href="{{ route('login') }}" class="text-primary">
                                    <i class="ri-login-circle-line me-1"></i>
                                    Kembali ke Login
                                </a>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- FAQ Section -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h6 class="mb-0">
                            <i class="ri-question-line me-2"></i>
                            Pertanyaan Umum
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="accordion" id="faqAccordion">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                        Berapa lama proses reset password?
                                    </button>
                                </h2>
                                <div id="faq1" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        <small class="text-muted">
                                            Proses reset password biasanya memakan waktu 1-2 hari kerja setelah admin memverifikasi identitas Anda.
                                        </small>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                        Informasi apa yang diperlukan untuk reset password?
                                    </button>
                                </h2>
                                <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        <small class="text-muted">
                                            Anda perlu memberikan nama UMKM, username, dan nomor telepon yang terdaftar untuk verifikasi identitas.
                                        </small>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                        Apakah layanan reset password gratis?
                                    </button>
                                </h2>
                                <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        <small class="text-muted">
                                            Ya, layanan reset password adalah gratis untuk semua pengguna UMKM yang terdaftar.
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- / Content -->

    <div class="content-backdrop fade"></div>
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

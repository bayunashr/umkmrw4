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

    <style>
        .step-progress {
            display: flex;
            justify-content: center;
            margin-bottom: 2rem;
            position: relative;
        }
        .step-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
            z-index: 2;
        }
        .step-item:not(:last-child) {
            margin-right: 60px;
        }
        .step-item:not(:last-child)::after {
            content: '';
            position: absolute;
            top: 20px;
            left: 50px;
            width: 60px;
            height: 2px;
            background: #e7e7e7;
            z-index: 1;
        }
        .step-item.active:not(:last-child)::after,
        .step-item.completed:not(:last-child)::after {
            background: #696cff;
        }
        .step-circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #f1f1f1;
            border: 2px solid #e7e7e7;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            color: #8A8D93;
            z-index: 2;
            position: relative;
            margin-bottom: 8px;
        }
        .step-item.active .step-circle {
            background: #696cff;
            border-color: #696cff;
            color: white;
        }
        .step-item.completed .step-circle {
            background: #28a745;
            border-color: #28a745;
            color: white;
        }
        .step-label {
            font-size: 0.75rem;
            color: #8A8D93;
            text-align: center;
            white-space: nowrap;
        }
        .step-item.active .step-label {
            color: #696cff;
            font-weight: 600;
        }
        .step-item.completed .step-label {
            color: #28a745;
            font-weight: 600;
        }

        /* Mobile responsive */
        @media (max-width: 768px) {
            .step-progress {
                margin-bottom: 1.5rem;
            }
            .step-item:not(:last-child) {
                margin-right: 40px;
            }
            .step-item:not(:last-child)::after {
                width: 40px;
                left: 30px;
            }
            .step-circle {
                width: 32px;
                height: 32px;
                font-size: 0.875rem;
            }
            .step-label {
                font-size: 0.6rem;
            }
        }

        @media (max-width: 480px) {
            .step-item:not(:last-child) {
                margin-right: 25px;
            }
            .step-item:not(:last-child)::after {
                width: 25px;
                left: 20px;
            }
            .step-circle {
                width: 28px;
                height: 28px;
                font-size: 0.75rem;
            }
            .step-label {
                font-size: 0.55rem;
            }
        }

        .form-section {
            display: none;
        }
        .form-section.active {
            display: block;
        }
        .location-preview {
            background: #f8f9fa;
            border: 1px solid #e7e7e7;
            border-radius: 8px;
            padding: 1rem;
            margin-top: 1rem;
            display: none;
        }
        .location-preview.show {
            display: block;
        }
        .map-container {
            position: relative;
        }
        .map-overlay {
            position: absolute;
            top: 10px;
            right: 10px;
            background: rgba(255, 255, 255, 0.9);
            padding: 8px 12px;
            border-radius: 4px;
            font-size: 0.875rem;
            z-index: 1000;
        }
        .form-helper-text {
            font-size: 0.875rem;
            color: #8A8D93;
            margin-top: 0.5rem;
        }
        .btn-outline-primary {
            border-color: #696cff;
            color: #696cff;
        }
        .btn-outline-primary:hover {
            background-color: #696cff;
            border-color: #696cff;
        }

        /* Navigation buttons responsive */
        @media (max-width: 576px) {
            .d-flex.justify-content-between {
                flex-direction: column;
                gap: 10px;
            }
            .d-flex.justify-content-end {
                justify-content: stretch !important;
            }
            .btn {
                width: 100%;
            }
        }
    </style>
</head>

<body>
<!-- Content -->

<div class="position-relative">
    <div class="authentication-wrapper authentication-basic container-p-y p-4 p-sm-0">
        <div class="authentication-inner py-6">
            <!-- Register Card -->
            <div class="card p-md-7 p-1">
                <div class="card-body mt-1">
                    <h4 class="mb-1">Daftar UMKM Digital Map 🚀</h4>
                    <p class="mb-4">Bergabunglah dengan komunitas UMKM digital Banjarsugihan</p>

                    <!-- Progress Steps -->
                    <div class="step-progress">
                        <div class="step-item active" data-step="1">
                            <div class="step-circle">1</div>
                            <div class="step-label">Akun</div>
                        </div>
                        <div class="step-item" data-step="2">
                            <div class="step-circle">2</div>
                            <div class="step-label">UMKM</div>
                        </div>
                        <div class="step-item" data-step="3">
                            <div class="step-circle">3</div>
                            <div class="step-label">Lokasi</div>
                        </div>
                        <div class="step-item" data-step="4">
                            <div class="step-circle">4</div>
                            <div class="step-label">Selesai</div>
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

                    <form id="formAuthentication" class="mb-5" action="{{ route('register.submit') }}" method="POST">
                        @csrf

                        <!-- Step 1: Account Information -->
                        <div class="form-section active" data-section="1">
                            <h5 class="mb-4">Informasi Akun</h5>

                            <div class="form-floating form-floating-outline mb-4">
                                <input
                                    type="text"
                                    class="form-control"
                                    id="username"
                                    name="username"
                                    placeholder="Masukkan username"
                                    autofocus />
                                <label for="username">Username</label>
                                <div class="form-helper-text">Username akan digunakan untuk login</div>
                            </div>

                            <div class="mb-4 form-password-toggle">
                                <div class="input-group input-group-merge">
                                    <div class="form-floating form-floating-outline">
                                        <input
                                            type="password"
                                            id="password"
                                            class="form-control"
                                            name="password"
                                            placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                                        <label for="password">Password</label>
                                    </div>
                                    <span class="input-group-text cursor-pointer"><i class="ri-eye-off-line"></i></span>
                                </div>
                                <div class="form-helper-text">Minimal 6 karakter</div>
                            </div>

                            <div class="mb-4 form-password-toggle">
                                <div class="input-group input-group-merge">
                                    <div class="form-floating form-floating-outline">
                                        <input
                                            type="password"
                                            id="confirm-password"
                                            class="form-control"
                                            name="password_confirmation"
                                            placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                                        <label for="confirm-password">Konfirmasi Password</label>
                                    </div>
                                    <span class="input-group-text cursor-pointer"><i class="ri-eye-off-line"></i></span>
                                </div>
                                <div class="form-helper-text">Masukkan password yang sama</div>
                            </div>

                            <div class="d-flex justify-content-end">
                                <button type="button" class="btn btn-primary w-100 w-sm-auto" onclick="nextStep(2)">
                                    Selanjutnya <i class="ri-arrow-right-line"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Step 2: Business Information -->
                        <div class="form-section" data-section="2">
                            <h5 class="mb-4">Informasi UMKM</h5>

                            <div class="form-floating form-floating-outline mb-4">
                                <input type="text" class="form-control" id="name" name="name" placeholder="Nama UMKM" />
                                <label for="name">Nama UMKM</label>
                                <div class="form-helper-text">Nama usaha yang akan ditampilkan di peta</div>
                            </div>

                            <div class="form-floating form-floating-outline mb-4">
                                <input type="text" class="form-control" id="owner" name="owner" placeholder="Nama pemilik" />
                                <label for="owner">Nama Pemilik</label>
                                <div class="form-helper-text">Nama lengkap pemilik usaha</div>
                            </div>

                            <div class="form-floating form-floating-outline mb-4">
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="fis fi fi-id rounded-circle"></i>&nbsp;(+62)</span>
                                    <div class="form-floating form-floating-outline">
                                        <input
                                            type="text"
                                            id="phone-number-mask"
                                            name="phone"
                                            class="form-control"
                                            placeholder="82151070990"
                                            pattern="[0-9]*"
                                            inputmode="numeric" />
                                        <label for="phone-number-mask">Nomor Telepon</label>
                                    </div>
                                </div>
                                <div class="form-helper-text">Nomor yang bisa dihubungi untuk keperluan bisnis (tanpa spasi)</div>
                            </div>

                            <div class="d-flex flex-column flex-sm-row justify-content-between gap-2">
                                <button type="button" class="btn btn-outline-primary order-2 order-sm-1" onclick="prevStep(1)">
                                    <i class="ri-arrow-left-line"></i> Sebelumnya
                                </button>
                                <button type="button" class="btn btn-primary order-1 order-sm-2" onclick="nextStep(3)">
                                    Selanjutnya <i class="ri-arrow-right-line"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Step 3: Location -->
                        <div class="form-section" data-section="3">
                            <h5 class="mb-4">Lokasi UMKM</h5>

                            <div class="alert alert-info">
                                <i class="ri-information-line"></i>
                                Klik pada peta untuk menandai lokasi UMKM Anda dengan akurat
                            </div>

                            <div class="mb-4">
                                <button
                                    type="button"
                                    id="locationModalButton"
                                    class="btn btn-primary d-grid w-100"
                                    data-bs-toggle="modal"
                                    data-bs-target="#addNewAddress">
                                    <i class="ri-map-pin-line me-2"></i>Pilih Lokasi UMKM
                                </button>
                            </div>

                            <div class="location-preview mb-4" id="locationPreview">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="ri-map-pin-fill text-success me-2"></i>
                                    <span class="fw-semibold">Lokasi berhasil dipilih</span>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <small class="text-muted">Latitude:</small>
                                        <div id="latDisplay" class="fw-medium"></div>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted">Longitude:</small>
                                        <div id="lonDisplay" class="fw-medium"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="row" style="display: none;">
                                <div class="col-6">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <input type="text" class="form-control" id="lat" name="lat" readonly/>
                                        <label for="lat">Latitude</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <input type="text" class="form-control" id="lon" name="lon" readonly/>
                                        <label for="lon">Longitude</label>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex flex-column flex-sm-row justify-content-between gap-2">
                                <button type="button" class="btn btn-outline-primary order-2 order-sm-1" onclick="prevStep(2)">
                                    <i class="ri-arrow-left-line"></i> Sebelumnya
                                </button>
                                <button type="button" class="btn btn-primary order-1 order-sm-2" onclick="nextStep(4)" id="locationNextBtn" disabled>
                                    Selanjutnya <i class="ri-arrow-right-line"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Step 4: Review & Submit -->
                        <div class="form-section" data-section="4">
                            <h5 class="mb-4">Review & Konfirmasi</h5>

                            <div class="alert alert-success">
                                <i class="ri-check-line"></i>
                                Mohon periksa kembali data yang telah Anda masukkan
                            </div>

                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12 col-md-6 mb-3 mb-md-0">
                                            <h6 class="mb-3">Informasi Akun</h6>
                                            <div class="mb-2">
                                                <small class="text-muted">Username:</small>
                                                <div id="reviewUsername" class="fw-medium"></div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <h6 class="mb-3">Informasi UMKM</h6>
                                            <div class="mb-2">
                                                <small class="text-muted">Nama UMKM:</small>
                                                <div id="reviewName" class="fw-medium"></div>
                                            </div>
                                            <div class="mb-2">
                                                <small class="text-muted">Pemilik:</small>
                                                <div id="reviewOwner" class="fw-medium"></div>
                                            </div>
                                            <div class="mb-2">
                                                <small class="text-muted">Telepon:</small>
                                                <div id="reviewPhone" class="fw-medium"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex flex-column flex-sm-row justify-content-between gap-2">
                                <button type="button" class="btn btn-outline-primary order-2 order-sm-1" onclick="prevStep(3)">
                                    <i class="ri-arrow-left-line"></i> Sebelumnya
                                </button>
                                <button type="submit" class="btn btn-success order-1 order-sm-2 mt-4">
                                    <i class="ri-check-line me-2"></i>Daftar Sekarang
                                </button>
                            </div>
                        </div>
                    </form>

                    <p class="text-center mt-3">
                        <span>Sudah pernah mendaftar?</span>
                        <a href="{{ route('login') }}">
                            <span>Klik disini untuk masuk!</span>
                        </a>
                    </p>
                </div>
            </div>

            <!-- Location Modal -->
            <div class="modal fade" id="addNewAddress" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-simple modal-add-new-address">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Pilih Lokasi UMKM</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body p-4">
                            <div class="alert alert-info">
                                <i class="ri-information-line"></i>
                                Klik pada peta untuk menandai lokasi UMKM Anda. Pastikan lokasi sudah tepat sebelum menutup modal.
                            </div>
                            <div class="map-container">
                                <div class="map-overlay" id="mapCoords" style="display: none;">
                                    <div class="fw-semibold">Koordinat Dipilih</div>
                                    <div id="mapCoordsText"></div>
                                </div>
                                <div id="map" style="height: 400px; border-radius: 8px;"></div>
                            </div>
                        </div>
                        <div class="modal-footer d-flex flex-column flex-sm-row gap-2">
                            <button type="button" class="btn btn-outline-secondary order-2 order-sm-1" data-bs-dismiss="modal">
                                <i class="ri-close-line me-2"></i>Batal
                            </button>
                            <button type="button" class="btn btn-primary order-1 order-sm-2" data-bs-dismiss="modal" onclick="confirmLocation()">
                                <i class="ri-check-line me-2"></i>Konfirmasi Lokasi
                            </button>
                        </div>
                    </div>
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
    let currentStep = 1;

    // Step navigation functions
    function nextStep(step) {
        if (validateCurrentStep()) {
            showStep(step);
        }
    }

    function prevStep(step) {
        showStep(step);
    }

    function showStep(step) {
        // Hide all sections
        document.querySelectorAll('.form-section').forEach(section => {
            section.classList.remove('active');
        });

        // Show current section
        document.querySelector(`[data-section="${step}"]`).classList.add('active');

        // Update step progress
        updateStepProgress(step);

        // Update review data if on step 4
        if (step === 4) {
            updateReviewData();
        }

        currentStep = step;
    }

    function updateStepProgress(activeStep) {
        document.querySelectorAll('.step-item').forEach((item, index) => {
            const stepNum = index + 1;
            item.classList.remove('active', 'completed');

            if (stepNum < activeStep) {
                item.classList.add('completed');
            } else if (stepNum === activeStep) {
                item.classList.add('active');
            }
        });
    }

    function validateCurrentStep() {
        const step = currentStep;
        let isValid = true;

        if (step === 1) {
            const username = document.getElementById('username').value;
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm-password').value;

            if (!username || username.length < 4) {
                showError('Username minimal 4 karakter');
                isValid = false;
            }
            if (!password || password.length < 6) {
                showError('Password minimal 6 karakter');
                isValid = false;
            }
            if (password !== confirmPassword) {
                showError('Password dan konfirmasi password tidak sama');
                isValid = false;
            }
        } else if (step === 2) {
            const name = document.getElementById('name').value;
            const owner = document.getElementById('owner').value;
            const phone = document.getElementById('phone-number-mask').value;

            if (!name.trim()) {
                showError('Nama UMKM harus diisi');
                isValid = false;
            }
            if (!owner.trim()) {
                showError('Nama pemilik harus diisi');
                isValid = false;
            }
            if (!phone.trim()) {
                showError('Nomor telepon harus diisi');
                isValid = false;
            }
        } else if (step === 3) {
            const lat = document.getElementById('lat').value;
            const lon = document.getElementById('lon').value;

            if (!lat || !lon) {
                showError('Lokasi UMKM harus dipilih');
                isValid = false;
            }
        }

        return isValid;
    }

    function showError(message) {
        // Create or update error alert
        let errorAlert = document.getElementById('stepError');
        if (!errorAlert) {
            errorAlert = document.createElement('div');
            errorAlert.id = 'stepError';
            errorAlert.className = 'alert alert-danger';
            document.querySelector('.form-section.active').insertBefore(errorAlert, document.querySelector('.form-section.active').firstChild);
        }
        errorAlert.innerHTML = `<i class="ri-error-warning-line"></i> ${message}`;

        // Auto hide after 5 seconds
        setTimeout(() => {
            if (errorAlert) {
                errorAlert.remove();
            }
        }, 5000);
    }

    function updateReviewData() {
        document.getElementById('reviewUsername').textContent = document.getElementById('username').value;
        document.getElementById('reviewName').textContent = document.getElementById('name').value;
        document.getElementById('reviewOwner').textContent = document.getElementById('owner').value;
        document.getElementById('reviewPhone').textContent = '+62' + document.getElementById('phone-number-mask').value;
    }

    function confirmLocation() {
        const lat = document.getElementById('lat').value;
        const lon = document.getElementById('lon').value;

        if (lat && lon) {
            document.getElementById('locationPreview').classList.add('show');
            document.getElementById('latDisplay').textContent = lat;
            document.getElementById('lonDisplay').textContent = lon;
            document.getElementById('locationNextBtn').disabled = false;
            document.getElementById('locationModalButton').innerHTML = '<i class="ri-map-pin-line me-2"></i>Ubah Lokasi UMKM';
        }
    }

    // Map initialization
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

                // Show coordinates overlay
                document.getElementById('mapCoords').style.display = 'block';
                document.getElementById('mapCoordsText').textContent = `${lat}, ${lon}`;

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

    // Form validation
    const formAuthentication = document.querySelector('#formAuthentication');

    document.addEventListener('DOMContentLoaded', function (e) {
        (function () {
            // Form validation for Add new record
            if (formAuthentication) {
                const fv = FormValidation.formValidation(formAuthentication, {
                    fields: {
                        username: {
                            validators: {
                                notEmpty: {
                                    message: 'Masukkan username'
                                },
                                stringLength: {
                                    min: 4,
                                    message: 'Minimal 4 karakter'
                                }
                            }
                        },
                        name: {
                            validators: {
                                notEmpty: {
                                    message: 'Masukkan nama UMKM'
                                },
                            }
                        },
                        owner: {
                            validators: {
                                notEmpty: {
                                    message: 'Masukkan nama pemilik'
                                },
                            }
                        },
                        password: {
                            validators: {
                                notEmpty: {
                                    message: 'Masukkan password'
                                },
                                stringLength: {
                                    min: 6,
                                    message: 'Minimal 6 karakter'
                                }
                            }
                        },
                        'confirm-password': {
                            validators: {
                                notEmpty: {
                                    message: 'Masukkan ulang password'
                                },
                                identical: {
                                    compare: function () {
                                        return formAuthentication.querySelector('[name="password"]').value;
                                    },
                                    message: 'Password tidak sama'
                                },
                                stringLength: {
                                    min: 6,
                                    message: 'Minimal 6 karakter'
                                }
                            }
                        },
                    },
                    plugins: {
                        trigger: new FormValidation.plugins.Trigger(),
                        bootstrap5: new FormValidation.plugins.Bootstrap5({
                            eleValidClass: '',
                            rowSelector: '.mb-4'
                        }),
                        submitButton: new FormValidation.plugins.SubmitButton(),
                        defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
                        autoFocus: new FormValidation.plugins.AutoFocus()
                    },
                    init: instance => {
                        instance.on('plugins.message.placed', function (e) {
                            if (e.element.parentElement.classList.contains('input-group')) {
                                e.element.parentElement.insertAdjacentElement('afterend', e.messageElement);
                            }
                        });
                    }
                });
            }

            //  Two Steps Verification
            const numeralMask = document.querySelectorAll('.numeral-mask');

            // Verification masking
            if (numeralMask.length) {
                numeralMask.forEach(e => {
                    new Cleave(e, {
                        numeral: true
                    });
                });
            }
        })();
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
<script src="{{ asset('') }}assets/js/forms-extras.js"></script>
</body>
</html>

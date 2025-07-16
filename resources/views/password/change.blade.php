@extends('layouts.umkm')

@section('title', 'Ganti Password - ' . $umkm->name . ' - Banjarsugihan UMKM Digital Map')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <!-- Back Button -->
            <div class="mb-4">
                <a href="{{ route('umkm.dashboard', $umkm->slug) }}" class="btn btn-outline-secondary">
                    <i class="ri-arrow-left-line me-2"></i>
                    Kembali ke Dashboard
                </a>
            </div>

            <!-- Change Password Card -->
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <i class="ri-lock-password-line me-2 text-warning"></i>
                        <h5 class="mb-0">Ganti Password</h5>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Alert Messages -->
                    @if (session('success'))
                        <div class="alert alert-success d-flex align-items-center alert-dismissible" role="alert">
                            <i class="ri-checkbox-circle-line me-2"></i>
                            <div>{{ session('success') }}</div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger d-flex align-items-center alert-dismissible" role="alert">
                            <i class="ri-error-warning-line me-2"></i>
                            <div>{{ session('error') }}</div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- Change Password Form -->
                    <form method="POST" action="{{ route('umkm.password.update') }}">
                        @csrf
                        @method('PUT')

                        <!-- Current Password -->
                        <div class="mb-4">
                            <label for="current_password" class="form-label">
                                Password Lama <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <input type="password"
                                       class="form-control @error('current_password') is-invalid @enderror"
                                       id="current_password"
                                       name="current_password"
                                       placeholder="Masukkan password lama"
                                       required>
                                <button class="btn btn-outline-secondary"
                                        type="button"
                                        id="toggleCurrentPassword">
                                    <i class="ri-eye-line"></i>
                                </button>
                            </div>
                            @error('current_password')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <!-- New Password -->
                        <div class="mb-4">
                            <label for="new_password" class="form-label">
                                Password Baru <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <input type="password"
                                       class="form-control @error('new_password') is-invalid @enderror"
                                       id="new_password"
                                       name="new_password"
                                       placeholder="Masukkan password baru"
                                       required>
                                <button class="btn btn-outline-secondary"
                                        type="button"
                                        id="toggleNewPassword">
                                    <i class="ri-eye-line"></i>
                                </button>
                            </div>
                            @error('new_password')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                            @enderror
                            <div class="form-text">
                                <small class="text-muted">
                                    <i class="ri-information-line me-1"></i>
                                    Password minimal 6 karakter, boleh menggunakan huruf, angka, atau kombinasi
                                </small>
                            </div>
                        </div>

                        <!-- Confirm New Password -->
                        <div class="mb-4">
                            <label for="new_password_confirmation" class="form-label">
                                Konfirmasi Password Baru <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <input type="password"
                                       class="form-control @error('new_password_confirmation') is-invalid @enderror"
                                       id="new_password_confirmation"
                                       name="new_password_confirmation"
                                       placeholder="Konfirmasi password baru"
                                       required>
                                <button class="btn btn-outline-secondary"
                                        type="button"
                                        id="toggleConfirmPassword">
                                    <i class="ri-eye-line"></i>
                                </button>
                            </div>
                            @error('new_password_confirmation')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <!-- Password Strength Indicator -->
                        <div class="mb-4">
                            <div class="password-strength d-none">
                                <div class="d-flex align-items-center mb-2">
                                    <small class="text-muted me-2">Kekuatan Password:</small>
                                    <div class="progress flex-grow-1" style="height: 4px;">
                                        <div class="progress-bar" role="progressbar" style="width: 0%"></div>
                                    </div>
                                </div>
                                <small class="strength-text text-muted"></small>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-warning">
                                <i class="ri-lock-password-line me-2"></i>
                                Ganti Password
                            </button>
                        </div>
                    </form>

                    <!-- Forgot Password Link -->
                    <div class="text-center mt-4 pt-3 border-top">
                        <small class="text-muted">
                            Lupa password?
                            <a href="{{ route('password.forgot') }}" class="text-primary">
                                <i class="ri-question-line me-1"></i>
                                Klik disini
                            </a>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
    <style>
        .password-strength .progress-bar {
            transition: width 0.3s ease, background-color 0.3s ease;
        }

        .strength-weak .progress-bar {
            background-color: #dc3545;
        }

        .strength-medium .progress-bar {
            background-color: #ffc107;
        }

        .strength-strong .progress-bar {
            background-color: #198754;
        }

        .input-group button {
            border-left: none;
        }

        .input-group .form-control:focus + button {
            border-color: #86b7fe;
        }
    </style>
@endpush

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Password visibility toggle
            function togglePasswordVisibility(toggleBtn, passwordField) {
                const icon = toggleBtn.querySelector('i');
                if (passwordField.type === 'password') {
                    passwordField.type = 'text';
                    icon.className = 'ri-eye-off-line';
                } else {
                    passwordField.type = 'password';
                    icon.className = 'ri-eye-line';
                }
            }

            // Toggle buttons
            document.getElementById('toggleCurrentPassword').addEventListener('click', function() {
                togglePasswordVisibility(this, document.getElementById('current_password'));
            });

            document.getElementById('toggleNewPassword').addEventListener('click', function() {
                togglePasswordVisibility(this, document.getElementById('new_password'));
            });

            document.getElementById('toggleConfirmPassword').addEventListener('click', function() {
                togglePasswordVisibility(this, document.getElementById('new_password_confirmation'));
            });

            // Password strength checker
            const newPasswordField = document.getElementById('new_password');
            const strengthContainer = document.querySelector('.password-strength');
            const strengthBar = document.querySelector('.progress-bar');
            const strengthText = document.querySelector('.strength-text');

            newPasswordField.addEventListener('input', function() {
                const password = this.value;
                const strength = checkPasswordStrength(password);

                if (password.length > 0) {
                    strengthContainer.classList.remove('d-none');
                    updateStrengthIndicator(strength);
                } else {
                    strengthContainer.classList.add('d-none');
                }
            });

            function checkPasswordStrength(password) {
                let score = 0;
                let feedback = [];

                // Length check - lebih sederhana
                if (password.length >= 6) {
                    score += 50;
                } else {
                    feedback.push('minimal 6 karakter');
                }

                // Bonus for longer passwords
                if (password.length >= 8) score += 25;

                // Bonus for numbers or mixed characters
                if (/\d/.test(password) || /[A-Z]/.test(password)) {
                    score += 25;
                }

                return { score, feedback };
            }

            function updateStrengthIndicator(strength) {
                const { score, feedback } = strength;

                strengthBar.style.width = score + '%';
                strengthContainer.className = 'password-strength';

                if (score < 50) {
                    strengthContainer.classList.add('strength-weak');
                    strengthText.textContent = 'Terlalu pendek - ' + feedback.join(', ');
                    strengthText.className = 'strength-text text-danger';
                } else if (score < 75) {
                    strengthContainer.classList.add('strength-medium');
                    strengthText.textContent = 'Cukup baik' + (feedback.length ? ' - Saran: lebih panjang atau tambah angka' : '');
                    strengthText.className = 'strength-text text-warning';
                } else {
                    strengthContainer.classList.add('strength-strong');
                    strengthText.textContent = 'Password bagus!';
                    strengthText.className = 'strength-text text-success';
                }
            }
        });
    </script>
@endpush
